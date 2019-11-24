<?php
/**
 * User: xiebing
 * Date: 2019/6/4
 * Time: 16:35
 */

namespace app\village_api\controller\user;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\LogUserLogin;
use app\village_api\model\UserAccount;
use app\village_api\model\UserAuth;
use app\village_api\model\UserInfo;
use crypt\Base;
use think\facade\Db;

class User extends eVillageApi {

    public function initialize() {
        parent::_init();
    }

    /**
     * 生成登录密码
     * @param $account
     * @param $password
     * @param $key
     * @return string
     */
    public static function set_password($account, $password, $key) {
        $arr = array_filter(array($account, $password, $key));
        ksort($arr);
        return strtoupper(md5(urldecode(http_build_query($arr))));
    }

    /**
     * 生成key
     * @param string $key
     * @return string
     */
    public static function set_key($key = '') {
        return strtoupper(Base::encrypt(uniqid($key)));
    }

    /**
     * 生成token
     * @param array $array
     * @param $tag string
     * @return string
     */
    public static function set_token($array = array(), $tag) {
        //生成新的token
        $array['timeStamp'] = time();
        $arr = array_filter($array);
        ksort($arr);
        $token = Base::encrypt(urldecode(http_build_query($arr)));
        //清除原始token
        cache(cache('token-' . $tag), null);
        //将新token记录到原始token
        cache('token-' . $tag, md5(strtoupper($token)));
        //将心token记录到缓存中
        cache(md5(strtoupper($token)), array(
            'access_token' => $token,
            'create_time' => time()
        ));
        return $token;
    }

    /**
     * 创建用户信息
     * @param array $data
     */
    protected function create($data) {
        $accountModel = new UserAccount();
        $infoModel=new UserInfo();
        $authModel=new UserAuth();
        Db::startTrans();
        try {
            $roleGroup = $data['roles'];
            unset($data['roles']);
            $accountModel->save($data);
            $uniqid = $accountModel->uniqid;
            if (!empty($roleGroup)) {
                $roles = [];
                foreach ($roleGroup as $role) {
                    $roles[] = ['role' => $role, 'userid' => $uniqid];
                }
                $authModel->saveAll($roles);
            }
            $data['uniqid'] = $uniqid;
            $infoModel->save($data);
            $data['userid'] = $infoModel->userid;
            Db::commit();
            unset($data['password']);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改密码
     * @param $uniqid
     * @param $data
     */
    protected function updatePassword($uniqid, $data) {
        $accountModel = new UserAccount();
        try {
            $userkey = strtoupper(Base::encrypt(uniqid($data['account'])));
            $password = self::set_password($data['account'],$data['password'],$userkey);
            $accountModel->where('uniqid', $uniqid)->data(array(
                'userkey' => $userkey,
                'password' => $password
            ))->update();
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    protected function log($uniqid, $loginTime) {
        $model = new LogUserLogin();
        $model->save(array(
            'userid' => $uniqid,
            'login_time' => $loginTime
        ));
    }

}