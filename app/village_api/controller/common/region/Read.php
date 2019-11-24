<?php

namespace app\village_api\controller\common\region;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\CommonRegion;

class Read extends eVillageApi {

    private $commonRegionModel;

    public function initialize() {
        parent::_init();
        $this->commonRegionModel = new CommonRegion();
    }

    /**
     * 获取地区数据   list：列表，tree:树形
     */
    public function index() {
        $where = [];
        $structure = input('get.structure', 'list');
        $parent = input('get.parent', '');
        $label = input('get.label', '');
        if (!empty($parent)) {
            $where[] = ['parent', '=', $parent];
        }
        if (!empty($label)) {
            $where[] = ['label', 'like', '%'.$label.'%'];
        }
        $data = $this->commonRegionModel->getAll($where);
        if ($structure == 'tree') {
            $tmp = [];
            foreach ($data as &$row) {
                $tmp[$row['value']] = &$row;
            }
            foreach ($tmp as &$u) {
                $key = &$u['parent'];
                $tmp[$key]['children'][] = &$u;
            }
            $this->ajaxReturn(200, $tmp[$data[0]['value']]);
        }
        $this->ajaxReturn(200, $data);
    }


    /**
     * 获取子级
     * @param $id
     */
    public function child($id) {
        $data = $this->commonRegionModel->getFind(['value' => $id]);
        $data['children'] = $this->getChild($id);
        $this->ajaxReturn(200, $data);
    }


    public function getChild($id) {
        $result = $this->commonRegionModel->getAll(['parent' => $id]);
        if (!empty($result)) {
            foreach ($result as $key => $item) {
                $result[$key]['children'] = $this->getChild($item['value']);
            }
        }
        return $result;
    }

}









