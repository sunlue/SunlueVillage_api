<?php

namespace app\village_api\controller\common\nation;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\CommonNation;
use app\village_api\model\CommonRegion;

class Read extends eVillageApi {

    private $commonNationModel;

    public function initialize() {
        parent::_init();
        $this->commonNationModel = new CommonNation();
    }

    /**
     * 获取地区数据   list：列表，tree:树形
     */
    public function index() {
        $where = [];
        $label = input('get.label', '');
        if (!empty($label)) {
            $where[] = ['label', 'like', '%'.$label.'%'];
        }
        $data = $this->commonNationModel->getAll($where);
        $this->ajaxReturn(200, $data);
    }

}









