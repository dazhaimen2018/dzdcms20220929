<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * cms函数文件
 */

use app\cms\model\Site;
use think\facade\Cache;
use think\facade\Request;
//获得Tag的URL
function getTagDir($tag)
{
    $tagdir = db('tags')->where('tag',$tag)->value('tagdir');
    return  $tagdir;
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
        $lang       = db('lang')->where(['name' => $langName])->find();
        $langId     = $lang['id'];
        $lang_data  = db('lang_data')->where(['lang_id' => $langId, 'site_id' => $siteId])->find();
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

//获取站点信息 后台用
function getSiteInfo($field)
{
    if (!$field) {
        return false;
    }
    $siteId = onSite();
    $sites  = allSite();
    $site   = [];
    foreach ($sites as $v) {
        if ($v['id'] == $siteId) {
            $site[] = $v;
        }
    }
    if ($site) {
        return $site[0][$field];
    } else {
        return false;
    }
}

//前端站点信息，后台用 和 getSiteInfo重复待优化
function getSite($field)
{
    $key = 'siteInfo';
    if (!$field) {
        return false;
    }
    $siteInfo = Cache::get($key);
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
    $siteIds  = $userInfo['sites'];
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

//当前站URL
function onSiteUrl(){
    $siteId = onSite();
    $sites  = allSite();
    $site   = [];
    foreach ($sites as $v) {
        if ($v['id'] == $siteId) {
            $site[] = $v;
        }
    }
    return $site[0]['url'];
}

// 当前私有化值
function onPrivate() {
    $private = getSiteInfo('private');
    if ($private){
        $private = 1;
    } else {
        $private = 0;
    }
    return $private;
}

// 当前私有化站点ID值
function onSiteId() {
    $private = onPrivate();
    if($private){
        $siteId = onSite();
    } else {
        $siteId = 0;
    }
    return $siteId;
}

//数据调用时虚拟站点ID为默认站点ID
function dataSiteId(){
    $masterId = masterSite('id'); // 主站ID
    if (getSite('alone') == 1){
        $siteId = getSiteId();
    }else{
        $siteId = $masterId;
    }
    return $siteId;
}

//设置语言
function setLang($lang) {
    $domain = $_SERVER['HTTP_HOST'];
    $key = $domain . '_lang';
    Cache::clear();
    Cache::set($key, $lang);
}

//当前站ID
function getSiteId() {
    $key       = 'siteInfo';
    $domain    = $_SERVER['HTTP_HOST'];
    $setDomain = isset(cache("Cms_Config")['domain']) ? cache("Cms_Config")['domain'] : 1;
    $masterId  = masterSite('id'); // 主站ID
    $siteInfo  = Cache::get($key);
    $sites     = allSite();
    Cache::set('Site', $sites, 3600);
    if($siteInfo && $siteInfo['close'] == 0){
        Cookie::set('site_id','');
        Cookie::set('var','');
        Cache::set($key,'');
        return $masterId;
    }
    foreach ($sites as $key => $site){
        if ($site['domain'] != $domain){
            unset($sites[$key]);
        }
    }
    if (count($sites) <= 0){
        if ($setDomain){
            $site = Site::where('status',1)->where('domain',$setDomain)->find();
        }else{
            $site = Site::where('status',1)->find();
        }
        Cache::set($key,$site);
        return $site['id'];
    }else{
        if (count($sites)>1){
            if (Cookie::get('site_id') && !empty($sites[Cookie::get('site_id')])){
                if (!isset($siteInfo['id']) || $siteInfo['id'] != Cookie::get('site_id')){
                    Cache::set($key,$sites[Cookie::get('site_id')]);
                }
                return Cookie::get('site_id');
            }
        }
        $site = $sites[$masterId]?$sites[$masterId]:array_pop($sites);
        if (!isset($siteInfo['id']) || $siteInfo['id'] != $site['id']){
            Cache::set($key,$site);
        }
        return $site['id'];
    }

}
