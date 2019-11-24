<?php


namespace app\village_api\controller\assets\upload;

class UploadException {
    public static function codeToMessage($code) {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = lang('UPLOAD_ERR_INI_SIZE');
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = lang('UPLOAD_ERR_FORM_SIZE');
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = lang('UPLOAD_ERR_PARTIAL');
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = lang('UPLOAD_ERR_NO_FILE');
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = lang('UPLOAD_ERR_NO_TMP_DIR');
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = lang('UPLOAD_ERR_CANT_WRITE');
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = lang('UPLOAD_ERR_EXTENSION');
                break;
            default:
                $message = lang('UPLOAD_ERR_UNKNOWN');
                break;
        }
        return $message;
    }

    public static function uploadReturn($errCode) {
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode(array('code' => $errCode, 'info' => UploadException::codeToMessage($errCode))));
    }
}