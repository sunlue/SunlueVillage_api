<?php

namespace app\village_api\controller\system\user;

use app\village_api\model\UserAuth;

class Auth extends User {
    public function initialize() {
        parent::_init();
    }

    public function index() {
        $param = input('put.');
        $validate = \think\facade\Validate::rule(array(
            'roles' => 'require|array',
            'user' => 'require'
        ))->message(array(
            'roles.require' => 'USER_AUTH_ROLE_EMPTY',
            'roles.array' => 'USER_AUTH_ROLE_FORMAT_ERROR',
            'user.require' => 'USER_AUTH_LIST_EMPTY'
        ));
        if (!$validate->check($param)) {
            $this->ajaxReturn(400, $validate->getError());
        }
        $data = array_map(function ($role) use ($param) {
            return array(
                'role' => $role,
                'user_id' => $param['user']
            );
        }, $param['roles']);
        $model = new UserAuth();
        try {
            $model->saveAll($data);
            $saveData = $model->getData();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    public function deletes(){
        $param=input('delete.');
        $validate = \think\facade\Validate::rule(array(
            'authid' => 'requireWithout:user,role',
            'user' => 'requireWithout:authid',
            'role'=>'requireWithout:authid'
        ))->message(array(
            'authid.requireWithout' => 'USER_AUTH_PARAMS_ERROR',
            'user.requireWithout' => 'USER_AUTH_PARAMS_ERROR',
            'role.requireWithout' => 'USER_AUTH_PARAMS_ERROR'
        ));
        if (!$validate->check($param)) {
            $this->ajaxReturn(400, $validate->getError());
        }
        $model = new UserAuth();
        try {
            if (!empty($param['authid'])){
                $model->destroy($param['authid'],true);
            }else{
                $model->destroy(array(
                    'user_id'=>$param['user'],
                    'role'=>$param['role']
                ));
            }
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}