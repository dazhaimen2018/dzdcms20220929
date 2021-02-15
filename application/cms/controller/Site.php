<?php
// +----------------------------------------------------------------------
// | TTmcms [ 天天互联 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://ttmcms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 马博 <8355763@qq.com>
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
// | 语言组管理
// +----------------------------------------------------------------------
namespace app\cms\controller;

use app\common\controller\Adminbase;
use app\cms\model\Site as SiteModel;

class Site extends Adminbase
{
	protected $modelClass = null;
	//初始化
	protected function initialize()
	{
		parent::initialize();
		$this->modelClass = new SiteModel;
	}
	/**
	 * 语言组列表
	 */
	public function index()
	{
		if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $_list = $this->modelClass->where($where)->order(["listorder" => "ASC", "id" => "DESC"])->page($page, $limit)->select();
            $total = $this->modelClass->where($where)->count();
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
			$data = $this->request->post();
			try {
				$this->validate($data, 'Site');
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			$data['status'] = 1;
			if ($row = SiteModel::create($data)) {
				//更新缓存
				// $row->SiteModel_cache();
                return $this->success('站点添加成功~', url('index'));
			} else {
				$this->error("添加失败！");
			}
		} else {
			return $this->fetch('edit');
		}
	}
	/*
    * 语言静态包保存
    */
	public function lang_save()
	{
		$data = [
			'm_title' => 1,
		];
		$code = "return [
                            'title' => '" . $data['m_title'] . "',
                        ]";
		$code = "<?php\n " . $code . ";";
		try {
			file_put_contents(APP_PATH . "/lang/zh_cn.php", $code);
			return $this->success('成功');
		} catch (\Exception $e) {
			echo $this->error('失败');
		}
	}
	/**
	 * 站点编辑
	 */
	public function edit()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			try {
				$this->validate($data, 'Site');
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			if ($row = SiteModel::update($data)) {
				//更新缓存
				// $row->SiteModel_cache();
                return $this->success('站点修改成功~', url('index'));
			} else {
				$this->error("修改失败！");
			}
		} else {
			$siteId = $this->request->param('id/d', 0);
			$data = SiteModel::where(["id" => $siteId])->find();
			if (empty($data)) {
				$this->error("该语言组不存在！", url("Site/index"));
			}
			$this->assign("data", $data);
			return $this->fetch('edit');
		}
	}
	/**
	 * 站点删除
	 */
	public function del()
    {
        $ids = $this->request->param('ids/d');
        if (!is_numeric($ids) || $ids < 0) {
            return '参数错误';
        }
        $this->error('站点只能修改或关闭，不能删除！');
    }
}
