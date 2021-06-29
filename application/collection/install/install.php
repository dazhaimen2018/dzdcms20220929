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
// | 安装脚本
// +----------------------------------------------------------------------
namespace app\collection\install;

use think\Db;
use util\Sql;
use \sys\InstallBase;

class install extends InstallBase
{
    /**
     * 安装完回调
     * @return boolean
     */
    public function end()
    {

        //安装演示数据
        if (request()->param('demo') == 1) {
            $sql_file = APP_PATH . "collection/install/demo.sql";
            if (file_exists($sql_file)) {
                $sql_statement = Sql::getSqlFromFile($sql_file);
                if (!empty($sql_statement)) {
                    foreach ($sql_statement as $value) {
                        try {
                            Db::execute($value);
                        } catch (\Exception $e) {
                            $this->error = '导入演示数据失败，请检查demo.sql的语句是否正确';
                            return false;
                        }
                    }
                }
            }
        }

    }

}
