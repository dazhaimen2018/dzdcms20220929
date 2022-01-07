<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 */
namespace app\cms\controller;

use addons\translator\Translator;
use app\admin\model\Language;
use app\cms\model\SiteDomain;
use app\common\controller\Adminbase;
use app\cms\model\Site as SiteModel;
use think\Db;
use think\facade\Cache;

class Site extends Adminbase
{
    protected $noNeedRight = [
        'cms/site/translator',
    ];
    protected $searchFields = 'id,name';
	//初始化
	protected function initialize()
	{
		parent::initialize();
		$this->modelClass = new SiteModel;
        $languages = Language::where(['status' => 1])->select()->toArray();
        $this->assign([
            'languages' => $languages,
            ]);
	}
	/**
	 * 站点列表
	 */

    public function index()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $models     = cache('Model');
            $tree       = new \util\Tree();
            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $sites      = [];
            $result     = Db::name('site')->order(array('listorder', 'id' => 'ASC'))->select();
            foreach ($result as $k => $v) {
                $v['name'] = '<a data-width="900" data-height="600" data-open="' . url('edit', ['id' => $v['id']]) . '"">' . $v['name'] . '</a>';
                $v['add_url'] = url("Site/add", array("parentid" => $v['id']));
                if (!valid()){
                    $v['sites']  = 1;
                }
                $sites[$v['id']] = $v;

            }
            $tree->init($sites);
            $_list  = $tree->getTreeList($tree->getTreeArray(0), 'name');
            $total  = count($_list);
            $result = ["code" => 0, "count" => $total, "data" => $_list];
            return json($result);
        }
        return $this->fetch();
    }

	/**
	 * 站点添加
	 */
	public function add()
	{
        $parentid = $this->request->param('parentid/d', 0);
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($data['isbatch']) {
                unset($data['isbatch'], $data['name']);
                //需要批量添加的站点
                $batch_add = explode(PHP_EOL, $data['batch_add']);
                if (empty($batch_add) || empty($data['batch_add'])) {
                    $this->error('请填写需要添加的站点名称！');
                }
                foreach ($batch_add as $rs) {
                    if (trim($rs) == '') {
                        continue;
                    }
                    $cat          = explode('|', $rs, 2);
                    $data['name'] = $cat[0];
                    $prefix  = isset($cat[1]) ? $cat[1] : '';
                    $prefix  = $this->get_name_pinyin($data['name'], $prefix);
                    $data['domain'] = $prefix .'.'. $data['domains'];
                    $data['url'] = $data['http'].'://'.$data['domain'];
                    $result = $this->validate($data, 'site');
                    if (true !== $result) {
                        return $this->error($result);
                    }
                    $okSite = SiteModel::create($data);
                    // 增加域名到站点域名列表
                    $domain['sites']       = $okSite['id'];
                    $domain['domain']      = $data['domain'];
                    $domain['master']      = 1;
                    $domain['listorder']   = 1;
                    $domain['status']      = 1;
                    $domain['create_time'] = time();
                    $okDomain = SiteDomain::create($domain);
                }
                Cache::set('Site',null);
                Cache::set('Domain',null);
                $this->success("添加成功！", url("index"));
            }else{
                unset($data['isbatch']);
                $data['domain'] = $data['domains'];
                $result = $this->validate($data, 'site');
                if (true !== $result) {
                    return $this->error($result);
                }
                $data['status'] = 1;
                $data['url'] = $data['http'].'://'.$data['domain'];
                if ($row = SiteModel::create($data)) {
                    //更新缓存
                    Cache::set('Site',null);
                    // 增加域名到站点域名列表
                    $domain['sites']       = $row['id'];
                    $domain['domain']      = $data['domain'];
                    $domain['master']      = 1;
                    $domain['listorder']   = 1;
                    $domain['status']      = 1;
                    $domain['create_time'] = time();
                    $domain = SiteDomain::create($domain);
                    return $this->success('站点添加成功~', url('index'));
                } else {
                    $this->error('添加失败！');
                }
            }

        } else {
            if (valid()){
                //站点列表 可以用缓存的方式
                $array = Db::name('site')->order('listorder ASC, id ASC')->column('*', 'id');
                if (!empty($array) && is_array($array)) {
                    $tree       = new \util\Tree();
                    $tree->icon = array('&nbsp;&nbsp;│ ', '&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;└─ ');
                    $tree->nbsp = '&nbsp;&nbsp;';
                    $str        = "<option value=@id @selected @disabled>@spacer @name</option>";
                    $tree->init($array);
                    $siteData = $tree->getTree(0, $str, $parentid);
                } else {
                    $siteData = '';
                }
                $templates = get_template_list();
                $this->assign([
                    'site'      => $siteData,
                    'templates' => $templates,
                ]);
                return $this->fetch();
            } else {
                return $this->error(tipsText());
            }
        }
	}

	public function translator(){
        if ($this->request->isPost()) {
	        $mark = $this->request->param('mark/s');
	        if (!$mark){
	            $this->error('语言标识不能为空');
            }
	        $check = db::name('language')->where('mark',$mark)->find();
	        if (!$check){
	            $this->error('未支持该语种的翻译');
            }
	        //获取主站信息
	        $info = Db::name('site')->field('title,keywords,description')->where('id',1)->find();
            //新站点数据
            $new_site = $info;
            $Translator = new Translator();
            $new_value = $Translator->text_translator($info['title'],$mark);
            if (!$new_value){
                $this->error('翻译失败，请检查翻译插件配置');
            }
            $new_site['title'] = $new_value;
            $new_site['keywords'] = $Translator->text_translator($info['keywords'],$mark);
            $new_site['description'] = $Translator->text_translator($info['description'],$mark);
            $this->success('翻译成功','',$new_site);
        }
    }

	/**
	 * 站点编辑
	 */
	public function edit()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
            $result = $this->validate($data, 'site');
            if (true !== $result) {
                return $this->error($result);
            }
            $data['url'] = $data['http'].'://'.$data['domain'];
			if ($row = SiteModel::update($data)) {
				//更新缓存
                Cache::set('Site',null);
                return $this->success('站点修改成功~', url('index'));
			} else {
				$this->error("修改失败！");
			}
		} else {

			$siteId = $this->request->param('id/d', 0);
			$data   = SiteModel::where(["id" => $siteId])->find();
			if (empty($data)) {
				$this->error("该站点不存在！", url("Site/index"));
			}
            //站点列表 可以用缓存的方式
            $array = Db::name('site')->order('listorder ASC, id ASC')->column('*', 'id');
            if (!empty($array) && is_array($array)) {
                $tree       = new \util\Tree();
                $tree->icon = array('&nbsp;&nbsp;│ ', '&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;└─ ');
                $tree->nbsp = '&nbsp;&nbsp;';
                $str        = "<option value=@id @selected @disabled>@spacer @name</option>";
                $tree->init($array);
                $siteData   = $tree->getTree(0, $str, $data['parentid']);
            } else {
                $siteData = '';
            }
            $templates = get_template_list();
            $this->assign([
                'site'      => $siteData,
                'templates' => $templates,
                'data'      => $data,
            ]);
			return $this->fetch();
		}
	}
	/**
	 * 站点删除
	 */
	public function del()
    {
        $this->error('站点只能修改或关闭，不能删除！');
    }

    /**
     * 设置为主站
     */
    public function master()
    {
        $ids = $this->request->param('id/a', null);
        if (empty($ids)) {
            $this->error('请选择站点！');
        }
        if (!is_array($ids)) {
            $ids = array(0 => $ids);
        }

        foreach ($ids as $sid) {
            Db::name('site')->where('master', 1)->update(['master' => 0]);
            Db::name('site')->where('id', $sid)->update(['master' => 1]);
        }
        $this->success("设置主站成功！");

    }

    //更新站点缓存
    public function cache() {
        $sites = SiteModel::where('status',1)->column('*','id');
        Cache::set('Site',$sites);
        $this->success("站点缓存更新成功！");
    }

    //获取栏目的拼音
    private function get_name_pinyin($name = '', $prefix = '', $id = 0)
    {
        $pinyin = new \Overtrue\Pinyin\Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        if (empty($catdir)) {
            $prefix = $pinyin->permalink($name, '');
        }
        if (strval(intval($prefix)) == strval($prefix)) {
            $prefix .= genRandomString(3);
        }
        $map = [
            ['domain', '=', $prefix],
        ];
        if (intval($id) > 0) {
            $map[] = ['id', '<>', $id];
        }
        $result = Db::name('site')->field('id')->where($map)->find();
        if (!empty($result)) {
            $nowDirname = $prefix . genRandomString(3);
            return $this->get_name_pinyin($name, $nowDirname, $id);
        }
        return $prefix;
    }
}
