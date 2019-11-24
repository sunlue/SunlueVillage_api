<?php

namespace app\village_api\validate;

use think\Validate;

class PluginConfig extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'type' => 'require',
        'name' => 'require',
        'pages' => 'require',
        'version' => 'require',
        'config' => 'require',
        'content' => 'require',
        'appid' => 'require',
        'appkey' => 'require',
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'uniqid.uniques' => 'UNIQID_EMPTY',
        'type.require' => 'PLUGIN_TYPE_EMPTY',
        'name.require' => 'PLUGIN_NAME_EMPTY',
        'pages.require' => 'PLUGIN_PAGES_EMPTY',
        'version.require' => 'PLUGIN_VERSION_EMPTY',
        'appid.require' => 'PLUGIN_APPID_EMPTY',
        'appkey.require' => 'PLUGIN_APPKEY_EMPTY',
    ];

    protected function sceneCreate() {
        return $this->only(['type','name', 'pages', 'version']);
    }

    protected function sceneInstall() {
        return $this->only(['uniqid', 'appid', 'appkey']);
    }

    protected function sceneUninstall() {
        return $this->only(['uniqid']);
    }

    protected function sceneState() {
        return $this->only(['uniqid']);
    }

    protected function uniques($value) {
        return \app\village_api\model\PluginConfig::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }

}