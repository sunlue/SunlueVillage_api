<?php

namespace app\village_api\validate;

use app\village_api\model\PortalArticleData;
use think\Validate;

class VillageScenic extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'village_id'=>'require',
        'field' => 'require',
        'value' => 'require'
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'village_id.require'=>"村落数据异常",
        'field.require' => 'FIELD_EMPTY',
        'value.require' => 'VALUE_EMPTY'
    ];

    protected function sceneCreate() {
        return $this->only(['village_id']);
    }


    protected function sceneUpdate() {
        return $this->only([
            'uniqid',
        ]);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneField() {
        return $this->only(['uniqid'])
            ->append('field', 'require')
            ->append('value', 'require');
    }

    protected function uniques($value) {
        return \app\village_api\model\VillageScenic::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}