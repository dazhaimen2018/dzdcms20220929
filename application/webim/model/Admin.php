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
// | webim模型
// +----------------------------------------------------------------------
namespace app\webim\model;

use \think\Model;

/**
 * 模型
 */
class Admin extends Model
{

    public function webim_cache()
    {
        $data          = unserialize(model('admin/Module')->where(array('module' => 'webim'))->value('setting'));
        $data['sider'] = (isset($data['sider']) && $data['sider']) ? get_file_path($data['sider']) : [];
        cache("Webim_Config", $data);
        return $data;
    }
}
