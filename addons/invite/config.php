<?php

return array(
    array(
        'name'    => 'invitercode',
        'title'   => '是否开启邀请码',
        'type'    => 'radio',
        'options' => [
            1 => '是',
            0 => '否',
        ],
        'value'   => 0,
        'tip'     => '只有填写邀请码才可以注册，可以在后台生成',
    ),
    array(
        'name'  => 'inviterscore',
        'title' => '邀请者奖励积分',
        'type'  => 'text',
        'value' => '10',
        'tip'   => '被邀请者注册账号成功后邀请者奖励积分',
    ),
    array(
        'name'  => 'inviteescore',
        'title' => '被邀请者赠送积分',
        'type'  => 'text',
        'value' => '10',
        'tip'   => '被邀请者注册账号成功将获得积分',
    ),
    array(
        'name'  => 'dailymaxinvite',
        'title' => '每天邀请限制',
        'type'  => 'text',
        'value' => '0',
        'tip'   => '每天邀请的前几名赠送积分，后面的不赠送积分，0为不限制',
    ),
    array(
        'name'    => 'filtermode',
        'title'   => '是否开启过滤模式',
        'type'    => 'radio',
        'options' => [
            1 => '是',
            0 => '否',
        ],
        'value'   => 0,
        'tip'     => '判断已邀请注册的IP,如有相同IP忽略邀请记录',
    ),
);
