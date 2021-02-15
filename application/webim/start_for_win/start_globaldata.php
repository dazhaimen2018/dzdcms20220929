<?php
namespace think;

use \Workerman\Worker;

// 自动加载类
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'application' . DIRECTORY_SEPARATOR);
require ROOT_PATH . 'thinkphp' . DIRECTORY_SEPARATOR . 'base.php';
Container::get('app')->initialize();

//请设置成服务器内网ip
$globaldata = new \GlobalData\Server('127.0.0.1', 2307);

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
