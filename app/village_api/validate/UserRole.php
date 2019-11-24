<?php

namespace app\village_api\validate;

use think\Validate;

class UserRole extends Validate {
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
        'name.require' => 'USER_ROLE_NAME_EMPTY',
        'sign.max' => 'USER_ROLE_SIGN_LENGTH_ERROR',
        'sort.number' => 'USER_ROLE_SORT_TYPE_ERROR',
        'remark.max' => 'USER_ROLE_REMARK_LENGTH_ERROR',
    ];

    protected function sceneCreate() {
        return $this->remove('uniqid', 'require');
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneRights() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\UserRole::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}