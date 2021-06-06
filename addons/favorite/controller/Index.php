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
// | 收藏管理
// +----------------------------------------------------------------------
namespace addons\favorite\Controller;

use app\cms\model\Cms as Cms_Model;
use app\member\controller\MemberBase;
use think\Db;

class Index extends MemberBase
{
    protected $noNeedLogin = ['post'];

    public function index()
    {
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 10);
            $page  = $this->request->param('page/d', 10);
            $where = array('uid' => $this->userid);
            $total = Db::name('favorite')->where($where)->count();
            $_list = Db::name('favorite')->where($where)->page($page, $limit)->order("id", "DESC")->select();
            foreach ($_list as $k => $v) {
                $_list[$k]['create_time'] = time_format($v['create_time']);
                $tid                      = explode("-", $v['tid']);
                $_list[$k]['url']         = buildContentUrl($tid[0], $tid[1]);
                $_list[$k]['catid']       = $tid[0];
                $_list[$k]['cid']         = $tid[1];
            }
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        return $this->fetch();
    }

    public function post()
    {
        if (!\app\member\service\User::instance()->id) {
            $this->error('请先登录！');
        }
        $catid    = $this->request->param('catid/d', 0);
        $id       = $this->request->param('id/d', 0);
        $category = getCategory($catid);
        if (empty($category)) {
            $this->error('栏目不存在！');
        }
        $modelid   = $category['modelid'];
        $Cms_Model = new Cms_Model;
        $info      = $Cms_Model->getContent($modelid, "id={$id}");
        if (!$info) {
            $this->error('内容不存在！');
        }

        $model_cache = cache("Model");
        $tablename   = ucwords($model_cache[$modelid]['tablename']);

        $res = Db::name('favorite')->where('tid', $catid . '-' . $id)->where('uid', $this->userid)->find();
        if ($res) {
            //取消收藏
            Db::name('favorite')->where('tid', $catid . '-' . $id)->where('uid', $this->userid)->delete();
            Db::name($tablename)->where('id', $id)->setDec('favorite');
            $this->success("取消收藏成功！", '', ['num' => (int) $info['favorite'] - 1]);
        } else {
            //收藏
            Db::name('favorite')->insert([
                'tid'         => $catid . '-' . $id,
                'uid'         => $this->userid,
                'title'       => $info['title'],
                'create_time' => time(),
            ]);
            Db::name($tablename)->where('id', $id)->setInc('favorite');
            $this->success("收藏成功！", '', ['num' => (int) $info['favorite'] + 1]);
        }
    }
}
