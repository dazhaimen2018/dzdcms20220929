<?php
/**
 * Yzncms
 * 版权所有 Yzncms，并保留所有权利。
 * Author: 御宅男 <530765310@qq.com>
 * Update: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 标签库
 */
namespace app\cms\taglib;

use app\cms\model\Category as Category_Model;
use app\cms\model\CategoryData;
use think\Db;

class CmsTagLib
{

    /**
     * 组合查询条件
     * @param type $attr
     * @return type
     */
    protected function where($attr)
    {
        $where = [];
        if (isset($attr['where']) && $attr['where']) {
            array_push($where, $attr['where']);
        }
        //栏目id条件
        if (isset($attr['catid']) && (int)$attr['catid']) {
            $catid = (int)$attr['catid'];

            //同步发布
            $catids   = [];
            $orCatids = '';
            if (isset($attr['catids'])) {
                foreach (explode(',', $attr['catids']) as $k => $v) {
                    $catids[] = "FIND_IN_SET('" . $v . "', catids)";
                }
                if ($catids) {
                    $orCatids = " OR (" . implode(' OR ', $catids) . ")";
                }
            }

            if (getCategory($catid, 'child')) {// 有子栏目
                $catids_str = getCategory($catid, 'arrchildid');// 所有子栏目ID
                // $pos = strpos($catids_str, ',') + 1;// 查找子字符串在字符串中第一次出现的位置
                // $catids_str = substr($catids_str, $pos); // 返回字符串的一部分
                array_push($where, "(`catid` in(" . $catids_str . ")" . $orCatids.")");
            } else {
                array_push($where, "(`catid` = " . $catid . $orCatids.")");
            }
        }
        $where_str = "";
        if (0 < count($where)) {
            $where_str = implode(" AND ", $where);
        }
        return $where_str;
    }


    /**
     * 栏目标签
     */
    public function Category($data)
    {
        $url_mode = isset(cache("Cms_Config")['site_url_mode']) ? cache("Cms_Config")['site_url_mode'] : 1;
        $where    = isset($data['where']) ? $data['where'] : "status=1";
        $order    = isset($data['order']) ? $data['order'] : 'listorder DESC,id DESC';
        if (getSite('alone')==1){
            $siteId = getSiteId();
        }else{
            $siteId = 1;
        }
        //每页显示总数
        //$num = isset($data['num']) ? (int) $data['num'] : 10;
        if (!isset($data['limit'])) {
            $data['limit'] = 0 == (int) $data['num'] ? 10 : (int) $data['num'];
        }
        if (isset($data['catid'])) {
            $catid = (int) $data['catid'];
            $where .= empty($where) ? "`parentid` = " . $catid : " AND `parentid` = " . $catid;
        }
        if (isset($data['siteId'])) {
            $site = [];
            foreach (explode(',', $data['siteId']) as $k => $v) {
                $site[] = "FIND_IN_SET('" . $v . "', sites)";
            }
            if ($site) {
                $where .= " AND (" . implode(' OR ', $site) . ")";
            }
        }
        $categorys = Category_Model::where($where)->limit($data['limit'])->order($data['order'])->cache(60)->select();

        if (!empty($categorys)) {
            foreach ($categorys as &$vo) {
                $category_data = CategoryData::where(['catid' => $vo['id'], 'site_id' => $siteId])->cache(60)->find();
                if ($category_data) {
                    $vo['catname'] = $category_data['catname'];
                    $vo['status']  = $category_data['status'];
                }else{
                    $vo['status']  = $categorys['status'];
                }

                $cat         = $url_mode == 1 ? $vo['id'] : $vo['catdir'];
                $vo['url']   = buildCatUrl($cat, $vo['url']);
            }
        }
        return $categorys;
    }

