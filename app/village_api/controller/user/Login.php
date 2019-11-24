<?php
/**
 * User: xiebing
 * Date: 2019-5-29
 * Time: 17:55
 */

namespace app\village_api\controller\user;

use app\village_api\model\LogUserLogin;
use app\village_api\model\UserAccount;
use app\village_api\model\UserAuth;
use app\village_api\model\UserListView;
use think\exception\ValidateException;

class Login extends User {

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
            $this->validate($data, array(
                'account' => 'require',
                'password' => 'require'
            ), array(
                'account.require' => lang('LOGIN_ACCOUNT_EMPTY'),
                'password.require' => lang('LOGIN_PASSWORD_EMPTY'),
            ));
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    /**
     * 执行登录操作
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index() {
        $param = input('post.');
        $this->dataValidate($param);
        $loginTime = date('Y-m-d H:i:s', time());
        $userLogin = UserAccount::scope('login', $param['account'])->find();
        if (empty($userLogin)) {
            $this->ajaxReturn(400, lang("LOGIN_USER_EMPTY"));
        } else {
            $userLogin = $userLogin->toArray();
        }

        //判断登录类型下的禁止登录
        if (preg_match('/^0?1[3|4|5|6|7|8][0-9]\d{8}$/', $param['account'])) {
            if ($userLogin['is_mobile'] != 'yes') {
                $this->ajaxReturn(400, lang('LOGIN_PROHIBIT_MOBILE'));
            }
        } else {
            if ($userLogin['is_login'] != 'yes') {
                $this->ajaxReturn(400, lang('LOGIN_PROHIBIT_ACCOUNT'));
            }
        }
        //验证密码
        $userPassword = $this->set_password($param['account'], $param['password'], $userLogin['userkey']);
        if ($userPassword !== $userLogin['password']) {
            $this->ajaxReturn(400, lang('LOGIN_PASSWORD_ERROR'));
        }
        //获取用户信息(如果信息为空则是内置超级管理员，否则是后期管理员)
        $userInfo = UserListView::getFind(array(
            'account' => $userLogin['account'],
            'uniqid' => $userLogin['uniqid']
        ));
        UserAccount::setLoginCount(['uniqid' => $userLogin['uniqid']]);
        if (empty($userInfo)) {
            unset($userLogin['password']);
            unset($userLogin['userkey']);
            $userLogin['login_time'] = $loginTime;
            $userLogin['is_manage'] = true;
            cache('userInfo-' . $param['account'], $userLogin);
            $this->log($userLogin['uniqid'], $loginTime);
            $this->ajaxReturn(200, array(
                'is_manage' => true,
                'user_info' => array_filter($userLogin),
                'access_token' => $this->set_token(array(
                    'appid' => $param['appid'],
                    'uniqid' => $userLogin['uniqid'],
                    'account' => $userLogin['account']
                ), $userLogin['uniqid'])
            ));
        } else {
            //查询权限
            $userAuth = UserAuth::getAuth($userLogin['uniqid']);
            if (empty($userAuth)) {
                $this->ajaxReturn(400, lang('UNAUTHORIZED_ACCESS'));
            } else {
                cache('userAuth-' . $param['account'], $userAuth);
            }
            $userInfo['login_time'] = $loginTime;
            cache('userInfo-' . $param['account'], $userInfo);
            $this->log($userInfo['uniqid'], $loginTime);
            $this->ajaxReturn(200, array(
                'user_info' => array_filter($userInfo),
                'user_auth' => $userAuth,
                'access_token' => $this->set_token(array(
                    'appid' => $param['appid'],
                    'uniqid' => $userInfo['uniqid'],
                    'account' => $userInfo['account']
                ), $userInfo['uniqid'])
            ));
        }
    }

    /**
     * 退出系统
     */
    public function logout() {
        parent::_checkToken(function ($data, $access_token) {
            $userData = cache('userInfo-' . $data['account']);
            $where[] = ['userid', '=', $userData['uniqid']];
            $where[] = ['login_time', '=', strtotime($userData['login_time'])];
            LogUserLogin::where($where)->data(['exit_time' => time()])->save();
            cache('userInfo-' . $data['account'], null);
            cache(md5(strtoupper($access_token)), null);
            $this->ajaxReturn(200);
        });
    }
}