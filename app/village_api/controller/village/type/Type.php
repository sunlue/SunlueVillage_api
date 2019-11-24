<?php

namespace app\village_api\controller\village\type;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\VillageType;

class Type extends eVillageApi {

    private $model;
    protected function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model=new VillageType();
    }

    /**
     * 创建文章类型
     * @param array $data
     */
    protected function create($data = array()) {
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 删除文章类型
     * @param $uniqid
     */
    protected function delete($uniqid){
        try{
            $this->model->destroy($uniqid);
            $this->ajaxReturn(200);
        }catch (\exception $e){
            $this->ajaxReturn(400,$e->getMessage());
        }
    }

    /**
     * 修改文章类型
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid,$data){
        try {
            unset($data['uniqid']);
            $this->model->where('uniqid',$uniqid)->update($data);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 获取文章类型
     * @param $where
     */
    protected function read($where){
        if (input('param.page')) {
            $data = VillageType::getList($where);
        } else {
            $data = VillageType::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}