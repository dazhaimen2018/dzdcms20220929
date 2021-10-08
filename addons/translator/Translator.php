<?php
// +----------------------------------------------------------------------
// | Golang [ 够浪工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://dzdcms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 猫头鹰 <951488865@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 翻译插件
// +----------------------------------------------------------------------
namespace addons\translator;

use Jonas\Translator\Lng;
use sys\Addons;

class Translator extends Addons
{
    public $config = [
        // HTTP 请求的超时时间（秒）
        'timeout'  => 5.0,

        // 默认发送配置
        'default'  => [
            // 网关调用策略，默认：顺序调用
//            'strategy' => \Jonas\Translator\Translator::class,

            // 默认可用的发送网关
            'gateways' => [
                //有道智云
                'youdao',
            ],
        ],
        // 可用的网关配置
        'gateways' => [
//            'errorlog' => [
//                'file' => APP_PATH . 'runtime/tmp/trabskator.log',
//            ],
            //有道智云
            'youdao'   => [
                'app_id' => '',
                'app_sec' => '',
            ],
        ],
    ];

    protected function init()
    {
        $config                                                   = $this->getAddonConfig();
        $this->config['default']['gateways']                      = (array) $config['gateways'];
        $this->config['gateways'][$config['gateways']]['app_id'] =  $config['app_key'];
        $this->config['gateways'][$config['gateways']]['app_sec'] = $config['app_sec'];
        $this->conversion                                         = (array) $config['conversion'];
    }

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * 翻译行为
     * @content          String     $content
     * @paramtoLanguage  String     $toLanguage
     * @return  string
     */
    public function text_translator($content,$toLanguage='',$debug=0)
    {
        $this->init();
        $translator = new \Jonas\Translator\Translator($this->config);
        try {
            //可以指定翻译的服务商 ctype
            $ctype = $this->config['default']['gateways'][0];
            //可以指定翻译输出的语种 toLanguage
            if (isset($this->conversion[$toLanguage]) && ($toLanguage !== 'auto')){
                $toLanguage = $this->conversion[$toLanguage]?$this->conversion[$toLanguage]:$toLanguage;
            }
            if ($toLanguage=='zh-CHS'){
                return $content;
            }else{
                $res = $translator->to($toLanguage)->$ctype($content);
            }
        } catch (\Exception $e) {
            //var_dump($e->getResults());
            return false;
        }
        $return = '';
        if ($res['status'] == 'success'){
            $result = (array)$res['result'];
            $return = $result["\0*\0trans_result"];
        }else{
            if ($debug){
                $return = $res['exception']->raw;
            }
        }
        return $return;
    }

}
