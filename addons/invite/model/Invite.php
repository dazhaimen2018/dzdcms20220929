<?php

namespace addons\invite\model;

use think\Model;

class Invite extends Model
{
    protected $autoWriteTimestamp = true;

    public function invited()
    {
        return $this->hasOne('\app\member\model\Member', 'id', 'touid');
    }
}
