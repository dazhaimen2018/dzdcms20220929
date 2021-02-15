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
// | 评论模型
// +----------------------------------------------------------------------
namespace app\comments\model;

use app\common\model\Modelbase;
use think\Db;

class Comments extends Modelbase
{
    //审核状态
    const statusCheck = -1;
    //拒绝状态
    const statusRefuse            = 0;
    protected $autoWriteTimestamp = true;
    protected $dateFormat         = false;

    //评论状态，1为审核通过，0为待审核
    protected $commentsApproved = 1;
    protected $insert           = ['author_ip', 'agent'];
    protected function setAuthorIpAttr()
    {
        return request()->ip();
    }
    protected function setAgentAttr()
    {
        return substr(request()->server('HTTP_USER_AGENT', ''), 0, 255);
    }

    /**
     * 增加评论
     * @param type $data 评论数据
     * @return boolean 成功返回评论id，失败返回false
     */
    public function addComments($data)
    {
        if (!is_array($data)) {
            $this->error = '数据类型有误！';
            return false;
        }
        $setting = cache('Comments_config');

        //如果是空值，直接赋值默认值
        if (empty($data['parent'])) {
            $data['parent'] = 0;
        }
        if (empty($data['user_id'])) {
            $data['user_id'] = 0;
        }
        //设置评论审核
        if (defined("IN_ADMIN") && IN_ADMIN) {
            $data['approved'] = 1;
        } else {
            $data['approved'] = (int) $setting['check'] == 0 ? 1 : 0;
        }
        //含违禁词设置为审核状态
        $handle = \util\SensitiveHelper::init()->setTreeByFile(ROOT_PATH . 'data/words.txt');
        $word   = $handle->getBadWord($data['content']);
        if ($word) {
            $data['approved'] = 0;
        }
        //添加信息到评论主表
        $res = $this->save($data);
        if ($res) {
            //状态码 -1 审核状态， 大于0 评论id， 0或false 评论发表失败。
            $status = $this->getAttr('id');
            if (isset($filterStatus) && true !== $filterStatus) {
                $status = $filterStatus;
            } else if (!$data['approved']) {
                $status = self::statusCheck;
            }
            //行为标签
            //$tagData = array_merge($data, $secondaryField);
            //tag('comment_add_end', $tagData);
            return $status;
        } else {
            $this->error = '评论入库失败！';
            return false;
        }
    }

    /**
     * 删除评论
     * @param type $ids 评论id，可以是数组
     * @return boolean
     */
    public function deleteComments($ids)
    {
        if (!$ids) {
            $this->error = '数据类型有误！';
            return false;
        }
        //增加行为标签
        //tag('comment_delete_begin', $ids);
        //判断是批量删除还是单条删除
        if (is_array($ids)) {
            $list = $this->where('id', 'in', $ids)->select();
            if (!$list) {
                $this->error = '评论不存在！';
                return false;
            }
            //删除主表评论
            if (false !== $this->where('id', 'in', $ids)->delete()) {
                //tag('comment_delete_end', $ids);
                return true;
            } else {
                $this->error = '删除失败！';
                return false;
            }
        } else {
            $info = $this->where('id', $ids)->find();
            if (!$info) {
                $this->error = '评论不存在！';
                return false;
            }
            if (false !== $this->where('id', $ids)->delete()) {
                return true;
            } else {
                $this->error = '删除失败！';
                return false;
            }
        }
        return false;
    }

    /**
     * 审核评论
     * @param type $ids $ids $ids 评论id，可以是数组
     * @param type $approved 状态
     * @return boolean
     */
    public function checkComments($ids, $approved = 1)
    {
        if (!$ids) {
            $this->error = '数据类型有误！';
            return false;
        }
        $tagArray = array(
            'ids'    => $ids,
            'status' => $approved,
        );
        //tag('comment_check_begin', $tagArray);
        //判断是批量审核还是单条审核
        if (is_array($ids)) {
            $status = $this->where('id', 'in', $ids)->update(["approved" => $approved]);
        } else {
            $status = $this->where('id', $ids)->update(["approved" => $approved]);
        }
        //tag('comment_check_end', $tagArray);
        return $status;
    }

    /**
     * 检查文章信息是否允许评论
     * @param type $catid 栏目id
     * @param type $id 信息id
     * @return boolean 允许评论返回true，不允许评论返回false
     */
    public function noAllowComments($catid, $id)
    {
        if (!$catid || !$id) {
            return false;
        }
        $modelid   = getCategory($catid, 'modelid');
        $tablename = ucwords(getModel($modelid, 'tablename'));
        if (empty($tablename)) {
            return false;
        }
        if ($this->field_exists($tablename, "allow_comment")) {
            $allow_comment = Db::name($tablename)->where("id", $id)->value("allow_comment");
            if ((int) $allow_comment <= 0) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * 评论表情替换
     * 以后在进行效率优化。。。菜鸟-__,-!
     * @param type $content 评论内容
     * @param string $emotionPath 表情存放路径，以'/'结尾
     * @param type $classStyle 表情img附加样式
     * @return boolean
     */
    public function replaceExpression(&$content, $emotionPath = '', $classStyle = '')
    {
        if (!$content) {
            return false;
        }
        //表情存放路径
        if (empty($emotionPath)) {
            $emotionPath = config('public_url') . 'static/modules/comments/images/emotion/';
        }
        $cacheReplaceExpression = \think\facade\cache::get('cacheReplaceExpression');
        if ($cacheReplaceExpression) {
            $replace = $cacheReplaceExpression;
        } else {
            $replace = model('comments/Emotion')->cacheReplaceExpression($emotionPath, $classStyle);
        }
        //替换表情
        $content = strtr($content, $replace);
        return true;
    }

    //配置缓存
    public function comments_cache()
    {
        $data = unserialize(model('admin/Module')->where('module', 'comments')->value('setting'));
        cache("Comments_config", $data);
        return $data;
    }
}
