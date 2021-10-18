<?php
// +----------------------------------------------------------------------
// | dzdcms [ 多站点CMS高级下拉框URL ]
// +----------------------------------------------------------------------
namespace app\api\controller;

use app\common\controller\Adminbase;
use think\Db;

// +----------------------------------------------------------------------
// | dzdcms [ 多站点CMS后端数据调用]
// +----------------------------------------------------------------------

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

    //获取标题拼音
    public function getTitlePinyin()
    {
        $config = isset(cache("Cms_Config")['show_url_mode']) && 1 == cache("Cms_Config")['show_url_mode'];
        $title = $this->request->post("title");
        //分隔符
        $delimiter = $this->request->post("delimiter", "");
        $pinyin = new \Overtrue\Pinyin\Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        if ($title) {
            if ($config) {
                $result = $pinyin->permalink($title, $delimiter);
                $this->success("", null, ['pinyin' => $result]);
            } else {
                $this->error();
            }
        } else {
            $this->error('标题不为能空');
        }
    }

}
