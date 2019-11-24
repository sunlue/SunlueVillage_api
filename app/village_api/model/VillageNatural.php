<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class VillageNatural extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'id' => 'integer',
        'uniqid' => 'string',
        'village_id' => 'integer',
        'lang' => 'string',
        'climate_characteristics' => 'string',
        'annual_mean_temperature' => 'decimal',
        'annual_rainfall' => 'integer',
        'annual_frost_free_period' => 'integer',
        'vegetation_coverage' => 'integer',
        'main_land' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer'
    );

    protected $field = [
        'id',
        'uniqid',
        'village_id',
        'lang',
        'climate_characteristics',
        'annual_mean_temperature',
        'annual_rainfall',
        'annual_frost_free_period',
        'vegetation_coverage',
        'main_land',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('village-natural-'));
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
        return VillageNatural::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang', input('get.lang', config('lang.default_lang')))
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
        return VillageNatural::withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
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
        $data = VillageNatural::withTrashed()->withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}