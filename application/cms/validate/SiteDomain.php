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

class SiteDomain extends Validate
{
	//定义验证规则
    protected $rule = [
        'domain|域名' => 'require|regex:/^[A-Za-z0-9][a-zA-Z][A-Za-z0-9\-\.]+$/|unique:site_domain',
    ];
}
