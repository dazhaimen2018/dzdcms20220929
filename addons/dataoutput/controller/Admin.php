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
// | 数据导出管理
// +----------------------------------------------------------------------
namespace addons\dataoutput\Controller;

use addons\dataoutput\library\Excel;
use addons\dataoutput\model\Output as outputModel;
use app\addons\util\Adminaddon;
use think\Db;

class Admin extends Adminaddon
{
    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new outputModel;

    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->post('data/a');
            $result = outputModel::create($data);
            if ($result) {
                $this->success("添加成功", url('index', ['isadmin' => 1]));
            } else {
                $this->error("添加失败");
            }
        } else {
            $list = Db::query('SHOW TABLE STATUS');
            $list = array_map('array_change_key_case', $list); //全部小写
            $this->assign('list', $list);
            return $this->fetch();
        }

    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->post('data/a');
            $result = outputModel::update($data);
            if ($result) {
                $this->success("编辑成功", url('index', ['isadmin' => 1]));
            } else {
                $this->error("编辑失败");
            }
        } else {
            $id = $this->request->param('id/d', 0);
            if (empty($id)) {
                $this->error('任务不存在！');
            }
            $data = outputModel::where('id', $id)->find()->toArray();
            $list = Db::query('SHOW TABLE STATUS');
            $list = array_map('array_change_key_case', $list); //全部小写

            if ($data['config'] && isset($data['config']['comment'])) {
                foreach ($data['config']['comment'] as $key => $value) {
                    $data['fields'][$key]['comment'] = $value;
                    $data['fields'][$key]['format']  = $data['config']['format'][$key];
                    $data['fields'][$key]['parm']    = $data['config']['parm'][$key];
                }
            }
            if (isset($data['join_table'])) {
                foreach ($data['join_table'] as $key => $value) {
                    if (isset($value['table'])) {
                        $data['join_table'][$key]['primary_list'] = $this->fieldlist($value['table']);
                    }
                    $arr = [];
                    if ($value['fields'] && isset($value['fields']['comment'])) {
                        foreach ($value['fields']['comment'] as $k => $vo) {
                            $arr[$k]['comment'] = $vo;
                            $arr[$k]['format']  = $value['fields']['format'][$k];
                            $arr[$k]['parm']    = $value['fields']['parm'][$k];
                        }
                    }
                    $data['join_table'][$key]['field_list'] = $arr;
                }
            } else {
                $data['join_table'] = [];
            }

            $this->assign('list', $list);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    public function output()
    {
        $id       = $this->request->param('id/d', '');
        $config   = outputModel::find($id);
        $excel    = new Excel($config);
        $fileName = iconv('UTF-8', 'GB2312', 'Task-' . $config['name'] . '-' . time());
        return $excel->exportData($fileName);
    }

    public function fieldlist($name = null)
    {
        if ($this->request->isAjax()) {
            $name = $this->request->param('tablename/s', '');
        }
        $data = Db::query("show full columns from {$name}");
        if ($this->request->isAjax()) {
            $result = array("code" => 0, "data" => $data);
            return json($result);
        } else {
            return $data;
        }
    }

}
