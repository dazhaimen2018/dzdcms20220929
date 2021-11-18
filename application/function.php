<?php

// 加载授权函数
use think\facade\Cache;

include_once APP_PATH . 'cert.php';

function adminDomain(){
    $agent = agent();
    $grant = grant();
    if($grant['sign'] = $agent['sign'] && $grant['level'] = 3){
        $domain = $agent['domain'];
    } else {
        $domain = $grant['domain'];
    }
    return $domain;
}

function agents(){
    $agent = agent();
    $grant = grant();
    if($grant['sign'] = $agent['sign'] && $grant['level'] = 3){
        $agents['level'] = $agent['level'];
        $agents['sites'] = $agent['sites'];
        $agents['date']  = $agent['date'];
    } else {
        $agents['level'] = $grant['level'];
        $agents['sites'] = $grant['sites'];
        $agents['date']  = $grant['date'];
    }
    return $agents;
}

function tipsText(){
    return '需要授权,请联系技术';
}

function getSiteId()
{
    $key = 'siteInfo';
    $domain    = $_SERVER['HTTP_HOST'];
    $setDomain = isset(cache("Cms_Config")['domain']) ? cache("Cms_Config")['domain'] : 1;
    $header    =  preg_match('/^([a-z\-]+)/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches);
    $mark      = $matches[1]; // 获得header中的语言标识
    $siteInfo  = Cache::get($key);
    if ( $setDomain && $domain == $setDomain) {
        // 站点域名相同时，还得优化
        if($mark == $siteInfo['mark']){
            return $siteInfo['id'];
        }else{
            Cache::rm($key, null);
            $site = db('site')->where("mark='{$mark}' and domain='{$domain}'")->find();
            Cache::set($key, $site, 3600);
            return $site['id'];
        }

    }else{
        if($domain == $siteInfo['domain']){
            return $siteInfo['id'];
        } else {
            Cache::rm($key, null);
            $site      = db('site')->where("domain='{$domain}'")->find();
            if($site){
                Cache::set($key, $site, 3600);
                return $site['id'];
            } else {
                //域名未绑定站点，打开默认站点
                Cache::rm($key, null);
                $site      = db('site')->where("id=1")->find();
                Cache::set($key, $site, 3600);
                return 1;
            }

        }

    }

}

function valid(){
    return true; //需要授权时删除本行
    $domain = $_SERVER['HTTP_HOST'];
    if(empower()){
        return true;
    } elseif($domain == '127.0.0.1' || $domain == 'localhost') {
        return true;
    }else{
        return false;
    }
}

function empower(){
    $adminDomain = adminDomain();
    $domain = $_SERVER['HTTP_HOST'];
    if($adminDomain){
        if(strpos($domain,$adminDomain) !== false){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function onSite(){
    if (valid()){
        $userInfo = Session::get('admin');
        $adminId = $userInfo['site_id'];
        if($adminId){
            $siteId =   $adminId;
        } else{
            $siteId = cache("Cms_Config")['site'];
        }
    }else{
        $siteId  = 1;
    }
    return $siteId;
}

//当前站URL
function onSiteUrl(){
    $siteId  = onSite();
    $siteUrl = db('site')->where('id',$siteId)->cache(60)->value('url');
    return $siteUrl;
}

