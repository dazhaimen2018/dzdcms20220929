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

function onSite(){
    if (valid()){
        $siteId = '';
        $userInfo = Session::get('admin');
        if($userInfo){

            $adminId = $userInfo['sites'];
            if($adminId){
                $siteId =   $adminId;
            } else{
                $siteId = cache("Cms_Config")['site'];
            }
        }
    }else{
        $siteId  = 1;
    }
    return $siteId;
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


