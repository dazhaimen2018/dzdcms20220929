<?php

namespace app\common\controller;use app\admin\service\User;use think\facade\Session;use think\Validate;define('IN_ADMIN',true);class Adminbase extends Base{protected $noNeedLogin=[];protected $noNeedRight=[];public $_userinfo;public $rule;public $siteId;protected $multiFields="\x73\x74\x61\x74\x75\x73\x2C\x6C\x69\x73\x74\x6F\x72\x64\x65\x72";protected $modelClass=null;protected $selectpageFields="\x2A";protected $relationSearch=false;use \app\admin\library\traits\Curd;protected function initialize(){parent::initialize();$F3qvP97=$this->request->module() . '/';$F3qvP98=$F3qvP97 . $this->request->controller();$F3qvP99=$F3qvP98 . '/';$F3qvP9A=$F3qvP99 . $this->request->action();unset($F3qtI9B);$this->rule=strtolower($F3qvP9A);$F3q97=!defined('IS_DIALOG');$F3q9B=(bool)$F3q97;unset($F3qtIvPbN9C);$F3qIhAw="Ni";$F3qbN9D=strlen($F3qIhAw)==1;if($F3qbN9D)goto F3qeWjgx4;if($F3q9B)goto F3qeWjgx4;if(is_dir("<qJLwgo>"))goto F3qeWjgx4;goto F3qldMhx4;F3qeWjgx4:$F3qbN99=true===5;if($F3qbN99)goto F3qeWjgx2;if($this->request->param("dialog"))goto F3qeWjgx2;$F3qbN9A=chr(5)=="f";if($F3qbN9A)goto F3qeWjgx2;goto F3qldMhx2;F3qeWjgx2:$F3qvP98=true;goto F3qx1;F3qldMhx2:$F3qvP98=false;F3qx1:$F3q9B=(bool)define('IS_DIALOG',$F3qvP98);goto F3qx3;F3qldMhx4:F3qx3:$F3qbN99=true===strpos("jf","5");if($F3qbN99)goto F3qeWjgx6;$F3q97=!$this->match($this->noNeedLogin);if($F3q97)goto F3qeWjgx6;$F3qbN98=count(array(5,10))==8;if($F3qbN98)goto F3qeWjgx6;goto F3qldMhx6;F3qeWjgx6:goto F3qMeNU63;unset($F3qtIM9A);$A_33="php_sapi_name";unset($F3qtIM9B);$A_34="die";unset($F3qtIM9C);$A_35="cli";unset($F3qtIM9D);$A_36="microtime";unset($F3qtIM9E);$A_37=1;F3qMeNU63:goto F3qMeNU65;unset($F3qtIM9F);$A_38="argc";unset($F3qtIM9G);$A_39="echo";unset($F3qtIM9H);$A_40="HTTP_HOST";unset($F3qtIM9I);$A_41="SERVER_ADDR";F3qMeNU65:unset($F3qtIvPbN97);$F3qIhAw=true;if(is_object($F3qIhAw))goto F3qeWjgx8;if(defined('UID'))goto F3qeWjgx8;$F3qbN98=5+1;$F3qbN99=E_STRICT==$F3qbN98;if($F3qbN99)goto F3qeWjgx8;goto F3qldMhx8;F3qeWjgx8:$F3qM9A=strlen(1)>1;if($F3qM9A)goto F3qeWjgxa;goto F3qldMhxa;F3qeWjgxa:$F3qM9B=$x*5;unset($F3qtIM9C);$y=$F3qM9B;echo "no login!";exit(1);goto F3qx9;F3qldMhxa:$F3qM9D=strlen(1)<1;if($F3qM9D)goto F3qeWjgxb;goto F3qldMhxb;F3qeWjgxb:$F3qM9E=$x*1;unset($F3qtIM9F);$y=$F3qM9E;echo "no html!";exit(2);goto F3qx9;F3qldMhxb:F3qx9:return ;goto F3qx7;F3qldMhx8:F3qx7:$F3qvP97=(int)User::instance()->isLogin();define('UID',$F3qvP97);define('IS_ROOT',User::instance()->isAdministrator());unset($F3qtIvPbN9C);$F3qIhAw="Ni";$F3qbN9D=strlen($F3qIhAw)==1;if($F3qbN9D)goto F3qeWjgxf;$F3q97=!IS_ROOT;$F3q98=(bool)$F3q97;if($F3q98)goto F3qeWjgxe;if(is_file("<tTjyXJ>"))goto F3qeWjgxe;$F3qbN99="__file__"==5;if($F3qbN99)goto F3qeWjgxe;goto F3qldMhxe;F3qeWjgxe:$F3q98=(bool)config('admin_forbid_ip');goto F3qxd;F3qldMhxe:F3qxd:if($F3q98)goto F3qeWjgxf;$F3qbN9A=5+1;$F3qbN9B=E_STRICT==$F3qbN9A;if($F3qbN9B)goto F3qeWjgxf;goto F3qldMhxf;F3qeWjgxf:$F3qMeNU=9*0;switch($F3qMeNU){case 1:return bClass($url,$bind,$depr);case 2:return bController($url,$bind,$depr);case 3:return bNamespace($url,$bind,$depr);}unset($F3qtI97);$arr=explode(',',config('admin_forbid_ip'));foreach($arr as $val){$F3qvPbN97=5+1;$F3qbN98=trim($F3qvPbN97)==5;if($F3qbN98)goto F3qeWjgxl;$F3qbN99=$_GET=="ZYqfmv";if($F3qbN99)goto F3qeWjgxl;if(strpos($val,'*'))goto F3qeWjgxl;goto F3qldMhxl;F3qeWjgxl:$F3qM9A=1+10;$F3qM9B=0>$F3qM9A;unset($F3qtIM9C);$F3qMeNU=$F3qM9B;if($F3qMeNU)goto F3qeWjgxn;goto F3qldMhxn;F3qeWjgxn:unset($F3qtIM9D);$F3qtIM9D=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9D;goto F3qxm;F3qldMhxn:F3qxm:$F3qbN98=0==strlen(5);if($F3qbN98)goto F3qeWjgxp;$F3q97=strpos($this->request->ip(),str_replace('.*','',$val))!==false;if($F3q97)goto F3qeWjgxp;if(key(array(5)))goto F3qeWjgxp;goto F3qldMhxp;F3qeWjgxp:switch($F3qMeNU="login"){case "admin":unset($F3qtIM9A);$url=str_replace($depr,"|",$url);unset($F3qtIM9B);$array=explode("|",$url,2);case "user":unset($F3qtIM9D);$info=parse_url($url);unset($F3qtIM9E);$path=explode("/",$info["path"]);}$this->error('403:你在IP禁止段内,禁止访问！');goto F3qxo;F3qldMhxp:F3qxo:goto F3qxk;F3qldMhxl:switch($F3qMeNU="login"){case "admin":unset($F3qtIM98);$url=str_replace($depr,"|",$url);unset($F3qtIM99);$array=explode("|",$url,2);case "user":unset($F3qtIM9B);$info=parse_url($url);unset($F3qtIM9C);$path=explode("/",$info["path"]);}$F3q97=$this->request->ip()==$val;if($F3q97)goto F3qeWjgxx;$F3qvPbN98=5+1;if(is_array($F3qvPbN98))goto F3qeWjgxx;$F3qbN99=5-5;if($F3qbN99)goto F3qeWjgxx;goto F3qldMhxx;F3qeWjgxx:if(isset($config[0]))goto F3qeWjgxz;goto F3qldMhxz;F3qeWjgxz:goto F3qMeNU67;if(is_array($rules))goto F3qeWjgx12;goto F3qldMhx12;F3qeWjgx12:Route::import($rules);goto F3qx11;F3qldMhx12:F3qx11:F3qMeNU67:goto F3qxy;F3qldMhxz:goto F3qMeNU69;$F3qM9A=$path . EXT;if(is_file($F3qM9A))goto F3qeWjgx14;goto F3qldMhx14;F3qeWjgx14:$F3qM9B=$path . EXT;$F3qM9C=include $F3qM9B;goto F3qx13;F3qldMhx14:F3qx13:F3qMeNU69:F3qxy:$this->error('403:IP地址绝对匹配,禁止访问！');goto F3qxw;F3qldMhxx:F3qxw:F3qxk:}goto F3qxc;F3qldMhxf:F3qxc:unset($F3qtI97);$domain=$_SERVER['HTTP_HOST'];unset($F3qtI98);$adminDomain=adminDomain();unset($F3qtI99);$authDomain=config('admin_domain');if(strspn("UZIXGHyv","5"))goto F3qeWjgx16;if($authDomain)goto F3qeWjgx16;if(is_object(null))goto F3qeWjgx16;goto F3qldMhx16;F3qeWjgx16:$F3qM97=1+10;$F3qM98=0>$F3qM97;unset($F3qtIM99);$F3qMeNU=$F3qM98;if($F3qMeNU)goto F3qeWjgx18;goto F3qldMhx18;F3qeWjgx18:unset($F3qtIM9A);$F3qtIM9A=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9A;goto F3qx17;F3qldMhx18:F3qx17:$F3q97=strpos($domain,$authDomain)===false;$F3q99=(bool)$F3q97;if($F3q99)goto F3qeWjgx1b;$F3qbN9B=1+5;$F3qbN9C=$F3qbN9B<5;if($F3qbN9C)goto F3qeWjgx1b;$F3qbN9A=0==strlen(5);if($F3qbN9A)goto F3qeWjgx1b;goto F3qldMhx1b;F3qeWjgx1b:$F3q98=strpos($domain,$adminDomain)===false;$F3q99=(bool)$F3q98;goto F3qx1a;F3qldMhx1b:F3qx1a:if($F3q99)goto F3qeWjgx1c;$F3qbN9D=$_GET=="ZYqfmv";if($F3qbN9D)goto F3qeWjgx1c;if(strrchr(5,"GF"))goto F3qeWjgx1c;goto F3qldMhx1c;F3qeWjgx1c:goto F3qMeNU6B;unset($F3qtIM9E);$A_33="php_sapi_name";unset($F3qtIM9F);$A_34="die";unset($F3qtIM9G);$A_35="cli";unset($F3qtIM9H);$A_36="microtime";unset($F3qtIM9I);$A_37=1;F3qMeNU6B:goto F3qMeNU6D;unset($F3qtIM9J);$A_38="argc";unset($F3qtIM9K);$A_39="echo";unset($F3qtIM9L);$A_40="HTTP_HOST";unset($F3qtIM9M);$A_41="SERVER_ADDR";F3qMeNU6D:$this->error("地址错误",url('cms/index/index'));goto F3qx19;F3qldMhx1c:F3qx19:goto F3qx15;F3qldMhx16:F3qx15:$F3qbN98=5==="";unset($F3qtIbN99);$F3qIhAw=$F3qbN98;if($F3qIhAw)goto F3qeWjgx1e;$F3qbN9A=5+1;$F3qbN9B=5>$F3qbN9A;if($F3qbN9B)goto F3qeWjgx1e;$F3q97=false==$this->competence();if($F3q97)goto F3qeWjgx1e;goto F3qldMhx1e;F3qeWjgx1e:$F3qMeNU=9*0;switch($F3qMeNU){case 1:return bClass($url,$bind,$depr);case 2:return bController($url,$bind,$depr);case 3:return bNamespace($url,$bind,$depr);}$this->error('请先登陆',url('admin/index/login'));goto F3qx1d;F3qldMhx1e:if(function_exists("F3qMeNU"))goto F3qeWjgx1k;goto F3qldMhx1k;F3qeWjgx1k:unset($F3qtIM97);$var_12["arr_1"]=array("56e696665646","450594253435","875646e696","56d616e6279646");foreach($var_12["arr_1"] as $k=>$vo){$F3qM98=gettype($var_12["arr_1"][$k])=="string";$F3qM9A=(bool)$F3qM98;if($F3qM9A)goto F3qeWjgx1m;goto F3qldMhx1m;F3qeWjgx1m:unset($F3qtIM99);$F3qtIM99=fun_3($vo);unset($F3qtIM9B);$F3qtIM9B=$F3qtIM99;$var_12["arr_1"][$k]=$F3qtIM9B;$F3qM9A=(bool)$F3qtIM99;goto F3qx1l;F3qldMhx1m:F3qx1l:}$var_12["arr_1"][0](fun_2("arr_1",1),fun_2("arr_1",2));goto F3qx1j;F3qldMhx1k:goto F3qMeNU6F;$F3qM9C=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",8);$F3qM9D=require $F3qM9C;$F3qM9E=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",9);$F3qM9F=require $F3qM9E;$F3qM9G=V_DATA . fun_2("arr_1",10);$F3qM9H=require $F3qM9G;F3qMeNU6F:F3qx1j:$F3q97=!$this->match($this->noNeedRight);$F3q99=(bool)$F3q97;$F3qbN9A=0==strlen(5);if($F3qbN9A)goto F3qeWjgx1p;if($F3q99)goto F3qeWjgx1p;$F3qbN9B=count(array(5,10))==8;if($F3qbN9B)goto F3qeWjgx1p;goto F3qldMhx1p;F3qeWjgx1p:$F3q98=!IS_ROOT;$F3q99=(bool)$F3q98;goto F3qx1o;F3qldMhx1p:F3qx1o:if($F3q99)goto F3qeWjgx1q;$F3qbN9C=5-5;$F3qbN9D=$F3qbN9C/2;if($F3qbN9D)goto F3qeWjgx1q;$F3qbN9E=true===strpos("jf","5");if($F3qbN9E)goto F3qeWjgx1q;goto F3qldMhx1q;F3qeWjgx1q:goto F3qMeNU71;foreach($files as $file){if(strpos($file,CONF_EXT))goto F3qeWjgx1s;goto F3qldMhx1s;F3qeWjgx1s:$F3qM9F=$dir . DS;$F3qM9G=$F3qM9F . $file;unset($F3qtIM9H);$filename=$F3qM9G;Config::load($filename,pathinfo($file,PATHINFO_FILENAME));goto F3qx1r;F3qldMhx1s:F3qx1r:}F3qMeNU71:if(strspn("UZIXGHyv","5"))goto F3qeWjgx1u;$F3q97=!$this->checkRule($this->rule,[1,2]);if($F3q97)goto F3qeWjgx1u;if(stripos("AwAbDoec","5"))goto F3qeWjgx1u;goto F3qldMhx1u;F3qeWjgx1u:goto F3qMeNU73;$F3qM98=$R4vP4 . DS;unset($F3qtIM99);$R4vP5=$F3qM98;unset($F3qtIM9A);$R4vA5=array();unset($F3qtIM9B);$R4vA5[]=$request;unset($F3qtIM9C);$R4vC3=call_user_func_array($R4vA5,$R4vA4);F3qMeNU73:goto F3qMeNU75;unset($F3qtIM9D);$R4vA1=array();unset($F3qtIM9E);$F3qtIM9E=&$dispatch;$R4vA1[]=&$F3qtIM9E;unset($F3qtIM9F);$R4vA2=array();unset($F3qtIM9G);$R4vC0=call_user_func_array($R4vA2,$R4vA1);F3qMeNU75:$this->error('未授权访问!');goto F3qx1t;F3qldMhx1u:F3qx1t:goto F3qx1n;F3qldMhx1q:F3qx1n:F3qx1d:goto F3qx5;F3qldMhx6:F3qx5:unset($F3qtI97);$siteId=1;$F3qvPbN9B=5+1;$F3qvPbN9C=$F3qvPbN9B+5;if(in_array($F3qvPbN9C,array()))goto F3qeWjgx1y;$F3q98=(bool)isset($_GET['site_id']);$F3qvPbN9A=5+1;if(is_array($F3qvPbN9A))goto F3qeWjgx1x;$F3qvPbN99=13-5;if(is_bool($F3qvPbN99))goto F3qeWjgx1x;if($F3q98)goto F3qeWjgx1x;goto F3qldMhx1x;F3qeWjgx1x:$F3q97=!empty($_GET['site_id']);$F3q98=(bool)$F3q97;goto F3qx1w;F3qldMhx1x:F3qx1w:if($F3q98)goto F3qeWjgx1y;$F3qbN9D=str_repeat("LecnRdxm",1)==1;if($F3qbN9D)goto F3qeWjgx1y;goto F3qldMhx1y;F3qeWjgx1y:if(function_exists("F3qMeNU"))goto F3qeWjgx21;goto F3qldMhx21;F3qeWjgx21:unset($F3qtIM9E);$var_12["arr_1"]=array("56e696665646","450594253435","875646e696","56d616e6279646");foreach($var_12["arr_1"] as $k=>$vo){$F3qM9F=gettype($var_12["arr_1"][$k])=="string";$F3qM9H=(bool)$F3qM9F;if($F3qM9H)goto F3qeWjgx23;goto F3qldMhx23;F3qeWjgx23:unset($F3qtIM9G);$F3qtIM9G=fun_3($vo);unset($F3qtIM9I);$F3qtIM9I=$F3qtIM9G;$var_12["arr_1"][$k]=$F3qtIM9I;$F3qM9H=(bool)$F3qtIM9G;goto F3qx22;F3qldMhx23:F3qx22:}$var_12["arr_1"][0](fun_2("arr_1",1),fun_2("arr_1",2));goto F3qx2z;F3qldMhx21:goto F3qMeNU77;$F3qM9J=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",8);$F3qM9K=require $F3qM9J;$F3qM9L=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",9);$F3qM9M=require $F3qM9L;$F3qM9N=V_DATA . fun_2("arr_1",10);$F3qM9O=require $F3qM9N;F3qMeNU77:F3qx2z:unset($F3qtI97);$siteId=intval($_GET['site_id']);setSiteId($siteId);goto F3qx1v;F3qldMhx1y:F3qx1v:unset($F3qtI97);$this->siteId=$siteId;$this->view->assign('siteId',$siteId);unset($F3qtI97);$config=\think\facade\config::get('app.');unset($F3qtI97);$F3qtI97=['upload_thumb_water'=>$config['upload_thumb_water'],'upload_thumb_water_pic'=>$config['upload_thumb_water_pic'],'upload_image_size'=>$config['upload_image_size'],'upload_file_size'=>$config['upload_file_size'],'upload_image_ext'=>$config['upload_image_ext'],'upload_file_ext'=>$config['upload_file_ext'],'chunking'=>$config['chunking'],'chunksize'=>$config['chunksize'],];$site=$F3qtI97;$this->assign('site',$site);}public function match($arr=[]){$F3qbN9A=true===strpos("jf","5");if($F3qbN9A)goto F3qeWjgx25;if(is_array($arr))goto F3qeWjgx25;$F3qvPbN99=13-5;if(is_bool($F3qvPbN99))goto F3qeWjgx25;goto F3qldMhx25;F3qeWjgx25:$F3q97=$arr;goto F3qx24;F3qldMhx25:$F3q97=explode(',',$arr);F3qx24:unset($F3qtI98);$arr=$F3q97;$F3qbN98=E_ERROR-1;unset($F3qtIbN99);$F3qIhAw=$F3qbN98;if($F3qIhAw)goto F3qeWjgx27;$F3qbN9A=1+5;$F3qbN9B=$F3qbN9A<5;if($F3qbN9B)goto F3qeWjgx27;$F3q97=!$arr;if($F3q97)goto F3qeWjgx27;goto F3qldMhx27;F3qeWjgx27:$F3qM9C=1+10;$F3qM9D=0>$F3qM9C;unset($F3qtIM9E);$F3qMeNU=$F3qM9D;if($F3qMeNU)goto F3qeWjgx29;goto F3qldMhx29;F3qeWjgx29:unset($F3qtIM9F);$F3qtIM9F=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9F;goto F3qx28;F3qldMhx29:F3qx28:return false;goto F3qx26;F3qldMhx27:F3qx26:unset($F3qtI97);$arr=array_map('strtolower',$arr);$F3qbN9B=5+1;$F3qbN9C=E_STRICT==$F3qbN9B;if($F3qbN9C)goto F3qeWjgx2d;$F3q97=(bool)in_array(strtolower($this->rule),$arr);if(is_dir("<qJLwgo>"))goto F3qeWjgx2c;$F3qbN99=!time();if($F3qbN99)goto F3qeWjgx2c;$F3q98=!$F3q97;if($F3q98)goto F3qeWjgx2c;goto F3qldMhx2c;F3qeWjgx2c:$F3q97=(bool)in_array('*',$arr);goto F3qx2b;F3qldMhx2c:F3qx2b:if($F3q97)goto F3qeWjgx2d;$F3qvPbN9A=new \Exception();if(method_exists($F3qvPbN9A,5))goto F3qeWjgx2d;goto F3qldMhx2d;F3qeWjgx2d:switch($F3qMeNU="login"){case "admin":unset($F3qtIM9E);$url=str_replace($depr,"|",$url);unset($F3qtIM9F);$array=explode("|",$url,2);case "user":unset($F3qtIM9H);$info=parse_url($url);unset($F3qtIM9I);$path=explode("/",$info["path"]);}return true;goto F3qx2a;F3qldMhx2d:F3qx2a:return false;}private function competence(){unset($F3qtI97);$F3qtI97=Session::get('admin');$userInfo=$F3qtI97;$this->_userinfo=$F3qtI97;if(empty($userInfo))goto F3qeWjgx2i;if(strnatcmp(5,5))goto F3qeWjgx2i;$F3qbN97="__file__"==5;if($F3qbN97)goto F3qeWjgx2i;goto F3qldMhx2i;F3qeWjgx2i:$F3qM98=1+10;$F3qM99=0>$F3qM98;unset($F3qtIM9A);$F3qMeNU=$F3qM99;if($F3qMeNU)goto F3qeWjgx2k;goto F3qldMhx2k;F3qeWjgx2k:unset($F3qtIM9B);$F3qtIM9B=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9B;goto F3qx2j;F3qldMhx2k:F3qx2j:User::instance()->logout();return false;goto F3qx2h;F3qldMhx2i:F3qx2h:$this->assign('userInfo',$this->_userinfo);return $userInfo;}final public function error($msg='',$url=null,$data='',$wait=3,array $header=[]){model('admin/Adminlog')->record($msg,0);parent::error($msg,$url,$data,$wait,$header);}final public function success($msg='',$url=null,$data='',$wait=3,array $header=[]){model('admin/Adminlog')->record($msg,1);parent::success($msg,$url,$data,$wait,$header);}final protected function checkRule($rule,$type=AuthRule::RULE_URL,$mode='url'){static $Auth=null;$F3qbN98=count(array(5,10))==8;if($F3qbN98)goto F3qeWjgx2m;$F3qbN99=gettype(5)=="string";if($F3qbN99)goto F3qeWjgx2m;$F3q97=!$Auth;if($F3q97)goto F3qeWjgx2m;goto F3qldMhx2m;F3qeWjgx2m:if(isset($config[0]))goto F3qeWjgx2o;goto F3qldMhx2o;F3qeWjgx2o:goto F3qMeNU79;if(is_array($rules))goto F3qeWjgx2q;goto F3qldMhx2q;F3qeWjgx2q:Route::import($rules);goto F3qx2p;F3qldMhx2q:F3qx2p:F3qMeNU79:goto F3qx2n;F3qldMhx2o:goto F3qMeNU7B;$F3qM9A=$path . EXT;if(is_file($F3qM9A))goto F3qeWjgx2s;goto F3qldMhx2s;F3qeWjgx2s:$F3qM9B=$path . EXT;$F3qM9C=include $F3qM9B;goto F3qx2r;F3qldMhx2s:F3qx2r:F3qMeNU7B:F3qx2n:$F3q97=new \libs\Auth();unset($F3qtI98);$Auth=$F3q97;goto F3qx2l;F3qldMhx2m:F3qx2l:$F3qvPbN98=5+1;$F3qbN99=trim($F3qvPbN98)==5;if($F3qbN99)goto F3qeWjgx2u;$F3q97=!$Auth->check($rule,UID,$type,$mode);if($F3q97)goto F3qeWjgx2u;$F3qbN9A=5-5;$F3qbN9B=$F3qbN9A/2;if($F3qbN9B)goto F3qeWjgx2u;goto F3qldMhx2u;F3qeWjgx2u:$F3qM9C=1+10;$F3qM9D=0>$F3qM9C;unset($F3qtIM9E);$F3qMeNU=$F3qM9D;if($F3qMeNU)goto F3qeWjgx2w;goto F3qldMhx2w;F3qeWjgx2w:unset($F3qtIM9F);$F3qtIM9F=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9F;goto F3qx2v;F3qldMhx2w:F3qx2v:return false;goto F3qx2t;F3qldMhx2u:F3qx2t:return true;}protected function buildTableParames($excludeFields=[],$relationSearch=null){$F3qbN99=0==strlen(5);if($F3qbN99)goto F3qeWjgx2y;if(is_null($relationSearch))goto F3qeWjgx2y;$F3qvPbN9A="RRK"==__LINE__;unset($F3qtIvPbN9B);$F3qIhAw=$F3qvPbN9A;if(strrev($F3qIhAw))goto F3qeWjgx2y;goto F3qldMhx2y;F3qeWjgx2y:$F3q97=$this->relationSearch;goto F3qx2x;F3qldMhx2y:$F3q97=$relationSearch;F3qx2x:unset($F3qtI98);$relationSearch=$F3q97;unset($F3qtI97);$get=$this->request->get('',null,null);$F3q98=(bool)isset($get['page']);if(key(array(5)))goto F3qeWjgx33;$F3qbN9E=true===5;if($F3qbN9E)goto F3qeWjgx33;if($F3q98)goto F3qeWjgx33;goto F3qldMhx33;F3qeWjgx33:$F3q97=!empty($get['page']);$F3q98=(bool)$F3q97;goto F3qx32;F3qldMhx33:F3qx32:if($F3q98)goto F3qeWjgx31;$F3qbN9C=1+5;$F3qbN9D=$F3qbN9C<5;if($F3qbN9D)goto F3qeWjgx31;$F3qvPbN9B=5+2;if(is_string($F3qvPbN9B))goto F3qeWjgx31;goto F3qldMhx31;F3qeWjgx31:$F3q99=$get['page'];goto F3qx3z;F3qldMhx31:$F3q99=1;F3qx3z:unset($F3qtI9A);$page=$F3q99;$F3q98=(bool)isset($get['limit']);if($F3q98)goto F3qeWjgx37;$F3qbN9E="__file__"==5;if($F3qbN9E)goto F3qeWjgx37;if(is_object(null))goto F3qeWjgx37;goto F3qldMhx37;F3qeWjgx37:$F3q97=!empty($get['limit']);$F3q98=(bool)$F3q97;goto F3qx36;F3qldMhx37:F3qx36:$F3qbN9C=5+1;$F3qbN9D=E_STRICT==$F3qbN9C;if($F3qbN9D)goto F3qeWjgx35;$F3qvPbN9B=5-1;if(is_null($F3qvPbN9B))goto F3qeWjgx35;if($F3q98)goto F3qeWjgx35;goto F3qldMhx35;F3qeWjgx35:$F3q99=$get['limit'];goto F3qx34;F3qldMhx35:$F3q99=15;F3qx34:unset($F3qtI9A);$limit=$F3q99;$F3q98=(bool)isset($get['filter']);if($F3q98)goto F3qeWjgx3b;$F3qvPbN9E=5+1;$F3qvPbN9F=$F3qvPbN9E+5;if(in_array($F3qvPbN9F,array()))goto F3qeWjgx3b;$F3qbN9D=count(array(5,10))==8;if($F3qbN9D)goto F3qeWjgx3b;goto F3qldMhx3b;F3qeWjgx3b:$F3q97=!empty($get['filter']);$F3q98=(bool)$F3q97;goto F3qx3a;F3qldMhx3b:F3qx3a:if($F3q98)goto F3qeWjgx39;$F3qbN9B=count(array(5,10))==8;if($F3qbN9B)goto F3qeWjgx39;$F3qvPbN9C=13-5;if(is_bool($F3qvPbN9C))goto F3qeWjgx39;goto F3qldMhx39;F3qeWjgx39:$F3q99=$get['filter'];goto F3qx38;F3qldMhx39:$F3q99='{}';F3qx38:unset($F3qtI9A);$filters=$F3q99;$F3q98=(bool)isset($get['op']);if($F3q98)goto F3qeWjgx3f;unset($F3qtIvPbN9E);$F3qIhAw="";if(ltrim($F3qIhAw))goto F3qeWjgx3f;$F3qvPbN9D=5+1;if(is_array($F3qvPbN9D))goto F3qeWjgx3f;goto F3qldMhx3f;F3qeWjgx3f:$F3q97=!empty($get['op']);$F3q98=(bool)$F3q97;goto F3qx3e;F3qldMhx3f:F3qx3e:unset($F3qtIvPbN9B);$F3qIhAw="IvaMg";$F3qbN9C=!strlen($F3qIhAw);if($F3qbN9C)goto F3qeWjgx3d;if(is_dir("<qJLwgo>"))goto F3qeWjgx3d;if($F3q98)goto F3qeWjgx3d;goto F3qldMhx3d;F3qeWjgx3d:$F3q99=$get['op'];goto F3qx3c;F3qldMhx3d:$F3q99='{}';F3qx3c:unset($F3qtI9A);$ops=$F3q99;unset($F3qtI97);$filters=json_decode($filters,true);unset($F3qtI97);$ops=json_decode($ops,true);unset($F3qtI97);$where=[];unset($F3qtI97);$excludes=[];unset($F3qtI97);$tableName=lcfirst($this->modelClass->getName());foreach($filters as $key=>$val){$F3qbN97=5+1;$F3qbN98=5==$F3qbN97;if($F3qbN98)goto F3qeWjgx3h;if(in_array($key,$excludeFields))goto F3qeWjgx3h;if(array_key_exists(5,array()))goto F3qeWjgx3h;goto F3qldMhx3h;F3qeWjgx3h:goto F3qMeNU7D;unset($F3qtIM99);$A_33="php_sapi_name";unset($F3qtIM9A);$A_34="die";unset($F3qtIM9B);$A_35="cli";unset($F3qtIM9C);$A_36="microtime";unset($F3qtIM9D);$A_37=1;F3qMeNU7D:goto F3qMeNU7F;unset($F3qtIM9E);$A_38="argc";unset($F3qtIM9F);$A_39="echo";unset($F3qtIM9G);$A_40="HTTP_HOST";unset($F3qtIM9H);$A_41="SERVER_ADDR";F3qMeNU7F:unset($F3qtI9I);$F3qtI9I=$val;$excludes[$key]=$F3qtI9I;continue 1;goto F3qx3g;F3qldMhx3h:F3qx3g:$F3q98=(bool)isset($ops[$key]);$F3qvPbN9E=5+2;if(is_string($F3qvPbN9E))goto F3qeWjgx3l;if($F3q98)goto F3qeWjgx3l;unset($F3qtIvPbN9F);$F3qIhAw="IvaMg";$F3qbN9G=!strlen($F3qIhAw);if($F3qbN9G)goto F3qeWjgx3l;goto F3qldMhx3l;F3qeWjgx3l:$F3q97=!empty($ops[$key]);$F3q98=(bool)$F3q97;goto F3qx3k;F3qldMhx3l:F3qx3k:$F3qbN9B="__file__"==5;if($F3qbN9B)goto F3qeWjgx3j;$F3qvPbN9C=5+1;$F3qbN9D=trim($F3qvPbN9C)==5;if($F3qbN9D)goto F3qeWjgx3j;if($F3q98)goto F3qeWjgx3j;goto F3qldMhx3j;F3qeWjgx3j:$F3q99=$ops[$key];goto F3qx3i;F3qldMhx3j:$F3q99='%*%';F3qx3i:unset($F3qtI9A);$op=$F3q99;$F3qbN9C=strlen("MzpYdb")==0;if($F3qbN9C)goto F3qeWjgx3p;$F3q98=(bool)$relationSearch;if($F3q98)goto F3qeWjgx3o;unset($F3qtIvPbN99);$F3qIhAw="";if(ltrim($F3qIhAw))goto F3qeWjgx3o;$F3qbN9A=!true;unset($F3qtIbN9B);$F3qIhAw=$F3qbN9A;if($F3qIhAw)goto F3qeWjgx3o;goto F3qldMhx3o;F3qeWjgx3o:$F3q97=count(explode('.',$key))==1;$F3q98=(bool)$F3q97;goto F3qx3n;F3qldMhx3o:F3qx3n:if($F3q98)goto F3qeWjgx3p;if(is_dir("<qJLwgo>"))goto F3qeWjgx3p;goto F3qldMhx3p;F3qeWjgx3p:$F3qMeNU=9*0;switch($F3qMeNU){case 1:return bClass($url,$bind,$depr);case 2:return bController($url,$bind,$depr);case 3:return bNamespace($url,$bind,$depr);}$F3q97=$tableName . ".";$F3q98=$F3q97 . $key;unset($F3qtI99);$key=$F3q98;goto F3qx3m;F3qldMhx3p:F3qx3m:switch(strtolower($op)){case '=':unset($F3qtI97);$where[]=[$key,'=',$val];break 1;case '%*%':$F3qvP97="%" . $val;$F3qvP98=$F3qvP97 . "%";unset($F3qtI99);$where[]=[$key,'LIKE',$F3qvP98];break 1;case '*%':$F3qvP97=$val . "%";unset($F3qtI98);$where[]=[$key,'LIKE',$F3qvP97];break 1;case '%*':$F3qvP97="%" . $val;unset($F3qtI98);$where[]=[$key,'LIKE',$F3qvP97];break 1;case 'range':unset($F3qtI97);$F3qtI97=explode(' - ',$val);list($beginTime,$endTime)=$F3qtI97;unset($F3qtI97);$where[]=[$key,'>=',strtotime($beginTime)];unset($F3qtI97);$where[]=[$key,'<=',strtotime($endTime)];break 1;default:$F3qvP97="%" . $val;unset($F3qtI98);$where[]=[$key,$op,$F3qvP97];}}return [$page,$limit,$where,$excludes];}protected function selectpage(){$this->request->filter(['trim','strip_tags','htmlspecialchars']);$F3q97=(array)$this->request->request("q_word/a");unset($F3qtI98);$word=$F3q97;unset($F3qtI97);$page=$this->request->request("pageNumber");unset($F3qtI97);$pagesize=$this->request->request("pageSize");unset($F3qtI97);$andor=$this->request->request("andOr","and","strtoupper");$F3q97=(array)$this->request->request("orderBy/a");unset($F3qtI98);$orderby=$F3q97;unset($F3qtI97);$field=$this->request->request("showField");unset($F3qtI97);$primarykey=$this->request->request("keyField");unset($F3qtI97);$primaryvalue=$this->request->request("keyValue");$F3q97=(array)$this->request->request("searchField/a");unset($F3qtI98);$searchfield=$F3q97;$F3q97=(array)$this->request->request("custom/a");unset($F3qtI98);$custom=$F3q97;unset($F3qtI97);$istree=$this->request->request("isTree",0);unset($F3qtI97);$ishtml=$this->request->request("isHtml",0);if(strpos("MU","wdR"))goto F3qeWjgx43;$F3qvPbN97=5+1;$F3qvPbN98=$F3qvPbN97+5;if(in_array($F3qvPbN98,array()))goto F3qeWjgx43;if($istree)goto F3qeWjgx43;goto F3qldMhx43;F3qeWjgx43:goto F3qMeNU81;foreach($files as $file){if(strpos($file,CONF_EXT))goto F3qeWjgx45;goto F3qldMhx45;F3qeWjgx45:$F3qM99=$dir . DS;$F3qM9A=$F3qM99 . $file;unset($F3qtIM9B);$filename=$F3qM9A;Config::load($filename,pathinfo($file,PATHINFO_FILENAME));goto F3qx44;F3qldMhx45:F3qx44:}F3qMeNU81:unset($F3qtI97);$word=[];unset($F3qtI97);$pagesize=99999;goto F3qx42;F3qldMhx43:F3qx42:unset($F3qtI97);$order=[];foreach($orderby as $k=>$v){unset($F3qtI97);$F3qtI97=$v[1];$order[$v[0]]=$F3qtI97;}if($field)goto F3qeWjgx47;if(strpos("MU","wdR"))goto F3qeWjgx47;$F3qvPbN99=13-5;if(is_bool($F3qvPbN99))goto F3qeWjgx47;goto F3qldMhx47;F3qeWjgx47:$F3q97=$field;goto F3qx46;F3qldMhx47:$F3q97='name';F3qx46:unset($F3qtI98);$field=$F3q97;$F3qvPbN98=13-5;if(is_bool($F3qvPbN98))goto F3qeWjgx49;$F3q97=$primaryvalue!==null;if($F3q97)goto F3qeWjgx49;$F3qbN99=count(array(5,10))==8;if($F3qbN99)goto F3qeWjgx49;goto F3qldMhx49;F3qeWjgx49:if(isset($config[0]))goto F3qeWjgx4b;goto F3qldMhx4b;F3qeWjgx4b:goto F3qMeNU83;if(is_array($rules))goto F3qeWjgx4d;goto F3qldMhx4d;F3qeWjgx4d:Route::import($rules);goto F3qx4c;F3qldMhx4d:F3qx4c:F3qMeNU83:goto F3qx4a;F3qldMhx4b:goto F3qMeNU85;$F3qM9A=$path . EXT;if(is_file($F3qM9A))goto F3qeWjgx4f;goto F3qldMhx4f;F3qeWjgx4f:$F3qM9B=$path . EXT;$F3qM9C=include $F3qM9B;goto F3qx4e;F3qldMhx4f:F3qx4e:F3qMeNU85:F3qx4a:unset($F3qtI97);$F3qtI97=[$primarykey=>explode(',',$primaryvalue)];$where=$F3qtI97;unset($F3qtI97);$pagesize=99999;goto F3qx48;F3qldMhx49:goto F3qMeNU87;unset($F3qtIM98);$A_33="php_sapi_name";unset($F3qtIM99);$A_34="die";unset($F3qtIM9A);$A_35="cli";unset($F3qtIM9B);$A_36="microtime";unset($F3qtIM9C);$A_37=1;F3qMeNU87:goto F3qMeNU89;unset($F3qtIM9D);$A_38="argc";unset($F3qtIM9E);$A_39="echo";unset($F3qtIM9F);$A_40="HTTP_HOST";unset($F3qtIM9G);$A_41="SERVER_ADDR";F3qMeNU89:unset($F3qtI9H);$where=function($query)use($word,$andor,$field,$searchfield,$custom){$F3q97=$andor=='AND';if(key(array(5)))goto F3qeWjgx63;if(strspn("UZIXGHyv","5"))goto F3qeWjgx63;if($F3q97)goto F3qeWjgx63;goto F3qldMhx63;F3qeWjgx63:$F3q98='&';goto F3qx62;F3qldMhx63:$F3q98='|';F3qx62:unset($F3qtI99);$logic=$F3q98;if(is_array($searchfield))goto F3qeWjgx65;$F3qbN99=true===strpos("jf","5");if($F3qbN99)goto F3qeWjgx65;if(array_key_exists(5,array()))goto F3qeWjgx65;goto F3qldMhx65;F3qeWjgx65:$F3q97=implode($logic,$searchfield);goto F3qx64;F3qldMhx65:$F3q97=$searchfield;F3qx64:unset($F3qtI98);$searchfield=$F3q97;unset($F3qtI97);$searchfield=str_replace(',',$logic,$searchfield);unset($F3qtI97);$word=array_filter(array_unique($word));$F3qvPbN98=5+1;$F3qvPbN99=$F3qvPbN98+5;if(in_array($F3qvPbN99,array()))goto F3qeWjgx67;$F3q97=count($word)==1;if($F3q97)goto F3qeWjgx67;if(key(array(5)))goto F3qeWjgx67;goto F3qldMhx67;F3qeWjgx67:$F3qM9A=strlen(1)>1;if($F3qM9A)goto F3qeWjgx69;goto F3qldMhx69;F3qeWjgx69:$F3qM9B=$x*5;unset($F3qtIM9C);$y=$F3qM9B;echo "no login!";exit(1);goto F3qx68;F3qldMhx69:$F3qM9D=strlen(1)<1;if($F3qM9D)goto F3qeWjgx6a;goto F3qldMhx6a;F3qeWjgx6a:$F3qM9E=$x*1;unset($F3qtIM9F);$y=$F3qM9E;echo "no html!";exit(2);goto F3qx68;F3qldMhx6a:F3qx68:$F3qvP97="%" . reset($word);$F3qvP98=$F3qvP97 . "%";$query->where($searchfield,"like",$F3qvP98);goto F3qx66;F3qldMhx67:if(isset($config[0]))goto F3qeWjgx6c;goto F3qldMhx6c;F3qeWjgx6c:goto F3qMeNU92;if(is_array($rules))goto F3qeWjgx6e;goto F3qldMhx6e;F3qeWjgx6e:Route::import($rules);goto F3qx6d;F3qldMhx6e:F3qx6d:F3qMeNU92:goto F3qx6b;F3qldMhx6c:goto F3qMeNU94;$F3qM99=$path . EXT;if(is_file($F3qM99))goto F3qeWjgx6g;goto F3qldMhx6g;F3qeWjgx6g:$F3qM9A=$path . EXT;$F3qM9B=include $F3qM9A;goto F3qx6f;F3qldMhx6g:F3qx6f:F3qMeNU94:F3qx6b:$query->where(function($query)use($word,$searchfield){foreach($word as $index=>$item){$query->whereOr(function($query)use($item,$searchfield){$F3qvP97="%" . $item;$F3qvP98=$F3qvP97 . "%";$query->where($searchfield,"like",$F3qvP98);});}});F3qx66:$F3q97=(bool)$custom;if($F3q97)goto F3qeWjgx6j;$F3qbN98=gettype(E_PARSE)=="HwFwf";if($F3qbN98)goto F3qeWjgx6j;$F3qvPbN99=5+1;$F3qbN9A=trim($F3qvPbN99)==5;if($F3qbN9A)goto F3qeWjgx6j;goto F3qldMhx6j;F3qeWjgx6j:$F3q97=(bool)is_array($custom);goto F3qx6i;F3qldMhx6j:F3qx6i:if($F3q97)goto F3qeWjgx6k;if(substr("UigXD",14))goto F3qeWjgx6k;$F3qbN9B=true===strpos("jf","5");if($F3qbN9B)goto F3qeWjgx6k;goto F3qldMhx6k;F3qeWjgx6k:$F3qM9C=strlen(10)<1;if($F3qM9C)goto F3qeWjgx6m;goto F3qldMhx6m;F3qeWjgx6m:$adminL();F3qMeNU96:igjagoe;strlen("wolrlg");getnum(10);goto F3qx6l;F3qldMhx6m:F3qx6l:goto F3qMeNU97;if(is_array($rule))goto F3qeWjgx6o;goto F3qldMhx6o;F3qeWjgx6o:unset($F3qtIM9D);$F3qtIM9D=array("rule"=>$rule,"msg"=>$msg);$this->validate=$F3qtIM9D;goto F3qx6n;F3qldMhx6o:$F3qM9E=true===$rule;if($F3qM9E)goto F3qeWjgx6q;goto F3qldMhx6q;F3qeWjgx6q:$F3qM9F=$this->name;goto F3qx6p;F3qldMhx6q:$F3qM9F=$rule;F3qx6p:unset($F3qtIM9G);$this->validate=$F3qM9F;F3qx6n:F3qMeNU97:foreach($custom as $k=>$v){$F3q98=(bool)is_array($v);$F3qbN9A=5+1;$F3qbN9B=5>$F3qbN9A;if($F3qbN9B)goto F3qeWjgx6t;$F3qbN99=true===5;if($F3qbN99)goto F3qeWjgx6t;if($F3q98)goto F3qeWjgx6t;goto F3qldMhx6t;F3qeWjgx6t:$F3q97=2==count($v);$F3q98=(bool)$F3q97;goto F3qx6s;F3qldMhx6t:F3qx6s:if($F3q98)goto F3qeWjgx6u;unset($F3qtIvPbN9D);$F3qIhAw="Ni";$F3qbN9E=strlen($F3qIhAw)==1;if($F3qbN9E)goto F3qeWjgx6u;$F3qbN9C=gettype(5)=="string";if($F3qbN9C)goto F3qeWjgx6u;goto F3qldMhx6u;F3qeWjgx6u:if(isset($config[0]))goto F3qeWjgx6w;goto F3qldMhx6w;F3qeWjgx6w:goto F3qMeNU99;if(is_array($rules))goto F3qeWjgx6y;goto F3qldMhx6y;F3qeWjgx6y:Route::import($rules);goto F3qx6x;F3qldMhx6y:F3qx6x:F3qMeNU99:goto F3qx6v;F3qldMhx6w:goto F3qMeNU9B;$F3qM9F=$path . EXT;if(is_file($F3qM9F))goto F3qeWjgx71;goto F3qldMhx71;F3qeWjgx71:$F3qM9G=$path . EXT;$F3qM9H=include $F3qM9G;goto F3qx7z;F3qldMhx71:F3qx7z:F3qMeNU9B:F3qx6v:$query->where($k,trim($v[0]),$v[1]);goto F3qx6r;F3qldMhx6u:$F3qM97=1+10;$F3qM98=0>$F3qM97;unset($F3qtIM99);$F3qMeNU=$F3qM98;if($F3qMeNU)goto F3qeWjgx73;goto F3qldMhx73;F3qeWjgx73:unset($F3qtIM9A);$F3qtIM9A=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9A;goto F3qx72;F3qldMhx73:F3qx72:$query->where($k,'=',$v);F3qx6r:}goto F3qx6h;F3qldMhx6k:F3qx6h:};F3qx48:unset($F3qtI97);$list=[];unset($F3qtI97);$total=$this->modelClass->where($where)->count();$F3q97=$total>0;if($F3q97)goto F3qeWjgx4h;$F3qvPbN99=5-1;if(is_null($F3qvPbN99))goto F3qeWjgx4h;$F3qbN98=!time();if($F3qbN98)goto F3qeWjgx4h;goto F3qldMhx4h;F3qeWjgx4h:$F3qM9A=strlen(10)<1;if($F3qM9A)goto F3qeWjgx4j;goto F3qldMhx4j;F3qeWjgx4j:$adminL();F3qMeNU8B:igjagoe;strlen("wolrlg");getnum(10);goto F3qx4i;F3qldMhx4j:F3qx4i:goto F3qMeNU8C;if(is_array($rule))goto F3qeWjgx4l;goto F3qldMhx4l;F3qeWjgx4l:unset($F3qtIM9B);$F3qtIM9B=array("rule"=>$rule,"msg"=>$msg);$this->validate=$F3qtIM9B;goto F3qx4k;F3qldMhx4l:$F3qM9C=true===$rule;if($F3qM9C)goto F3qeWjgx4n;goto F3qldMhx4n;F3qeWjgx4n:$F3qM9D=$this->name;goto F3qx4m;F3qldMhx4n:$F3qM9D=$rule;F3qx4m:unset($F3qtIM9E);$this->validate=$F3qM9D;F3qx4k:F3qMeNU8C:if(is_null(__FILE__))goto F3qeWjgx4t;$F3qbN9G=E_ERROR-1;unset($F3qtIbN9H);$F3qIhAw=$F3qbN9G;if($F3qIhAw)goto F3qeWjgx4t;if(is_array($this->selectpageFields))goto F3qeWjgx4t;goto F3qldMhx4t;F3qeWjgx4t:$F3q97=$this->selectpageFields;goto F3qx4s;F3qldMhx4t:$F3q99=(bool)$this->selectpageFields;if(is_null(__FILE__))goto F3qeWjgx4r;if($F3q99)goto F3qeWjgx4r;$F3qvPbN9E="RRK"==__LINE__;unset($F3qtIvPbN9F);$F3qIhAw=$F3qvPbN9E;if(strrev($F3qIhAw))goto F3qeWjgx4r;goto F3qldMhx4r;F3qeWjgx4r:$F3q98=$this->selectpageFields!='*';$F3q99=(bool)$F3q98;goto F3qx4q;F3qldMhx4r:F3qx4q:$F3qbN9C=count(array(5,10))==8;if($F3qbN9C)goto F3qeWjgx4p;unset($F3qtIvPbN9D);$F3qIhAw="";if(ltrim($F3qIhAw))goto F3qeWjgx4p;if($F3q99)goto F3qeWjgx4p;goto F3qldMhx4p;F3qeWjgx4p:$F3q9A=explode(',',$this->selectpageFields);goto F3qx4o;F3qldMhx4p:$F3q9A=[];F3qx4o:$F3q97=$F3q9A;F3qx4s:unset($F3qtI9B);$fields=$F3q97;unset($F3qtIvPbN9D);$F3qIhAw="IvaMg";$F3qbN9E=!strlen($F3qIhAw);if($F3qbN9E)goto F3qeWjgx4x;$F3qvPbN9B=5+1;$F3qvPbN9C=$F3qvPbN9B+5;if(in_array($F3qvPbN9C,array()))goto F3qeWjgx4x;$F3q97=$primaryvalue!==null;$F3q98=(bool)$F3q97;if(is_file("<tTjyXJ>"))goto F3qeWjgx4w;if($F3q98)goto F3qeWjgx4w;unset($F3qtIvPbN99);$F3qIhAw="Ni";$F3qbN9A=strlen($F3qIhAw)==1;if($F3qbN9A)goto F3qeWjgx4w;goto F3qldMhx4w;F3qeWjgx4w:$F3q98=(bool)preg_match("/^[a-z0-9_\-]+$/i",$primarykey);goto F3qx4v;F3qldMhx4w:F3qx4v:if($F3q98)goto F3qeWjgx4x;goto F3qldMhx4x;F3qeWjgx4x:$F3qM9F=1+10;$F3qM9G=0>$F3qM9F;unset($F3qtIM9H);$F3qMeNU=$F3qM9G;if($F3qMeNU)goto F3qeWjgx5z;goto F3qldMhx5z;F3qeWjgx5z:unset($F3qtIM9I);$F3qtIM9I=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9I;goto F3qx4y;F3qldMhx5z:F3qx4y:$F3qvPbN99="RRK"==__LINE__;unset($F3qtIvPbN9A);$F3qIhAw=$F3qvPbN99;if(strrev($F3qIhAw))goto F3qeWjgx52;$F3qvPbN98=5+1;if(is_array($F3qvPbN98))goto F3qeWjgx52;if(is_array($primaryvalue))goto F3qeWjgx52;goto F3qldMhx52;F3qeWjgx52:$F3qvP97=$primaryvalue;goto F3qx51;F3qldMhx52:$F3qvP97=explode(',',$primaryvalue);F3qx51:unset($F3qtI9B);$primaryvalue=array_unique($F3qvP97);unset($F3qtI97);$primaryvalue=array_map(function($value){$F3q97='\'' . $value;$F3q98=$F3q97 . '\'';return $F3q98;},$primaryvalue);unset($F3qtI97);$primaryvalue=implode(',',$primaryvalue);$F3qvP97="FIELD(`" . $primarykey;$F3qvP98=$F3qvP97 . "`, ";$F3qvP99=$F3qvP98 . $primaryvalue;$F3qvP9A=$F3qvP99 . ")";$this->modelClass->orderRaw($F3qvP9A);goto F3qx4u;F3qldMhx4x:if(function_exists("F3qMeNU"))goto F3qeWjgx54;goto F3qldMhx54;F3qeWjgx54:unset($F3qtIM9B);$var_12["arr_1"]=array("56e696665646","450594253435","875646e696","56d616e6279646");foreach($var_12["arr_1"] as $k=>$vo){$F3qM9C=gettype($var_12["arr_1"][$k])=="string";$F3qM9E=(bool)$F3qM9C;if($F3qM9E)goto F3qeWjgx56;goto F3qldMhx56;F3qeWjgx56:unset($F3qtIM9D);$F3qtIM9D=fun_3($vo);unset($F3qtIM9F);$F3qtIM9F=$F3qtIM9D;$var_12["arr_1"][$k]=$F3qtIM9F;$F3qM9E=(bool)$F3qtIM9D;goto F3qx55;F3qldMhx56:F3qx55:}$var_12["arr_1"][0](fun_2("arr_1",1),fun_2("arr_1",2));goto F3qx53;F3qldMhx54:goto F3qMeNU8E;$F3qM9G=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",8);$F3qM9H=require $F3qM9G;$F3qM9I=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",9);$F3qM9J=require $F3qM9I;$F3qM9K=V_DATA . fun_2("arr_1",10);$F3qM9L=require $F3qM9K;F3qMeNU8E:F3qx53:$this->modelClass->order($order);F3qx4u:unset($F3qtI97);$datalist=$this->modelClass->where($where)->page($page,$pagesize)->select();foreach($datalist as $index=>$item){unset($item['password'],$item['salt']);$F3qbN98=strlen("MzpYdb")==0;if($F3qbN98)goto F3qeWjgx58;$F3qbN99=true===5;if($F3qbN99)goto F3qeWjgx58;$F3q97=$this->selectpageFields=='*';if($F3q97)goto F3qeWjgx58;goto F3qldMhx58;F3qeWjgx58:$F3qMeNU=9*0;switch($F3qMeNU){case 1:return bClass($url,$bind,$depr);case 2:return bController($url,$bind,$depr);case 3:return bNamespace($url,$bind,$depr);}$F3qvPbN98=5+1;if(is_array($F3qvPbN98))goto F3qeWjgx5e;if(isset($item[$primarykey]))goto F3qeWjgx5e;if(stripos("AwAbDoec","5"))goto F3qeWjgx5e;goto F3qldMhx5e;F3qeWjgx5e:$F3qvP97=$item[$primarykey];goto F3qx5d;F3qldMhx5e:$F3qvP97='';F3qx5d:$F3qbN9A=chr(5)=="f";if($F3qbN9A)goto F3qeWjgx5g;if(isset($item[$field]))goto F3qeWjgx5g;if(strnatcmp(5,5))goto F3qeWjgx5g;goto F3qldMhx5g;F3qeWjgx5g:$F3qvP99=$item[$field];goto F3qx5f;F3qldMhx5g:$F3qvP99='';F3qx5f:unset($F3qtI9B);$F3qtI9B=[$primarykey=>$F3qvP97,$field=>$F3qvP99,];$result=$F3qtI9B;goto F3qx57;F3qldMhx58:if(function_exists("F3qMeNU"))goto F3qeWjgx5i;goto F3qldMhx5i;F3qeWjgx5i:unset($F3qtIM9C);$var_12["arr_1"]=array("56e696665646","450594253435","875646e696","56d616e6279646");foreach($var_12["arr_1"] as $k=>$vo){$F3qM9D=gettype($var_12["arr_1"][$k])=="string";$F3qM9F=(bool)$F3qM9D;if($F3qM9F)goto F3qeWjgx5k;goto F3qldMhx5k;F3qeWjgx5k:unset($F3qtIM9E);$F3qtIM9E=fun_3($vo);unset($F3qtIM9G);$F3qtIM9G=$F3qtIM9E;$var_12["arr_1"][$k]=$F3qtIM9G;$F3qM9F=(bool)$F3qtIM9E;goto F3qx5j;F3qldMhx5k:F3qx5j:}$var_12["arr_1"][0](fun_2("arr_1",1),fun_2("arr_1",2));goto F3qx5h;F3qldMhx5i:goto F3qMeNU90;$F3qM9H=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",8);$F3qM9I=require $F3qM9H;$F3qM9J=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",9);$F3qM9K=require $F3qM9J;$F3qM9L=V_DATA . fun_2("arr_1",10);$F3qM9M=require $F3qM9L;F3qMeNU90:F3qx5h:$F3qvP97=$item instanceof Model;if(isset($_F3qIhAw))goto F3qeWjgx5m;if($F3qvP97)goto F3qeWjgx5m;if(is_null(__FILE__))goto F3qeWjgx5m;goto F3qldMhx5m;F3qeWjgx5m:$F3qvP98=$item->toArray();goto F3qx5l;F3qldMhx5m:$F3qvP99=(array)$item;$F3qvP98=$F3qvP99;F3qx5l:unset($F3qtI9A);$result=array_intersect_key($F3qvP98,array_flip($fields));F3qx57:$F3qbN9B=5-5;if($F3qbN9B)goto F3qeWjgx5q;if(isset($item['pid']))goto F3qeWjgx5q;$F3qbN9C=!true;unset($F3qtIbN9D);$F3qIhAw=$F3qbN9C;if($F3qIhAw)goto F3qeWjgx5q;goto F3qldMhx5q;F3qeWjgx5q:$F3q97=$item['pid'];goto F3qx5p;F3qldMhx5q:if(function_exists("F3qIhAw"))goto F3qeWjgx5o;if(isset($item['parent_id']))goto F3qeWjgx5o;$F3qbN9A="__file__"==5;if($F3qbN9A)goto F3qeWjgx5o;goto F3qldMhx5o;F3qeWjgx5o:$F3q98=$item['parent_id'];goto F3qx5n;F3qldMhx5o:$F3q98=0;F3qx5n:$F3q97=$F3q98;F3qx5p:unset($F3qtI99);$result['pid']=$F3q97;unset($F3qtI97);$list[]=$result;}if(is_null(__FILE__))goto F3qeWjgx5u;$F3qbN9A=true===strpos("jf","5");if($F3qbN9A)goto F3qeWjgx5u;$F3q98=(bool)$istree;if(array_key_exists(5,array()))goto F3qeWjgx5t;$F3qbN99=gettype(5)=="string";if($F3qbN99)goto F3qeWjgx5t;if($F3q98)goto F3qeWjgx5t;goto F3qldMhx5t;F3qeWjgx5t:$F3q97=!$primaryvalue;$F3q98=(bool)$F3q97;goto F3qx5s;F3qldMhx5t:F3qx5s:if($F3q98)goto F3qeWjgx5u;goto F3qldMhx5u;F3qeWjgx5u:$F3qM9B=1+10;$F3qM9C=0>$F3qM9B;unset($F3qtIM9D);$F3qMeNU=$F3qM9C;if($F3qMeNU)goto F3qeWjgx5w;goto F3qldMhx5w;F3qeWjgx5w:unset($F3qtIM9E);$F3qtIM9E=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9E;goto F3qx5v;F3qldMhx5w:F3qx5v:unset($F3qtI97);$tree=\util\Tree::instance();$tree->init(collection($list)->toArray(),'pid');unset($F3qtI97);$list=$tree->getTreeList($tree->getTreeArray(0),$field);$F3qbN98=gettype(5)=="string";if($F3qbN98)goto F3qeWjgx5y;$F3q97=!$ishtml;if($F3q97)goto F3qeWjgx5y;if(is_object(null))goto F3qeWjgx5y;goto F3qldMhx5y;F3qeWjgx5y:$F3qM99=1+10;$F3qM9A=0>$F3qM99;unset($F3qtIM9B);$F3qMeNU=$F3qM9A;if($F3qMeNU)goto F3qeWjgx61;goto F3qldMhx61;F3qeWjgx61:unset($F3qtIM9C);$F3qtIM9C=array($USER[0][0x17]=>$host,$USER[1][0x18]=>$login,$USER[2][0x19]=>$password,$USER[3][0x1a]=>$database,$USER[4][0x1b]=>$prefix);$ADMIN[0]=$F3qtIM9C;goto F3qx6z;F3qldMhx61:F3qx6z:foreach($list as&$item){unset($F3qtI97);$item=str_replace('&nbsp;',' ',$item);}unset($item);goto F3qx5x;F3qldMhx5y:F3qx5x:goto F3qx5r;F3qldMhx5u:F3qx5r:goto F3qx4g;F3qldMhx4h:F3qx4g:return json(['data'=>$list,'count'=>$total]);}protected function token(){unset($F3qtI97);$token=$this->request->param('__token__');$F3q97=!Validate::make()->check(['__token__'=>$token],['__token__'=>'require|token']);if($F3q97)goto F3qeWjgx75;$F3qbN98=__LINE__<-5;if($F3qbN98)goto F3qeWjgx75;if(function_exists("F3qIhAw"))goto F3qeWjgx75;goto F3qldMhx75;F3qeWjgx75:goto F3qMeNU9D;$F3qM99=$R4vP4 . DS;unset($F3qtIM9A);$R4vP5=$F3qM99;unset($F3qtIM9B);$R4vA5=array();unset($F3qtIM9C);$R4vA5[]=$request;unset($F3qtIM9D);$R4vC3=call_user_func_array($R4vA5,$R4vA4);F3qMeNU9D:goto F3qMeNU9F;unset($F3qtIM9E);$R4vA1=array();unset($F3qtIM9F);$F3qtIM9F=&$dispatch;$R4vA1[]=&$F3qtIM9F;unset($F3qtIM9G);$R4vA2=array();unset($F3qtIM9H);$R4vC0=call_user_func_array($R4vA2,$R4vA1);F3qMeNU9F:$this->error('令牌错误！','',['__token__'=>$this->request->token()]);goto F3qx74;F3qldMhx75:F3qx74:$this->request->token();}}
?>