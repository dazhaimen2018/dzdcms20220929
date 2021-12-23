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

class Special extends Validate
{
	//定义验证规则
	protected $rule = [
		'title|专题名称' => 'require|max:100',
        'diyname|专题标识' => 'require|max:100|unique:special|regex:/^[a-zA-Z][A-Za-z0-9\-\_]+$/',
        'template|专题模板' => 'require',
	];
}
