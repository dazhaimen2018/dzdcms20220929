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
namespace app\webim\library;

use think\Db;
use \GatewayWorker\Lib\Gateway;

class Chat
{
    //worker链接时候检测权限
    public static function checkConnect($client_id, $data)
    {
        if ($data['get']['module'] == 'admin' && $data['get']['token']) {
            //管理员
            list($id, $keeptime, $expiretime, $key) = explode('|', $data['get']['token']);
            if ($id && $keeptime && $expiretime && $key && $expiretime > time()) {
                $admin = Db::name('admin')->where('id', $id)->find();
                if (!$admin || !$admin['token']) {
                    return false;
                }
                //token有变更
                if ($key != md5(md5($id) . md5($keeptime) . md5($expiretime) . $admin['token'])) {
                    return false;
                }
            } else {
                return false;
            }
            Gateway::setSession($client_id, ['type' => 'admin']);
            return true;
        } elseif ($data['get']['module'] == 'index') {
            //游客
            Gateway::setSession($client_id, ['type' => 'visitors']);
            return true;
        }
        Gateway::sendToClient($client_id, json_encode(['message_type' => 'clear']));
    }
}
