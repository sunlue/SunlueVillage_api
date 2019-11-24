<?php

namespace app\village_api\validate;

use app\village_api\model\PortalArticleType;
use think\Validate;

class ArticleType extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'name' => 'require',
        'sign' => 'max:100',
        'sort' => 'number',
        'remark' => 'max:255',

    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'name.require' => 'ARTICLE_TYPE_NAME_EMPTY',
        'sign.max' => 'ARTICLE_TYPE_SIGN_LENGTH_ERROR',
        'sort.number' => 'ARTICLE_TYPE_SORT_TYPE_ERROR',
        'remark.max' => 'ARTICLE_TYPE_REMARK_LENGTH_ERROR',
    ];

    protected function sceneCreate() {
        return $this->only(['name','sign','sort','remark']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return PortalArticleType::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}