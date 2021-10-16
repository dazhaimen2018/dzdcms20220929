<?php
// +----------------------------------------------------------------------
// | TTcms [ 天天互联 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://ttcms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 马博 <8355763@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Language模型
// +----------------------------------------------------------------------
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
