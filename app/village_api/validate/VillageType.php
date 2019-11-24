<?php

namespace app\village_api\validate;

use think\Validate;

class VillageType extends Validate {
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
        'name.require' => 'VILLAGE_TYPE_NAME_EMPTY',
        'sign.max' => 'VILLAGE_TYPE_SIGN_LENGTH_ERROR',
        'sort.number' => 'VILLAGE_TYPE_SORT_TYPE_ERROR',
        'remark.max' => 'VILLAGE_TYPE_REMARK_LENGTH_ERROR',
    ];

    protected function sceneCreate() {
        return $this->only(['name','sign','sort','remark']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\VillageType::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}