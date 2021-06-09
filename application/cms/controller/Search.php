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

use app\cms\model\SearchLog;
use app\common\controller\Adminbase;

use think\Db;

class Search extends Adminbase
{
	protected $modelClass = null;
	//初始化
	protected function initialize()
	{
		parent::initialize();
		$this->modelClass = new SearchLog();
	}
	/**
	 * 站点列表
	 */

	/**
	 * 站点添加
	 */
	public function add()
	{

	}

	/**
	 * 站点编辑
	 */
	public function edit()
	{

	}
	/**
	 * 站点删除
	 */
	public function del()
    {

    }

}
