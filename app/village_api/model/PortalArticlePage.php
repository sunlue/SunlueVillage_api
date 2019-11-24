<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Db;
use think\Model;

class PortalArticlePage extends Common {

    protected $pk = 'uniqid';
    protected $schema = array(
        'id' => 'string',
        'uniqid' => 'string',
        'title' => 'string',
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
        'title',
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
        $uniqid = strtoupper(uniqid('article-page-'));
        $model->setAttr('uniqid', $uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    public static function onBeforeUpdate(Model $model) {
        $model->setAttrs(array(
            'update_time' => time()
        ));
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
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return PortalArticlePage::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->order('sort', 'desc')->order('create_time','asc')
            ->paginate(input('get.limit'))
            ->each(function ($item) {
                $item->attach = PortalArticleAttr::getAll(array(
                    'unique' => $item->uniqid
                ));
                $item->images = PortalArticleImage::getAll(array(
                    'unique' => $item->uniqid
                ));
                return $item;
            })
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
        return PortalArticlePage::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->order('sort', 'desc')->order('create_time','asc')
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
        $data = PortalArticlePage::withTrashed()->withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->find();
        return $data ? $data->toArray() : [];
    }

}