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
use app\cms\model\Site;
use think\facade\Cache;
use think\facade\Request;

include_once APP_PATH . 'cms/cms.php';
/**
 * 获取栏目相关信息
 * @param type $catid 栏目id或者栏目标识
 * @param type $field 返回的字段，默认返回全部，数组
 * @param type $newCache 是否强制刷新
 * @return boolean
 */
function getCategory($cat, $fields = '', $newCache = false)
{
    $url_mode = isset(cache("Cms_Config")['site_url_mode']) ? cache("Cms_Config")['site_url_mode'] : 1;
    if (empty($cat)) {
        return false;
    }
    $siteId = getSiteId();
    $field  = is_numeric($cat) ? 'id' : 'catdir';
    $key    = 'getCategory_' . $siteId . '_' . $cat;
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
                $cache['catname']      = $category_data['catname'];
                $cache['description']  = $category_data['description'];
                $cache['detail']       = $category_data['detail'];
                $cache['setting_data'] = json_decode($category_data['setting'],true);
            }
            //马博 end
            //扩展配置
            $field            = 1 == $url_mode ? 'id' : 'catdir';
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
        $data[$name]['options'][0] = '不限';
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
    $siteId = getSiteId();
    if (!empty($title)) {
        $title = strip_tags($title);
    }
    if (!empty($description)) {
        $description = strip_tags($description);
    }
    if (!empty($keyword)) {
        //$keyword = str_replace(' ', ',', strip_tags($keyword));
        $keyword = strip_tags($keyword);
    }

    $key  = 'siteSeo';
    $site = cache($key);
    if ($site['id'] != $siteId){ //如果站点ID不登录SEO缓存中的站点ID。清楚缓存，重新缓存
        Cache::rm($key, null);
        $site = db('site')->where('id', $siteId)->field('id,title,name,keywords,description')->find();
        Cache::set($key, $site, 3600);
    }

    if (!empty($catid)) {
        $cat = getCategory($catid);
    }
    $seo['site_title']  = isset($site['title']) && !empty($site['title']) ? $site['title'] : $site['name'];
    $seo['keyword']     = !empty($keyword) ? $keyword : $site['keywords'];
    $seo['description'] = isset($description) && !empty($description) ? $description : (isset($cat['setting']['meta_description']) && !empty($cat['setting']['meta_description']) ? $cat['setting']['meta_description'] : (isset($site['description']) && !empty($site['description']) ? $site['description'] : ''));
    $seo['title']       = (isset($title) && !empty($title) ? $title . ' - ' : '') . (isset($cat['setting']['meta_title']) && !empty($cat['setting']['meta_title']) ? $cat['setting']['meta_title']: '');
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
    if(isset(cache("Cms_Config")['site_cat_url']) && 1 == cache("Cms_Config")['site_cat_url']) {
        $suffix = false;
        $slash  = '/';
    }else{
        $suffix = true;
        $slash  = '';
    }
    $field = is_numeric($cat) ? 'catid' : 'catdir';
    return empty($url) ? url('cms/index/lists', [$field => $cat], $suffix, $domain).$slash : ((strpos($url, '://') !== false) ? $url : url($url));
}

//创建内容链接
function buildContentUrl($cat, $id, $url = '', $suffix = true, $domain = false)
{
    $field = is_numeric($cat) ? 'catid' : 'catdir';
    return empty($url) ? url('cms/index/shows', [$field => $cat, 'id' => $id], $suffix, $domain) : ((strpos($url, '://') !== false) ? $url : url($url));
}

//创建章节内容链接
function buildChapterUrl($cat, $id, $url = '', $suffix = true, $domain = false)
{
    $field = is_numeric($cat) ? 'catid' : 'catdir';
    return empty($url) ? url('cms/index/chapter', [$field => $cat, 'id' => $id], $suffix, $domain) : ((strpos($url, '://') !== false) ? $url : url($url));
}



/*文章发布多少时间前*/
function timeRule($time)
{
    $startdate = date('Y-m-d H:i:s',$time);//时间戳转日期（要是日期的话可以不用转）
    $enddate   = date('Y-m-d H:i:s');//当前日期
    $date      = floor((strtotime($enddate) - strtotime($startdate)) / 86400);
    $hour      = floor((strtotime($enddate) - strtotime($startdate)) % 86400 / 3600);
    $minute    = floor((strtotime($enddate) - strtotime($startdate)) % 86400 % 3600 / 60);
    $second    = floor((strtotime($enddate) - strtotime($startdate)) % 86400 % 60);
    if ($date > 90)
    {
        return $startdate;
    }
    elseif ($date >= 30 && $date <= 90)
    {
        return floor($date / 30) . '个月前';
    }
    elseif ($date > 0 && $date < 30)
    {
        return $date . '天前';
    }
    elseif ($hour < 24 && $hour > 0)
    {
        return $hour . '小时前';
    }
    elseif ($minute < 60 && $minute > 0)
    {
        return $minute . '分钟前';
    }
    elseif ($second < 60 && $second > 0)
    {
        //return $second . '秒前';
        return '刚刚';
    }
}
/**
 * 删除指定标签
 * @return mixed
 */
function stripHtmlTags($str)
{
    preg_match_all("/<([\w]+)[^>]*>(.*?)<\/([\w]+)[^>]*>/s", $str,$data);
    $new_data = [];
    foreach($data[0] as $key => $value){
        $nvalue = strip_tags($value);
        if ($nvalue){
            $new_data[] = trim($nvalue);
        }
    }
    return $new_data;
}
/**
 * 还原指定标签
 * @return mixed
 */
function restoreHtmlTags($pattern,$replacement,$str)
{
    if ($pattern && is_array($pattern)){
        foreach($pattern as &$value){
            $value = trim($value,'/');
            $value = '/'.$value.'/';
        }
    }
    $new_data = preg_replace($pattern,$replacement,$str);
    return $new_data;
}