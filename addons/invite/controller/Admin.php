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
// | 会员推广管理
// +----------------------------------------------------------------------
namespace addons\invite\Controller;

use addons\invite\model\InviteCode as InviteCodeModel;
use app\addons\util\Adminaddon;
use util\Random;

class Admin extends Adminaddon
{

    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new InviteCodeModel;
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $rule = [
                'prefix|前缀'         => 'alphaDash',
                'max|使用次数'          => 'require|number|>=:1',
                'expired_time|失效时间' => 'require|date',
                'num|生成数量'          => 'require|number|>=:1',

            ];
            $result = $this->validate($data, $rule);
            if (true !== $result) {
                $this->error($result);
            }
            try {
                for ($i = 1; $i <= $data['num']; $i++) {
                    $data['code'] = $data['prefix'] . date('yd') . Random::alnum(12, '~@#$%^&*(){}[]|') . date('s');
                    $this->modelClass->isUpdate(false)->allowField(['code', 'max', 'expired_time', 'status'])->save($data);
                }
            } catch (\Exception $ex) {
                $this->error($ex->getMessage());
            }
            $this->success("邀请码生成成功！");
        } else {
            return $this->fetch();
        }
    }
}
