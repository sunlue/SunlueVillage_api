<?php


namespace app\village_api\controller\village\data;


use app\village_api\model\CommonRegion;
use app\village_api\model\VillageData;
use office\excel\Excel;

class Import extends Village {
    public function index() {
        $filename = app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . 'village.xlsx';
        $data = Excel::import($filename);
        $row = [];

        foreach ($data as $k => $r) {
            if ($k < 4) {
                continue;
            }
            $region=CommonRegion::getFind(['label'=>$r['C']]);
            $row[] = array(
                'region'=>$region['value'],
                'name' => $r['C'],
                'type' => $r['D'] == '行政村' ? 1 : 2,
                'registered_population' => $r['E'],
                'registered_population_man' => $r['F'],
                'registered_population_woman' => $r['G'],
                'permanent_population' => $r['H'],
                'permanent_population_man' => $r['I'],
                'permanent_population_woman' => $r['J'],
                'collective_income' => $r['K']*100,
                'person_income' => $r['L']*100,
                'nation' => ['1'],
                'decade' => $r['N'],
                'domain_area' => $r['O'],
                'village_area' => $r['P'],
                'content' => $r['R'],
                'industry' => $r['Q'],
            );
        }
        $model = new VillageData();
        $result=$model->saveAll($row);
        dump($result);
    }
}