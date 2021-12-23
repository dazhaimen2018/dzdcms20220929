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
// | 模型验证
// +----------------------------------------------------------------------
namespace app\cms\validate;

use think\Validate;

class Models extends Validate
{
    //定义验证规则
    protected $rule = [
        'name|模型名称' => 'require|chs|max:30',
        //'name|模型名称' => 'require|chs|max:30|unique:model',
        'tablename|表键名' => 'require|lower|max:20|unique:model|alpha',
        'type|模型类型' => 'in:1,2,3',
    ];
}
