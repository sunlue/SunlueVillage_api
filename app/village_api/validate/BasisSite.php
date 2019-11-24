<?php

namespace app\village_api\validate;

use think\Validate;

class BasisSite extends Validate {
    protected $rule = [
        'uniqid' => 'require',
        'type' => 'require',
        'content' => 'require|type',

        'file_upload_type' => 'require',
        'file_upload_size' => 'require',
        'audio_upload_type' => 'require',
        'audio_upload_size' => 'require',
        'video_upload_type' => 'require',
        'video_upload_size' => 'require',
        'image_upload_type' => 'require',
        'image_upload_size' => 'require',

        'seo_title' => 'require'
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY',
        'type.require' => 'BASIS_SITE_TYPE_EMPTY',
        'content.require' => 'BASIS_SITE_CONTENT_EMPTY',
        'content.type' => 'BASIS_SITE_CONTENT_NOT_ARRAY',

        'file_upload_type.require' => 'BASIS_SITE_UPLOAD_FILE_UPLOAD_TYPE_EMPTY',
        'file_upload_size.require' => 'BASIS_SITE_UPLOAD_FILE_UPLOAD_SIZE_EMPTY',
        'audio_upload_type.require' => 'BASIS_SITE_UPLOAD_AUDIO_UPLOAD_TYPE_EMPTY',
        'audio_upload_size.require' => 'BASIS_SITE_UPLOAD_AUDIO_UPLOAD_SIZE_EMPTY',
        'video_upload_type.require' => 'BASIS_SITE_UPLOAD_VIDEO_UPLOAD_TYPE_EMPTY',
        'video_upload_size.require' => 'BASIS_SITE_UPLOAD_VIDEO_UPLOAD_SIZE_EMPTY',
        'image_upload_type.require' => 'BASIS_SITE_UPLOAD_IMAGE_UPLOAD_TYPE_EMPTY',
        'image_upload_size.require' => 'BASIS_SITE_UPLOAD_IMAGE_UPLOAD_SIZE_EMPTY',

        'seo_title.require' => "BASIS_SITE_SETTING_SEO_TITLE_EMPTY"

    ];

    protected function sceneSearch() {
        return $this->only(['type']);
    }

    protected function sceneSubmit() {
        return $this->only(['type', 'content']);
    }

    protected function sceneUpload() {
        return $this->only(['file_upload_type', 'file_upload_size', 'audio_upload_type', 'audio_upload_size',
            'video_upload_type', 'video_upload_size', 'image_upload_type', 'image_upload_size']);
    }

    protected function sceneSetting() {
        return $this->only(['seo_title']);
    }

    protected function type($value) {
        return is_array($value) ? true : false;
    }
}