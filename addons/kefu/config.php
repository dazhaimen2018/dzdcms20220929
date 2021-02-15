<?php
return [
    [
        'name'    => 'type',
        'title'   => '输出方式:',
        'type'    => 'radio',
        'options' => array(
            1 => 'js调用输出',
            2 => 'HTML生成输出',
        ),
        'value'   => 2,
        'tip'     => '“HTML生成输出”是直接把代码生成到输出到页面，“js调用输出”是在页面显示一个JS调用。',
    ],
    [
        'name'    => 'theme',
        'title'   => '主题:',
        'type'    => 'radio',
        'options' => [
            '1' => '样式一',
            '2' => '样式二',
            '3' => '样式三',
            '4' => '样式四',
            '5' => '样式五',
            '6' => '样式六',
        ],
        'value'   => '1',
    ],
    [
        'name'    => 'location',
        'title'   => '位置:',
        'type'    => 'radio',
        'options' => [
            'right' => 'right',
            'left'  => 'left',
        ],
        'value'   => 'right',
    ],
    [
        'name'  => 'qq',
        'title' => '客服QQ:',
        'type'  => 'textarea',
        'value' => '',
        'style' => "width:200px;",
        'tip'   => '格式：12346|小名，一行一个QQ号',
    ],
    [
        'name'  => 'phone',
        'title' => '手机号码:',
        'type'  => 'textarea',
        'value' => '',
        'style' => "width:200px;",
        'tip'   => '格式：13400000000|联系人，一行一个手机号码',
    ],
    [
        'name'  => 'url',
        'title' => '链接:',
        'type'  => 'text',
        'value' => '',
        'tip'   => '部分客服样式需要填写链接，如：在线留言链接',
    ],
    [
        'name'  => 'qrcode',
        'title' => '二维码:',
        'type'  => 'image',
        'value' => 0,
        'tip'   => '',
    ],
];
