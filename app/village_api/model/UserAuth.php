<?php

namespace app\village_api\model;

use think\Model;

class UserAuth extends Model {
    protected $pk = 'uniqid';
    protected $createTime = false;
    protected $updateTime = false;

    protected $schema = [
        'uniqid' => 'string',
        'userid' => 'string',
        'rights' => 'string',
        'role' => 'string',
    ];
    protected $field = [
        'uniqid',
        'userid',
        'rights',
        'role'
    ];

    public static function onBeforeInsert(Model $model) {
        $uniqid = strtoupper(uniqid('user-auth-'));
        $model->setAttr('uniqid', $uniqid);
    }

    public static function getAuth($userid) {
        $data = UserAuth::field('name,role,user_role.rights as role_rights,user_auth.rights as user_rights')
            ->json(['role_rights'], true)
            ->where('userid', $userid)
            ->join('user_role', 'user_auth.role=user_role.uniqid', 'left')
            ->select()->each(function ($item) {
                $roleAuth = [];
                if (isset($item->role_rights)) {
                    foreach ($item->role_rights as $role_rights) {
                        $roleAuth[] = $role_rights;
                    }
                }
                $userAuth = [];
                if (!empty($item->user_rights)) {
                    $userAuth[] = $item->user_rights;
                }
                $item->rights = array_merge($roleAuth, $userAuth);
                unset($item->role_rights);
                unset($item->user_rights);
            });
        $userAuthScattered = array_column($data->toArray(), 'rights');
        $userAuth = [];
        foreach ($userAuthScattered as $scattered) {
            foreach ($scattered as $collection) {
                $userAuth[] = $collection;
            }
        }
        return array_unique(array_filter($userAuth));
    }

    public function getFind($where=array()){
        return UserAuth::where($where)->find();

    }

}









