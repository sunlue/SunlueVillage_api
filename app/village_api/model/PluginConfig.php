<?php


namespace app\village_api\model;


use think\Model;

class PluginConfig extends Model {
    protected $pk = 'uniqid';
    protected $autoWriteTimestamp = false;
    protected $type = [
        'uniqid' => 'string',
        'type' => 'string',
        'name' => 'string',
        'enable' => 'string',
        'install' => 'string',
        'pages' => 'string',
        'version' => 'string',
        'config' => 'string',
        'content' => 'string',
        'appid' => 'string',
        'appkey' => 'string',
    ];

    protected $field = [
        'uniqid',
        'type',
        'name',
        'enable',
        'install',
        'pages',
        'version',
        'config',
        'content',
        'appid',
        'appkey',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('config-'));
        $model->setAttrs(array(
            'uniqid' => $uniqid,
        ));
    }

    public function setTypeAttr($value) {
        $type = ['config' => 1];
        return $type[$value];
    }

    public function getTypeAttr($value) {
        $type = [1 => 'config'];
        return $type[$value];
    }

    public function setConfigAttr($value) {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getConfigAttr($value) {
        return $value ? json_decode($value, true) : '';
    }

    public static function getAll($where) {
        $data = PluginConfig::where($where)->select();
        return $data ? $data->toArray() : [];
    }

    public static function getFind($where = array()) {
        $data = PluginConfig::where($where)->find();
        return $data ? $data->toArray() : [];
    }
}