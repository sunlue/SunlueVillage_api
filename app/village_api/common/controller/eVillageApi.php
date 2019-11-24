<?php
/**
 * User: xiebing
 * Date: 2019-5-29
 * Time: 17:46
 */

namespace app\village_api\common\controller;

use app\village_api\BaseController;
use crypt\Base;
use think\facade\Env;
use think\facade\Request;

class eVillageApi extends BaseController {

    protected function _init() {
        header('Access-Control-Allow-Origin:*');
    }

    protected function _checkToken($callback = '') {
        if (!Env::get('app_debug') || $callback!='') {
            $access_token = input('param.access_token', Request::header('access_token'));
            if (empty($access_token)) {
                $this->ajaxReturn(302, lang('ACCESS_TOKEN_ERROR'));
            }
            $token = cache(md5(strtoupper($access_token)));
            if (empty($token) || $token['access_token'] != $access_token) {
                $this->ajaxReturn(302, lang('ACCESS_TOKEN_EXCEPTION'));
            }
            if ($token['create_time'] + 7200 < time()) {
                $this->ajaxReturn(302, lang('ACCESS_TOKEN_EXPIRE'));
            }
            if ($callback instanceof \Closure) {
                parse_str(Base::decrypt($access_token), $token_data);
                $callback($token_data, $access_token);
            }
        }
    }

    protected function _refreshToken($callback=''){
        $access_token = input('param.access_token', Request::header('access_token'));
        if (empty($access_token)) {
            $this->ajaxReturn(302, lang('ACCESS_TOKEN_ERROR'));
        }
        if ($callback instanceof \Closure) {
            parse_str(Base::decrypt($access_token), $token_data);
            $callback($token_data, $access_token);
        }
    }

    /**
     * ajax返回
     * @param int $code
     * @param string $info
     * @param array $data
     * @param string $type
     */
    protected function ajaxReturn($code = 200, $info = '', $data = [], $type = '') {
        $type = empty($type) ? config('app.default_ajax_return') : $type;
        if (is_array($code)) {
            $return = $code;
        } else {
            $return ['code'] = $code;
            if ($code == 200 && is_array($info)) {
                $return ['data'] = $info;
                $return ['info'] = 'success';
            } elseif ($code != 200 && !empty ($data)) {
                $return ['data'] = $data;
            }
            if ($code == 200 && !is_array($info) && !empty ($info)) {
                $return ['info'] = $info;
            } elseif ($code == 200 && empty ($info)) {
                $return ['info'] = 'success';
            } elseif ($code != 200 && !empty ($info)) {
                $return ['info'] = $info;
            }
        }
        switch (strtoupper($type)) {
            case 'XML' :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(arrtoxml($return));
            case 'JSONP' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = isset ($_GET [config('VAR_JSONP_HANDLER')]) ? $_GET [config('VAR_JSONP_HANDLER')] : config('DEFAULT_JSONP_HANDLER');
                exit ($handler . '(' . json_encode($return, JSON_UNESCAPED_UNICODE) . ');');
            case 'HTML' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($return);
            case 'TEXT' :
                // 返回txt格式数据
                header('Content-Type:text/plain; charset=utf-8');
                exit(var_export($return));
            default :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($return, JSON_UNESCAPED_UNICODE));
        }
    }
}