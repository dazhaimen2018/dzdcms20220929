<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\Model;

use think\Model;

/**
 * 权限规则模型
 */
class Language extends Model
{
    protected $insert = ['status' => 1];

    public function createLanguage($data)
    {
        if (empty($data)) {
            $this->error = '没有数据！';
            return false;
        }
        $id               = $this->allowField(true)->save($data);
        if ($id) {
            return $id;
        }
        $this->error = '入库失败！';
        return false;
    }

    public function editLanguage($data)
    {
        if (empty($data) || !isset($data['id']) || !is_array($data)) {
            $this->error = '没有修改的数据！';
            return false;
        }
        $info = $this->where('id', $data['id'])->find();
        if (empty($info)) {
            $this->error = '该语言不存在！';
            return false;
        }

        $status = $this->allowField(true)->isUpdate(true)->save($data);
        return $status !== false ? true : false;
    }
}
