<?php
/**
 * User: xiebing
 * Date: 2019-6-20
 * Time: 11:17
 */

namespace app\village_api\middleware;

use think\exception\ValidateException;
use think\facade\Request;
use think\Validate;

class Auth {
    public function handle($request, \Closure $next) {
        $param = input('param.');
        try {
            $this->validate($param);
            $error = $this->check($param);
            if ($error)
                return json($error);
        } catch (ValidateException $e) {
            return json(array(
                'code' => 400,
                'info' => $e->getError()
            ));
        }
        return $next($request);
    }

    public function check($param) {
        $authInfo = config('auth.' . $param['appid']);
        $ip = (!empty($authInfo['ip']) && $authInfo['ip'] != Request::ip());
        $host = (!empty($authInfo['host']) && $authInfo['host'] != Request::host());
        if ($ip && $host) {
            return array(
                'code' => 400,
                'info' => lang('AUTH_ERROR')
            );
        }
    }

    /**
     * 参数验证
     * @param $param
     * @return bool
     */
    public function validate($param) {
        $v = new Validate();
        $v->rule(array(
            'appid' => 'require',
            'appkey' => 'require'
        ));
        $v->message(array(
            'appid.require' => lang('APPID_ERROR'),
            'appkey.require' => lang('APPKEY_ERROR'),
        ));
        return $v->failException()->check($param);
    }
}