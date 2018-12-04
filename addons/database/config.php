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
// | 插件配置
// +----------------------------------------------------------------------
return [
    'path' => [ //配置在表单中的键名 ,这个会是config[title]
        'title' => '数据库备份路径:', //表单的文字
        'type' => 'text', //表单的类型：text、textarea、checkbox、radio、select等
        'value' => '/Data/', //表单的默认值
        'style' => "width:200px;", //表单样式
        'tips' => '路径必须以 / 结尾',
    ],
    'part' => [
        'title' => '数据库备份卷大小:',
        'type' => 'text',
        'value' => '20971520',
        'style' => "width:200px;",
        'tips' => '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M',
    ],
    'compress' => [
        'title' => '是否启用压缩:',
        'type' => 'select',
        'options' => [
            '1' => '启用压缩',
            '0' => '不启用',
        ],
        'value' => '1',
        'tips' => '压缩备份文件需要PHP环境支持gzopen,gzwrite函数',
    ],
    'level' => [
        'title' => '压缩级别:',
        'type' => 'select',
        'options' => [
            '1' => '普通',
            '4' => '一般',
            '9' => '最高',
        ],
        'value' => '9',
        'tips' => '数据库备份文件的压缩级别，该配置在开启压缩时生效',
    ],
];
