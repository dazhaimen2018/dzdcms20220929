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
use app\cms\model\Cms as Cms_Model;
use app\cms\model\Page as Page_Model;
use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\Db;


class Cms extends Adminbase
{
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
        $this->cmsConfig = cache("Cms_Config");
        $this->assign("cmsConfig", $this->cmsConfig);
        // 20200805 马博所有站点
        $siteIds    = $this->auth->sites;
        if ($siteIds) {
            $whereSite = " id = $siteIds";
        }else{
           if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
               $sites     = cache("Cms_Config")['site'];
               if(!$sites){ //不满条件
                   $this->error('请在CMS配置-切换站点中选一个站！','cms/setting/index');
               }
               $whereSite = " id = $sites";
           }
        }
        $catid    = $this->request->param('catid/d', 0);
        $catSites = getCategory($catid,'sites'); //当前栏目所属站点
        if($catSites){
            $whereIn  = " id in($catSites)";
        }
        $sites  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->select()->toArray();
        $this->site = $sites;
        $this->view->assign('sites', $sites);
        // 20200805 马博 end
    }

    public function index()
    {
        $isAdministrator = $this->auth->isAdministrator();
        $json            = $priv_catids            = [];
        if (0 !== (int) $this->cmsConfig['site_category_auth']) {
            //栏目权限 超级管理员例外
            if ($isAdministrator !== true) {
                $role_id     = $this->auth->roleid;
                $priv_result = Db::name('CategoryPriv')->where(['roleid' => $role_id, 'action' => 'init'])->select();
                foreach ($priv_result as $_v) {
                    $priv_catids[] = $_v['catid'];
                }
            }
        }
        if (isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
            $sitId = onSite();
            $site  = [];
            foreach (explode(',', $sitId) as $k => $v) {
                $site[] = "FIND_IN_SET('" . $v . "', sites)";
            }
            if ($site) {
                $where = "  (" . implode(' OR ', $site) . ")";
            }
        }
        // 获取当前管理所属站点
        $sites = $this->auth->sites;
        if($sites){
            $site  = [];
            foreach (explode(',', $sites) as $k => $v) {
                $site[] = "FIND_IN_SET('" . $v . "', sites)";
            }
            if ($site) {
                $whereSite = "  (" . implode(' OR ', $site) . ")";
            }
        }
        $categorys = Db::name('Category')->where($where)->where($whereSite)->order('listorder DESC, id DESC')->select();

        foreach ($categorys as $rs) {
            //剔除无子栏目外部链接
            if ($rs['type'] == 3 && $rs['child'] == 0) {
                continue;
            }
            if (0 !== (int) $this->cmsConfig['site_category_auth']) {
                //只显示有init权限的，超级管理员除外
                if ($isAdministrator !== true && !in_array($rs['id'], $priv_catids)) {
                    $arrchildid      = explode(',', $rs['arrchildid']);
                    $array_intersect = array_intersect($priv_catids, $arrchildid);
                    if (empty($array_intersect)) {
                        continue;
                    }
                }
            }
            $data = array(
                'id'       => $rs['id'],
                'parentid' => $rs['parentid'],
                'catname'  => $rs['catname'],
                'type'     => $rs['type'],
            );
            //终极栏目
            if ($rs['child'] !== 0) {
                $data['isParent'] = true;
            }
            $data['target'] = 'right';
            $data['url']    = url('cms/cms/classlist', array('catid' => $rs['id']));
            //单页
            if ($rs['type'] == 1) {
                $data['target'] = 'right';
                $data['url']    = url('cms/cms/add', array('catid' => $rs['id']));
            }
            $json[] = $data;
        }
        $this->assign('json', json_encode($json));
        return $this->fetch();
    }

    //栏目信息列表
    public function classlist()
    {
        $catid      = $this->request->param('catid/d', 0);
        $url_mode   = isset(cache("Cms_Config")['site_url_mode']) ? cache("Cms_Config")['site_url_mode'] : 1;
        $show_mode  = isset(cache("Cms_Config")['show_url_mode']) ? cache("Cms_Config")['show_url_mode'] : 1;
        //当前栏目信息
        $catInfo = getCategory($catid);
        if (empty($catInfo)) {
            $this->error('该栏目不存在！');
        }
        //栏目所属模型
        $modelid   = $catInfo['modelid'];
        $modelType = db('model')->where('id',$modelid)->cache(60)->value('type');
        if ($this->request->isAjax()) {
            // 20200805 马博
            $limit = $this->request->param('limit/d', 10);
            $page = $this->request->param('page/d', 1);
            // 20200805 马博 end
            //检查模型是否被禁用
            if (!getModel($modelid, 'status')) {
                $this->error('模型被禁用！');
            }
            $modelCache = cache("Model");
            $tableName  = $modelCache[$modelid]['tablename'];
            //Selectpage条件
            $selecCatid = $this->request->param('catid/d', 0);
            $wheres     = 'catid =' . $selecCatid ;
            $this->modelClass = Db::name($tableName);
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage($wheres);
            }
            list($page, $limit, $where) = $this->buildTableParames();

            $conditions = [
                ['catid', '=', $catid],
                ['status', 'in', [0, 1]],
            ];
            $total   = Db::name($tableName)->where($where)->where($conditions)->count();
            $list    = Db::name($tableName)->page($page, $limit)->where($where)->where($conditions)->order('listorder DESC, id DESC')->select();
            $siteId  = onSite();
            $siteUrl = onSiteUrl();
            $_list   = [];
            foreach ($list as $k => $v) {
                $cat             = $url_mode == 1 ? $catid : (isset($Category[$catid]) ? $Category[$catid]['catdir'] : getCategory($catid, 'catdir'));
                $diy             = $show_mode == 1 ? $v['diyurl'] : $v['id'];
                $v['updatetime'] = date('Y-m-d H:i', $v['updatetime']);
                $v['url']        = $siteUrl.buildContentUrl($cat, $diy, $v['url']);
                //马博 显示已添站点ID
                $sites           = Db::name($tableName . '_data')->where('did', $v['id'])->field('site_id as id')->select();
                $v['site']       = array_column($sites,'id');
                if($siteId){
                    $v['title']  = Db::name($tableName . '_data')->where('did', $v['id'])->where('site_id', $siteId )->value('title');
                } else {
                    $v['title']  = '发布模式为“单站”模式时才显示标题！';
                }
                $v['modelType'] = $modelType;
                // end
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
            'site'   => $siteData,
        ]);
        return $this->fetch();
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

    //添加信息

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $catid = intval($data['modelField']['catid']);
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
                    $insertId = $this->Cms_Model->addModelDataAll($data['modelField'], $data['modelFieldExt'], $data['extra_data']);
                    Db::commit();
                } catch (\Exception $ex) {
                    Db::rollback();
                    $this->error($ex->getMessage());
                }

            } else if ($category['type'] == 1) {
                $Page_Model = new Page_Model;
                Db::startTrans();
                try {
                    if (!$Page_Model->saveData($data)) {
                        $error = $Page_Model->getError();
                        $this->error($error ? $error : '操作失败！');
                    }
                    Db::commit();
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
            }
            //增加清除缓存
            $cache =  cleanUp();
            $this->success('操作成功！');
        } else {
            $catid = $this->request->param('catid/d', 0);
            $import = $this->request->param('import/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if(isset(cache("Cms_Config")['offside']) && 1 == cache("Cms_Config")['offside']) {
                $view = 'add_tab';
            }
            if ($category['type'] == 2) {
                $modelid = $category['modelid'];
                $fieldList = $this->Cms_Model->getFieldListAll($modelid);
                $extraFieldList = $this->Cms_Model->getExtraField($modelid, 0);
                $this->assign([
                    'catid'     => $catid,
                    'fieldList' => $fieldList,
                    'extraFieldList' => $extraFieldList,
                ]);
                return $this->fetch($view);
            } else if ($category['type'] == 1) {
                $Page_Model = new Page_Model;
                $info = $Page_Model->selectAll($catid);
                // 马博增加
                $ret = [];
                if($import==1){
                    foreach ($this->site as $k => $s) {

                        if ($info) {
                            foreach ($info as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $ret[$k] = $e;
                                } else {
                                    //只输出站点1的数据
                                    foreach ($info as $f) {
                                        if ($e['site_id']== 1) {
                                            $ret[$k]            = $f;
                                            $ret[$k]['site_id'] = $s['id'];
                                            $ret[$k]['id']      = '';
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
                        if ($info) {
                            foreach ($info as $e) {
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
                $this->assign([
                    'info'  => $ret,
                    'catid' => $catid,
                ]);
                // 马博增加 end
                return $this->fetch('singlepage');
            }
        }
    }


    //编辑信息
    public function edit()
    {
        if ($this->request->isPost()) {
            $data                  = $this->request->post();
            $data['modelFieldExt'] = isset($data['modelFieldExt']) ? $data['modelFieldExt'] : [];
            $data['modelField']['id'] = intval($_GET['id']);
            $catid = intval($data['modelField']['catid']);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                try {
                    $this->Cms_Model->editModelDataAll($data['modelField'], $data['modelFieldExt'], $data['extra_data']);
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            } else if ($category['type'] == 1) {
                $Page_Model = new Page_Model;
                Db::startTrans();
                try {
                    if (!$Page_Model->saveData($data)) {
                        $error = $Page_Model->getError();
                        $this->error($error ? $error : '操作失败！');
                    }
                    Db::commit();
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
            }
            //增加清除缓存
            $cache =  cleanUp();
            $this->success('编辑成功！');

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $id       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if(isset(cache("Cms_Config")['offside']) && 1 == cache("Cms_Config")['offside']) {
                $view = 'edit_tab';
            }
            if ($category['type'] == 2) {
                $modelid   = $category['modelid'];
                $fieldList = $this->Cms_Model->getFieldListAll($modelid, $id);
                $extraFieldList = $this->Cms_Model->getExtraField($modelid, 0);
                $this->assign([
                    'catid'     => $catid,
                    'id'        => $id,
                    'fieldList' => $fieldList,
                    'extraFieldList' => $extraFieldList,
                ]);
                $extraData = $this->Cms_Model->getExtraData(['catid' => $catid, 'did' => $id]);
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
                return $this->fetch($view);
            } else {
                return $this->fetch('singlepage');
            }
        }
    }

    //推送并翻译
    public function push()
    {
        if ($this->request->isPost()) {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $id       = $this->request->param('id/d', 0);
            $data     = $this->request->post();
            foreach ($data as $dk => $dv){
                if (strstr( $dk , 'site' ) !== false ){
                    $data['sites'][] = $dv;
                }
            }
            $category = getCategory($catid);
            if (empty($category)) {
                return json(['status'=>0,'info'=>'该栏目不存在!']);
            }
            $cms_table = $this->Cms_Model->getModelTableName($category['modelid']);
            if (empty($cms_table)) {
                return json(['status'=>0,'info'=>'未找到栏目对应的模型信息！']);
            }
            $info = Db::name($cms_table.'_data')->where(['did' => $id])->find();
            if ($category['type'] == 2) {
                if (!$data['sites']){
                    return json(['status'=>0,'info'=>'至少选择一个推送站点']);
                }
                $Translator = new Translator();
                foreach ($data['sites'] as $key => $value){
                    $site_arr = explode(':',$value);
                    $site_name = Db::name('site')->where('id',$site_arr[0])->value('name');
                    $save = array();
                    $save['did'] = $id;
                    $new_value = $Translator->text_translator($info['title'],$site_arr[1]);
                    if (!$new_value){
                        echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败,请检查翻译插件配置</span>']);
                        echo str_pad("", 1024*80);
                        ob_flush();
                        flush();
                        sleep(1);
                        continue;
                    }
                    $save['title'] = $new_value;
                    $save['site_id'] = $site_arr[0];
                    $save['tags']  = $Translator->text_translator($info['tags'],$site_arr[1]);
                    $save['keywords']  = $Translator->text_translator($info['keywords'],$site_arr[1]);
                    $save['description']  = $Translator->text_translator($info['description'],$site_arr[1]);

                    if (isset($info['content'])){
                        $pattern = stripHtmlTags($info['content']);
                        $replacement = [];
                        foreach ($pattern as $pk => $pv){
                            $replacement[] = $Translator->text_translator($pv,$site_arr[1]);
                        }
                        $save_content = restoreHtmlTags($pattern,$replacement,$info['content']);
                        $save['content'] = $save_content;
                    }else{
                        $save['content'] = '';
                    }

                    if (Db::name($cms_table.'_data')->where(['did'=>$id,'site_id'=>$site_arr[0]])->count()>0){
                        if ($data['status']){
                            $result = Db::name($cms_table.'_data')->where(['did'=>$id,'site_id'=>$site_arr[0]])->update($save);
                        }else{
                            $result = true;
                        }
                    }else{
                        $result = Db::name($cms_table.'_data')->insert($save);
                    }
                    if ($result !== false){
                        echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:green;">成功</span>']);
                    }else{
                        echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败</span>']);
                    }
                    echo str_pad("", 1024*80);
                    ob_flush();
                    flush();
                    sleep(1);
                }
            }
            //增加清除缓存
            $cache =  cleanUp();
            return json(['status'=>1,'info'=>'推送成功！']);

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $id       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $extraData = $this->Cms_Model->getExtraData(['catid' => $catid, 'did' => $id]);
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

                $this->view->assign(['catid'=>$catid,'id'=>$id,'check_site'=>$check_site]);
                return $this->fetch();
            } else {
                return $this->fetch();
            }
        }
    }




    //删除
    public function del()
    {
        $this->check_priv('delete');
        $catid = $this->request->param('catid/d', 0);
        $ids   = $this->request->param('ids/a', null);
        $sites = $this->request->param('sites/d', null);
        if (empty($ids) || !$catid) {
            $this->error('参数错误！');
        }
        if (!is_array($ids)) {
            $ids = array(0 => $ids);
        }
        $modelid   = getCategory($catid, 'modelid');
        try {
            foreach ($ids as $id) {
                $this->Cms_Model->deleteModelData($modelid, $id, $sites, $this->cmsConfig['web_site_recycle']);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        $this->success('删除成功！');
    }

    //清空回收站
    public function destroy()
    {
        $catid = $this->request->param('catid/d', 0);
        $ids   = $this->request->param('ids/a', null);
        if (empty($ids) || !$catid) {
            $this->error('参数错误！');
        }
        if (!is_array($ids)) {
            $ids = array(0 => $ids);
        }
        try {
            foreach ($ids as $id) {
                $this->Cms_Model->deleteModelData($modelid, $id);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        $this->success('销毁成功！');
    }

    //面板
    public function panl()
    {
        if ($this->request->isPost()) {
            $date                         = $this->request->post('date');
            list($xAxisData, $seriesData) = $this->getAdminPostData($date);
            $this->success('', '', ['xAxisData' => $xAxisData, 'seriesData' => $seriesData]);
        } else {
            $info['category'] = Db::name('Category')->count();
            $info['model']    = Db::name('Model')->where(['module' => 'cms'])->count();
            $info['tags']     = Db::name('Tags')->count();
            $info['doc']      = 0;
            $modellist        = cache('Model');
            foreach ($modellist as $model) {
                if ($model['module'] !== 'cms') {
                    continue;
                }
                $tmp = Db::name($model['tablename'])->count();
                $info['doc'] += $tmp;
            }
            list($xAxisData, $seriesData) = $this->getAdminPostData();
            $this->assign('xAxisData', $xAxisData);
            $this->assign('seriesData', $seriesData);
            $this->assign('info', $info);
            return $this->fetch();
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

    //回收站
    public function recycle()
    {
        $catid = $this->request->param('catid/d', 0);
        //当前栏目信息
        $catInfo = getCategory($catid);
        if (empty($catInfo)) {
            $this->error('该栏目不存在！');
        }
        //栏目所属模型
        $modelid = $catInfo['modelid'];
        if ($this->request->isAjax()) {
            $modelCache                 = cache("Model");
            $tableName                  = $modelCache[$modelid]['tablename'];
            $this->modelClass           = Db::name($tableName);
            list($page, $limit, $where) = $this->buildTableParames();
            $conditions                 = [
                ['catid', '=', $catid],
                ['status', '=', -1],
            ];
            $total = Db::name($tableName)->where($where)->where($conditions)->count();
            $_list = Db::name($tableName)->where($where)->page($page, $limit)->where($conditions)->order('listorder DESC, id DESC')->select();

            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        $this->assign('catid', $catid);
        return $this->fetch();
    }

    //还原回收站
    public function restore()
    {
        $catid = $this->request->param('catid/d', 0);
        //当前栏目信息
        $catInfo = getCategory($catid);
        if (empty($catInfo)) {
            $this->error('该栏目不存在！');
        }
        //栏目所属模型
        $modelid   = $catInfo['modelid'];
        $ids       = $this->request->param('ids');
        $modelInfo = cache('Model');
        $modelInfo = $modelInfo[$modelid];
        if ($ids) {
            if (!is_array($ids)) {
                $ids = array(0 => $ids);
            }
            Db::name($modelInfo['tablename'])->where('id', 'in', $ids)->setField('status', 1);
        }
        $this->success('还原成功！');
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
