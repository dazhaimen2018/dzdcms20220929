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
// | 友情链接管理
// +----------------------------------------------------------------------
namespace app\links\controller;

use app\cms\model\Site as SiteModel;
use app\common\controller\Adminbase;
use app\links\model\Links as LinksModel;
use think\Db;

/**
 * 友情链接管理
 */
class Links extends Adminbase
{
    protected $modelClass    = null;
    protected $modelValidate = true;

    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new LinksModel;
    }

    /**
     * 新增友情链接
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //验证器
            $result = $this->validate($data, 'links');
            if (true !== $result) {
                $this->error($result);
            }
            if (true !== $result) {
                $this->error($result);
            }
            if (!empty($data['terms']['name'])) {
                $data['termsid'] = $this->addTerms($data['terms']['name']);
            }
            //马博添加
            $data['sites']  = !empty($data['sites']) ? implode(',', $data['sites']) : '';
            //马博添加 end
            $status = $this->modelClass->allowField(true)->save($data);
            if ($status) {
                $this->success("添加成功！", url("links/index"));
            } else {
                $this->error("添加失败！");
            }
        } else {
            $Terms = Db::name('Terms')->where(["module" => "links"])->select();
            $siteArray = SiteModel::where("status=1")->select()->toArray();
            $this->assign([
                'siteArray' => $siteArray,
                'Terms'     => $Terms,
            ]);
            return $this->fetch();
        }
    }

    /**
     * 编辑友情链接
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //验证器
            $result = $this->validate($data, 'links');
            if (true !== $result) {
                $this->error($result);
            }
            if (!empty($data['terms']['name'])) {
                $data['termsid'] = $this->addTerms($data['terms']['name']);
            }
            //马博添加
            $data['sites']  = !empty($data['sites']) ? implode(',', $data['sites']) : '';
            //马博添加 end
            $status = $this->modelClass->allowField(true)->save($data, ['id' => $data['id']]);
            if ($status) {
                $this->success("编辑成功！", url("links/index"));
            } else {
                $this->error("编辑失败！");
            }

        } else {
            $id   = $this->request->param('id', 0);
            $data = $this->modelClass->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该信息不存在！");
            }
            //马博添加
            $data['sites'] = explode(',', $data['sites']);
            //马博添加 end
            $Terms = Db::name('Terms')->where(["module" => "links"])->select();
            $siteArray = SiteModel::where("status=1")->select()->toArray();
            $this->assign([
                'siteArray' => $siteArray,
                'Terms'     => $Terms,
                'data'      => $data,
            ]);
            // 20200620 end 马博
            return $this->fetch();
        }
    }

    //分类管理
    public function terms()
    {
        if ($this->request->isAjax()) {
            $_list  = Db::name('Terms')->where("module", "links")->select();
            $total  = count($_list);
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        return $this->fetch();
    }

    //分类编辑
    public function termsedit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post('');
            if (Db::name('Terms')->update($data) !== false) {
                $this->success("更新成功！", url("links/links/terms"));
            } else {
                $this->error("更新失败！");
            }
        } else {
            $id   = $this->request->param('id/d', 0);
            $info = Db::name('Terms')->where(["id" => $id, "module" => "links"])->find();
            if (!$info) {
                $this->error("该分类不存在！");
            }
            $this->assign('data', $info);
            return $this->fetch();
        }
    }

    /**
     * 添加分类
     * @param type $name
     */
    protected function addTerms($name)
    {
        $name = trim($name);
        if (empty($name)) {
            $this->error("分类名称不能为空！");
        }
        $count = Db::name('Terms')->where(["name" => $name, "module" => "links"])->count();
        if ($count > 0) {
            $this->error("该分类已经存在！");
        }
        $TermsId = Db::name('Terms')->insertGetId(["name" => $name, "module" => "links"]);
        if ($TermsId) {
            return $TermsId;
        } else {
            $this->error("分类添加失败！");
        }
    }

    //分类删除
    public function termsdelete()
    {
        $id = $this->request->param('id/d', 0);
        if (Db::name('Terms')->where(["id" => $id, "module" => "links"])->delete()) {
            Db::name('Links')->where(["termsid" => $id])->delete();
            $this->success("分类删除成功！");
        } else {
            $this->error("分类删除失败！");
        }
    }

}
