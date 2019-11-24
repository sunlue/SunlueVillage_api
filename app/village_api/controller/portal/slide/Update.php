<?php


namespace app\village_api\controller\portal\slide;
use app\village_api\validate\PortalSlide;
use think\exception\ValidateException;

class Update extends Slide {
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
            validate(PortalSlide::class)->scene('update')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        $this->dataValidate($param);
        parent::updateNav($param['uniqid'],$param);
    }
}