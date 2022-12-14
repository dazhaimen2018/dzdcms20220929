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
// | 标签库
// +----------------------------------------------------------------------
namespace app\links\taglib;

use think\Db;

class LinksTagLib
{
    /**
     * 友情连接标签
     */
    public function lists($data)
    {
        $where = isset($data['where']) ? $data['where'] : "status=1";
        $order = isset($data['order']) ? $data['order'] : 'listorder,id desc';
        $num   = isset($data['num']) ? (int) $data['num'] : 10;
        if (isset($data['linktype'])) {
            $where .= empty($where) ? "linktype = " . (int) $data['linktype'] : " AND linktype = " . (int) $data['linktype'];
        }
        if (isset($data['typeid'])) {
            $where .= empty($where) ? "termsid = " . (int) $data['typeid'] : " AND termsid = " . (int) $data['typeid'];
        }
        if (isset($data['siteId'])) {
            $site = [];
            foreach (explode(',', $data['siteId']) as $k => $v) {
                $site[] = "FIND_IN_SET('" . $v . "', sites)";
            }
            if ($site) {
                $where .= " AND (" . implode(' OR ', $site) . ")";
            }
        }
        $result = Db::name('Links')->where($where)->limit($num)->order($order)->select();
        return $result;
    }

}
