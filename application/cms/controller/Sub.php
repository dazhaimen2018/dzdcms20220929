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
// | cms管理
// +----------------------------------------------------------------------
namespace app\cms\controller;

use app\cms\model\Sub as SubModel;
use app\cms\model\Page as Page_Model;
use app\cms\model\Site;
use app\common\controller\Adminbase;
use think\Db;


class Sub extends Adminbase
{
    protected function initialize()
    {
        parent::initialize();
        $this->SubModel = new SubModel;
        $this->cmsConfig = cache("Cms_Config");
        $this->assign("cmsConfig", $this->cmsConfig);
        // 20200805 马博所有站点
        $sites    = $this->auth->site_id;
        if ($sites) {
            $whereSite = " id = $sites";
        }else{
           if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
               $sites     = cache("Cms_Config")['site'];
               if(!$sites){ //不满条件
                   $this->error('请在CMS配置-切换站点中选一个站！','cms/setting/index');
               }
               $whereSite = " id = $sites";
           }
        }
        $catid    = $this->request->param('catid/d', 0);
        $catSites = getCategory($catid,'sites'); //当前栏目所属站点
        if($catSites){
            $whereIn  = " id in($catSites)";
        }
        $sites  = Site::where(['alone' => 1])->where($whereIn)->where($whereSite)->select()->toArray();
        $this->site = $sites;
        $this->view->assign('sites', $sites);
        // 20200805 马博 end
    }


    //栏目信息列表
    public function index()
    {
        $catid = $this->request->param('catid/d', 0);
        //当前栏目信息
        $catInfo = getCategory($catid);
        if (empty($catInfo)) {
            $this->error('该栏目不存在！');
        }
        //栏目所属模型
        $modelid   = $catInfo['modelid'];
        $modelType = db('model')->where('id',$modelid)->cache(60)->value('type');
        if ($this->request->isAjax()) {
            // 20200805 马博
            $limit = $this->request->param('limit/d', 10);
            $page = $this->request->param('page/d', 1);
            // 20200805 马博 end
            //检查模型是否被禁用
            if (!getModel($modelid, 'status')) {
                $this->error('模型被禁用！');
            }
            $modelCache = cache("Model");
            $tableName  = $modelCache[$modelid]['tablename'];

            $this->modelClass = Db::name($tableName);
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($page, $limit, $where) = $this->buildTableParames();

            $conditions = [
                ['catid', '=', $catid],
                ['status', 'in', [0, 1]],
            ];
            $total   = Db::name($tableName)->where($where)->where($conditions)->count();
            $list    = Db::name($tableName)->page($page, $limit)->where($where)->where($conditions)->order('listorder DESC, id DESC')->select();
            $siteId  = onSite();
            $siteUrl = onSiteUrl();
            $_list   = [];
            foreach ($list as $k => $v) {
                $v['updatetime'] = date('Y-m-d H:i', $v['updatetime']);
                $v['url']        = $siteUrl.buildContentUrl($v['catid'], $v['id'], $v['url']);
                //马博 显示已添站点ID
                $sites           = Db::name($tableName . '_data')->where('did', $v['id'])->field('site_id as id')->select();
                $v['site']       = array_column($sites,'id');
                if($siteId){
                    $v['title']  = Db::name($tableName . '_data')->where('did', $v['id'])->where('site_id', $siteId )->value('title');
                } else {
                    $v['title']  = '发布模式为“单站”模式时才显示标题！';
                }
                $v['modelType'] = $modelType;
                // end
                $_list[]         = $v;
            }
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);

        }
        /*移动栏目 复制栏目*/
        $tree       = new \util\Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $categorys  = array();
        $result     = Db::name('category')->order('listorder DESC, id DESC')->select();
        foreach ($result as $k => $v) {
            if ($v['type'] != 2) {
                $v['disabled'] = 'disabled';
            }
            if ($modelid && $modelid != $v['modelid']) {
                $v['disabled'] = 'disabled';
            }
            //$v['disabled'] = $v['child'] ? 'disabled' : '';
            $v['selected'] = $v['id'] == $catid ? 'selected' : '';
            $categorys[$k] = $v;
        }
        $str = "<option value=@id @selected @disabled>@spacer @catname</option>";
        $tree->init($categorys);
        $string = $tree->getTree(0, $str, $catid);
        // 20200620 马博
        $siteArray = Site::where("status=1")->select()->toArray();
        // 20200620 end 马博
        $this->assign([
            'string' => $string,
            'catid'  => $catid,
            'site'   => $siteData,
        ]);
        return $this->fetch();
    }


    //添加信息

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
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

                Db::startTrans();
                try {
                    $insertId = $this->SubModel->addModelDataAll($data['modelField'], $data['modelFieldExt'], $data['extra_data']);
                    Db::commit();
                } catch (\Exception $ex) {
                    Db::rollback();
                    $this->error($ex->getMessage());
                }

            }
            //增加清除缓存
            //$cache =  cleanUp();
            $this->success('操作成功！');
        } else {
            $catid = $this->request->param('catid/d', 0);
            $import = $this->request->param('import/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $modelid = $category['modelid'];
                $fieldList = $this->SubModel->getFieldListAll($modelid);
                $subFieldList = $this->SubModel->getExtraField($modelid, 2);
                $this->assign([
                    'catid'     => $catid,
                    'fieldList' => $fieldList,
                    'subFieldList' => $subFieldList,
                ]);
                return $this->fetch();
            }
        }
    }


    //编辑信息
    public function edit()
    {
        if ($this->request->isPost()) {
            $data                  = $this->request->post();
            $data['modelFieldExt'] = isset($data['modelFieldExt']) ? $data['modelFieldExt'] : [];
            $data['modelField']['id'] = intval($_GET['id']);
            $catid = intval($data['modelField']['catid']);
            $category = getCategory($catid);

            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                try {
                    $this->SubModel->editModelDataAll($data['modelField'], $data['modelFieldExt'], $data['extra_data']);
                } catch (\Exception $ex) {
                    $this->error($ex->getMessage());
                }
            }
            //增加清除缓存
            $cache =  cleanUp();
            $this->success('编辑成功！');

        } else {
            $catid    = $this->request->param('catid/d', 0);
            $import   = $this->request->param('import/d', 0);
            $id       = $this->request->param('id/d', 0);
            $category = getCategory($catid);
            if (empty($category)) {
                $this->error('该栏目不存在！');
            }
            if ($category['type'] == 2) {
                $modelid   = $category['modelid'];
                $fieldList = $this->SubModel->getFieldListAll($modelid, $id);
                $subFieldList = $this->SubModel->getExtraField($modelid, 2);
                $this->assign([
                    'catid'     => $catid,
                    'id'        => $id,
                    'fieldList' => $fieldList,
                    'subFieldList' => $subFieldList,
                ]);
                $subData = $this->SubModel->getsubData(['catid' => $catid, 'did' => $id]);
                $ret = [];
                if($import){
                    foreach ($this->site as $k => $s) {

                        if ($subData) {
                            foreach ($subData as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $ret[$k] = $e;
                                    $ret[$k]['id'] = $e['id'];
                                } else {
                                    //只输出站点1的数据
                                    foreach ($subData as $f) {
                                        if ($e['site_id']== 1) {
                                            $ret[$k] = $f;
                                            $ret[$k]['site_id'] = $s['id'];
                                            $ret[$k]['id'] = '';
                                        }
                                    }
                                }
                            }
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                        }
                    }
                }else{
                    foreach ($this->site as $k => $s) {
                        if ($subData) {
                            foreach ($subData as $e) {
                                if ($e['site_id'] == $s['id']) {
                                    $ret[$k] = $e;
                                } else {
                                    $ret[$k]['site_id'] = $s['id'];
                                }
                            }
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                        }
                    }
                }
                $this->view->assign('extra_data', $ret);
                return $this->fetch();
            }
        }
    }

    //删除
    public function del()
    {
        $this->check_priv('delete');
        $catid = $this->request->param('catid/d', 0);
        $ids   = $this->request->param('ids/a', null);
        if (empty($ids) || !$catid) {
            $this->error('参数错误！');
        }
        if (!is_array($ids)) {
            $ids = array(0 => $ids);
        }
        $modelid   = getCategory($catid, 'modelid');
        try {
            foreach ($ids as $id) {
                $this->SubModel->deleteModelData($modelid, $id, $this->cmsConfig['web_site_recycle']);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        $this->success('删除成功！');
    }



    protected function getAdminPostData($date = '')
    {
        if ($date) {
            list($start, $end) = explode(' - ', $date);
            $start_time        = strtotime($start);
            $end_time          = strtotime($end);
        } else {
            $start_time = \util\Date::unixtime('day', 0, 'begin');
            $end_time   = \util\Date::unixtime('day', 0, 'end');
        }
        $diff_time = $end_time - $start_time;
        $format    = '%Y-%m-%d';
        if ($diff_time > 86400 * 30 * 2) {
            $format = '%Y-%m';
        } else {
            if ($diff_time > 86400) {
                $format = '%Y-%m-%d';
            } else {
                $format = '%H:00';
            }
        }
        //获取所有表名
        $models = array_values(cache('Model'));
        $list   = $xAxisData   = $seriesData   = [];
        if (count($models) > 0) {
            $table1 = $models[0]['tablename'];
            unset($models[0]);
            $field = 'a.username,uid,FROM_UNIXTIME(inputtime, "' . $format . '") as inputtimes,COUNT(*) AS num';
            $dbObj = Db::name($table1)->alias('b')->field($field)->where('inputtime', 'between time', [$start_time, $end_time])->join('admin a', 'a.id = b.uid');
            foreach ($models as $k => $v) {
                $dbObj->union(function ($query) use ($field, $start_time, $end_time, $v) {
                    $query->name($v['tablename'])->alias('b')->field($field)->where('inputtime', 'between time', [$start_time, $end_time])->join('admin a', 'a.id = b.uid')->group('uid,inputtimes');
                });
            };
            $res = $dbObj->group('uid,inputtimes')->select();
            if ($diff_time > 84600 * 30 * 2) {
                $start_time = strtotime('last month', $start_time);
                while (($start_time = strtotime('next month', $start_time)) <= $end_time) {
                    $column[] = date('Y-m', $start_time);
                }
            } else {
                if ($diff_time > 86400) {
                    for ($time = $start_time; $time <= $end_time;) {
                        $column[] = date("Y-m-d", $time);
                        $time += 86400;
                    }
                } else {
                    for ($time = $start_time; $time <= $end_time;) {
                        $column[] = date("H:00", $time);
                        $time += 3600;
                    }
                }
            }
            $xAxisData = array_fill_keys($column, 0);
            foreach ($res as $k => $v) {
                if (!isset($list[$v['username']])) {
                    $list[$v['username']] = $xAxisData;
                }
                $list[$v['username']][$v['inputtimes']] = $v['num'];
            }
            foreach ($list as $index => $item) {
                $seriesData[] = [
                    'name'      => $index,
                    'type'      => 'line',
                    'smooth'    => true,
                    'areaStyle' => [],
                    'data'      => array_values($item),
                ];
            }
        }
        return [array_keys($xAxisData), $seriesData];
    }


    /**
     * 排序
     */
    public function listorder()
    {
        $this->check_priv('listorder');
        $catid      = $this->request->param('catid/d', 0);
        $id         = $this->request->param('id/d', 0);
        $listorder  = $this->request->param('value/d', 0);
        $modelid    = getCategory($catid, 'modelid');
        $modelCache = cache("Model");
        if (empty($modelCache[$modelid])) {
            return false;
        };
        $tableName = $modelCache[$modelid]['tablename'];
        if (Db::name($tableName)->where('id', $id)->update(['listorder' => $listorder])) {
            $this->success("排序成功！");
        } else {
            $this->error("排序失败！");
        }
    }


    //状态
    public function setstate()
    {
        $this->check_priv('status');
        $catid      = $this->request->param('catid/d', 0);
        $id         = $this->request->param('id/d', 0);
        $status     = $this->request->param('value/d');
        $modelid    = getCategory($catid, 'modelid');
        $modelCache = cache("Model");
        if (empty($modelCache[$modelid])) {
            return false;
        };
        $tableName = ucwords($modelCache[$modelid]['tablename']);
        if (Db::name($tableName)->where('id', $id)->update(['status' => $status])) {
            //更新栏目缓存
            cache('Category', null);
            getCategory($id, '', true);
            $this->success('操作成功！');
        } else {
            $this->error('操作失败！');
        }
    }

    public function check_title()
    {
        $title = $this->request->param('data/s', '');
        $catid = $this->request->param('catid/d', 0);
        $id    = $this->request->param('id/d', 0);
        if (empty($title)) {
            $this->success('标题没有重复！');
            return false;
        }
        $modelid    = getCategory($catid, 'modelid');
        $modelCache = cache("Model");
        if (empty($modelCache[$modelid])) {
            $this->error('模型不存在！');
            return false;
        };
        $tableName = ucwords($modelCache[$modelid]['tablename']);
        $repeat    = Db::name($tableName)->where('title', $title);
        empty($id) ?: $repeat->where('id', '<>', $id);
        if ($repeat->find()) {
            $this->error('标题有重复！');
        } else {
            $this->success('标题没有重复！');
        }
    }

    //批量更新
    public function multi()
    {
        // 管理员禁止批量操作
        $this->error();
    }

    protected function check_priv($action)
    {
        if ($this->auth->isAdministrator() !== true) {
            if (0 !== (int) $this->cmsConfig['site_category_auth']) {
                $catid      = $this->request->param('catid/d', 0);
                $action     = getCategory($catid, 'type') == 1 ? 'init' : $action;
                $priv_datas = Db::name('CategoryPriv')->where(['catid' => $catid, 'is_admin' => 1, 'roleid' => $this->auth->roleid, 'action' => $action])->find();
                if (empty($priv_datas)) {
                    $this->error('您没有操作该项的权限！');
                }
            }
        }
    }

}
