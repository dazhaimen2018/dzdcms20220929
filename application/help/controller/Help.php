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
// | 栏目管理
// +----------------------------------------------------------------------
namespace app\help\controller;

use app\help\model\Help as HelpModel;
use app\common\controller\Adminbase;
use think\Db;

class Help extends Adminbase
{

    private $filepath;
    private $tp_help;
    private $tp_list;
    private $tp_show;
    private $tp_page;

    protected $noNeedRight = [
        'help/help/count_items',
        'help/help/public_cache',
    ];
    protected $searchFields = 'id,catname';
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new HelpModel;
        //取得当前内容模型模板存放目录
        $this->filepath = TEMPLATE_PATH . (empty(config('theme')) ? "default" : config('theme')) . DIRECTORY_SEPARATOR . "cms" . DIRECTORY_SEPARATOR;
        $themePath = TEMPLATE_PATH . (config('theme') ?: "default") . DS . "cms" . DS;
        //取得栏目频道模板列表
        $this->tp_help = str_replace($this->filepath . DIRECTORY_SEPARATOR, '', glob($this->filepath . DIRECTORY_SEPARATOR . 'help*'));
        //取得栏目列表模板列表
        $this->tp_list = str_replace($this->filepath . DIRECTORY_SEPARATOR, '', glob($this->filepath . DIRECTORY_SEPARATOR . 'list*'));
        //取得内容页模板列表
        $this->tp_show = str_replace($this->filepath . DIRECTORY_SEPARATOR, '', glob($this->filepath . DIRECTORY_SEPARATOR . 'show*'));
        //取得单页模板
        $this->tp_page = str_replace($this->filepath . DIRECTORY_SEPARATOR, '', glob($this->filepath . DIRECTORY_SEPARATOR . 'page*'));
    }

    //栏目列表
    public function index()
    {
        if ($this->request->isAjax()) {
            $models     = cache('Model');
            $tree       = new \util\Tree();
            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $helps  = array();
            $result     = Db::name('help')->order(array('listorder', 'id' => 'ASC'))->select();
            foreach ($result as $k => $v) {
                if (isset($models[$v['modelid']]['name'])) {
                    $v['modelname'] = $models[$v['modelid']]['name'];
                } else {
                    $v['modelname'] = '/';
                }
                $v['catname'] = '<a data-width="900px" data-height="600px" data-open="' . url('edit', ['id' => $v['id']]) . '"">' . $v['catname'] . '</a>';
                if ($v['type'] == 1) {
                    $v['add_url'] = url("Help/singlepage", array("parentid" => $v['id']));
                } elseif ($v['type'] == 2) {
                    $v['add_url'] = url("Help/add", array("parentid" => $v['id']));
                } elseif ($v['type'] == 3) {
                    $v['add_url'] = url("Help/wadd", array("parentid" => $v['id']));
                }
                $v['url']            = buildCatUrl($v['id'], $v['url']);
                $helps[$v['id']] = $v;
            }
            $tree->init($helps);
            $_list  = $tree->getTreeList($tree->getTreeArray(0), 'catname');
            $total  = count($_list);
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        return $this->fetch();
    }

    //新增栏目
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (empty($data)) {
                $this->error = '添加栏目数据不能为空！';
                return false;
            }
            switch ($data['type']) {
                //列表
                case 2:
                    $fields = ['parentid', 'catname', 'catdir', 'type', 'modelid', 'image', 'icon', 'description', 'url', 'setting', 'listorder', 'letter', 'status'];
                    $scene  = 'list';
                    break;
                default:
                    $this->error('栏目类型错误~');
            }
            if ($data['isbatch']) {
                unset($data['isbatch'], $data['info']['catname'], $data['info']['catdir']);
                //需要批量添加的栏目
                $batch_add = explode(PHP_EOL, $data['batch_add']);
                if (empty($batch_add) || empty($data['batch_add'])) {
                    $this->error('请填写需要添加的栏目！');
                }
                foreach ($batch_add as $rs) {
                    if (trim($rs) == '') {
                        continue;
                    }
                    $cat             = explode('|', $rs, 2);
                    $data['catname'] = $cat[0];
                    $data['catdir']  = isset($cat[1]) ? $cat[1] : '';
                    $data['catdir']  = $this->get_dirpinyin($data['catname'], $data['catdir']);

                    $result = $this->validate($data, 'Help.' . $scene);
                    if (true !== $result) {
                        $this->error($result);
                    }
                    $catid = $this->modelClass->addHelp($data, $fields);

                }
                $this->success("添加成功！", url("Help/index"));
            } else {
                $data['catdir'] = $this->get_dirpinyin($data['catname'], $data['catdir']);
                $result         = $this->validate($data, 'Help.' . $scene);
                if (true !== $result) {
                    $this->error($result);
                }
                //20200518 ethan update: $res should be a string, not arrays.
                $catid = $this->modelClass->addHelp($data, $fields);
                if ($catid) {
                    $this->success("添加成功！", url("Help/index"));
                } else {
                    $error = $this->modelClass->getError();
                    $this->error($error ? $error : '栏目添加失败！');
                }
            }

        } else {
            $parentid = $this->request->param('parentid/d', 0);
            if (!empty($parentid)) {
                $Ca = getHelp($parentid);
                if (empty($Ca)) {
                    $this->error("父栏目不存在！");
                }
            }
            //输出可用模型
            $modelsdata = cache("Model");
            $models     = array();
            foreach ($modelsdata as $v) {
                if ($v['status'] == 1 && $v['module'] == 'custom') {
                    $models[] = $v;
                }
            }
            //栏目列表 可以用缓存的方式
            $array = Db::name('Help')->order('listorder ASC, id ASC')->column('*', 'id');
            if (!empty($array) && is_array($array)) {
                $tree       = new \util\Tree();
                $tree->icon = array('&nbsp;&nbsp;│ ', '&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;└─ ');
                $tree->nbsp = '&nbsp;&nbsp;';
                $str        = "<option value=@id @selected @disabled>@spacer @catname</option>";
                $tree->init($array);
                $helpdata = $tree->getTree(0, $str, $parentid);
            } else {
                $helpdata = '';
            }


            $this->assign('parentid_modelid', isset($Ca['modelid']) ? $Ca['modelid'] : 0);
            if (isModuleInstall('member')) {
                //会员组
                $this->assign("Member_Group", cache("Member_Group"));
            }
            $this->assign("help", $helpdata);
            $this->assign("models", $models);
            return $this->fetch();

        }

    }


    //编辑栏目
    public function edit()
    {
        if ($this->request->isPost()) {
            $catid = $this->request->param('id/d', 0);
            if (empty($catid)) {
                $this->error('请选择需要修改的栏目！');
            }
            $data = $this->request->post();
            //上级栏目不能是自身
            if ($data['parentid'] == $catid) {
                $this->error('上级栏目不能是自身！');
            }
            switch ($data['type']) {
                //单页
                case 1:
                    $data['modelid'] = 0;
                    $scene           = 'page';
                    break;
                //列表
                case 2:
                    $scene = 'list';
                    break;
                default:
                    $this->error('栏目类型错误~');
            }
            $data['catdir'] = $this->get_dirpinyin($data['catname'], $data['catdir'], $catid);
            $result         = $this->validate($data, 'Help.' . $scene);
            if (true !== $result) {
                $this->error($result);
            }
            $status = $this->modelClass->editHelp($data, ['parentid', 'catname', 'catdir', 'type', 'modelid', 'image', 'icon', 'description', 'url', 'setting', 'listorder', 'letter', 'status']);
            if ($status) {
                $this->success("修改成功！", url("Help/index"));
            } else {
                $error = $this->modelClass->getError();
                $this->error($error ? $error : '栏目修改失败！');
            }

        } else {
            $catid = $this->request->param('id/d', 0);
            if (empty($catid)) {
                $this->error('请选择需要修改的栏目！');
            }
            $data    = Db::name('help')->where(['id' => $catid])->find();
            $setting = unserialize($data['setting']);

            //输出可用模型
            $modelsdata = cache("Model");
            $models     = array();
            foreach ($modelsdata as $v) {
                if ($v['status'] == 1 && $v['module'] == 'cms') {
                    $models[] = $v;
                }
            }
            //栏目列表 可以用缓存的方式
            $array = Db::name('Help')->order('listorder ASC, id ASC')->column('*', 'id');
            if (!empty($array) && is_array($array)) {
                $tree       = new \util\Tree();
                $tree->icon = array('&nbsp;&nbsp;│ ', '&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;└─ ');
                $tree->nbsp = '&nbsp;&nbsp;';
                $str        = "<option value=@id @selected @disabled>@spacer @catname</option>";
                $tree->init($array);
                $helpdata = $tree->getTree(0, $str, $data['parentid']);
            } else {
                $helpdata = '';
            }


            $this->assign("data", $data);
            $this->assign("setting", $setting);
            $this->assign("help", $helpdata);
            $this->assign("models", $models);

            //权限数据

            if ($data['type'] == 1) {
                //单页栏目
                return $this->fetch("singlepage_edit");
            } else if ($data['type'] == 2) {
                //外部栏目
                return $this->fetch();
            } else {
                $this->error('栏目类型错误！');
            }
        }

    }

    //删除栏目
    public function del()
    {
        $ids = $this->request->param('id/a', null);
        if (empty($ids)) {
            $this->error('参数错误！');
        }
        if (!is_array($ids)) {
            $ids = array(0 => $ids);
        }
        try {
            foreach ($ids as $id) {
                $this->modelClass->deleteCatid($id);
            }
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

        $this->cache();
        $this->success("栏目删除成功！", url('cms/help/public_cache'));
    }


    //更新栏目缓存并修复
    public function public_cache()
    {
        $this->repair();
        $this->cache();
        $this->success("更新缓存成功！", Url("cms/help/index"));

    }

    //清除栏目缓存
    protected function cache()
    {
        cache('Help', null);
    }

    //修复栏目数据
    private function repair()
    {
        $this->helps = $helps = array();
        //取出需要处理的栏目数据
        $data = Db::name('Help')->order('listorder ASC, id ASC')->select();
        if (empty($data)) {
            return true;
        }
        foreach ($data as $v) {
            $helps[$v['id']] = $v;
        }
        $this->helps = $helps;
        if (is_array($helps)) {
            foreach ($helps as $catid => $cat) {
                //获取父栏目ID列表
                $arrparentid = $this->modelClass->get_arrparentid($catid);
                //栏目配置信息反序列化
                $setting = unserialize($cat['setting']);
                //获取子栏目ID列表
                $arrchildid = $this->modelClass->get_arrchildid($catid);
                $child      = is_numeric($arrchildid) ? 0 : 1; //是否有子栏目
                //检查所有父id 子栏目id 等相关数据是否正确，不正确更新
                if ($helps[$catid]['arrparentid'] !== $arrparentid || $helps[$catid]['arrchildid'] !== $arrchildid || $helps[$catid]['child'] !== $child) {
                    HelpModel::update(['arrparentid' => $arrparentid, 'arrchildid' => $arrchildid, 'child' => $child], ['id' => $catid], true);
                }
                \think\facade\Cache::rm('getHelp_' . $catid, null);
                //删除在非正常显示的栏目
                if ($cat['parentid'] != 0 && !isset($this->helps[$cat['parentid']])) {
                    $this->modelClass->deleteCatid($catid);
                }
            }

        }
        return true;
    }

    //重新统计栏目信息数量
    public function count_items()
    {
        $result      = Db::name('Help')->order('listorder ASC, id ASC')->select();
        $model_cache = cache("Model");
        foreach ($result as $r) {
            if ($r['type'] == 2) {
                $modelid = $r['modelid'];
                $number  = Db::name(ucwords($model_cache[$modelid]['tablename']))->where('catid', $r['id'])->count();
                Db::name('Help')->where('id', $r['id'])->update(['items' => $number]);
            }
        }
        $this->success("栏目数量校正成功！");
    }

    public function multi()
    {
        $id = $this->request->param('id/d');
        cache('Help', null);
        getHelp($id, '', true);
        return parent::multi();
    }

    //获取栏目的拼音
    private function get_dirpinyin($catname = '', $catdir = '', $id = 0)
    {
        $pinyin = new \Overtrue\Pinyin\Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        if (empty($catdir)) {
            $catdir = $pinyin->permalink($catname, '');
        }
        if (strval(intval($catdir)) == strval($catdir)) {
            $catdir .= genRandomString(3);
        }
        $map = [
            ['catdir', '=', $catdir],
        ];
        if (intval($id) > 0) {
            $map[] = ['id', '<>', $id];
        }
        $result = Db::name('Help')->field('id')->where($map)->find();
        if (!empty($result)) {
            $nowDirname = $catdir . genRandomString(3);
            return $this->get_dirpinyin($catname, $nowDirname, $id);
        }
        return $catdir;
    }

    //动态根据模型ID加载栏目模板
    public function public_tpl_file_list()
    {
        $id   = $this->request->param('id/d');
        $data = Db::name('Model')->where(array("id" => $id))->find();
        if ($data) {
            $json = ['code' => 0, 'data' => unserialize($data['setting'])];
            return json($json);
        }
    }

}
