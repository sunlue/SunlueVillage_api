<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;
use think\model\concern\SoftDelete;

class PortalSlide extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'uniqid' => 'string',
        'nav' => 'string',
        'name' => 'string',
        'sign' => 'string',
        'sort' => 'integer',
        'remark' => 'string',
        'link' => 'string',
        'image' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'uniqid',
        'nav',
        'name',
        'sign',
        'sort',
        'remark',
        'link',
        'image',
        'delete_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('slide-'));
        $model->set('uniqid',$uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return PortalSlide::withoutField('delete_time')
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
        return PortalSlide::withoutField('delete_time')
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
        $data = PortalSlide::withoutField('delete_time')
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}