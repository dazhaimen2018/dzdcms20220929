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
// | CMS路由
// +----------------------------------------------------------------------
Route::group('/', function () {
    if (isset(cache("Cms_Config")['site_cat_url']) && 1 == cache("Cms_Config")['site_cat_url']) {
        $slash  = '/';
    }else{
        $slash  = '';
    }
    if (isset(cache("Cms_Config")['web_site_guide']) && 1 == cache("Cms_Config")['web_site_guide']) {
        Route::rule('', 'cms/index/default');
    }else{
        Route::rule('', 'cms/index/index');
    }
    Route::rule('default', 'cms/index/default');
    Route::rule('index', 'cms/index/index');
    Route::rule('lists/:catid/[:condition]'.$slash, 'cms/index/lists')->pattern(['catid' => '\d+', 'condition' => '[0-9_&=a-zA-Z]+']);
    Route::rule('shows/:catid/:id', 'cms/index/shows')->pattern(['catid' => '\d+', 'id' => '\d+']);
    Route::rule('chapter/:catid/:did/:id', 'cms/index/chapter')->pattern(['catid' => '\d+', 'did' => '\d+', 'id' => '\d+']);
    Route::rule('search', 'cms/index/search');
    Route::rule('tag/[:tagdir]', 'cms/index/tags');
    if (isset(cache("Cms_Config")['site_url_mode']) && 2 == cache("Cms_Config")['site_url_mode']) {
        Route::rule('admin', 'admin/index/index');//如去除c/ d/ 需要解开此注释
        if (isset(cache("Cms_Config")['show_url_mode']) && 1 == cache("Cms_Config")['show_url_mode']) {
            Route::rule(':catdir/:diyurl', 'cms/index/shows')->pattern(['catdir' => '[A-Za-z0-9\-\_]+', 'diyurl' => '[A-Za-z0-9\-\_]+']);
        }else{
            Route::rule(':catdir/:id', 'cms/index/shows')->pattern(['catdir' => '[A-Za-z0-9\-\_]+', 'id' => '\d+']);
        }
        Route::rule(':catdir/:id', 'cms/index/shows')->pattern(['catdir' => '[A-Za-z0-9\-\_]+', 'id' => '\d+']);
        Route::rule(':catdir/[:condition]'.$slash, 'cms/index/lists')->pattern(['catdir' => '[A-Za-z0-9\-\_]+', 'condition' => '[0-9_&=a-zA-Z]+']);
    }

});
