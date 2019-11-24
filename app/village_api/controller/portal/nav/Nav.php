<?php

namespace app\village_api\controller\portal\nav;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PortalNav;

class Nav extends eVillageApi {

    private $model;
    protected function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model=new PortalNav();
    }

    /**
     * 创建导航
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
     * 删除导航
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
     * 修改导航
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
     * 获取导航
     * @param $where
     */
    protected function read($where){
        if (input('param.page')) {
            $data = PortalNav::getList($where);
        } else {
            $data = PortalNav::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}