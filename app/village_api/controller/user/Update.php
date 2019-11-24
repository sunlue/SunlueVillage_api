<?php


namespace app\village_api\controller\user;


use app\village_api\validate\UserAccount;
use think\exception\ValidateException;

class Update extends User {

    /**
     * 提交数据验证
     * @param array $data
     * @return array|string|true
     */
    protected function dataValidate($data = array()) {
        try {
            validate(UserAccount::class)->scene('updatePwd')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function password(){
        $param = input('put.');
        $this->dataValidate($param);
        $userLogin = \app\village_api\model\UserAccount::scope('login', $param['account'])->find();
        $userPassword = $this->set_password($param['account'], $param['old_pwd'], $userLogin['userkey']);
        if ($userPassword !== $userLogin['password']) {
            $this->ajaxReturn(400, lang('USER_OLD_PWD_ERROR'));
        }
        parent::updatePassword($param['uniqid'], $param);
    }
}