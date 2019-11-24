<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class VillageDataTypeJoin extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'uniqid' => 'string',
        'data' => 'string',
        'type' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'uniqid',
        'data',
        'type',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('village-data-type-'));
        $model->setAttr('uniqid',$uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return VillageDataTypeJoin::withoutField('delete_time')
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->where($where)->cache(true, 10)->paginate(input('get.limit'))
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
        return VillageDataTypeJoin::withoutField('delete_time')
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->where($where)->cache(true, 10)->select()->toArray();
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
        $data = VillageDataTypeJoin::withTrashed()->field('uniqid,data,type')
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}