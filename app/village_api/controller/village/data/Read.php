<?php

namespace app\village_api\controller\village\data;

use app\village_api\model\VillageData;

class Read extends Village {
    public function initialize() {
        parent::_init();
    }

    public function index() {
        $param = input('get.');
        $where = [];
        if (!empty($param['name'])) {
            $where[] = ['name', 'like', '%' . $param['name'] . '%'];
        }
        if (!empty($param['attr'])) {
            $where[] = ['attr', '=', $param['attr']];
        }
        if (!empty($param['hot'])) {
            $where[] = ['hot', '=', $param['hot']];
        }
        if (!empty($param['is_top'])) {
            $where[] = ['is_top', '=', $param['is_top']];
        }
        if (!empty($param['recommended'])) {
            $where[] = ['recommended', '=', $param['recommended']];
        }
        if (input('param.page')) {
            $data = VillageData::getList($where);
        } else {
            $data = VillageData::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }

    public function details() {
        $uniqid = input('get.uniqid');
        if(empty($uniqid)){
            $this->ajaxReturn(400,lang('UNIQID_EMPTY'));
        }
        $data = VillageData::getFind(['uniqid' => $uniqid]);
        $this->ajaxReturn(200, $data);
    }
}