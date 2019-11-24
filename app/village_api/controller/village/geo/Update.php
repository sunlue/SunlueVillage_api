<?php

namespace app\village_api\controller\village\geo;

use app\village_api\model\CommonRegion;
use app\village_api\validate\VillageGeo;
use think\exception\ValidateException;

class Update extends Geo {
    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @param string $scene
     * @return array|string|true
     */
    protected function dataValidate($data = array(), $scene = 'update') {
        try {
            validate(VillageGeo::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        if (isset($param['field']) && isset($param['value'])) {
            $this->dataValidate($param, 'field');
            parent::updateField($param['uniqid'], $param['field'], $param['value']);
        } else {
            $this->dataValidate($param);
            parent::update($param['uniqid'], $param);
        }
    }

}