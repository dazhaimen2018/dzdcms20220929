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
namespace app\user\model;

use think\Db;
use think\Model;

/**
 * 会员模型
 */
class UcenterMember extends Model
{
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'reg_time';
    protected $updateTime = 'update_time';

    protected $insert = ['status' => 1, 'reg_ip'];

    protected function setPasswordAttr($value, $data)
    {
        return think_ucenter_md5($value, UC_AUTH_KEY);
    }
    protected function setRegIpAttr($value, $data)
    {
        return get_client_ip(1);
    }

    /**
     * 检测用户名是不是被禁止注册
     * @param  string $username 用户名
     * @return boolean          ture - 未禁用，false - 禁止注册
     */
    protected function checkDenyMember($username)
    {
        return true; //TODO: 暂不限制，下一个版本完善
    }

    /**
     * 检测邮箱是不是被禁止注册
     * @param  string $email 邮箱
     * @return boolean       ture - 未禁用，false - 禁止注册
     */
    protected function checkDenyEmail($email)
    {
        return true; //TODO: 暂不限制，下一个版本完善
    }

    /**
     * 检测手机是不是被禁止注册
     * @param  string $mobile 手机
     * @return boolean        ture - 未禁用，false - 禁止注册
     */
    protected function checkDenyMobile($mobile)
    {
        return true; //TODO: 暂不限制，下一个版本完善
    }

    /**
     * 根据配置指定用户状态
     * @return integer 用户状态
     */
    protected function getStatus()
    {
        return true; //TODO: 暂不限制，下一个版本完善
    }

    /**
     * 注册一个新用户
     * @param  string $username 用户名
     * @param  string $password 用户密码
     * @param  string $email    用户邮箱
     * @param  string $mobile   用户手机号码
     * @param  stting $scene  验证场景  admin 后台 user为用户注册
     * @return integer          注册成功-用户信息，注册失败-错误编号
     */
    public function register($username, $password, $email, $mobile, $scene = '')
    {
        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'mobile' => $mobile,
        );

        //验证手机
        if (empty($data['mobile'])) {
            unset($data['mobile']);
        }

        $validate = \think\Loader::validate('user/UcenterMember');
        if (!$validate->scene($scene)->check($data)) {
            return $validate->getError();
        }

        /* 添加用户 */
        if ($user_data = $this->create($data)) {
            $user_data = $user_data->toArray();
        }

        if ($user_data) {
            $uid = $user_data['id'];
            return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
        } else {
            return $this->getError();
        }
    }

    /**
     * 用户登录认证
     * @param  string  $username 用户名
     * @param  string  $password 用户密码
     * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
     * @return integer           登录成功-用户ID，登录失败-错误编号
     */
    public function login($username, $password, $type = 1)
    {
        $map = array();
        switch ($type) {
            case 1:
                $map['username'] = $username;
                break;
            case 2:
                $map['email'] = $username;
                break;
            case 3:
                $map['mobile'] = $username;
                break;
            case 4:
                $map['id'] = $username;
                break;
            default:
                return 0; //参数错误
        }

        /* 获取用户数据 */
        if ($user = $this->where($map)->find()) {
            $user = $user->toArray();
        }

        if (is_array($user) && $user['status']) {
            /* 验证用户密码 */
            if (think_ucenter_md5($password, UC_AUTH_KEY) === $user['password']) {
                $this->updateLogin($user['id']); //更新用户登录信息
                return $user['id']; //登录成功，返回用户ID
            } else {
                return -2; //密码错误
            }
        } else {
            return -1; //用户不存在或被禁用
        }
    }

    /**
     * 获取用户信息
     * @param  string  $uid         用户ID或用户名
     * @param  boolean $is_username 是否使用用户名查询
     * @return array                用户信息
     */
    public function info($uid, $is_username = false)
    {
        $map = array();
        if ($is_username) {
            //通过用户名获取
            $map['username'] = $uid;
        } else {
            $map['id'] = $uid;
        }

        $user = $this->where($map)->field('id,username,email,mobile,status')->find();
        if (is_object($user)) {
            $user = $user->toArray();
        }

        if (is_array($user) && $user['status'] == 1) {
            return [$user['id'], $user['username'], $user['email'], $user['mobile']];
        } else {
            return -1; //用户不存在或被禁用
        }
    }

    /**
     * 检测用户信息
     * @param  string  $field  用户名
     * @param  integer $type   用户名类型 1-用户名，2-用户邮箱，3-用户电话
     * @return integer         错误编号
     */
    public function checkField($field, $type = 1)
    {
        $data = array();
        switch ($type) {
            case 1:
                $data['username'] = $field;
                break;
            case 2:
                $data['email'] = $field;
                break;
            case 3:
                $data['mobile'] = $field;
                break;
            default:
                return 0; //参数错误
        }

        return $this->create($data) ? 1 : $this->getError();
    }

    /**
     * 更新用户登录信息
     * @param  integer $uid 用户ID
     */
    protected function updateLogin($uid)
    {
        $data = array(
            'id' => $uid,
            'last_login_time' => time(),
            'last_login_ip' => get_client_ip(1),
        );
        $this->where(array('id' => $uid))->update($data);
    }

    /**
     * 更新用户信息
     * @param int $uid 用户id
     * @param type $oldpw 旧密码
     * @param type $newpw 新密码，如不修改为空
     * @param type $email Email，如不修改为空
     * @param type $ignoreoldpw 是否忽略旧密码
     * @param type $data 其他信息
     * @return true 修改成功，false 修改失败
     */
    public function updateUserFields($uid, $oldpw, $newpw = '', $email = '', $ignoreoldpw = 0, $data)
    {

        if (empty($uid)) {
            $this->error = '参数错误！';
            return false;
        }
        //如果有新密码 则更新密码
        if ($newpw) {
            $data['password'] = $newpw;
        }
        //如果有新邮箱 则更新邮箱
        if ($email) {
            $data['email'] = $email;
        }
        if (empty($data)) {
            return true;
        }
        //验证旧密码是否正确
        if ($ignoreoldpw == 0) {
            //更新前检查用户密码
            if (!$this->verifyUser($uid, $oldpw)) {
                $this->error = '验证出错：密码不正确！';
                return false;
            }
        }
        //更新用户信息
        return $this->allowField(true)->isUpdate(true)->save($data, ['id' => $uid]);
    }

    /**
     * 验证用户密码
     * @param int $uid 用户id
     * @param string $password_in 密码
     * @return true 验证成功，false 验证失败
     */
    protected function verifyUser($uid, $password_in)
    {
        $password = $this->getFieldById($uid, 'password');
        if (strlen($password_in) > 20) {
            if ($password_in === $password) {
                return true;
            }
        } else {
            if (think_ucenter_md5($password_in, UC_AUTH_KEY) === $password) {
                return true;
            }
        }

        return false;
    }

}
