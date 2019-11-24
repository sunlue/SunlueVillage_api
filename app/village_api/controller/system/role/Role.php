<?php
/**
 * User: xiebing
 * Date: 2019-6-14
 * Time: 15:31
 */

namespace app\village_api\controller\system\role;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\UserRole;
use app\village_api\common\controller\eByte;

class Role extends eVillageApi {

    private $model;

    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new UserRole();
    }

    /**
     * 创建用户角色
     * @param array $data
     */
    protected function create($data = array()) {
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            unset($saveData['delete_time']);
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 更新数据
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid, $data) {
        try {
            unset($data['uniqid']);
            $this->model->where('uniqid', $uniqid)->update($data);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 数据授权
     * @param $uniqid
     * @param $rights
     */
    protected function setRights($uniqid, $rights) {
        try {
            $this->model->update(['rights' => $rights], ['uniqid' => $uniqid]);
            $this->ajaxReturn(200, $rights);
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
            $data = UserRole::getList($where);
        } else {
            $data = UserRole::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }

    /**
     * 删除数据
     * @param $uniqid
     */
    protected function delete($uniqid) {
        try {
            $this->model->destroy($uniqid);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}

