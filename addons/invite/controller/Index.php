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
// | 会员推广管理
// +----------------------------------------------------------------------
namespace addons\invite\Controller;

use addons\invite\library\InviteCode;
use addons\invite\model\Invite;
use app\member\controller\MemberBase;
use think\facade\Cookie;

class Index extends MemberBase
{
    //无需登录的方法,同时也就不需要鉴权了
    protected $noNeedLogin = ['index'];

    //推广首页
    public function init()
    {
        $limit = $this->request->param('limit/d', 10);
        $page  = $this->request->param('page/d', 1);
        if ($this->request->isAjax()) {
            $count = Invite::where(['uid' => $this->userid])
                ->order('id DESC')
                ->count();

            $data = Invite::with('invited')
                ->where(['uid' => $this->userid])
                ->order('id DESC')
                ->page($page, $limit)
                ->select();
            $result = ["code" => 0, 'count' => $count, 'data' => $data];
            return json($result);
        } else {
            $config   = get_addon_config('invite');
            $userCode = InviteCode::encryptCode($this->userid);
            $this->assign('config', $config);
            $this->assign('userCode', $userCode);
            return $this->fetch();
        }

    }

    public function index()
    {
        $id = $this->request->param('userCode/s');
        if ($id) {
            Cookie::set("userCode", $id);
        }
        return $this->fetch();
    }
}
