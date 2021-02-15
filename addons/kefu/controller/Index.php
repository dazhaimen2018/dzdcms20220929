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
// | qq客服
// +----------------------------------------------------------------------
namespace addons\kefu\Controller;

use app\addons\util\AddonsBase;

class Index extends AddonsBase
{

    public function index()
    {
        $config = get_addon_config('kefu');
        $qq     = explode("\n", $config['qq']);
        $phone  = explode("\n", $config['phone']);
        $qqList = array();
        foreach ($qq as $r) {
            $r        = explode('|', $r);
            $qqList[] = array(
                'qq'   => $r[0],
                'nick' => $r[1],
            );
        }
        $phoneList = array();
        foreach ($phone as $r) {
            $r           = explode('|', $r);
            $phoneList[] = array(
                'phone' => $r[0],
                'nick'  => $r[1],
            );
        }
        $this->assign('qqList', $qqList);
        $this->assign('phoneList', $phoneList);
        $this->assign('location', $config['location'] ?: 'right');
        $this->assign('theme', $config['theme'] ?: '1');
        $this->assign('qrcode', $config['qrcode'] ?: '');
        echo $this->format_js($this->fetch('kefu'));
    }

    /**
     * 将文本格式成适合js输出的字符串
     * @param string $string 需要处理的字符串
     * @param intval $isjs 是否执行字符串格式化，默认为执行
     * @return string 处理后的字符串
     */
    protected function format_js($str, $isjs = 1)
    {
        preg_match_all("/[\xc2-\xdf][\x80-\xbf]+|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}|[\x01-\x7f]+/e", $str, $r);
        //匹配utf-8字符，
        $str = $r[0];
        $l   = count($str);
        for ($i = 0; $i < $l; $i++) {
            $value = ord($str[$i][0]);
            if ($value < 223) {
                $str[$i] = rawurlencode(utf8_decode($str[$i]));
                //先将utf8编码转换为ISO-8859-1编码的单字节字符，urlencode单字节字符.
                //utf8_decode()的作用相当于iconv("UTF-8","CP1252",$v)。
            } else {
                $str[$i] = "%u" . strtoupper(bin2hex(iconv("UTF-8", "UCS-2", $str[$i])));
            }
        }
        $reString = join("", $str);
        return $isjs ? 'document.write(unescape("' . $reString . '"));' : $reString;
    }

}
