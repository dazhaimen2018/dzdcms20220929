<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 */
namespace app\cms\controller;

use addons\translator\Translator;
use app\cms\model\Lang as Lang_Model;
use app\common\controller\Adminbase;
use think\Db;
use app\cms\model\Site;
use app\cms\model\LangData;
use app\cms\model\Lang as LangMode;
use think\facade\Env;

class Lang extends Adminbase
{
	public $banfie;
    protected $searchFields = 'id,name,title';
	protected function initialize()
	{
		parent::initialize();
        $this->modelClass = new LangMode;
		//允许使用的字段列表
		$this->banfie = array("text", "checkbox", "textarea", "radio", "number", "datetime", "image", "images", "array", "switch", "select", "Ueditor", "file", "files", 'color', 'tags', 'markdown');

        // 20200805 马博所有站点
        $sites     = $this->auth->sites;
        $whereSite = '';
        if ($sites) {
            $whereSite = " id = $sites";
        }else{
            if(isset(cache("Cms_Config")['publish_mode']) && 2 == cache("Cms_Config")['publish_mode']) {
                $sites     = cache("Cms_Config")['site'];
                if(!$sites){
                    $this->error('请在CMS配置-切换站点中选一个站！','cms/setting/index');
                }
                $whereSite = " id = $sites";
            }
        }
        $private = onPrivate();
        $sites   = Site::where('private', $private)->where('alone', 1)->where($whereSite)->select()->toArray();
        $this->site = $sites;

        // 20200805 马博 end
        $langGroups = Db::name('langGroup')->select();
        $this->assign([
            'sites'      => $sites,
            'langGroups' => $langGroups,
            'private'    => $private,
        ]);
	}

	//碎片首页
	public function index($group = 1)
	{
        if ($this->request->isAjax()) {
            list($page, $limit, $where) = $this->buildTableParames();
            $private = onPrivate();
            $list    = $this->modelClass->where('private', $private)->where($where)
                ->where('group', $group)
                ->order(["listorder" => "ASC", "id" => "DESC"])
                ->page($page, $limit)->select();
            $_list  = [];
            foreach ($list as $k => $v) {
                $sites      = Db::name('lang_data')->where('lang_id', $v['id'])->field('site_id as id')->select();
                $v['site']  = array_column($sites,'id');
                $_list[]    = $v;
            }
            $total = $this->modelClass->where('private', $private)->where($where)->where('group', $group)->count();
            $result = array("code" => 0, "count" => $total, "data" => $_list);
            return json($result);
        }
        $this->assign('group', $group);
        return $this->fetch();
	}

