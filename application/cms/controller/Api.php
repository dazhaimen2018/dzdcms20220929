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
// | cms管理
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
            $_list = db($table)->where($param,$value)->order('listorder DESC, id DESC')->select();
            $total  = db($table)->where($param,$value)->count();
        }

        $result = array("code" => 0, "count" => $total, "data" => $_list);
        return json($result);
    }

}
