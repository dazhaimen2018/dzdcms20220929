<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 */
namespace app\cms\controller;


use app\cms\model\FlagData;
use app\common\controller\Adminbase;
use app\cms\model\Flag as FlagModel;
use think\Db;
use think\facade\Cache;

class Flag extends Adminbase
{

    protected $searchFields = 'id,name';
	//初始化
	protected function initialize()
	{
		parent::initialize();
		$this->modelClass = new FlagModel;
	}
	/**
	 * 属性列表
	 */


    public function index()
    {
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $siteUrl                    = onSiteUrl();
            $onSiteId                   = onSiteId();
            $_list                      = $this->modelClass->where('sites', $onSiteId)->where($where)->order(['listorder' => 'desc', 'id' => 'desc'])->page($page, $limit)->select();
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
            $result = $this->validate($data, 'flag');
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
            if ($row = FlagModel::create($data)) {
                //更新缓存
                Cache::set('flag',null);
                return $this->success('属性添加成功~', url('index'));
            } else {
                $this->error("添加失败！");
            }
        } else {
            return $this->fetch();
        }
    }

	/**
	 * 属性编辑
	 */
	public function edit()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			try {
				$this->validate($data, 'flag');
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
            $data['update_time'] = time();
			if ($row = FlagModel::update($data)) {
				//更新缓存
                Cache::set('flag',null);
                return $this->success('站点修改成功~', url('index'));
			} else {
				$this->error("修改失败！");
			}
		} else {
            $id = $this->request->param('id/d', 0);
            $data   = FlagModel::where(["id" => $id])->find();
            if (empty($data)) {
                $this->error("该站点不存在！", url("index"));
            }
            $this->assign([
                'templates' => $this->flagTemplate,
                'data'      => $data,
            ]);
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
        if (FlagModel::where(['id' => $ids])->delete()) {
            cache('flag', null); //清空缓存配置
            FlagModel::where(['id' => $ids])->delete();
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    //更新属性缓存
    public function cache() {
        $flags = FlagModel::where('status',1)->column('*','id');
        Cache::set('Flag',$flags);
        $this->success("属性缓存更新成功！");
    }

    /**
     * 属性内容列表
     */
    public function lists()
    {
        $id = $this->request->param('id/d', '');
        if (empty($id)) {
            $this->error('参数错误！');
        }
        $flagData = cache("Flag")?cache("Flag"):FlagModel::where('status',1)->column('*','id');
        $flag  = [];
        foreach ($flagData as $v) {
            if ($v['id'] == $id) {
                $flag[] = $v;
            }
        }
        if (empty($flag)) {
            $this->error('该属性不存在！');
        }
        $siteUrl = onSiteUrl();
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $_list                      =  FlagData::where($where)->where("flagid", $id)->order(['listorder' => 'desc', 'id' => 'desc'])->page($page, $limit)->select();
            foreach ($_list as $k => $v) {
                $modelsdata = cache("Model");
                $models     = [];
                foreach ($modelsdata as $vo) {
                    if ($v['id'] == $v['modelid'] ) {
                        $models[] = $vo;
                    }
                }
                $v['url']     = $siteUrl.buildContentUrl($v['catid'], $v['did'], '');
                $v['catname'] = getCategory($v['catid'],'catname');
                $v['model']   = $models[0]['name'];
            }
            unset($v);
            $total  = FlagData::where($where)->where("flagid", $id)->count();
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        $this->assign([
            'flagId' => $id,
            'flag'   => $flag[0]['name'],
        ]);
        return $this->fetch();
    }

    /**
     * 属性内容移除
     */
    public function revoke()
    {
        $id     = $this->request->param('id/d', 0);
        $did     = $this->request->param('did/d', 0);
        $catid  = $this->request->param('catid/d', 0);
        $outid  = $this->request->param('outid/d', 0);
        if (empty($outid) || !$catid) {
            $this->error('参数错误！');
        }
        $modelid   = getCategory($catid, 'modelid');
        $modelInfo = cache('Model');
        $modelInfo = $modelInfo[$modelid];
        $flag      = Db::name($modelInfo['tablename'])->where('id', $did)->field('flag')->find();
        $flag      = explode(',',$flag['flag']);
        for ( $i=0; $i<count($flag); $i++ ){
            if($outid == $flag[$i]) unset($flag[$i]);
        }
        $flag = arr2str($flag);
        Db::name($modelInfo['tablename'])->where('id', $did)->update([
            'flag'		=>	$flag,
        ]);
        FlagData::where('id',$id)->delete();
        $this->success('移除成功！');
    }
}
