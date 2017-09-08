<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\Module as ModuleModel;
use think\Controller;
use app\common\controller\Adminbase;

class Module extends Adminbase
{

    //本地模块
    public function index()
    {
        $ModuleModel = new ModuleModel();
        $list = $ModuleModel->getAll();

        $this->assign("data", $list['modules']);
        return $this->fetch();
    }

    //模块安装
    public function install()
    {
    	if($this->request->isPost()){

    	}else{
    		//模块安装检查界面
    		return $this->fetch();

    	}

    }

}
