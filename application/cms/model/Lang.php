<?php
/**
 * TopAdmin
 * 版权所有 TopAdmin，并保留所有权利。
 * Author: TopAdmin <8355763@qq.com>
 * Date: 2021/11/16
 * 碎片模型
 */
namespace app\cms\model;

use \think\Model;

class Lang extends Model
{
	// 自动写入时间戳
	protected $autoWriteTimestamp = true;
	/**
	 * 获取配置信息
	 * @return mixed
	 */
	public function Lang_cache()
	{
		$data = $this->getLang();
		cache("Lang", $data);
		return $data;
	}
	public function getLang($where = "status='1'", $fields = 'name,value,type,options', $order = 'listorder,id desc')
	{
		$configs = self::where($where)->order($order)->column($fields);
		$newConfigs = [];
		foreach ($configs as $key => $value) {
			if ($value['options'] != '') {
				$value['options'] = parse_attr($value['options']);
			}
			switch ($value['type']) {
				case 'array':
					$newConfigs[$key] = parse_attr($value['value']);
					break;
				case 'select':
				case 'radio':
					$newConfigs[$key] = isset($value['options'][$value['value']]) ? ['key' => $value['value'], 'value' => $value['options'][$value['value']]] : ['key' => $value['value'], 'value' => $value['value']];
					break;
				case 'checkbox':
					if (empty($value['value'])) {
						$newConfigs[$key] = [];
					} else {
						$valueArr = explode(',', $value['value']);
						foreach ($valueArr as $v) {
							if (isset($value['options'][$v])) {
								$newConfigs[$key][$v] = $value['options'][$v];
							} elseif ($v) {
								$newConfigs[$key][$v] = $v;
							}
						}
					}
					break;
				case 'file':
				case 'image':
					$newConfigs[$key] = empty($value['value']) ? '' : get_file_path($value['value']);
					break;
				case 'files':
				case 'images':
					$newConfigs[$key] = empty($value['value']) ? [] : get_file_path($value['value']);
					if (!is_array($newConfigs[$key])) {
						$newConfigs[$key] = array($newConfigs[$key]);
					}
					break;
				case 'Ueditor':
					$newConfigs[$key] = htmlspecialchars_decode($value['value']);
					break;
				default:
					$newConfigs[$key] = $value['value'];
					break;
			}
		}
		return $newConfigs;
	}
}
