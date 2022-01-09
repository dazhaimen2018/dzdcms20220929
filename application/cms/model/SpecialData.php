<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 专题数据模型
 */
namespace app\cms\model;

use think\Model;

class SpecialData extends Model
{

    protected $autoWriteTimestamp = true;

    /**
     * 添加Spec内容
     */
    public function addSpec($specs, $id, $catid, $modelid, $sites, $title, $description, $thumb)
    {
        if (!$specs || !$id || !$catid || !$modelid) {
            return false;
        }
        if (is_array($specs)) {
            foreach ($specs as $v) {
                if (empty($v) || $v == '') {
                    continue;
                }
                self::create([
                    'specid'        => $v,
                    'did'           => $id,
                    "catid"         => $catid,
                    "modelid"       => $modelid,
                    "sites"         => $sites,
                    "title"         => $title,
                    "description"   => $description,
                    "thumb"         => $thumb,
                    "create_time"   => time(),
                ]);
            }
        }
    }

    /**
     * 根据指定的条件更新spec数据
     */
    public function updata($specs, $id, $catid, $modelid, $sites, $title, $description, $thumb)
    {
        if (!$specs || !$id || !$catid || !$modelid) {
            return false;
        }
        $tags = SpecialData::where([
            "modelid" => $modelid,
            "did"     => $id,
            "catid"   => $catid,
        ])->select();
        foreach ($tags as $key => $val) {
            if ($val) {
                SpecialData::where('id', $val['id'])->update(['thumb' => $thumb,'title'=>$title,'description'=>$description]);
            } else{
                continue;
            }
            //如果在新的关键字数组找不到，说明已经去除
            if (!in_array($val['specid'], $specs)) {
                //删除不存在的flag
                $this->deleteSpecId($val['specid'], $id, $catid, $modelid);
            } else {
                foreach ($specs as $k => $v) {
                    if ($val['specid'] == $v) {
                        unset($specs[$k]);
                    }
                }
            }
        }
        //新增的Flags
        if (count($specs) > 0) {
            $this->addSpec($specs, $id, $catid, $modelid, $sites, $title, $description, $thumb);
        }
    }

    /**
     * 删除spec
     */
    public function deleteSpecId($specs, $id, $catid, $modelid)
    {
        if (!$id || !$catid || !$modelid || !$specs) {
            return false;
        }
        if (is_array($specs)) {
            foreach ($specs as $name) {
                $row = $this->where("specid", $name)->find();
                if ($row) {
                    //删除tags数据
                    SpecialData::where(["specid" => $name, 'did' => $id, "catid" => $catid])->delete();
                }
            }
        } else {
            $row = $this->where("specid", $specs)->find();
            if ($row) {
                //删除spec数据
                SpecialData::where(["specid" => $row['specid'], 'did' => $id, "catid" => $catid])->delete();
            }
        }
        return true;
    }

    /**
     * 根据信息id删除全部的spec内容
     */
    public function deleteAll($id, $catid, $modelid)
    {
        if (!$id || !$catid || !$modelid) {
            return false;
        }
        $where = ['modelid' => $modelid, 'did' => $id, "catid" => $catid];
        //取得对应tag数据
        $tagslist = SpecialData::where($where)->select();
        if (empty($tagslist)) {
            return true;
        }
        //删除spec数据
        SpecialData::where($where)->delete();
        return true;
    }

}
