<?php

namespace app\village_api\controller\system\log;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\LogUserLogin;
use think\facade\Env;

class Login extends eVillageApi {

    public function initialize() {
        parent::_init();
    }

    public function index() {
        if (!Env::get('app_debug')) {
            parent::_checkToken(function ($data) {
                $userData = cache('userInfo-' . $data['account']);
                $data = LogUserLogin::getList($userData['is_manage']);
                $this->ajaxReturn(200, $data);
            });
        } else {
            $data = LogUserLogin::getList(true);
            $this->ajaxReturn(200, $data);
        }
    }

}