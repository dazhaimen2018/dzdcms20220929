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
// | 会员首页管理
// +----------------------------------------------------------------------
namespace app\member\controller;

use app\cms\model\Site;
use app\common\library\Ems;
use app\common\library\Sms;
use app\member\model\Authorized;
use app\member\model\Member as Member_Model;
use think\Db;
use think\facade\Cookie;
use think\facade\Hook;
use think\facade\Validate;

class Auth extends MemberBase
{
    protected $noNeedLogin = ['login', 'register', 'logout', 'forget'];

    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->Member_Model = new Member_Model;
        $auth = $this->auth;

        //监听注册登录退出的事件
        Hook::add('user_login_successed', function ($user) use ($auth) {
            $expire = $this->request->post('keeplogin') ? 30 * 86400 : 0;
            Cookie::set('uid', $user->id, $expire);
            Cookie::set('token', $auth->getToken(), $expire);
        });
        Hook::add('user_register_successed', function ($user) use ($auth) {
            Cookie::set('uid', $user->id);
            Cookie::set('token', $auth->getToken());
        });
        Hook::add('user_delete_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
        Hook::add('user_logout_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
    }

    /**
     * 授权证书
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 10);
            $page  = $this->request->param('page/d', 10);
            $type  = $this->request->param('type/s', "");
            $where = array('userid' => $this->auth->id);
            $total = Authorized::where($where)->count();
            $_list = Authorized::where($where)->page($page, $limit)->order(array("id" => "DESC"))->select();
            $result = array("code" => 0, "count" => $total, "data" => $_list);

            return json($result);
        }
        return $this->fetch('/auth');
    }

    /**
     * 申请授权
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //验证数据合法性
            $rule = [
                'domain|域名' => 'require|regex:^[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$|unique:authorized',
            ];
            $message  =   [
                'domain.unique' => '域名已经存',
                'domain.regex'   => '域名格式错误',
            ];
            $result = $this->validate($data, $rule, $message);
            if (true !== $result) {
                $this->error($result);
            }
            $userinfo = Member_Model::get($this->auth->id);
            if (empty($userinfo)) {
                $this->error(patch('MemberNo') );//该会员不存在
            }
            $data['userid']     = $this->auth->id;
            $data['catid']      = 1;
            $data['inputtime']  = request()->time();
            $data['updatetime'] = request()->time();
            $data['status'] = 0;
            if (!empty($data)) {
                //数据保存
                $status = Authorized::insert($data);
            }
            if ($status){
                return $this->success('申请成功、等待管理员审核！', url('index'));
            }
        } else {
            return $this->fetch('/apply');
        }

    }

}
