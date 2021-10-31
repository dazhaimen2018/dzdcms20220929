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
// | 前台控制模块
// +----------------------------------------------------------------------
namespace app\common\controller;

use app\cms\model\Site;
use app\common\controller\Base;
use think\Db;
use think\facade\Cache;
use think\facade\Config;

class Homebase extends Base
{
    //初始化
    protected function initialize()
    {
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');
        parent::initialize();
        $config = \think\facade\config::get('app.');
        $domain     = $_SERVER['HTTP_HOST'];
        $sites  = cache('sites')?cache('sites'):Site::where('status',1)->column('*','id');
        Cache::set('sites', $sites, 3600);

        //语言设定
        $mark = $sites[getSiteId()]['mark'];
        if ($mark && ($mark.'_'.getSiteId() != cookie('var'))){
            cookie('var',$mark.'_'.getSiteId());
            header('Location:'.$_SERVER['REQUEST_URI']);exit;
        }
        //$siteName 虚拟站点显示自己的站点名称 独立站不显示
        if (getSite('alone')!=1){
            $siteId   = 1;
            $siteName = $sites[$siteId]['name'];
        }else{
            $siteId   = getSite('id');
            $siteName = '';
        }


        $site   = [
            'upload_thumb_water'     => $config['upload_thumb_water'],
            'upload_thumb_water_pic' => $config['upload_thumb_water_pic'],
            'upload_image_size'      => $config['upload_image_size'],
            'upload_file_size'       => $config['upload_file_size'],
            'upload_image_ext'       => $config['upload_image_ext'],
            'upload_file_ext'        => $config['upload_file_ext'],
            'chunking'               => $config['chunking'],
            'chunksize'              => $config['chunksize'],
        ];
        $this->assign([
            'site'     => $site,
            'domain'   => $domain,
            'allSite'  => $sites,
            'siteName' => $siteName,
            'siteId'   => $siteId,
        ]);
    }

    protected function fetch($template = '', $vars = [], $config = [], $renderContent = false)
    {
        $siteTheme    = getSite('template');
        $Theme        = empty($siteTheme) ? 'default' : $siteTheme;
        $viewPath     = TEMPLATE_PATH . $Theme . DIRECTORY_SEPARATOR . $this->request->module() . DIRECTORY_SEPARATOR;
        $templateFile = $viewPath . trim($template, '/') . '.' . Config::get('template.view_suffix');
        if ('default' !== $Theme && !is_file($templateFile)) {
            $viewPath = TEMPLATE_PATH . 'default' . DIRECTORY_SEPARATOR . $this->request->module() . DIRECTORY_SEPARATOR;
        }
        $this->view->config('view_path', $viewPath);
        return $this->view->fetch($template, $vars, $config, $renderContent);
    }
}
