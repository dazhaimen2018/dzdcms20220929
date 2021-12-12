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
// | 模型模型
// +----------------------------------------------------------------------
namespace app\cms\model;

use app\common\model\Modelbase;
use think\Db;
use think\facade\Config;
use \think\Model;

/**
 * 模型
 */
class Models extends Modelbase
{

    protected $name               = 'model';
    protected $ext_table          = '_data';
    protected $sub_table          = '_sub_data';
    protected $autoWriteTimestamp = true;

    /**
     * 创建模型
     * @param type $data 提交数据
     * @return boolean
     */
    public function addModel($data, $module = 'cms')
    {
        if (empty($data)) {
            throw new \Exception('数据不得为空！');
        }
        $data['module']  = $module;
        $data['setting'] = serialize($data['setting']);
        //添加模型记录
        if ($res = self::create($data)) {
            cache("Model", null);
            //创建模型表和模型字段
            if ($this->createTable($data)) {
                $this->addFieldRecord($res->id, $data['type']);
            }
        }
        //增加数据到push表中
        $push['module']       = $module;
        $push['modelid']      = $res->id;
        $push['tablename']    = $data['tablename'] . '_data';
        $push['name']         = $data['name'];
        $push['description']  = $data['description'];
        $res = Push::create($push);
        if($data['type']==3){
            $push['tablename']    = $data['tablename'] . '_sub_data';
            $push['name']         = $data['name']. '子表';
            $res = Push::create($push);
        }
    }

    /**
     * 编辑模型
     * @param type $data 提交数据
     * @return boolean
     */
    public function editModel($data, $modelid = 0)
    {
        if (empty($data)) {
            throw new \Exception('数据不得为空！');
        }
        //模型ID
        $modelid = $modelid ? $modelid : (int) $data['id'];
        if (!$modelid) {
            throw new \Exception('模型ID不能为空！');
        }
        //查询模型数据
        $info = self::where(array("id" => $modelid))->find();
        if (empty($info)) {
            throw new \Exception('该模型不存在！');
        }
        $data['modelid'] = $modelid;
        $data['setting'] = serialize($data['setting']);

        //是否更改表名
        if ($info['tablename'] != $data['tablename'] && !empty($data['tablename'])) {
            //检查新表名是否存在
            if ($this->table_exists($data['tablename']) || $this->table_exists($data['tablename'] . '_data') || $this->table_exists($data['tablename'] . '_sub_data')) {
                throw new \Exception('该表名已经存在！');
            }
            if (false !== $this->allowField(true)->save($data, array("modelid" => $modelid))) {
                //表前缀
                $dbPrefix = Config::get("database.prefix");
                //表名更改
                Db::execute("RENAME TABLE  `{$dbPrefix}{$info['tablename']}` TO  `{$dbPrefix}{$data['tablename']}` ;");
                //修改副表
                if ($info['type'] == 2) {
                    Db::execute("RENAME TABLE  `{$dbPrefix}{$info['tablename']}_data` TO  `{$dbPrefix}{$data['tablename']}_data` ;");
                }
                //修改副表子表
                if ($info['type'] == 3) {
                    Db::execute("RENAME TABLE  `{$dbPrefix}{$info['tablename']}_sub_data` TO  `{$dbPrefix}{$data['tablename']}_sub_data` ;");
                }
                //更新缓存
                cache("Model", null);
                return true;
            } else {
                throw new \Exception('模型更新失败！');
            }
        } else {
            if (false !== self::allowField(true)->save($data, array("modelid" => $modelid))) {
                //更新缓存
                cache("Model", null);
                return true;
            } else {
                throw new \Exception('模型更新失败！');
            }
        }
    }

    /**
     * 根据模型ID删除模型
     * @param type $id 模型id
     * @return boolean
     */
    public function deleteModel($id)
    {
        $modeldata = self::where("id", $id)->find();
        if (!$modeldata) {
            throw new \Exception('要删除的模型不存在！');
        }
        //删除模型数据
        self::destroy($id);
        //更新缓存
        cache("Model", null);
        //删除所有和这个模型相关的字段
        Db::name("ModelField")->where("modelid", $id)->delete();
        //删除推送表中相关数据
        Db::name("push")->where("modelid", $id)->delete();
        //删除主表
        $table_name = Config::get("database.prefix") . $modeldata['tablename'];
        Db::execute("DROP TABLE IF EXISTS `{$table_name}`");
        if ((int) $modeldata['type'] == 2) {
            //删除副表
            $table_name .= $this->ext_table;
            Db::execute("DROP TABLE IF EXISTS `{$table_name}`");
        }
        if ((int) $modeldata['type'] == 3) {
            //删除副表子表
            $table_name .= $this->sub_table;
            Db::execute("DROP TABLE IF EXISTS `{$table_name}`");
        }
        return true;
    }

