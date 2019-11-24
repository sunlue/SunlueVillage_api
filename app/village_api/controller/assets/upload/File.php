<?php

namespace app\village_api\controller\assets\upload;
use app\village_api\controller\assets\Upload;

class File extends Upload {
    public function index() {
        $this->verify();
    }
}
