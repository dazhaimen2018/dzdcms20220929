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
// | 悬浮客服插件
// +----------------------------------------------------------------------
namespace addons\kefu;

use sys\Addons;

class Kefu extends Addons
{
    //安装
    public function install()
    {
        return true;
    }

    //卸载
    public function uninstall()
    {
        return true;
    }

    public function pageFooter($data)
    {
        $config = $this->getAddonConfig();
        //输出方式
        $type = $config['type'] ?: 1;
        if ($type == 1) {
            echo '<script type="text/javascript" src="' . url('addons/Kefu/index') . '"></script>';
        } else {
            $qq     = explode("\n", $config['qq']);
            $phone  = explode("\n", $config['phone']);
            $qqList = array();
            foreach ($qq as $r) {
                $r        = explode('|', $r);
                $qqList[] = array(
                    'qq'   => $r[0],
                    'nick' => $r[1],
                );
            }
            $phoneList = array();
            foreach ($phone as $r) {
                $r           = explode('|', $r);
                $phoneList[] = array(
                    'phone' => $r[0],
                    'nick'  => $r[1],
                );
            }
            $this->assign('url', $config['url']);
            $this->assign('qqList', $qqList);
            $this->assign('phoneList', $phoneList);
            $this->assign('location', $config['location'] ?: 'right');
            $this->assign('theme', $config['theme'] ?: '1');
            $this->assign('qrcode', $config['qrcode'] ?: '');
            return $this->fetch('view/kefu/kefu');
        }
    }

}
