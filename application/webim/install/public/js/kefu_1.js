var head = document.getElementsByTagName('head')[0];
var link = document.createElement('link');
link.type='text/css';
link.rel = 'stylesheet';
link.href ='http://www.yzncms.net/static/modules/webim/css/style.css';
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
            div.id ="kefu-box";
            div.className +='kefu-form';
            document.body.appendChild(div);
            var w =document.getElementById('kefu-box');
            w.innerHTML='<a href="javascript:;" onclick="kefu.connenct(0)"><i class="kefu-icon"></i><p class="kefu-item">在线咨询</p></a>';
        }
     },
     connenct:function(groupid){
        var web =encodeURI('http://www.yzncms.net/webim?visiter_id='+this.visiter_id+'&visiter_name='+this.visiter_name+'&avatar='+this.avatar+'&business_id=&groupid='+groupid+'&product='+this.product);
        var moblieweb = encodeURI('http://www.yzncms.net/webim/index/wap?visiter_id='+this.visiter_id+'&visiter_name='+this.visiter_name+'&avatar='+this.avatar+'&business_id=&groupid='+groupid+'&product='+this.product);
        if ((navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i))) {
         window.open(moblieweb);
        }else{
          window.open(web);
        }
     },
     narrow:function(){
        document.getElementById('wolive-talk').style="display:none";
     }
}
window.onload =kefu.open();