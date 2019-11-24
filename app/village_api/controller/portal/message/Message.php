<?php

namespace app\village_api\controller\portal\message;

use app\village_api\common\controller\eVillageApi;
use app\village_api\model\PortalMessage;

class Message extends eVillageApi {
    private $model;

    public function _init() {
        parent::_init();
        parent::_checkToken();
        $this->model = new PortalMessage();
    }


    /**
     * 创建留言
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
     * 删除留言
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
     * 回复留言
     * @param $group
     * @param $content
     */
    protected function reply($group, $content) {
        try {
            $this->model->save(array(
                'content'=>$content,
                'group'=>$group,
                'reply'=>true
            ));
            $data=$this->model->getData();
            $data['by_time']=date('Y-m-d H:i:s',time());
            $this->ajaxReturn(200,$data);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 获取留言
     * @param $where
     */
    protected function read($where) {
        $data = PortalMessage::getAll($where);
        $list = [];
        foreach ($data as $message) {
            $list[$message['group']]['last'] = $message;
            $list[$message['group']]['list'][] = $message;
        }
        $this->ajaxReturn(200, $list);
    }
}