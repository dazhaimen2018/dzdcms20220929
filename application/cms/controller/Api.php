<?php
// +----------------------------------------------------------------------
// | dzdcms [ 多站点CMS ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Dzdcms <8355763@qq.com>
// +----------------------------------------------------------------------
namespace app\cms\controller;

use app\common\controller\Adminbase;
use think\Db;


class Api extends Adminbase
{
    protected function initialize()
    {
        parent::initialize();

    }

    //高级下拉菜单url
    //url格式：url:/cms/api/index/table/category/param/parentid/value/1
    //field:catname
    //key:id
    //pagination:true
    //page_size:20
    //multiple:false
    //max:10
    //order:id
    public function  index(){
        $table = $this->request->param('table/s', 0);
        $param = $this->request->param('param/s', 0);
        $value = $this->request->param('value/s', 0);
        if ($value){
            $list  = db($table)->where($param,$value)->order('listorder DESC, id DESC')->select();
            $total = db($table)->where($param,$value)->count();
        }
        $result = array("code" => 0, "count" => $total, "data" => $list);
        return json($result);
    }

}
