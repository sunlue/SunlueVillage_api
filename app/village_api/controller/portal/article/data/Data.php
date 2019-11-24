<?php

namespace app\village_api\controller\portal\article\data;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PortalArticleData;

class Data extends eVillageApi {

    private $model;

    protected function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new PortalArticleData();
    }

    /**
     * 创建文章数据
     * @param array $data
     */
    protected function create($data = array()) {
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 删除文章数据
     * @param $uniqid
     */
    protected function delete($uniqid) {
        try {
            $this->model->destroy($uniqid);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改文章数据
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid, $data) {
        try {
            unset($data['id']);
            unset($data['uniqid']);
            unset($data['create_time']);
            unset($data['update_time']);
            $field = array_column($this->model->getFields(), 'name');
            $data = array_filter($data, function ($item, $key) use ($field) {
                return !in_array($key, $field) ? [] : array($key => $item);
            }, ARRAY_FILTER_USE_BOTH);
            $data['tag'] = is_array($data['tag']) ? implode(',', array_column($data['tag'], 'value')) : '';
            $this->model->where('uniqid', $uniqid)->save($data);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改文章数据字段
     * @param $uniqid
     * @param $field
     * @param $value
     */
    protected function updateAericleField($uniqid, $field, $value) {
        try {
            $this->model->where('uniqid', $uniqid)->data(array(
                $field => $value
            ))->update();
            $this->ajaxReturn(200, array(
                $field => $value
            ));
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 点赞
     * @param $uniqid
     */
    protected function setLike($uniqid){
        try {
            $this->model->where('uniqid',$uniqid)->inc('like')->update();
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }


    /**
     * 获取文章数据
     * @param $where
     */
    protected function read($where) {
        if (input('param.page')) {
            $data = PortalArticleData::getList($where);
        } else {
            $data = PortalArticleData::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}