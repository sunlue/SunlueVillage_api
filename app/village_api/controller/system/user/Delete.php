<?php
/**
 * User: xiebing
 * Date: 2019-6-17
 * Time: 15:38
 */

namespace app\village_api\controller\system\user;
use app\village_api\validate\UserInfo;
use think\exception\ValidateException;

class Delete extends User {
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
            validate(UserInfo::class)->scene('delete')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $this->dataValidate(input('delete.'));
        $uniqid=input('delete.uniqid');
        parent::delete($uniqid);
    }
}