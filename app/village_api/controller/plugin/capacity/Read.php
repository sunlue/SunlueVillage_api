<?php


namespace app\village_api\controller\plugin\capacity;


use app\village_api\model\PluginCapacity;

class Read extends capacity {
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
        if (!empty($param['start'])) {
            $where[] = ['date', '>=', strtotime($param['start'])];
        }
        if (!empty($param['end'])) {
            $where[] = ['date', '<=', strtotime($param['end'])];
        }
        if ($callback instanceof \Closure) {
            $callback($where);
        } else {
            return $where;
        }
    }

    public function index(){
        $params=input('get.');
        $where = $this->searchWhere($params);
        $data=PluginCapacity::getAll($where);
        $this->ajaxReturn(200,$data);
    }
}