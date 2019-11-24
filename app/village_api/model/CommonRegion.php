<?php

namespace app\village_api\model;

use think\Model;

class CommonRegion extends Model {
    protected $pk = 'id';

    protected function getTypeAttr($value) {
        $text = array(
            '0' => '',
            '100' => '城镇',
            '110' => '城区',
            '111' => '主城区',
            '112' => '城乡结合部',
            '120' => '镇区',
            '121' => '镇中心区',
            '122' => '镇乡结合部',
            '123' => '特殊区域',
            '200' => '乡村',
            '210' => '乡中心区',
            '220' => '村庄',
        );
        return $text[$value];
    }

    public function getList($where = array()) {
        $data = CommonRegion::field('value,label,type,parent')->where($where)->paginate();
        return $data ? $data->toArray() : [];
    }

    public function getAll($where = array()) {
        $data = CommonRegion::field('value,label,type,parent')->where($where)->cache(true)->select();
        return $data ? $data->toArray() : [];
    }

    public static function getFind($where = array()) {
        $data = CommonRegion::field('value,label,type,parent')->where($where)->cache(true)->find();
        return $data ? $data->toArray() : [];
    }

    private static $region;

    public static function getParents($value,$number=0) {
        if ($number==0){self::$region=[];}
        $region = CommonRegion::where('value', $value)->find();
        $region = $region ? $region->toArray() : [];
        if (!empty($region) && $region['parent'] != '0') {
            self::$region[] = $region;
            CommonRegion::getParents($region['parent'],1);
        }
        return self::$region;
    }

    /**
     * 取镇级
     * @param $value int 村级识别号
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */

    public static function getTown($value) {
        $region = CommonRegion::alias('a')
            ->join('common_region b','a.parent=b.value','left')
            ->where('a.value', $value)->find();
        return $region?$region['label']:'';
    }

}