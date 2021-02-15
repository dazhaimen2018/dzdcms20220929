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
// | webim管理
// +----------------------------------------------------------------------
namespace app\webim\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $config = cache('Webim_Config');
        $this->assign('config', $config);
        return $this->fetch();
    }

    public function wap()
    {
        return $this->fetch();
    }
}
