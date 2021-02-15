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
// | 评论管理
// +----------------------------------------------------------------------
namespace app\comments\controller;

use app\admin\model\Module as Module_Model;
use app\comments\model\Comments as Comments_Model;
use app\common\controller\Adminbase;

class Comments extends Adminbase
{

    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new Comments_Model;
    }

    //显示全部评论
    public function index()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $total                      = $this->modelClass->where($where)->where('approved', 1)->count();
            $list                       = $this->modelClass->page($page, $limit)->where($where)->where('approved', 1)->withAttr('create_time', function ($value, $data) {
                return date('Y-m-d H:i:s', $value);
            })->order('id', 'desc')->select()->toArray();
            $result = array("code" => 0, "count" => $total, "data" => $list);
            return json($result);
        } else {
            return $this->fetch();
        }
    }

    //待审核评论列表
    public function check()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $total                      = $this->modelClass->where($where)->where('approved', 0)->count();
            $list                       = $this->modelClass->page($page, $limit)->where($where)->where('approved', 0)->order('id', 'desc')->withAttr('create_time', function ($value, $data) {
                return date('Y-m-d H:i:s', $value);
            })->select()->toArray();
            $result = array("code" => 0, "count" => $total, "data" => $list);
            return json($result);
        } else {
            return $this->fetch();
        }
    }

    //评论编辑
    public function edit()
    {

    }

    //删除评论
    public function del()
    {
        $ids = $this->request->param('ids/a', null);
        if (empty($ids)) {
            $this->error('参数错误！');
        }
        if (false !== $this->modelClass->deleteComments($ids)) {
            $this->success("评论删除成功！");
        } else {
            $this->error("评论删除失败！");
        }
    }

    //垃圾评论也就是取消审核
    public function spamcomment()
    {
        $id = $this->request->param('id/d', 0);
        if (!$id) {
            $this->error("参数有误！");
        }
        $r = $this->modelClass->where("id", $id)->find();
        if ($r) {
            $approved = ((int) $r['approved'] == 1) ? 0 : 1;
            if (false !== $this->modelClass->checkComments($id, $approved)) {
                if ($approved) {
                    $this->success("评论审核成功！");
                } else {
                    $this->success("评论取消审核成功！");
                }
            } else {
                $this->error('操作失败！');
            }
        } else {
            $this->error("该评论不存在！");
        }
    }

    //评论配置
    public function config()
    {
        if ($this->request->isPost()) {
            $setting         = $this->request->param('setting/a');
            $data['setting'] = serialize($setting);
            if (Module_Model::update($data, ['module' => 'comments'])) {
                $this->success("更新成功！");
            } else {
                $this->success("更新失败！");
            }
        } else {
            $setting = Module_Model::where('module', 'comments')->value("setting");
            $this->assign("setting", unserialize($setting));
            return $this->fetch();
        }
    }
}
