<?php

namespace addons\dataoutput\model;

use think\Model;

class Output extends Model
{
    // 表名
    protected $name = 'dataoutput';
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $type = [
        'config' => 'array',
        'join_table' => 'array',
    ];
}
