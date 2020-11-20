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
// | 模块管理
// +----------------------------------------------------------------------

namespace sys;

use app\admin\model\Module as ModuleModel;
use app\common\library\Cache as CacheLib;
use think\Db;
use think\Exception;
use think\facade\Cache;
use util\File;
use util\Sql;

class ModuleService
{
    /**
     * 从文件获取模块信息
     * @param string $name 模块名称
     * @return array|mixed
     */
    public static function getInfo($name = '')
    {
        $config = array(
            //模块目录
            'module'      => $name,
            //模块名称
            'name'        => $name,
            //模块简介
            'introduce'   => '',
            //模块作者
            'author'      => '',
            //作者地址
            'authorsite'  => '',
            //作者邮箱
            'authoremail' => '',
            //版本号，请不要带除数字外的其他字符
            'version'     => '',
            //适配最低yzncms版本，
            'adaptation'  => '',
            //签名
            'sign'        => '',
            //依赖模块
            'need_module' => array(),
            //依赖模块
            'need_plugin' => array(),
            //缓存
            'cache'       => array(),
        );

        // 从配置文件获取
        if (is_file(APP_PATH . $name . DS . 'info.php')) {
            $moduleConfig = include APP_PATH . $name . DS . 'info.php';
            $config       = array_merge($config, $moduleConfig);
        }

        //检查是否安装，如果安装了，加载模块安装后的相关配置信息
        if (self::isInstall($name)) {
            $moduleList = cache('Module');
            $config     = array_merge($moduleList[$name], $config);
        }
        return $config;
    }

    /**
     * 执行模块安装
     * @param type $name 模块名(目录名)
     * @return boolean
     */
    public static function install($name)
    {
        //加载模块基本配置
        $config = self::getInfo($name);
        //检查模块是否已经安装
        if (self::isInstall($name)) {
            throw new Exception('模块已经安装，无法重复安装！');
        }
        try {
            ModuleModel::create($config);
            self::runInstallScript($name);
            self::installMenu($name);
            if (!empty($config['cache'])) {
                CacheLib::installModuleCache($config['cache'], $config);
            }
        } catch (Exception $e) {
            self::installRollback($name);
            throw new Exception($e->getMessage());
        }
        //执行数据库脚本安装
        self::runSQL($name);
        //前台模板
        $installdir = APP_PATH . "{$name}" . DS . "install" . DS;
        if (is_dir($installdir . "template" . DS)) {
            //拷贝模板到前台模板目录中去
            File::copy_dir($installdir . "template" . DS, self::getTemplatePath());
        }
        //静态资源文件
        if (file_exists($installdir . "public" . DS)) {
            //拷贝模板到前台模板目录中去
            File::copy_dir($installdir . "public" . DS, self::getExtresPath($name));
        }
        //安装结束，最后调用安装脚本完成
        self::runInstallScript($name, 'end');
        self::refresh();
        //更新缓存
        cache('Module', null);
        return true;

    }

