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
// | 后台常用ajax
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\Adminbase;
use think\Db;

class Ajax extends Adminbase
{
    //过滤内容的敏感词
    public function filterWord($content)
    {
        $content = $this->request->post('content');
        // 获取感词库文件路径
        $wordFilePath = ROOT_PATH . 'data/words.txt';
        $handle       = \util\SensitiveHelper::init()->setTreeByFile($wordFilePath);
        $word         = $handle->getBadWord($content);
        if ($word) {
            $this->error('内容包含违禁词！', null, $word);
        } else {
            $this->success('内容没有违禁词！');
        }
    }

    /**
     * 生成后缀图标
     */
    public function icon()
    {
        $suffix = $this->request->request("suffix");
        header('Content-type: image/svg+xml');
        $suffix = $suffix ? $suffix : "FILE";
        echo build_suffix_image($suffix);
        exit;
    }

    /**
     * 高级下拉菜单url 同模型所有栏目
     * url:/admin/ajax/category // 同模型的所有栏目  /admin/ajax/category/modelid/2 其他模型的ID
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
        if (!$modelid){ //同步发布
            $catCache  = cache('catCache'); //从缓存中得到模型ID
            $modelid   = $catCache['modelid'];
            $catid     = $catCache['catid'];
            //相同模型并且不含当前栏目并且是终极栏目
            $wheres = 'modelid =' . $modelid .' AND child = 0 AND id <>' . $catid;
        } else {
            //关联其他模型栏目
            $wheres = 'modelid =' . $modelid .' AND child = 0';
        }
        $this->modelClass = Db::name('category');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage($wheres);
        }
    }

    /**
     * 高级下拉菜单url 会员级别
     */

    public function memberGroup(){
        $wheres = '' ;
        $this->modelClass = Db::name('member_group');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage($wheres);
        }
    }

    /**
     * 高级下拉菜单url 会员列表
     */

    public function member(){
        $wheres = '' ;
        $this->modelClass = Db::name('member');
        //如果发送的来源是Selectpage，则转发到Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage($wheres);
        }
    }

    /**
     * 高级下拉菜单url 专题列表
     */

    public function special(){
        $wheres = '' ;
        $this->modelClass = Db::name('special');
        if ($this->request->request('keyField')) {
            return $this->selectpage($wheres);
        }
    }

    /**
     *  获取标题拼音
     */

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
