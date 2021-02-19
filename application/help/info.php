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
// | cms模块信息文件
// +----------------------------------------------------------------------
return array(
    //模块名称[必填]
    'name'        => '帮助模块',
    //模块简介[选填]
    'introduce'   => '这是一个功能强大的后台帮助内容管理模块！',
    //模块作者[选填]
    'author'      => 'dzdcms',
    //作者地址[选填]
    'authorsite'  => 'http://www.dzdcms.com',
    //作者邮箱[选填]
    'authoremail' => '8355763@qq.com',
    //版本号，请不要带除数字外的其他字符[必填]
    'version'     => '1.0.0',
    //适配最低yzncms版本[必填]
    'adaptation'  => '1.0.0',
    //签名[必填]
    'sign'        => 'b19cc279ed484c13c96c2f7142e2f437',
    //依赖模块
    'need_module' => [],
    //依赖插件
    'need_plugin' => [],
    //缓存，格式：缓存key=>array('module','model','action')
    'cache'       => [],
    // 数据表，不要加表前缀[有数据库表时必填]
    'tables'      => [
        'help',
        'help_priv',
    ],
);
