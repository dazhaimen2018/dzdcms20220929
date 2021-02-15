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
// | 卸载脚本
// +----------------------------------------------------------------------
namespace app\webim\uninstall;

use think\Db;
use \sys\UninstallBase;

class Uninstall extends UninstallBase
{
    //固定相关表
    private $modelTabList = array(
        'webim_visitors',
    );

    //卸载
    public function run()
    {
        $file = APP_PATH . 'command.php';
        if (is_file($file)) {
            $array = include $file;
        }
        $ok = false;
        foreach ($array as $key => $value) {
            if ($value == 'app\webim\command\GatewayWorker') {
                $ok = true;
                unset($array[$key]);
            }
        }
        if ($ok) {
            if (\util\File::is_really_writable($file)) {
                if ($handle = fopen($file, 'w')) {
                    fwrite($handle, "<?php\n\n" . "return " . var_export($array, true) . ";\n");
                    fclose($handle);
                }
            }
        }
        if (request()->param('clear') == 1) {
            //删除固定表
            if (!empty($this->modelTabList)) {
                foreach ($this->modelTabList as $tablename) {
                    if (!empty($tablename)) {
                        $tablename = config('database.prefix') . $tablename;
                        Db::execute("DROP TABLE IF EXISTS `{$tablename}`;");
                    }
                }
            }
        }
        return true;
    }

}
