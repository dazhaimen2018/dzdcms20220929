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
// | 表情管理
// +----------------------------------------------------------------------
namespace app\comments\controller;

use app\comments\model\Emotion as Emotion_Model;
use app\common\controller\Adminbase;
use think\Db;

class Emotion extends AdminBase
{

    public $emotionPath;

    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass  = new Emotion_Model;
        $this->emotionPath = ROOT_PATH . 'public' . DS . 'static' . DS . 'modules' . DS . 'comments' . DS . 'images' . DS . 'emotion' . DS;
    }

    //表情管理
    public function index()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $total                      = $this->modelClass->where($where)->order(['listorder' => 'ASC', 'id' => 'DESC'])->count();
            $list                       = $this->modelClass->where($where)->order(['listorder' => 'ASC', 'id' => 'DESC'])->page($page, $limit)->select();
            $result                     = array("code" => 0, "count" => $total, "data" => $list);
            return json($result);
        } else {
            return $this->fetch();
        }
    }

    public function add()
    {
        $file    = new \util\File();
        $emotion = $file::listFile($this->emotionPath);
        $num     = 0;
        foreach ($emotion as $k => $v) {
            $res = Db::name('comments_emotion')->where('icon', $v['filename'])->find();
            if (!$res) {
                $num++;
                Db::name('comments_emotion')->insert(
                    [
                        'name'      => substr($v['filename'], 0, strrpos($v['filename'], ".")),
                        'icon'      => $v['filename'],
                        'listorder' => 0,
                        'status'    => 1,
                    ]
                );
            }
        }
        $num ? $this->success('导入成功！') : $this->success('没有新的表情！');
    }
}
