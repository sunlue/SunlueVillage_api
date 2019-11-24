<?php
/**
 * User: xiebing
 * Date: 2019-6-14
 * Time: 15:31
 */

namespace app\village_api\controller\system\user;

use app\village_api\validate\UserAccount;
use think\exception\ValidateException;

class Reset extends User {
    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @param string $scene
     */
    protected function dataValidate($data = array()) {
        try {
            validate(UserAccount::class)->scene('resetPwd')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('param.');
        $this->dataValidate($param);
        parent::resetPassword($param['userid'], $param);
    }

}