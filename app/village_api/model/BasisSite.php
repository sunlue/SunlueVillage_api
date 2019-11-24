<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;
use think\model\concern\SoftDelete;

class BasisSite extends Model {

    protected $pk = 'uniqid';
    protected $autoWriteTimestamp=false;
    protected $schema = array(
        'uniqid' => 'string',
        'type' => 'string',
        'content' => 'string',
    );

    protected $field = [
        'uniqid',
        'type',
        'content',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('site-'));
        $model->setAttr('uniqid', $uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    public function setContentAttr($value) {
        return json_encode($value);
    }

    public function getContentAttr($value) {
        return json_decode($value, true);
    }

    /**
     * 查询数据
     * @param $where
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public static function getFind($where = array()) {
        $data = BasisSite::field('content')->where($where)
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->find();
        return $data ? $data->toArray() : [];
    }

}