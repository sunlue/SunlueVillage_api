<?php
/**
 * User: xiebing
 * Date: 2019-6-20
 * Time: 11:50
 */
return [
    'default_lang'    => env('lang.default_lang', 'zh-cn'),
    'detect_var'      => env('lang.detect_var', 'lang'),
    'allow_lang_list' => ['zh-cn', 'en-us'],
    'use_cookie'      => env('lang.use_cookie', false),
    'cookie_var'      => env('lang.cookie_var', 'SunlueCMS_API_lang')
];
