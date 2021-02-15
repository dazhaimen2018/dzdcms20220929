<?php
return [
    [
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid"  => 4,
        //地址，[模块/]控制器/方法
        "route"     => "webim/admin/index",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type"      => 0,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status"    => 1,
        //名称
        "name"      => "即时通讯",
        //图标
        "icon"      => "icon-people",
        //备注
        "remark"    => "",
        //排序
        "listorder" => 0,
        //子菜单列表
        "child"     => [
            [
                "route"  => "webim/setting/index",
                "type"   => 1,
                "status" => 1,
                "name"   => "客服配置",
                "icon"   => "icon-setup",
                "child"  => [],
            ],
            [
                "route"  => "webim/admin/chat",
                "type"   => 1,
                "status" => 1,
                "name"   => "在线聊天",
                "icon"   => "icon-interactive",
                "child"  => [],
            ],
            [
                "route"  => "webim/admin/record",
                "type"   => 1,
                "status" => 0,
                "name"   => "聊天记录",
                "icon"   => "icon-shiyongwendang",
                "child"  => [],
            ],
            [
                "route"  => "webim/admin/deploy",
                "type"   => 1,
                "status" => 1,
                "name"   => "网页部署",
                "icon"   => "icon-zidongxiufu",
                "child"  => [],
            ],
        ],
    ],
];
