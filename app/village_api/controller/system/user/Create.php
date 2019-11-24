<?php


namespace app\village_api\controller\system\user;


use app\village_api\validate\UserAccount;
use app\village_api\validate\UserInfo;
use think\exception\ValidateException;

class Create extends User {

    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @return array|string|true
     */
    protected function dataValidate($data = array()) {
        try {
            validate(UserAccount::class)->scene('create')->check($data);
            validate(UserInfo::class)->scene('create')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('post.');
        $this->dataValidate($param);
        $checkAccount = \app\village_api\model\UserAccount::checkAccount(array(
            'account' => $param['account']
        ));
        if (!empty($checkAccount)) {
            $this->ajaxReturn(400, lang('USER_ACCOUNT_ALREADY_EXIST'));
        }
        if (!empty($param['mobile'])){
            $checkMobile = \app\village_api\model\UserAccount::checkAccount(array(
                'mobile' => $param['mobile']
            ));
            if (!empty($checkMobile)) {
                $this->ajaxReturn(400, lang('USER_MOBILE_ALREADY_EXIST'));
            }
        }
        parent::create($param);
    }
}