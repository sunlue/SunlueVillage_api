<?php

namespace app\village_api\validate;

use think\Validate;

class PortalNotice extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'title' => 'require',
        'content' => 'require',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'title.require' => 'PORTAL_NOTICE_NAME_EMPTY',
        'content.require' => 'PORTAL_NOTICE_CONTENT_EMPTY',
    ];

    protected function sceneCreate() {
        return $this->remove('uniqid', 'require');
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneRelease() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\PortalNotice::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}