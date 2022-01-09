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
// | Tag模型
// +----------------------------------------------------------------------
namespace app\cms\model;

use think\Model;

class FlagData extends Model
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
    public function addFlag($flags, $id, $catid, $modelid, $sites, $title, $thumb)
    {
        if (!$flags || !$id || !$catid || !$modelid) {
            return false;
        }
        $time    = time();
        $newdata = [];
        if (is_array($flags)) {
            foreach ($flags as $v) {
                if (empty($v) || $v == '') {
                    continue;
                }
                self::create([
                    'flagid'     => $v,
                    'did'     => $id,
                    "catid"   => $catid,
                    "modelid" => $modelid,
                    "sites"   => $sites,
                    "title"   => $title,
                    "thumb"   => $thumb,
                ]);
            }
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
    public function updata($flags, $id, $catid, $modelid, $sites, $title, $thumb)
    {
        if (!$flags || !$id || !$catid || !$modelid) {
            return false;
        }
        $tags = FlagData::where([
            "modelid" => $modelid,
            "did"     => $id,
            "catid"   => $catid,
        ])->select();
        foreach ($tags as $key => $val) {
            if (!$val) {
                continue;
            }
            //如果在新的关键字数组找不到，说明已经去除
            if (!in_array($val['flagid'], $flags)) {
                //删除不存在的tag
                $this->deleteFlagId($val['flagid'], $id, $catid, $modelid);
            } else {
                foreach ($flags as $k => $v) {
                    if ($val['flagid'] == $v) {
                        unset($flags[$k]);
                    }
                }
            }
        }
        //新增的tags
        if (count($flags) > 0) {
            $this->addFlag($flags, $id, $catid, $modelid, $sites, $title, $thumb);
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
    public function deleteFlagId($flags, $id, $catid, $modelid)
    {
        if (!$id || !$catid || !$modelid || !$flags) {
            return false;
        }
        if (is_array($flags)) {
            foreach ($flags as $name) {
                $row = $this->where("flagid", $name)->find();
                if ($row) {
                    //删除tags数据
                    FlagData::where(["flagid" => $name, 'did' => $id, "catid" => $catid])->delete();
                }
            }
        } else {
            $row = $this->where("flagid", $flags)->find();
            if ($row) {
                //删除tags数据
                FlagData::where(["flagid" => $row['flagid'], 'did' => $id, "catid" => $catid])->delete();
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
    public function deleteAll($id, $catid, $modelid)
    {
        if (!$id || !$catid || !$modelid) {
            return false;
        }
        $where = ['modelid' => $modelid, 'contentid' => $id, "catid" => $catid];
        //取得对应tag数据
        $tagslist = FlagData::where($where)->select();
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
        FlagData::where($where)->delete();
        return true;
    }

}
