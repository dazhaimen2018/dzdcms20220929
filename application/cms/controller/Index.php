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

use app\cms\library\FulltextSearch;
use app\cms\model\Page;
use app\cms\model\SearchLog;
use app\cms\model\Cms as CmsModel;
use app\cms\model\Chapter;
use app\cms\model\Site;
use think\facade\Cache;
use think\Db;
use think\Session;

class Index extends Cmsbase
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = [];
    protected function initialize()
    {
        parent::initialize();
        $this->CmsModel     = new CmsModel;
        $this->ChapterModel = new Chapter;
    }

    /**
     * 首页
     */
    public function default()
    {
        $page = $this->request->param('page/d', 1);
        $seo = seo();
        $this->assign([
            'SEO'  => $seo,
            'page' => $page,
        ]);

        return $this->fetch('/default');
    }

    public function index()
    {
        $page = $this->request->param('page/d', 1);
        $seo  = seo();
        $this->assign([
            'SEO'  => $seo,
            'page' => $page,
        ]);
        return $this->fetch('/index');
    }

    // 列表页
    public function lists()
    {
        //栏目ID
        $cat = $this->request->param('catid/d', 0);
        if (empty($cat)) {
            $cat = $this->request->param('catdir/s', '');
        }
        $page = $this->request->param('page/d', 1);
        //获取栏目数据
        $category = getCategory($cat);
        if (empty($category)) {
            throw new \think\exception\HttpException(404, patch('PageNot'));
        }
        $catid = $category['id'];
        // 20211226 判断栏目的访问权限
        $readListAuth  = isset(cache("Cms_Config")['read_list_auth']) ? cache("Cms_Config")['read_list_auth'] : 1;
        $reads         = Db::name('category_read')->where(array("catid" => $catid, "is_admin" => 0, "action" => "add"))->field('roleid as id')->select();
        $roles         = array_column($reads,'id');
        if($readListAuth){
            if ($roles) {
                if (in_array($this->auth->groupid,$roles)===false) {
                    $this->error("您没有该栏目访问权限！", 'member/index/login');
                }
            }
        }
        $modelid = $category['modelid'];
        $models  = cache('Model');
        //栏目扩展配置信息
        $setting      = $category['setting'];
        $setting_data = $category['setting_data'];

        //类型为列表的栏目
        if ($category['type'] == 2) {
            //栏目首页模板
            $template      = $setting['category_template'] ? $setting['category_template'] : 'category';
            //栏目列表页模板
            $template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
            //判断使用模板类型，如果有子栏目使用频道页模板
            $template      = $category['child'] ? $template : $template_list;
            $title         =  $setting_data['title'] ? $setting_data['title'] : $category['catname'];
            $seo           = seo($catid, $title, $setting_data['description'], $setting_data['keyword']);
            //单页
        } else if ($category['type'] == 1) {
            $template = $setting['page_template'] ? $setting['page_template'] : 'page';
            $ifcache  = $this->cmsConfig['site_cache_time'] ? $this->cmsConfig['site_cache_time'] : false;
            $info     = model('Page')->getPage($catid, $ifcache, $this->$siteId );
            if ($info) {
                $info = $info->toArray();
            }
            //SEO
            $title       =  $setting_data['title'] ? $setting_data['title'] : $info['title'];
            $keywords    = $info['keywords'] ? $info['keywords'] : $setting_data['keyword'];
            $description = $info['description'] ? $info['description'] : $setting_data['description'];
            $seo         = seo($catid, $title, $description, $keywords);
            $this->assign($info);
        }
        $tpar     = explode(".", $template, 2);
        $template = $tpar[0];
        unset($tpar);
        if ($this->request->isAjax()) {
            //马博修改 ajax文件路径./public/
            $ajax = './public/' . $template . '_ajax';
            $this->success('', '', $this->fetch($ajax));
        }
        //获取顶级栏目ID
        $category['arrparentid'] = explode(',', $category['arrparentid']);
        $top_parentid            = isset($category['arrparentid'][1]) ? $category['arrparentid'][1] : $catid;
        $parentid                = $category['parentid'];
        unset($category['id']);
        $this->assign($category);
        $this->assign([
            'top_parentid' => $top_parentid,
            'parentid'     => $parentid,
            'SEO'          => $seo,
            'catid'        => $catid,
            'page'         => $page,
            'modelid'      => $modelid,
        ]);
        return $this->fetch('/' . $template);
    }

    // 内容页
    public function shows()
    {
        $id  = $this->request->param('id/d', 0);
        $cat = $this->request->param('catid/d', 0);
        if (empty($cat)) {
            $cat = $this->request->param('catdir/s', '');
        }
        if (empty($id)) {
            $diy = $this->request->param('diyurl/s', 0);
        }
        $page = $this->request->param('page/d', 1);
        $page = max(1, $page);

        //获取栏目数据
        $category = getCategory($cat);
        if (empty($category)) {
            throw new \think\exception\HttpException(404, patch('PageNot'));
        }
        $catid = $category['id'];

        //模型ID
        $modelid   = $category['modelid'];
        $modelInfo = cache('Model')[$modelid];
        if (empty($modelInfo)) {
            throw new \think\exception\HttpException(404, patch('PageNot'));
        }
        //更新点击量 获得文章ID
        //$showMode     = isset(cache("Cms_Config")['show_url_mode']) ? cache("Cms_Config")['show_url_mode'] : 1;
        $showCatMode  = isset(cache("Cms_Config")['show_cat_mode']) ? cache("Cms_Config")['show_cat_mode'] : 1;
        if (empty($id)) {
            $id = Db::name($modelInfo['tablename'])->where('diyurl', $diy)->value('id');
        }
        if ($showCatMode) {
            $catid = Db::name($modelInfo['tablename'])->where('id', $id)->value('catid');
        }
        Db::name($modelInfo['tablename'])->where('id', $id)->setInc('hits');
        //内容所有字段
        $siteId  = getSiteId();
        $ifcache = $this->cmsConfig['site_cache_time'] ? $this->cmsConfig['site_cache_time'] : false;
        $info    = $this->CmsModel->getContent($modelid, "id={$id}", true, '*', '', $ifcache, $siteId );
        //$info    = $this->CmsModel->getContent($modelid, ['catid' => $catid, 'id' => $id], true, '*', '', $ifcache, $siteId );
        //文章的阅读权限
        //20211226 判断栏目中内容的访问权限 如果栏目已经设置权限就不用再判断文章了
        $reads = Db::name('category_read')->where(array("catid" => $catid, "is_admin" => 0, "action" => "add"))->field('roleid as id')->select();
        $roles = array_column($reads,'id');
        if ($roles) {
            if (in_array($this->auth->groupid,$roles)===false) {
                $this->error("您没有该信息访问权限！", 'member/index/login');
            }
        } else {
            $groupids = $info['groupids'] ;
            if($groupids){
                $groupids = str2arr($info['groupids']) ;
                if (in_array($this->auth->groupid,$groupids)===false) {
                    $this->error("您没有该信息访问权限！", 'member/index/login');
                }
            }
        }

        if (!$info || ($info['status'] !== 1 && !\app\admin\service\User::instance()->isLogin())) {
            throw new \think\exception\HttpException(404, patch('PageError'));
        }
        //内容分页
        $paginator = strpos($info['content'], '[page]');
        if ($paginator !== false) {
            $contents = array_filter(explode('[page]', $info['content']));
            $total    = count($contents);
            $pages    = \app\cms\paginator\Page::make([], 1, $page, $total, false, ['path' => $this->request->baseUrl()]);
            //判断[page]出现的位置是否在第一位
            if ($paginator < 7) {
                $info['content'] = $contents[$page];
            } else {
                $info['content'] = $contents[$page - 1];
            }
            $this->assign("pages", $pages);
        } else {
            $this->assign("pages", '');
        }
        //栏目扩展配置信息
        $setting      = $category['setting'];
        $setting_data = $category['setting_data'];
        //内容页模板
        $template     = $setting['show_template'] ? $setting['show_template'] : 'show';
        //去除模板文件后缀
        $newstempid   = explode(".", $template);
        $template     = $newstempid[0];
        unset($newstempid);
        //阅读收费
        $readpoint     = isset($info['readpoint']) ? (int) $info['readpoint'] : 0; //金额
        $allow_visitor = 1;
        if ($readpoint > 0) {
            $paytype = isset($info['paytype']) && $info['paytype'] ? $info['paytype'] : 0;
            //检查是否支付过
            $allow_visitor = self::_check_payment($catid . '_' . $id, $paytype);
            if (!$allow_visitor) {
                //$http_referer = urlencode(\think\facade\Request::url(true));
                $allow_visitor = sys_auth($catid . '_' . $id . '|' . $readpoint . '|' . $paytype);
            } else {
                $allow_visitor = 1;
            }
        }


        //SEO
        $keywords    = $info['keywords'] ? $info['keywords'] : $setting_data['keyword'];
        $title       = $info['title'] ? $info['title'] : $info['seo_title'];
        $seoTitle    = $info['seo_title'] ? $info['seo_title'] : $info['title'];
        $description = $info['description'] ? $info['description'] : $setting_data['description'];
        $seo         = seo($catid, $seoTitle, $description, $keywords);
        //获取顶级栏目ID
        $arrparentid = explode(',', $category['arrparentid']);
        $top_parentid = isset($arrparentid[1]) ? $arrparentid[1] : $catid;
        $this->view->assign($info);
        $this->view->assign([
            'category'      => $category,
            'readpoint'     => $readpoint,
            'allow_visitor' => $allow_visitor,
            'top_parentid'  => $top_parentid,
            'arrparentid'   => $arrparentid,
            'SEO'           => $seo,
            'catid'         => $catid,
            'page'          => $page,
            'modelid'       => $modelid,
            'title'         => $title,
            'parentid'      => $id,
        ]);
        return $this->fetch('/' . $template);
    }

    // 子内容页
    public function chapter()
    {
        //ID
        $id  = $this->request->param('id/d', 0);
        $did = $this->request->param('did/d', 0);
        $cat = $this->request->param('catid/d', 0);
        if (empty($cat)) {
            $cat = $this->request->param('catdir/s', '');
        }
        $page = $this->request->param('page/d', 1);
        $page = max(1, $page);

        //获取栏目数据
        $category = getCategory($cat);
        if (empty($category)) {
            $this->error(patch('PageNot')); //栏目不存在
        }
        $catid = $category['id'];
        //模型ID
        $modelid = $category['modelid'];
        $modelInfo = cache('Model')[$modelid];
        if (empty($modelInfo)) {
            $this->error(patch('PageNot')); //模型不存在
        }
        //更新点击量 子表
        Db::name($modelInfo['tablename'].'_sub_data')->where('did', $did)->where('id', $id)->setInc('views');
        //内容所有字段
        $siteId  = getSiteId();
        $ifcache = $this->cmsConfig['site_cache_time'] ? $this->cmsConfig['site_cache_time'] : false;
        $info = $this->ChapterModel->getChapterContent($modelid, $id,"id={$did}", true, '*', '', $ifcache, $siteId);
        if (!$info || ($info['status'] !== 1 && !\app\admin\service\User::instance()->isLogin())) {
            throw new \think\Exception(patch('PageError'), 404);
        }
        //更新点击量 主表
        Db::name($modelInfo['tablename'])->where('id', $info['did'])->setInc('hits');
        //内容分页
        $paginator = strpos($info['details'], '[page]');
        if ($paginator !== false) {
            $contents = array_filter(explode('[page]', $info['details']));
            $total    = count($contents);
            $pages    = \app\cms\paginator\Page::make([], 1, $page, $total, false, ['path' => $this->request->baseUrl()]);
            //判断[page]出现的位置是否在第一位
            if ($paginator < 7) {
                $info['details'] = $contents[$page];
            } else {
                $info['details'] = $contents[$page - 1];
            }
            $this->assign("pages", $pages);
        } else {
            $this->assign("pages", '');
        }
        //栏目扩展配置信息
        $setting = $category['setting'];
        //章节页模板
        $template = $setting['chapter_template'] ? $setting['chapter_template'] : 'chapter';
        //去除模板文件后缀
        $newstempid = explode(".", $template);
        $template = $newstempid[0];
        unset($newstempid);
        //阅读收费
        $readpoint     = isset($info['readpoint']) ? (int) $info['readpoint'] : 0; //金额
        $allow_visitor = 1;
        if ($readpoint > 0) {
            $paytype = isset($info['paytype']) && $info['paytype'] ? $info['paytype'] : 0;
            //检查是否支付过
            $allow_visitor = self::_check_payment($catid . '_' . $id, $paytype);
            if (!$allow_visitor) {
                //$http_referer = urlencode(\think\facade\Request::url(true));
                $allow_visitor = sys_auth($catid . '_' . $id . '|' . $readpoint . '|' . $paytype);
            } else {
                $allow_visitor = 1;
            }
        }
        //SEO
        $keywords = $info['keywords'] ? $info['keywords'] : $setting['meta_keywords'];
        $title = $info['chapter'] ? $info['chapter'] : $setting['meta_title'];
        $description = $info['description'] ? $info['description'] : $setting['meta_description'];
        $seo = seo($catid, $title, $description, $keywords);
        //获取顶级栏目ID
        $arrparentid = explode(',', $category['arrparentid']);
        $top_parentid = isset($arrparentid[1]) ? $arrparentid[1] : $catid;
        $this->view->assign($info);
        $this->view->assign([
            'category'      => $category,
            'readpoint'     => $readpoint,
            'allow_visitor' => $allow_visitor,
            'top_parentid'  => $top_parentid,
            'arrparentid'   => $arrparentid,
            'SEO'           => $seo,
            'catid'         => $catid,
            'page'          => $page,
            'modelid'       => $modelid,
            'title' => $title,
            'parentid' => $id,
        ]);
        return $this->fetch('/' . $template);
    }

    // 搜索
    public function search()
    {
        $siteId = getSiteId();
        if ($this->cmsConfig['web_site_searchtype'] == 'xunsearch') {
            return $this->xunsearch();
        }
        $seo    = seo('', '搜索结果');
        $noData = patch('NoSearchData');
        //模型
        $modelid = $this->request->param('modelid/d', 0);
        //关键词
        $keyword = $this->request->param('keyword/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');
        $keyword = str_replace('%', '', $keyword); //过滤'%'，用户全文搜索
        //搜索入库
        if ($keyword) {
            $log = SearchLog::where('keywords' ,$keyword)->find();
            if ($log) {
                $log->setInc("nums");
                $updateTime = request()->time();
                SearchLog::where('keywords' ,$keyword)->update(['update_time' => $updateTime]);
            } else {
                SearchLog::create([
                    'keywords' => $keyword,
                    'siteId'  => $siteId,
                    'nums'    => 1,
                    'ip'      => $this->request->ip()
                ]);
            }
        }

        //时间范围
        $time = $this->request->param('time/s', '');
        $result = $this->validate([
            'keyword' => $keyword,
        ], [
            'keyword|标题关键词' => 'max:50',
        ]);
        if (true !== $result) {
            $this->error($result);
        }
        debug('begin');
        //按时间搜索
        if ($time == 'day') {
            $search_time = time() - 86400;
            $sql_time    = ' AND inputtime > ' . $search_time;
        } elseif ($time == 'week') {
            $search_time = time() - 604800;
            $sql_time    = ' AND inputtime > ' . $search_time;
        } elseif ($time == 'month') {
            $search_time = time() - 2592000;
            $sql_time    = ' AND inputtime > ' . $search_time;
        } elseif ($time == 'year') {
            $search_time = time() - 31536000;
            $sql_time    = ' AND inputtime > ' . $search_time;
        } else {
            $search_time = 0;
            $sql_time    = '';
        }
        //搜索历史记录
        $shistory = cookie("shistory");
        if (!$shistory) {
            $shistory = array();
        }
        array_unshift($shistory, $keyword);
        $shistory = array_slice(array_unique($shistory), 0, 10);
        //加入搜索历史
        cookie("shistory", $shistory);
        //输出可用模型
        $modelsdata = cache("Model");
        $modellist  = [];
        foreach ($modelsdata as $v) {
            $onSiteId = onSiteId();
            if ($v['status'] == 1 && $v['module'] == 'cms' && $v['sites'] == $onSiteId) {
                $modellist[] = $v;
            }
        }
        if (!$modellist) {
            return $this->error('没有可搜索模型~');
        }
        if ($modelid) {
            if (!array_key_exists($modelid, $modellist)) {
                $this->error(patch('PageNot')); //模型错误
            }
            $searchField = Db::name('model_field')->where('modelid', $modelid)->where('ifsystem', 0)->where('ifsearch', 1)->column('name');
            if (empty($searchField)) {
                $this->error(patch('PageNot')); //没有设置搜索字段
            }
            $where = '';
            foreach ($searchField as $vo) {
                $where .= "$vo like '%$keyword%' or ";
            }
            $where = '(' . substr($where, 0, -4) . ') ';
            $where .= " AND status='1' $sql_time";
            $list = $this->CmsModel->getList($modelid, $where, false, '*', $siteId, "listorder DESC,did DESC", 10, 1, false, ['query' => ['keyword' => $keyword, 'modelid' => $modelid]]);
        } else {
            foreach ($modellist as $key => $vo) {
                $searchField = Db::name('model_field')->where('modelid', $key)->where('ifsystem', 0)->where('ifsearch', 1)->column('name');
                if (empty($searchField)) {
                    continue;
                }
                $where = '';
                foreach ($searchField as $v) {
                    $where .= "$v like '%$keyword%' or ";
                }
                $where = '(' . substr($where, 0, -4) . ') ';
                $where .= " AND status='1' $sql_time";
                $list = $this->CmsModel->getList($key, $where, false, '*',$siteId, 'listorder DESC,did DESC', 10, 1, false, ['query' => ['keyword' => $keyword, 'modelid' => $modelid]]);
                if ($list->isEmpty()) {
                    continue;
                } else {
                    break;
                }
            }
        }
        $count = $list->total();
        debug('end');
        $this->assign([
            'time'        => $time,
            'modelid'     => $modelid,
            'keyword'     => $keyword,
            'shistory'    => $shistory,
            'SEO'         => $seo,
            'list'        => $list,
            'count'       => $count,
            'modellist'   => $modellist,
            'search_time' => debug('begin', 'end', 6), //运行时间
            'pages'       => $list->render(),
            'noData'      => $noData,
        ]);
        if (!empty($keyword)) {
            return $this->fetch('/search_result');
        } else {
            return $this->fetch('/search');
        }

    }

    //迅搜简单搜索示例 复杂搜索重写此方法
    public function xunsearch()
    {
        $seo = seo('', '搜索结果');
        //模型
        $modelid = $this->request->param('modelid/d', 0);
        //关键词
        $keyword = $this->request->param('keyword/s', '', 'trim,safe_replace,strip_tags,htmlspecialchars');
        $keyword = str_replace('%', '', $keyword); //过滤'%'，用户全文搜索

        //时间范围
        $time     = $this->request->param('time/s', '');
        $page     = $this->request->get('page/d', '1');
        $pagesize = 5;
        $order    = $this->request->get('order', '');
        $fulltext = $this->request->get('fulltext/d', '1');
        $fuzzy    = $this->request->get('fuzzy/d', '0');
        $synonyms = $this->request->get('synonyms/d', '0');

        $result = $this->validate([
            'keyword' => $keyword,
        ], [
            'keyword|标题关键词' => 'chsDash|max:25',
        ]);
        if (true !== $result) {
            $this->error($result);
        }
        $search = FulltextSearch::setQuery($keyword, $fulltext, $fuzzy, $synonyms);
        if ($modelid > 0) {
            $search->addQueryString("modelid:({$modelid})");
        }
        //按时间搜索
        if ($time == 'day') {
            //一天
            $search_time = time() - 86400;
            $search->addRange('inputtime', $search_time, time());
        } elseif ($time == 'week') {
            //一周
            $search_time = time() - 604800;
            $search->addRange('inputtime', $search_time, time());
        } elseif ($time == 'month') {
            //一月
            $search_time = time() - 2592000;
            $search->addRange('inputtime', $search_time, time());
        } elseif ($time == 'year') {
            //一年
            $search_time = time() - 31536000;
            $search->addRange('inputtime', $search_time, time());
        }
        $modellist = cache('Model');
        if (!$modellist) {
            return $this->error('没有可搜索模型~');
        }
        $query  = ['keyword' => $keyword, 'modelid' => $modelid];
        $result = FulltextSearch::search($page, $pagesize, $order, $query);
        //获取热门搜索
        $hot = FulltextSearch::hot();
        $this->assign([
            'time'        => $time,
            'modelid'     => $modelid,
            'keyword'     => $keyword,
            'SEO'         => $seo,
            'list'        => $result['list'],
            'count'       => $result['count'],
            'total'       => $result['total'],
            'search_time' => $result['search_time'], //运行时间
            'pages'       => $result['list']->render(),
            'search'      => $result['search'],
            'corrected'   => $result['corrected'],
            'related'     => $result['related'],
            'hot'         => $hot,
            'modellist'   => $modellist,
        ]);
        if (!empty($keyword)) {
            return $this->fetch('/xunsearch_result');
        } else {
            return $this->fetch('/search');
        }
    }

    // tags
    public function tags()
    {
        $page   = $this->request->param('page/d', 1);
        $tag    = $this->request->param('tag/s', '');
        $tagdir = $this->request->param('tagdir/s', '');
        $siteId = getSiteId();
        $where  = array();
        if (!empty($tagdir)) {
            $where['tagdir'] = $tagdir;
        }
        //如果条件为空，则显示标签首页
        if (empty($where)) {
            $data = Db::name('Tags')->where('site_id',$siteId)->order(['listorder' => 'DESC', 'hits' => 'DESC'])->limit(100)->cache(60)->select();
            $this->assign("SEO", seo('', '标签'));
            $this->assign('list', $data);
            return $this->fetch('/tags_list');
        }

        //根据条件获取tag信息
        $info = Db::name('Tags')->where($where)->find();
        if (empty($info)) {
            $this->error(patch('NoSearchData')); //抱歉，沒有找到您需要的内容！
        }
        //访问数+1
        Db::name('Tags')->where($where)->setInc("hits");
        $this->assign($info);
        //$this->assign("SEO", seo('', $tagdir, $info['seo_description'], $info['seo_keyword']));
        $seoTitle= $info['seo_title']?$info['seo_title']:$info['tag'];
        $this->assign("SEO", seo('', $seoTitle, $info['seo_description'], $info['seo_keyword']));
        $this->assign("page", $page);
        return $this->fetch('/tags');
    }

    // special
    public function special()
    {
        $page     = $this->request->param('page/d', 1);
        $diyname  = $this->request->param('diyname/s', '');
        $siteId   = getSiteId();
        $where    = array();
        if (!empty($diyname)) {
            $where['diyname'] = $diyname;
        }
        //如果条件为空，则显示标签首页
        if (empty($where)) {
            $data = Db::name('special')->where('sites',$siteId)->order(['listorder' => 'DESC', 'views' => 'DESC'])->limit(100)->cache(60)->select();
            $this->assign("SEO", seo('', '专题'));
            $this->assign('list', $data);
            return $this->fetch('/special_list');
        }

        //根据条件获取tag信息
        $info = Db::name('special')->where($where)->find();
        if (empty($info)) {
            $this->error(patch('NoSearchData')); //抱歉，沒有找到您需要的内容！
        }
        //访问数+1
        Db::name('special')->where($where)->setInc("views");
        $seoTitle= $info['title']?$info['title']:$info['name'];
        $this->assign($info);
        $this->assign("SEO", seo('', $seoTitle, $info['description'], $info['keyword']));
        $this->assign("page", $page);
        return $this->fetch('/special');
    }

    // 阅读付费
    public function readpoint()
    {
        if (isModuleInstall('pay')) {
            if (!$this->auth->isLogin()) {
                $this->error('请先登录！', url('member/index/login'));
            }
            $Spend_Model   = new \app\pay\model\Spend;
            $allow_visitor = $this->request->param('allow_visitor');
            $auth          = sys_auth($allow_visitor, 'DECODE');
            if (strpos($auth, '|') === false) {
                $this->error('非法操作！');
            }
            $auth_str = explode('|', $auth);
            $flag     = $auth_str[0];
            if (!preg_match('/^([0-9]+)|([0-9]+)/', $flag)) {
                $this->error('非法操作！');
            }
            $readpoint = intval($auth_str[1]);
            $paytype   = intval($auth_str[2]);

            $flag_arr = explode('_', $flag);
            $catid    = $flag_arr[0];
            $id       = $flag_arr[1];
            try {
                $Spend_Model->_spend($paytype, floatval($readpoint), $this->auth->id, $this->auth->username, '阅读付费', $flag);
            } catch (\Exception $ex) {
                $this->error($ex->getMessage(), url('pay/index/pay'));
            }
            $this->success(patch('PaymentSuccessful'), buildContentUrl($catid, $id)); //恭喜你！支付成功!
        } else {
            $this->error('请先在后台安装支付模块！');
        }

    }

    //下载次数
    public function times(){
        $id  = $this->request->param('id/d', 0);
        $cat = $this->request->param('catid/d', 0);
        if ($id) {
            //获取栏目数据
            $category = getCategory($cat);
            if (empty($category)) {
                $this->error(patch('PageNot')); //栏目不存在
            }
            $catid = $category['id'];
            //模型ID
            $modelid = $category['modelid'];
            $modelInfo = cache('Model')[$modelid];
            if (empty($modelInfo)) {
                throw new \think\Exception(patch('PageNot'), 404); //栏目不存在
            }
            //更新点击量
            Db::name($modelInfo['tablename'])->where('id', $id)->setInc('times');
        } else {
            $this->error('请先模型中增加times字段！');
        }
    }

    // 检查支付状态
    protected function _check_payment($flag, $paytype)
    {
        $this->userid = \app\member\service\User::instance()->id;
        if (!$this->userid) {
            return false;
        }
        if (\app\pay\model\Spend::spend_time($this->auth->id, '24', $flag)) {
            return true;
        }
        return false;
    }


}
