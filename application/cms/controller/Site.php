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
use think\Db;

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
	 * 站点列表
	 */

    public function index()
    {
        if ($this->request->isAjax()) {
            $models     = cache('Model');
            $tree       = new \util\Tree();
            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $sites  = array();
            $result     = Db::name('site')->order(array('listorder', 'id' => 'ASC'))->select();
            foreach ($result as $k => $v) {
                $v['name'] = '<a data-width="900px" data-height="600px" data-open="' . url('edit', ['id' => $v['id']]) . '"">' . $v['name'] . '</a>';
                $v['add_url'] = url("Site/add", array("parentid" => $v['id']));
                $sites[$v['id']] = $v;
            }
            $tree->init($sites);
            $_list  = $tree->getTreeList($tree->getTreeArray(0), 'name');
            $total  = count($_list);
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
            $parentid = $this->request->param('parentid/d', 0);
            if (!empty($parentid)) {
                $Ca = getSiteName($parentid);
                if (empty($Ca)) {
                    $this->error("父栏目不存在！");
                }
            }
            $templates = get_template_list();
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

            $this->assign("site", $siteData);
            $this->assign("templates", $templates);
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
            $templates = get_template_list();
			$siteId = $this->request->param('id/d', 0);
			$data = SiteModel::where(["id" => $siteId])->find();
			if (empty($data)) {
				$this->error("该语言组不存在！", url("Site/index"));
			}
			$this->assign("data", $data);
            $this->assign("templates", $templates);
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

    //更新碎片缓存
    public function site_cache() {
        $this->success("站点缓存更新成功！");
    }
}
