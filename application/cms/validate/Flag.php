<?php

/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 专题验证
 */
namespace app\cms\validate;

use think\Validate;

class Flag extends Validate
{
	//定义验证规则
	protected $rule = [
		'name|属性名称' => 'require|max:100',
	];
}
