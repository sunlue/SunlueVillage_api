<?php

namespace app\village_api\controller\village\slide;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\VillageSlide;

class Slide extends eVillageApi {

    private $model;

    protected function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new VillageSlide();
    }

    /**
     * 创建幻灯片
     * @param array $data
     */
    protected function createSlide($data = array()) {
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 删除幻灯片
     * @param $uniqid
     */
    protected function deleteSlide($uniqid) {
        try {
            VillageSlide::destroy($uniqid);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改幻灯片
     * @param $uniqid
     * @param $data
     */
    protected function updateSlide($uniqid, $data) {
        try {
            unset($data['uniqid']);
            $this->model->where('uniqid', $uniqid)->update($data);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 获取幻灯片
     * @param $where
     */
    protected function readSlide($where) {
        if (input('param.page')) {
            $data = VillageSlide::getList($where);
        } else {
            $data = VillageSlide::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}