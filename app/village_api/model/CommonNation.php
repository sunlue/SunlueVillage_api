<?php

namespace app\village_api\model;

use think\Model;

class CommonNation extends Model {
    protected $pk = 'id';

    public function getList($where = array()) {
        $data = CommonNation::field('value,label')->where($where)->paginate();
        return $data ? $data->toArray() : [];
    }

    public function getAll($where = array()) {
        $data = CommonNation::field('value,label')->where($where)->cache(true)->select();
        return $data ? $data->toArray() : [];
    }

    public function getFind($where = array()) {
        $data = CommonNation::field('value,label')->where($where)->cache(true)->find();
        return $data ? $data->toArray() : [];
    }

    public static function getLabel($where = array()) {
        $data = CommonNation::field('label')->where($where)->cache(true)->select();
        return $data ? array_column($data->toArray(), 'label') : [];
    }
}