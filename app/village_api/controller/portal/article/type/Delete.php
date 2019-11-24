<?php


namespace app\village_api\controller\portal\article\type;

use app\village_api\validate\ArticleType;
use think\exception\ValidateException;

class Delete extends Type {
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
            validate(ArticleType::class)->scene('delete')->check($data);
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