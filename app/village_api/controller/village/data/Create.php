<?php

namespace app\village_api\controller\village\data;

use app\village_api\model\CommonRegion;
use app\village_api\validate\VillageData;
use think\exception\ValidateException;

class Create extends Village {
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
            validate(VillageData::class)->scene('create')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('post.');
        if (count($param['region']) != 5) {
            $this->ajaxReturn(400, '村落名称异常');
        }
        $regionModal = new CommonRegion();
        $regionData = $regionModal->getFind(['value' => $param['region'][4]]);
        $param['name'] = $regionData['label'];
        $param['region'] = $param['region'][4];
        $this->dataValidate($param);
        parent::create($param);
    }



}