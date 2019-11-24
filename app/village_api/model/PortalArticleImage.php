<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Db;
use think\Model;

class PortalArticleImage extends Model {

    protected $pk = 'uniqid';
    protected $autoWriteTimestamp = false;
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
        'core' => 'string',
        'thumb' => 'string',
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
        'core',
        'thumb'
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('article-image-'));
        $model->setAttr('uniqid', $uniqid);
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return PortalArticleImage::where($where)->cache(true, 10)
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
        return PortalArticleImage::field('uniqid,name,link,size')
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
        $data = PortalArticleImage::where($where)->find();
        return $data ? $data->toArray() : [];
    }

}