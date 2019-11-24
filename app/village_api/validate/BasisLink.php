<?php

namespace app\village_api\validate;

use think\Validate;

class BasisLink extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'name' => 'require',
        'link' => 'require|url',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'name.require' => 'BASIS_LINK_NAME_EMPTY',
        'link.require' => 'BASIS_LINK_LINK_EMPTY',
        'link.url' => 'BASIS_LINK_LINK_URL_ERROR',
    ];

    protected function sceneCreate() {
        return $this->remove('uniqid', 'require');
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\BasisLink::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}