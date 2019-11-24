<?php
/**
 * User: xiebing
 * Date: 2019/6/4
 * Time: 15:58
 */

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class UserRole extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'uniqid' => 'string',
        'pid' => 'string',
        'name' => 'string',
        'sign' => 'string',
        'sort' => 'integer',
        'remark' => 'string',
        'rights' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = array(
        'uniqid',
        'pid',
        'name',
        'sign',
        'sort',
        'remark',
        'rights',
        'create_time',
        'update_time',
        'delete_time',
    );

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('user-role-'));
        $model->setAttr('uniqid', $uniqid);
    }

    protected function setRightsAttr($value) {
        return json_encode($value);
    }

    protected function getRightsAttr($value) {
        return json_decode($value, true);
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        $data = UserRole::withoutField('create_time,update_time,delete_time')
            ->where($where)->cache(true, 10)->paginate(input('get.limit'))
            ->each(function ($item) {
                $item->users = UserAuth::where('role', $item['uniqid'])
                    ->field('b.uniqid,b.userid,role,name,nickname,weixin,qq,email,account,mobile,is_login,is_mobile,login_count')
                    ->join('user_list_view b', 'user_auth.userid=b.userid', 'left')->select();
            });
        return $data ? $data->toArray() : [];


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
        $data = UserRole::withoutField('create_time,update_time,delete_time')
            ->where($where)->cache(true, 10)->select()
            ->each(function ($item) {
                $item->users = UserAuth::where('role', $item['uniqid'])
                    ->field('b.uniqid,user_auth.uniqid as authid,b.userid,role,name,nickname,weixin,qq,email,account,mobile,is_login,is_mobile,login_count')
                    ->join('user_list_view b', 'user_auth.userid=b.uniqid', 'inner')->select();
            });
        return $data ? $data->toArray() : [];
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
        $data = UserRole::withTrashed('create_time,update_time,delete_time')->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}















