<?php


namespace app\village_api\controller\portal\notice;


use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PortalNotice;

class Notice extends eVillageApi {
    private $model;

    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new PortalNotice();
    }


    /**
     * 创建通知公告
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
     * 删除通知公告
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
     * 修改通知公告
     * @param $uniqid
     * @param $data
     */
    protected function update($uniqid, $data) {
        try {
            unset($data['uniqid']);
            $this->model->where('uniqid', $uniqid)->update($data);
            $this->ajaxReturn(200, $data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    public function release($uniqid, $release) {
        try {
            $this->model->where('uniqid', $uniqid)->update(array(
                'release' => $release,
                'by_time'=>time()
            ));
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 获取通知公告
     * @param $where
     */
    protected function read($where) {
        if (input('param.page')) {
            $data = PortalNotice::getList($where);
        } else {
            $data = PortalNotice::getAll($where);
        }
        $this->ajaxReturn(200, $data);
    }
}