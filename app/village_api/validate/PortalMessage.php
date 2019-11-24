<?php

namespace app\village_api\validate;

use think\Validate;

class PortalMessage extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'content' => 'require',
        'mobile_tel' => 'mobile',
        'address' => 'max:100',
        'email' => 'email',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'content.require' => 'PORTAL_MESSAGE_CONTENT_EMPTY',
        'mobile_tel.mobile'=>'MOBILE_FORMAT_ERROR',
        'email.email'=>'EMAIL_FORMAT_ERROR',
    ];

    protected function sceneCreate() {
        return $this->remove('uniqid', 'require');
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneReply() {
        return $this->only(['content']);
    }

    protected function uniques($value) {
        return \app\village_api\model\PortalMessage::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}