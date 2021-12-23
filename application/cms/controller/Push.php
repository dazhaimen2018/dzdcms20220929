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

class Push extends Adminbase
{
    protected $modelClass = null;
    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
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
        $sites  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->select()->toArray();
        $this->site = $sites;
        $this->view->assign('sites', $sites);
        // 20200805 马博 end
    }


    //栏目推送并翻译
    public function category()
    {
        if ($this->request->isPost()) {
            $catid = $this->request->param('id/d', 0);
            if (empty($catid)) {
                return json(['status'=>0,'info'=>'请选择需要推送的栏目！']);
            }
            $info           = Db::name('category')->where(['id' => $catid])->find();
            $info2          = Db::name('category_data')->where(['catid' => $catid])->find();
            $setting        = json_decode($info2['setting'],true);
            $data           = $this->request->post();
            $page_info      = [];//单页数据
            $data['sites']  = [];
            $data['psites'] = [];
            foreach ($data as $dk => $dv){
                if (strstr( $dk , 'sites_cat' ) !== false ){
                    $data['sites'][] = $dv;
                }
            }
            if ($info['type'] == 1){
                $page_info = Db::name('page')->where(['catid' => $catid])->find();
                foreach ($data as $dk => $dv){
                    if (strstr( $dk , 'page_sites' ) !== false ){
                        $data['psites'][] = $dv;
                    }
                }
            }
            if (!$data['sites'] && !$data['psites']){
                return json(['status'=>0,'info'=>'至少选择一个推送站点']);
            }
            $Translator        = new Translator();
            $CategoryDataModel = new CategoryData();
            //步数计算
            $trans_count = count($data['sites'])+count($data['psites']);
            foreach ($data['sites'] as $key => $value){
                $site_arr      = explode(':',$value);
                $site_name     = Db::name('site')->where('id',$site_arr[0])->value('name');
                $save          = array();
                $save['catid'] = $catid;
                $new_catname   = $Translator->text_translator($info2['catname'],$site_arr[1]);
                if (!$new_catname){
                    echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/$trans_count*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败,请检查翻译插件配置</span>']);
                    echo str_pad("", 1024*80);
                    ob_flush();
                    flush();
                    sleep(1);
                    continue;
                }
                $save['catname']     = $new_catname;
                if (isset($save['description'])){
                    $save['description'] = $Translator->text_translator($info2['description'],$site_arr[1]);
                }else{
                    $save['description'] = '';
                }
                $new_setting = [];
                if (isset($setting['title'])){
                    $new_setting['title'] = $Translator->text_translator($setting['title'],$site_arr[1]);
                }else{
                    $new_setting['title'] = '';
                }
                if (isset($setting['keyword'])){
                    $new_setting['keyword'] = $Translator->text_translator($setting['keyword'],$site_arr[1]);
                }else{
                    $new_setting['keyword'] = '';
                }
                if (isset($setting['description'])){
                    $new_setting['description'] = $Translator->text_translator($setting['description'],$site_arr[1]);
                }else{
                    $new_setting['description'] = '';
                }
                $save['setting'] = json_encode($new_setting);
                $save['site_id'] = $site_arr[0];

                if (isset($info2['detail'])){
                    $pattern = stripHtmlTags($info2['detail']);
                    $replacement = [];
                    foreach ($pattern as $pk => $pv){
                        $replacement[] = $Translator->text_translator($pv,$site_arr[1]);
                    }
                    $save_content = restoreHtmlTags($pattern,$replacement,$info2['detail']);
                    $save['detail'] = $save_content;
                }else{
                    $save['detail'] = '';
                }
                $save['status']  = 0;
                if ($CategoryDataModel->where(['catid'=>$catid,'site_id'=>$site_arr[0]])->count()>0){
                    if ($data['status']){
                        $result = $CategoryDataModel->where(['catid'=>$catid,'site_id'=>$site_arr[0]])->update($save);
                    }else{
                        $result = true;
                    }
                }else{
                    $result = $CategoryDataModel->insert($save);
                }
                if ($result !== false){
                    echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/$trans_count*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:green;">成功</span>']);
                }else{
                    echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/$trans_count*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败</span>']);
                }
                echo str_pad("", 1024*80);
                ob_flush();
                flush();
                sleep(1);
            }
            //单页内容推送
            if ($info['type'] == 1){
                foreach ($data['psites'] as $key => $value){
                    $site_arr      = explode(':',$value);
                    $site_name     = Db::name('site')->where('id',$site_arr[0])->value('name');
                    $save          = array();
                    $save['catid'] = $catid;
                    $title         = $Translator->text_translator($page_info['title'],$site_arr[1]);
                    if (!$title){
                        echo json_encode(['status'=>-1,'jindu'=>round(($key+1+count($data['sites']))/$trans_count*100),'info'=>'单页推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败,请检查翻译插件配置</span>']);
                        echo str_pad("", 1024*80);
                        ob_flush();
                        flush();
                        sleep(1);
                        continue;
                    }
                    $save['title'] = $title;
                    if (isset($page_info['keywords'])){
                        $save['keywords'] = $Translator->text_translator($page_info['keywords'],$site_arr[1]);
                    }else{
                        $save['keywords'] = '';
                    }
                    if (isset($page_info['description'])){
                        $save['description'] = $Translator->text_translator($page_info['description'],$site_arr[1]);
                    }else{
                        $save['description'] = '';
                    }
                    if (isset($page_info['content'])){
                        $pattern = stripHtmlTags($page_info['content']);
                        $replacement = [];
                        foreach ($pattern as $pk => $pv){
                            $replacement[] = $Translator->text_translator($pv,$site_arr[1]);
                        }
                        $save_content = restoreHtmlTags($pattern,$replacement,$page_info['content']);
                        $save['content'] = $save_content;
                    }else{
                        $save['content'] = '';
                    }
                    $save['site_id'] = $site_arr[0];
                    $save['thumb']  = $page_info['thumb'];
                    $save['inputtime']  = $page_info['inputtime'];
                    $save['updatetime']  = $page_info['updatetime'];
                    if (Db::name('page')->where(['catid'=>$catid,'site_id'=>$site_arr[0]])->count()>0){
                        if ($data['status']){
                            $result = Db::name('page')->where(['catid'=>$catid,'site_id'=>$site_arr[0]])->update($save);
                        }else{
                            $result = true;
                        }
                    }else{
                        $result = Db::name('page')->insert($save);
                    }
                    if ($result !== false){
                        echo json_encode(['status'=>-1,'jindu'=>round(($key+1+count($data['sites']))/$trans_count*100),'info'=>'单页推送并翻译【'.$site_name.'站】：<span style="color:green;">成功</span>']);
                    }else{
                        echo json_encode(['status'=>-1,'jindu'=>round(($key+1+count($data['sites']))/$trans_count*100),'info'=>'单页推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败</span>']);
                    }
                    echo str_pad("", 1024*80);
                    ob_flush();
                    flush();
                    sleep(1);
                }
            }

            return json(['status'=>1,'info'=>'推送成功']);
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
            $sites        = Site::where('id','in',$data['sites'])->where('status',1)->select()->toArray();
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


    //编辑配置
    public function lang()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id/d');
            $lang_info = Lang_Model::get($id);
            $info = LangData::where('lang_id',$id)->where('site_id',1)->find();
            if (!$info){return json(['status'=>0,'info'=>'未找到指定的碎片信息']);}
            $data = $this->request->post();
            foreach ($data as $dk => $dv){
                if (strstr( $dk , 'site' ) !== false ){
                    $data['sites'][] = $dv;
                }
            }
            $result = $this->validate($data, 'lang.push');
            if (true !== $result) {
                return json(['status'=>0,'info'=>$result]);
            }
            if (!$data['sites']){
                return json(['status'=>0,'info'=>'至少选择一个推送站点']);
            }
            $Translator = new Translator();
            foreach ($data['sites'] as $key => $value){
                $site_arr = explode(':',$value);
                $site_name = Db::name('site')->where('id',$site_arr[0])->value('name');
                $save = array();
                $save['lang_id'] = $id;
                $title = $info['value']?$info['value']:$lang_info['value'];
                $new_value = $Translator->text_translator($title,$site_arr[1]);
                if (!$new_value){
                    echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败,请检查翻译插件配置</span>']);
                    echo str_pad("", 1024*80);
                    ob_flush();
                    flush();
                    sleep(1);
                    continue;
                }
                $save['value'] = $new_value;
                $save['site_id'] = $site_arr[0];
                $save['status']  = 0;
                if (LangData::where(['lang_id'=>$id,'site_id'=>$site_arr[0]])->count()>0){
                    if ($data['status']){
                        $result = LangData::where(['lang_id'=>$id,'site_id'=>$site_arr[0]])->update($save);
                    }else{
                        $result = true;
                    }
                }else{
                    $result = LangData::create($save);
                }
                if ($result !== false){
                    echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:green;">成功</span>']);
                }else{
                    echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败</span>']);
                }
                echo str_pad("", 1024*100);
                ob_flush();
                flush();
                sleep(1);
            }
            cache('lang', null); //清空缓存配置
            return json(['status'=>1,'info'=>'推送成功']);
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
                return json(['status'=>0,'info'=>'该栏目不存在！']);
            }
            $cms_table = $this->Cms_Model->getModelTableName($category['modelid']);
            if (empty($cms_table)) {
                return json(['status'=>0,'info'=>'未找到栏目对应的模型信息！']);
            }
            $info = Db::name($cms_table.'_sub_data')->where(['pid' => $id])->find();
            if ($category['type'] == 2) {
                try {
                    if (!$data['sites']){
                        return json(['status'=>0,'info'=>'至少选择一个推送站点']);
                    }
                    $Translator = new Translator();
                    foreach ($data['sites'] as $key => $value){
                        $site_arr = explode(':',$value);
                        $site_name = Db::name('site')->where('id',$site_arr[0])->value('name');
                        $save = $info;
                        unset($save['id']);
                        $save['views'] = 0;
                        $save['site_id'] = $site_arr[0];
                        $new_value = $Translator->text_translator($info['chapter'],$site_arr[1]);
                        if (!$new_value){
                            echo json_encode(['status'=>-1,'jindu'=>round(($key+1)/count($data['sites'])*100),'info'=>'推送并翻译【'.$site_name.'站】：<span style="color:darkred;">失败,请检查翻译插件配置</span>']);
                            echo str_pad("", 1024*80);
                            ob_flush();
                            flush();
                            sleep(1);
                            continue;
                        }
                        $save['chapter'] = $new_value;
                        //$save['details']  = $Translator->text_translator($info['details'],$site_arr[1]);

                        if (isset($info['details'])){
                            $pattern = stripHtmlTags($info['details']);
                            $replacement = [];
                            foreach ($pattern as $pk => $pv){
                                $replacement[] = $Translator->text_translator($pv,$site_arr[1]);
                            }
                            $save_content = restoreHtmlTags($pattern,$replacement,$info['details']);
                            $save['details'] = $save_content;
                        }else{
                            $save['details'] = '';
                        }

                        if (Db::name($cms_table.'_sub_data')->where(['pid'=>$id,'site_id'=>$site_arr[0]])->count()>0){
                            if ($data['status']){
                                $result = Db::name($cms_table.'_sub_data')->where(['pid'=>$id,'site_id'=>$site_arr[0]])->update($save);
                            }else{
                                $result = true;
                            }
                        }else{
                            $result = Db::name($cms_table.'_sub_data')->insert($save);
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
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            }
            //增加清除缓存
            return json(['status'=>1,'info'=>'推送成功！']);

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
                $this->view->assign(['id'=>$pid,'catid'=>$catid,'check_site'=>$check_site]);
            }
            return $this->fetch();
        }
    }

    //全站同步 cms
    public function site()  {

        if ($this->request->isAjax()) {
            $data = PushMode::where('module', 'cms')->select();
            return json(["code" => 0, "data" => $data]);
        }
        return $this->fetch();
    }

    //一键推送 cms
    public function push()  {
        $this->error('正在开发中。。。！');
    }

}
