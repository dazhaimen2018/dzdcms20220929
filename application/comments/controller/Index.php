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
// | 评论管理
// +----------------------------------------------------------------------
namespace app\comments\controller;

use app\comments\model\Comments as Comments_Model;
use app\common\controller\Homebase;

class Index extends HomeBase
{
    public $setting;
    public $modelClass;
    public $userinfo = [];
    public $userid   = 0;

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    protected $arr = array();

    //初始化
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new Comments_Model;
        $this->setting    = cache('Comments_config');
        //检测会员模块
        if (isModuleInstall('member')) {
            $this->userid = \app\member\service\User::instance()->isLogin();
            if ($this->userid) {
                $this->userinfo = \app\member\service\User::instance()->getInfo();
            }
        }
        $this->userinfo['id']       = (isset($this->userinfo['id']) && $this->userinfo['id']) ? $this->userinfo['id'] : 0;
        $this->userinfo['username'] = (isset($this->userinfo['username']) && $this->userinfo['username']) ? $this->userinfo['username'] : '';
        $this->userinfo['email']    = (isset($this->userinfo['email']) && $this->userinfo['email']) ? $this->userinfo['email'] : '';
        $this->userinfo['avatar']   = (isset($this->userinfo['avatar']) && $this->userinfo['avatar']) ? $this->userinfo['avatar'] : '';

    }

    //显示信息评论,json格式
    public function json()
    {
        //信息ID
        $id = $this->request->param('id/d', 0);
        //栏目ID
        $catid = $this->request->param('catid/d', 0);
        //评论标识id
        $comment_id = "c-$catid-$id";
        if (!$id || !$catid) {
            $this->error('参数错误！');
        }

        //每页显示评论信息量
        $pageSize = $this->request->param('size/d', 20);
        //当前分页号
        $page = $this->request->param('page/d', 1);

        //评论主表数据
        $commentCount = $this->modelClass->where(['comment_id' => $comment_id, 'approved' => 1])->order($this->setting['order'])->count();
        $commentData  = $this->modelClass->where(['comment_id' => $comment_id, 'approved' => 1, 'parent' => 0])->order($this->setting['order'])->page($page, 10)->select()->toArray();
        foreach ($commentData as $r) {
            $this->getParentComment($r['id']);
            //替换表情
            $this->modelClass->replaceExpression($r['content']);
            $this->arr[] = $r;
        }

        //取得树状结构数组
        $treeArray = $this->get_tree_array();

        //最终返回数组
        $return = array(
            //配置
            'config'   => array(
                'token'     => $this->request->token(),
                'guest'     => $this->setting['guest'],
                'code'      => $this->setting['code'],
                'strlength' => $this->setting['strlength'],
                'expire'    => $this->setting['expire'],
                //'noallow' => (int) $this->setting['status'] ? $this->modelClass->noAllowComments($catid, $id) : false,
                'noallow'   => true,
            ),
            //当前登陆会员信息
            'users'    => array(
                'user_id' => $this->userinfo['id'],
                'name'    => $this->userinfo['username'],
                'email'   => $this->userinfo['email'],
                'avatar'  => $this->userinfo['avatar'],
            ),
            //评论列表 去除键名，不然json输出会影响排序
            'response' => $treeArray ? array_values($treeArray) : '',
            //分页相关
            'cursor'   => array(
                'pagetotal' => ceil($commentCount / $pageSize), //总页数
                'total'     => $commentCount, //总信息数
                'size'      => $pageSize, //每页显示多少
                'page'      => $page, //当前分页号
            ),
        );

        $this->ajaxReturn([
            'data'   => $return,
            'info'   => '',
            'status' => true,
        ], 'JSONP');
    }

    //添加评论
    public function add()
    {
        if ($this->request->isPost()) {
            //栏目id
            $catid = $this->request->param('comment_catid/d', 0);
            //信息id
            $id = $this->request->param('comment_id/d', 0);
            //回复评论id
            $parent = $this->request->param('parent/d', 0);
            if (!$catid || !$id) {
                $this->error("请指定需要评论的信息id！");
            }
            //评论功能是否开启
            if ((int) $this->setting['status'] !== 1) {
                $this->error("评论功能已经关闭！");
            }
            /*if (false === $this->modelClass->noAllowComments($catid, $id)) {
            $this->error("该信息不允许评论！");
            }*/
            //转换html为实体
            $post               = $this->request->post();
            $strlength          = $this->setting['strlength'] >= 3 ? $this->setting['strlength'] : 400;
            $post['comment_id'] = "c-{$catid}-{$id}";
            //如果是登陆状态，强制使用会员帐号和会员邮箱
            if ($this->userid) {
                $post['user_id']      = $this->userinfo['id'];
                $post['author']       = $this->userinfo['username'];
                $post['author_email'] = $this->userinfo['email'];
            }
            //检查评论间隔时间
            $co = cookie($post['comment_id']);
            if ($co && (int) $this->setting['expire']) {
                $this->error("评论发布间隔为" . $this->setting['expire'] . "秒！");
            }
            //判断游客是否有发表权限
            if ((int) $this->setting['guest'] < 1) {
                if (!isset($this->userid) && empty($this->userid)) {
                    $this->error("游客不允许参与评论！");
                }
            }
            //验证码判断开始
            if ($this->setting['code'] == 1) {
                $verify = $this->request->param('verify/s', '');
                if (empty($verify) || !captcha_check($verify)) {
                    if ($this->request->isAjax()) {
                        $this->ajaxReturn(array(
                            'msg'   => '验证码错误，请重新输入！',
                            'focus' => 'verify',
                            'code'  => 0,
                        ));
                        exit(json_encode($data));
                    } else {
                        $this->error("验证码错误，请重新输入！");
                    }
                }
            }
            $rule = [
                'comment_id|所属信息id' => 'require',
                'author|评论昵称'       => 'require|chsDash|length:3,20',
                'author_email|评论邮箱' => 'require|email',
                'content|评论内容'      => 'require|length:3,' . $strlength,
                '__token__'         => 'require|token',
            ];
            $result = $this->validate($post, $rule);
            if (true !== $result) {
                $this->error($result);
            }
            //检查回复的评论是否存在
            if ($parent) {
                $parentInfo = $this->modelClass->where('id', $parent)->find();
                if (!$parentInfo) {
                    $this->error('回复的评论不存在！');
                } else {
                    $post['content'] = "@{$parentInfo['author']}，" . $post['content'];
                }
            }
            $commentsId = $this->modelClass->addComments($post);
            if (false !== $commentsId) {
                //设置评论间隔时间，cookie没啥样的感觉-__,-!
                if ($this->setting['expire']) {
                    cookie($post['comment_id'], '1', array('expire' => (int) $this->setting['expire']));
                }

                if ($commentsId === -1) {
                    //待审核
                    $error = $this->modelClass->getError();
                    if (empty($error)) {
                        $error = '评论发表成功，但需要审核通过后才显示！';
                    }
                    if ($this->request->isAjax()) {
                        $this->ajaxReturn(array(
                            'msg'  => $error,
                            'code' => $commentsId,
                            'data' => ['__token__' => $this->request->token()],
                        ));
                    } else {
                        $this->error($error, null, ['__token__' => $this->request->token()]);
                    }
                } else {
                    $this->success("评论发表成功！", null, ['__token__' => $this->request->token()]);
                }
            } else {
                $this->error($this->modelClass->getError());
            }
        } else {
            $this->error("请使用POST方式新增评论！");
        }
    }

    //获取评论表情
    public function json_emote()
    {
        $cacheReplaceExpression = \think\facade\Cache::get('cacheReplaceExpression');
        if (empty($cacheReplaceExpression)) {
            $cacheReplaceExpression = model('comments/Emotion')->cacheReplaceExpression();
        }
        $this->ajaxReturn([
            'data'   => $cacheReplaceExpression,
            'info'   => '',
            'status' => true,
        ], 'JSONP');
    }

    //显示某篇信息的评论页面
    public function comment()
    {

    }

    /**
     * 使用递归的方式查询出回复评论...效率如何俺也不清楚，能力限制了。。
     * @param type $id
     * @return boolean
     */
    public function getParentComment($id)
    {
        if (!$id) {
            return false;
        }
        $where = array(
            'parent'   => $id,
            'approved' => 1,
        );
        $count = $this->modelClass->where($where)->count();
        //如果大于5条以上，只显示最久的第一条，和最新的3条
        /*if ($count > 5) {
        $oldData  = $this->modelClass->where($where)->order('create_time', 'ASC')->find()->toArray();
        $newsData = $this->modelClass->where($where)->limit(2)->order('create_time', 'DESC')->select()->toArray();
        //数组从新排序
        sort($newsData);
        array_unshift($newsData, $oldData, array(
        'id'         => 'load',
        'display'    => 'none', //标识这条评论不显示
        'comment_id' => $oldData['comment_id'],
        'parent'     => $oldData['parent'],
        'info'       => '已经省略中间部分...',
        ));
        $data = $newsData;
        } else {*/
        $data = $this->modelClass->where($where)->order('create_time', 'ASC')->select()->toArray();
        //}
        if ($data) {
            foreach ($data as $r) {
                $this->getParentComment((int) $r['id']);
                //替换表情
                $this->modelClass->replaceExpression($r['content']);
                $this->arr[] = $r;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    public function get_child($myid)
    {
        $a = $newarr = array();
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['parent'] == $myid) {
                    $newarr[$id] = $a;
                }

            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 得到树型结构数组
     * @param int $myid，开始父id
     */
    public function get_tree_array($myid = 0)
    {
        $retarray = array();
        //一级栏目数组
        $child = $this->get_child($myid);
        if (is_array($child)) {
            //数组长度
            $total = count($child);
            foreach ($child as $id => $value) {
                @extract($value);
                $retarray[$value['id']]          = $value;
                $retarray[$value['id']]["child"] = $this->get_tree_array($id);
            }
        } else {
            return false;
        }
        return array_values($retarray);
    }

    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @param int $json_option 传递给json_encode的option参数
     * @return void
     */
    protected function ajaxReturn($data, $type = 'JSON', $json_option = 0)
    {
        $data['state'] = $data['status'] ? "success" : "fail";
        switch (strtoupper($type)) {
            case 'JSON':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                exit(json_encode($data, $json_option));
            case 'XML':
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = $this->request->param('callback/s', 'callback');
                exit($handler . '(' . json_encode($data, $json_option) . ');');
            case 'EVAL':
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            default:
                // 用于扩展其他返回格式数据
                //tag('ajax_return', $data);
        }
    }

}
