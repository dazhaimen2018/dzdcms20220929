<?php

/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 */
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
        $sites    = $this->auth->sites;
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
        return $this->error(tipsText());
    }



    //添加信息

    public function add()
    {
        return $this->error(tipsText());
    }


    //编辑信息
    public function edit()
    {
        return $this->error(tipsText());
    }

    //编辑信息
    public function push()
    {
        return $this->error(tipsText());
    }

    //删除
    public function del()
    {
        return $this->error(tipsText());
    }

    //移动文章
    public function remove()
    {
        return $this->error(tipsText());
    }

    protected function getAdminPostData($date = '')
    {
        return $this->error(tipsText());
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
