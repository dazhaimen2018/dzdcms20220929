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
// | 单页模型
// +----------------------------------------------------------------------

namespace app\cms\model;

use think\Model;

/**
 * 模型
 */

class Page extends Model
{
    protected $pk                 = 'catid';
    protected $autoWriteTimestamp = true;
    protected $createTime         = 'inputtime';
    protected $updateTime         = 'updatetime';
  
    protected function setInputTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }
	/**
	 * 根据栏目ID获取内容
	 * @param type $catid 栏目ID
	 * @return boolean
	 */
	public function getPage($catid, $cache = false, $siteId = 0)
	{
        if (getSite('alone')==1){
            $siteId = getSiteId();
        }else{
            $siteId = 1;
        }
		if (empty($catid)) {
			return false;
		}
		if ($siteId == 0) {
			$list = self::get($catid, 10);
		} else {
			$list = self::where("catid=" . $catid . " and site_id=" . $siteId)->find();
		}
		return $list;
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
	 * @param type $post 表单数据
	 * @return boolean
	 */
	public function savePage($data)
	{
		if (empty($data)) {
			$this->error = '内容不能为空！';
			return false;
		}
		$catid = $data['catid'];
        $row = self::get($catid);
		if ($row) {
			//更新
			self::update($data, [], true);
			return true;
		} else {
			//新增
			self::create($data, true);
			return true;
		}
		$this->error = '操作失败！';
		return false;
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
