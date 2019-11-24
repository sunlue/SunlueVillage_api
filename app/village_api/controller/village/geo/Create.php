<?php

namespace app\village_api\controller\village\geo;

use app\village_api\model\CommonRegion;
use app\village_api\validate\VillageGeo;
use think\exception\ValidateException;

class Create extends Geo {
    public function initialize() {
        parent::_init();
    }
    /**
     * 提交数据验证
     * @param array $data
     * @return array|string|true
     */
    protected function dataValidate($data = array()) {
        try {
            validate(VillageGeo::class)->scene('create')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('post.');
        $this->dataValidate($param);
        parent::create($param);
    }



}