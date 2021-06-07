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
// | 安装脚本
// +----------------------------------------------------------------------
namespace app\cms\install;

use think\Db;
use util\Sql;
use \sys\InstallBase;

class install extends InstallBase
{
    /**
     * 安装完回调
     * @return boolean
     */
    public function end()
    {
        //填充默认配置
        $Setting = include APP_PATH . 'cms/install/setting.php';
        if (!empty($Setting) && is_array($Setting)) {
            Db::name("Module")->where('module', 'cms')->setField('setting', serialize($Setting));
        }
        //安装演示数据
        if (request()->param('demo') == 1) {
            $sql_file = APP_PATH . "cms/install/demo.sql";
            if (file_exists($sql_file)) {
                $sql_statement = Sql::getSqlFromFile($sql_file);
                if (!empty($sql_statement)) {
                    foreach ($sql_statement as $value) {
                        try {
                            Db::execute($value);
                        } catch (\Exception $e) {
                            $this->error = '导入演示数据失败，请检查demo.sql的语句是否正确';
                            return false;
                        }
                    }
                }
                //给角色编辑增加权限并增加测试帐号
                Db::name('auth_group')->where(['id' => '2'])->setField('rules', '1,4,2,3,5,17,118,119,7,8,18,19,21,117,22,23,24,25,26,27,9,11,16,35,36,14,6,121,51,52,53,54,55,56,59,60,61,62,63,64,108,109,110,111,112,113,114,115,116,65,65,66,67,69,70,71,72,73,74,75,76,77,79,80,81,82,83,84,85,86,87,88,89,90,91,93,94,95,96,96,97,98,100,101,102,102,103,104,106,107,122,45,46,47,48,49,50,123,31,32,37,39,32,124,28,29,40,41,43,44,30');
                $data = ['username' => 'demo','email'=>'demo@admin.com','nickname'=>'demo', 'password' => '54ff86eaea1eb07b7a2b1f9242dc09d5','roleid'=>2,'site_id'=>0,'encrypt'=>'gMQ0c1','status'=>1];
                Db::name('admin')->insert($data);
            }
        }
        //复制路由
        $route_file = APP_PATH . str_replace("/", DIRECTORY_SEPARATOR, "cms/install/route_cms.php");
        copy($route_file, ROOT_PATH . 'route' . DIRECTORY_SEPARATOR . 'route_cms.php');
        return true;
    }

}
