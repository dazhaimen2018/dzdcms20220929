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
// | webim管理
// +----------------------------------------------------------------------
namespace app\webim\controller;

use app\common\controller\Adminbase;

class Admin extends Adminbase
{

    public function chat()
    {
        return $this->fetch();
    }

    public function record()
    {

    }

    //生成js
    public function deploy()
    {
        $domain = $this->request->domain();
        $jsPath = "{$domain}" . config('public_url') . "static/modules/webim/js/kefu_" . $this->_userinfo['id'] . ".js";
        $this->assign('jsPath', $jsPath);
        return $this->fetch();
    }

    public function createJs()
    {
        $domain = $this->request->domain();
        try {
            $content = "var head = document.getElementsByTagName('head')[0];
var link = document.createElement('link');
link.type='text/css';
link.rel = 'stylesheet';
link.href ='{$domain}" . config('public_url') . "static/modules/webim/css/style.css';
head.appendChild(link);
var kefu ={
     visiter_id:'',
     visiter_name:'',
     avatar:'',
     product:'',
     open:function(){
        var d =document.getElementById('wolive-box');
        if(!d){
            var div =document.createElement('div');
            div.id =\"kefu-box\";
            div.className +='kefu-form';
            document.body.appendChild(div);
            var w =document.getElementById('kefu-box');
            w.innerHTML='<a href=\"javascript:;\" onclick=\"kefu.connenct(0)\"><i class=\"kefu-icon\"></i><p class=\"kefu-item\">在线咨询</p></a>';
        }
     },
     connenct:function(groupid){
        var web =encodeURI('{$domain}/webim?visiter_id='+this.visiter_id+'&visiter_name='+this.visiter_name+'&avatar='+this.avatar+'&business_id={$business_id}&groupid='+groupid+'&product='+this.product);
        var moblieweb = encodeURI('{$domain}/webim/index/wap?visiter_id='+this.visiter_id+'&visiter_name='+this.visiter_name+'&avatar='+this.avatar+'&business_id={$business_id}&groupid='+groupid+'&product='+this.product);
        if ((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
         window.open(moblieweb);
        }else{
          window.open(web);
        }
     },
     narrow:function(){
        document.getElementById('wolive-talk').style=\"display:none\";
     }
}
window.onload =kefu.open();";
            file_put_contents(ROOT_PATH . "public/static/modules/webim/js/kefu_" . $this->_userinfo['id'] . ".js", $content);
        } catch (\Exception $e) {
            $this->error('生成js失败');
        }
        $this->success('生成js成功!');
    }

}
