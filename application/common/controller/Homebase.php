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
        $domain = isset(cache("Cms_Config")['domain']) ? cache("Cms_Config")['domain'] : 1;
        if (empty($domain)){
            $domain     = $_SERVER['HTTP_HOST'];
        }
        $count = Site::where("domain='{$domain}'")->cache(60)->count();
        if ($count > 1) {
            $sameSite = Site::where("domain='{$domain}'")->select()->cache(60)->toArray();
            $allSite  = Site::where("domain!='{$domain}'")->select()->cache(60)->toArray();
        } else {
            $allSite  = Site::select()->toArray();
        }
        if (getSite('alone')!=1){
            $siteName = getSite('name');
            $siteId   = 1;
        }else{
            $siteName = '';
            $siteId   = getSite('id');
        }

        $lang = Db::name('lang_data')->alias('ld')
            ->join('lang l','l.id=ld.lang_id')
            ->where('l.group',1)
            ->where('ld.site_id',$siteId)
            ->cache(60)
            ->column('ld.value','l.name');

        $userLang = Db::name('lang_data')->alias('ld')
            ->join('lang l','l.id=ld.lang_id')
            ->where('l.group',2)
            ->where('ld.site_id',$siteId)
            ->cache(60)
            ->column('ld.value','l.name');
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
            'sameSite' => $sameSite,
            'allSite'  => $allSite,
            'siteName' => $siteName,
            'siteId'   => $siteId,
            'lang'     => $lang,
            'userLang' => $userLang,
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
