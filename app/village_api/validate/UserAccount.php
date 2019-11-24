<?php

namespace app\village_api\validate;

use think\Validate;

class UserAccount extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'userid' => 'require',
        'account' => 'require',
        'old_pwd' => 'require',
        'password' => 'min:6',
        'passwords' => 'confirm:password',
        'mobile' => 'mobile',
        'is_login' => 'accepted',
        'is_mobile' => 'accepted'
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'userid.require' => 'UNIQID_EMPTY',
        'account.require' => 'USER_ACCOUNT_EMPTY',
        'old_pwd.require' => 'USER_OLD_PWD_EMPTY',
        'password.min' => 'USER_PASSWORD_LENGTH_ERROR',
        'passwords.confirm' => 'USER_PASSWORD_DISAFFINITY',
        'mobile.mobile' => 'MOBILE_FORMAT_ERROR',
        'is_login.accepted' => 'USER_ACCEPTED_ERROR',
        'is_mobile.accepted' => 'USER_ACCEPTED_ERROR',
    ];

    protected function sceneCreate() {
        return $this->only(['account']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneResetPwd() {
        return $this->only(['userid', 'account', 'password', 'passwords']);
    }

    protected function sceneUpdatePwd() {
        return $this->only(['uniqid', 'account','old_pwd', 'password', 'passwords']);
    }

    protected function uniques($value) {
        return \app\village_api\model\UserAccount::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }

}