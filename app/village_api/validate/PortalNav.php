<?php

namespace app\village_api\validate;

use think\Validate;

class PortalNav extends Validate {
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
        'name.require' => 'PORTAL_NAV_NAME_EMPTY',
        'sign.max' => 'PORTAL_NAV_SIGN_LENGTH_ERROR',
        'sort.number' => 'PORTAL_NAV_SORT_TYPE_ERROR',
        'remark.max' => 'PORTAL_NAV_REMARK_LENGTH_ERROR',
    ];

    protected function sceneCreate() {
        return $this->remove('uniqid', 'require');
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\PortalNav::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}