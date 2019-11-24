<?php


namespace app\village_api\controller\portal\nav;
use app\village_api\model\PortalArticleData;
use app\village_api\validate\PortalNav;
use think\exception\ValidateException;

class Delete extends Nav {
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
            validate(PortalNav::class)->scene('delete')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index(){
        $this->dataValidate(input('delete.'));
        $uniqid=input('delete.uniqid');
        parent::delete($uniqid);
    }
}