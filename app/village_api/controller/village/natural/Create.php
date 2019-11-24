<?php

namespace app\village_api\controller\village\natural;

use app\village_api\validate\VillageNatural;
use think\exception\ValidateException;

class Create extends Natural {
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
            validate(VillageNatural::class)->scene('create')->check($data);
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