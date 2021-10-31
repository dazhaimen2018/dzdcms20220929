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

    /**
     * 高级下拉菜单url 同模型所有栏目
     * url:/api/lists/category // 同模型的所有栏目  /api/lists/category/modelid/2 其他模型的ID
     * field:catname
     * key:id
     * pagination:true
     * page_size:10
     * multiple:true
     * max:10
     * order:id
     */

    public function category(){
        $modelid = $this->request->param('modelid/d', 0);
        $catid = $this->request->param('catid/d', 0);
        if (!$modelid){
            $catCache  = cache('catCache'); //从缓存中得到模型ID
            $modelid   = $catCache['modelid'];
            $catid     = $catCache['catid'];
            //相同模型并且不含当前栏目并且是终极栏目
            $wheres = 'modelid =' . $modelid .' AND child = 0 AND id <>' . $catid;
        } else {
            $wheres = 'modelid =' . $modelid;
        }
        $this->modelClass = Db::name('category');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage($wheres);
        }
    }

    //高级下拉菜单url 会员级别
    public function memberGroup(){
        $wheres = '' ;
        $this->modelClass = Db::name('member_group');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage($wheres);
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
