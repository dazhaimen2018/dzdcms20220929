<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fastadmin: https://www.fastadmin.net/
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 蜘蛛访问统计插件
// +----------------------------------------------------------------------
namespace addons\spider;

use addons\spider\library\Spider as SpiderLib;
use sys\Addons;
use think\Request;

class Spider extends Addons
{
    //安装
    public function install()
    {
        return true;
    }

    //卸载
    public function uninstall()
    {
        return true;
    }

    public function cmsSpider(Request $request, $data)
    {
        $SpiderLib = new SpiderLib();
        $agent     = strtolower($request->server('HTTP_USER_AGENT', ''));
        $spider    = $SpiderLib->get_spider($agent);
        if ($spider) {
            $title = (isset($data['title']) && !empty($data['title']) ? $data['title'] : '') . $data['site_title'];
            $SpiderLib->save_log($title);
        }

    }

}
