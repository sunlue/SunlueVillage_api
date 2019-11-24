<?php
/**
 * User: xiebing
 * Date: 2019-6-14
 * Time: 15:31
 */

namespace app\village_api\controller\system\user;

use app\village_api\validate\UserInfo;
use think\exception\ValidateException;

class Update extends User {
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
            validate(UserInfo::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        if (isset($param['field']) && isset($param['value'])) {
            $this->dataValidate($param, 'field');
            parent::updateField($param['uniqid'],$param['userid'], $param['field'], $param['value']);
        } else {
            $this->dataValidate($param);
            parent::update($param['uniqid'], $param);
        }
    }
}