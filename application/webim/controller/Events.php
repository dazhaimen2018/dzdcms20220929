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
// | Worker 命令行服务类
// +----------------------------------------------------------------------
namespace app\webim\controller;

use app\webim\library\Chat;
use \GatewayWorker\Lib\Gateway;

class Events
{
    public static $global = null;

    /**
     * 进程启动后初始化数据库连接
     */
    public static function onWorkerStart($worker)
    {
        if (empty(self::$global)) {
            self::$global = new \GlobalData\Client('127.0.0.1:2307');
        }
        // 客服列表
        if (is_null(self::$global->kfList)) {
            self::$global->kfList = [];
        }
        // 会员列表[动态的，这里面只是目前未被分配的会员信息]
        if (is_null(self::$global->userList)) {
            self::$global->userList = [];
        }
        // 会员以 uid 为key的信息简表,只有在用户退出的时候，才去执行修改
        if (is_null(self::$global->uidSimpleList)) {
            self::$global->uidSimpleList = [];
        }
    }

    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
    }

    /**
     * 当客户端连接上gateway完成websocket握手时触发的回调函数。
     *
     * @param int $client_id 连接id
     * @param mixed $data 包含get、server等变量
     */
    public static function onWebSocketConnect($client_id, $data)
    {
        Chat::checkConnect($client_id, $data);
    }

    /**
     * onMessage 事件回调
     * 当客户端发来数据(Gateway进程收到数据)后触发
     *
     * @access public
     * @param  int       $client_id
     * @param  mixed     $data
     * @return void
     */
    public static function onMessage($client_id, $data)
    {
        $message = json_decode($data, true);
        $session = Gateway::getSession($client_id);
        switch ($message['type']) {
            // 客服初始化
            case 'init':
                if ($session['type'] == 'visitors') {
                    Gateway::sendToClient($client_id, json_encode(['message_type' => 'clear']));
                }
                $kfList = self::$global->kfList;
                // 如果该客服未在内存中记录则记录
                if (!isset($kfList[$message['group']]) || !array_key_exists($message['uid'], $kfList[$message['group']])) {

                    do {
                        $newKfList                                     = $kfList;
                        $newKfList[$message['group']][$message['uid']] = [
                            'id'        => $message['uid'],
                            'name'      => $message['name'],
                            'avatar'    => $message['avatar'],
                            'client_id' => $client_id,
                            'task'      => 0,
                            'user_info' => [],
                        ];
                    } while (!self::$global->cas('kfList', $kfList, $newKfList));
                    unset($newKfList, $kfList);
                } else if (isset($kfList[$message['group']][$message['uid']])) {

                    do {
                        $newKfList                                                  = $kfList;
                        $newKfList[$message['group']][$message['uid']]['client_id'] = $client_id;
                    } while (!self::$global->cas('kfList', $kfList, $newKfList));
                    unset($newKfList, $kfList);
                }
                $uid = 'admin-' . $message['uid'];
                // 绑定 client_id 和 uid
                Gateway::bindUid($client_id, $uid);
                // 客服上线通知在线用户
                $msg = [
                    'message_type' => 'kf_online',
                    'data'         => [
                        'kf_name'   => $message['name'],
                        'kf_avatar' => $message['avatar'],
                        'kf_id'     => $message['uid'],
                        'kf_group'  => $message['group'],
                        'time'      => date('Y-m-d H:i:s'),
                    ],
                ];
                Gateway::sendToAll(json_encode($msg));
                break;
            // 顾客初始化
            case 'userInit';
                $userList = self::$global->userList;
                // 如果该顾客未在内存中记录则记录
                if (!array_key_exists($message['uid'], $userList)) {
                    do {
                        $NewUserList                  = $userList;
                        $NewUserList[$message['uid']] = [
                            'id'        => $message['uid'],
                            'name'      => $message['name'],
                            'avatar'    => $message['avatar'],
                            'ip'        => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
                            'group'     => $message['group'],
                            'client_id' => $client_id,
                        ];

                    } while (!self::$global->cas('userList', $userList, $NewUserList));
                    unset($NewUserList, $userList);

                    // 维护 UID对应的client_id 数组
                    do {
                        $old                      = $newList                      = self::$global->uidSimpleList;
                        $newList[$message['uid']] = [
                            $client_id,
                            $message['group'],
                        ];

                    } while (!self::$global->cas('uidSimpleList', $old, $newList));
                    unset($old, $newList);
                }
                $message['uid'] = 'home-' . $message['uid'];
                // 绑定 client_id 和 uid
                Gateway::bindUid($client_id, $message['uid']);
                // 尝试分配新会员进入服务
                self::userOnlineTask($client_id, $message['group']);
                break;
            // 聊天
            case 'chatMessage':
                if ($session['type'] == 'admin') {
                    $to_id = 'home-' . $message['data']['to_id'];
                } elseif ($session['type'] == 'visitors') {
                    $to_id = 'admin-' . $message['data']['to_id'];
                }
                $chat_message = [
                    'message_type' => 'chatMessage',
                    'data'         => [
                        'name'    => $message['data']['from_name'],
                        'avatar'  => $message['data']['from_avatar'],
                        'id'      => $message['data']['from_id'],
                        'time'    => date('Y-m-d H:i:s'),
                        'content' => htmlspecialchars($message['data']['content']),
                    ],
                ];
                Gateway::sendToUid($to_id, json_encode($chat_message));
                unset($chat_message);
                break;
            // 转接
            case 'changeGroup':
                break;
            case 'closeUser':
                break;
            case 'ping':
                break;
        }
    }

    /**
     * 有人退出
     * @param $group
     */
    private static function userOfflineTask($group)
    {
        // TODO 此处查询最大的可服务人数，后面可以用其他的方式，存储这个数值，让其更高效的访问
        $maxNumber = self::getMaxServiceNum();
        $res       = self::assignmentTask(self::$global->kfList, self::$global->userList, $group, $maxNumber);
        unset($maxNumber);
        if (1 == $res['code']) {
            while (!self::$global->cas('kfList', self::$global->kfList, $res['data']['4'])) {
            }; // 更新客服数据
            while (!self::$global->cas('userList', self::$global->userList, $res['data']['5'])) {
            }; // 更新会员数据
            // 通知会员发送信息绑定客服的id
            $noticeUser = [
                'message_type' => 'connect',
                'data'         => [
                    'kf_id'   => $res['data']['0'],
                    'kf_name' => $res['data']['1'],
                ],
            ];
            Gateway::sendToClient($res['data']['3']['client_id'], json_encode($noticeUser));
            unset($noticeUser);
            // 通知客服端绑定会员的信息
            $noticeKf = [
                'message_type' => 'connect',
                'data'         => [
                    'user_info' => $res['data']['3'],
                ],
            ];
            Gateway::sendToClient($res['data']['2'], json_encode($noticeKf));
            unset($noticeKf);
            // 逐一通知
            $number = 1;
            foreach (self::$global->userList as $vo) {
                $waitMsg     = '您前面还有 ' . $number . ' 位会员在等待。';
                $waitMessage = [
                    'message_type' => 'wait',
                    'data'         => [
                        'content' => $waitMsg,
                    ],
                ];
                Gateway::sendToClient($vo['client_id'], json_encode($waitMessage));
                $number++;
            }
            unset($waitMessage, $number);
        } else {
            switch ($res['code']) {
                case -1:
                    $waitMsg = '暂时没有客服上班,请稍后再咨询。';
                    // 逐一通知
                    foreach (self::$global->userList as $vo) {
                        $waitMessage = [
                            'message_type' => 'wait',
                            'data'         => [
                                'content' => $waitMsg,
                            ],
                        ];
                        Gateway::sendToClient($vo['client_id'], json_encode($waitMessage));
                    }
                    break;
                case -2:
                    break;
                case -3:
                    break;
                case -4:
                    // 逐一通知
                    $number = 1;
                    foreach (self::$global->userList as $vo) {
                        $waitMsg     = '您前面还有 ' . $number . ' 位会员在等待。';
                        $waitMessage = [
                            'message_type' => 'wait',
                            'data'         => [
                                'content' => $waitMsg,
                            ],
                        ];
                        Gateway::sendToClient($vo['client_id'], json_encode($waitMessage));
                        $number++;
                    }
                    break;
            }
            unset($waitMessage, $number);
        }
    }

    /**
     * 有人进入执行分配
     * @param $client_id
     * @param $group
     */
    private static function userOnlineTask($client_id, $group)
    {
        // TODO 此处查询最大的可服务人数，后面可以用其他的方式，存储这个数值，让其更高效的访问
        $maxNumber = self::getMaxServiceNum();

        $res = self::assignmentTask(self::$global->kfList, self::$global->userList, $group, $maxNumber);
        unset($maxNumber);

        if (1 == $res['code']) {
            while (!self::$global->cas('kfList', self::$global->kfList, $res['data']['4'])) {
            }; // 更新客服数据
            while (!self::$global->cas('userList', self::$global->userList, $res['data']['5'])) {
            }; // 更新会员数据

            // 通知会员发送信息绑定客服的id
            $noticeUser = [
                'message_type' => 'connect',
                'data'         => [
                    'kf_id'   => $res['data']['0'],
                    'kf_name' => $res['data']['1'],
                ],
            ];
            Gateway::sendToClient($client_id, json_encode($noticeUser));
            unset($noticeUser);

            // 检测是否开启自动应答
            //$sayHello = self::$db->query('select `word`,`status` from `ws_reply` where `id` = 1');
            $sayHello = "";
            if (!empty($sayHello) && 1 == $sayHello['0']['status']) {

                $hello = [
                    'message_type' => 'helloMessage',
                    'data'         => [
                        'name'    => $res['data']['1'],
                        'avatar'  => '',
                        'id'      => $res['data']['0'],
                        'time'    => date('Y-m-d H:i:s'),
                        'content' => htmlspecialchars($sayHello['0']['word']),
                    ],
                ];
                Gateway::sendToClient($client_id, json_encode($hello));
                unset($hello);
            }
            unset($sayHello);

            // 通知客服端绑定会员的信息
            $noticeKf = [
                'message_type' => 'connect',
                'data'         => [
                    'user_info' => $res['data']['3'],
                ],
            ];
            Gateway::sendToClient($res['data']['2'], json_encode($noticeKf));
            unset($noticeKf);
            // 写入接入值
            $key                = date('Ymd') . 'success_in';
            self::$global->$key = 0;
            do {
                $oldKey = date('Ymd', strtotime('-1 day')); // 删除前一天的统计值
                unset(self::$global->$oldKey);
            } while (!self::$global->increment($key));
            unset($key);
        } else {

            $waitMsg = '';
            switch ($res['code']) {

                case -1:
                    $waitMsg = '暂时没有客服上班,请稍后再咨询。';
                    break;
                case -2:
                    break;
                case -3:
                    break;
                case -4:
                    $number  = count(self::$global->userList);
                    $waitMsg = '您前面还有 ' . $number . ' 位会员在等待。';
                    break;
            }

            $waitMessage = [
                'message_type' => 'wait',
                'data'         => [
                    'content' => $waitMsg,
                ],
            ];

            Gateway::sendToClient($client_id, json_encode($waitMessage));
            unset($waitMessage);
        }
    }

    /**
     * 给客服分配会员【均分策略】
     * @param $kfList
     * @param $userList
     * @param $group
     * @param $total
     */
    private static function assignmentTask($kfList, $userList, $group, $total)
    {
        // 没有客服上线
        if (empty($kfList) || empty($kfList[$group])) {
            return ['code' => -1];
        }

        // 没有待分配的会员
        if (empty($userList)) {
            return ['code' => -2];
        }

        // 未设置每个客服可以服务多少人
        if (0 == $total) {
            return ['code' => -3];
        }

        // 查看该组的客服是否在线
        if (!isset($kfList[$group])) {
            return ['code' => -1];
        }

        $kf   = $kfList[$group];
        $user = array_shift($userList);

        $kf   = array_shift($kf);
        $min  = $kf['task'];
        $flag = $kf['id'];

        foreach ($kfList[$group] as $key => $vo) {
            if ($vo['task'] < $min) {
                $min  = $vo['task'];
                $flag = $key;
            }
        }
        unset($kf);

        // 需要排队了
        if ($kfList[$group][$flag]['task'] == $total) {
            return ['code' => -4];
        }

        $kfList[$group][$flag]['task'] += 1;
        array_push($kfList[$group][$flag]['user_info'], $user['client_id']); // 被分配的用户信息

        return [
            'code' => 1,
            'data' => [
                $kfList[$group][$flag]['id'],
                $kfList[$group][$flag]['name'],
                $kfList[$group][$flag]['client_id'],
                $user,
                $kfList,
                $userList,
            ],
        ];
    }

    /**
     * 获取最大的服务人数
     * @return int
     */
    private static function getMaxServiceNum()
    {
        //$maxNumber = self::$db->query('select `max_service` from `ws_config` where `id` = 1');
        $maxNumber = '';
        if (empty($maxNumber)) {
            $maxNumber = 5;
        } else {
            $maxNumber = $maxNumber['0']['max_service'];
        }

        return $maxNumber;
    }

    /**
     * 将内存中的数据写入统计表
     * @param int $flag
     */
    private static function writeLog($flag = 1)
    {
        // 上午 8点 到 22 点开始统计
        if (date('H') < 8 || date('H') > 22) {
            return;
        }
        // 当前正在接入的人 和 在线客服数
        $kfList = self::$global->kfList;

        $nowTalking = 0;
        $onlineKf   = 0;
        if (!empty($kfList)) {

            foreach ($kfList as $key => $vo) {

                $onlineKf += count($vo);
                foreach ($vo as $k => $v) {
                    $nowTalking += count($v['user_info']);
                }
            }
        }
        unset($kfList, $nowTalking, $inQueue, $onlineKf, $key, $key2, $param);
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     *
     * tips: 当服务端主动退出的时候，会出现 exit status 9.原因是：服务端主动断开之后，连接的客户端会走这个方法，而短时间内进程
     * 需要处理这多的逻辑，又有cas操作，导致进程退出会超时，然后会被内核杀死，从而报出错误 9.实际对真正的业务没有任何的影响。
     */
    public static function onClose($client_id)
    {
        $isServiceUserOut = false;
        // 将会员服务信息，从客服的服务列表中移除
        $old = $kfList = self::$global->kfList;
        foreach ($kfList as $k => $v) {
            foreach ($v as $key => $vo) {
                if (in_array($client_id, $vo['user_info'])) {
                    $isServiceUserOut = true;
                    // 根据client id 去更新这个会员离线的一些信息
                    //self::$db->query("update `ws_service_log` set `end_time` = " . time() . " where `client_id`= '" . $client_id . "'");
                    // 从会员的内存表中检索出该会员的信息，并更新内存
                    $oldSimple = $simpleList = self::$global->uidSimpleList;
                    $outUser   = [];
                    foreach ($simpleList as $u => $c) {
                        if ($c['0'] == $client_id) {
                            $outUser[] = [
                                'user_id'  => $u,
                                'group_id' => $c['1'],
                            ];
                            unset($simpleList[$u]);
                            break;
                        }
                    }
                    while (!self::$global->cas('uidSimpleList', $oldSimple, $simpleList)) {
                    };
                    unset($oldSimple, $simpleList);
                    //$outUser = self::$db->query("select `user_id`,`group_id` from `ws_service_log` where `client_id`= '" . $client_id . "'");
                    // 通知 客服删除退出的用户
                    if (!empty($outUser)) {
                        $del_message = [
                            'message_type' => 'delUser',
                            'data'         => [
                                'id' => $outUser['0']['user_id'],
                            ],
                        ];
                        Gateway::sendToClient($vo['client_id'], json_encode($del_message));
                        unset($del_message);

                        // 尝试分配新会员进入服务
                        self::userOfflineTask($outUser['0']['group_id']);
                    }
                    unset($outUser);
                    // 维护现在的该客服的服务信息
                    $kfList[$k][$key]['task'] -= 1; // 当前服务的人数 -1
                    foreach ($vo['user_info'] as $m => $l) {
                        if ($client_id == $l) {
                            unset($kfList[$k][$key]['user_info'][$m]);
                            break;
                        }
                    }
                    // 刷新内存中客服的服务列表
                    while (!self::$global->cas('kfList', $old, $kfList)) {
                    };
                    unset($old, $kfList);
                    break;
                }
            }
            if ($isServiceUserOut) {
                break;
            }
        }

        // 尝试从排队的用户中删除退出的客户端
        if (false == $isServiceUserOut) {
            $old = $userList = self::$global->userList;
            foreach (self::$global->userList as $key => $vo) {
                if ($client_id == $vo['client_id']) {

                    $isServiceUserOut = true;

                    unset($userList[$key]);
                    break;
                }
            }
            while (!self::$global->cas('userList', $old, $userList)) {
            };

            // 从会员的内存表中检索出该会员的信息，并更新内存
            $oldSimple = $simpleList = self::$global->uidSimpleList;
            foreach ($simpleList as $u => $c) {
                if ($c['0'] == $client_id) {
                    unset($simpleList[$u]);
                    break;
                }
            }
            while (!self::$global->cas('uidSimpleList', $oldSimple, $simpleList)) {
            };
            unset($oldSimple, $simpleList);
        }

        // 尝试是否是非管理员退出
        if (false == $isServiceUserOut) {
            $type = [
                'message_type' => 'kf_offline',
            ];
            $old = $kfList = self::$global->kfList;
            foreach (self::$global->kfList as $k => $v) {
                $type['data']['kf_group'] = $k;
                foreach ($v as $key => $vo) {
                    $type['data']['kf_id']   = $vo['id'];
                    $type['data']['kf_name'] = $vo['name'];
                    foreach ($vo['user_info'] as $userId) {
                        Gateway::sendToClient($userId, json_encode($type));
                    }
                    // 客服服务列表中无数据，才去删除客服内存信息
                    // && (0 == count($vo['user_info']))
                    if ($client_id == $vo['client_id']) {
                        unset($kfList[$k][$key]);
                        break;
                    }
                }
            }

            while (!self::$global->cas('kfList', $old, $kfList)) {
            };
        }
    }

}
