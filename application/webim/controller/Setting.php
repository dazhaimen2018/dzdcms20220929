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

use app\admin\model\Module as Module_Model;
use app\common\controller\Adminbase;

class Setting extends Adminbase
{
    public function index()
    {
        if ($this->request->isPost()) {
            $setting         = $this->request->param('setting/a');
            $data['setting'] = serialize($setting);
            if (Module_Model::update($data, ['module' => 'webim'])) {
                //cache('Cms_Config', null);
                $this->success("更新成功！");
            } else {
                $this->success("更新失败！");
            }
        } else {
            $setting = Module_Model::where(['module' => 'webim'])->value("setting");
            $this->assign("setting", unserialize($setting));
            return $this->fetch();
        }
    }
}
