<?php
/**
 * User: xiebing
 * Date: 2019-4-17
 * Time: 16:04
 */

namespace app\village_api\controller\plugin\access;

use app\village_api\common\controller\eVillageApi;
use think\facade\Db;

class Referer extends eVillageApi {
    public function initialize() {
        parent::_init();
        parent::_checkToken();
    }

    public function get() {
        $data = Db::name('plugin_access')->field('count(*) as value,`type`')->group('`type`')->select()->toArray();
        $pcKey = array_search('pc', array_column($data, 'type'));
        $wapKey = array_search('wap', array_column($data, 'type'));
        $mpWeixinKey = array_search('mp_weixin', array_column($data, 'type'));
        $mpAlipayKey = array_search('mp_alipay', array_column($data, 'type'));
        $mpBaiduKey = array_search('mp_baidu', array_column($data, 'type'));
        $androidKey = array_search('android', array_column($data, 'type'));
        $iosKey = array_search('ios', array_column($data, 'type'));
        $weixinPublicKey = array_search('weixin_public', array_column($data, 'type'));
        $data = array(
            'date' => ["电脑端", "微信公众号", "微信小程序", "支付宝小程序", "百度小程序", "Android", "IOS", "WAP"],
            'data' => array(
                array(
                    'name' => '电脑端',
                    'value' => empty($data) ? 0 : ($pcKey || $pcKey == 0) ? $data[$pcKey]['value'] : 0
                ),
                array(
                    'name' => '微信公众号',
                    'value' => empty($data) ? 0 : $weixinPublicKey ? $data[$weixinPublicKey]['value'] : 0
                ),
                array(
                    'name' => '微信小程序',
                    'value' => empty($data) ? 0 : $mpWeixinKey ? $data[$mpWeixinKey]['value'] : 0
                ),
                array(
                    'name' => '支付宝小程序',
                    'value' => empty($data) ? 0 : $mpAlipayKey ? $data[$mpAlipayKey]['value'] : 0
                ),
                array(
                    'name' => '百度小程序',
                    'value' => empty($data) ? 0 : $mpBaiduKey ? $data[$mpBaiduKey]['value'] : 0
                ),
                array(
                    'name' => 'Android',
                    'value' => empty($data) ? 0 : $androidKey ? $data[$androidKey]['value'] : 0
                ),
                array(
                    'name' => 'IOS',
                    'value' => empty($data) ? 0 : $iosKey ? $data[$iosKey]['value'] : 0
                ),
                array(
                    'name' => 'WAP',
                    'value' => empty($data) ? 0 : $wapKey ? $data[$wapKey]['value'] : 0
                )
            )
        );
        $this->ajaxReturn(200, $data);
    }
}