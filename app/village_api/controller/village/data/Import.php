<?php

namespace app\village_api\controller\village\data;

use app\village_api\model\CommonRegion;
use app\village_api\model\VillageData;
use office\excel\Excel;

class Import extends Village {
    public function index() {
        $filename = app()->getRootPath() . 'public' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . 'village.xlsx';
        $data = Excel::import($filename);
        $insert = [];
        $model = new VillageData();
        foreach ($data as $k => $r) {
            if ($k < 4) {
                continue;
            }
            $region = CommonRegion::getFind(['label' => $r['C']]);
            $town = CommonRegion::getFind(['label' => $r['B']]);

            $where = array(
                'province' => '510000000000',
                'city' => '510700000000',
                'county' => '510703000000',
                'town' => $town['value'],
                'village' => $region['value'],
            );
            $villageDATA = VillageData::getFind($where);
            if (!empty($villageDATA)) {
                $row = array(
                    'name' => $r['C'],
                    'attribute' => $r['D'] == '行政村' ? 1 : 2,
                    'registered_population' => $r['E'],
                    'registered_population_man' => $r['F'],
                    'registered_population_woman' => $r['G'],
                    'permanent_population' => $r['H'],
                    'permanent_population_man' => $r['I'],
                    'permanent_population_woman' => $r['J'],
                    'collective_income' => $r['K'] * 100,
                    'person_income' => $r['L'] * 100,
                    'nation' => ['1'],
                    'decade' => $r['N'],
                    'domain_area' => $r['O'],
                    'village_area' => $r['P'],
                    'content' => $r['R'],
                    'industry' => $r['Q'],
                );
                $model->data($row)->where(['uniqid' => $villageDATA['uniqid']])->update();
            } else {
                $insert[] = array(
                    'province' => '510000000000',
                    'city' => '510700000000',
                    'county' => '510703000000',
                    'town' => $town['value'],
                    'village' => $region['value'],
                    'name' => $r['C'],
                    'attribute' => $r['D'] == '行政村' ? 1 : 2,
                    'registered_population' => $r['E'],
                    'registered_population_man' => $r['F'],
                    'registered_population_woman' => $r['G'],
                    'permanent_population' => $r['H'],
                    'permanent_population_man' => $r['I'],
                    'permanent_population_woman' => $r['J'],
                    'collective_income' => $r['K'] * 100,
                    'person_income' => $r['L'] * 100,
                    'nation' => ['1'],
                    'decade' => $r['N'],
                    'domain_area' => $r['O'],
                    'village_area' => $r['P'],
                    'content' => $r['R'],
                    'industry' => $r['Q'],
                );
            }
        }
        $model->saveAll($insert);
        echo '执行完成';
    }
}