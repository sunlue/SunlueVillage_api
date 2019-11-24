<?php
namespace app\village_api\model;
use app\village_api\common\model\Common;
use think\Model;

class VillageGeo extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'id' => 'integer',
        'uniqid' => 'string',
        'village_id' => 'integer',
        'lang' => 'string',
        'lng' => 'decimal',
        'lat' => 'decimal',
        'altitude' => 'decimal',
        'max_altitude' => 'decimal',
        'min_altitude' => 'decimal',
        'location_realm' => 'string',
        'geo_structure' => 'string',
        'topography' => 'string',
        'hydrological_situation' => 'string',
        'natural_disasters' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer'
    );

    protected $field = [
        'id',
        'uniqid',
        'village_id',
        'lang',
        'lng',
        'lat',
        'altitude',
        'max_altitude',
        'min_altitude',
        'location_realm',
        'geo_structure',
        'topography',
        'hydrological_situation',
        'natural_disasters',
        'create_time',
        'update_time',
        'delete_time'
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('village-geo-'));
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
        return VillageGeo::withoutField('delete_time')
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
        return VillageGeo::withoutField('delete_time')
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
        $data = VillageGeo::withTrashed()->withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}