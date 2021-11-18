<?php

/**
 * Yzncms
 * 版权所有 Yzncms，并保留所有权利。
 * Author: 御宅男 <530765310@qq.com>
 * Update: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * CMS设置
 */

namespace app\cms\controller;

use app\admin\model\Module as Module_Model;
use app\common\controller\Adminbase;
use app\cms\model\Site;

class Setting extends Adminbase
{
    //cms设置
    public function index()
    {
        if ($this->request->isPost()) {
            $setting         = $this->request->param('setting/a');
            $data['setting'] = serialize($setting);
            if (Module_Model::update($data, ['module' => 'cms'])) {
                cache('Cms_Config', null);
                $this->success("更新成功！");
            } else {
                $this->success("更新失败！");
            }
        } else {
            $setting = Module_Model::where('module', 'cms')->value("setting");
            $siteArray = Site::where(['alone' => 1])->select()->toArray();
            $this->assign('siteArray', $siteArray);
            $this->assign("setting", unserialize($setting));
            return $this->fetch();
        }
    }

    public function change(){
        $site = $this->request->request("type");
        $data['setting'] = Module_Model::where('module', 'cms')->value("setting");
        $setting = unserialize($data['setting']);
        if ($site){
            $setting['site'] = $site;
            $setting['publish_mode'] = 2;
        } else {
            $setting['site'] = 0;
            $setting['publish_mode'] = 1;
        }
        $data['setting'] = serialize($setting);
        if (Module_Model::update($data, ['module' => 'cms'])) {
            cache('Cms_Config', null);
            $this->success("切换成功！");
        } else {
            $this->success("切换失败！");
        }
    }

}
