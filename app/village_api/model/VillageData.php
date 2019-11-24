<?php

namespace app\village_api\model;

use app\village_api\common\model\Common;
use think\Model;

class VillageData extends Common {

    protected $pk = 'uniqid';
    protected $type = array(
        'id' => 'integer',
        'uniqid' => 'string',
        'lang' => 'string',
        'thumbnail' => 'string',
        'region' => 'string',
        'name' => 'string',
        'attribute' => 'integer',
        'registered_population' => 'integer',
        'registered_population_man' => 'integer',
        'registered_population_woman' => 'integer',
        'permanent_population' => 'integer',
        'permanent_population_man' => 'integer',
        'permanent_population_woman' => 'integer',
        'collective_income' => 'integer',
        'person_income' => 'integer',
        'nation' => 'array',
        'decade' => 'string',
        'domain_area' => 'string',
        'village_area' => 'string',
        'content' => 'string',
        'industry' => 'string',
        'audio' => 'string',
        'video' => 'string',
        'demonstration' => 'integer',
        'advanced' => 'integer',
        'show' => 'integer',
        'is_top' => 'integer',
        'recommended' => 'integer',
        'hot' => 'integer',
        'hits' => 'integer',
        'tag' => 'array',
        'sort' => 'integer',
        'like' => 'integer',
        'target' => 'string',
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
        'thumbnail',
        'region',
        'name',
        'attribute',
        'registered_population',
        'registered_population_man',
        'registered_population_woman',
        'permanent_population',
        'permanent_population_man',
        'permanent_population_woman',
        'collective_income',
        'person_income',
        'nation',
        'decade',
        'domain_area',
        'village_area',
        'content',
        'industry',
        'audio',
        'video',
        'demonstration',
        'advanced',
        'show',
        'is_top',
        'recommended',
        'hot',
        'hits',
        'tag',
        'sort',
        'like',
        'target',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'create_time',
        'update_time',
        'delete_time'
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('village-data-'));
        $model->setAttr('uniqid', $uniqid);
        $model->setAttr('lang', input('get.lang', config('lang.default_lang')));
    }

    public static function onBeforeUpdate(Model $model) {
        $model->setAttrs(array(
            'update_time' => time()
        ));
    }

    public function getCollectiveIncomeAttr($value) {
        return $value > 0 ? $value / 100 : '0.00';
    }

    public function getPersonIncomeAttr($value) {
        return $value > 0 ? $value / 100 : '0.00';
    }

    /**
     * 查询列表
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public static function getList($where = array()) {
        return VillageData::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->order('sort', 'desc')->order('create_time', 'asc')
            ->paginate(input('get.limit'))
            ->each(function ($item) {
                //取属性
                $item['attr_text'] = $item['attribute'] == 1 ? '行政村' : '自然村';
                //取行政区域
                $region = CommonRegion::getParents($item['village']);
                $data = array_column($region, 'label');
                $item['region_text'] = implode(array_reverse($data), '/');
                //取民族
                $where[] = ['value', 'in', $item['nation']];
                $item['nation_text'] = CommonNation::getLabel($where);
                //取乡镇
                $item['town_text'] = CommonRegion::getTown($item['village']);
                //取类型
                $type = VillageDataTypeJoin::getAll(array(
                    'data' => $item['uniqid']
                ));
                if (!empty($type)) {
                    $map[] = ['uniqid', 'in', array_column($type, 'type')];
                    $typeArr = VillageType::getAll($map);
                    $item['type'] = $typeArr ? array_column($typeArr, 'name') : [];
                }
            })->toArray();
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
        return VillageData::withoutField('delete_time')
            ->where($where)->cache(true, 10)
            ->order('sort', 'desc')->order('create_time', 'asc')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->select()->each(function ($item) {
                //取属性
                $item['type_text'] = $item['type'] == 1 ? '行政村' : '自然村';
                //取行政区域
                $region = CommonRegion::getParents($item['village']);
                $data = array_column($region, 'label');
                $item['region_text'] = implode(array_reverse($data), '/');
                //取民族
                $where[] = ['value', 'in', $item['nation']];
                $item['nation_text'] = CommonNation::getLabel($where);
                //取乡镇
                $item['town_text'] = CommonRegion::getTown($item['village']);
                //取类型
                $type = VillageDataTypeJoin::getAll(array(
                    'data' => $item['uniqid']
                ));
                if (!empty($type)) {
                    $map[] = ['uniqid', 'in', array_column($type, 'type')];
                    $typeArr = VillageType::getAll($map);
                    $item['type'] = $typeArr ? array_column($typeArr, 'name') : [];
                }
            })->toArray();
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
        $data = VillageData::withTrashed()->withoutField('delete_time')
            ->where('lang', input('get.lang', config('lang.default_lang')))
            ->where($where)->cache(true, 10)->find();
        if (empty($data)) {
            return [];
        }
        //取属性
        $item['attr_text'] = $data['type'] == 1 ? '行政村' : '自然村';
        //取行政区域
        $region = CommonRegion::getParents($data['village']);
        $region = array_column($region, 'value');
        sort($region);
        $data['region_text'] = $region;
        //民族
        $nation[] = ['value', 'in', $data['nation']];
        $data['nation_text'] = CommonNation::getLabel($nation);
        //取乡镇
        $data['town_text'] = CommonRegion::getTown($data['village']);
        //取类型
        $type = VillageDataTypeJoin::getAll(array(
            'data' => $data['uniqid']
        ));
        if (!empty($type)) {
            $map[] = ['uniqid', 'in', array_column($type, 'type')];
            $typeArr = VillageType::getAll($map);
            $data['type'] = $typeArr ? array_column($typeArr, 'name') : [];
        }
        return $data ? $data->toArray() : [];
    }

}