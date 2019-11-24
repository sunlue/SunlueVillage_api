<?php


namespace app\village_api\controller\basis\link;


class Read extends Link {
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
        if (!empty($param['name'])) {
            $where[] = ['name', 'like', '%' . $param['name'] . '%'];
        }
        if (!empty($param['uniqid'])) {
            $where[] = ['uniqid', '=', $param['uniqid']];
        }
        if ($callback instanceof \Closure) {
            $callback($where);
        } else {
            return $where;
        }
    }

    public function index() {
        $param = input('get.');
        $where = $this->searchWhere($param);
        parent::read($where);
    }
}