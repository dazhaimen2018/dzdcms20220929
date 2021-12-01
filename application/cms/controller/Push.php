<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/12/1
 * 栏目管理
 */
namespace app\cms\controller;

use addons\translator\Translator;
use app\cms\model\CategoryData;
use app\cms\model\Cms as Cms_Model;
use app\cms\model\Lang as Lang_Model;
use app\cms\model\LangData;

use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\Db;

class Push extends Adminbase
{
    protected $modelClass = null;
    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
        // 20200805 马博所有站点
        $siteIds   = $this->auth->sites;
        $whereIn   = '';
        $whereSite = '';
        if ($siteIds) {
            $whereSite = " id = $siteIds";
        }else{
            if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
                $sites     = cache("Cms_Config")['site'];
                if(!$sites){ //不满条件
                    $this->error('请在CMS配置-切换站点中选一个站！','cms/setting/index');
                }
                $whereSite = " id = $sites";
            }
        }
        $catid    = $this->request->param('catid/d', 0);
        $catSites = getCategory($catid,'sites'); //当前栏目所属站点

        if($catSites){
            $whereIn  = " id in($catSites)";
        }
        $sites  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->select()->toArray();
        $this->site = $sites;
        $this->view->assign('sites', $sites);
        // 20200805 马博 end
    }


    //栏目推送并翻译
    public function category()
    {
        return $this->error(tipsText());
    }


    //推送并翻译 cms
    public function cms()
    {
        return $this->error(tipsText());
    }


    //编辑配置
    public function lang()
    {
        return $this->error(tipsText());
    }


    //章节推送
    public function chapter()
    {
        return $this->error(tipsText());
    }


}
