<?php
namespace app\village_api\controller\village\natural;
use app\village_api\model\VillageNatural;
use office\excel\Excel;
class Import extends Natural {
    public function index() {
        $filename = app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'village.xlsx';
        $data = Excel::import($filename,1);
        $row = [];

        foreach ($data as $k => $r) {
            if ($k < 2) {
                continue;
            }
            $row[] = array(
                'name' => $r['C'],
                'type' => $r['D'] == '传统技艺' ? 8 : 0,
            );
        }
        $model = new VillageNatural();
        $model->saveAll($row);
    }
}