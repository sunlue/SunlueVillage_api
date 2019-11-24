<?php

namespace app\village_api\controller\village\relics;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\VillageRelics;

class Relics extends eVillageApi {
    private $model;

    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new VillageRelics();
    }

    public function create($data) {
        try {
            unset($data['id']);
            unset($data['create_time']);
            unset($data['update_time']);
            $this->model->replace()->save($data);
            $saveData = $this->model->getData();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
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

    /**
     * 修改数据
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid, $data) {
        try {
            unset($data['id']);
            unset($data['uniqid']);
            unset($data['create_time']);
            unset($data['update_time']);
            $field = array_column($this->model->getFields(), 'name');
            $data = array_filter($data, function ($item, $key) use ($field) {
                return !in_array($key, $field) ? [] : array($key => $item);
            }, ARRAY_FILTER_USE_BOTH);
            $this->model->where('uniqid', $uniqid)->data($data)->update();
            $data['uniqid']=$uniqid;
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改数据字段
     * @param $uniqid
     * @param $field
     * @param $value
     */
    protected function updateField($uniqid, $field, $value) {
        try {
            $this->model->where('uniqid', $uniqid)->data(array(
                $field => $value
            ))->update();
            $this->ajaxReturn(200, array(
                $field => $value
            ));
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}