    /**
     * 创建内容模型
     */
    protected function createTable($data)
    {
        $data['tablename'] = strtolower($data['tablename']);
        $table             = Config::get("database.prefix") . $data['tablename'];
        if ($this->table_exists($data['tablename'])) {
            throw new \Exception('创建失败！' . $table . '表已经存在~');
        }
        $sql = <<<EOF
                CREATE TABLE `{$table}` (
               `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
				`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
				 `catids` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '同步栏目',
				`theme` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '主题',				
				`url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转连接',				
				`diyurl` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '自定义URL',				
				`thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '封面图片',
				`flag` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性',	
                `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付类型',
                `readpoint` smallint(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付数量',
				`listorder` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
				`uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
				`username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
				`sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否后台添加',
                `hits` mediumint(8) UNSIGNED DEFAULT 0 COMMENT '点击量' ,
                `likes` mediumint(8) UNSIGNED DEFAULT 0 COMMENT '点赞数' ,
                `dislikes` mediumint(8) UNSIGNED DEFAULT 0 COMMENT '点踩数' ,
				`inputtime` int(10) unsigned NOT NULL DEFAULT '0'  COMMENT '创建时间',
				`updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
				`pushtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推送时间',
                `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '前台显示',
                `comment` tinyint(2) NOT NULL DEFAULT '0' COMMENT '允许评论',
                `groupids` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '访问权限',
				PRIMARY KEY (`id`),
                KEY `status` (`catid`,`status`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='{$data['name']}模型表';
EOF;

        $res = Db::execute($sql);
        if ($data['type'] == 2) {
            // 新建附属表
            $sql = <<<EOF
                CREATE TABLE `{$table}{$this->ext_table}` (
                `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自然ID',
				`did` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
				`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
				`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
				`tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
				`keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
				`description` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
				`content` mediumtext COLLATE utf8_unicode_ci COMMENT '内容',
				PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='{$data['name']}模型表';
EOF;
            $res = Db::execute($sql);
        }
        if ($data['type'] == 3) {
            // 新建附属表
            $sql = <<<EOF
                CREATE TABLE `{$table}{$this->ext_table}` (
               `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自然ID',
				`did` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
				`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
				`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
				`tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tags标签',
				`keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO关键词',
				`description` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO描述',
				`content` mediumtext COLLATE utf8_unicode_ci COMMENT '内容',
				PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='{$data['name']}模型表';
EOF;
            $res = Db::execute($sql);
            // 新建附属子表
            $sql = <<<EOF
                CREATE TABLE `{$table}{$this->sub_table}` (
                `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '自然ID',
				`did` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主表ID',
				`sid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '附表ID',
				`pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '同级ID',
				`site_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
				`catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
				`uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
                `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
				`chapter` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '章节标题',
				`image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '章节图片',
				`price` decimal(10,2) unsigned NOT NULL DEFAULT '0' COMMENT '付费阅读' ,
				`details` mediumtext COLLATE utf8_unicode_ci COMMENT '章节内容',
                `views` mediumint(8) UNSIGNED DEFAULT 0 COMMENT '浏览数量' ,
				`inputtime` int(10) unsigned NOT NULL DEFAULT '0'  COMMENT '创建时间',
				`updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
				`pushtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推送时间',
				`listorder` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
				`status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
				PRIMARY KEY (`id`),
                KEY `status` (`did`,`status`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='{$data['name']}模型表';
EOF;
            $res = Db::execute($sql);
        }
        return true;
    }

    /**
     * 添加默认字段
     */
    protected function addFieldRecord($modelid, $type)
    {
        $default = [
            'modelid'     => $modelid,
            'pattern'     => '',
            'errortips'   => '',
            'create_time' => request()->time(),
            'update_time' => request()->time(),
            'ifsystem'    => 1,
            'status'      => 1,
            'listorder'   => 100,
            'ifsearch'    => 0,
            'iffixed'     => 1,
            'remark'      => '',
            'isadd'       => 0,
            'iscore'      => 0,
            'ifrequire'   => 0,
        ];
        $data = [
            [
                'name'  => 'id',
                'title' => '文档id',
                'type'  => 'hidden',
                'isadd' => 1,
            ],
            [
                'name'  => 'catid',
                'title' => '栏目id',
                'type'  => 'hidden',
                'isadd' => 1,
            ],
            [
                'name'      => 'theme',
                'title'     => '主题',
                'type'      => 'text',
                'listorder' => 2,
                'ifsearch'  => 1,
                'ifrequire' => 1,
                'setting'   => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                'isadd'     => 1,
            ],
            [
                'name'    => 'catids',
                'title'   => '同步栏目',
                'type'    => 'selectpage',
                'listorder' => 3,
                'remark' => '同时发布在其他栏目中',
                'setting' => "a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:111:\"url:/admin/ajax/category\r\nfield:catname\r\nkey:id\r\npagination:true\r\npage_size:10\r\nmultiple:true\r\nmax:10\r\norder:id\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}",
            ],
            [
                'name'    => 'flag',
                'title'   => '属性',
                'type'    => 'checkbox',
                'listorder'=> 4,
                'ifrequire' => 0,
                'setting' => "a:3:{s:6:\"define\";s:31:\"varchar(32) NOT NULL DEFAULT ''\";s:7:\"options\";s:76:\"1:置顶[1]\r\n2:头条[2]\r\n3:特荐[3]\r\n4:推荐[4]\r\n5:热点[5]\r\n6:幻灯[6]\";s:5:\"value\";s:0:\"\";}",
            ],
            [
                'name'      => 'thumb',
                'title'     => '封面图片',
                'type'      => 'image',
                'listorder'   => 10,
                'ifrequire' => 0,
                'iffixed'   => 0,
                'setting'   => "a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                'isadd'     => 1,
            ],
            [
                'name' => 'url',
                'title' => '跳转连接',
                'type' => 'link',
                'listorder' => 11,
                'ifsearch' => 0,
                'ifrequire' => 0,
                'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                'isadd' => 1,
            ],
            [
                'name'    => 'diyurl',
                'title'   => '自己定义url',
                'type'    => 'dzd',
                'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
            ],
            [
                'name'      => 'inputtime',
                'title'     => '定时发布',
                'type'      => 'datetime',
                'listorder' => 12,
                'remark'    => '创建时间为未来时是定时发布！',
                'setting'   => "a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
            ],
            [
                'name'    => 'status',
                'title'   => '前台显示',
                'type'    => 'radio',
                'listorder' => 13,
                'setting' => "a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:18:\"0:隐藏\r\n1:显示\";s:5:\"value\";s:1:\"1\";}",
            ],
            [
                'name'    => 'listorder',
                'title'   => '排序',
                'type'    => 'dzd',
                'setting' => "a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}",
            ],
            [
                'name'   => 'uid',
                'title'  => '用户id',
                'type'   => 'number',
                'iscore' => 1,
            ],
            [
                'name'   => 'username',
                'title'  => '用户名',
                'type'   => 'text',
                'iscore' => 1,
            ],
            [
                'name'   => 'sysadd',
                'title'  => '是否后台添加',
                'type'   => 'number',
                'iscore' => 1,
            ],
            [
                'name'    => 'paytype',
                'title'   => '支付类型',
                'type'    => 'dzd',
                'setting' => "a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:18:\"0:积分\r\n1:金额\";s:5:\"value\";s:1:\"1\";}",
            ],
            [
                'name'    => 'readpoint',
                'title'   => '支付数量',
                'type'    => 'dzd',
                'setting'   => "a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}",
            ],
            [
                'name'      => 'hits',
                'title'     => '点击量',
                'type'      => 'dzd',
                'setting'   => "a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}",
            ],
            [
                'name'      => 'likes',
                'title'     => '点赞数',
                'type'      => 'dzd',
                'setting'   => "a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}",
            ],
            [
                'name'      => 'dislikes',
                'title'     => '点踩数',
                'type'      => 'dzd',
                'setting'   => "a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}",
            ],

            [
                'name'      => 'updatetime',
                'title'     => '更新时间',
                'type'      => 'datetime',
                'setting'   => "a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                'iscore'    => 1,
            ],
            [
                'name'      => 'pushtime',
                'title'     => '推送时间',
                'type'      => 'datetime',
                'setting'   => "a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                'iscore'    => 1,
            ],
            [
                'name'    => 'comment',
                'title'   => '允许评论',
                'type'    => 'radio',
                'listorder' => 20,
                'setting' => "a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:18:\"0:禁止\r\n1:允许\";s:5:\"value\";s:1:\"1\";}",
            ],
            [
                'name'    => 'groupids',
                'title'   => '访问权限',
                'type'    => 'selectpage',
                'listorder' => 21,
                'setting' => "a:4:{s:6:\"define\";s:21:\"varchar(255) NOT NULL\";s:7:\"options\";s:111:\"url:/admin/ajax/memberGroup\r\nfield:name\r\nkey:id\r\npagination:true\r\npage_size:10\r\nmultiple:true\r\nmax:10\r\norder:id\";s:10:\"filtertype\";s:1:\"0\";s:5:\"value\";s:0:\"\";}",
            ],

        ];
        if ($type == 2) {
            array_push($data, [
                'name' => 'id',
                'title' => '自然ID',
                'type' => 'hidden',
                'isadd' => 0,
                'ifsystem' => 0,
                ],
                [
                    'name' => 'did',
                    'title' => '附表文档id',
                    'type' => 'hidden',
                    'iscore' => 1,
                    'ifsystem' => 0,
                ],
                [
                    'name' => 'site_id',
                    'title' => '站点ID',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 0,
                ],
                [
                    'name' => 'title',
                    'title' => '标题',
                    'type' => 'text',
                    'listorder' => 1,
                    'ifsearch' => 1,
                    'ifrequire' => 1,
                    'ifsystem' => 0,
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'tags',
                    'title' => 'Tags标签',
                    'type' => 'tags',
                    'listorder' => 51,
                    'iffixed' => 0,
                    'ifsystem' => 0,
                    'remark' => '关键词用回车确认',
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'keywords',
                    'title' => 'SEO关键词',
                    'type' => 'tags',
                    'listorder' => 52,
                    'ifsystem' => 0,
                    'iffixed' => 0,
                    'remark' => '关键词用回车确认',
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'description',
                    'title' => 'SEO摘要',
                    'type' => 'textarea',
                    'listorder' => 53,
                    'ifsystem' => 0,
                    'iffixed' => 0,
                    'remark' => '如不填写，则自动截取附表中编辑器的200字符',
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'content',
                    'title' => '内容',
                    'type' => 'Ueditor',
                    'listorder' => 60,
                    'ifsystem' => 0,
                    'iffixed' => 0,
                    'ifrequire' => 1,
                    'setting' => "a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ]);

        };
        if ($type == 3) {
            array_push($data,[
                'name' => 'id',
                'title' => '自然ID',
                'type' => 'hidden',
                'isadd' => 0,
                'ifsystem' => 0,
                ],
                [
                    'name' => 'did',
                    'title' => '附表文档id',
                    'type' => 'hidden',
                    'iscore' => 1,
                    'ifsystem' => 0,
                ],
                [
                    'name' => 'site_id',
                    'title' => '站点ID',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 0,
                ],
                [
                    'name' => 'title',
                    'title' => '标题',
                    'type' => 'text',
                    'listorder' => 1,
                    'ifsearch' => 1,
                    'ifrequire' => 1,
                    'ifsystem' => 0,
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'tags',
                    'title' => 'Tags标签',
                    'type' => 'tags',
                    'listorder' => 51,
                    'iffixed' => 0,
                    'ifsystem' => 0,
                    'remark' => '关键词用回车确认',
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'keywords',
                    'title' => 'SEO关键词',
                    'type' => 'tags',
                    'listorder' => 52,
                    'ifsystem' => 0,
                    'iffixed' => 0,
                    'remark' => '关键词用回车确认',
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'description',
                    'title' => 'SEO摘要',
                    'type' => 'textarea',
                    'listorder' => 53,
                    'ifsystem' => 0,
                    'iffixed' => 0,
                    'remark' => '如不填写，则自动截取附表中编辑器的200字符',
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name' => 'content',
                    'title' => '内容',
                    'type' => 'Ueditor',
                    'listorder' => 60,
                    'ifsystem' => 0,
                    'iffixed' => 0,
                    'ifrequire' => 1,
                    'setting' => "a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                'name' => 'id',
                'title' => '子表自然ID',
                'type' => 'hidden',
                'isadd' => 0,
                'ifsystem' => 2,
                'listorder' => 301,
                ],
                [
                    'name' => 'did',
                    'title' => '主表id',
                    'type' => 'hidden',
                    'iscore' => 1,
                    'ifsystem' => 2,
                    'listorder' => 302,
                ],
                [
                    'name' => 'sid',
                    'title' => '附表id',
                    'type' => 'hidden',
                    'iscore' => 1,
                    'ifsystem' => 2,
                    'listorder' => 303,
                ],
                [
                    'name' => 'pid',
                    'title' => '同级Id',
                    'type' => 'hidden',
                    'iscore' => 1,
                    'ifsystem' => 2,
                    'listorder' => 304,
                ],
                [
                    'name' => 'site_id',
                    'title' => '站点ID',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 2,
                    'listorder' => 305,
                ],
                [
                    'name' => 'catid',
                    'title' => '栏目ID',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 2,
                    'listorder' => 306,
                ],
                [
                    'name' => 'chapter',
                    'title' => '章节标题',
                    'type' => 'text',
                    'listorder' => 307,
                    'ifrequire' => 1,
                    'ifsystem' => 2,
                    'setting' => "a:3:{s:6:\"define\";s:32:\"varchar(255) NOT NULL DEFAULT ''\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name'      => 'image',
                    'title'     => '章节图片',
                    'type'      => 'image',
                    'listorder'   => 308,
                    'ifrequire' => 0,
                    'ifsystem' => 2,
                    'setting'   => "a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd'     => 1,
                ],
                [
                    'name' => 'details',
                    'title' => '章节内容',
                    'type' => 'Ueditor',
                    'listorder' => 309,
                    'ifrequire' => 1,
                    'ifsystem' => 2,
                    'setting' => "a:3:{s:6:\"define\";s:13:\"text NOT NULL\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                    'isadd' => 1,
                ],
                [
                    'name'   => 'uid',
                    'title'  => '用户id',
                    'type'   => 'hidden',
                    'ifsystem' => 2,
                    'listorder'   => 310,
                ],
                [
                    'name'   => 'username',
                    'title'  => '用户名',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 2,
                    'listorder'   => 311,
                ],
                [
                    'name'      => 'inputtime',
                    'title'     => '创建时间',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 2,
                    'listorder' => 312,
                    'iscore'    => 1,
                    'setting'   => "a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                ],
                [
                    'name'      => 'updatetime',
                    'title'     => '更新时间',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 2,
                    'listorder' => 313,
                    'iscore'    => 1,
                    'setting'   => "a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                ],
                [
                    'name'      => 'pushtime',
                    'title'     => '推送时间',
                    'type' => 'hidden',
                    'isadd' => 1,
                    'ifsystem' => 2,
                    'listorder' => 314,
                    'iscore'    => 1,
                    'setting'   => "a:3:{s:6:\"define\";s:37:\"int(10) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:0:\"\";}",
                ],
                [
                    'name' => 'price',
                    'title' => '付费阅读',
                    'type' => 'number',
                    'ifsystem' => 2,
                    'listorder' => 315,
                    'setting'   => "a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}",
                ],
                [
                    'name'      => 'views',
                    'title'     => '浏览数量',
                    'type'      => 'number',
                    'ifsystem' => 2,
                    'listorder' => 316,
                    'setting'   => "a:3:{s:6:\"define\";s:42:\"mediumint(8) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:1:\"0\";}",
                ],
                [
                'name'    => 'listorder',
                    'title'   => '排序',
                    'type'    => 'number',
                    'listorder'   => 317,
                    'ifsystem' => 2,
                    'setting' => "a:3:{s:6:\"define\";s:40:\"tinyint(3) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:0:\"\";s:5:\"value\";s:3:\"100\";}",
                ],
                [
                    'name'    => 'status',
                    'title'   => '状态',
                    'type'    => 'radio',
                    'listorder'   => 318,
                    'ifsystem' => 2,
                    'setting' => "a:3:{s:6:\"define\";s:40:\"tinyint(2) UNSIGNED NOT NULL DEFAULT '0'\";s:7:\"options\";s:18:\"0:禁用\r\n1:启用\";s:5:\"value\";s:1:\"1\";}",
                ]);

        }
        foreach ($data as $item) {
            $item = array_merge($default, $item);
            Db::name('model_field')->insert($item);
        }
        return true;
    }

}
