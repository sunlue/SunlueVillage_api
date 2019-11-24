<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Db;
use think\Model;

class PortalArticleAttr extends Model {

    protected $pk = 'uniqid';
    protected $autoWriteTimestamp=false;
    protected $schema = array(
        'uniqid' => 'string',
        'unique' => 'string',
        'type' => 'integer',
        'name' => 'string',
        'link' => 'string',
        'size' => 'string',
        'mime' => 'string',
        'dirname' => 'string',
        'basename' => 'string',
        'extension' => 'string',
        'filename' => 'string',
    );

    protected $field = [
        'uniqid',
        'unique',
        'type',
        'name',
        'link',
        'size',
        'mime',
        'dirname',
        'basename',
        'extension',
        'filename',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('article-attr-'));
        $model->setAttr('uniqid', $uniqid);
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return PortalArticleAttr::where($where)->cache(true, 10)
            ->order('sort', 'desc')->paginate(input('get.limit'))
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
        return PortalArticleAttr::field('uniqid,name,link,size,extension')
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
        $data = PortalArticleAttr::where($where)->find();
        return $data ? $data->toArray() : [];
    }

}