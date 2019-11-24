<?php

namespace app\village_api\controller\village\geo;
use app\village_api\model\VillageGeo;

class Read extends Geo {
    public function initialize() {
        parent::_init();
    }

    public function index() {
        $param = input('get.');
        $where = [];
        if (!empty($param['name'])) {
            $where[] = ['name', 'like', '%' . $param['name'] . '%'];
        }
        if (!empty($param['type'])) {
            $where[] = ['type', '=', $param['type']];
        }
        $data = VillageGeo::getList($where);
        $this->ajaxReturn(200, $data);
    }

    public function details() {
        $uniqid = input('get.uniqid');
        $village_id = input('get.village_id');
        if (empty($uniqid) && empty($village_id)){
            $this->ajaxReturn('400','唯一识别号错误');
        }
        if (!empty($uniqid)){
            $where[]=['uniqid','=',$uniqid];
        }
        if (!empty($village_id)){
            $where[]=['village_id','=',$village_id];
        }
        $data = VillageGeo::getFind($where);
        $this->ajaxReturn(200, $data);
    }
}