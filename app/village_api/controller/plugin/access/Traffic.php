<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-1-17
 * Time: 10:38
 */

namespace app\village_api\controller\plugin\access;

use app\village_api\model\PluginAccess;

class Traffic extends Total {
    private $accessModel;

    public function initialize() {
        header('Access-Control-Allow-Origin:*');
        $this->accessModel = new PluginAccess();
    }

    public function get() {
        $start_date = date('Y-m-d', strtotime('-7 day'));
        $end_date = date('Y-m-d', time());
        $pv = self::tempNumber('count', $start_date, $end_date, $this->accessModel->getPv([], true))->toArray();
        $uv = self::tempNumber('count', $start_date, $end_date, $this->accessModel->getUv([], true))->toArray();
        $ip = self::tempNumber('count', $start_date, $end_date, $this->accessModel->getIp([], true))->toArray();
        $this->ajaxReturn(200, array(
            'date' => array_column($pv, 'date'),
            'pv' => array_column($pv, 'value'),
            'uv' => array_column($uv, 'value'),
            'ip' => array_column($ip, 'value'),
        ));
    }
}