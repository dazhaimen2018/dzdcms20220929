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
// | 会员投稿管理
// +----------------------------------------------------------------------
namespace app\member\controller;

use app\cms\model\Cms as Cms_Model;
use app\member\model\MemberContent as MemberContentModel;
use think\Db;

class Content extends MemberBase
{
    protected function initialize()
    {
        parent::initialize();
        $this->Cms_Model = new Cms_Model;
    }

    public function publish()
    {
        $groupinfo = $this->_check_group_auth($this->auth->groupid);
        //没有认证用户不得投稿
        if (isset(cache("Cms_Config")['authentication']) && 1 == cache("Cms_Config")['authentication']) {
            if (empty($this->auth->ischeck_email) && empty($this->auth->ischeck_mobile)) {
                $this->error(patch('publishCondition'));
            }
        }
        //判断每日投稿数
        $allowpostnum = MemberContentModel::where('uid', $this->auth->id)->whereTime('create_time', 'd')->count();
        if ($groupinfo['allowpostnum'] > 0 && $allowpostnum >= $groupinfo['allowpostnum']) {
            $this->error("今日投稿数量已达上限！");
        }
        if ($this->request->isPost()) {
            $data = $this->request->param();
            //默认编辑器不过滤
            $content = $this->request->param('modelFieldExt.content', '', 'trim');
            if (isset($data['modelFieldExt']['content']) && $data['modelFieldExt']['content'] && $content) {
                $data['modelFieldExt']['content'] = $content;
            }
            $token = $this->request->param('__token__');
            // 验证数据
            $rule = [
                'modelField.theme|标题' => 'require|length:3,100',
                'modelField.catid|栏目' => 'require|integer',
                '__token__'           => 'require|token',
            ];
            $result = $this->validate($data, $rule);
            if (true !== $result) {
                $this->error($result, null, ['token' => $this->request->token()]);
            }
            $catid = intval($data['modelField']['catid']);
            if (empty($catid)) {
                $this->error("请指定栏目ID！", null, ['token' => $this->request->token()]);
            }
            $catidPrv = Db::name('category_priv')->where(array("catid" => $catid, "roleid" => $this->auth->groupid, "is_admin" => 0, "action" => "add"))->find();
            if (empty($catidPrv)) {
                $this->error("您没有该栏目投稿权限！", null, ['token' => $this->request->token()]);
            }
            $category = Db::name('Category')->find($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！', null, ['token' => $this->request->token()]);
            }
            $fields = Db::name('model_field')->where('modelid', $category['modelid'])->where('isadd', 1)->column('name,ifsystem');
            $_data  = [];
            foreach ($fields as $k => $v) {
                if (1 == $v && isset($data['modelField'][$k])) {
                    $_data['modelField'][$k] = $data['modelField'][$k];
                } elseif (0 == $v && isset($data['modelFieldExt'][$k])) {
                    $_data['modelFieldExt'][$k] = $data['modelFieldExt'][$k];
                }
            }
            $_data['modelField']['uid']      = $this->auth->id;
            $_data['modelField']['username'] = $this->auth->username;

            //判断会员组投稿是否需要审核
            if ($groupinfo['allowpostverify']) {
                $_data['modelField']['status'] = 1;
            } else {
                $_data['modelField']['status'] = 0;
            }
            $id = 0;
            if ($category['type'] == 2) {
                $_data['modelFieldExt'] = isset($_data['modelFieldExt']) ? $_data['modelFieldExt'] : [];
                try {
                    $id = $this->Cms_Model->addModelData($_data['modelField'], $_data['modelFieldExt']);
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            }
            //添加投稿记录
            if ($id) {
                MemberContentModel::create([
                    'catid'       => $catid,
                    'content_id'  => $id,
                    'uid'         => $_data['modelField']['uid'],
                    'username'    => $_data['modelField']['username'],
                    'create_time' => time(),
                    'status'      => $_data['modelField']['status'],
                ]);
            }
            if ($_data['modelField']['status'] == 1) {
                //增加清除缓存
                $cache =  cleanUp();
                $this->success(patch('PublishedReviewed'), url('published'));
            } else {
                $this->success(patch('PublishedNeedReview'), url('published'));
            }
        } else {
            $step = $this->request->param('step/d', 1);
            if ($step == 1) {
                return $this->fetch('/declaration');
            }
            $catid = $this->request->param('catid/d', 0);
            $tree  = new \util\Tree();
            $str   = "<option value=@catidurl @selected @disabled>@spacer @catname</option>";
            //按当前站点适配栏目
            $sites   = getSiteId();
            if ($sites) {
                $site  = [];
                foreach (explode(',', $sites) as $k => $v) {
                    $site[] = "FIND_IN_SET('" . $v . "', sites)";
                }
                if ($site) {
                    $where = "  (" . implode(' OR ', $site) . ")";
                }
            }

            // 获得能投稿的栏目ID
            $catidArr = Db::name('category_priv')->where(array( "roleid" => $this->auth->groupid, "is_admin" => 0, "action" => "add"))->select();
            $catids   = array_column($catidArr,'catid');
            $catids   = implode(",", $catids);
            if ($catids){
                $whereIn  = " id in($catids)";
            }
            $array = Db::name('Category')->where($where)->where($whereIn)->where('status',1)->order('listorder DESC, id DESC')->column('*', 'id');

            foreach ($array as $k => $v) {
                //获得当前站点栏目名称
                $array[$k]['catname'] = Db::name('Category_data')->where('catid',$v['id'])->where('site_id',$sites)->value('catname');
                $array[$k]['catname'] = $array[$k]['catname'] ? $array[$k]['catname'] : $v['catname'];
                if ($v['id'] == $catid) {
                    $array[$k]['selected'] = "selected";
                }

                //含子栏目和单页不可以发表
                if ($v['child'] == 1 || $v['type'] == 1) {
                    $array[$k]['disabled'] = "disabled";
                    $array[$k]['catidurl'] = url('publish', array('step' => 2));
                } else {
                    $array[$k]['disabled'] = "";
                    $array[$k]['catidurl'] = url('publish', array('step' => 2, 'catid' => $v['id']));
                }
            }
            $tree->init($array);
            $categoryselect = $tree->getTree(0, $str);
            //如果有选择栏目的情况下
            if ($catid) {
                $category = Db::name('Category')->find($catid);
                if (empty($category)) {
                    $this->error('该栏目不存在！');
                }
                if ($category['type'] == 2) {
                    $modelid   = $category['modelid'];
                    $fieldList = $this->Cms_Model->getFieldList($modelid);
                    $this->assign([
                        'catid'     => $catid,
                        'fieldList' => $fieldList,
                        'siteId'    => $sites,
                    ]);
                }
            }
            $this->assign("categoryselect", $categoryselect);
            return $this->fetch('/publish');
        }

    }

    /**
     * 编辑内容
     */
    public function edit()
    {
        $groupinfo = $this->_check_group_auth($this->auth->groupid);
        $did = $this->request->param('did/d', 0);
        if ($this->request->isPost()) {
            $data = $this->request->param();
            //默认编辑器不过滤
            $content = $this->request->param('modelFieldExt.content', '', 'trim');
            if (isset($data['modelFieldExt']['content']) && $data['modelFieldExt']['content'] && $content) {
                $data['modelFieldExt']['content'] = $content;
            }
            $token = $this->request->param('__token__');
            // 验证数据
            $rule = [
                'modelField.theme|标题' => 'require|length:3,100',
                'modelField.catid|栏目' => 'require|integer',
                '__token__'           => 'require|token',
            ];
            $result = $this->validate($data, $rule);
            if (true !== $result) {
                $this->error($result, null, ['token' => $this->request->token()]);
            }
            $id    = intval($data['modelField']['id']);

            $catid = intval($data['modelField']['catid']);
            if (empty($id) || empty($catid)) {
                $this->error("请指定栏目ID！");
            }
            $category = Db::name('Category')->find($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }

            $catidPrv = Db::name('category_priv')->where(array("catid" => $catid, "roleid" => $this->auth->groupid, "is_admin" => 0, "action" => "add"))->find();
            if (empty($catidPrv)) {
                $this->error("您没有该栏目投稿权限！");
            }
            $fields = Db::name('model_field')->where('modelid', $category['modelid'])->where('isadd', 1)->column('name,ifsystem');
            $_data  = [];
            foreach ($fields as $k => $v) {
                if (1 == $v && isset($data['modelField'][$k])) {
                    $_data['modelField'][$k] = $data['modelField'][$k];
                } elseif (0 == $v && isset($data['modelFieldExt'][$k])) {
                    $_data['modelFieldExt'][$k] = $data['modelFieldExt'][$k];
                }
            }

            //判断会员组投稿是否需要审核
            if ($groupinfo['allowpostverify']) {
                $_data['modelField']['status'] = 1;
            } else {
                $_data['modelField']['status'] = 0;
            }

            if ($category['type'] == 2) {
                $_data['modelFieldExt'] = isset($_data['modelFieldExt']) ? $_data['modelFieldExt'] : [];
                try {
                    $this->Cms_Model->editModelData($_data['modelField'], $_data['modelFieldExt']);
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            }

            if ($_data['modelField']['status'] == 1) {
                MemberContentModel::where(['content_id' => $id, 'catid' => $catid])->update(['status' => 1]);
                //增加清除缓存
                $cache =  cleanUp();
                $this->success('编辑成功，内容已通过审核！', url('published'));

            } else {
                MemberContentModel::where(['content_id' => $id, 'catid' => $catid])->update(['status' => 0]);
                $this->success('编辑成功，等待管理员审核！', url('published'));
            }
        } else {
            $id   = $this->request->param('id/d', 0);
            $info = MemberContentModel::where(array('uid' => $this->auth->id, 'id' => $id))->find();
            if (empty($info)) {
                $this->error('稿件不存在！');
            }
            $catid = $info['catid'];
            //取得栏目数据
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！', url('publish', array('step' => 2)));
            }
            //模型ID
            $modelid = (int) $category['modelid'];
            //判断是否终极栏目
            if ($category['child'] || $category['type'] == 0) {
                $this->error("该栏目不允许投稿！", url('publish', array('step' => 2)));
            }
            $fieldList = $this->Cms_Model->getFieldList($modelid, $info['content_id']);
            $this->assign([
                'catid'     => $catid,
                'fieldList' => $fieldList,
                'did' => $did,
            ]);
            return $this->fetch('/edit');
        }

    }

    public function published()
    {
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 10);
            $page  = $this->request->param('page/d', 10);
            $type  = $this->request->param('type/s', "");
            $where = array('uid' => $this->auth->id);
            if ('check' == $type) {
                $where['status'] = 1;
            }
            if ('checking' == $type) {
                $where['status'] = 0;
            }
            $total = MemberContentModel::where($where)->count();
            $_list = MemberContentModel::where($where)->page($page, $limit)->order(array("id" => "DESC"))->select();
            foreach ($_list as $k => $v) {
                $modelid   = getCategory($v['catid'], 'modelid');
                $tablename = ucwords(getModel($modelid, 'tablename'));
                $info      = Db::name($tablename)->where(array("id" => $v['content_id'], "sysadd" => 0))->find();
                if ($info) {
                    $_list[$k]['url']     = buildContentUrl($v['catid'], $v['content_id'], $info['url']);
                    $_list[$k]['theme']   = $info['theme'];
                    $_list[$k]['catname'] = getCategory($v['catid'], 'catname');
                }
            }
            $result = array("code" => 0, "count" => $total, "data" => $_list);

            return json($result);
        }
        return $this->fetch('/published');
    }

    //删除
    public function del()
    {
        $id = $this->request->param('id/d', 0);
        if (empty($id)) {
            $this->error('请指定需要删除的信息！');
        }
        //信息
        $info = MemberContentModel::where('id', $id)->find();
        //只能删除自己的 且 未通过审核的
        if ($info && $info['uid'] == $this->auth->id && $info['status'] != 1) {
            //取得栏目信息
            $category = getCategory($info['catid']);
            if (!$category) {
                $this->success('栏目不存在！');
            }
            try {
                $this->Cms_Model->deleteModelData($category['modelid'], $info['content_id']);
            } catch (\Exception $ex) {
                $this->error($ex->getMessage());
            }
            $this->success('删除成功！');
        } else {
            $this->error('对不起，你无权删除！');
        }
    }

    //检查会员组权限
    private function _check_group_auth($groupid)
    {
        $grouplist = cache("Member_Group"); //会员模型
        if (!$grouplist[$groupid]['allowpost']) {
            $this->error('你没有权限投稿，请升级会员组！');
        }
        return $grouplist[$groupid];
    }

}
