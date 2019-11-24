<?php

namespace app\village_api\controller\system\user;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\UserAccount;
use app\village_api\model\UserAuth;
use app\village_api\model\UserInfo;
use app\village_api\model\UserListView;
use crypt\Base;
use think\facade\Db;

class User extends eVillageApi {
    private $authModel;
    private $infoModel;
    private $accountModel;

    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->authModel = new UserAuth();
        $this->infoModel = new UserInfo();
        $this->accountModel = new UserAccount();
    }

    /**
     * 创建数据
     * @param $data
     */
    protected function create($data) {
        Db::startTrans();
        try {
            $roleGroup = $data['roles'];
            unset($data['roles']);
            $this->accountModel->save($data);
            $uniqid = $this->accountModel->uniqid;
            if (!empty($roleGroup)) {
                $roles = [];
                foreach ($roleGroup as $role) {
                    $roles[] = ['role' => $role, 'userid' => $uniqid];
                }
                $this->authModel->saveAll($roles);
            }
            $data['uniqid'] = $uniqid;
            $this->infoModel->save($data);
            Db::commit();
            unset($data['password']);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 删除数据
     * @param $uniqid
     */
    protected function delete($uniqid) {
        try {
            $this->infoModel->destroy($uniqid);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改数据
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid, $data) {
        unset($data['uniqid']);
        unset($data['create_time']);
        unset($data['update_time']);
        Db::startTrans();
        try {
            $field = array_column($this->infoModel->getFields(), 'name');
            $infoData = array_filter($data, function ($item, $key) use ($field) {
                return !in_array($key, $field) ? [] : array($key => $item);
            }, ARRAY_FILTER_USE_BOTH);
            $this->infoModel->where('uniqid', $uniqid)->update($infoData);
            $field = array_column($this->accountModel->getFields(), 'name');
            $accountData = array_filter($data, function ($item, $key) use ($field) {
                return !in_array($key, $field) ? [] : array($key => $item);
            }, ARRAY_FILTER_USE_BOTH);
            $this->accountModel->where('uniqid', $uniqid)->update($accountData);
            if (!empty($data['roles'])) {
                $this->authModel->where('userid',$uniqid)->delete(true);
                $roles = [];
                foreach ($data['roles'] as $role) {
                    $roles[] = [
                        'role' => $role,
                        'userid' => $uniqid
                    ];
                }
                $this->authModel->saveAll($roles);
            }
            Db::commit();
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改数据字段
     * @param $uniqid
     * @param $field
     * @param $value
     */
    protected function updateField($uniqid, $userid, $field, $value) {
        Db::startTrans();
        try {
            $fields = array_column($this->accountModel->getFields(), 'name');
            if (in_array($field, $fields)) {
                $this->accountModel->where('uniqid', $userid)->data(array(
                    $field => $value
                ))->update();
            }
            $fields = array_column($this->infoModel->getFields(), 'name');
            if (in_array($field, $fields)) {
                $this->infoModel->where('uniqid', $uniqid)->data(array(
                    $field => $value
                ))->update();
            }
            Db::commit();
            $this->ajaxReturn(200, array(
                $field => $value
            ));
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 重置密码
     * @param $uniqid
     * @param $data
     */
    protected function resetPassword($uniqid, $data) {
        try {
            $userkey = strtoupper(Base::encrypt(uniqid($data['account'])));
            $arr = array_filter(array($data['account'], $data['password'], $userkey));
            ksort($arr);
            $password = strtoupper(md5(urldecode(http_build_query($arr))));
            $this->accountModel->where('uniqid', $uniqid)->data(array(
                'userkey' => $userkey,
                'password' => $password
            ))->update();
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 获取数据
     * @param array $where
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function read($where = array()) {
        if (input('param.page')) {
            $data = UserListView::getList($where);
        } else {
            $data = UserListView::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}