<?php

namespace app\village_api\controller\basis\site;

use app\village_api\validate\BasisSite;
use think\exception\ValidateException;

class Submit extends Site {
    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @param string $scene
     */
    protected function dataValidate($data = array(),$scene='submit') {
        try {
            validate(BasisSite::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('post.');
        $this->dataValidate($param);
        $this->dataValidate($param['content'],$param['type']);
        parent::submit($param);
    }

}







