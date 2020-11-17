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
// | 插件管理
// +----------------------------------------------------------------------
namespace app\addons\controller;

use app\common\controller\Adminbase;
use think\AddonService;
use think\Db;

class Addons extends Adminbase
{
    //显示插件列表
    public function index()
    {
        if ($this->request->isAjax()) {
            $addons = get_addon_list();
            $list   = [];
            foreach ($addons as $k => $v) {
                $config               = get_addon_config($v['name']);
                $addons[$k]['config'] = $config ? 1 : 0;

            }
            $result = array("code" => 0, "data" => $addons);
            return json($result);

            /*//取得模块目录名称
        $dirs = array_map('basename', glob(ADDON_PATH . '*', GLOB_ONLYDIR));
        if ($dirs === false || !file_exists(ADDON_PATH)) {
        $this->error = '插件目录不可读或者不存在';
        return false;
        }
        // 读取数据库插件表
        $addons = Addons_Model::order('id desc')->column(true, 'name');
        //遍历插件列表
        foreach ($dirs as $value) {
        //是否已经安装过
        if (!isset($addons[$value])) {
        $class = get_addon_class($value);
        if (!class_exists($class)) {
        // 实例化插件失败忽略执行
        unset($addons[$value]);
        //$addons[$value]['uninstall'] = -1;
        continue;
        }
        //获取插件配置
        $obj            = new $class();
        $addons[$value] = $obj->info;
        if ($addons[$value]) {
        $addons[$value]['uninstall'] = 1;
        unset($addons[$value]['status']);
        //是否有配置
        //$config = $obj->getAddonConfig();
        //$addons[$value]['config'] = $config;
        }
        }
        }
        int_to_string($addons, array('status' => array(-1 => '损坏', 0 => '禁用', 1 => '启用', null => '未安装')));
        $result = array("code" => 0, "data" => $addons);
        return json($result);*/
        }
        return $this->fetch();

    }

    //插件钩子列表
    public function hooks()
    {
        if ($this->request->isAjax()) {
            $list = Db::name("hooks")->select();
            int_to_string($list, array(
                'type' => [1 => '视图', 2 => '控制器'],
            ));
            $result = array("code" => 0, "data" => $list);
            return json($result);
        }
        return $this->fetch();
    }

