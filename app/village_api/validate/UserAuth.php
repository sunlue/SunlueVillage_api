<?php

namespace app\village_api\validate;

use think\facade\Validate;

class UserAuth extends Validate {
    protected $rule = [
        'uniqid' => 'require',
        'user_id' => 'require',
        'role' => 'require',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'user_id.require' => 'USER_NAME_EMPTY',
        'role.require' => 'USER_ROLE_EMPTY',
    ];

    protected function sceneCreate() {
        return $this->only(['user_id']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneUpdate() {
        return $this->only(['uniqid', 'user_id']);
    }

}