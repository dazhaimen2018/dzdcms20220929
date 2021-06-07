<?php
// +----------------------------------------------------------------------
// | TTmcms [ 天天互联 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://ttmcms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 马博 <8355763@qq.com>
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | 语言组管理
// +----------------------------------------------------------------------
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
        $file = $this->request->file('file');
        try {
            ModuleService::local($file);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('插件解压成功，可以进入插件管理进行安装！');
    }

}
