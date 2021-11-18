<?php
/**
 * Yzncms
 * 版权所有 Yzncms，并保留所有权利。
 * Author: 御宅男 <530765310@qq.com>
 * Update: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * Tag模型
 */
namespace app\cms\model;

use think\Db;
use think\Model;

class Tags extends Model
{

    protected $autoWriteTimestamp = true;
    /**
     * 添加tags
     *
     * @param  type  $tagname  tags名称 可以是数组
     * @param  type  $id       信息id
     * @param  type  $catid    栏目Id
     * @param  type  $modelid  模型id
     *
     * @return false|void
     * @throws \think\Exception
     */
    public function addTag($tagname, $id, $catid, $modelid, $siteId)
    {
        if (!$tagname || !$id || !$catid || !$modelid) {
            return false;
        }
        $time    = time();
        $newdata = [];
        if (is_array($tagname)) {
            foreach ($tagname as $v) {
                if (empty($v) || $v == '') {
                    continue;
                }
                $row = $this->where("tag", $v)->find();
                if ($row) {
                    $row->setInc('usetimes');
                } else {
                    self::create([
                        "tag"      => $v,
                        "usetimes" => 1,
                        "site_id"  => $siteId,
                        "tagdir"   =>  $this->get_tagpinyin($v),
                    ]);
                }
                $newdata[] = [
                    'tag'        => $v,
                    "modelid"    => $modelid,
                    "contentid"  => $id,
                    "catid"      => $catid,
                    "updatetime" => $time,
                    "site_id"    => $siteId,
                ];
            }
            (new TagsContent())->saveAll($newdata);
        }
    }

    /**
     * 根据指定的条件更新tags数据
     *
     * @param  type  $tagname
     * @param  type  $id
     * @param  type  $catid
     * @param  type  $modelid
     *
     * @return false|void
     * @throws \think\Exception
     */
    public function updata($tagname, $id, $catid, $modelid, $siteId)
    {
        if (!$tagname || !$id || !$catid || !$modelid) {
            return false;
        }
        $tags = TagsContent::where([
            "modelid"   => $modelid,
            "contentid" => $id,
            "catid"     => $catid,
            "site_id"   => $siteId,
        ])->select();
        foreach ($tags as $key => $val) {
            if (!$val) {
                continue;
            }
            //如果在新的关键字数组找不到，说明已经去除
            if (!in_array($val['tag'], $tagname)) {
                //删除不存在的tag
                $this->deleteTagName($val['tag'], $id, $catid, $modelid, $siteId);
            } else {
                foreach ($tagname as $k => $v) {
                    if ($val['tag'] == $v) {
                        unset($tagname[$k]);
                    }
                }
            }
        }
        //新增的tags
        if (count($tagname) > 0) {
            $this->addTag($tagname, $id, $catid, $modelid, $siteId);
        }
    }

    /**
     * 删除tag
     *
     * @param  type  $tagname
     * @param  type  $id
     * @param  type  $catid
     * @param  type  $modelid
     *
     * @return bool
     * @throws \think\Exception
     */
    public function deleteTagName($tagname, $id, $catid, $modelid, $siteId)
    {
        if (!$id || !$catid || !$modelid || !$tagname) {
            return false;
        }
        if (is_array($tagname)) {
            foreach ($tagname as $name) {
                $row = $this->where("tag", $name)->find();
                if ($row) {
                    if ($row->usetimes > 0) {
                        $row->setDec('usetimes');
                    }
                    //删除tags数据
                    TagsContent::where(["tag" => $name, 'contentid' => $id, "catid" => $catid, 'site_id' => $siteId])->delete();
                }
            }
        } else {
            $row = $this->where("tag", $tagname)->find();
            if ($row) {
                if ($row->usetimes > 0) {
                    $row->setDec('usetimes');
                }
                //删除tags数据
                TagsContent::where(["tag" => $row['tag'], 'contentid' => $id, "catid" => $catid, 'site_id' => $siteId])->delete();
            }
        }
        return true;
    }

    /**
     * 根据信息id删除全部的tags记录
     *
     * @param  type  $id
     * @param  type  $catid
     * @param  type  $modelid
     *
     * @return boolean
     * @throws \think\Exception
     */
    public function deleteAll($id, $catid, $modelid, $siteId)
    {
        if (!$id || !$catid || !$modelid) {
            return false;
        }
        $where = ['modelid' => $modelid, 'contentid' => $id, "catid" => $catid, 'site_id' => $siteId];
        //取得对应tag数据
        $tagslist = TagsContent::where($where)->select();
        if (empty($tagslist)) {
            return true;
        }
        //全部-1
        foreach ($tagslist as $k => $value) {
            $row = $this->where("tag", $value['tag'])->find();
            if ($row && $row->usetimes > 0) {
                $row->setDec('usetimes');
            }
        }
        //删除tags数据
        TagsContent::where($where)->delete();
        return true;
    }

    //获取栏目的拼音  这个重复了，优化一下
    private function get_tagpinyin($catname = '', $tagdir = '', $id = 0)
    {
        $pinyin = new \Overtrue\Pinyin\Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        if (empty($tagdir)) {
            $tagdir = $pinyin->permalink($catname, '');
        }
        if (strval(intval($tagdir)) == strval($tagdir)) {
            $tagdir .= genRandomString(3);
        }
        $map = [
            ['tagdir', '=', $tagdir],
        ];
        if (intval($id) > 0) {
            $map[] = ['id', '<>', $id];
        }
        $result = Db::name('tags')->field('id')->where($map)->find();
        if (!empty($result)) {
            $nowDirname = $tagdir . genRandomString(3);
            return $this->get_tagpinyin($catname, $nowDirname, $id);
        }
        return $tagdir;
    }
}
