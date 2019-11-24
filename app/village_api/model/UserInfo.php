<?php
/**
 * User: xiebing
 * Date: 2019/6/4
 * Time: 15:58
 */

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class UserInfo extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'uniqid' => 'string',
        'userid' => 'string',
        'name' => 'string',
        'nickname' => 'string',
        'mobile' => 'integer',
        'weixin' => 'string',
        'qq' => 'string',
        'email' => 'integer',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = array(
        'uniqid',
        'userid',
        'name',
        'nickname',
        'mobile',
        'weixin',
        'qq',
        'email',
        'create_time',
        'update_time',
        'delete_time',
    );

    public static function onBeforeInsert(Model $model) {
        $userid = strtoupper(uniqid('user-info-'));
        $model->setAttr('userid',$userid);
    }


    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return UserInfo::withoutField('del_time')->where($where)->cache(true, 10)->paginate(input('get.limit'))
            ->toArray();
    }

    /**
     * 查询全部数据
     * @param array $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAll($where = array()) {
        return UserInfo::withoutField('del_time')->where($where)->cache(true, 10)->select()->toArray();
    }

    /**
     * @param array $where
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFind($where = array()) {
        $data = UserInfo::withTrashed('delete_time')->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}















