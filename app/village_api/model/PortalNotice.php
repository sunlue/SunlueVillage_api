<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class PortalNotice extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'uniqid' => 'string',
        'title' => 'string',
        'release' => 'integer',
        'content' => 'string',
        'by_time' => 'integer',
        'thumb' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'uniqid',
        'title',
        'release',
        'content',
        'by_time',
        'thumb',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('notice-'));
        $model->setAttrs(array(
            'uniqid' => $uniqid,
            'by_time' => time(),
            'lang'=>input('get.lang', config('lang.default_lang'))
        ));
    }

    public function getByTimeAttr($value) {
        return date('Y-m-d', $value);
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return PortalNotice::withoutField('delete_time')
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
        return PortalNotice::withoutField('delete_time')
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
        $data = PortalNotice::withoutField('delete_time')
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}