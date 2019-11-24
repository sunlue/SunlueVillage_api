<?php

namespace app\village_api\validate;

use think\Validate;

class UserInfo extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'name' => 'require',
        'field' => 'require',
        'value' => 'require',
        'mobile' => 'mobile'
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'name.require' => 'USER_NAME_EMPTY',
        'field.require' => 'FIELD_EMPTY',
        'value.require' => 'VALUE_EMPTY',
        'mobile.mobile' => 'MOBILE_FORMAT_ERROR'
    ];

    protected function sceneCreate() {
        return $this->only(['name']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneField() {
        return $this->only(['uniqid'])
            ->append('field', 'require')
            ->append('value', 'require');
    }

    protected function sceneUpdate() {
        return $this->only(['uniqid', 'name']);
    }

    protected function uniques($value) {
        return \app\village_api\model\UserInfo::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}