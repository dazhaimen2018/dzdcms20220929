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
// | 邮件插件
// +----------------------------------------------------------------------
namespace addons\aliems;

use Dm\Request\V20151123 as Dm;
use sys\Addons;

include_once ADDON_PATH . 'aliems/library/aliyun-php-sdk-core/Config.php';

class Aliems extends Addons
{
    //安装
    public function install()
    {
        return true;
    }

    //卸载
    public function uninstall()
    {
        return true;
    }

    public function appInit()
    {
        \think\Loader::addNamespace('Dm', ADDON_PATH . 'aliems' . DS . 'library' . DS . 'aliyun-php-sdk-dm' . DS);
    }

    protected function init()
    {
        $this->config   = $this->getAddonConfig();
        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", $this->config['appid'], $this->config['appkey']);
        $this->client   = new \DefaultAcsClient($iClientProfile);
        $this->request  = new Dm\SingleSendMailRequest();
    }

    /**
     * 邮箱发送行为
     * @param   Sms     $params
     * @return  boolean
     */
    public function emsSend($params)
    {
        $this->init();

        $this->request->setAccountName($this->config['from']);
        //$this->request->setFromAlias("发信人昵称");
        $this->request->setAddressType(1);
        $this->request->setTagName($this->config['tag']);
        $this->request->setReplyToAddress("true");
        $this->request->setToAddress($params['email']);
        //可以给多个收件人发送邮件，收件人之间用逗号分开,若调用模板批量发信建议使用BatchSendMailRequest方式
        //$this->request->setToAddress("邮箱1,邮箱2");
        $this->request->setSubject('邮件验证');
        $this->request->setHtmlBody("你的邮件验证码是：" . $params['code']);
        try {
            $response = $this->client->getAcsResponse($this->request);
            return true;
        } catch (\Exception $e) {
            //dump($e->getErrorMessage());
            return false;
        }
    }

    /**
     * 邮箱发送通知
     * @param   array   $params
     * @return  boolean
     */
    public function emsNotice($params)
    {
        $this->init();

        $this->request->setAccountName($this->config['from']);
        //$this->request->setFromAlias("发信人昵称");
        $this->request->setAddressType(1);
        $this->request->setTagName($this->config['tag']);
        $this->request->setReplyToAddress("true");
        $this->request->setToAddress($params['email']);
        //可以给多个收件人发送邮件，收件人之间用逗号分开,若调用模板批量发信建议使用BatchSendMailRequest方式
        //$this->request->setToAddress("邮箱1,邮箱2");
        $this->request->setSubject($params['title']);
        $this->request->setHtmlBody($params['msg']);
        try {
            $response = $this->client->getAcsResponse($this->request);
            return true;
        } catch (\Exception $e) {
            //dump($e->getErrorMessage());
            return false;
        }
    }

    /**
     * 检测验证是否正确
     * @param   Sms     $params
     * @return  boolean
     */
    public function emsCheck($params)
    {
        return true;
    }

}