	//新增配置
	public function add()
	{
        $group = $this->request->param('group/d');
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$data['status'] = isset($data['status']) ? intval($data['status']) : 1;
			$result = $this->validate($data, 'lang');
			if (true !== $result) {
				return $this->error($result);
			}
				$lang = Lang_Model::create($data);
				if($lang){
				$this->addLangData($data['lang_data'], $lang['id']);
				return $this->success('碎片添加成功~', url('index'));
				}else{
					return $this->error('碎片编辑失败！');
				}
		} else {
			$fieldType = Db::name('field_type')->where('name', 'in', $this->banfie)->order('listorder')->column('name,title,ifoption,ifstring');
			$this->assign([
				'groupArray' => lang('lang_group'),
				'fieldType'  => $fieldType,
				'group'      => $group,
			]);
			return $this->fetch('add');
		}
	}

	public function addLangData($LangData, $langId)
	{
		if ($LangData) {

			foreach ($LangData as $l) {
				if (trim($l['value'])) {
					$model       = new LangData();
					$model->value     = trim($l['value']);
					$model->site_id     = $l['site_id'];
					$model->lang_id       = $langId;
					$model->save();
				}
			}
		}
	}


	public function updateLangData($LangData)
	{
		if ($LangData) {

			foreach ($LangData as $l) {
				if (trim($l['value'])) {
					if($l['id']){
						LangData::where(['id'=>$l['id']])->update(['value'=>$l['value']]);
					}else{
						$model       = new LangData();
						$model->value     = trim($l['value']);
						$model->site_id     = $l['site_id'];
						$model->lang_id       = $l['lang_id'];
						$model->save();
					}
				}
			}
		}
	}

	//编辑配置
	public function edit()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$result = $this->validate($data, 'lang');
			if (true !== $result) {
				return $this->error($result);
			}
			if (Lang_Model::update($data)) {

				$this->updateLangData($data['lang_data']);
				cache('lang', null); //清空缓存配置
				$this->success('碎片修改成功~', url('index'));
			} else {
				$this->error('碎片修改失败！');
			}
		} else {
			$id = $this->request->param('id/d');
			if (!is_numeric($id) || $id < 0) {
				return '参数错误';
			}
			$fieldType = Db::name('field_type')->where('name', 'in', $this->banfie)->order('listorder')->column('name,title,ifoption,ifstring');
			$info = Lang_Model::get($id);
			$lang_data = LangData::where(['lang_id'=>$id])->select()->toArray();
            $ret = [];
            foreach ($this->site as $k => $s) {
                if ($lang_data) {
                    foreach ($lang_data as $e) {
                        if ($e['site_id'] == $s['id']) {
                            $ret[$k] = $e;
                        } else {
                            $ret[$k]['site_id'] = $s['id'];
                            $ret[$k]['lang_id'] = $id;
                        }
                    }
                } else {
                    $ret[$k]['site_id'] = $s['id'];
                    $ret[$k]['lang_id'] = $id;
                }
            }
            // 马博增加 end
			$this->assign([
				'groupArray' => lang('lang_group'),
				'fieldType' => $fieldType,
				'info' => $info,
				'lang_data'=>$ret,
				'lang_id'=>$id,
			]);
			return $this->fetch();
		}
	}

	//删除配置
	public function del()
	{
		$ids = $this->request->param('ids/d');
		if (!is_numeric($ids) || $ids < 0) {
			return '参数错误';
		}
		if (Lang_Model::where(['id' => $ids])->delete()) {
			cache('lang', null); //清空缓存配置
            LangData::where(['lang_id' => $ids])->delete();
			$this->success('删除成功');
		} else {
			$this->error('删除失败！');
		}
	}

	//排序
	public function listorder()
	{
		$id = $this->request->param('id/d', 0);
		$listorder = $this->request->param('value/d', 0);
		$rs = Lang_Model::update(['listorder' => $listorder], ['id' => $id], true);
		if ($rs) {
			$this->success("排序成功！");
		} else {
			$this->error("排序失败！");
		}
	}

	//设置配置状态
	public function setstate($id, $status)
	{
		$id = $this->request->param('id/d');
		empty($id) && $this->error('参数不能为空！');
		$status = $this->request->param('status/d');
		if (Lang_Model::update(['status' => $status], ['id' => $id])) {
			cache('lang', null); //清空缓存配置
			$this->success('操作成功！');
		} else {
			$this->error('操作失败！');
		}
	}

    //更新碎片缓存
    public function cache() {
        $filepath = Env::get('APP_PATH').'lang'.DIRECTORY_SEPARATOR;
        if (!is_dir($filepath)){
            mkdir($filepath,0777,true);
        }
        //加默认值
        foreach ($this->site as $key => $value){
            $filename = $value['mark'].'.php';
            $config = Db::name('lang')->alias('l')
                ->join('lang_data ld','ld.lang_id=l.id and ld.site_id='.$value['id'],'LEFT')
                ->where('l.group','<>',3)
                ->where('l.status',1)
                ->column('ld.value as v1,l.value as v2','l.name');
            $data = <<<EOT
<?php
return [ \r\n
EOT;
            foreach ($config as $ca => $cv){
                $cvv = $cv['v1']?$cv['v1']:$cv['v2'];
                $data .= <<<EOT
    '{$ca}' => "{$cvv}",\r\n
EOT;
            }
            $data .= <<<EOT
];
EOT;
            file_put_contents($filepath.$filename, $data,LOCK_EX);
        }
        $this->success("碎片缓存更新成功！");
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
}
