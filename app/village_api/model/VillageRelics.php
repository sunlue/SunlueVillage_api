<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class VillageRelics extends Common {

    protected $pk = 'uniqid';
    protected $type = array(
        'id' => 'integer',
        'uniqid' => 'string',
        'village_id' => 'string',
        'lang' => 'string',
        'name' => 'string',
        'excerpt' => 'string',
        'content' => 'string',
        'lng' => 'float',
        'lat' => 'float',
        'thumbnail' => 'string',
        'decade' => 'string',
        'is_attractions' => 'integer',
        'visit_time' => 'float',
        'season' => 'array',
        'price' => 'float',
        'level' => 'integer',
        'open_time' => 'string',
        'close_time' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer'
    );

    protected $field = [
        'id',
        'uniqid',
        'village_id',
        'name',
        'excerpt',
        'content',
        'lang',
        'lng',
        'lat',
        'thumbnail',
        'decade',
        'is_attractions',
        'visit_time',
        'season',
        'price',
        'level',
        'open_time',
        'close_time',
        'create_time',
        'update_time',
        'delete_time'
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('village-relics-'));
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
        return VillageRelics::withoutField('delete_time')
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
        return VillageRelics::withoutField('delete_time')
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
        $data = VillageRelics::withTrashed()->withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}