    /**
     * 设置插件页面
     */
    public function config($name = null)
    {
        $name = $name ? $name : $this->request->get("name");
        if (!$name) {
            $this->error('参数不得为空！');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            $this->error('插件名称不正确！');
        }
        if (!is_dir(ADDON_PATH . $name)) {
            $this->error('目录不存在！');
        }
        $info   = get_addon_info($name);
        $config = get_addon_fullconfig($name);
        if (!$info) {
            $this->error('配置不存在！');
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("config/a", [], 'trim');
            if ($params) {
                foreach ($config as $k => &$v) {
                    if (isset($params[$v['name']])) {
                        if ($v['type'] == 'array') {
                            $params[$v['name']] = is_array($params[$v['name']]) ? $params[$v['name']] : (array) json_decode($params[$v['name']],
                                true);
                            $value = $params[$v['name']];
                        } else {
                            $value = is_array($params[$v['name']]) ? implode(',',
                                $params[$v['name']]) : $params[$v['name']];
                        }
                        $v['value'] = $value;
                    }
                }
                try {
                    //更新配置文件
                    set_addon_fullconfig($name, $config);
                    //AddonService::refresh();
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            }
            $this->success('插件配置成功！');
        }
        $this->assign('data', ['info' => $info, 'config' => $config]);
        $configFile = ADDON_PATH . $name . DIRECTORY_SEPARATOR . 'config.html';
        $viewFile   = is_file($configFile) ? $configFile : '';
        return $this->fetch($viewFile);
        /*$name = $name ? $name : $this->request->get("name");
    if (empty($addonId)) {
    $this->error('请选择需要操作的插件！');
    }
    //获取插件信息
    $addon = Addons_Model::where(array('id' => $addonId))->find();
    if (!$addon) {
    $this->error('该插件没有安装！');
    }
    $addon = $addon->toArray();
    //实例化插件入口类
    $addon_class = get_addon_class($addon['name']);
    if (!class_exists($addon_class)) {
    trace("插件{$addon['name']}无法实例化,", 'ADDONS', 'ERR');
    }

    $db_config = $addon['config'];
    //载入插件配置数组
    $addon['config'] = get_addon_fullconfig($addon['name']);
    if ($this->request->isPost()) {
    //保存插件设置
    $params = $this->request->param('config/a');
    foreach ($params as $k => $v) {
    if (isset($addon['config'][$k])) {
    if ($addon['config'][$k]['type'] == 'array') {
    $params[$k] = (array) json_decode($params[$k], true);
    }
    }
    }
    $flag = Db::name('Addons')->where(['id' => $addonId])->setField('config', json_encode($params));
    if ($flag !== false) {
    //更新插件缓存
    //$this->addons->addons_cache();
    $this->success('保存成功', url('index'));
    } else {
    $this->error('保存失败');
    }
    }
    if ($db_config) {
    $db_config = json_decode($db_config, true);
    foreach ($addon['config'] as $key => $value) {
    if ($value['type'] != 'group') {
    $addon['config'][$key]['value'] = isset($db_config[$key]) ? $db_config[$key] : '';
    } else {
    foreach ($value['options'] as $gourp => $options) {
    foreach ($options['options'] as $gkey => $value) {
    $addon['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
    }
    }
    }
    }
    }
    $this->assign('data', $addon);
    $configFile = ADDON_PATH . $addon['name'] . DS . 'config.html';
    if (is_file($configFile)) {
    $this->assign('custom_config', $this->view->fetch($configFile));
    }
    return $this->fetch();*/
    }

    /**
     * 禁用启用.
     */
    public function state()
    {
        $name   = $this->request->get('name');
        $action = $this->request->get('action');

        if (!$name) {
            $this->error('参数不得为空！');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            $this->error('插件名称不正确');
        }
        try {
            $action = $action == 'enable' ? $action : 'disable';
            //调用启用、禁用的方法
            AddonService::$action($name, true);
            //Cache::delete('__menu__');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('操作成功');
    }

    /**
     * 安装插件
     */
    public function install()
    {
        $name = $this->request->param('name');
        if (empty($name)) {
            $this->error('请选择需要安装的插件！');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            $this->error('插件标识错误！');
        }
        try {
            AddonService::install($name);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('插件安装成功！清除浏览器缓存和框架缓存后生效！');
    }

    /**
     * 卸载插件
     */
    public function uninstall()
    {
        $name = $this->request->param('name');
        if (empty($name)) {
            $this->error('请选择需要安装的插件！');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            $this->error('插件标识错误！');
        }
        try {
            AddonService::uninstall($name, true);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('插件卸载成功！清除浏览器缓存和框架缓存后生效！');
    }

    /**
     * 卸载插件
     */
    /*public function uninstall()
    {
    $addonId = $this->request->param('id/d');
    if (empty($addonId)) {
    $this->error('请选择需要卸载的插件！');
    }
    //获取插件信息
    $info  = Addons_Model::where(array('id' => $addonId))->find();
    $class = get_addon_class($info['name']);
    if (empty($info) || !class_exists($class)) {
    $this->error('该插件不存在！');
    }
    //插件标识
    $addonName = $info['name'];
    //检查插件是否安装
    if ($this->isInstall($addonName) == false) {
    $this->error('该插件未安装，无需卸载！');
    }
    //卸载插件
    $addonObj  = new $class();
    $uninstall = $addonObj->uninstall();
    if ($uninstall !== true) {
    if (method_exists($addonObj, 'getError')) {
    $this->error($addonObj->getError() ? $addonObj->getError() : '执行插件预卸载操作失败！');
    } else {
    $this->error('执行插件预卸载操作失败！');
    }
    }
    if (false !== Addons_Model::destroy($addonId)) {
    //删除插件后台菜单
    if (isset($info['has_adminlist']) && $info['has_adminlist']) {
    model('admin/Menu')->delAddonMenu($info);
    }
    // 移除插件基础资源目录
    $destAssetsDir = self::getDestAssetsDir($addonName);
    if (is_dir($destAssetsDir)) {
    \util\File::del_dir($destAssetsDir);
    }
    $hooks_update = model('admin/Hooks')->removeHooks($addonName);
    if ($hooks_update === false) {
    $this->error = '卸载插件所挂载的钩子数据失败！';
    }
    Cache::set('Hooks', null);
    $this->success('插件卸载成功！清除浏览器缓存和框架缓存后生效！', url('Addons/index'));
    } else {
    $this->error('插件卸载失败！');
    }
    }

    public function install()
    {
    $addonName = $this->request->param('addon_name');
    if (empty($addonName)) {
    $this->error('请选择需要安装的插件！');
    }
    //检查插件是否安装
    if ($this->isInstall($addonName)) {
    $this->error('该插件已经安装，无需重复安装！');
    }
    $class = get_addon_class($addonName);
    if (!class_exists($class)) {
    $this->error('获取插件对象出错！');
    }
    $addonObj = new $class();
    //获取插件信息
    $info = $addonObj->info;
    if (empty($info)) {
    $this->error('插件信息获取失败！');
    }
    //开始安装
    $install = $addonObj->install();
    if ($install !== true) {
    if (method_exists($addonObj, 'getError')) {
    $this->error($addonObj->getError() ?: '执行插件预安装操作失败！');
    } else {
    $this->error('执行插件预安装操作失败！');
    }
    }
    $info['config'] = json_encode($addonObj->getAddonConfig());
    //添加插件安装记录
    $res = Addons_Model::create($info, true);
    if (!$res) {
    $this->error('写入插件数据失败！');
    }
    // 复制静态资源
    $sourceAssetsDir = self::getSourceAssetsDir($addonName);
    $destAssetsDir   = self::getDestAssetsDir($addonName);
    if (is_dir($sourceAssetsDir)) {
    \util\File::copy_dir($sourceAssetsDir, $destAssetsDir);
    }
    //如果插件有自己的后台
    if (isset($info['has_adminlist']) && $info['has_adminlist']) {
    $admin_list = $addonObj->admin_list;
    //添加菜单
    model('admin/Menu')->addAddonMenu($info, $admin_list);
    }
    //更新插件行为实现
    $hooks_update = model('admin/Hooks')->updateHooks($addonName);
    if (!$hooks_update) {
    $this->where("name='{$addonName}'")->delete();
    $this->error('更新钩子处插件失败,请卸载后尝试重新安装！');
    }
    Cache::set('Hooks', null);
    $this->success('插件安装成功！清除浏览器缓存和框架缓存后生效！', url('Addons/index'));
    }*/

    //本地安装
    public function local()
    {
        if ($this->request->isPost()) {
            $files = $this->request->file('file');
            if ($files == null) {
                $this->error("请选择上传文件！");
            }
            if (strtolower(substr($files->getInfo('name'), -3, 3)) != 'zip') {
                $this->error("上传的文件格式有误！");
            }
            //插件名称
            $addonName = pathinfo($files->getInfo('name'));
            $addonName = $addonName['filename'];
            //检查插件目录是否存在
            if (file_exists(ADDON_PATH . $addonName)) {
                $this->error('该插件目录已经存在！');
            }

            //上传临时文件地址
            $filename = $files->getInfo('tmp_name');
            $zip      = new \util\PclZip($filename);
            $status   = $zip->extract(PCLZIP_OPT_PATH, ADDON_PATH . $addonName);
            if ($status) {
                $this->success('插件解压成功，可以进入插件管理进行安装！', url('index'));
            } else {
                $this->error('插件解压失败！');
            }
        }
    }
}
