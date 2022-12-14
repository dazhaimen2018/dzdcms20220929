<?php

/**
 * Yzncms
 * 版权所有 Yzncms，并保留所有权利。
 * Author: 御宅男 <530765310@qq.com>
 * Update: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 栏目管理
 */
namespace app\cms\controller;

use addons\translator\Translator;
use app\cms\model\Category as CategoryModel;
use app\common\controller\Adminbase;
use app\cms\model\CategoryData;
use app\cms\model\Site;
use think\Db;

class Category extends Adminbase
{

    private $themePath;
    private $categoryTemplate;
    private $listTemplate;
    private $showTemplate;
    private $chapterTemplate;
    private $pageTemplate;
    protected $noNeedRight = [
        'cms/category/count_items',
        'cms/category/public_cache',
    ];
    protected $searchFields = 'id,catname';
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new CategoryModel;
        //取得当前内容模型模板存放目录
        $themePath = TEMPLATE_PATH . (config('theme') ?: "default") . DS . "cms" . DS;
        //取得栏目频道模板列表
        $this->categoryTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'category*'));
        //取得栏目列表模板列表
        $this->listTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'list*'));
        //取得内容页模板列表
        $this->showTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'show*'));
        //取得子内容页模板列表
        $this->chapterTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'chapter*'));
        //取得单页模板
        $this->pageTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'page*'));

        // 20200805 马博所有站点
        $whereIn   = '';
        $whereSite = '';
        $private   = onPrivate();
        $siteAdmin = $this->auth->sites;
        if ($siteAdmin) {
            $whereSite = " id = $siteAdmin";
        }else{
            if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
                $site = cache("Cms_Config")['site'];
                if(!$site){
                    $this->error('请在CMS配置-切换站点中选一个站！','cms/setting/index');
                }
                $whereSite = " id = $site";
            }
        }
        //所有站 或 站点独立管理为否时 $private为假 显示 private为0的所有栏目 否则显示 显示 private为1的栏目 20211222
        $sites = Site::where('private', $private)->where('alone', 1)->select()->toArray(); //所有独立数据站点，不包含独立管理的站 private为0的
        $catid = $this->request->param('id/d', 0);
        $catSites = getCategory($catid,'sites'); //当前栏目所属站点
        if($catSites){
            $whereIn  = " id in($catSites)";
        }
        $site  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->select()->toArray(); // 当前站点
        $this->site = $site;
        $this->assign([
            'site'  => $site,
            'sites' => $sites,
            'isall' => $siteAdmin,
            'private' => $private,
        ]);
        // 20200805 马博 end

    }

    //栏目列表

    public function index()
    {
        $url_mode  = isset(cache("Cms_Config")['site_url_mode']) ? cache("Cms_Config")['site_url_mode'] : 1;
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $models     = cache('Model');
            $tree       = new \util\Tree();
            $tree->icon = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $categorys  = [];
            $whereSite  = '';
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
            $siteId  = onSite();
            $siteUrl = onSiteUrl();
            $private = onPrivate();
            //所有站 或 站点独立管理为否时 $private为假 显示 private为0的所有栏目 否则显示 显示 private为1的栏目 20211222
            $result  = Db::name('category')->where('private', $private )->where($where)->where($whereSite)->order('listorder DESC, id DESC')->select();
            foreach ($result as $k => $v) {
                if (isset($models[$v['modelid']]['name'])) {
                    $v['modelname'] = $models[$v['modelid']]['name'];
                } else {
                    $v['modelname'] = '单页';
                }
                $v['catname'] = '<a data-width="900" data-height="600" data-open="' . url('edit', ['id' => $v['id']]) . '"">' . $v['catname'] . '</a>';
                $onCatname = '';
                if($siteId){ //显示当前名称
                    $v['onCatname']  = Db::name('category_data')->where('catid', $v['id'])->where('site_id', $siteId )->value('catname');
                } else { //显示已推送站点
                    $sites           = Db::name('category_data')->where('catid', $v['id'])->field('site_id as id')->select();
                    $v['onCatname']       = array_column($sites,'id');
                }
                if ($v['type'] == 1) {
                    $v['add_url'] = url("Category/singlepage", ["parentid" => $v['id']]);
                } elseif ($v['type'] == 2) {
                    $v['add_url'] = url("Category/add", ["parentid" => $v['id']]);
                }
                $cat = $url_mode == 1 ? $v['id'] : $v['catdir'];
                if (!$v['url']){
                    $v['url']    = $siteUrl.buildCatUrl($cat, $v['url']);
                }
                $categorys[$v['id']] = $v;
            }
            $tree->init($categorys);
            $_list  = $tree->getTreeList($tree->getTreeArray(0), 'catname');
            $total  = count($_list);
            $result = ["code" => 0, "count" => $total, "data" => $_list];
            return json($result);
        }
        return $this->fetch();
    }

    //新增栏目
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (empty($data)) {
                $this->error('添加栏目数据不能为空！');
            }
            switch ($data['type']) {
                //单页
                case 1:
                    $fields = ['parentid', 'catname', 'catdir', 'english', 'type', 'private', 'image', 'icon', 'description', 'url', 'setting', 'listorder', 'letter', 'sites', 'target', 'detail', 'status'];
                    $scene  = 'page';
                    break;
                //列表
                case 2:
                    $fields = ['parentid', 'catname', 'catdir', 'english', 'type', 'private', 'modelid', 'image', 'icon', 'description', 'url', 'setting', 'listorder', 'letter', 'sites', 'target', 'detail', 'status'];
                    $scene  = 'list';
                    break;
                default:
                    $this->error('栏目类型错误~');
            }
            //马博添加
            $data['sites']  = !empty($data['sites']) ? implode(',', $data['sites']) : '';
            //马博添加 end
            if ($data['isbatch']) {
                unset($data['isbatch'], $data['info']['catname'], $data['info']['catdir']);
                //需要批量添加的栏目
                $batch_add = explode(PHP_EOL, $data['batch_add']);
                if (empty($batch_add) || empty($data['batch_add'])) {
                    $this->error('请填写需要添加的栏目！');
                }
                foreach ($batch_add as $rs) {
                    if (trim($rs) == '') {
                        continue;
                    }
                    $cat             = explode('|', $rs, 2);
                    $data['catname'] = $cat[0];
                    $data['catdir']  = isset($cat[1]) ? $cat[1] : '';
                    $data['catdir']  = $this->get_dirpinyin($data['catname'], $data['catdir']);
                    $data['catdir']  = str_replace(array(" ","　","\t","\n","\r"), "", $data['catdir']);
                    $result = $this->validate($data, 'Category.' . $scene);
                    if (true !== $result) {
                        $this->error($result);
                    }

                    $catid = $this->modelClass->addCategory($data, $fields);
                    if ($catid && isset($data['priv_groupid'])) {
                        //更新会员组权限
                        model("cms/CategoryPriv")->update_priv($catid, $data['priv_groupid'], 0);
                    }

                    if ($catid && isset($data['read_groupid'])) {
                        //更新会员组权限
                        model("cms/CategoryRead")->update_read($catid, $data['read_groupid'], 0);
                    }
                }
                // 20200805 马博添加
                $this->addCategoryData($data['category_data'], $catid);
                // 20200805 马博添加 end
                $this->success("添加成功！", url("Category/index"));
            } else {
                $data['catdir'] = $this->get_dirpinyin($data['catname'], $data['catdir']);
                $result         = $this->validate($data, 'Category.' . $scene);
                if (true !== $result) {
                    $this->error($result);
                }
                $catid = $this->modelClass->addCategory($data, $fields);
                if ($catid) {
                    isset($data['priv_groupid']) && model("cms/CategoryPriv")->update_priv($catid, $data['priv_groupid'], 0);
                    isset($data['read_groupid']) && model("cms/CategoryRead")->update_read($catid, $data['read_groupid'], 0);

                    // 20220903 如果catdir重名后加-catid
                    $last = substr($data['catdir'],-1);
                    if($last == '0'){
                        $catdir = rtrim ( $data['catdir'] ,  "0" );
                        $catdir = $catdir . $catid; // 增加栏目-ID
                        //更新catdir
                        Db::name('Category')->where('id', $catid)->update(['catdir' => $catdir]);
                    }

                    $this->success("添加成功！", url("Category/index"));
                } else {
                    $error = $this->modelClass->getError();
                    $this->error($error ? $error : '栏目添加失败！');
                }
            }

        } else {
            $parentid = $this->request->param('parentid/d', 0);
            if (!empty($parentid)) {
                $Ca = getCategory($parentid);
                if (empty($Ca)) {
                    $this->error("父栏目不存在！");
                }
            }
            //输出可用模型
            $modelsdata = cache("Model");
            $models     = [];
            $whereSite = '';
            foreach ($modelsdata as $v) {
                $onSiteId = onSiteId();
                if ($v['status'] == 1 && $v['module'] == 'cms' && $v['sites'] == $onSiteId) {
                    $models[] = $v;
                }
            }
            //栏目列表 可以用缓存的方式

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

            $array = Db::name('Category')->where($whereSite)->order('listorder DESC, id DESC')->column('*', 'id');
            if (!empty($array) && is_array($array)) {
                $tree       = new \util\Tree();
                $tree->icon = ['&nbsp;&nbsp;│ ', '&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;└─ '];
                $tree->nbsp = '&nbsp;&nbsp;';
                $str        = "<option value=@id @selected @disabled>@spacer @catname</option>";
                $tree->init($array);
                $categorydata = $tree->getTree(0, $str, $parentid);
            } else {
                $categorydata = '';
            }

            $this->assign([
                'category'         => $categorydata,
                'models'           => $models,
                'tp_category'      => $this->categoryTemplate,
                'tp_list'          => $this->listTemplate,
                'tp_show'          => $this->showTemplate,
                'tp_chapter'       => $this->chapterTemplate,
                'tp_page'          => $this->pageTemplate,
                'parentid_modelid' => isset($Ca['modelid']) ? $Ca['modelid'] : 0,
            ]);
            $this->assign("Member_Group", cache("Member_Group"));
            return $this->fetch();
        }
    }

    // 20200805 马博添加
    public function addCategoryData($categoryData, $catid)
    {
        if ($categoryData) {
            foreach ($categoryData as $d) {
                if (trim($d['catname'])) {
                    $model              = new CategoryData();
                    $model->catname     = trim($d['catname']);
                    $model->description = trim($d['description']);
                    $model->detail      = trim($d['detail']);
                    $model->status      = trim($d['status']);
                    $model->setting     = json_encode($d['setting']);
                    $model->site_id     = $d['site_id'];
                    $model->catid       = $catid;
                    $model->save();
                }
            }
        }
    }
    public function updateCategoryData($categoryData, $catid)
    {
        if ($categoryData) {
            foreach ($categoryData as $d) {
                if (trim($d['catname'])) {
                    if (!empty($d['cd_id'])) {
                        $id    = intval($d['cd_id']);
                        $model = CategoryData::where(['id' => $id]);
                        $model->update(['catname' => trim($d['catname']), 'description' => trim($d['description']), 'detail' => trim($d['detail']),  'setting' => json_encode($d['setting'])]);
                    } else {
                        $model              = new CategoryData();
                        $model->catname     = trim($d['catname']);
                        $model->description = trim($d['description']);
                        $model->detail      = trim($d['detail']);
                        $model->status      = 1;
                        $model->setting     = json_encode($d['setting']);
                        $model->site_id     = $d['site_id'];
                        $model->catid       = $catid;
                        $model->save();
                    }
                }
            }
        }
    }
    // 20200805 马博添加 end

    //添加单页
    public function singlepage()
    {
        return $this->add();
    }

    //编辑栏目
    public function edit()
    {
        if ($this->request->isPost()) {
            $catid = $this->request->param('id/d', 0);
            if (empty($catid)) {
                $this->error('请选择需要修改的栏目！');
            }
            $data = $this->request->post();
            //上级栏目不能是自身
            if ($data['parentid'] == $catid) {
                $this->error('上级栏目不能是自身！');
            }
            switch ($data['type']) {
                //单页
                case 1:
                    $data['modelid'] = 0;
                    $scene           = 'page';
                    break;
                //列表
                case 2:
                    $scene = 'list';
                    break;
                default:
                    $this->error('栏目类型错误~');
            }
            $data['catdir'] = $this->get_dirpinyin($data['catname'], $data['catdir'], $catid);
            //马博添加
            $data['sites']  = !empty($data['sites']) ? implode(',', $data['sites']) : '';
            //马博添加 end
            $result         = $this->validate($data, 'Category.' . $scene);
            if (true !== $result) {
                $this->error($result);
            }
            $status = $this->modelClass->editCategory($data, ['parentid', 'catname', 'catdir', 'english', 'type', 'private', 'modelid', 'image', 'icon', 'description', 'url', 'setting', 'listorder', 'letter', 'sites', 'target', 'detail', 'status']);
            if ($status) {
                //更新会员组权限
                model("cms/CategoryPriv")->update_priv($catid, (isset($data['priv_groupid']) ? $data['priv_groupid'] : []), 0);
                model("cms/CategoryRead")->update_read($catid, (isset($data['read_groupid']) ? $data['read_groupid'] : []), 0);
                // 20200805 马博
                $this->updateCategoryData($data['category_data'], $catid);
                // 20200805 马博 end
                $this->success("修改成功！", url("Category/index"));
            } else {
                $error = $this->modelClass->getError();
                $this->error($error ? $error : '栏目修改失败！');
            }

        } else {
            $catid = $this->request->param('id/d', 0);
            $modelid = getCategory($catid, 'modelid');
            $modelType = Db::name('Model')->where('id', $modelid)->value('type');
            if (empty($catid)) {
                $this->error('请选择需要修改的栏目！');
            }
            $data    = Db::name('category')->where(['id' => $catid])->find();
            //马博添加
            $data['sites'] = explode(',', $data['sites']);
            //马博添加 end
            $setting = unserialize($data['setting']);

            //输出可用模型
            $modelsdata = cache("Model");
            $models     = [];
            foreach ($modelsdata as $v) {
                if ($v['status'] == 1 && $v['module'] == 'cms') {
                    $models[] = $v;
                }
            }
            //栏目列表 可以用缓存的方式
            // 获取当前管理所属站点
            $sites = $this->auth->sites;
            $whereSite = '';
            if($sites){
                $site  = [];
                foreach (explode(',', $sites) as $k => $v) {
                    $site[] = "FIND_IN_SET('" . $v . "', sites)";
                }
                if ($site) {
                    $whereSite = "  (" . implode(' OR ', $site) . ")";
                }
            }
            $array = Db::name('Category')->where($whereSite)->order('listorder DESC, id DESC')->column('*', 'id');
            if (!empty($array) && is_array($array)) {
                $tree       = new \util\Tree();
                $tree->icon = ['&nbsp;&nbsp;│ ', '&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;└─ '];
                $tree->nbsp = '&nbsp;&nbsp;';
                $str        = "<option value=@id @selected @disabled>@spacer @catname</option>";
                $tree->init($array);
                $categorydata = $tree->getTree(0, $str, $data['parentid']);
            } else {
                $categorydata = '';
            }
            // 20200805 马博
            $siteArray = Site::where(['alone' => 1])->select()->toArray();

            $categoryData = CategoryData::where(['catid' => $catid])->select()->toArray();

            $ret = [];

            foreach ($this->site as $k => $s) {
                if ($categoryData) {
                    foreach ($categoryData as $e) {
                        if ($e['site_id'] == $s['id']) {
                            $ret[$k] = $e;
                            $ret[$k]['setting'] = json_decode((string)$ret[$k]['setting'],true);
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                        }
                    }
                } else {
                    $ret[$k]['site_id'] = $s['id'];
                }
            }
            $this->assign([
                'category_data' => $ret,
                'data'        => $data,
                'setting'     => $setting,
                'category'    => $categorydata,
                'models'      => $models,
                'modelType'   => $modelType,
                'tp_category' => $this->categoryTemplate,
                'tp_list'     => $this->listTemplate,
                'tp_show'     => $this->showTemplate,
                'tp_chapter'  => $this->chapterTemplate,
                'tp_page'     => $this->pageTemplate,
                'privs'       => model("cms/CategoryPriv")->where('catid', $catid)->select(),
                'reads'       => model("cms/CategoryRead")->where('catid', $catid)->select(),
            ]);
            // 20200805 马博 end
            //会员组
            $this->assign("Member_Group", cache("Member_Group"));
            if ($data['type'] == 1) {
                //单页栏目
                return $this->fetch("singlepage_edit");
            } else {
                if ($data['type'] == 2) {
                    //外部栏目
                    return $this->fetch();
                } else {
                    $this->error('栏目类型错误！');
                }
            }
        }

    }

    //删除栏目
    public function del()
    {
        $ids = $this->request->param('id/a', null);
        if (empty($ids)) {
            $this->error('参数错误！');
        }
        if (!is_array($ids)) {
            $ids = [0 => $ids];
        }
        try {
            foreach ($ids as $id) {
                $this->modelClass->deleteCatid($id);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        $this->cache();
        $this->success("栏目删除成功！", url('cms/category/public_cache'));
    }

    //栏目授权
    public function cat_priv()
    {
        $act = $this->request->param('act');
        $id  = $this->request->param('id');
        if ($act == 'authorization') {
            if (empty($id)) {
                $this->error('请指定需要授权的角色！');
            }
            if ($this->request->isAjax()) {
                $data = $this->request->post();
                $priv = [];
                if (isset($data['priv'])) {
                    foreach ($data['priv'] as $k => $v) {
                        foreach ($v as $e => $q) {
                            $priv[] = ["roleid" => $id, "catid" => $k, "action" => $q, "is_admin" => 1];
                        }
                    }
                    Db::name("CategoryPriv")->where("roleid", $id)->delete();
                    Db::name("CategoryPriv")->insertAll($priv);
                    $this->success("栏目授权成功！");
                } else {
                    $this->error('请指定需要授权的栏目！');
                }

            } else {
                $tree          = new \util\Tree();
                $tree->icon    = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
                $tree->nbsp    = '&nbsp;&nbsp;&nbsp;';
                $category_priv = Db::name('CategoryPriv')->where("roleid", $id)->select();
                $priv          = [];
                foreach ($category_priv as $k => $v) {
                    $priv[$v['catid']][$v['action']] = true;
                }
                $categorys = Db::name('category')->order('listorder DESC, id DESC')->select();
                foreach ($categorys as $k => $v) {
                    if ($v['type'] == 1 || $v['child']) {
                        $v['disabled']        = 'disabled';
                        $v['init_check']      = '';
                        $v['add_check']       = '';
                        $v['delete_check']    = '';
                        $v['listorder_check'] = '';
                        $v['move_check']      = '';
                        $v['edit_check']      = '';
                        $v['status_check']    = '';
                    } else {
                        $v['disabled']        = '';
                        $v['add_check']       = isset($priv[$v['id']]['add']) ? 'checked' : '';
                        $v['delete_check']    = isset($priv[$v['id']]['delete']) ? 'checked' : '';
                        $v['listorder_check'] = isset($priv[$v['id']]['listorder']) ? 'checked' : '';
                        $v['move_check']      = isset($priv[$v['id']]['remove']) ? 'checked' : '';
                        $v['edit_check']      = isset($priv[$v['id']]['edit']) ? 'checked' : '';
                        $v['status_check']    = isset($priv[$v['id']]['status']) ? 'checked' : '';
                    }
                    $v['init_check'] = isset($priv[$v['id']]['init']) ? 'checked' : '';
                    $categorys[$k]   = $v;
                }
                $str = "<tr>
    <td align='center'><input type='checkbox'  value='1' data-name='@id' lay-skin='primary'></td>
    <td>@spacer@catname</td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @init_check  lay-skin='primary' value='init' ></td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @disabled @add_check lay-skin='primary' value='add' ></td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @disabled @edit_check lay-skin='primary' value='edit' ></td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @disabled @delete_check  lay-skin='primary' value='delete' ></td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @disabled @listorder_check lay-skin='primary' value='listorder' ></td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @disabled @status_check lay-skin='primary' value='status' ></td>
    <td align='center'><input type='checkbox' name='priv[@id][]' @disabled @move_check lay-skin='primary' value='remove' ></td>
            </tr>";
                $tree->init($categorys);
                $categorydata = $tree->getTree(0, $str);
                $this->assign("categorys", $categorydata);
                return $this->fetch('authorization');
            }
        } elseif ($act == 'remove') {
            Db::name('CategoryPriv')->where('roleid', $id)->delete();
            $this->success('删除成功！');
        }
        if ($this->request->isAjax()) {
            $priv_num      = [];
            $category_priv = Db::name('CategoryPriv')->field("count(*) as num,roleid")->group("roleid")->select();
            foreach ($category_priv as $k => $v) {
                $priv_num[$v['roleid']] = $v['num'];
            }
            $_list = Db::name('AuthGroup')->where('status', 1)->order('id', 'desc')->field('id,title')->select();
            foreach ($_list as $k => $v) {
                $_list[$k]['admin'] = $v['id'] == 1;
                $_list[$k]['num']   = isset($priv_num[$v['id']]) ? $priv_num[$v['id']] : 0;
            }
            $result = ["code" => 0, "data" => $_list];
            return json($result);
        } else {
            $cmsConfig = cache("Cms_Config");
            $this->assign("cmsConfig", $cmsConfig);
            return $this->fetch();
        }
    }

    //更新栏目缓存并修复
    public function public_cache()
    {
        $this->repair();
        $this->cache();
        $this->success("更新缓存成功！", Url("cms/category/index"));

    }

    //清除栏目缓存
    protected function cache()
    {
        cache('Category', null);
    }

    //修复栏目数据
    private function repair()
    {
        //取出需要处理的栏目数据
        $categorys = Db::name('Category')->order('listorder DESC, id DESC')->column('*', 'id');
        if (empty($categorys)) {
            return true;
        }
        if (is_array($categorys)) {
            foreach ($categorys as $catid => $cat) {
                //获取父栏目ID列表
                $arrparentid = (string) $this->modelClass->get_arrparentid($catid);
                //栏目配置信息反序列化
                //$setting = unserialize($cat['setting']);
                //获取子栏目ID列表
                $arrchildid = (string) $this->modelClass->get_arrchildid($catid);
                $child      = is_numeric($arrchildid) ? 0 : 1; //是否有子栏目
                //检查所有父id 子栏目id 等相关数据是否正确，不正确更新
                if ($cat['arrparentid'] != $arrparentid || $cat['arrchildid'] != $arrchildid || $cat['child'] != $child) {
                    Db::name('Category')->where('id', $catid)->update(['arrparentid' => $arrparentid, 'arrchildid' => $arrchildid, 'child' => $child]);
                }
                \think\facade\Cache::rm('getCategory_' . $catid, null);
                //删除在非正常显示的栏目
                if ($cat['parentid'] != 0 && !isset($categorys[$cat['parentid']])) {
                    $this->modelClass->deleteCatid($catid);
                }
            }
        }
        return true;
    }

    //重新统计栏目信息数量
    public function count_items()
    {
        $result      = Db::name('Category')->order('listorder DESC, id DESC')->select();
        $model_cache = cache("Model");
        foreach ($result as $r) {
            if ($r['type'] == 2) {
                $modelid = $r['modelid'];
                if (isset($model_cache[$modelid])) {
                    $number = Db::name(ucwords($model_cache[$modelid]['tablename']))->where('catid', $r['id'])->count();
                    Db::name('Category')->where('id', $r['id'])->update(['items' => $number]);
                } else {
                    Db::name('Category')->where('id', $r['id'])->update(['items' => 0]);
                }

            }
        }
        $this->success("栏目数量校正成功！");
    }

    public function multi()
    {
        $id = $this->request->param('id/d');
        cache('Category', null);
        getCategory($id, '', true);
        return parent::multi();
    }

    //获取栏目的拼音
    private function get_dirpinyin($catname = '', $catdir = '', $id = 0)
    {
        $pinyin = new \Overtrue\Pinyin\Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        if (empty($catdir)) {
            $catdir = $pinyin->permalink($catname, '-');
            $catdir = strtolower($catdir);//强制小写
        }
        if (strval(intval($catdir)) == strval($catdir)) {
           //$catdir .= genRandomString(3);
           $catdir = $catdir .'-'. $id; // 增加栏目-ID
        }
        $map = [
            ['catdir', '=', $catdir],
        ];
        if (intval($id) > 0) {
            $map[] = ['id', '<>', $id];
        }
        $result = Db::name('Category')->field('id')->where($map)->find();
        if (!empty($result)) {
            //$nowDirname = $catdir . genRandomString(3);
            $nowDirname = $catdir .'-'. $id; // 增加栏目-ID
            return $this->get_dirpinyin($catname, $nowDirname, $id);
        }
        return $catdir;
    }

    //动态根据模型ID加载栏目模板
    public function public_tpl_file_list()
    {
        $id   = $this->request->param('id/d');
        $data = Db::name('Model')->where('id', $id)->find();
        if ($data) {
            $json = ['code' => 0, 'data' => unserialize($data['setting']),'type'=>$data['type']];
            return json($json);
        }
    }

}
