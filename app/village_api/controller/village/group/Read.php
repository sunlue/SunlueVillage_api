<?php

namespace app\village_api\controller\village\group;

use app\village_api\model\VillageGroup;

class Read extends Group {
    public function initialize() {
        parent::_init();
    }

    public function index() {
        $param = input('get.');
        $where = [];
        if (!empty($param['name'])) {
            $where[] = ['name', 'like', '%' . $param['name'] . '%'];
        }
        if (input('param.page')) {
            $data = VillageGroup::getList($where);
        } else {
            $data = VillageGroup::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }

    public function details() {
        $uniqid = input('get.uniqid');
        $village_id = input('get.village_id');
        if (empty($uniqid) && empty($village_id)) {
            $this->ajaxReturn('400', '唯一识别号错误');
        }
        $where = [];
        if (!empty($uniqid)) {
            $where[] = ['uniqid', '=', $uniqid];
        }
        if (!empty($village_id)) {
            $where[] = ['village_id', '=', $village_id];
        }
        $data = VillageGroup::getFind($where);
        $this->ajaxReturn(200, $data);
    }
}