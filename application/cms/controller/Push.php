<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/12/1
 * 栏目管理
 */
namespace app\cms\controller;

use addons\translator\Translator;
use app\cms\model\CategoryData;
use app\cms\model\Cms as Cms_Model;
use app\cms\model\Lang as Lang_Model;
use app\cms\model\LangData;
use app\cms\model\Push as PushMode;

use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\Db;
use think\exception\DbException;

class Push extends Adminbase
{
    protected $modelClass = null;
    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
        //默认数据源站点 以下所有源站点用这个代替 推送时要排除源站点
        $this->masterId  = masterSite('id'); // 默认数据源站ID
        // 20200805 马博所有站点
        $siteIds   = $this->auth->sites;
        $whereIn   = '';
        $whereSite = '';
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
        $sites  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->where('id','<>',$this->masterId)->select()->toArray();
        $this->site = $sites;
        $this->view->assign('sites', $sites);
        // 20200805 马博 end
    }


    //栏目推送并翻译
    public function category()
    {
        if ($this->request->isPost()) {
            $catid = $this->request->param('id/d', 0);
            $site_id  = $this->request->param('site_id/d', 0);
            $data_type  = $this->request->param('type/s', '');
            if (empty($catid)) {
                $this->error('请选择需要推送的栏目！');
            }
            if (empty($site_id)) {
                $this->error('请选择需要推送的站点！');
            }

            $info           = Db::name('category')->where(['id' => $catid])->find();
            $info2          = Db::name('category_data')->where(['catid' => $catid])->where('site_id',$this->masterId)->find();
            if (empty($info2)) {
                $this->error('源语言站数据为空，请切换主站设置');
            }
            $site_info      = Db::name('site')->where('id',$site_id)->field('name,mark')->find();
            $setting        = json_decode($info2['setting'],true);
            $page_info      = Db::name('page')->where(['catid' => $catid])->where('site_id',$this->masterId)->find();//单页数据

            $Translator        = new Translator();
            $CategoryDataModel = new CategoryData();

            //数据整理
            if($data_type == 'cat'){
                $save          = $info2;
                unset($save['id']);
                $save['catid'] = $catid;
                $trans_result   = $Translator->text_translator($info2['catname'],$site_info['mark']);
                if ($trans_result['code']==0){
                    $this->error($trans_result['content']);
                }
                $save['catname']     = $trans_result['content'];

                $trans_result   = $Translator->text_translator($info2['description'],$site_info['mark']);
                if ($trans_result['code']==0){
                    $this->error($trans_result['content']);
                }
                $save['description']     = $trans_result['content'];

                $new_setting = [];
                if (isset($setting['title'])){
                    $trans_result   = $Translator->text_translator($setting['title'],$site_info['mark']);
                    if ($trans_result['code']==0){
                        $this->error($trans_result['content']);
                    }
                    $new_setting['title'] = $trans_result['content'];
                }else{
                    $new_setting['title'] = '';
                }
                if (isset($setting['keyword'])){
                    $trans_result   = $Translator->text_translator($setting['keyword'],$site_info['mark']);
                    if ($trans_result['code']==0){
                        $this->error($trans_result['content']);
                    }
                    $new_setting['keyword'] = $trans_result['content'];
                }else{
                    $new_setting['keyword'] = '';
                }
                if (isset($setting['description'])){
                    $trans_result   = $Translator->text_translator($setting['description'],$site_info['mark']);
                    if ($trans_result['code']==0){
                        $this->error($trans_result['content']);
                    }
                    $new_setting['description'] = $trans_result['content'];
                }else{
                    $new_setting['description'] = '';
                }
                $save['setting'] = json_encode($new_setting);
                $save['site_id'] = $site_id;

                if (isset($info2['detail'])){
                    $pattern = stripHtmlTags($info2['detail']);
                    $replacement = [];
                    foreach ($pattern as $pk => $pv){
                        $trans_result = $Translator->text_translator($pv,$site_info['mark']);
                        if ($trans_result['code']==0){
                            $this->error($trans_result['content']);
                        }
                        $replacement[] = $trans_result['content'];
                    }
                    $save_content = restoreHtmlTags($pattern,$replacement,$info2['detail']);
                    if (isset($save_content['code']) && $save_content['code'] == 0){
                        $this->error($save_content['msg']);
                    }
                    $save['detail'] = $save_content;
                }else{
                    $save['detail'] = '';
                }
                $save['status']  = 0;
                if ($CategoryDataModel->where(['catid'=>$catid,'site_id'=>$site_id])->count()>0){
                    $result = $CategoryDataModel->where(['catid'=>$catid,'site_id'=>$site_id])->update($save);
                }else{
                    $result = $CategoryDataModel->insert($save);
                }
                if ($result === false){
                    $this->success('推送失败','',['info'=>$site_info['name'].'[失败]']);
                }
            }else{
                if ($info['type'] == 1){
                    //单页内容推送
                    $save          = $page_info;
                    unset($save['id']);
                    $save['catid'] = $catid;

                    $trans_result   = $Translator->text_translator($page_info['title'],$site_info['mark']);
                    if ($trans_result['code']==0){
                        $this->error($trans_result['content']);
                    }
                    $save['title'] = $trans_result['content'];

                    if (isset($page_info['keywords'])){
                        $trans_result   = $Translator->text_translator($page_info['keywords'],$site_info['mark']);
                        if ($trans_result['code']==0){
                            $this->error($trans_result['content']);
                        }
                        $save['keywords'] = $trans_result['content'];
                    }else{
                        $save['keywords'] = '';
                    }
                    if (isset($page_info['description'])){
                        $trans_result   = $Translator->text_translator($page_info['description'],$site_info['mark']);
                        if ($trans_result['code']==0){
                            $this->error($trans_result['content']);
                        }
                        $save['description'] = $trans_result['content'];
                    }else{
                        $save['description'] = '';
                    }
                    if (isset($page_info['content'])){
                        $pattern = stripHtmlTags($page_info['content']);
                        $replacement = [];
                        foreach ($pattern as $pk => $pv){
                            $trans_result = $Translator->text_translator($pv,$site_info['mark']);
                            if ($trans_result['code']==0){
                                $this->error($trans_result['content']);
                            }
                            $replacement[] = $trans_result['content'];
                        }
                        $save_content = restoreHtmlTags($pattern,$replacement,$page_info['content']);
                        if (isset($save_content['code']) && $save_content['code'] == 0){
                            $this->error($save_content['msg']);
                        }
                        $save['content'] = $save_content;
                    }else{
                        $save['content'] = '';
                    }
                    $save['site_id'] = $site_id;
                    $save['thumb']  = $page_info['thumb'];
                    $save['inputtime']  = $page_info['inputtime'];
                    $save['updatetime']  = $page_info['updatetime'];
                    if (Db::name('page')->where(['catid'=>$catid,'site_id'=>$site_id])->count()>0){
                        $result = Db::name('page')->where(['catid'=>$catid,'site_id'=>$site_id])->update($save);
                    }else{
                        $result = Db::name('page')->insert($save);
                    }
                    if ($result === false){
                        $this->success('单页推送失败','',['info'=>$site_info['name'].'[失败]']);
                    }
                }
            }

            $this->success('推送成功','',['info'=>$site_info['name'].'[已推]']);
        } else {
            $catid     = $this->request->param('id/d', 0);
            $modelid   = getCategory($catid, 'modelid');
            $modelType = Db::name('Model')->where('id', $modelid)->value('type');
            if (empty($catid)) {
                $this->error('请选择需要推送的栏目！');
            }
            $data          = Db::name('category')->where(['id' => $catid])->find();
            //马博添加
            $data['sites'] = explode(',', $data['sites']);
            //马博添加 end
            $sites        = Site::where('id','in',$data['sites'])->where('id','<>',$this->masterId)->where('status',1)->select()->toArray();
            $categoryData = CategoryData::where(['catid' => $catid])->select()->toArray();

            //20210926 增加已推送站点识别
            $check_site = [];
            $check_page_site = [];
            foreach ($sites as $k => $s) {
                if ($categoryData) {
                    foreach ($categoryData as $e) {
                        if ($e['site_id'] == $s['id']) {
                            $check_site[] = $e['site_id'];
                        }
                    }
                }
            }
            if ($data['type'] == 1){
                #单页栏目，显示内容推送
                $check_page_site = Db::name('page')->where('catid',$catid)->column('site_id');
            }
            $this->assign([
                'catid'           => $catid,
                'sites'           => $sites,
                'check_site'      => $check_site,
                'check_page_site' => $check_page_site,
                'type'            => $data['type']?$data['type']:2,
            ]);
            return $this->fetch();
        }

    }


    //推送并翻译 cms
    public function cms()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id/d', 0);
            $catid = $this->request->param('catid/d', 0);
            $site_id = $this->request->param('site_id/d', 0);
            if (empty($catid)) {
                $this->error('请选择需要推送的栏目！');
            }
            if (empty($site_id)) {
                $this->error('请选择需要推送的站点！');
            }
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在!');
            }
            $cms_table = $this->Cms_Model->getModelTableName($category['modelid']);
            if (empty($cms_table)) {
                $this->error('未找到栏目对应的模型信息！');
            }
            $site_info      = Db::name('site')->where('id',$site_id)->field('name,mark')->find();
            $info = Db::name($cms_table.'_data')->where(['did' => $id])->where('site_id',$this->masterId)->find();

            if ($category['type'] !== 2) {
                $this->error('操作错误');
            }

