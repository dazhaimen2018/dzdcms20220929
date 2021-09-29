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
// | cms管理
// +----------------------------------------------------------------------
namespace app\cms\controller;

use addons\translator\Translator;
use app\cms\model\Chapter as ChapterModel;
use app\cms\model\Cms as Cms_Model;
use app\cms\model\Page as Page_Model;
use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\Db;


class Chapter extends Adminbase
{
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
        $this->ChapterModel = new ChapterModel;
        $this->cmsConfig = cache("Cms_Config");
        $this->assign("cmsConfig", $this->cmsConfig);
        // 20200805 马博所有站点
        $catid    = $this->request->param('catid/d', 0);
        $did      = $this->request->param('did/d', 0);
        $sites    = $this->auth->site_id;
        if ($sites) {
            $whereSite = " id = $sites";
        }else{
            if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
                $sites     = cache("Cms_Config")['site'];
                if(!$sites){ //不满条件
                    $this->error('请在CMS配置-切换站点中选一个站！','cms/setting/index');
                }
                $whereSite = " id = $sites";
            }
        }
        // 找已发布的站点
        if($did){
            $modelid   = getCategory($catid, 'modelid');
            $tablename = $this->ChapterModel->getModelTableName($modelid);
            $sites     = Db::name($tablename . '_data')->where('did', $did)->field('site_id as id')->select();
            $sites     = array_column($sites,'id');
            $catSites  = join(',',$sites);
            $whereIn   = " id in($catSites)";
        }
        $sites  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->select()->toArray();
        if(!$sites){
            $this->error('当前站没有发布内容，无法发布章节内容！');
        }else{
            $this->site = $sites;
            $this->view->assign('sites', $sites);
        }

        // 20200805 马博 end
    }


    //栏目信息列表 $did 为什么出不来值
    public function index()
    {
        $catid = $this->request->param('catid/d', 0);
        $did = $this->request->param('did/d', 0);
        //当前栏目信息
        $catInfo = getCategory($catid);
        if (empty($catInfo)) {
            $this->error('该栏目不存在！');
        }
        //栏目所属模型
        $modelid   = $catInfo['modelid'];
        $catSites  = $catInfo['sites']; //当前栏目所属站点
        $siteId    = onSite();
        // 显示当前站的数据，不太完美，带升级
        $firstSite = substr($catSites,0,strpos($catSites, ','));
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 10);
            $page  = $this->request->param('page/d', 1);
            //检查模型是否被禁用
            if (!getModel($modelid, 'status')) {
                $this->error('模型被禁用！');
            }
            $modelCache = cache("Model");
            $tableName  = $modelCache[$modelid]['tablename'].'_sub_data';
            $this->modelClass = Db::name($tableName);
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $conditions = [
                ['catid',   '=', $catid],
                ['did',     '=', $did],
                ['site_id', '=', $firstSite],
                ['status',  'in', [0, 1]],
            ];
            $total   = Db::name($tableName)->where($where)->where($conditions)->count();
            $list    = Db::name($tableName)->page($page, $limit)->where($where)->where($conditions)->order('listorder DESC, id DESC')->select();
            $_list   = [];
            foreach ($list as $k => $v) {
                $siteUrl         = onSiteUrl();
                $v['updatetime'] = date('Y-m-d H:i', $v['updatetime']);
                $v['url']        = $siteUrl.buildChapterUrl($v['catid'], $v['id'], $v['url']);
                $sites           = Db::name($tableName)->where('pid', $v['id'])->field('site_id as id')->select();
                $v['site']       = array_column($sites,'id');
                $_list[]         = $v;
            }
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);

        }
        /*移动栏目 复制栏目*/
        $tree       = new \util\Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $categorys  = array();
        $result     = Db::name('category')->order('listorder DESC, id DESC')->select();
        foreach ($result as $k => $v) {
            if ($v['type'] != 2) {
                $v['disabled'] = 'disabled';
            }
            if ($modelid && $modelid != $v['modelid']) {
                $v['disabled'] = 'disabled';
            }
            //$v['disabled'] = $v['child'] ? 'disabled' : '';
            $v['selected'] = $v['id'] == $catid ? 'selected' : '';
            $categorys[$k] = $v;
        }
        $str = "<option value=@id @selected @disabled>@spacer @catname</option>";
        $tree->init($categorys);
        $string = $tree->getTree(0, $str, $catid);
        // 20200620 马博
        $siteArray = Site::where("status=1")->select()->toArray();
        // 20200620 end 马博
        $this->assign([
            'string' => $string,
            'catid'  => $catid,
            'did'    => $did,
        ]);
        return $this->fetch();
    }



    //添加信息

    public function add()
    {
        $did = $this->request->param('did/d', 0);
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $catid = intval($data['modelField']['catid']);
            $data['modelField']['did'] = $did;
            if (empty($catid)) {
                $this->error("请指定栏目ID！");
            }
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $data['modelFieldExt'] = isset($data['modelFieldExt']) ? $data['modelFieldExt'] : [];

                Db::startTrans();
                try {
                    $insertId = $this->ChapterModel->addModelDataAll($data['modelField'], $data['modelFieldExt'], $data['extra_data']);
                    Db::commit();
                } catch (\Exception $ex) {
                    Db::rollback();
                    $this->error($ex->getMessage());
                }

            }
            //增加清除缓存
            //$cache =  cleanUp();
            $this->success('操作成功！');
        } else {
            $catid = $this->request->param('catid/d', 0);
            $import = $this->request->param('import/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            $catSites  = $category['sites']; //当前栏目所属站点
            $firstSite = substr($catSites,0,strpos($catSites, ','));
            //发布模式为单站时，如果当前站点不是默认站点时，不能新增！
            if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
                if($firstSite != onSite()) {
                    $this->error('只能默认站新增数据，当前站通过编辑完成数据！');
                }
            }
            if ($category['type'] == 2) {
                $modelid = $category['modelid'];
                $fieldList = $this->ChapterModel->getFieldListAll($modelid);
                $extraFieldList = $this->ChapterModel->getExtraField($modelid, 2);
                $this->assign([
                    'catid'     => $catid,
                    'fieldList' => $fieldList,
                    'extraFieldList' => $extraFieldList,
                    'did' => $did,
                ]);
                return $this->fetch();
            }
        }
    }


    //编辑信息
    public function edit()
    {
        if ($this->request->isPost()) {
            $data                        = $this->request->post();
            $data['modelFieldExt']       = isset($data['modelFieldExt']) ? $data['modelFieldExt'] : [];
            $data['modelField']['id']    = intval($_GET['id']);
            $catid                       = $this->request->param('catid/d', 0);
            $did                         = $this->request->param('did/d', 0);
            $id                          = $this->request->param('id/d', 0);
            $data['modelField']['catid'] = $catid;
            $data['modelField']['id']    = $id;
            $data['modelField']['did']    = $did;
            $category                    = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在!!');
            }
            if ($category['type'] == 2) {
                try {
                    $this->ChapterModel->editModelDataAll($data['modelField'], $data['modelFieldExt'], $data['extra_data']);
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            }
            //增加清除缓存
            //$cache =  cleanUp();
            $this->success('编辑成功！');

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $pid       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $modelid   = $category['modelid'];

                $extraFieldList = $this->ChapterModel->getExtraField($modelid, 2);
                $this->assign([
                    'catid'     => $catid,
                    'id'        => $pid,
                    'extraFieldList' => $extraFieldList,
                    'did' => $did,
                ]);
                $extraData = $this->ChapterModel->getExtraData(['catid' => $catid, 'pid' => $pid]);
                $ret = [];

                if($import){
                    foreach ($this->site as $k => $s) {
                        if ($extraData) {
                            foreach ($extraData as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $ret[$k] = $e;
                                    $ret[$k]['id'] = $e['id'];
                                } else {
                                    //只输出站点1的数据
                                    foreach ($extraData as $f) {
                                        if ($e['site_id']== 1) {
                                            $ret[$k] = $f;
                                            $ret[$k]['site_id'] = $s['id'];
                                            $ret[$k]['id'] = '';
                                        }
                                    }
                                }
                            }
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                        }
                    }
                }else{
                    foreach ($this->site as $k => $s) {
                        if ($extraData) {
                            foreach ($extraData as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $ret[$k] = $e;
                                } else {
                                    $ret[$k]['site_id'] = $s['id'];
                                }
                            }
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                        }
                    }
                }
                $this->view->assign('extra_data', $ret);
                return $this->fetch();
            }
        }
    }

    //编辑信息
    public function push()
    {
        if ($this->request->isPost()) {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $id       = $this->request->param('id/d', 0);
            $data     = $this->request->post();
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            $cms_table = $this->Cms_Model->getModelTableName($category['modelid']);
            if (empty($cms_table)) {
                $this->error('未找到栏目对应的模型信息！');
            }
            $info = Db::name($cms_table.'_sub_data')->where(['pid' => $id])->find();
            if ($category['type'] == 2) {
                try {
                    if (!$data['sites']){
                        $this->error('至少选择一个推送站点');
                    }
                    $Translator = new Translator();
                    foreach ($data['sites'] as $key => $value){
                        $site_arr = explode(':',$value);
                        $save = $info;
                        unset($save['id']);
                        $save['views'] = 0;
                        $save['site_id'] = $site_arr[0];
                        $new_value = $Translator->text_translator($info['chapter'],$site_arr[1]);
                        if (!$new_value){
                            $this->error('翻译失败，请检查翻译插件配置');
                        }
                        $save['chapter'] = $new_value;
                        $save['details']  = $Translator->text_translator($info['details'],$site_arr[1]);
                        if (Db::name($cms_table.'_sub_data')->where(['pid'=>$id,'site_id'=>$site_arr[0]])->count()>0){
                            if ($data['status']){
                                Db::name($cms_table.'_sub_data')->where(['pid'=>$id,'site_id'=>$site_arr[0]])->update($save);
                            }
                        }else{
                            Db::name($cms_table.'_sub_data')->insert($save);
                        }
                    }
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            }
            //增加清除缓存
            $this->success('推送成功！');

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $pid       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $extraData = $this->ChapterModel->getExtraData(['catid' => $catid, 'pid' => $pid]);
                //20210926 增加已推送站点识别
                $check_site = [];
                if($import){
                    foreach ($this->site as $k => $s) {
                        if ($extraData) {
                            foreach ($extraData as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $check_site[] = $e['site_id'];
                                }
                            }
                        }
                    }
                }else{
                    foreach ($this->site as $k => $s) {
                        if ($extraData) {
                            foreach ($extraData as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $check_site[] = $e['site_id'];
                                }
                            }
                        }
                    }
                }
                $this->view->assign(['check_site'=>$check_site]);
            }
            return $this->fetch();
        }
    }

    //删除
    public function del()
    {
        $this->check_priv('delete');
        $catid = $this->request->param('catid/d', 0);
        $ids   = $this->request->param('ids/a', null);
        if (empty($ids) || !$catid) {
            $this->error('参数错误！');
        }
        if (!is_array($ids)) {
            $ids = array(0 => $ids);
        }
        $modelid   = getCategory($catid, 'modelid');
        try {
            foreach ($ids as $id) {
                $this->ChapterModel->deleteModelData($modelid, $id, $this->cmsConfig['web_site_recycle']);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        $this->success('删除成功！');
    }

    //移动文章
    public function remove()
    {
        $this->check_priv('remove');
        if ($this->request->isPost()) {
            $catid = $this->request->param('catid/d', 0);
            if (!$catid) {
                $this->error("请指定栏目！");
            }
            //需要移动的信息ID集合
            $ids = $this->request->param('ids/s');
            //目标栏目
            $tocatid = $this->request->param('tocatid/d', 0);
            if ($ids) {
                if ($tocatid == $catid) {
                    $this->error('目标栏目和当前栏目是同一个栏目！');
                }
                $modelid = getCategory($tocatid, 'modelid');
                if (!$modelid) {
                    $this->error('该模型不存在！');
                }
                $ids       = array_filter(explode('|', $ids), 'intval');
                $tableName = Db::name('model')->where('id', $modelid)->where('status', 1)->value('tablename');
                if (!$tableName) {
                    $this->error('模型被冻结不可操作~');
                }
                if (Db::name(ucwords($tableName))->where('id', 'in', $ids)->update(['catid' => $tocatid])) {
                    Db::name('Category')->where('id', $catid)->setDec('items', count($ids));
                    Db::name('Category')->where('id', $tocatid)->setInc('items', count($ids));
                    $this->success('移动成功~');
                } else {
                    $this->error('移动失败~');
                }
            } else {
                $this->error('请选择需要移动的信息！');
            }
        }
    }

    protected function getAdminPostData($date = '')
    {
        if ($date) {
            list($start, $end) = explode(' - ', $date);
            $start_time        = strtotime($start);
            $end_time          = strtotime($end);
        } else {
            $start_time = \util\Date::unixtime('day', 0, 'begin');
            $end_time   = \util\Date::unixtime('day', 0, 'end');
        }
        $diff_time = $end_time - $start_time;
        $format    = '%Y-%m-%d';
        if ($diff_time > 86400 * 30 * 2) {
            $format = '%Y-%m';
        } else {
            if ($diff_time > 86400) {
                $format = '%Y-%m-%d';
            } else {
                $format = '%H:00';
            }
        }
        //获取所有表名
        $models = array_values(cache('Model'));
        $list   = $xAxisData   = $seriesData   = [];
        if (count($models) > 0) {
            $table1 = $models[0]['tablename'];
            unset($models[0]);
            $field = 'a.username,uid,FROM_UNIXTIME(inputtime, "' . $format . '") as inputtimes,COUNT(*) AS num';
            $dbObj = Db::name($table1)->alias('b')->field($field)->where('inputtime', 'between time', [$start_time, $end_time])->join('admin a', 'a.id = b.uid');
            foreach ($models as $k => $v) {
                $dbObj->union(function ($query) use ($field, $start_time, $end_time, $v) {
                    $query->name($v['tablename'])->alias('b')->field($field)->where('inputtime', 'between time', [$start_time, $end_time])->join('admin a', 'a.id = b.uid')->group('uid,inputtimes');
                });
            };
            $res = $dbObj->group('uid,inputtimes')->select();
            if ($diff_time > 84600 * 30 * 2) {
                $start_time = strtotime('last month', $start_time);
                while (($start_time = strtotime('next month', $start_time)) <= $end_time) {
                    $column[] = date('Y-m', $start_time);
                }
            } else {
                if ($diff_time > 86400) {
                    for ($time = $start_time; $time <= $end_time;) {
                        $column[] = date("Y-m-d", $time);
                        $time += 86400;
                    }
                } else {
                    for ($time = $start_time; $time <= $end_time;) {
                        $column[] = date("H:00", $time);
                        $time += 3600;
                    }
                }
            }
            $xAxisData = array_fill_keys($column, 0);
            foreach ($res as $k => $v) {
                if (!isset($list[$v['username']])) {
                    $list[$v['username']] = $xAxisData;
                }
                $list[$v['username']][$v['inputtimes']] = $v['num'];
            }
            foreach ($list as $index => $item) {
                $seriesData[] = [
                    'name'      => $index,
                    'type'      => 'line',
                    'smooth'    => true,
                    'areaStyle' => [],
                    'data'      => array_values($item),
                ];
            }
        }
        return [array_keys($xAxisData), $seriesData];
    }


    /**
     * 排序
     */
    public function listorder()
    {
        $this->check_priv('listorder');
        $catid      = $this->request->param('catid/d', 0);
        $id         = $this->request->param('id/d', 0);
        $listorder  = $this->request->param('value/d', 0);
        $modelid    = getCategory($catid, 'modelid');
        $modelCache = cache("Model");
        if (empty($modelCache[$modelid])) {
            return false;
        };
        $tableName = $modelCache[$modelid]['tablename'];
        if (Db::name($tableName)->where('id', $id)->update(['listorder' => $listorder])) {
            $this->success("排序成功！");
        } else {
            $this->error("排序失败！");
        }
    }


    //状态
    public function setstate()
    {
        $this->check_priv('status');
        $catid      = $this->request->param('catid/d', 0);
        $id         = $this->request->param('id/d', 0);
        $status     = $this->request->param('value/d');
        $modelid    = getCategory($catid, 'modelid');
        $modelCache = cache("Model");
        if (empty($modelCache[$modelid])) {
            return false;
        };
        $tableName = ucwords($modelCache[$modelid]['tablename']);
        if (Db::name($tableName)->where('id', $id)->update(['status' => $status])) {
            //更新栏目缓存
            cache('Category', null);
            getCategory($id, '', true);
            $this->success('操作成功！');
        } else {
            $this->error('操作失败！');
        }
    }

    public function check_title()
    {
        $title = $this->request->param('data/s', '');
        $catid = $this->request->param('catid/d', 0);
        $id    = $this->request->param('id/d', 0);
        if (empty($title)) {
            $this->success('标题没有重复！');
            return false;
        }
        $modelid    = getCategory($catid, 'modelid');
        $modelCache = cache("Model");
        if (empty($modelCache[$modelid])) {
            $this->error('模型不存在！');
            return false;
        };
        $tableName = ucwords($modelCache[$modelid]['tablename']);
        $repeat    = Db::name($tableName)->where('title', $title);
        empty($id) ?: $repeat->where('id', '<>', $id);
        if ($repeat->find()) {
            $this->error('标题有重复！');
        } else {
            $this->success('标题没有重复！');
        }
    }

    //批量更新
    public function multi()
    {
        // 管理员禁止批量操作
        $this->error();
    }

    protected function check_priv($action)
    {
        if ($this->auth->isAdministrator() !== true) {
            if (0 !== (int) $this->cmsConfig['site_category_auth']) {
                $catid      = $this->request->param('catid/d', 0);
                $action     = getCategory($catid, 'type') == 1 ? 'init' : $action;
                $priv_datas = Db::name('CategoryPriv')->where(['catid' => $catid, 'is_admin' => 1, 'roleid' => $this->auth->roleid, 'action' => $action])->find();
                if (empty($priv_datas)) {
                    $this->error('您没有操作该项的权限！');
                }
            }
        }
    }

}
