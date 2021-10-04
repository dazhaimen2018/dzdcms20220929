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
// | 前台会员管理
// +----------------------------------------------------------------------
namespace app\member\controller;

use app\common\controller\Homebase;
use app\member\service\User;
use think\Loader;

class MemberBase extends HomeBase
{
    //会员模型相关配置
    protected $memberConfig = array();
    //会员组缓存
    protected $memberGroup = array();
    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];
    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = [];
    /**
     * 权限Auth
     * @var Auth
     */
    protected $auth = null;

    //初始化
    protected function initialize()
    {
        parent::initialize();
        $modulename         = $this->request->module();
        $controllername     = Loader::parseName($this->request->controller());
        $actionname         = strtolower($this->request->action());
        $this->memberConfig = cache("Member_Config");
        $this->memberGroup  = cache("Member_Group");
        $siteId             = getSiteId();
        $this->auth = User::instance();
        $token      = $this->request->server('HTTP_TOKEN', $this->request->request('token', \think\facade\Cookie::get('token')));
        $path       = str_replace('.', '/', $controllername) . '/' . $actionname;
        if (substr($this->request->module(), 0, 7) == 'public_' || !$this->auth->match($this->noNeedLogin)) {
            //初始化
            $this->auth->init($token);
            //检测是否登录
            if (!$this->auth->isLogin()) {
                $this->error('请登录后再操作', 'member/index/login');
            }
            // 判断是否需要验证权限
            /*if (!$this->auth->match($this->noNeedRight)) {

        }*/
        } else {
            // 如果有传递token才验证是否登录状态
            if ($token) {
                $this->auth->init($token);
            }
        }
        $this->assign('userlang', '111');
        $this->assign('userinfo', $this->auth->getUser());
        $this->assign("Member_group", $this->memberGroup);
        $this->assign("Member_config", $this->memberConfig);
        $this->view->assign('siteId', $siteId);
    }
}
