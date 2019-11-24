<?php

namespace app\village_api\model;

use think\Model;

class LogUserLogin extends Model {
    protected $pk = 'uniqid';


    public static function onBeforeInsert(Model $model) {
        $model->setAttrs(array(
            'uniqid' => strtoupper(uniqid('log-login-')),
            'exit_time' => 0,
            'ip' => request()->ip()
        ));
    }

    public function setLoginTimeAttr($value) {
        return strtotime($value);
    }

    public function getLoginTimeAttr($value) {
        return date('Y-m-d H:i:s', $value);
    }

    public function getExitTimeAttr($value) {
        return $value > 0 ? date('Y-m-d H:i:s', $value) : '';
    }

    public static function getList($isManage = false) {
        $sql = LogUserLogin::alias('a')
            ->field('a.uniqid,c.uniqid as userid,a.ip,a.login_time,a.exit_time,
            IFNULL(b.name, \'\') as name,IFNULL(b.nickname,\'\') as nickname,
            c.account,c.mobile')
            ->join('user_info b', 'a.userid=b.uniqid', 'left')
            ->join('user_account c','a.userid=c.uniqid','left');
        if (!$isManage) {
            $sql->whereNotLike('a.userid', 'USER-ADMIN%');
        }
        $data = $sql->paginate(input('get.limit'))->each(function ($item) {
            $item['date_diff']=datetime_diff($item['login_time'],$item['exit_time']);
            return $item;
        });
        return $data ? $data->toArray() : [];
    }



}