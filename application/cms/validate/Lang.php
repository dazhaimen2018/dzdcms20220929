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
// | 登录验证
// +----------------------------------------------------------------------
namespace app\cms\validate;

use think\Validate;

class Lang extends Validate
{
	//定义验证规则
	protected $rule = [
		'type|碎片类型' => 'require|alpha',
		'title|碎片标题' => 'require|chsAlphaNum',
		'name|碎片名称' => 'require|regex:^[a-zA-Z]\w{0,39}$|unique:lang',
		'value|碎片默认值' => 'require',
		'group|碎片分类' => 'require',
		'listorder|排序' => 'number',
	];
    protected $scene = [
        'push' => ['from', 'sites', 'status'],
    ];
}
