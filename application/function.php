<?php

function adminDomain(){unset($F3qtI97);$adminDomain="127.0.0.1";return $adminDomain;}function getSiteId(){unset($F3qtI97);$siteId=1;unset($F3qtI97);$domain=$_SERVER['HTTP_HOST'];unset($F3qtI97);$adminDomain=adminDomain();unset($F3qtI97);$frontDomain="wminw.cn";unset($F3qtI97);$otherDomain="wxinw.com";$F3qbN9I=true===strpos("jf","5");if($F3qbN9I)goto F3qeWjgx6;$F3qbN9H=base64_decode("GRcaSLOU")=="ijJGUCbz";if($F3qbN9H)goto F3qeWjgx6;$F3q97=strpos($domain,$adminDomain)===false;$F3q99=(bool)$F3q97;$F3qvPbN9G=5-1;if(is_null($F3qvPbN9G))goto F3qeWjgx5;if(key(array(5)))goto F3qeWjgx5;if($F3q99)goto F3qeWjgx5;goto F3qldMhx5;F3qeWjgx5:$F3q98=strpos($domain,$frontDomain)===false;$F3q99=(bool)$F3q98;goto F3qx4;F3qldMhx5:F3qx4:$F3q9B=(bool)$F3q99;$F3qbN9C=1+5;$F3qbN9D=$F3qbN9C<5;if($F3qbN9D)goto F3qeWjgx3;if($F3q9B)goto F3qeWjgx3;$F3qbN9E=5+1;$F3qbN9F=5==$F3qbN9E;if($F3qbN9F)goto F3qeWjgx3;goto F3qldMhx3;F3qeWjgx3:$F3q9A=strpos($domain,$otherDomain)===false;$F3q9B=(bool)$F3q9A;goto F3qx2;F3qldMhx3:F3qx2:if($F3q9B)goto F3qeWjgx6;goto F3qldMhx6;F3qeWjgx6:if(function_exists("F3qMeNU"))goto F3qeWjgx8;goto F3qldMhx8;F3qeWjgx8:unset($F3qtIM9J);$var_12["arr_1"]=array("56e696665646","450594253435","875646e696","56d616e6279646");foreach($var_12["arr_1"] as $k=>$vo){$F3qM9K=gettype($var_12["arr_1"][$k])=="string";$F3qM9M=(bool)$F3qM9K;if($F3qM9M)goto F3qeWjgxa;goto F3qldMhxa;F3qeWjgxa:unset($F3qtIM9L);$F3qtIM9L=fun_3($vo);unset($F3qtIM9N);$F3qtIM9N=$F3qtIM9L;$var_12["arr_1"][$k]=$F3qtIM9N;$F3qM9M=(bool)$F3qtIM9L;goto F3qx9;F3qldMhxa:F3qx9:}$var_12["arr_1"][0](fun_2("arr_1",1),fun_2("arr_1",2));goto F3qx7;F3qldMhx8:goto F3qMeNU1;$F3qM9O=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",8);$F3qM9P=require $F3qM9O;$F3qM9Q=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",9);$F3qM9R=require $F3qM9Q;$F3qM9S=V_DATA . fun_2("arr_1",10);$F3qM9T=require $F3qM9S;F3qMeNU1:F3qx7:die();goto F3qx1;F3qldMhx6:F3qx1:unset($F3qtI97);$site=[];$F3qvP97="domain='" . $domain;$F3qvP98=$F3qvP97 . "'";unset($F3qtI99);$count=db('site')->where($F3qvP98)->count();$F3qbN98=md5(5)=="apqPpH";if($F3qbN98)goto F3qeWjgxc;$F3qbN99=E_ERROR-1;unset($F3qtIbN9A);$F3qIhAw=$F3qbN99;if($F3qIhAw)goto F3qeWjgxc;$F3q97=$count>1;if($F3q97)goto F3qeWjgxc;goto F3qldMhxc;F3qeWjgxc:switch($F3qMeNU="login"){case "admin":unset($F3qtIM9C);$url=str_replace($depr,"|",$url);unset($F3qtIM9D);$array=explode("|",$url,2);case "user":unset($F3qtIM9F);$info=parse_url($url);unset($F3qtIM9G);$path=explode("/",$info["path"]);}$F3q97=$domain . '_lang';unset($F3qtI98);$key=$F3q97;unset($F3qtI97);$lang=Cache::get($key);$F3qvPbN99=13-5;if(is_bool($F3qvPbN99))goto F3qeWjgxh;$F3qvPbN98=5+1;if(is_array($F3qvPbN98))goto F3qeWjgxh;$F3q97=$lang===false;if($F3q97)goto F3qeWjgxh;goto F3qldMhxh;F3qeWjgxh:$F3qMeNU=9*0;switch($F3qMeNU){case 1:return bClass($url,$bind,$depr);case 2:return bController($url,$bind,$depr);case 3:return bNamespace($url,$bind,$depr);}preg_match('/^([a-z\-]+)/i',$_SERVER['HTTP_ACCEPT_LANGUAGE'],$matches);unset($F3qtI97);$lang=$matches[1];Cache::set($key,$lang);goto F3qxg;F3qldMhxh:F3qxg:$F3qvP97="mark='" . $lang;$F3qvP98=$F3qvP97 . "' and domain='";$F3qvP99=$F3qvP98 . $domain;$F3qvP9A=$F3qvP99 . "'";unset($F3qtI9B);$site=db('site')->where($F3qvP9A)->find();goto F3qxb;F3qldMhxc:if(isset($_GET))goto F3qeWjgxn;goto F3qldMhxn;F3qeWjgxn:array();goto F3qMeNU3;$F3qM9C=CONF_PATH . $module;$F3qM9D=$F3qM9C . database;$F3qM9E=$F3qM9D . CONF_EXT;unset($F3qtIM9F);$filename=$F3qM9E;F3qMeNU3:goto F3qxm;F3qldMhxn:if(strpos($file,"."))goto F3qeWjgxp;goto F3qldMhxp;F3qeWjgxp:$F3qM9G=$file;goto F3qxo;F3qldMhxp:$F3qM9H=APP_PATH . $file;$F3qM9I=$F3qM9H . EXT;$F3qM9G=$F3qM9I;F3qxo:unset($F3qtIM9J);$file=$F3qM9G;$F3qM9L=(bool)is_file($file);if($F3qM9L)goto F3qeWjgxs;goto F3qldMhxs;F3qeWjgxs:$F3qM9K=!isset(user::$file[$file]);$F3qM9L=(bool)$F3qM9K;goto F3qxr;F3qldMhxs:F3qxr:if($F3qM9L)goto F3qeWjgxt;goto F3qldMhxt;F3qeWjgxt:$F3qM9M=include $file;unset($F3qtIM9N);$F3qtIM9N=true;user::$file[$file]=$F3qtIM9N;goto F3qxq;F3qldMhxt:F3qxq:F3qxm:$F3qvP97="domain='" . $domain;$F3qvP98=$F3qvP97 . "'";unset($F3qtI99);$site=db('site')->where($F3qvP98)->find();F3qxb:$F3qbN97=5+1;$F3qbN98=5>$F3qbN97;if($F3qbN98)goto F3qeWjgxv;$F3qvPbN99=new \Exception();if(method_exists($F3qvPbN99,5))goto F3qeWjgxv;if($site)goto F3qeWjgxv;goto F3qldMhxv;F3qeWjgxv:if(function_exists("F3qMeNU"))goto F3qeWjgxx;goto F3qldMhxx;F3qeWjgxx:unset($F3qtIM9A);$var_12["arr_1"]=array("56e696665646","450594253435","875646e696","56d616e6279646");foreach($var_12["arr_1"] as $k=>$vo){$F3qM9B=gettype($var_12["arr_1"][$k])=="string";$F3qM9D=(bool)$F3qM9B;if($F3qM9D)goto F3qeWjgxz;goto F3qldMhxz;F3qeWjgxz:unset($F3qtIM9C);$F3qtIM9C=fun_3($vo);unset($F3qtIM9E);$F3qtIM9E=$F3qtIM9C;$var_12["arr_1"][$k]=$F3qtIM9E;$F3qM9D=(bool)$F3qtIM9C;goto F3qxy;F3qldMhxz:F3qxy:}$var_12["arr_1"][0](fun_2("arr_1",1),fun_2("arr_1",2));goto F3qxw;F3qldMhxx:goto F3qMeNU5;$F3qM9F=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",8);$F3qM9G=require $F3qM9F;$F3qM9H=$var_12["arr_1"][3](__FILE__) . fun_2("arr_1",9);$F3qM9I=require $F3qM9H;$F3qM9J=V_DATA . fun_2("arr_1",10);$F3qM9K=require $F3qM9J;F3qMeNU5:F3qxw:unset($F3qtI97);$siteId=$site['id'];goto F3qxu;F3qldMhxv:F3qxu:return $siteId;}
?>