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
// | webim管理
// +----------------------------------------------------------------------
namespace app\webim\controller;

use app\admin\service\User;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use util\Random;

class Init extends Controller
{
    protected $token = [];
    protected $info  = false;

    public function index()
    {
        $config       = [];
        $msg          = '';
        $Webim_Config = cache('Webim_Config');
        $allow        = [
            'port',
        ];
        foreach ($allow as $k => $v) {
            if (isset($Webim_Config[$v])) {
                $config[$v] = $Webim_Config[$v];
            }
        }
        $module                        = $this->request->request('module');
        $visitors_token                = $this->request->request('visitors_token');
        $this->token['visitors_token'] = $visitors_token ? $visitors_token : Cookie::get('visitors_token');
        if ($module == 'admin' && User::instance()->isLogin()) {
            //管理员
            $uid        = User::instance()->isLogin();
            $this->info = Db::name('admin')->field('id,username,nickname,token')->where('id', $uid)->find();
            if ($this->info) {
                $this->token['admin_token'] = $this->keeplogin($this->info['id'], $this->info['token'], 86400);
                unset($this->info['token']);
            }
        } elseif ($module == 'index') {
            //游客
            if ($this->token['visitors_token'] && !$this->info) {
                $this->info = $this->check_visitors($this->token['visitors_token']);
            }
            if (!$this->info) {
                $max_id   = Db::name('webim_visitors')->max('id');
                $token    = Random::uuid();
                $visitors = [
                    'name'        => '游客 ' . $max_id,
                    'token'       => $token,
                    'ip'          => $this->request->ip(),
                    'create_time' => time(),
                ];
                if (Db::name('webim_visitors')->insert($visitors)) {
                    $id                            = Db::name('webim_visitors')->getLastInsID();
                    $this->token['visitors_token'] = $this->keeplogin($id, $token, 86400);
                    Cookie::set('visitors_token', $this->token['visitors_token']);
                    $this->info = $this->check_visitors($visitors_token);
                } else {
                    $this->ajaxReturn([
                        'data' => null,
                        'msg'  => '游客创建失败！',
                        'code' => -1,
                    ]);
                }
            }
        }
        $config['token'] = $this->token;
        $config['info']  = $this->info;
        $this->ajaxReturn([
            'data' => $config,
            'msg'  => '',
            'code' => 1,
        ]);
    }

    protected function keeplogin($id, $token, $keeptime = 0)
    {
        if ($keeptime) {
            $expiretime = time() + $keeptime;
            $key        = md5(md5($id) . md5($keeptime) . md5($expiretime) . $token);
            return implode('|', [$id, $keeptime, $expiretime, $key]);
        }
        return false;
    }

    public function check_visitors($visitors)
    {
        list($id, $keeptime, $expiretime, $key) = explode('|', $visitors);
        if ($id && $keeptime && $expiretime && $key && $expiretime > time()) {
            $visitors = Db::name('webim_visitors')->where('id', $id)->find();
            if (!$visitors || !$visitors['token']) {
                return false;
            }
            if ($key != md5(md5($id) . md5($keeptime) . md5($expiretime) . $visitors['token'])) {
                return false;
            }
        } else {
            return false;
        }
        $visitors['type'] = 'visitors';
        unset($visitors['token']);
        return $visitors;
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @param int $json_option 传递给json_encode的option参数
     * @return void
     */
    protected function ajaxReturn($data, $type = 'JSON', $json_option = 0)
    {
        $data['state'] = $data['code'] ? "success" : "fail";
        switch (strtoupper($type)) {
            case 'JSON':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                exit(json_encode($data, $json_option));
            case 'XML':
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = $this->request->param('callback/s', 'callback');
                exit($handler . '(' . json_encode($data, $json_option) . ');');
            case 'EVAL':
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default:
                // 用于扩展其他返回格式数据
                //tag('ajax_return', $data);
        }
    }

}
