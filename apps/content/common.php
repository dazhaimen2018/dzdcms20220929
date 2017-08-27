<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2007 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------
// 内容管理函数
define('CODETABLEDIR', APP_PATH . 'Content/Data/');

/**
 * 获取扩展模型对象
 * @param  integer $model_id 模型编号
 * @param string   默认公共模型 base基础模型 Independent独立模型公共模型 Document 继承模型公共模型
 * @return object         模型对象
 */
function logic($model_id,$Base='Base'){
    $modelCache = cache("Model");
    if (empty($modelCache[$model_id])) {
        return false;
    }
    $tableName = $modelCache[$model_id]['tablename'];
    $class = 'app\common\logic\\'.$Base;
    return new $class(['table_name'=>$tableName]);
}

/**
 * gbk转拼音
 */
function gbk_to_pinyin($txt) {
	$l = strlen($txt);
	$i = 0;
	$pyarr = array();
	$py = array();
	$filename = CODETABLEDIR.'gb-pinyin.table';
	$fp = fopen($filename,'r');
	while(!feof($fp)) {
		$p = explode("-",fgets($fp,32));
		$pyarr[intval($p[1])] = trim($p[0]);
	}
	fclose($fp);
	ksort($pyarr);
	while($i<$l) {
		$tmp = ord($txt[$i]);
		if($tmp>=128) {
			$asc = abs($tmp*256+ord($txt[$i+1])-65536);
			$i = $i+1;
		} else $asc = $tmp;
		$py[] = asc_to_pinyin($asc,$pyarr);
		$i++;
	}
	return $py;
}

/**
 * Ascii转拼音
 * @param $asc
 * @param $pyarr
 */
function asc_to_pinyin($asc,&$pyarr) {
	if($asc < 128)return chr($asc);
	elseif(isset($pyarr[$asc]))return $pyarr[$asc];
	else {
		foreach($pyarr as $id => $p) {
			if($id >= $asc)return $p;
		}
	}
}