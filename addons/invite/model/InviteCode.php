<?php

namespace addons\invite\model;

use think\Model;

class InviteCode extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime         = 'expired_time';
    protected $updateTime         = false;
    protected $insert             = ['status' => 1];
    public function setExpiredTimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : ($value ? $value : null);
    }
}
