<?php
/**
 * Yzncms
 * 版权所有 Yzncms，并保留所有权利。
 * Author: 御宅男 <530765310@qq.com>
 * Update: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 单页模型
 */
namespace app\cms\model;

use think\Model;

class Page extends Model
{

    protected $pk = 'catid';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'inputtime';
    protected $updateTime = 'updatetime';

    protected function setInputTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    /**
     * 根据栏目ID获取内容
     * @param  type  $catid  栏目ID
     * @return boolean
     */
    public function getPage($catid, $cache = false, $site_id = 1)
    {
        $siteId = dataSiteId(); //数据调用时虚拟站点ID为默认站点ID
        if (empty($catid)) {
            return false;
        }
        if (is_numeric($cache)) {
            $cache = (int) $cache;
        }
        $list = self::where("catid=" . $catid . " and site_id=" . $siteId)->find();
        return $list;

        //return self::get($catid, $cache, $siteId);
    }

    public function selectAll($catid, $cache = false)
    {
        if (empty($catid)) {
            return false;
        }
        $list = self::where(['catid' => $catid])->select()->toArray();
        return $list;
    }

    /**
     * 更新单页内容
     * @param $data
     * @return boolean
     */
    public function savePage($data)
    {
        if (empty($data)) {
            $this->error = '内容不能为空！';
            return false;
        }
        $catid = $data['catid'];
        $row   = self::get($catid);
        if ($row) {
            //更新
            self::update($data, [], true);
        } else {
            //新增
            self::create($data, true);
        }
        return true;
    }

    public function saveData($data)
    {
        if (empty($data)) {
            $this->error = '内容不能为空！';
            return false;
        }
        if ($data['extra_data']) {
            foreach ($data['extra_data'] as $e) {
                if (!empty($e['title'])) {
                    if (!empty($e['id']) && $e['id']) {
                        $e['inputtime']  = strtotime($e['inputtime']);
                        $e['updatetime'] = time();
                        self::where(['id' => $e['id']])->update($e);
                    } else {
                        self::create($e);
                    }
                }
            }
        }
        return true;
    }
}
