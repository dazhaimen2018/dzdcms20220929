<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 后台欢迎页
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;

class Main extends Adminbase
{
    protected $noNeedRight = ['admin/main/index'];
    //欢迎首页
    public function index()
    {
        if (IS_ROOT && $this->auth->password == encrypt_password('admin', $this->auth->encrypt)) {
            $this->assign('default_pass', 1);
        }
        $this->assign('sys_info', $this->get_sys_info());
        return $this->fetch();
    }

    //phpinfo信息 按需显示在前台
    public function get_sys_info()
    {
        //$sys_info['os'] = PHP_OS; //操作系统
        $sys_info['ip']           = GetHostByName($_SERVER['SERVER_NAME']); //服务器IP
        $sys_info['web_server']   = $_SERVER['SERVER_SOFTWARE']; //服务器环境
        $sys_info['phpv']         = phpversion(); //php版本
        $sys_info['fileupload']   = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknown'; //文件上传限制
        $sys_info['memory_limit'] = ini_get('memory_limit'); //最大占用内存
        $sys_info['domain']          = $_SERVER['HTTP_HOST']; //域名
        $sys_info['remaining_space'] = round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M'; //剩余空间
        //$sys_info['user_ip'] = $_SERVER['REMOTE_ADDR']; //用户IP地址
        $sys_info['beijing_time'] = gmdate("Y年n月j日 H:i:s", time() + 8 * 3600); //北京时间
        $sys_info['time']         = date("Y年n月j日 H:i:s"); //服务器时间
        //$sys_info['web_directory'] = $_SERVER["DOCUMENT_ROOT"]; //网站目录
        $mysqlinfo                 = Db::query("SELECT VERSION() as version");
        $sys_info['mysql_version'] = $mysqlinfo[0]['version'];
        if (function_exists("gd_info")) {
            //GD库版本
            $gd                 = gd_info();
            $sys_info['gdinfo'] = $gd['GD Version'];
        } else {
            $sys_info['gdinfo'] = "未知";
        }
        // 新增
        if(isModuleInstall('cms')){
            if(empower()){
                $sys_info['state'] = 1;
            }else{
                $sys_info['state'] = 0;
            }
            $sys_info['sites'] = Db::name('site')->where('status', 1)->cache(60)->count();
        }else{
            $sys_info['state'] = -1;
            $sys_info['site']  = 0;
        }
        $role_id  = $this->auth->roleid;
        $site     = $this->auth->sites;
        $sys_info['group'] = Db::name('auth_group')->where('id', $role_id)->cache(60)->value('title');
        if ($site){
            $sys_info['site'] = Db::name('site')->where('id', $site)->cache(60)->value('name');
        }else{
            $sys_info['site'] = '所有站';
        }
        $sys_info['adminlog'] = Db::name('adminlog')->count();
        $sys_info['model'] = Db::name('model')->where('status', 1)->cache(60)->count();
        $sys_info['admin'] = Db::name('admin')->where('status', 1)->cache(60)->count();

        return $sys_info;
    }

}
