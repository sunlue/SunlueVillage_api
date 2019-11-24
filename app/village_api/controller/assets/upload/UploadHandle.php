<?php
namespace app\village_api\controller\assets\upload;
use think\facade\Request;

class UploadHandle {

    public static function upload($file, $saveRoot, $saveDir,$callback) {
        if ($file['error'] != UPLOAD_ERR_OK) {
            UploadException::uploadReturn($file['error']);
        }
        $suffix = pathinfo($file['name'], PATHINFO_EXTENSION);
        $saveName = uniqid(hash_file('md5', $file['tmp_name'])) . '.' . $suffix;
        $savePath = $saveRoot . $saveDir . $saveName;
        $moveRes = move_uploaded_file($file['tmp_name'], $savePath);
        if ($moveRes) {
            $link=str_replace('\\', '/', $saveDir . $saveName);
            $callback(array(
                'url' => Request::root(true),
                'link' => $link,
                'size' => $file['size'],
                'type' => $file['type'],
                'name' => $file['name'],
            ));
        }
    }

    public static  function multiple($files, $saveRoot, $saveDir,$callback) {
        $error_list = array();
        foreach ($files['error'] as $key => $error) {
            if ($error != 0) {
                $error_list[] = '文件【' . $files['name'][$key] . '】存在异常,错误对照码:' . $files['error'][$key];
            }
        }
        $file_list = self::reArrayFiles($files);;
        $moveRes = array();
        foreach ($file_list as $file) {
            $suffix = pathinfo($file['name'], PATHINFO_EXTENSION);
            $saveName = hash_file('md5', $file['tmp_name']) . '.' . $suffix;
            $savePath = $saveRoot . $saveDir . $saveName;
            move_uploaded_file($file['tmp_name'], $savePath);
            $link=str_replace('\\', '/', $saveDir . $saveName);
            $moveRes[] = array(
                'url' => Request::root(true),
                'link' => $link,
                'size' => $file['size'],
                'type' => $file['type'],
                'name' => $file['name'],
            );
        }
        $callback($moveRes);
    }

    protected function reArrayFiles(&$file_post) {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }
}