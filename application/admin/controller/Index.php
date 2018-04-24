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

use app\common\controller\Adminbase;

class Index extends Adminbase
{
    //后台首页
    public function index()
    {
        //后台菜单
        //$this->assign('__MENU__', model("common/Menu")->getMenuList());
        $this->assign("SUBMENU_CONFIG", json_encode(model("admin/Menu")->getMenuList()));
        return $this->fetch();
    }

}
