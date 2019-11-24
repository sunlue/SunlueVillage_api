<?php
/**
 * User: xiebing
 * Date: 2019-6-14
 * Time: 15:31
 */

namespace app\village_api\controller\portal\nav;

use app\village_api\validate\PortalNav;
use think\exception\ValidateException;

class Create extends Nav {
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
            validate(PortalNav::class)->scene('create')->check($data);
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