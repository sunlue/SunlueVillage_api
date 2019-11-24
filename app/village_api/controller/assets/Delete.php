<?php

namespace app\village_api\controller\assets;

class Delete extends Upload {
    public function index() {
        $path = parse_url(input('delete.path'));
        $filename = app()->getRootPath() . 'public' . $path['path'];
        if (!file_exists($filename)) {
            $this->ajaxReturn(400, '文件不存在');
        }
        try {
            unlink($filename);
            $this->ajaxReturn(200);
        } catch (\exception $e) {
            $this->ajaxReturn(400, $e->getMessage());
        }
    }
}