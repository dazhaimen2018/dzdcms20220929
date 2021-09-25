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
// | 语言管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\Adminbase;
use app\admin\model\Language as LanguageModel;
use think\Db;

class Language extends Adminbase
{
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new LanguageModel;
    }

    public function index()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $_list                      = $this->modelClass->where($where)->page($page, $limit)->select();
            $total                      = $this->modelClass->where($where)->count();
            $result                     = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->post('');
            $result = $this->validate($data, 'Language');
            if (true !== $result) {
                return $this->error($result);
            }

            if ($this->modelClass->createLanguage($data)) {
                $this->success("语言添加成功！", url('admin/language/index'));
            } else {
                $error = $this->modelClass->getError();
                $this->error($error ? $error : '添加失败！');
            }

        } else {
            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post('');
            $result = $this->validate($data, 'Language');
            if (true !== $result) {
                return $this->error($result);
            }

            if ($this->modelClass->editLanguage($data)) {
                $info = $this->modelClass->where("id", $data['id'])->find();
                $this->success("修改成功！");
            } else {
                $this->error('修改失败！');
            }
        } else {
            $id = $this->request->param('id/d');
            $data = $this->modelClass->where("id", $id)->find();
            if (empty($data)) {
                $this->error('该语言不存在！');
            }
            $this->assign("data", $data);
            return $this->fetch();
        }
    }

    public function del()
    {
        //字段ID
        $id = $this->request->param('id/d', '');
        if (empty($id)) {
            $this->error('请指定需要删除的语言ID！');
        }
        if ($id == 1) {
            $this->error('禁止对默认语言执行该操作！');
        }

        if (Db::name('language')->where(["id" => $id])->delete()) {
            $this->success("语言删除成功！");
        } else {
            $this->error("分类删除失败！");
        }
    }


}
