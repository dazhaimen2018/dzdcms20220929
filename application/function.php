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

//后台用当前站点
function onSite(){
    if (valid()){
        $siteId = 0;
        $userInfo = Session::get('admin');
        if($userInfo){
            $adminId = $userInfo['sites'];
            if($adminId){
                $siteId = $adminId;
            } else {
                if(cache("Cms_Config")){
                    $siteId = cache("Cms_Config")['site'];
                } else {
                    $siteId = masterSite('id'); //主站
                }
            }
        }
    }else{
        $siteId  = masterSite('id'); //主站
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

//所有站点
function allSite() {
    $sites = cache('Site');
    if(!is_array($sites) || empty($sites)){
        Cache::set('Site',null);
        $sites = Db('site')->where('status',1)->column('*','id');
        Cache::set('Site', $sites, 3600);
    }
    return $sites;
}

//默认数据源站信息
function masterSite($field) {
    //输出所有站点
    $sites = allSite();
    $site  = [];
    foreach ($sites as $v) {
        if ($v['master'] == 1) {
            $site[] = $v;
        }
    }
    return $site[0][$field];
}

function getTableList($fieldList = [])
{
    $htmlstr = "";
    foreach ($fieldList as $k => $v) {
        if ($v['type'] == "datetime") {
            $htmlstr .= "{ field: '" . $v['name'] . "',title: '" . $v['title'] . "',templet: function(d){ return layui.formatDateTime(d." . $v['name'] . ") } },\n";
        }if ($v['type'] == "image") {
            $htmlstr .= "{ field: '" . $v['name'] . "',title: '" . $v['title'] . "',templet: yznTable.formatter.image },\n";
        } elseif ($v['type'] != "images" && $v['type'] != "files") {
            $htmlstr .= "{ field: '" . $v['name'] . "', align: 'left',title: '" . $v['title'] . "' },\n";
        }
    }
    return $htmlstr;
}


