<?php
// +----------------------------------------------------------------------
// | Dzdcms [ 火车头免登陆入库接口 2021年7月28日 ]
// +----------------------------------------------------------------------

namespace app\api\controller;
use app\common\controller\Api;
use app\cms\model\Cms as Cms_Model;
use app\cms\model\Page as Page_Model;
use think\Db;

class Publish extends Api
{
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data  = $this->request->post();
			if($data['password'] !='pDEBmxdYJy8km5Md'){// 火车头入库验证密码，要保持和火车头模块里设置相同的
				$this->error("火车头入库密码验证失败！");
				exit();
			}
			//发布的添加用户名和id
			$data['modelField']['LocoySpider'] = true;
			$data['modelField']['uid'] = 1;
			$data['modelField']['username'] = 'dzdcms';// 用户名
			// $data['modelField']['sysadd'] = 1;
				
            $catid = intval($data['modelField']['catid']);
            if (empty($catid)) {
                $this->error("请指定栏目ID！");
            }
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $data['modelFieldExt'] = isset($data['modelFieldExt']) ? $data['modelFieldExt'] : [];
                try {
                    $this->Cms_Model->addModelData($data['modelField'], $data['modelFieldExt']);
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            } else if ($category['type'] == 1) {
                $Page_Model = new Page_Model;
                if (!$Page_Model->savePage($data['modelField'])) {
                    $error = $Page_Model->getError();
                    $this->error($error ? $error : '操作失败！');
                }
            }
            $this->success('操作成功！');
        } else {
            $catid    = $this->request->param('catid/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $modelid   = $category['modelid'];
                $fieldList = $this->Cms_Model->getFieldList($modelid);
                $this->assign([
                    'catid'     => $catid,
                    'fieldList' => $fieldList,
                ]);
                return $this->fetch();
            } else if ($category['type'] == 1) {
                $Page_Model = new Page_Model;
                $info       = $Page_Model->getPage($catid);
                $this->assign([
                    'info'  => $info,
                    'catid' => $catid,
                ]);
                return $this->fetch('singlepage');
            }

        }
    }

  

}
