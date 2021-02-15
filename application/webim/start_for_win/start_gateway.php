<?php
namespace think;

use \GatewayWorker\Gateway;
use \Workerman\Worker;

// 自动加载类
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'application' . DIRECTORY_SEPARATOR);
require ROOT_PATH . 'thinkphp' . DIRECTORY_SEPARATOR . 'base.php';
Container::get('app')->initialize();
$Webim_Config = cache('Webim_Config');

// gateway 进程
$gateway = new Gateway("Websocket://0.0.0.0:" . $Webim_Config['port']);
// gateway名称，status方便查看
$gateway->name = 'Gateway';
// gateway进程数
$gateway->count = $Webim_Config['gateway_count'];
// 本机ip，分布式部署时使用内网ip
$gateway->lanIp = '127.0.0.1';
// 内部通讯起始端口，假如$gateway->count=4，起始端口为4000
// 则一般会使用4001 4002 4003 4004 4个端口作为内部通讯端口
$gateway->startPort = 2300;
// 心跳间隔
$gateway->pingInterval = 50;
// 心跳数据
$gateway->pingData = '{"type":"ping"}';
// 服务注册地址
$gateway->registerAddress = $Webim_Config['registeraddress'];

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
