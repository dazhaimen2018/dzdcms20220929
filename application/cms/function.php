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
// | cms函数文件
// +----------------------------------------------------------------------
use think\facade\Cache;
use think\facade\Request;

function getCategory($cat, $fields = '', $newCache = false)
{
    if (empty($cat)) {
        return false;
    }
    //马博
    $siteId = getSiteId();
    $field = is_numeric($cat) ? 'id' : 'catdir';
    $key = 'getCategory_' . $siteId . '_' . $cat;
    //马博 end

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
        $cache = db('category')->where($field, $cat)->find();
        if (empty($cache)) {
            Cache::set($key, 'false', 60);
            return false;
        } else {
            //马博
            $category_data = db('category_data')->where(['catid' => $cache['id'], 'site_id' => $siteId])->find();
            if ($category_data) {
                $cache['catname']     = $category_data['catname'];
                $cache['description'] = $category_data['description'];
                $cache['detail']     = $category_data['detail'];
            }
            //马博 end
            //扩展配置
            $cache['setting'] = unserialize($cache['setting']);
            $cache['url']     = buildCatUrl($cache[$field], $cache['url']);
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

/**
 * 当前路径
 * 返回指定栏目路径层级
 * @param $catid 栏目id
 * @param $symbol 栏目间隔符
 */
function catpos($catid, $symbol = ' &gt; ')
{
    if (getCategory($catid) == false) {
        return '';
    }
    //获取当前栏目的 父栏目列表
    $arrparentid = array_filter(explode(',', getCategory($catid, 'arrparentid') . ',' . $catid));
    foreach ($arrparentid as $cid) {
        $parsestr[] = '<a href="' . getCategory($cid, 'url') . '" >' . getCategory($cid, 'catname') . '</a>';
    }
    $parsestr = implode($symbol, $parsestr);
    return $parsestr;
}

/**
 * 生成分类信息中的筛选菜单
 */
function filters($modelid, $catid)
{
    $url_mode = isset(cache("Cms_Config")['site_url_mode']) ? cache("Cms_Config")['site_url_mode'] : 1;
    $data     = get_filters_field($modelid);
    Request::filter('trim,strip_tags');
    $param = paramdecode(Request::param('condition'));

    //$catid = Request::param('catid');
    $conditionParam = [];
    foreach ($data as $name => $rs) {
        $all[0]                 = '不限';
        $data[$name]['options'] = array_merge($all, $data[$name]['options']);
        //判断是否是单选条件
        $ifradio = 'checkbox' == $data[$name]['type'] ? false : true;
        if ($ifradio) {
            //单选选中参数
            if (!empty($param[$name])) {
                $conditionParam[$name]['options'][$param[$name]]['active'] = true;
                $nowParam                                                  = $param;
                $nowParam[$name]                                           = '';
                $conditionParam[$name]['options'][$param[$name]]['param']  = paramencode($nowParam);
                unset($nowParam);
            }
        } else {
            //多选选中参数
            if (!empty($param[$name])) {
                $paramContent = explode('_', $param[$name]);
                foreach ($paramContent as $k => $v) {
                    $nowParamContent = $paramContent;
                    unset($nowParamContent[$k]);
                    $nowParam                                       = $param;
                    $nowParam[$name]                                = implode('_', $nowParamContent);
                    $conditionParam[$name]['options'][$v]['active'] = true;
                    $conditionParam[$name]['options'][$v]['param']  = paramencode($nowParam);
                    unset($nowParam);
                    unset($nowParamContent);
                }
                unset($paramContent);
            }
        }
        $conditionParam[$name]['title'] = $rs['title'];
        $conditionParam[$name]['name']  = $rs['name'];
        //未选中 active param title url
        foreach ($data[$name]['options'] as $k => $v) {
            $conditionParam[$name]['options'][$k]['title'] = $v;
            //未选中条件参数生成
            if (!isset($conditionParam[$name]['options'][$k]['active'])) {
                //未选中条件参数生成
                $conditionParam[$name]['options'][$k]['active'] = 0;
                if ($ifradio) {
                    $nowParam                                      = $param;
                    $nowParam[$name]                               = $k;
                    $conditionParam[$name]['options'][$k]['param'] = paramencode($nowParam);
                } else {
                    $nowParam                                      = $param;
                    $nowParam[$name]                               = empty($param[$name]) ? $k : $param[$name] . '_' . $k;
                    $conditionParam[$name]['options'][$k]['param'] = paramencode($nowParam);
                }
            }
            if ($url_mode == 1) {
                $field = 'catid';
            } else {
                $field = 'catdir';
                $catid = getCategory($catid, 'catdir');
            }
            $conditionParam[$name]['options'][$k]['url'] = url('cms/index/lists', [$field => $catid, 'condition' => $conditionParam[$name]['options'][$k]['param']]);
            ksort($conditionParam[$name]['options']);
        }
        if (!isset($param[$rs['name']]) && empty($param[$rs['name']])) {
            $conditionParam[$name]['options'][0]['active'] = true;
        }
    }
    return $conditionParam;
}

function structure_filters_sql($modelid)
{
    $data       = get_filters_field($modelid);
    $fields_key = array_keys($data);
    $sql        = '`status` = \'1\'';
    $param      = paramdecode(Request::param('condition'));
    foreach ($param as $k => $r) {
        if (isset($data[$k]['type']) && in_array($k, $fields_key) && intval($r) != 0) {
            if ('radio' == $data[$k]['type']) {
                $sql .= " AND `$k` = '$r'";
            } elseif ('checkbox' == $data[$k]['type']) {
                if (strpos($r, '_')) {
                    $r = explode('_', $r);
                    foreach ($r as $key => $val) {
                        $sql .= " AND FIND_IN_SET($val,`$k`)";
                    }
                } else {
                    $sql .= " AND FIND_IN_SET($r,`$k`)";
                }
            }
        }
    }
    return $sql;
}

function get_filters_field($modelid)
{

    static $filters_data = [];
    if ($filters_data) {
        return $filters_data;
    }
    $options = cache('ModelField')[$modelid];
    foreach ($options as $_k => $_v) {
        if (isset($_v['filtertype']) && $_v['filtertype']) {
            $_v['options'] = parse_attr($_v['options']);
        } else {
            continue;
        }
        $filters_data[$_v['name']] = $_v;
    }
    return $filters_data;

}

function paramdecode($str)
{
    $arr  = [];
    $arr1 = explode('&', $str);
    foreach ($arr1 as $vo) {
        if (!empty($vo)) {
            $arr2 = explode('=', $vo);
            if (!empty($arr2[1])) {
                $arr[$arr2[0]] = $arr2[1];
            }
        }
    }
    return $arr;
}

function paramencode($arr)
{
    $str = '';
    if (!empty($arr)) {
        foreach ($arr as $key => $vo) {
            if (!empty($vo)) {
                $str .= $key . '=' . $vo . '&';
            }
        }
        $str = substr($str, 0, -1);
    }
    return $str;
}

/**
 * 生成SEO
 * @param $catid        栏目ID
 * @param $title        标题
 * @param $description  描述
 * @param $keyword      关键词
 */
function seo($catid = '', $title = '', $description = '', $keyword = '')
{
    //马博 新增
    $siteId = getSiteId();
    if (!empty($catid)) {
        $cat           = getCategory($catid);
        $category_data = db('category_data')->where(['catid' => $catid, 'site_id' => $siteId])->find();
        $setting       = json_decode($category_data['setting'], true);
        if ($setting['title']) {
            $title = $setting['title'];
        }
        if ($setting['keywords']) {
            $keyword = $setting['keywords'];
        }
        if ($setting['description']) {
            $description = $setting['description'];
        }
    }

    $site = db('site')->where('id', $siteId)->find();
    if (!$title && $site) {
        $title = $site['title'];
    }

    if (!$keyword && $site) {
        $keyword = $site['keywords'];
    }

    if (!$description && $site) {
        $description = $site['description'];
    }
    //马博 end
    $seo['site_title']  = $site['title'];
    $seo['keyword']     = !empty($keyword) ? $keyword : $site['site_keyword'];
    $seo['description'] = isset($description) && !empty($description) ? $description : (isset($cat['setting']['meta_description']) && !empty($cat['setting']['meta_description']) ? $cat['setting']['meta_description'] : (isset($site['site_description']) && !empty($site['site_description']) ? $site['site_description'] : ''));
    $seo['title']       = (isset($title) && !empty($title) ? $title . ' - ' : '') . (isset($cat['setting']['meta_title']) && !empty($cat['setting']['meta_title']) ? $cat['setting']['meta_title'] . ' - ' : (isset($cat['catname']) && !empty($cat['catname']) ? $cat['catname'] :''));
    foreach ($seo as $k => $v) {
        $seo[$k] = str_replace(array("\n", "\r"), '', $v);
    }
    return $seo;
}

/**
 * 生成栏目URL
 */
function buildCatUrl($cat, $url = '', $suffix = true, $domain = false)
{
    $field = is_numeric($cat) ? 'catid' : 'catdir';
    return empty($url) ? url('cms/index/lists', [$field => $cat], $suffix, $domain) : ((strpos($url, '://') !== false) ? $url : url($url));
}

//创建内容链接
function buildContentUrl($cat, $id, $url = '', $suffix = true, $domain = false)
{
    $field = is_numeric($cat) ? 'catid' : 'catdir';
    return empty($url) ? url('cms/index/shows', [$field => $cat, 'id' => $id], $suffix, $domain) : ((strpos($url, '://') !== false) ? $url : url($url));
}

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
        $site = db('site')->find($id);
        if ($site) {
            return $site['name'];
        } else {
            return false;
        }
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

//获取站点信息
function getSiteInfo($field)
{
    if (!$field) {
        return false;
    }
    $siteId = onSite();
    $site = db('site')->where(['id' => $siteId])->find();
    if ($site) {
        return $site[$field];
    } else {
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
    $siteUrl = db('site')->where('id',$siteId)->value('url');
    return $siteUrl;
}

//前端站点信息，只有站点标题中有用，可优化删除
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

//前端获取站点风格
function siteTheme()
{
    $siteId = getSiteId();
    $theme = db('site')->where('id',$siteId)->value('template');
    return  $theme ;
}

// 立即清除缓存
function  cleanUp(){
    $cache =  \util\File::del_dir(ROOT_PATH . 'runtime' . DIRECTORY_SEPARATOR . 'cache');
    Cache::clear();
}

function valid(){
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


