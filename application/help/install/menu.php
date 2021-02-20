<?php
return [
    [
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid"  => 0,
        //地址，[模块/]控制器/方法
        "route"     => "help/help/index",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type"      => 0,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status"    => 1,
        //名称
        "name"      => "帮助",
        //图标
        "icon"      => "icon-feedback",
        //备注
        "remark"    => "",
        //排序
        "listorder" => 10,
        //子菜单列表
        "child"     => [
            [
                "route"  => "help/help/helps",
                "type"   => 1,
                "status" => 1,
                "name"   => "帮助内容",
                "icon"   => "icon-draft-line",
                "child"  => [
                    [
                        "route"  => "help/cms/index",
                        "type"   => 1,
                        "status" => 0,
                        "name"   => "管理内容",
                        "icon"   => "icon-draft-line",
                        "child"  => [
                            [
                                "route"  => "help/cms/panl",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "面板",
                            ],
                            [
                                "route"  => "help/cms/public_helps",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "栏目列表",
                            ],
                            [
                                "route"  => "help/cms/classlist",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "信息列表",
                            ],
                            [
                                "route"  => "help/cms/add",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "添加",
                            ],
                            [
                                "route"  => "help/cms/edit",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "编辑",
                            ],
                            [
                                "route"  => "help/cms/read",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "阅读",
                            ],
                            [
                                "route"  => "help/cms/del",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "删除",
                            ],
                            [
                                "route"  => "help/cms/listorder",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "排序",
                            ],
                            [
                                "route"  => "help/cms/remove",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "批量移动",
                            ],
                            [
                                "route"  => "help/cms/setstate",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "状态",
                            ],
                            [
                                "route"  => "help/cms/check_title",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "标题检查",
                            ],
                            [
                                "route"  => "help/cms/recycle",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "回收站",
                                "icon"   => "icon-trash",
                            ],
                        ],
                    ],

                ],
            ],
            [
                "route"  => "help/help/index",
                "type"   => 1,
                "status" => 1,
                "name"   => "相关设置",
                "icon"   => "icon-file-settings-line",
                "child"  => [

                    [
                        "route"  => "help/help/index",
                        "type"   => 1,
                        "status" => 1,
                        "name"   => "栏目列表",
                        "icon"   => "icon-other",
                        "child"  => [
                            [
                                "route"  => "help/help/add",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "添加栏目",
                            ],
                            [
                                "route"  => "help/help/wadd",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "添加外部链接",
                            ],
                            [
                                "route"  => "help/help/edit",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "编辑栏目",
                            ],
                            [
                                "route"  => "help/help/del",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "删除栏目",
                            ],
                            [
                                "route"  => "help/help/multi",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "批量更新",
                            ],
                        ],
                    ],
                    [
                        "route"  => "help/models/index",
                        "type"   => 1,
                        "status" => 1,
                        "name"   => "模型管理",
                        "icon"   => "icon-apartment",
                        "child"  => [
                            [
                                "route"  => "help/field/index",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段管理",
                            ],
                            [
                                "route"  => "help/field/add",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段添加",
                            ],
                            [
                                "route"  => "help/field/edit",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段编辑",
                            ],
                            [
                                "route"  => "help/field/del",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段删除",
                            ],
                            [
                                "route"  => "help/field/listorder",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段排序",
                            ],
                            [
                                "route"  => "help/field/setstate",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段状态",
                            ],
                            [
                                "route"  => "help/field/setsearch",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段搜索",
                            ],
                            [
                                "route"  => "help/field/setvisible",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段隐藏",
                            ],
                            [
                                "route"  => "help/field/setrequire",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "字段必须",
                            ],

                            [
                                "route"  => "help/models/add",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "添加模型",
                            ],
                            [
                                "route"  => "help/models/edit",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "修改模型",
                            ],
                            [
                                "route"  => "help/models/del",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "删除模型",
                            ],
                            [
                                "route"  => "help/models/setSub",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "模型投稿",
                            ],
                            [
                                "route"  => "help/models/setstate",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "设置模型状态",
                            ],
                            [
                                "route"  => "help/models/multi",
                                "type"   => 1,
                                "status" => 0,
                                "name"   => "批量更新",
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];