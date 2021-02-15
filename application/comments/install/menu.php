<?php
return [
    [
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid"  => 4,
        //地址，[模块/]控制器/方法
        "route"     => "comments/comments/index1",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type"      => 0,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status"    => 1,
        //名称
        "name"      => "评论管理",
        //图标
        "icon"      => "icon-shiyongwendang",
        //备注
        "remark"    => "",
        //排序
        "listorder" => 4,
        //子菜单列表
        "child"     => [
            [
                "route"  => "comments/comments/config",
                "type"   => 1,
                "status" => 1,
                "name"   => "评论设置",
                "icon"   => "icon-setup",
                "child"  => [

                ],
            ],
            [
                "route"  => "comments/comments/index",
                "type"   => 1,
                "status" => 1,
                "name"   => "评论列表",
                "icon"   => "icon-createtask",
                "child"  => [

                ],
            ],
            [
                "route"  => "comments/comments/check",
                "type"   => 1,
                "status" => 1,
                "name"   => "评论审核",
                "icon"   => "icon-shenhe",
                "child"  => [

                ],
            ],
            [
                "route"  => "comments/emotion/index",
                "type"   => 1,
                "status" => 1,
                "name"   => "表情管理",
                "icon"   => "icon-smile",
                "child"  => [

                ],
            ],
        ],
    ],
];
