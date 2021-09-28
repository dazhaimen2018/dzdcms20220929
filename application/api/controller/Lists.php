<?php
// +----------------------------------------------------------------------
// | dzdcms [ 多站点CMS高级下拉框URL ]
// +----------------------------------------------------------------------
namespace app\api\controller;

use app\common\controller\Adminbase;
use think\Db;


class Lists extends Adminbase
{
    protected function initialize()
    {
        parent::initialize();

    }

    //高级下拉菜单url 选点站栏目
    public function category(){
        $catid = $this->request->param('catid/d', 0);
        $this->modelClass = Db::name('category');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage();
        }

    }

    //高级下拉菜单url 会员级别
    public function memberGroup(){
        $this->modelClass = Db::name('member_group');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage();
        }

    }

}
