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
// | 会员邀请插件
// +----------------------------------------------------------------------
namespace addons\invite;

use addons\invite\library\InviteCode;
use addons\invite\model\Invite as InviteModel;
use app\member\model\Member as Member_Model;
use sys\Addons;
use think\Db;
use think\facade\Cookie;
use util\File;

class Invite extends Addons
{
    //安装
    public function install()
    {
        $prefix = config("database.prefix");
        Db::execute("DROP TABLE IF EXISTS {$prefix}invite;");
        Db::execute("
            CREATE TABLE IF NOT EXISTS `{$prefix}invite` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `uid` int(11) unsigned NOT NULL COMMENT '会员ID',
            `touid` int(11) unsigned NOT NULL COMMENT '被邀请者会员ID',
            `ip` char(15) NOT NULL DEFAULT '' COMMENT '注册IP',
            `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
            PRIMARY KEY (`id`),
            KEY `uid` (`uid`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ");

        Db::execute("DROP TABLE IF EXISTS {$prefix}invite_code;");
        Db::execute("
            CREATE TABLE IF NOT EXISTS `{$prefix}invite_code` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `code` varchar(40) NOT NULL COMMENT '邀请码',
            `max` smallint(5) unsigned NOT NULL COMMENT '最多使用次数',
            `users` varchar(20),
            `expired_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
            `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
            PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ");

        //前台模板
        $installdir = ADDON_PATH . "invite" . DIRECTORY_SEPARATOR . "install" . DIRECTORY_SEPARATOR;
        if (is_dir($installdir . "template" . DIRECTORY_SEPARATOR)) {
            //拷贝模板到前台模板目录中去
            File::copy_dir($installdir . "template" . DIRECTORY_SEPARATOR, TEMPLATE_PATH . 'default' . DIRECTORY_SEPARATOR . 'addons' . DIRECTORY_SEPARATOR);
        }
        return true;
    }

    //卸载
    public function uninstall()
    {
        $prefix = config("database.prefix");
        Db::execute("DROP TABLE IF EXISTS {$prefix}invite;");
        Db::execute("DROP TABLE IF EXISTS {$prefix}invite_code;");
        if (is_dir(TEMPLATE_PATH . 'default' . DIRECTORY_SEPARATOR . 'addons' . DIRECTORY_SEPARATOR . 'invite' . DIRECTORY_SEPARATOR)) {
            File::del_dir(TEMPLATE_PATH . 'default' . DIRECTORY_SEPARATOR . 'addons' . DIRECTORY_SEPARATOR . 'invite' . DIRECTORY_SEPARATOR);
        }
        return true;
    }

    //会员中心边栏
    public function userSidenavAfter()
    {
        return $this->fetch('user_sidenav_after');
    }

    //表单
    public function registerInput()
    {
        $config = get_addon_config('invite');
        if ($config['invitercode']) {
            return $this->fetch('register_input');
        }
    }

    use \traits\controller\Jump;
    public function userRegisterInit($data)
    {
        $config = get_addon_config('invite');
        if ($config['invitercode']) {
            if (isset($data['code']) && empty($data['code'])) {
                $this->error('邀请码不得为空！', null, ['token' => request()->token()]);
            }
            $info = Db::name('invite_code')->where('code', $data['code'])->find();
            if ($info) {
                if ($info['expired_time'] == 0 || $info['expired_time'] >= time()) {
                    if ($info['max'] > 1) {
                        Db::name('invite_code')->where('code', $data['code'])->setDec('max');
                        return true;
                    } else {
                        Db::name('invite_code')->where('code', $data['code'])->delete();
                    }
                } else {
                    $this->error('邀请码已经过期！', null, ['token' => request()->token()]);
                }
            }
            $this->error('邀请码不正确！', null, ['token' => request()->token()]);
        }
    }

    // 会员注册成功
    public function userRegisterSuccessed($auth)
    {
        $userCode = Cookie::get("userCode");
        $ispayok  = isModuleInstall('pay');
        if ($userCode) {
            $userCode = (int) InviteCode::decryptCode($userCode);
            $ip       = Request()->ip(0, false);
            $config   = get_addon_config('invite');
            $user     = Member_Model::get($userCode);

            if (!$user || $user->last_login_ip == $auth->reg_ip) {
                return;
            }

            if ($config['filtermode']) {
                $ipRegistered = InviteModel::where('uid', $user->id)->where('ip', $ip)->find();
                if ($ipRegistered) {
                    return;
                }
            }
            InviteModel::create(['uid' => $user->id, 'ip' => $ip, 'touid' => $auth->id]);

            if ($config['inviteescore']) {
                if ($ispayok) {
                    $account = new \app\pay\model\Account;
                    $account->_add(1, $config['inviteescore'], 'selfincome', $auth->id, $auth->username, '受邀注册赠送');

                } else {
                    Db::name('member')->where('id', $auth->id)->setInc('point', $config['inviteescore']);
                }
            }

            if ($config['dailymaxinvite']) {
                $inviteCount = InviteModel::where('uid', $user->id)->whereTime('createtime', 'today')->count();
                if ($inviteCount > $config['dailymaxinvite']) {
                    return;
                }
            }
            if ($ispayok) {
                $account = new \app\pay\model\Account;
                $account->_add(1, $config['inviteescore'], 'selfincome', $user->id, $user->username, '邀请好友注册');
            } else {
                Db::name('member')->where('id', $user->id)->setInc('point', $config['inviterscore']);
            }
        }
        Cookie::delete("inviter");
    }

    // 会员删除成功
    public function userDeleteSuccessed($auth)
    {
        InviteModel::destroy(function ($query) use ($auth) {
            $query->where('uid', $auth['id'])->whereOr('touid', $auth['id']);
        });
    }
}
