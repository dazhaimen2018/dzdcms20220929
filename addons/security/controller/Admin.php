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
// | 网站防篡改
// +----------------------------------------------------------------------
namespace addons\security\Controller;

use app\addons\util\Adminaddon;
use util\File;

class Admin extends Adminaddon
{
    protected $noNeedLogin = [
        'addons/security/check',
    ];

    /*
     * 安全文件列表
     */
    public function index()
    {
        $config = get_addon_config('security');
        if ($this->request->isAjax()) {
            $security_dir = ROOT_PATH . 'data/security/';
            if (!file_exists($security_dir)) {
                @mkdir($security_dir);
            }
            $finger_files = File::listFile($security_dir, '*.finger');
            foreach ($finger_files as $key => $val) {
                $finger_files[$key]['check_href'] = url('addons/security/check', ['isadmin' => 1, 'file' => md5($val['filename'])]);
                $finger_files[$key]['del_href']   = url('addons/security/del', ['isadmin' => 1, 'file' => md5($val['filename'])]);
                $finger_files[$key]['monitoring'] = url('addons/security/check', ['isadmin' => 1, 'file' => md5($val['filename']), 'md5' => $config['md5']], true, true);
                $finger_files[$key]['atime']      = date('Y-m-d H:i:s', $val['atime']);
                $finger_files[$key]['size']       = format_bytes($val['size']);
            }
            $result = array("code" => 0, "data" => $finger_files);
            return json($result);
        } else {
            return $this->fetch();
        }
    }

    /*
     * 安全文件生成
     */
    public function add()
    {
        $security_dir = ROOT_PATH . 'data/security/';
        if (!file_exists($security_dir)) {
            @mkdir($security_dir);
        }
        $filename = $security_dir . 'file_finger_' . date('YmdHi') . '_' . genRandomString(10) . '.finger';
        $f        = fopen($filename, 'w');
        fwrite($f, "GENE: RCF V" . config('version.yzncms_release') . "\n");
        fwrite($f, "TIME: " . date('Y-m-d H:i:s') . "\n");
        fwrite($f, "ROOT: \n");
        $files_md5 = [];
        foreach ([
            //检测目录
            'addons',
            'application',
            'config',
            'extend',
            'templates',
            'public',
            'route',
            'thinkphp',
            'vendor',
        ] as $dir) {
            foreach ($this->securityFilefingerGenerate(ROOT_PATH . $dir . '/', $dir . '/') as $file_md5) {
                $files_md5[] = $file_md5;
                fwrite($f, $file_md5[1] . '|' . $file_md5[0] . "\n");
            }
        }
        fclose($f);
        $this->success('成功生成安全文件');
    }

    /*
     * 安全检测
     */
    public function check()
    {
        $error_msgs = [];
        $md5        = $this->request->param('md5/s', '');
        $isLogin    = \app\admin\service\User::instance()->isLogin();
        $config     = get_addon_config('security');
        if ((empty($isLogin) && empty($md5)) || (empty($isLogin) && $md5 !== $config['md5'])) {
            $error_msgs[] = 'md5错误！';
        } else {
            $security_dir = ROOT_PATH . 'data/security/';
            if (!file_exists($security_dir)) {
                $error_msgs[] = '文件不存在！';
            }
            $md5_file = null;
            $file     = $this->request->param('file/s', '');
            foreach (File::listFile($security_dir, '*.finger') as $f) {
                if (md5($f['filename']) == $file) {
                    $md5_file = $f['pathname'];
                    break;
                }
            }
            if (null != $md5_file && !$error_msgs) {
                if (!file_exists($md5_file) || !is_file($md5_file)) {
                    $error_msgs[] = '文件不存在！';
                }
                $lines = explode("\n", file_get_contents($md5_file));
                if (count($lines) < 3) {
                    $error_msgs[] = '安全文件错误1！';
                }
                if (!preg_match('/^GENE: RCF V.*?$/', $lines[0]) || !preg_match('/^TIME: \\d+\\-\\d+\\-\\d+ \\d+:\\d+:\\d+$/', $lines[1]) || !preg_match('/^ROOT: ([\\/\\.]*)/', $lines[2])) {
                    $error_msgs[] = '安全文件错误2！';
                }
                $finger_file_root = trim(substr($lines[2], 5));
                unset($lines[0], $lines[1], $lines[2]);

                $file_should_exists = [];
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line) {
                        $l = explode('|', $line);
                        if (count($l) == 2) {
                            $file                      = trim($l[1]);
                            $md5                       = trim($l[0]);
                            $file_should_exists[$file] = $md5;
                            if (File::listFile($filename = ROOT_PATH . $file)) {
                                if ($md5 != md5_file($filename)) {
                                    $error_msgs[] = '文件被篡改 : ' . $file;
                                }
                            } else {
                                $error_msgs[] = '缺少文件 : ' . $file;
                            }
                        } else {
                            $error_msgs[] = '错误行 : ' . $line;
                        }
                    }
                }
            } else {
                $error_msgs['error'] = '文件不存在';
            }
            if (empty($isLogin) && $error_msgs && $config['email']) {
                $ems['email'] = $config['email'];
                $ems['title'] = "您的域名：" . request()->domain() . "，网站文件异常提醒！";
                $ems['msg']   = implode('<br>', $error_msgs);
                hook('ems_notice', $ems, true, true);
            }
        }
        $this->assign('error_msgs', $error_msgs);
        return $this->fetch();
    }

    /*
     * 安全文件删除
     */
    public function del()
    {
        $security_dir = ROOT_PATH . 'data/security/';
        if (!file_exists($security_dir)) {
            $this->error('文件不存在');
        }
        $file = input('file');
        foreach (File::listFile($security_dir, '*.finger') as $f) {
            if (md5($f['filename']) == $file) {
                @unlink($f['pathname']);
            }
        }
        $this->success('成功删除');
    }

    //安全文件生成
    private function securityFilefingerGenerate($dir = '', $prefix = '')
    {
        static $allow_file_exts = [
            'php'  => true,
            'js'   => true,
            'html' => true,
            'htm'  => true,
        ];
        $file_arrs = [];
        foreach (File::listFile($dir) as $file) {
            if ($file['isDir']) {
                $file_arrs = array_merge($file_arrs, $this->securityFilefingerGenerate($file['pathname'] . '/', $prefix . $file['filename'] . '/'));
            } else if ($file['isFile']) {
                if (isset($allow_file_exts[$file['ext']])) {
                    $file_saved  = $prefix . str_replace('\\', '/', $file['filename']);
                    $file_arrs[] = [
                        $file_saved,
                        md5_file($file['pathname']),
                    ];
                }
            }
        }
        return $file_arrs;
    }

}
