<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class PortalArticleData extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'id' => 'string',
        'lang' => 'string',
        'uniqid' => 'string',
        'title' => 'string',
        'region' => 'string',
        'village_id' => 'string',
        'type' => 'string',
        'excerpt' => 'string',
        'source' => 'string',
        'link' => 'string',
        'audio' => 'string',
        'video' => 'string',
        'content' => 'string',
        'quality' => 'integer',
        'show' => 'integer',
        'comment' => 'integer',
        'is_top' => 'integer',
        'recommended' => 'integer',
        'hot' => 'integer',
        'sort' => 'integer',
        'hits' => 'integer',
        'like' => 'integer',
        'favorites' => 'integer',
        'comment_count' => 'integer',
        'thumbnail' => 'string',
        'target' => 'string',
        'tag' => 'string',
        'seo_title' => 'string',
        'seo_keywords' => 'string',
        'seo_description' => 'string',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    );

    protected $field = [
        'id',
        'uniqid',
        'lang',
        'title',
        'region',
        'village_id',
        'type',
        'excerpt',
        'source',
        'link',
        'audio',
        'video',
        'content',
        'quality',
        'show',
        'comment',
        'is_top',
        'recommended',
        'hot',
        'sort',
        'hits',
        'like',
        'favorites',
        'comment_count',
        'thumbnail',
        'target',
        'tag',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('article-data-'));
        $model->setAttr('uniqid', $uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    public static function onBeforeUpdate(Model $model) {
        $model->setAttrs(array(
            'update_time' => time()
        ));
    }

    public function setVillageIdAttr($value) {
        return $value && is_array($value) ? $value[0] : '';
    }

    public function setRegionAttr($value) {
        return $value && is_array($value) ? $value[count($value)-1] : '';
    }

    public function setTagAttr($value) {
        return $value ? implode(',', array_column($value, 'value')) : '';
    }

    public function getTagAttr($value) {
        return explode(',', $value);
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\db\exception\DbException
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return PortalArticleData::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->order('sort', 'desc')->order('create_time', 'asc')
            ->paginate(input('get.limit'))
            ->each(function ($item) {
                $articleType = PortalArticleType::getFind(array(
                    'uniqid' => $item['type']
                ));
                $item['type_text'] = $articleType ? $articleType['name'] : '';
            })->toArray();
    }

    /**
     * 查询全部数据
     * @param array $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAll($where = array()) {
        return PortalArticleData::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->order('sort', 'desc')->order('create_time', 'asc')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->select()->each(function ($item) {
                $articleType = PortalArticleType::getFind(array(
                    'uniqid' => $item['type']
                ));
                $item['type_text'] = $articleType ? $articleType['name'] : '';
            })->toArray();
    }

    /**
     * 查询单条数据
     * @param array $where
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFind($where = array()) {
        $data = PortalArticleData::withTrashed()->withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->find();

        $articleType = PortalArticleType::getFind(array(
            'uniqid' => $data['type']
        ));
        $data['type_text'] = $articleType ? $articleType['name'] : '';
        return $data ? $data->toArray() : [];
    }

    public static function getPrev($id) {
        $where[] = ['id', '<', $id];
        $maxId = PortalArticleData::where($where)->max('id');
        $data = PortalArticleData::where(['id' => $maxId])->find();
        return $data ? $data->toArray() : [];
    }

    public static function getNext($id) {
        $where[] = ['id', '>', $id];
        $minId = PortalArticleData::where($where)->min('id');
        $data = PortalArticleData::where(['id' => $minId])->find();
        return $data ? $data->toArray() : [];
    }

}