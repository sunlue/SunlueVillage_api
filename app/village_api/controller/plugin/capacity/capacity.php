<?php
namespace app\village_api\controller\plugin\capacity;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PluginCapacity;

class capacity extends eVillageApi {
    private $model;
    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model=new PluginCapacity();
    }
    protected function submit($data){
        try{
            $this->model->replace()->save($data);
            $this->ajaxReturn(200,$data);
        }catch (\exception $e){
            $this->ajaxReturn(400,$e->getMessage());
        }
    }
}