<?php
/**
 * User: xibing
 * Date: 2019/6/5
 * Time: 10:51
 */

namespace app\village_api\controller\user;
class Info extends User {

    public function index() {
        parent::_checkToken(function ($data) {
            $userData = cache('userInfo-' . $data['account']);
            $this->ajaxReturn(200, array_filter($userData));
        });
    }
}