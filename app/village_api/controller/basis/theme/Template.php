<?php


namespace app\village_api\controller\basis\theme;


use app\village_api\common\controller\eVillageApi;

class Template extends eVillageApi {
    public function initialize() {
        parent::_init();
        parent::_checkToken();
    }
    public function index(){
        $dir = app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'theme';
        $templateArray = [];
        if (false != ($handle = opendir($dir))) {
            while (false !== ($dirName = readdir($handle))) {
                if ($dirName != "." && $dirName != ".." && !strpos($dirName, ".")) {
                    $manifest = opendir($dir . DIRECTORY_SEPARATOR . $dirName);
                    if ($manifest != false) {
                        $manifestFile = $dir . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . 'manifest.json';
                        if (file_exists($manifestFile)) {
                            $manifestFileRes = file_get_contents($manifestFile);
                            $templateArray[$dirName] = json_decode($manifestFileRes, true);
                        } else {
                            $templateArray[$dirName] = [];
                        }
                    }
                }
            }
            closedir($handle);
        }
        $this->ajaxReturn(200,$templateArray);
    }
}