    /**
     * 模块卸载
     * @param type $name 模块名(目录名)
     * @return boolean
     */
    public static function uninstall($name)
    {
        if (!$name || !is_dir(APP_PATH . $name)) {
            throw new Exception('模块不存在！');
        }
        $config = self::getInfo($name);
        //取得该模块数据库中记录的安装信息
        $info = ModuleModel::where('module', $name)->find();
        if (empty($info)) {
            throw new Exception('该模块未安装，无需卸载！');
        }
        if ($info['iscore']) {
            throw new Exception('内置模块，不能卸载！');
        }
        try {
            ModuleModel::where('module', $name)->delete();
            self::runInstallScript($name, 'run', 'uninstall');
            if (!empty($config['cache'])) {
                CacheLib::deleteCacheModule($name);
            }
            //删除菜单项
            Db::name('menu')->where('app', $name)->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        //删除模块前台模板
        if (is_dir(self::getTemplatePath() . $name . DS)) {
            File::del_dir(self::getTemplatePath() . $name . DS);
        }
        //静态资源移除
        if (is_dir(self::getExtresPath($name))) {
            File::del_dir(self::getExtresPath($name));
        }
        //卸载结束，最后调用卸载脚本完成
        self::runInstallScript($name, 'end', 'uninstall');

        self::runSQL($name, 'uninstall');
        // 刷新
        self::refresh();
        cache('Module', null);
        return true;
    }

    /**
     * 刷新插件缓存文件.
     * @throws Exception
     * @return bool
     */
    private static function refresh()
    {
        $file   = ROOT_PATH . 'config' . DS . 'addons.php';
        $config = get_addon_autoload_config(true);
        if ($config['autoload']) {
            return;
        }
        if (!File::is_really_writable($file)) {
            throw new Exception('addons.php文件没有写入权限');
        }
        if ($handle = fopen($file, 'w')) {
            fwrite($handle, "<?php\n\n" . 'return ' . var_export($config, true) . ';');
            fclose($handle);
        } else {
            throw new Exception('文件没有写入权限');
        }
        return true;
    }

    /**
     * 安装菜单项
     * @param type $name 模块名称
     * @param type $file 文件
     * @return boolean
     */
    private static function installMenu($name = '', $file = 'menu')
    {
        $path = APP_PATH . "{$name}" . DS . "install" . DS . "{$file}.php";
        //检查是否有安装脚本
        if (!file_exists($path)) {
            return true;
        }
        $menu = include $path;
        if (empty($menu)) {
            return true;
        }
        $status = model('admin/Menu')->installModuleMenu($menu, self::getInfo($name));
        return true;
    }

    /**
     * 执行安装脚本
     * @param type $name 模块名(目录名)
     * @return boolean
     */
    private static function runInstallScript($name = '', $type = 'run', $Dir = 'install')
    {
        //检查是否有安装脚本
        if (!is_file(APP_PATH . "{$name}/{$Dir}/{$Dir}.php")) {
            return true;
        }
        $class = "\\app\\{$name}\\{$Dir}\\{$Dir}";
        if (class_exists($class)) {
            $installObj = new $class;
            $installObj->$type();
        }
        return true;
    }

    /**
     * 安装回滚
     * @param type $name 模块名(目录名)
     */
    private static function installRollback($name = '')
    {
        ModuleModel::where('module', $name)->delete();
        cache('Module', null);
    }

    /**
     * 执行安装数据库脚本
     * @param type $name 模块名(目录名)
     * @return boolean
     */
    private static function runSQL($name = '', $Dir = 'install')
    {
        $sql_file = APP_PATH . "{$name}" . DS . "{$Dir}" . DS . "{$name}.sql";
        if (file_exists($sql_file)) {
            $sql_statement = Sql::getSqlFromFile($sql_file);
            if (!empty($sql_statement)) {
                foreach ($sql_statement as $value) {
                    $value = str_ireplace('__PREFIX__', config('database.prefix'), $value);
                    $value = str_ireplace('INSERT INTO ', 'INSERT IGNORE INTO ', $value);
                    try {
                        Db::execute($value);
                    } catch (\Exception $e) {
                        throw new Exception('导入SQL失败，请检查{$Dir}.sql的语句是否正确');
                    }
                }
            }
        }
        return true;
    }

    /**
     * 获取模板的目录
     */
    public static function getTemplatePath()
    {
        return TEMPLATE_PATH . 'default' . DS;
    }
    /**
     * 获取资源的目录
     */
    public static function getExtresPath($name)
    {
        return ROOT_PATH . 'public' . DS . 'static' . DS . 'modules' . DS . strtolower($name) . DS;
    }

    private static function systemModuleList()
    {
        return ['admin', 'index', 'api', 'attachment', 'common', 'addons', 'template', 'error'];
    }

    /**
     * 是否已经安装
     * @param type $name 模块名(目录名)
     * @return boolean
     */
    private static function isInstall($name = '')
    {
        $moduleList = cache('Module');
        return (isset($moduleList[$name]) && $moduleList[$name]) ? true : false;
    }

}
