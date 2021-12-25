<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 */
namespace app\cms\controller;


use app\common\controller\Adminbase;
use app\cms\model\Special as SpecialModel;
use think\Db;
use think\facade\Cache;

class Special extends Adminbase
{

    protected $searchFields = 'id,title';
	//初始化
	protected function initialize()
	{
		parent::initialize();
        //模块安装后，模板安装在Default主题下！
        $themePath = TEMPLATE_PATH . (empty(config('theme')) ? "default" : config('theme')) . DS . "cms" . DS;
        //取得专题模板
        $this->specialTemplate = str_replace($themePath . DS, '', glob($themePath . DS . 'special*'));
		$this->modelClass = new SpecialModel;
	}
	/**
	 * 专题列表
	 */


    public function index()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $siteUrl                    = onSiteUrl();
            $onSiteId                   = onSiteId();
            $_list                      = $this->modelClass->where('sites', $onSiteId)->where($where)->order(['listorder' => 'desc', 'id' => 'desc'])->page($page, $limit)->select();
            foreach ($_list as $k => &$v) {
                $v['url'] = url('cms/index/special', ['diyname' => $v['diyname']]);
            }
            unset($v);
            $total  = $this->modelClass->where('sites', $onSiteId)->where($where)->count();
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        return $this->fetch();
    }

	/**
	 * 站点添加
	 */
    public function add()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->post();
            $result = $this->validate($data, 'special');
            if (true !== $result) {
                return $this->error($result);
            }
            $siteId = onSite();
            if(!$siteId){
                $siteId = 0;
            }
            $data['sites'] = $siteId;
            $data['create_time'] = time();
            $data['update_time'] = time();
            if ($row = SpecialModel::create($data)) {
                //更新缓存
                Cache::set('special',null);
                return $this->success('专题添加成功~', url('index'));
            } else {
                $this->error("添加失败！");
            }
        } else {
            $this->assign('templates', $this->specialTemplate);
            return $this->fetch();
        }
    }

	/**
	 * 专题编辑
	 */
	public function edit()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			try {
				$this->validate($data, 'special');
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
            $data['update_time'] = time();
			if ($row = SpecialModel::update($data)) {
				//更新缓存
                Cache::set('special',null);
                return $this->success('站点修改成功~', url('index'));
			} else {
				$this->error("修改失败！");
			}
		} else {
            $id = $this->request->param('id/d', 0);
            $data   = SpecialModel::where(["id" => $id])->find();
            if (empty($data)) {
                $this->error("该站点不存在！", url("index"));
            }
            $this->assign([
                'templates' => $this->specialTemplate,
                'data'      => $data,
            ]);
			return $this->fetch();
		}
	}
	/**
	 * 专题删除
	 */
	public function del()
    {
        $ids = $this->request->param('id/d');
        if (!is_numeric($ids) || $ids < 0) {
            return '参数错误';
        }
        if (SpecialModel::where(['id' => $ids])->delete()) {
            cache('special', null); //清空缓存配置
            SpecialModel::where(['id' => $ids])->delete();
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    //更新站点缓存
    public function cache() {
        $sites = SpecialModel::where('status',1)->column('*','id');
        Cache::set('special',$sites);
        $this->success("专题缓存更新成功！");
    }
    /**
     * 专题内容列表
     */

    public function lists()
    {
        $id = $this->request->param('id/d', '');
        if (empty($id)) {
            $this->error('参数错误！');
        }
        $specia = Db::name("special")->where("id", $id)->find();
        if (empty($specia)) {
            $this->error('该专题不存在！');
        }
        $onSiteId   = onSiteId();
        //输出可用模型
        $modelsdata = cache("Model");
        $models     = [];
        foreach ($modelsdata as $v) {
            if ($v['status'] == 1 && $v['module'] == 'cms' && $v['sites'] == $onSiteId) {
                $models[] = $v;
            }
        }
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 10);
            $page = $this->request->param('page/d', 1);
            list($page, $limit, $where) = $this->buildTableParames();
            $conditions = [
                ['status', 'in', [0, 1]],
            ];
            $whereSpecial = "FIND_IN_SET($id,specialids)";
            $total  = Db::name('news')->where($where)->where($conditions)->where($whereSpecial)->count();
            $list   = Db::name('news')->page($page, $limit)->where($where)->where($conditions)->where($whereSpecial)->order('listorder DESC, id DESC')->select();
            $result = array("code" => 0, "count" => $total, "data" => $list);
            return json($result);
        }
        $this->assign([
            'specialId'   => $id,
        ]);
        return $this->fetch();
    }

    /**
     * 专题内容移除
     */
    public function revoke()
    {
        $id     = $this->request->param('id/d', 0);
        $catid  = $this->request->param('catid/d', 0);
        $outid  = $this->request->param('outid/d', 0);
        if (empty($outid) || !$catid) {
            $this->error('参数错误！');
        }
        $modelid   = getCategory($catid, 'modelid');
        $modelInfo = cache('Model');
        $modelInfo = $modelInfo[$modelid];
        $catids    = Db::name($modelInfo['tablename'])->where('id', $id)->field('catids')->find();
        $catids    = explode(',',$catids['catids']);
        for ( $i=0; $i<count($catids); $i++ ){
            if($outid == $catids[$i]) unset($catids[$i]);
        }
        $catids = arr2str($catids);
        Db::name($modelInfo['tablename'])->where('id', $id)->update([
            'catids'		=>	$catids,
        ]);
        $this->success('移除成功！');
    }
}
