<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * flag数据模型
 */
namespace app\cms\model;

use think\Model;

class FlagData extends Model
{

    protected $autoWriteTimestamp = true;

    /**
     * 添加flag内容
     */
    public function addFlag($flags, $id, $catid, $modelid, $sites, $title, $thumb)
    {
        if (!$flags || !$id || !$catid || !$modelid) {
            return false;
        }
        if (is_array($flags)) {
            foreach ($flags as $v) {
                if (empty($v) || $v == '') {
                    continue;
                }
                self::create([
                    'flagid'        => $v,
                    'did'           => $id,
                    "catid"         => $catid,
                    "modelid"       => $modelid,
                    "sites"         => $sites,
                    "title"         => $title,
                    "thumb"         => $thumb,
                    "create_time"   => time(),
                ]);
            }
        }
    }

    /**
     * 根据指定的条件更新flag数据
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
            if ($val) {
                FlagData::where('id', $val['id'])->update(['thumb' => $thumb,'title'=>$title]);
            } else{
                continue;
            }
            //如果在新的关键字数组找不到，说明已经去除
            if (!in_array($val['flagid'], $flags)) {
                //删除不存在的flag
                $this->deleteFlagId($val['flagid'], $id, $catid, $modelid);
            } else {
                foreach ($flags as $k => $v) {
                    if ($val['flagid'] == $v) {
                        unset($flags[$k]);
                    }
                }
            }
        }
        //新增的Flags
        if (count($flags) > 0) {
            $this->addFlag($flags, $id, $catid, $modelid, $sites, $title, $thumb);
        }
    }

    /**
     * 删除flag
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
                //删除flag数据
                FlagData::where(["flagid" => $row['flagid'], 'did' => $id, "catid" => $catid])->delete();
            }
        }
        return true;
    }

    /**
     * 根据信息id删除全部的flag内容
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
        //删除flag数据
        FlagData::where($where)->delete();
        return true;
    }

}
