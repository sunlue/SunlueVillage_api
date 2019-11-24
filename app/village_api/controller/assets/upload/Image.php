<?php

namespace app\village_api\controller\assets\upload;


use app\village_api\controller\assets\Upload;

class Image extends Upload {
    public function index() {
        $this->verify('image');
    }
}