//            翻译测试，避免浪费翻译费用 start
//            $Translator = new Translator();
//            $pattern = stripHtmlTags($info['content']);
//            $pattern = array_splice($pattern,0,24);
//            dump($pattern);
//            $replacement = [];
//            foreach ($pattern as $pk => $pv){
//                $replacement[] = 'Translator->text_translator';
//                $trans_result = $Translator->text_translator($pv, $site_info['mark']);
//                if ($trans_result['code'] == 0) {
//                    $this->error($trans_result['content']);
//                }
//                $replacement[] = $trans_result['content'];
//            }
//            dump($replacement);
//            $save_content = restoreHtmlTags($pattern,$replacement,$info['content']);
//            dump($save_content);
//            exit;
//            翻译测试，避免浪费翻译费用 end

            //获取翻译字段
            $Translator = new Translator();
            $save = $info;
            unset($save['id']);
            $save['did'] = $id;
            $save['site_id'] = $site_id;
            foreach ($save as $field =>$value) {
                if (strpos($field, 'id') === false && strpos($field, 'time') === false) {
                    if($value != strip_tags($value)) {
                        $pattern = stripHtmlTags($value);
                        $replacement = [];
                        foreach ($pattern as $pk => $pv) {
                            $trans_result = $Translator->text_translator($pv, $site_info['mark']);
                            if ($trans_result['code'] == 0) {
                                $this->error($trans_result['content']);
                            }
                            $replacement[] = $trans_result['content'];
                        }
                        $save_content = restoreHtmlTags($pattern, $replacement, $value);
                        if (isset($save_content['code']) && $save_content['code'] == 0) {
                            $this->error($save_content['msg']);
                        }
                        $save[$field] = $save_content;
                    }elseif (!is_null(@json_decode($value)) && is_array(json_decode($value,true))){
                        $valArr = json_decode($value,true);
                        $valArr2= [];
                        foreach ($valArr as $valKey => $valVal){
                            $trans_result   = $Translator->text_translator($valKey,$site_info['mark']);
                            if ($trans_result['code']==0){
                                $this->error($trans_result['content']);
                            }
                            $valKey = $trans_result['content'];
                            $trans_result   = $Translator->text_translator($valVal,$site_info['mark']);
                            if ($trans_result['code']==0){
                                $this->error($trans_result['content']);
                            }
                            $valVal = $trans_result['content'];
                            $valArr2[$valKey] = $valVal;
                        }
                        $save[$field] = json_encode($valArr2);
                    }else {
                        $trans_result   = $Translator->text_translator($value,$site_info['mark']);
                        if ($trans_result['code']==0){
                            $this->error($trans_result['content']);
                        }
                        $save[$field] = $trans_result['content'];
                    }
                }
            }
            if (Db::name($cms_table.'_data')->where(['did'=>$id,'site_id'=>$site_id])->count()>0){
                $result = Db::name($cms_table.'_data')->where(['did'=>$id,'site_id'=>$site_id])->update($save);
            }else{
                $result = Db::name($cms_table.'_data')->insert($save);
            }
            if ($result === false){
                $this->success('推送失败','',['info'=>$site_info['name'].'[失败]']);
            }

            //增加清除缓存
            $cache =  cleanUp();
            $this->success('推送成功','',['info'=>$site_info['name'].'[已推]']);

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $id       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $extraData = $this->Cms_Model->getExtraData(['catid' => $catid, 'did' => $id]);
                //20210926 增加已推送站点识别
                $check_site = [];
                foreach ($this->site as $k => $s) {
                    if ($extraData) {
                        foreach ($extraData as $e) {
                            if ($e['site_id'] == $s['id']) {
                                $check_site[] = $e['site_id'];
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


    //编辑配置
    public function lang()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id/d');
            $site_id = $this->request->param('site_id/d', 0);
            if (empty($id)) {
                $this->error('请选择需要推送的碎片！');
            }
            if (empty($site_id)) {
                $this->error('请选择需要推送的站点！');
            }
            $lang_info = Lang_Model::get($id);
            $site_info = Db::name('site')->where('id',$site_id)->field('name,mark')->find();
            $info = LangData::where('lang_id',$id)->where('site_id',$this->masterId)->find();
            if (!$lang_info) {
                $this->error('未找到指定的碎片信息！');
            }

            $Translator = new Translator();
            $save = array();
            $save['lang_id'] = $id;
            $save['site_id'] = $site_id;
            $save['status']  = 0;
            $title = $info['value']?$info['value']:$lang_info['value'];
            if (isset($title)){
                $trans_result   = $Translator->text_translator($title,$site_info['mark']);
                if ($trans_result['code']==0){
                    $this->error($trans_result['content']);
                }
                $save['value'] = $trans_result['content'];
            }else{
                $save['value'] = '';
            }
            $map = [];
            $map[] = ['lang_id','=',$id];
            $map[] = ['site_id','=',$site_id];
            $LangDataModel = new LangData();
            try {
                if (Db::name('lang_data')->where($map)->count()>0){
                    $result = Db::name('lang_data')->where($map)->update($save);
                }else{
                    $result = Db::name('lang_data')->insert($save);
                }
            }catch (DbException $e){
                $this->error($e->getMessage());
            }
            if ($result === false){
                $this->success('推送失败','',['info'=>$site_info['name'].'[失败]']);
            }
            cache('lang', null); //清空缓存配置
            $this->success('推送成功','',['info'=>$site_info['name'].'[已推]']);
        } else {
            $id = $this->request->param('id/d');
            if (!is_numeric($id) || $id < 0) {
                return '参数错误';
            }
            $fieldType = Db::name('field_type')->where('name', 'in', $this->banfie)->order('listorder')->column('name,title,ifoption,ifstring');
            $info = Lang_Model::get($id);
            $lang_data = LangData::where(['lang_id'=>$id])->select()->toArray();
            $ret = [];
            //20210926 增加已推送站点识别
            $check_site = [];
            foreach ($this->site as $k => $s) {
                if ($lang_data) {
                    foreach ($lang_data as $e) {
                        if ($e['site_id'] == $s['id']) {
                            $check_site[] = $e['site_id'];
                            $ret[$k] = $e;
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                            $ret[$k]['lang_id'] = $id;
                        }
                    }
                } else {
                    $ret[$k]['site_id'] = $s['id'];
                    $ret[$k]['lang_id'] = $id;
                }
            }
            // 马博增加 end
            $this->assign([
                'groupArray' => lang('lang_group'),
                'fieldType' => $fieldType,
                'info' => $info,
                'lang_data'=>$ret,
                'lang_id'=>$id,
                'check_site'=>$check_site,
            ]);
            return $this->fetch();
        }
    }


    //章节推送
    public function chapter()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id/d', 0);
            $catid = $this->request->param('catid/d', 0);
            $site_id = $this->request->param('site_id/d', 0);
            if (empty($catid)) {
                $this->error('请选择需要推送的栏目！');
            }
            if (empty($site_id)) {
                $this->error('请选择需要推送的站点！');
            }
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在!');
            }
            $cms_table = $this->Cms_Model->getModelTableName($category['modelid']);
            if (empty($cms_table)) {
                $this->error('未找到栏目对应的模型信息！');
            }
            $site_info      = Db::name('site')->where('id',$site_id)->field('name,mark')->find();
            $info = Db::name($cms_table.'_sub_data')->where(['pid' => $id])->where('site_id',$this->masterId)->find();

            //获取翻译字段
            $Translator = new Translator();
            $save = $info;
            unset($save['id']);
            $save['site_id'] = $site_id;
            foreach ($save as $field =>$value) {
                if (strpos($field, 'id') === false && strpos($field, 'time') === false) {
                    if($value != strip_tags($value)){
                        $pattern = stripHtmlTags($value);
                        $replacement = [];
                        foreach ($pattern as $pk => $pv){
                            $trans_result = $Translator->text_translator($pv,$site_info['mark']);
                            if ($trans_result['code']==0){
                                $this->error($trans_result['content']);
                            }
                            $replacement[] = $trans_result['content'];
                        }
                        $save_content = restoreHtmlTags($pattern,$replacement,$value);
                        if (isset($save_content['code']) && $save_content['code'] == 0){
                            $this->error($save_content['msg']);
                        }
                        $save[$field] = $save_content;
                    }elseif (!is_null(@json_decode($value)) && is_array(json_decode($value,true))){
                        $valArr = json_decode($value,true);
                        $valArr2= [];
                        foreach ($valArr as $valKey => $valVal){
                            $trans_result   = $Translator->text_translator($valKey,$site_info['mark']);
                            if ($trans_result['code']==0){
                                $this->error($trans_result['content']);
                            }
                            $valKey = $trans_result['content'];
                            $trans_result   = $Translator->text_translator($valVal,$site_info['mark']);
                            if ($trans_result['code']==0){
                                $this->error($trans_result['content']);
                            }
                            $valVal = $trans_result['content'];
                            $valArr2[$valKey] = $valVal;
                        }
                        $save[$field] = json_encode($valArr2);
                    }else {
                        $trans_result   = $Translator->text_translator($value,$site_info['mark']);
                        if ($trans_result['code']==0){
                            $this->error($trans_result['content']);
                        }
                        $save[$field] = $trans_result['content'];
                    }
                }
            }
            if (Db::name($cms_table.'_sub_data')->where(['pid'=>$id,'site_id'=>$site_id])->count()>0){
                $result = Db::name($cms_table.'_sub_data')->where(['pid'=>$id,'site_id'=>$site_id])->update($save);
            }else{
                $result = Db::name($cms_table.'_sub_data')->insert($save);
            }
            if ($result === false){
                $this->success('推送失败','',['info'=>$site_info['name'].'[失败]']);
            }
            $this->success('推送成功','',['info'=>$site_info['name'].'[已推]']);

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $pid       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $ChapterModel = new \app\cms\model\Chapter();
                $extraData = $ChapterModel->getExtraData(['catid' => $catid, 'pid' => $pid]);
                //20210926 增加已推送站点识别
                $check_site = [];
                foreach ($this->site as $k => $s) {
                    if ($extraData) {
                        foreach ($extraData as $e) {
                            if ($e['site_id'] == $s['id']) {
                                $check_site[] = $e['site_id'];
                            }
                        }
                    }
                }
                $this->view->assign(['id'=>$pid,'catid'=>$catid,'check_site'=>$check_site]);
            }
            return $this->fetch();
        }
    }

    //全站同步 cms
    public function site()  {
        $id = $this->request->param('id/d', 0);
        $siteName = "目标站";
        if ($this->request->isAjax()) {
            $data = PushMode::where('module', 'cms')->select();
            return json(["code" => 0, "data" => $data]);
        }
        $site_info      = Db::name('site')->where('id',$id)->field('name,mark')->find();
        $this->view->assign(['id'=>$id,'siteName'=>$site_info['name']]);
        return $this->fetch();
    }

    //一键推送 cms
    public function push()  {
        $site_id = $this->request->param('id/d', '');
        $change = $this->request->param('change/s', '');
        $tablename = $this->request->param('tablename/s', '');
        $page = $this->request->param('page/d', 1);
        if (!$tablename){
            $this->error('推送目标信息不能为空');
        }
        if ($site_id == $this->masterId){
            $this->error('源语言站与目标站不能一致');
        }
        $site_info = Db::name('site')->where('id',$site_id)->field('name,mark')->find();
        if ($change == 'init'){
            if ($tablename == 'site'){
                $count = db::name($tablename)->where('id',$this->masterId)->count();
            }else{
                $count = db::name($tablename)->where('site_id',$this->masterId)->count();
            }
            $this->success('开始推送','',['count'=>$count]);
        }else{
            
        }
    }

    //新增或编辑站点翻译相关数据
    public function translator(){
        if ($this->request->isPost()) {
            $mark = $this->request->param('mark/s');
            if (!$mark){
                $this->error('语言标识不能为空');
            }
            $check = db::name('language')->where('mark',$mark)->find();
            if (!$check){
                $this->error('未支持该语种的翻译');
            }
            //获取主站信息
            $info = Db::name('site')->field('title,keywords,description')->where('id',$this->masterId)->find();
            //新站点数据
            $save = $info;
            $Translator = new Translator();

            foreach ($save as $field =>$value) {
                $trans_result   = $Translator->text_translator($value,$mark);
                if ($trans_result['code']==0){
                    $this->error($trans_result['content']);
                }
                $save[$field] = $trans_result['content'];
            }
            $this->success('翻译成功','',$save);
        }
    }

}
