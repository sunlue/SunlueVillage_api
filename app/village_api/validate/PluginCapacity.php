<?php

namespace app\village_api\validate;

use think\Validate;

class PluginCapacity extends Validate {
    protected $rule = [
        'uniqid' => 'require',
        'date' => 'require|date',
        'number' => 'require|number',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'date.require' => 'CAPACITY_DATE_EMPTY',
        'date.date' => 'CAPACITY_DATA_FORMAT_ERROR',
        'number.require' => 'CAPACITY_NUMBER_EMPTY',
        'number.number' => 'CAPACITY_NUMBER_FORMAT_ERROR',
    ];

    protected function sceneCreate() {
        return $this->only(['date','number']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

}