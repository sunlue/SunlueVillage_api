<?php

namespace app\village_api\controller\village\scenic;

use app\village_api\validate\VillageScenic;
use think\exception\ValidateException;

class Create extends Scenic {
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
            validate(VillageScenic::class)->scene('create')->check($data);
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