<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * cms函数文件
 */

use think\facade\Cache;
use think\facade\Request;
//获得Tag的URL
function getTagDir($tag)
{
    $tagdir = db('tags')->where('tag',$tag)->value('tagdir');
    return  $tagdir;
}

//设置语言
function setLang($lang)
{
    $domain = $_SERVER['HTTP_HOST'];
    $key = $domain . '_lang';
    Cache::clear();
    Cache::set($key, $lang);
}

//通过ID获得当前站点名称
function getSiteName($id)
{
    if (!$id) {
        return '所有站';
    }
    if ($id !== 'false') {
        return false;
    } else {
        return '所有站';
    }
}

//当前碎片信息
function patch($langName, $newCache = false)
{
    if (empty($langName)) {
        return false;
    }
    $siteId = getSiteId();
    $key    = 'getLang_' . $langName . '_' . $siteId;
    //强制刷新缓存
    if ($newCache) {
        Cache::rm($key, null);
    }
    $cache = Cache::get($key);
    if ($cache === 'false') {
        return false;
    }
    if (empty($cache)) {
        $lang       = db('lang')->where(['name' => $langName])->cache(60)->find();
        $langId     = $lang['id'];
        $lang_data  = db('lang_data')->where(['lang_id' => $langId, 'site_id' => $siteId])->cache(60)->find();
        if($lang_data){
            $lang_value = $lang_data['value'];
        }else{
            $lang_value = $lang['value'];
        }
        Cache::set($key, $lang_value, 3600);
    } else {
        $lang_value = Cache::get($key);
    }
    return $lang_value;
}

//获取站点信息
function getSiteInfo($field)
{
    if (!$field) {
        return false;
    }
    $siteId = onSite();
    $site   = db('site')->where(['id' => $siteId])->cache(60)->find();
    if ($site) {
        return $site[$field];
    } else {
        return false;
    }
}

//前端站点信息，后台用 和 getSiteInfo重复待优化
function getSite($field)
{
    if (!$field) {
        return false;
    }
    $siteInfo  = Cache::get('siteInfo');
    if ($siteInfo) {
        return $siteInfo[$field];
    } else {
        return false;
    }
}


// 立即清除缓存
function  cleanUp(){
    $cache =  \util\File::del_dir(ROOT_PATH . 'runtime' . DIRECTORY_SEPARATOR . 'cache');
    Cache::clear();
}

function onSiteName(){
    $userInfo = Session::get('admin');
    $siteIds = $userInfo['site_id'];
    if(isset(cache("Cms_Config")['publish_mode']) && 1 == cache("Cms_Config")['publish_mode']) {
        if($siteIds){
            $siteName = getSiteInfo('name');
        }else{
            $siteName = '所有站';
        }
    }else{
        $siteName = getSiteInfo('name');
    }
    return $siteName;
}

/**
 * 根据内容ID和栏目ID获得内容url
 */
function showsUrl($id,$catid){
    $url = '';
    return buildContentUrl($catid, $id, $url);
}
