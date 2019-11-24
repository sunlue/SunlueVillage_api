<?php

namespace app\village_api\controller\assets;

use app\village_api\controller\assets\upload\UploadHandle;
use think\facade\Db;

class Upload {

    public function __construct() {
        header('Access-Control-Allow-Origin:*');
    }

    public function verify($fileType = 'file') {
        $saveDir = DIRECTORY_SEPARATOR . 'upload' .
            DIRECTORY_SEPARATOR . config('app.app_name') .
            DIRECTORY_SEPARATOR . date('Ymd', time()) .
            DIRECTORY_SEPARATOR . $fileType . DIRECTORY_SEPARATOR;
        $file = $_FILES;
        if (empty($file['file'])) {
            $this->ajaxReturn(UPLOAD_ERR_NO_FILE, lang('UPLOAD_ERR_NO_FILE'));
        } else {
            $file = $file['file'];
        }
        $config = Db::name('basis_site')->cache('uploadConfig')->where('type', 'upload')->value('content');
        $uploadConfig = json_decode($config, true);
        $pathInfo = pathinfo($file['name']);
        if ($fileType == 'image') {
            $uploadType = 'image_upload_type';
            $uploadSize = 'image_upload_size';
        } else if ($fileType == 'audio') {
            $uploadType = 'audio_upload_type';
            $uploadSize = 'audio_upload_size';
        } else if ($fileType == 'video') {
            $uploadType = 'video_upload_type';
            $uploadSize = 'video_upload_size';
        } else {
            $uploadType = 'file_upload_type';
            $uploadSize = 'file_upload_size';
        }

        if (!in_array($pathInfo['extension'], explode(',', $uploadConfig[$uploadType]))) {
            $this->ajaxReturn(400, lang('EXTENSION_NOT_ALLOWED'));
        }

        if ($file['size'] > $uploadConfig[$uploadSize] * 1000) {
            $this->ajaxReturn(400, '['.$file['name'].']'.lang('UPLOAD_ERR_MAX_SIZE'));
        }

        $saveRoot = app()->getRootPath() . DIRECTORY_SEPARATOR . 'public';
        if (!is_dir($saveRoot . $saveDir)) {
            mkdir($saveRoot . $saveDir, 0777, true);
        }
        if (is_array($file['name'])) {
            UploadHandle::multiple($file, $saveRoot, $saveDir, function ($result) {
                $this->ajaxReturn(200, $result);
            });
        } else {
            UploadHandle::upload($file, $saveRoot, $saveDir, function ($result) {
                $this->ajaxReturn(200, $result);
            });
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