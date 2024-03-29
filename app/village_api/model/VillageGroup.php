<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class VillageGroup extends Common {

    protected $pk = 'uniqid';
    protected $type = array(
        'id' => 'integer',
        'village_id' => 'string',
        'uniqid' => 'string',
        'lang' => 'string',
        'content' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'id',
        'village_id',
        'uniqid',
        'lang',
        'content',
        'create_time',
        'update_time',
        'delete_time'
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('village-group-'));
        $model->setAttr('uniqid', $uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    public static function onBeforeUpdate(Model $model) {
        $model->setAttrs(array(
            'update_time' => time()
        ));
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return VillageGroup::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->order('sort', 'desc')->order('create_time', 'asc')
            ->paginate(input('get.limit'))->toArray();
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
        return VillageGroup::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->order('sort', 'desc')->order('create_time', 'asc')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->select()->toArray();
    }

    /**
     * 查询单条数据
     * @param array $where
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFind($where = array()) {
        $data = VillageGroup::withTrashed()->withoutField('delete_time')
//            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->cache(true, 10)->find();
        return $data ? $data->toArray() : [];
    }

}