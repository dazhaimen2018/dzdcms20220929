<?php
namespace think;

use \GatewayWorker\Register;
use \Workerman\Worker;

// 自动加载类
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'application' . DIRECTORY_SEPARATOR);
require ROOT_PATH . 'thinkphp' . DIRECTORY_SEPARATOR . 'base.php';
Container::get('app')->initialize();

$register = new Register('text://0.0.0.0:1235');

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
