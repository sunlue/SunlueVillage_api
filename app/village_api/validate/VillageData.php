<?php

namespace app\village_api\validate;

use app\village_api\model\PortalArticleData;
use think\Validate;

class VillageData extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'name' => 'require',
        'attribute' => 'number',
        'registered_population' => 'number|min:0',
        'registered_population_man' => 'number|min:0',
        'registered_population_woman' => 'number|min:0',
        'permanent_population' => 'number|min:0',
        'permanent_population_man' => 'number|min:0',
        'permanent_population_woman' => 'number|min:0',
        'collective_income' => 'number|require',
        'person_income' => 'number|require',
        'content' => 'require',
        'demonstration' => 'require',
        'advanced' => 'require',
        'show' => 'number',
        'is_top' => 'number',
        'recommended' => 'number',
        'hot' => 'number',
        'hits' => 'number',
        'like' => 'number',
        'sort' => 'number',
        'thumbnail' => 'max:100',
        'seo_keywords' => 'max:150',
        'seo_description' => 'max:255',
        'seo_title' => 'max:100',
        'field' => 'require',
        'value' => 'require'
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'name.require' => '村落名称不能为空',
        'attribute.number' => '村落属性数据格式不正确',
        'registered_population.number' => '户籍人口数据格式不正确',
        'registered_population.min' => '户籍人口必须大于0',
        'registered_population_man.number' => '户籍人口（男）数据格式不正确',
        'registered_population_man.min' => '户籍人口（男）必须大于0',
        'registered_population_woman.number' => '户籍人口（女）数据格式不正确',
        'registered_population_woman.min' => '户籍人口（女）必须大于0',
        'permanent_population.number' => '常住人口数据格式不正确',
        'permanent_population.min' => '常住人口必须大于0',
        'permanent_population_man.number' => '常住人口（男）数据格式不正确',
        'permanent_population_man.min' => '常住人口（男）必须大于0',
        'permanent_population_woman.number' => '常住人口（女）数据格式不正确',
        'permanent_population_woman.min' => '常住人口（女）必须大于0',
        'content.require' => '村落简介不能为空',
        'show.number' => '村落显示类型错误',
        'is_top.number' => '村落置顶类型错误',
        'recommended.number' => '村落推荐类型错误',
        'hot.number' => '村落热度类型错误',
        'sort.number' => '村落排序类型错误',
        'hits.number' => '村落查看数类型错误',
        'like.number' => '村落点赞数类型错误',
        'thumbnail.max' => '村落缩略图长度错误',
        'seo_keywords.max' => '村落SEO关键词长度错误',
        'seo_description.max' => '村落SEO描述长度错误',
        'seo_title.max' => '村落SEO标题长度错误',
        'field.require' => 'FIELD_EMPTY',
        'value.require' => 'VALUE_EMPTY'
    ];

    protected function sceneCreate() {
        return $this->only([
            'name',
            'type',
            'registered_population',
            'registered_population_man',
            'registered_population_woman',
            'permanent_population',
            'permanent_population_man',
            'permanent_population_woman',
            'content',
            'show',
            'is_top',
            'recommended',
            'hot',
            'sort',
            'hits',
            'like',
            'thumbnail',
            'seo_keywords',
            'seo_description',
            'seo_title'
        ]);
    }

    protected function sceneUpdate() {
        return $this->only([
            'uniqid',
            'name',
            'type',
            'registered_population',
            'registered_population_man',
            'registered_population_woman',
            'permanent_population',
            'permanent_population_man',
            'permanent_population_woman',
            'content',
            'show',
            'is_top',
            'recommended',
            'hot',
            'sort',
            'hits',
            'like',
            'thumbnail',
            'seo_keywords',
            'seo_description',
            'seo_title'
        ]);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneLike() {
        return $this->only(['uniqid']);
    }

    protected function sceneField() {
        return $this->only(['uniqid'])
            ->append('field', 'require')
            ->append('value', 'require');
    }

    protected function uniques($value) {
        return \app\village_api\model\VillageData::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}