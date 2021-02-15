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
// | 表情模型
// +----------------------------------------------------------------------
namespace app\comments\model;

use think\Model;

class Emotion extends Model
{
    protected $name = 'comments_emotion';

    //表情缓存，用于表情调用的
    public function cacheReplaceExpression($emotionPath = '', $classStyle = '')
    {
        //加载表情缓存
        $emotion = cache('Emotion');
        //表情存放路径
        if (empty($emotionPath)) {
            $emotionPath = config('public_url') . 'static/modules/comments/images/emotion/';
        }
        //需要替换的标签
        $replace = array();
        foreach ($emotion as $lab => $info) {
            if ($lab) {
                $replace[$lab] = '<img src="' . $emotionPath . $info['icon'] . '" alt="' . $lab . '" title="' . $lab . '" ' . $classStyle . ' />';
            }
        }
        //进行缓存
        \think\facade\cache::set('cacheReplaceExpression', $replace, 3600);
        return $replace;
    }

    /**
     * 更新缓存
     * @return type 成功返回true;
     */
    public function emotion_cache()
    {
        $data      = $this->where('status', 1)->select()->toArray();
        $cacheList = array();
        foreach ($data as $r) {
            $cacheList['[' . $r['name'] . ']'] = $r;
        }
        cache('Emotion', $cacheList);
        return $cacheList;
    }
}
