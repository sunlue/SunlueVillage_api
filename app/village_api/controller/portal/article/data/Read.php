<?php


namespace app\village_api\controller\portal\article\data;

use app\village_api\model\PortalArticleData;

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
            if (is_array($param['type'])) {
                $where[] = ['type', 'in', $param['type']];
            } else {
                $where[] = ['type', '=', $param['type']];
            }
        }
        if (!empty($param['title'])) {
            $where[] = ['title', 'like', '%' . $param['title'] . '%'];
        }
        if (!empty($param['uniqid'])) {
            $where[] = ['uniqid', '=', $param['uniqid']];
        }
        if (!empty($param['village_id'])) {
            $where[] = ['village_id', '=', $param['village_id']];
        }
        if (!empty($param['hot'])) {
            $where[] = ['hot', '=', $param['hot']];
        }
        if (!empty($param['is_top'])) {
            $where[] = ['is_top', '=', $param['is_top']];
        }
        if (!empty($param['recommended'])) {
            $where[] = ['recommended', '=', $param['recommended']];
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

    public function details() {
        $uniqid = input('get.uniqid');
        if (empty($uniqid)) {
            $this->ajaxReturn(400, lang('UNIQID_EMPTY'));
        }
        $data = PortalArticleData::getFind(['uniqid' => $uniqid]);
        $data['prev']=PortalArticleData::getPrev($data['id']);
        $data['next']=PortalArticleData::getNext($data['id']);
        $this->ajaxReturn(200, $data);
    }
}




