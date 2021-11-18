<?php

/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 模板管理
 */

namespace app\cms\controller;

use app\common\controller\Adminbase;

use sys\ModuleService;
use think\Db;

class Template extends Adminbase
{
	protected $modelClass = null;
	//初始化
	protected function initialize()
	{
		parent::initialize();

	}
	/**
	 * 站点列表
	 */

    public function index()
    {
        if ($this->request->isAjax()) {
            $templates = get_template_list();
            $list   = [];
            foreach ($templates as $k => &$v) {
                $config      = get_addon_config($v['name']);
                $v['config'] = $config ? 1 : 0;
            }
            $result = array("code" => 0, "data" => $templates);
            return json($result);
        }
        return $this->fetch();

    }

    /**
     * 本地上传
     */
    public function local()
    {
        $this->success("离线安装模版正在开发吧，请手动上传！");
        $file = $this->request->file('file');
        try {
            ModuleService::local($file);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('插件解压成功，可以进入插件管理进行安装！');
    }

}
