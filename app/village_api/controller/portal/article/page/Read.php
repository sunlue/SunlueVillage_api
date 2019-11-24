<?php


namespace app\village_api\controller\portal\article\page;

class Read extends Data {
    public function initialize() {
        parent::_init();
    }

    /**
     * 查询数据
     * @param array $param
     * @param string $callback
     */
    protected function searchWhere($param = array(), $callback = '') {
        $where = array();
        if (!empty($param['type'])) {
            if (is_array($param['type'])){
                $where[] = ['type', 'in', $param['type']];
            }else{
                $where[] = ['type', '=', $param['type']];
            }
        }
        if (!empty($param['title'])) {
            $where[] = ['title', 'like', '%' . $param['title'] . '%'];
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