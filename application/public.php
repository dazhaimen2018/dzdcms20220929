<?php

//马博
function getSiteId()
{
    $siteId = 1;
    $domain = $_SERVER['HTTP_HOST'];
    $authDomain1 = "127.0.0.1";
    $authDomain2 = "localhost";
    $authDomain3 = "wxinw.com";
    if (strpos($domain, $authDomain1) === false && strpos($domain, $authDomain2) === false && strpos($domain, $authDomain3) === false) {
        die;
    }
    $site = [];
    $count = db('site')->where("domain='{$domain}'")->count();
    if ($count > 1) {
        $key = $domain . '_lang';
        $lang = Cache::get($key);
        if ($lang === false) {
            preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
            $lang = $matches[1];
            Cache::set($key, $lang);
        }
        $site = db('site')->where("mark='{$lang}' and domain='{$domain}'")->find();
    } else {
        $site = db('site')->where("domain='{$domain}'")->find();
    }

    if ($site) {
        $siteId = $site['id'];
    }
    return $siteId;
}

function setLang($lang)
{
    $domain = $_SERVER['HTTP_HOST'];
    $key = $domain . '_lang';
    Cache::clear();
    Cache::set($key, $lang);
}

//当前站点信息

function getSite($field)
{
    if (!$field) {
        return false;
    }
    $siteId = getSiteId();
    $key    = $siteId . '_site';
    $site = Cache::get($key);
    if ($site !== 'false') {
        $site = db('site')->find($siteId);
        Cache::set($key, $site);
    }
    if ($site) {
        return $site[$field];
    } else {
        return false;
    }
}

//通过ID获得当前站点名称
function getSiteName($id)
{
    if (!$id) {
        return false;
    }

    if ($id !== 'false') {
        $site = db('site')->find($id);
        if ($site) {
            return $site['name'];
        } else {
            return false;
        }
    } else {
        return false;
    }

}

//当前碎片信息
function patch($langName, $newCache = false)
{
    if (empty($langName)) {
        return false;
    }
    $siteId = getSiteId();
    $key = 'getLang_' . $langName . '_' . $siteId;
    //强制刷新缓存
    if ($newCache) {
        Cache::rm($key, null);
    }
    $cache = Cache::get($key);
    if ($cache === 'false') {
        return false;
    }
    if (empty($cache)) {
        $lang = db('lang')->where(['name' => $langName])->find();
        $langId = $lang['id'];
        $lang_data = db('lang_data')->where(['lang_id' => $langId, 'site_id' => $siteId])->find();
        $lang_value = $lang_data['value'];
        Cache::set($key, $lang_value, 3600);
    } else {
        $lang_value = Cache::get($key);
    }
    return $lang_value;
}

//获取信息
function getSiteInfo($field)
{
    if (!$field) {
        return false;
    }
    $siteId = cache("Cms_Config")['site'];
    $site = db('site')->where(['id' => $siteId])->find();
    if ($site) {
        return $site[$field];
    } else {
        return false;
    }
}

function siteName($id)
{
    $site = db('site')->where('id',$id)->value('mark');
    return  "<span class='text-danger'>$site</span>";
}