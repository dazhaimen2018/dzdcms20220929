<?php

/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * cms搜索
 */

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
}