    /**
     * 列表标签
     */
    public function lists($data)
    {
        $catid  = isset($data['catid']) ? trim($data['catid']) : '';
        $onTime = time(); // 当前时间 未来文章不显示
        //$data['where'] = isset($data['where']) ? $data['where'] . " AND `status`=1" : "`status`=1";
        $data['where'] = isset($data['where']) ? $data['where'] . " AND `status`=1 AND `inputtime`<" . $onTime : "`status`=1  AND `inputtime`<" . $onTime;
        if (!isset($data['limit'])) {
            $data['limit'] = 0 == (int) $data['num'] ? 10 : (int) $data['num'];
        }
        if (empty($data['order'])) {
            $data['order'] = ['updatetime' => 'DESC', 'id' => 'DESC'];
        }
        if (isset($data['flag'])) {
            $flag = [];
            foreach (explode(',', $data['flag']) as $k => $v) {
                $flag[] = "FIND_IN_SET('" . $v . "', flag)";
            }
            if ($flag) {
                $data['where'] .= " AND (" . implode(' OR ', $flag) . ")";
            }
        }
        $data['field']  = isset($data['field']) ? $data['field'] : '*';
        $data['simple'] = isset($data['simple']) ? (is_numeric($data['simple']) ? (int) $data['simple'] : (bool) $data['simple']) : false;
        $moreifo        = isset($data['moreinfo']) ? $data['moreinfo'] : 0;
        //如果设置了catid，则根据catid判断modelid,传入的modelid失效
        if ($catid) {
            //当前栏目信息
            $catInfo = getCategory($catid);
            $modelid = $catInfo ? $catInfo['modelid'] : 0;
        } else {
            if (!isset($data['modelid'])) {
                return false;
            }
            $modelid = intval($data['modelid']);
        }
        if (getSite('alone')==1){
            $siteId = getSiteId();
        }else{
            $siteId = 1;
        }
        $pageconfig                                     = [];
        isset($data['pagepath']) && $pageconfig['path'] = $data['pagepath'];
        $result                                         = model('cms/Cms')->getList($modelid, $this->where($data), $moreifo, $siteId, $data['field'], $data['order'], $data['limit'], $data['page'], $data['simple'], $pageconfig);
        return $result;
    }

    /**
     * 章节列表标签
     */
    public function chapters($data)
    {
        $catid = isset($data['catid']) ? trim($data['catid']) : '';
        $did   = isset($data['did']) ? trim($data['did']) : '';

        $data['where'] = isset($data['where']) ? $data['where'] . " AND `status`=1" : "`status`=1";
        if (!isset($data['limit'])) {
            $data['limit'] = 0 == (int) $data['num'] ? 10 : (int) $data['num'];
        }
        if (empty($data['order'])) {
            $data['order'] = array('updatetime' => 'DESC', 'id' => 'DESC');
        }
//        if (isset($data['flag'])) {
//            $flag = [];
//            foreach (explode(',', $data['flag']) as $k => $v) {
//                $flag[] = "FIND_IN_SET('" . $v . "', flag)";
//            }
//            if ($flag) {
//                $data['where'] .= " AND (" . implode(' OR ', $flag) . ")";
//            }
//        }
        $data['field']  = isset($data['field']) ? $data['field'] : '*';
        $data['simple'] = isset($data['simple']) ? (is_numeric($data['simple']) ? (int) $data['simple'] : (bool) $data['simple']) : false;
        $moreifo        = isset($data['moreinfo']) ? $data['moreinfo'] : 0;
        //如果设置了catid，则根据catid判断modelid,传入的modelid失效
        if ($catid) {
            //当前栏目信息
            $catInfo = getCategory($catid);
            $modelid = $catInfo ? $catInfo['modelid'] : 0;
        } else {
            if (!isset($data['modelid'])) {
                return false;
            }
            $modelid = intval($data['modelid']);
        }
        if (getSite('alone')==1){
            $siteId = getSiteId();
        }else{
            $siteId = 1;
        }
        $result = model('cms/Chapter')->getChapterList($modelid, $this->where($data), $moreifo, $did, $siteId, $data['field'], $data['order'], $data['limit'], $data['page'], $data['simple']);
        return $result;
    }

    /**
     * Tags标签
     */
    public function tags($data)
    {
        $where = [];
        if (isset($attr['where']) && $attr['where']) {
            array_push($where, $attr['where']);
        }
        if (isset($data['tagid'])) {
            if (strpos($data['tagid'], ',') !== false) {
                $r = Db::name('Tags')->where('id', 'in', $data['tagid'])->cache(60)->value('tagid,tag');
                array_push($where, "tag in(" . $r . ")");
            } else {
                $r = Db::name('Tags')->where(['id' => (int) $data['tagid']])->find();
                array_push($where, "tag = '" . $r['tag'] . "'");
            }
        } else {
            if (is_array($data['tag'])) {
                array_push($where, "tag in(" . $data['tag'] . ")");
            } else {
                $tags = strpos($data['tag'], ',') !== false ? explode(',', $data['tag']) : explode(' ', $data['tag']);
                if (count($tags) == 1) {
                    array_push($where, "tag = '" . $data['tag'] . "'");
                } else {
                    array_push($where, "tag in('" . implode("', '", $tags) . "')");
                }
            }
        }
        $where_str = "";
        if (0 < count($where)) {
            $where_str = implode(" AND ", $where);
        }
        if (!isset($data['limit'])) {
            $data['limit'] = 0 == (int) $data['num'] ? 10 : (int) $data['num'];
        }
        $where_str .= " and site_id=" . getSiteId();
        $res = Db::name('TagsContent')->where($where_str)->limit($data['limit'])->cache(60)->select();
        //读取文章信息
        foreach ($res as $k => $v) {
            $p = model('cms/Cms')->getParentData(['id' => $v['contentid'], 'catid' => $v['catid']]);
            $r = model('cms/Cms')->getContent($v['modelid'], "`id` =" . $p['did'], false, '*', $data['limit'], $data['page']);
            if ($r) {
                $return[$k] = array_merge($v, $r);
            }
        }
        return $return;

    }

