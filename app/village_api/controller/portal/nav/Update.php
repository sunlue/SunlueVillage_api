<?php


namespace app\village_api\controller\portal\nav;
use app\village_api\validate\PortalNav;
use think\exception\ValidateException;

class Update extends Nav {
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
            validate(PortalNav::class)->scene('update')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        $this->dataValidate($param);
        parent::update($param['uniqid'],$param);
    }
}