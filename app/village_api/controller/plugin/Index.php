<?php

namespace app\village_api\controller\plugin;

use app\village_api\common\controller\eVillageApi;
use app\village_api\validate\PluginConfig;
use think\exception\ValidateException;

class Index extends eVillageApi {
    public function initialize() {
        parent::_init();
        parent::_checkToken();
    }


    /**
     * 提交数据验证
     * @param array $data
     * @param $scene
     */
    protected function dataValidate($data = array(), $scene) {
        try {
            validate(PluginConfig::class)->scene($scene)->check($data);
        } catch (ValidateException $e) {
            $this->ajaxReturn(400, $e->getError());
        }
    }

    /**
     * 初始化应用
     */
    public function submit() {
        $params = input('post.');
        $this->dataValidate($params, 'create');
        $model = new \app\village_api\model\PluginConfig();
        $model->replace()->save($params);
    }

    /**
     * 安装应用
     */
    public function install() {
        $params = input('post.');
        $this->dataValidate($params, 'install');
        $model = new \app\village_api\model\PluginConfig();
        try {
            $config = json_encode(!empty($params['config']) ? $params['config'] : [], JSON_UNESCAPED_UNICODE);
            $model->where('uniqid', $params['uniqid'])->data(array(
                'install' => 1,
                'config' => $config,
                'appid' => $params['appid'],
                'appkey' => $params['appkey'],
            ))->save();
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 卸载应用
     */
    public function uninstall() {
        $params = input('post.');
        $this->dataValidate($params, 'uninstall');
        $model = new \app\village_api\model\PluginConfig();
        try {
            $model->where('uniqid', $params['uniqid'])->save(array(
                'install' => 2,
                'appid' => '',
                'appkey' => '',
            ));
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }

    /**
     * 查询条件
     * @param array $param
     * @param string $callback
     * @return array
     */
    protected function searchWhere($param = array(), $callback = '') {
        $where = array();
        if (!empty($param['config'])) {
            $where[] = ['config', '=', $param['config']];
        }
        if ($callback instanceof \Closure) {
            $callback($where);
        } else {
            return $where;
        }
    }

    /**
     * 读取应用
     */
    public function read() {
        $params = input('get.');
        $where = $this->searchWhere($params);
        $data = \app\village_api\model\PluginConfig::getAll($where);
        $this->ajaxReturn(200, $data);
    }


    /**
     * 启用/禁用应用
     */
    public function state() {
        $params = input('post.');
        $this->dataValidate($params, 'state');
        if (empty($params['enable'])) {
            $data = \app\village_api\model\PluginConfig::getFind(array(
                'uniqid' => $params['uniqid']
            ));
            $params['enable'] = $data['enable'] == 1 ? 2 : 1;
        }
        $model = new \app\village_api\model\PluginConfig();
        try {
            $model->where('uniqid', $params['uniqid'])->save(array(
                'enable' => $params['enable']
            ));
            $this->ajaxReturn(200, array(
                'enable' => $params['enable']
            ));
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}