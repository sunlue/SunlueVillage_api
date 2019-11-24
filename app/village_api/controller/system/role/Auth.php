<?php

namespace app\village_api\controller\system\role;

use app\village_api\model\UserAuth;

class Auth extends Role {
    public function initialize() {
        parent::_init();
    }

    protected function dataValidate($data) {
        $validate = \think\facade\Validate::rule(array(
            'role' => 'require',
            'users' => 'require|array'
        ))->message(array(
            'role.require' => 'USER_AUTH_ROLE_EMPTY',
            'users.require' => 'USER_AUTH_LIST_EMPTY',
            'users.array' => 'USER_AUTH_LIST_FORMAT_ERROR'
        ));
        if (!$validate->check($data)) {
            $this->ajaxReturn(400, $validate->getError());
        }
    }

    public function index() {
        $param = input('put.');
        $this->dataValidate($param);
        $model = new UserAuth();
        $data = array_map(function ($user) use ($param,$model) {
            $role=array(
                'role' => $param['role'],
                'userid' => $user
            );
            return $model->getFind($role)?[]:$role;
        }, $param['users']);
        $data=array_filter($data);
        sort($data);
        try {
            $saveData=$model->saveAll($data);
            $this->ajaxReturn(200, $saveData->toArray());
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}