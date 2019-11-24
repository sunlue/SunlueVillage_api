<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\facade\Request;
use think\Model;

class PortalMessage extends Common {

    protected $pk = 'uniqid';
    protected $autoWriteTimestamp=false;
    protected $schema = array(
        'uniqid' => 'string',
        'group' => 'string',
        'type' => 'string',
        'name' => 'string',
        'content' => 'string',
        'by_time' => 'integer',
        'mobile_tel' => 'string',
        'by_ip' => 'string',
        'address' => 'string',
        'email' => 'string',
        'reply' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'uniqid',
        'group',
        'type',
        'name',
        'content',
        'by_time',
        'mobile_tel',
        'by_ip',
        'address',
        'email',
        'reply',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('message-'));
        $model->setAttrs(array(
            'uniqid' => $uniqid,
            'by_time' => time(),
            'by_ip' => Request::ip(),
            'lang'=>input('get.lang',config('lang.default_lang'))
        ));
        if (empty($model->group)){
            $model->setAttr('group',rand(1000000000,9999999999));
        }
    }

    public function getByTimeAttr($value) {
        return date('Y-m-d H:i:s', $value);
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
        return PortalMessage::withoutField('delete_time')
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
        $data = PortalMessage::where($where)
            ->where('lang',input('get.lang', config('lang.default_lang')))
            ->find();
        return $data ? $data->toArray() : [];
    }

}