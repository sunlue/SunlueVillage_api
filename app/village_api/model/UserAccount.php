<?php
/**
 * User: xiebing
 * Date: 2019/6/4
 * Time: 15:58
 */

namespace app\village_api\model;

use app\village_api\common\model\Common;
use crypt\Base;
use think\Model;

class UserAccount extends Common {

    protected $pk = 'uniqid';

    protected $schema = [
        'uniqid' => 'char',
        'account' => 'char',
        'password' => 'string',
        'userkey' => 'string',
        'mobile' => 'char',
        'is_login' => 'enum',
        'is_mobile' => 'enum',
        'login_count' => 'integer',
        'create_time' => 'integer',
        'update_time' => 'integer',
        'delete_time' => 'integer',
    ];

    protected $field = [
        'uniqid',
        'account',
        'password',
        'userkey',
        'mobile',
        'is_login',
        'is_mobile',
        'login_count',
        'create_time',
        'update_time',
        'delete_time',
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('user-account-'));
        $userkey = strtoupper(Base::encrypt(uniqid($model->account)));
        $userPassword = empty($model->password) ? '123456' : $model->password;
        $arr = array_filter(array($model->account, $userPassword, $userkey));
        ksort($arr);
        $password = strtoupper(md5(urldecode(http_build_query($arr))));
        $model->setAttrs(array(
            'uniqid' => $uniqid,
            'userkey' => $userkey,
            'password' => $password,
        ));
    }

    /**
     * 用户登录
     * @param $query
     * @param $account
     */
    public function scopeLogin($query, $account) {
        $query->where('account|mobile', '=', $account)->field('uniqid,account,mobile,password,userkey,is_login,is_mobile');
    }

    /**
     * 账号检测
     * @param array $where
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function checkAccount($where = array()) {
        $data = UserAccount::where($where)->find();
        return $data ? $data->toArray() : [];
    }

    /**
     * 获取所有用户
     * @param array $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAll($where = array()) {
        return UserAccount::where($where)->select()->toArray();
    }

    /**
     * 设置登录次数
     * @param array $where
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function setLoginCount($where = array()) {
        UserAccount::where($where)->inc('login_count')->update();
    }

    /**
     * 获取单条用户数据
     * @param array $where
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFind($where = array()) {
        return UserAccount::where($where)->find()->toArray();
    }
}