<?php
/**
 * User: xiebing
 * Date: 2019-6-20
 * Time: 10:54
 */

namespace app\village_api\controller\oauth;

use app\village_api\controller\user\User;
use app\village_api\common\controller\eVillageApi;
use think\exception\ValidateException;

class Auth extends eVillageApi {

    public function initialize() {
        parent::_init();
    }

    public function index() {
        $param = input('get.');
        $this->dataValidate($param);
    }

    public function refresh() {
        parent::_refreshToken(function ($token_data) {
            $token = User::set_token($token_data, $token_data['uniqid']);
            $this->ajaxReturn(200, array('access_token' => $token));
        });
    }
}
























