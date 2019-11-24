<?php


namespace app\village_api\controller\portal\notice;

use app\village_api\validate\PortalNav;
use app\village_api\validate\PortalNotice;
use think\exception\ValidateException;

class Update extends Notice {
    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @return array|string|true
     */
    protected function dataValidate($data = array(), $scene = "create") {
        try {
            validate(PortalNotice::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        $this->dataValidate($param);
        parent::update($param['uniqid'], $param);
    }

    public function releases() {
        $param = input('put.');
        $this->dataValidate($param, 'release');
        parent::release($param['uniqid'], !empty($param['release'])?$param['release']:1);
    }
}