    /**
     * 上一页
     */
    public function pre($data)
    {
        //当没有内容时的提示语
        $msg = !empty($data['msg']) ? $data['msg'] : patch('NoData');
        //是否新窗口打开
        $target    = !empty($data['target']) ? ' target=_blank ' : '';
        $tableName = model('cms/Cms')->getModelTableName(getCategory($data['catid'], 'modelid'));
        $result    = model('cms/Cms')->getContent(getCategory($data['catid'], 'modelid'), "catid =" . $data['catid'] . " AND " . $tableName . ".status=1 AND " . $tableName . ".id <" . $data['id'], false, '*','', $cache = false, $site_id = 0,$type="pre");
        if (!$result) {
            $result['title'] = $msg;
            $result['url']   = 'javascript:alert("' . $msg . '");';
        }
        $result['target'] = $target;
        return $result;

    }


    /**
     * 下一页
     */
    public function next($data)
    {
        //当没有内容时的提示语
        $msg = !empty($data['msg']) ? $data['msg'] : patch('NoData');
        //是否新窗口打开
        $target    = !empty($data['target']) ? ' target=_blank ' : '';
        $tableName = model('cms/Cms')->getModelTableName(getCategory($data['catid'], 'modelid'));
        $result    = model('cms/Cms')->getContent(getCategory($data['catid'], 'modelid'), "catid =" . $data['catid'] . " AND " . $tableName . ".status=1 AND " . $tableName . ".id >" . $data['id'], false, '*');
        if (!$result) {
            $result['title'] = $msg;
            $result['url']   = 'javascript:alert("' . $msg . '");';
        }
        $result['target'] = $target;
        return $result;
    }

    /**
     * 章节上一页
     */
    public function chapterPre($data)
    {
        //当没有内容时的提示语
        $msg = !empty($data['msg']) ? $data['msg'] : patch('NoData');
        //是否新窗口打开
        $target    = !empty($data['target']) ? ' target=_blank ' : '';
        $tableName = model('cms/Chapter')->getModelTableName(getCategory($data['catid'], 'modelid'));
        $tableName = $tableName . '_sub_data';
        $result    = model('cms/Chapter')->getChapterContent(getCategory($data['catid'], 'modelid'), $data['did'], "catid =" . $data['catid'] . " AND " . $tableName . ".status=1 AND " . $tableName . ".id <" . $data['id'], false, '*','', $cache = false, $site_id = 0,$type="chapterPre");
        if (!$result) {
            $result['chapter'] = $msg;
            $result['url']   = 'javascript:alert("' . $msg . '");';
        }
        $result['target'] = $target;
        return $result;

    }

    /**
     * 章节下一页
     */
    public function chapterNext($data)
    {
        //当没有内容时的提示语
        $msg = !empty($data['msg']) ? $data['msg'] : patch('NoData');
        //是否新窗口打开
        $target    = !empty($data['target']) ? ' target=_blank ' : '';
        $tableName = model('cms/Chapter')->getModelTableName(getCategory($data['catid'], 'modelid'));
        $tableName = $tableName . '_sub_data';
        $result    = model('cms/Chapter')->getChapterContent(getCategory($data['catid'], 'modelid'), $data['did'], "catid =" . $data['catid'] . " AND " . $tableName . ".status=1 AND " . $tableName . ".id >" . $data['id'], false, '*');
        if (!$result) {
            $result['chapter'] = $msg;
            $result['url']   = 'javascript:alert("' . $msg . '");';
        }
        $result['target'] = $target;
        return $result;
    }

}
