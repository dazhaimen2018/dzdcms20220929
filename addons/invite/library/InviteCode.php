<?php

namespace addons\invite\library;

class InviteCode
{
    const sourceStrings = 'E5FCDG3HQA4B1NOPIJ2RSTUV67MWX89KLYZ';

    /**
     * @param $id
     *
     * @return string
     */
    public static function encryptCode($id)
    {
        $num  = $id;
        $code = '';
        while ($num > 0) {
            $mod  = $num % 35;
            $num  = ($num - $mod) / 35;
            $code = self::sourceStrings[$mod] . $code;
        }
        if (empty($code[3])) {
            $code = str_pad($code, 4, '0', STR_PAD_LEFT);
        }

        return $code;
    }

    /**
     * @param $code
     *
     * @return float|int
     */
    public static function decryptCode($code)
    {
        if (strrpos($code, '0') !== false) {
            $code = substr($code, strrpos($code, '0') + 1);
        }
        $len  = strlen($code);
        $code = strrev($code);
        $num  = 0;
        for ($i = 0; $i < $len; ++$i) {
            $num += strpos(self::sourceStrings, $code[$i]) * pow(35, $i);
        }

        return $num;
    }
}
