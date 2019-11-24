<?php

namespace app\village_api\model;

use think\facade\Db;
use think\Model;

class PluginAccess extends Model {
    protected $pk = 'uniqid';

    public function getPv($where = array(), $isSql = false) {
        $data = PluginAccess::alias('a')->field('count(*) as total,date')
            ->where($where)->group('date')->fetchSql($isSql)->select();
        return !$isSql ? $data->toArray() : $data;
    }

    public function getUv($where = array(), $isSql = false) {
        $sql = PluginAccess::alias('a')->field('count(*),date,ip')->group('date,cookie')->fetchSql()->select();
        $data = Db::table("($sql) as t")->field('COUNT(*) as total,`date`')
            ->where($where)->group('date')->fetchSql($isSql)->select();
        return !$isSql ? $data->toArray() : $data;
    }

    public function getIp($where = array(), $isSql = false) {
        $sql = PluginAccess::alias('a')->field('count(*),date,ip')->group('date,ip')->fetchSql(true)->select();
        $data = Db::table("($sql) as t")->field('COUNT(*) as total,`date`')
            ->where($where)->fetchSql($isSql)->group('date')->select();
        return !$isSql ? $data->toArray() : $data;
    }
}