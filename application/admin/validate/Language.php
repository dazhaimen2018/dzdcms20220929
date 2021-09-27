<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\validate;

use \think\Validate;

/**
 * 用户组验证器
 */
class Language extends Validate
{
    //定义验证规则
    protected $rule = [
        'name' => 'require',

    ];

    //定义验证提示
    protected $message = [
        'name.require' => '语言名称不得为空',

    ];

    //定义验证场景
    protected $scene = [

    ];
}
