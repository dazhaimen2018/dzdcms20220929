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

class ModelField extends Validate
{
    //定义验证规则
    protected $rule = [
        'name'                => 'require|regex:/^[a-zA-Z][A-Za-z0-9\-\_]+$/',
        'title|字段标题'          => 'require|chsDash',
        'type|字段类型'           => 'require|alphaDash',
        'setting.define|字段定义' => 'require',
        'ifsystem|主表字段'       => 'in:0,1,2',
        'ifrequire|是否必填格'     => 'in:0,1',
        'ifsearch|是否显示搜索'     => 'in:0,1',
        'status|字段状态'         => 'in:0,1',
    ];
    //定义验证提示
    protected $message = [
        'name.require' => '字段名称不得为空',
        'name.regex'   => '字段名称只能为字母、数字和下划线_及破折号-，并且仅能字母开头',
    ];
}
