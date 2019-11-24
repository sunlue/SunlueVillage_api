<?php


namespace app\village_api\controller\portal\article\data;

use app\village_api\validate\ArticleData;
use think\exception\ValidateException;

class Update extends Data {
    public function initialize() {
        parent::_init();
    }

    /**
     * 提交数据验证
     * @param array $data
     * @param string $scene
     * @return array|string|true
     */
    protected function dataValidate($data = array(), $scene = 'update') {
        try {
            validate(ArticleData::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('put.');
        if (isset($param['field']) && isset($param['value'])) {
            $this->dataValidate($param, 'field');
            parent::updateAericleField($param['uniqid'], $param['field'], $param['value']);
        } else {
            $this->dataValidate($param);
            parent::update($param['uniqid'], $param);
        }
    }

    public function like(){
        $param = input('put.');
        $this->dataValidate($param,'like');
        parent::setLike($param['uniqid']);
    }

}