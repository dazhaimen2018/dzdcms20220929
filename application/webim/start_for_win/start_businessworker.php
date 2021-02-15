<?php
namespace think;

use \GatewayWorker\BusinessWorker;
use \Workerman\Worker;

// 自动加载类
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'application' . DIRECTORY_SEPARATOR);
require ROOT_PATH . 'thinkphp' . DIRECTORY_SEPARATOR . 'base.php';
Container::get('app')->initialize();
$Webim_Config = cache('Webim_Config');

// bussinessWorker 进程
$worker = new BusinessWorker();
// worker名称
$worker->name = 'BusinessWorker';
// bussinessWorker进程数量
$worker->count = $Webim_Config['worker_count'];
// 服务注册地址
$worker->registerAddress = $Webim_Config['registeraddress'];
$worker->eventHandler    = '\app\webim\controller\Events';

// 如果不是在根目录启动，则运行runAll方法
if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
