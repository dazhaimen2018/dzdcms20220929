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
// | help函数文件
// +----------------------------------------------------------------------
use think\facade\Cache;
use think\facade\Request;
// 帮助模块获取帮助数据
function getHelp($cat, $fields = '', $newCache = false)
{
    $url_mode = isset(cache("Cms_Config")['site_url_mode']) ? cache("Cms_Config")['site_url_mode'] : 1;
    if (empty($cat)) {
        return false;
    }
    $field = is_numeric($cat) ? 'id' : 'catdir';
    $key   = 'getHelp_' . $cat;
    //强制刷新缓存
    if ($newCache) {
        Cache::rm($key, null);
    }
    $cache = Cache::get($key);
    if ($cache === 'false') {
        return false;
    }
    if (empty($cache)) {
        //读取数据
        $cache = db('help')->where($field, $cat)->find();
        if (empty($cache)) {
            Cache::set($key, 'false', 60);
            return false;
        } else {
            //扩展配置
            $field            = 1 == $url_mode ? 'id' : 'catdir';
            $cache['setting'] = unserialize($cache['setting']);
            $cache['url']     = buildCatUrl($cache[$field], $cache['url']);
            $cache['image']   = empty($cache['image']) ? '' : get_file_path($cache['image']);
            $cache['icon']    = empty($cache['icon']) ? '' : get_file_path($cache['icon']);
            Cache::set($key, $cache, 3600);
        }
    }
    if ($fields) {
        //支持var.property，不过只支持一维数组
        if (false !== strpos($fields, '.')) {
            $vars = explode('.', $fields);
            return $cache[$vars[0]][$vars[1]];
        } else {
            return $cache[$fields];
        }
    } else {
        return $cache;
    }
}
