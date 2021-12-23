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
            $siteUrl = onSiteUrl();
            $private   = onPrivate();
            if($private){
                $siteId = onSite();
            } else {
                $siteId = 1;
            }
            $specials = [];
            $result   = $this->modelClass->where('sites', $siteId)->select();
            foreach ($result as $k => $v) {
                $v['url']           = $siteUrl .'/special/'.$v['diyname'] .'.html';
                $specials[$v['id']] = $v;
            }
            return json(["code" => 0, "data" => $specials]);
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
                $siteId = 1;
            }
            $data['sites'] = $siteId;
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
}
