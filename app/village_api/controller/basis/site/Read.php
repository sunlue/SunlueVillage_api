<?php

namespace app\village_api\controller\basis\site;

use app\village_api\validate\BasisSite;
use think\exception\ValidateException;

class Read extends Site {
    public function initialize() {
        parent::_init();
    }

    /**
     * 查询数据
     * @param array $param
     * @param string $callback
     * @return array
     */
    protected function searchWhere($param = array(), $callback = '') {
        $where = array();
        if (!empty($param['type'])) {
            $where[] = ['type', '=', $param['type']];
        }
        if ($callback instanceof \Closure) {
            $callback($where);
        } else {
            return $where;
        }
    }

    /**
     * 查询数据验证
     * @param array $data
     */
    protected function dataValidate($data = array()) {
        try {
            validate(BasisSite::class)->scene('search')->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    public function index() {
        $param = input('get.');
        $this->dataValidate($param);
        $where = $this->searchWhere($param);
        parent::read($where);
    }
}