<?php
/**
 * User: xiebing
 * Date: 2019-6-14
 * Time: 15:31
 */

namespace app\village_api\controller\system\role;

use app\village_api\validate\UserRole;
use think\exception\ValidateException;

class Update extends Role {
    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @param string $scene
     */
    protected function dataValidate($data = array(), $scene = 'update') {
        try {
            validate(UserRole::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        $this->dataValidate($param);
        parent::update($param['uniqid'], $param);
    }

    public function rights() {
        $param = input('put.');
        $this->dataValidate($param, 'rights');
        if (!isset($param['rights'])) {
            $this->ajaxReturn(400, lang('USER_ROLE_RIGHTS_ERROR'));
        }
        parent::setRights($param['uniqid'], $param['rights']);
    }
}