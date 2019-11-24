<?php

namespace app\village_api\controller\basis\link;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\BasisLink;

class Link extends eVillageApi {
    private $model;

    protected function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new BasisLink();
    }

    /**
     * 创建友情链接
     * @param $data
     */
    protected function create($data) {
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            unset($saveData['create_time']);
            unset($saveData['update_time']);
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 获取友情链接
     * @param $where
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function read($where) {
        if (input('param.page')) {
            $data = BasisLink::getList($where);
        } else {
            $data = BasisLink::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }

    /**
     * 删除友情链接
     * @param $uniqid
     */
    protected function delete($uniqid) {
        try {
            BasisLink::destroy($uniqid);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改友情链接
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
}