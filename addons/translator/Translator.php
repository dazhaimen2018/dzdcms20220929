<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin
 * Date: 2021/11/16
 * 翻译插件
 */
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
        if (empty($content)){
            return ['code'=>1,'msg'=>'翻译成功','content'=>''];
        }
        $this->init();
        $translator = new \Jonas\Translator\Translator($this->config);
        try {
            //可以指定翻译的服务商 ctype
            $ctype = $this->config['default']['gateways'][0];
            //可以指定翻译输出的语种 toLanguage
            if (isset($this->conversion[$toLanguage]) && ($toLanguage !== 'auto')){
                $toLanguage = $this->conversion[$toLanguage]?$this->conversion[$toLanguage]:$toLanguage;
            }
            $res = $translator->to($toLanguage)->$ctype($content);
        } catch (\Exception $e) {
            return ['code'=>0,'msg'=>'翻译失败','content'=>$e->getMessage()];
        }
        $return = '';
        if ($res['status'] == 'success'){
            $result = (array)$res['result'];
//            $return = $result["\0*\0trans_result"];
            return ['code'=>1,'msg'=>'翻译成功','content'=>$result["\0*\0trans_result"]];
        }else{
            if ($debug){
                $return = $res['exception']->raw;
            }else{
                $result = (array)$res['exception'];
                $return = $result["\0*\0message"]?$result["\0*\0message"]:'请检查翻译插件配置';
                return ['code'=>0,'msg'=>'翻译失败','content'=>$return];
            }
        }
    }

}
