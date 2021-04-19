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
// | 敏感词检测管理
// +----------------------------------------------------------------------
namespace addons\sensitive\Controller;

use app\addons\util\Adminaddon;
use think\Db;
use think\facade\Cache;
use util\Http;
use util\SensitiveHelper;

class Admin extends Adminaddon
{
    public function index()
    {

        return $this->fetch();
    }

    public function init()
    {
        $db_config = [];
        $data      = $this->request->post();
        if (!empty($data['hostname']) && !empty($data['database']) && !empty($data['username']) && !empty($data['password']) && !empty($data['prefix'])) {
            $db_config = [
                'type'     => 'mysql',
                'hostname' => $data['hostname'],
                'database' => $data['database'],
                'username' => $data['username'],
                'password' => $data['password'],
                'charset'  => 'utf8',
                'prefix'   => $data['prefix'],
            ];
        }
        //提取所有链接
        $db_link = [
            0 => url('cms/index/index', '', true, true),
        ];
        try {
            //栏目
            $cat = Db::connect($db_config)->name('Category')->where('status', 1)->order('id desc')->column('id');
            foreach ($cat as $k => $v) {
                $db_link[] = buildCatUrl($v, '', true, true);
            }
            //单页
            $page = Db::connect($db_config)->name('Page')->column('catid');
            foreach ($page as $k => $v) {
                $db_link[] = buildCatUrl($v, '', true, true);
            }
            //列表
            $modelList = cache('Model');
            $volist    = [];
            foreach ($modelList as $vo) {
                if ($vo['module'] == "cms") {
                    $volist = Db::connect($db_config)->name($vo['tablename'])->where('status', 1)->order('updatetime desc')->field('id,catid')->select();
                    foreach ($volist as $v) {
                        $db_link[] = buildContentUrl($v['catid'], $v['id'], '', true, true);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        Cache::set('db_link', $db_link, 600);
        $this->success('CMS模块' . count($db_link) . '条链接提取完毕！');
    }

    public function start()
    {
        $page    = $this->request->param('page/d', 0);
        $db_link = Cache::get('db_link');
        $count   = $db_link ? count($db_link) : 0;
        if ($count > 100) {
            $lun = round((100 / $count) * ($page + 1), 2);
        } else {
            $lun = round(($page + 1) / $count * 100, 1);
        }
        if (isset($db_link[$page])) {
            $content      = Http::get($db_link[$page]);
            $wordFilePath = ROOT_PATH . 'data/words.txt';
            $handle       = SensitiveHelper::init()->setTreeByFile($wordFilePath);
            $arr          = $handle->getBadWord($content);
            if ($arr) {
                $html .= '网址：' . $db_link[$page] . '<font>敏感词：【' . implode(',', $arr) . '】</font>';
                $this->success($html, null, ['code' => -1, 'page' => $page + 1, 'lun' => $lun]);
            } else {
                $this->success($html, null, ['code' => 1, 'page' => $page + 1, 'lun' => $lun]);
            }
        } else {
            $this->success('所有页面检测完毕', null, ['code' => 2]);
        }
    }
}
