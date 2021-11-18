<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 站点模型
 */
namespace app\cms\model;

use think\Model;

class Site extends Model
{
	protected $createTime = 'inputtime';

    public function getSiteName($sites)
    {
        if ($sites) {
            return $this->where(array('id' => $sites))->value('name');
        } else{
            return '所有站';
        }
    }
}
