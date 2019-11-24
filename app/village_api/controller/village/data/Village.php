<?php

namespace app\village_api\controller\village\data;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\VillageData;
use app\village_api\model\VillageDataTypeJoin;
use think\facade\Db;

class Village extends eVillageApi {
    private $model;

    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new VillageData();
    }

    public function create($data) {
        Db::startTrans();
        try {
            $this->model->save($data);
            $saveData = $this->model->getData();
            if (is_array($data['type']) && count($data['type'])) {
                $dataTypeJoinModel = new VillageDataTypeJoin();
                $type = [];
                foreach ($data['type'] as $key => $row) {
                    $type[] = array(
                        'data' => $saveData['uniqid'],
                        'type' => $row
                    );
                }
                $dataTypeJoinModel->saveAll($type);
            }
            Db::commit();
            $this->ajaxReturn(200, $saveData);
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 删除数据
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
     * 修改数据
     * @param $uniqid
     * @param $params
     */
    protected function update($uniqid, $params) {
        Db::startTrans();
        try {
            unset($params['id']);
            unset($params['uniqid']);
            unset($params['create_time']);
            unset($params['update_time']);
            $field = array_column($this->model->getFields(), 'name');
            $data = array_filter($params, function ($item, $key) use ($field) {
                return !in_array($key, $field) ? [] : array($key => $item);
            }, ARRAY_FILTER_USE_BOTH);
            $data['tag'] = json_encode($data['tag'], JSON_UNESCAPED_UNICODE);
            $data['nation'] = json_encode($data['nation'], JSON_UNESCAPED_UNICODE);
            $this->model->where('uniqid', $uniqid)->data($data)->update();
            if (is_array($params['type']) && count($params['type'])) {
                $dataTypeJoinModel = new VillageDataTypeJoin();
                $type = [];
                foreach ($params['type'] as $key => $row) {
                    $type[] = array(
                        'data' => $uniqid,
                        'type' => $row
                    );
                }
                $dataTypeJoinModel->destroy(['data' => $uniqid]);
                $dataTypeJoinModel->saveAll($type);
            }
            Db::commit();
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            Db::rollback();
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 修改数据字段
     * @param $uniqid
     * @param $field
     * @param $value
     */
    protected function updateField($uniqid, $field, $value) {
        try {
            if ($field == 'tag' || $field == 'nation') {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            };
            $this->model->where('uniqid', $uniqid)->data(array(
                $field => $value
            ))->update();
            $this->ajaxReturn(200, array(
                $field => $value
            ));
        } catch (\exception $e) {
            $this->ajaxReturn(400, $this->model->getLastSql());
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
}