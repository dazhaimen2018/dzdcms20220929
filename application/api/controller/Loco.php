<?php

/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/12/3
 * 火车头免登录接口
 * 火车头全局变量，要保持和火车头模块里设置相同的
 * 火车头全局变量，在使用前必须修改！
 */

namespace app\api\controller;
use app\cms\model\Site;
use app\common\controller\Api;
use app\cms\model\Cms as Cms_Model;
use app\cms\model\Page as Page_Model;
use think\Db;

class Loco extends Api
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
			if($data['auth'] !='MsCmsLocoApi'){  // 火车头全局变量
				$this->error("全局变量码验证失败！");
				exit();
			}

			//发布的添加用户名和id
			$data['modelField']['uid'] = 1;
			$data['modelField']['username'] = 'admin';// 用户名
            $data['modelField']['sysadd'] = 1;
            $catid = intval($data['modelField']['catid']);
            $data['modelFieldExt']['content'] = $this->request->param('modelFieldExt.content', '', 'trim');
            if (empty($catid)) {
                $this->error("请指定栏目ID！");
            }
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            $modelid   = getCategory($catid, 'modelid');
            $tablename = $this->Cms_Model->getModelTableName($modelid);
            //检查主题标题是否重复
            $theme = $data['modelField']['theme'];
            if ($theme){
                $theme = db::name($tablename)->where('theme',$theme)->where('catid',$catid)->find();
                if ($theme) {
                    throw new \Exception('该内容已存在！');
                }
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

    public function cate(){
        $tree       = new \util\Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $categorys  = array();

        //按当前站点适配栏目
        $sites   = 1;
        if ($sites) {
            $site  = [];
            foreach (explode(',', $sites) as $k => $v) {
                $site[] = "FIND_IN_SET('" . $v . "', sites)";
            }
            if ($site) {
                $where = "  (" . implode(' OR ', $site) . ")";
            }
        }

        $result = Db::name('Category')->where($where)->where('status',1)->order('listorder DESC, id DESC')->field('id,catname')->column('*', 'id');
        foreach ($result as $k => $v) {
            if ($v['type'] != 2) {
                $v['disabled'] = 'disabled';
            }
            $v['disabled'] = $v['child'] ? 'disabled' : '';
            $categorys[$k] = $v;
        }
        $str = "<option value=@id @selected @disabled>@spacer @catname</option>";
        $tree->init($categorys);
        $string = $tree->getTree(0, $str, 0);

        echo "<select>$string<select>";
    }

}
