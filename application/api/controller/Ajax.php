<?php
// +----------------------------------------------------------------------
// | dzdcms [ 多站点CMS前端AJAX数据返回 ]
// +----------------------------------------------------------------------

namespace app\api\controller;

use app\cms\controller\Cmsbase;
use think\Db;

class Ajax extends Cmsbase
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = [];
    protected function initialize()
    {
        parent::initialize();
    }

    // 文档模型 标题搜索
    public function search()
    {
        $keyword = $this->request->param('w/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');
        $keyword = str_replace('%', '', $keyword); //过滤'%'，用户全文搜索
        $where   = "theme like '%$keyword%'";
        $list    = db('docs')->where($where)->field('id,theme as title,catid,url')->select();
        $_list   = [];
        foreach ($list as $k => $v) {
            $v['url']  =  $v['url']?$v['url']: '/'. getCategory($v['catid'],'catdir').'/'.$v['id'].'.html';
            $_list[]   = $v;
        }
        $result = array("code" => 0, "data" => $_list, "msg"=>  "success");
        return json($result);
    }

    public function doctor()
    {
        $type = $this->request->param('type/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');
        $area = $this->request->param('area/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');

        if ($type == '不限') {
            $doctors = db('doctor')->where(['area' => $area])->field('theme as name,clinic as title')->select();
        } elseif ($area == '不限') {
            $doctors = db('doctor')->where(['type' => $type])->field('theme as name,clinic as title')->select();
        } else {
            $doctors = db('doctor')->where(['type' => $type, 'area' => $area])->field('theme as name,clinic as title')->select();
        }

        return $doctors;
    }

    public function hospital()
    {
        $catid    = $this->request->param('type/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');
        $area     = $this->request->param('city/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');
        $hospital = $this->request->param('hospital/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');

        if ($catid) {
            $hospitals = db('hospital')->where(['catid' => $catid])->field('theme as company')->select();
        } elseif ($area !='不限') {
            $hospitals = db('hospital')->where(['area' => $area])->field('theme as name')->select();
        }elseif ($hospital) {
            $hospitals = db('hospital')->where(['theme' => $hospital])->field('theme as name')->select();
        }
        else {
            $hospitals = db('hospital')->where(['catid' => $catid, 'area' => $area])->field('theme as name,clinic as title')->select();
        }
        return $hospitals;
    }

}
