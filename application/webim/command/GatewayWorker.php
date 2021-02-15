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
// |  Worker 命令行类
// +----------------------------------------------------------------------
namespace app\webim\command;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use GlobalData\Server as GlobalDataServer;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use Workerman\Worker;

class GatewayWorker extends Command
{
    public function configure()
    {
        $this->setName('worker:gateway')
            ->addArgument('action', Argument::OPTIONAL, "start|stop|restart|reload|status|connections", 'start')
            ->addOption('host', 'H', Option::VALUE_OPTIONAL, 'the host of workerman server.', null)
            ->addOption('port', 'p', Option::VALUE_OPTIONAL, 'the port of workerman server.', null)
            ->addOption('daemon', 'd', Option::VALUE_NONE, 'Run the workerman server in daemon mode.')
            ->setDescription('GatewayWorker Server for ThinkPHP');
    }

    public function execute(Input $input, Output $output)
    {
        $action       = $input->getArgument('action');
        $Webim_Config = cache('Webim_Config');
        if (DIRECTORY_SEPARATOR !== '\\') {
            if (!in_array($action, ['start', 'stop', 'reload', 'restart', 'status', 'connections'])) {
                $output->writeln("Invalid argument action:{$action}, Expected start|stop|restart|reload|status|connections .");
                exit(1);
            }

            global $argv;
            array_shift($argv);
            array_shift($argv);
            array_unshift($argv, 'think', $action);
        } else {
            $output->writeln("GatewayWorker Not Support On Windows.");
            exit(1);
        }

        if ('start' == $action) {
            $output->writeln('Starting GatewayWorker server...');
        }

        $option = [ // 扩展自身需要的配置
            'protocol'             => 'websocket', // 协议 支持 tcp udp unix http websocket text
            'host'                 => '0.0.0.0', // 监听地址
            'port'                 => $Webim_Config['port'], // 监听端口
            'socket'               => '', // 完整监听地址
            'context'              => [], // socket 上下文选项

            // Register配置
            'registerAddress'      => $Webim_Config['registeraddress'],

            // Gateway配置
            'name'                 => 'Gateway',
            'count'                => $Webim_Config['gateway_count'],
            'lanIp'                => '127.0.0.1',
            'startPort'            => 2300,
            'daemonize'            => false,
            'pingInterval'         => 50,
            'pingNotResponseLimit' => 0,
            'pingData'             => '{"type":"ping"}',

            // BusinsessWorker配置
            'businessWorker'       => [
                'name'         => 'BusinessWorker',
                'count'        => $Webim_Config['worker_count'],
                'eventHandler' => '\app\webim\controller\Events',
            ],
        ];

        if ($input->hasOption('host')) {
            $host = $input->getOption('host');
        } else {
            $host = !empty($option['host']) ? $option['host'] : '0.0.0.0';
        }

        if ($input->hasOption('port')) {
            $port = $input->getOption('port');
        } else {
            $port = !empty($option['port']) ? $option['port'] : '1235';
        }

        $this->start($host, (int) $port, $option);
    }

    /**
     * 启动
     * @access public
     * @param  string   $host 监听地址
     * @param  integer  $port 监听端口
     * @param  array    $option 参数
     * @return void
     */
    public function start(string $host, int $port, array $option = [])
    {
        $registerAddress = !empty($option['registerAddress']) ? $option['registerAddress'] : '127.0.0.1:1235';
        $this->register($registerAddress);
        $this->businessWorker($registerAddress, $option['businessWorker'] ?? []);
        $this->gateway($registerAddress, $host, $port, $option);
        $this->globaldata();
        Worker::runAll();
    }

    /**
     * 启动register
     * @access public
     * @param  string   $registerAddress
     * @return void
     */
    public function globaldata()
    {
        // 初始化register
        new GlobalDataServer('127.0.0.1', 2307);
    }

    /**
     * 启动register
     * @access public
     * @param  string   $registerAddress
     * @return void
     */
    public function register(string $registerAddress)
    {
        // 初始化register
        new Register('text://' . $registerAddress);
    }

    /**
     * 启动businessWorker
     * @access public
     * @param  string   $registerAddress registerAddress
     * @param  array    $option 参数
     * @return void
     */
    public function businessWorker(string $registerAddress, array $option = [])
    {
        // 初始化 bussinessWorker 进程
        $worker = new BusinessWorker();

        $this->option($worker, $option);

        $worker->registerAddress = $registerAddress;
    }

    /**
     * 启动gateway
     * @access public
     * @param  string  $registerAddress registerAddress
     * @param  string  $host 服务地址
     * @param  integer $port 监听端口
     * @param  array   $option 参数
     * @return void
     */
    public function gateway(string $registerAddress, string $host, int $port, array $option = [])
    {
        // 初始化 gateway 进程
        if (!empty($option['socket'])) {
            $socket = $option['socket'];
            unset($option['socket']);
        } else {
            $protocol = !empty($option['protocol']) ? $option['protocol'] : 'websocket';
            $socket   = $protocol . '://' . $host . ':' . $port;
            unset($option['host'], $option['port'], $option['protocol']);
        }

        $gateway = new Gateway($socket, $option['context'] ?? []);

        // 以下设置参数都可以在配置文件中重新定义覆盖
        $gateway->name                 = 'Gateway';
        $gateway->count                = 4;
        $gateway->lanIp                = '127.0.0.1';
        $gateway->startPort            = 2000;
        $gateway->pingInterval         = 30;
        $gateway->pingNotResponseLimit = 0;
        $gateway->pingData             = '{"type":"ping"}';
        $gateway->registerAddress      = $registerAddress;

        // 全局静态属性设置
        foreach ($option as $name => $val) {
            if (in_array($name, ['stdoutFile', 'daemonize', 'pidFile', 'logFile'])) {
                Worker::${$name} = $val;
                unset($option[$name]);
            }
        }

        $this->option($gateway, $option);
    }

    /**
     * 设置参数
     * @access protected
     * @param  Worker $worker Worker对象
     * @param  array  $option 参数
     * @return void
     */
    protected function option(Worker $worker, array $option = [])
    {
        // 设置参数
        if (!empty($option)) {
            foreach ($option as $key => $val) {
                $worker->$key = $val;
            }
        }
    }
}
