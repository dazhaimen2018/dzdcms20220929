<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 * 站点域名管理
 */
namespace app\cms\controller;


use app\cms\model\SiteDomain;
use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\Db;
use think\facade\Cache;

class Domain extends Adminbase
{

    protected $searchFields = 'id,domain';
    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new SiteDomain();
    }
    /**
     * 域名列表
     */
    public function index()
    {
        $siteId = $this->request->param('id/d', '');
        if (empty($siteId)) {
            $this->error('参数错误！');
        }
        //输出所有站点
        $sites = cache('Site')?cache('Site'):Site::where('status',1)->column('*','id');
        $site  = [];
        foreach ($sites as $v) {
            if ($v['id'] == $siteId) {
                $site[] = $v;
            }
        }
        $site = $site[0];
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $_list                      = $this->modelClass->where($where)->where('sites', $siteId)->order(['listorder' => 'desc', 'id' => 'desc'])->page($page, $limit)->select();
            $total  = $this->modelClass->where($where)->where('sites', $siteId)->count();
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        $this->assign([
            "siteId" => $siteId,
            "name"    => $site['name'],
        ]);
        return $this->fetch();
    }

    /**
     * 站点域名
     */
    public function add()
    {
        $siteId = $this->request->param('siteId/d', '');
        if (empty($siteId)) {
            $this->error('参数错误！');
        }
        if ($this->request->isPost()) {
            $data   = $this->request->post();
            $result = $this->validate($data, 'site_domain');
            if (true !== $result) {
                return $this->error($result);
            }
            $data['create_time'] = time();
            if ($row = SiteDomain::create($data)) {
                //更新缓存
                Cache::set('Domain',null);
                return $this->success('域名添加成功~', url('index'));
            } else {
                $this->error("添加失败！");
            }
        } else {
            $this->assign(
                [
                    "siteId"   => $siteId,
                ]
            );
            return $this->fetch();
        }
    }

    /**
     * 属性删除
     */
    public function del()
    {
        $ids = $this->request->param('id/d');
        if (!is_numeric($ids) || $ids < 0) {
            return '参数错误';
        }
        if (SiteDomain::where(['id' => $ids])->delete()) {
            cache('Domain', null); //清空缓存配置
            SiteDomain::where(['id' => $ids])->delete();
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    //更新站点缓存
    public function cache() {
        $domains = SiteDomain::where('status',1)->column('*','id');
        Cache::set('Domain',$domains);
        $this->success("域名缓存更新成功！");
    }

}
