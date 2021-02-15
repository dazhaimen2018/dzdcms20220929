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
namespace app\comments\uninstall;

use think\Db;
use \sys\UninstallBase;

class Uninstall extends UninstallBase
{
    //固定相关表
    private $modelTabList = array(
        'comments',
        'comments_emotion',
    );

    //卸载
    public function run()
    {
        if (request()->param('clear') == 1) {
            // 删除模型中建的表
            /*$table_list = Db::name('model')->where(['module' => 'comments'])->field('tablename,type,id')->select();
            if ($table_list) {
            foreach ($table_list as $val) {
            $tablename = config('database.prefix') . $val['tablename'];
            Db::execute("DROP TABLE IF EXISTS `{$tablename}`;");
            Db::name('model_field')->where(['modelid' => $val['id']])->delete();
            }
            }
            //删除模型中的表
            Db::name('model')->where(['module' => 'comments'])->delete();*/
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
