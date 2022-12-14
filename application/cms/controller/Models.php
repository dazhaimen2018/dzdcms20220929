<?php
/**
 * Yzncms
 * 版权所有 Yzncms，并保留所有权利。
 * Author: 御宅男 <530765310@qq.com>
 * Update: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 模型管理
 */

namespace app\cms\controller;

use app\cms\model\Models as ModelsModel;
use app\common\controller\Adminbase;
use think\facade\Cache;
use think\Db;

class Models extends Adminbase
{
    protected $modelClass = null;
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new ModelsModel;
        //取得当前内容模型模板存放目录
        $this->filepath = TEMPLATE_PATH . (empty(config('theme')) ? "default" : config('theme')) . DS . "cms" . DS;
        //取得栏目频道模板列表
        $this->tp_category = str_replace($this->filepath . DS, '', glob($this->filepath . DS . 'category*'));
        //取得栏目列表模板列表
        $this->tp_list = str_replace($this->filepath . DS, '', glob($this->filepath . DS . 'list*'));
        //取得内容页模板列表
        $this->tp_show = str_replace($this->filepath . DS, '', glob($this->filepath . DS . 'show*'));
        //取得章节页模板列表
        $this->tp_chapter = str_replace($this->filepath . DS, '', glob($this->filepath . DS . 'chapter*'));
        $agents = agents();
        $level  = $agents['level'];
        $this->assign([
            'tp_category' => $this->tp_category,
            'tp_list'     => $this->tp_list,
            'tp_show'     => $this->tp_show,
            'tp_chapter'  => $this->tp_chapter,
            'level'       => $level,
        ]);
    }

    //模型列表
    public function index()
    {
        if ($this->request->isAjax()) {
            $onSiteId = onSiteId();
            $data = $this->modelClass->where('sites', $onSiteId)->where('module', 'cms')->select();
            return json(["code" => 0, "data" => $data]);
        }
        return $this->fetch();
    }

    //添加模型
    public function add()
    {
        if ($this->request->isPost()) {
            $data    = $this->request->post();
            $private = onPrivate();
            $result  = $this->validate($data, 'Models');
            if (true !== $result) {
                return $this->error($result);
            }
            if($private){
                $siteId            = onSite();
                $data['tablename'] = $data['tablename']. '_' .$siteId;
                $data['sites']     = $siteId;
            }
            try {
                $this->modelClass->addModel($data);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('模型新增成功！', url('index'));
        } else {
            return $this->fetch();
        }
    }

    //模型修改
    public function edit()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->post();
            $result = $this->validate($data, 'Models');
            if (true !== $result) {
                return $this->error($result);
            }
            try {
                $this->modelClass->editModel($data);
                //更新缓存
                cache("Model", null);
                Cache::set('getModel_' . $data['id'], '');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('模型修改成功！', url('index'));
        } else {
            $id              = $this->request->param('id/d', 0);
            $data            = $this->modelClass->where("id", $id)->find();
            $data['setting'] = unserialize($data['setting']);
            $this->assign("data", $data);
            return $this->fetch();
        }
    }

    //模型删除
    public function del()
    {
        $id = $this->request->param('id/d');
        empty($id) && $this->error('参数不能为空！');
        //检查该模型是否已经被使用
        $r = Db::name("category")->where("modelid", $id)->find();
        if ($r) {
            $this->error("该模型使用中，删除栏目后再删除！");
        }
        try {
            $this->modelClass->deleteModel($id);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success("删除成功！", url("index"));
    }

    public function multi()
    {
        $id    = $this->request->param('id/d', 0);
        $value = $this->request->param('value/d', 0);
        try {
            $row = $this->modelClass->find($id);
            if (empty($row)) {
                $this->error('数据不存在！');
            }
            $row->status = $value;
            $row->save();
            //更新缓存
            cache("Model", null);
            Cache::set('getModel_' . $id, '');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success("操作成功！");
    }
}
