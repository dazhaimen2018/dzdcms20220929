<?php
return array(
    'guest' => 1,//是否允许游客评论
    'code' => 0,//是否开启验证码
    'check' => 0,//是否需要审核
    'stb' => 1,//存储分表
    'stbsum' => 1,//分表总数
    'order' => 'create_time DESC',//前台评论排序
    'strlength' => 400,//允许最大字数
    'status' => 1,//关闭/开启评论
    'expire' => 60,//评论间隔时间单位秒
);
