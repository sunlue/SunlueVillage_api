<?php


namespace app\village_api\model;


use think\Model;

class PluginCapacity extends Model {
    protected $pk = 'uniqid';
    protected $autoWriteTimestamp = false;
    protected $type = [
        'uniqid' => 'string',
        'date' => 'timestamp',
        'number' => 'integer',
    ];

    protected $field = [
        'uniqid',
        'date',
        'number',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('capacity-'));
        $model->setAttr('uniqid', $uniqid);
    }

    public function getDateAttr($value) {
        return date('Y-m-d', $value);
    }

    public static function getAll($where) {
        $data = PluginCapacity::where($where)->select();
        return $data ? $data->toArray() : [];
    }
}