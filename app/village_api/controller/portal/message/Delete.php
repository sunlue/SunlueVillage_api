<?php


namespace app\village_api\controller\portal\message;
use app\village_api\model\PortalArticleData;
use app\village_api\validate\PortalNav;
use app\village_api\validate\PortalNotice;
use think\exception\ValidateException;

class Delete extends Message {
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
            validate(PortalNotice::class)->scene('delete')->check($data);
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