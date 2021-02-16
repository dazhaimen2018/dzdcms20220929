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
// | 后台首页
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\service\User;
use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\facade\Cache;

class Index extends Adminbase
{
    protected $noNeedLogin = [
        'admin/index/login',
        'admin/index/logout',
    ];
    protected $noNeedRight = [
        'admin/index/index',
        'admin/index/cache',
    ];

    //后台首页
    public function index()
    {
        // 20200620 马博
        $siteArray = Site::where("status=1")->select()->toArray();
        $this->assign('siteArray', $siteArray);
        // 20200620 end 马博
        $this->assign("SUBMENU_CONFIG", json_encode(model("admin/Menu")->getMenuList()));
        return $this->fetch();
    }

    //登录判断
    public function login()
    {
        // 判断是否有登录权 20200617 马博
        $domain = $_SERVER['HTTP_HOST'];
        $authDomain = config('admin_domain');
        if ($authDomain) {
            if (strpos($domain, $authDomain) === false) {
                $this->error("地址错误", url('cms/index/index'));
            }
        }
        // 判断是否有登录权 end 20200617 马博
        $url = $this->request->get('url', 'index/index');
        if (User::instance()->isLogin()) {
            $this->redirect('admin/index/index');
        }
        if ($this->request->isPost()) {
            $data      = $this->request->post();
            $keeplogin = $this->request->post('keeplogin');
            // 验证数据
            $rule = [
                'verify|验证码'   => 'require|captcha',
                'username|用户名' => 'require|alphaDash|length:3,20',
                'password|密码'  => 'require|length:3,20',
                '__token__'    => 'require|token',
            ];
            $result = $this->validate($data, $rule);
            if (true !== $result) {
                $this->error($result, $url, ['token' => $this->request->token()]);
            }
            if (User::instance()->login($data['username'], $data['password'], $keeplogin ? 86400 : 0)) {
                $this->success('恭喜您，登陆成功', url('admin/Index/index'));
            } else {
                $msg = User::instance()->getError();
                $msg = $msg ? $msg : '用户名或者密码错误!';
                $this->error($msg, $url, ['token' => $this->request->token()]);
            }
        } else {
            if (User::instance()->autologin()) {
                $this->redirect('admin/index/index');
            }
            return $this->fetch();
        }

    }

    //手动退出登录
    public function logout()
    {
        if (User::instance()->logout()) {
            //手动登出时，清空forward
            //cookie("forward", NULL);
            $this->success('注销成功！', url("admin/index/login"));
        }
    }

    //缓存更新
    public function cache()
    {
        $type = $this->request->request("type");
        switch ($type) {
            case 'data' || 'all':
                \util\File::del_dir(ROOT_PATH . 'runtime' . DIRECTORY_SEPARATOR . 'cache');
                Cache::clear();
                if ($type == 'content') {
                    break;
                }

            case 'template' || 'all':
                \util\File::del_dir(ROOT_PATH . 'runtime' . DIRECTORY_SEPARATOR . 'temp');
                if ($type == 'template') {
                    break;
                }
        }
        $this->success('清理缓存');
    }

}
