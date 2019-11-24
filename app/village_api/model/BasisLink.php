<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;
use think\model\concern\SoftDelete;

class BasisLink extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'uniqid' => 'string',
        'target' => 'integer',
        'name' => 'string',
        'link' => 'string',
        'icon' => 'string',
        'remark' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'uniqid',
        'target',
        'name',
        'link',
        'icon',
        'remark',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('link-'));
        $model->setAttr('uniqid', $uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return BasisLink::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang',input('get.lang', config('lang.default_lang')))
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
        return BasisLink::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang',input('get.lang', config('lang.default_lang')))
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
        $data = BasisLink::withoutField('delete_time')->where($where)
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->find();
        return $data ? $data->toArray() : [];
    }

}