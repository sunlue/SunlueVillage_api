<?php

namespace app\village_api\validate;

use think\Validate;

class PortalSlide extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'name' => 'require',
        'image' => 'require',
        'sign' => 'max:100',
        'sort' => 'number',
        'remark' => 'max:255',
        'link' => 'url',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'name.require' => 'PORTAL_SLIDE_NAME_EMPTY',
        'image.require' => 'PORTAL_SLIDE_IMAGE_EMPTY',
        'sign.max' => 'PORTAL_SLIDE_SIGN_LENGTH_ERROR',
        'sort.number' => 'PORTAL_SLIDE_SORT_TYPE_ERROR',
        'remark.max' => 'PORTAL_SLIDE_REMARK_LENGTH_ERROR',
        'link.url' => 'PORTAL_SLIDE_LINK_URL_ERROR',
    ];

    protected function sceneCreate() {
        return $this->remove('uniqid', 'require');
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\PortalSlide::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}