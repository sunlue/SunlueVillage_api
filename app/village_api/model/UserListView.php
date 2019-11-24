<?php
/**
 * User: xiebing
 * Date: 2019/6/11
 * Time: 20:44
 */

namespace app\village_api\model;

use think\Model;

class UserListView extends Model {

    /**
     * @param array $where
     * @return array|mixed|Model|null
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFind($where = array()) {
        $data = UserListView::where($where)->find();
        return $data ? $data->toArray() : [];
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return UserListView::withoutField('delete_time')->where($where)
            ->cache(true, 10)->paginate(input('get.limit'))->toArray();
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
        return UserListView::withoutField('delete_time')->where($where)->cache(true, 10)->select()->toArray();
    }


}