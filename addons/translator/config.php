<?php

return array (
  0 => 
  array (
    'name' => 'gateways',
    'title' => '翻译服务商',
    'type' => 'select',
    'options' => 
    array (
      'youdao' => '有道智云',
      'baidu' => '百度云',
    ),
    'value' => 'youdao',
    'tip' => '请自行查询相关平台的收费标准然后进行选择',
  ),
  1 => 
  array (
    'name' => 'app_key',
    'title' => '应用ID',
    'type' => 'text',
    'value' => '',
    'tip' => '有道智云前往[有道智云平台]获取应用Id和密钥',
  ),
  2 => 
  array (
    'name' => 'app_sec',
    'title' => '应用秘钥',
    'type' => 'password',
    'value' => '',
    'tip' => '前往平台获取密钥',
  ),
  3 => 
  array (
    'name' => 'conversion',
    'title' => '语言标识转换',
    'type' => 'array',
    'value' => 
    array (
      'zh-cn' => 'zh-CHS',
    ),
    'tip' => '主要用于站点标识转换为翻译平台标识<br/>zh-CHS => 中文<br/>en => 英文<br/>ja => 日文<br/>fr => 法语<br/>es => 西班牙语<br/>pt => 葡萄牙语<br/>it => 意大利语<br/>ru => 俄文<br/>vi => 越南文<br/>de => 德文<br/>ar => 阿拉伯文',
  ),
);
