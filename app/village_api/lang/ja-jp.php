<?php
/**
 * 多语言日语版本
 * User: xiebing
 * Date: 2019/6/4
 * Time: 16:57
 */

return [
    //common
    'UNIQID_EMPTY' => "uniqid异常",
    'FIELD_EMPTY' => "字段异常",
    'VALUE_EMPTY' => "值异常",
    'MOBILE_FORMAT_ERROR' => '手机号格式不正确',
    'EMAIL_FORMAT_ERROR' => '电子邮箱格式不正确',
    'UNAUTHORIZED_ACCESS' => '未获得访问权限',
    //授权过程
    'APPID_ERROR' => '应用ID（appid）错误',
    'APPKEY_ERROR' => '应用密钥（appkey）错误',
    'AUTH_ERROR' => '授权错误或异常',
    //access_token
    'ACCESS_TOKEN_ERROR' => 'access_token错误',
    'ACCESS_TOKEN_EXPIRE' => 'access_token过期',
    'ACCESS_TOKEN_EXCEPTION' => 'access_token失效或不存在',
    //系统用户登录
    'LOGIN_ACCOUNT_EMPTY' => '登录账号异常',
    'LOGIN_PASSWORD_EMPTY' => '登录密码异常',
    'LOGIN_USER_EMPTY' => '用户信息不存在',
    'LOGIN_PASSWORD_ERROR' => '登录密码错误',
    'LOGIN_PROHIBIT_ACCOUNT' => '禁止账号登录',
    'LOGIN_PROHIBIT_MOBILE' => '禁止手机号登录',
    //系统用户注册
    'USER_NAME_EMPTY' => '用户姓名不能为空',
    'USER_ALREADY_EXIST' => '用户已存在',
    'USER_ACCOUNT_ALREADY_EXIST' => '用户账号已存在',
    'USER_MOBILE_ALREADY_EXIST' => '用户手机号已存在',
    'USER_ACCOUNT_EMPTY' => '用户账号不能为空',
    'USER_PASSWORD_LENGTH_ERROR' => '用户密码长度必须大于6位',
    'USER_PASSWORD_DISAFFINITY' => '用户密码不一致',
    'USER_ACCEPTED_ERROR' => '是/否数据格式错误',
    //用户角色
    'USER_ROLE_NAME_EMPTY' => "用户角色名称不能为空",
    'USER_ROLE_SIGN_LENGTH_ERROR' => "用户角色标记长度错误",
    'USER_ROLE_SORT_TYPE_ERROR' => "用户角色排序类型错误",
    'USER_ROLE_REMARK_LENGTH_ERROR' => "用户角色备注长度错误",
    'USER_ROLE_RIGHTS_ERROR' => "用户权限设置错误",
    //用户授权
    'USER_AUTH_LIST_EMPTY' => "授权用户不能为空",
    'USER_AUTH_LIST_FORMAT_ERROR' => "授权用户数据格式错误",
    'USER_AUTH_ROLE_EMPTY' => "授权角色不能为空",
    'USER_AUTH_ROLE_FORMAT_ERROR' => "授权用户角色数据格式错误",
    'USER_AUTH_PARAMS_ERROR' => "提交参数错误",
    //文章类型
    'ARTICLE_TYPE_NAME_EMPTY' => "文章类型名称不能为空",
    'ARTICLE_TYPE_SIGN_LENGTH_ERROR' => "文章类型标记长度错误",
    'ARTICLE_TYPE_SORT_TYPE_ERROR' => "文章类型排序类型错误",
    'ARTICLE_TYPE_REMARK_LENGTH_ERROR' => "文章类型备注长度错误",
    //文章列表
    'ARTICLE_DATA_TITLE_EMPTY' => "文章标题不能为空",
    'ARTICLE_DATA_EXCERPT_EMPTY' => '文章摘要不能为空',
    'ARTICLE_DATA_SOURCE_LENGTH_ERROR' => '文章来源长度错误',
    'ARTICLE_DATA_LINK_LENGTH_ERROR' => '文章外部链接长度错误',
    'ARTICLE_DATA_AUDIO_LENGTH_ERROR' => '文章音频长度错误',
    'ARTICLE_DATA_VIDEO_LENGTH_ERROR' => '文章视频长度错误',
    'ARTICLE_DATA_CONTENT_EMPTY' => '文章内容不能为空',
    'ARTICLE_DATA_SHOW_TYPE_ERROR' => '文章显示类型错误',
    'ARTICLE_DATA_COMMENT_TYPE_ERROR' => '文章评论类型错误',
    'ARTICLE_DATA_IS_TOP_ERROR' => '文章置顶类型错误',
    'ARTICLE_DATA_RECOMMENDED_TYPE_ERROR' => '文章推荐类型错误',
    'ARTICLE_DATA_HOT_TYPE_ERROR' => '文章热度类型错误',
    'ARTICLE_DATA_SORT_TYPE_ERROR' => '文章排序类型错误',
    'ARTICLE_DATA_HITS_TYPE_ERROR' => '文章查看数类型错误',
    'ARTICLE_DATA_LIKE_TYPE_ERROR' => '文章点赞数类型错误',
    'ARTICLE_DATA_FAVORITES_TYPE_ERROR' => '文章收藏数类型错误',
    'ARTICLE_DATA_COMMENT_COUNT_TYPE_ERROR' => '文章评论数类型错误',
    'ARTICLE_DATA_THUMBNAIL_LENGTH_ERROR' => '文章缩略图长度错误',
    'ARTICLE_DATA_SEO_KEYWORDS_LENGTH_ERROR' => '文章SEO关键词长度错误',
    'ARTICLE_DATA_SEO_DESCRIPTION_LENGTH_ERROR' => '文章SEO描述长度错误',
    'ARTICLE_DATA_SEO_TITLE_LENGTH_ERROR' => '文章SEO标题长度错误',
    //门户导航
    'PORTAL_NAV_NAME_EMPTY' => "导航名称不能为空",
    'PORTAL_NAV_SIGN_LENGTH_ERROR' => "导航标记长度错误",
    'PORTAL_NAV_SORT_TYPE_ERROR' => "导航排序类型错误",
    'PORTAL_NAV_REMARK_LENGTH_ERROR' => "导航备注长度错误",
    //门户幻灯片
    'PORTAL_SLIDE_NAME_EMPTY' => "幻灯片名称不能为空",
    'PORTAL_SLIDE_IMAGE_EMPTY' => "幻灯片图片不能为空",
    'PORTAL_SLIDE_SIGN_LENGTH_ERROR' => "幻灯片标记长度错误",
    'PORTAL_SLIDE_SORT_TYPE_ERROR' => "幻灯片排序类型错误",
    'PORTAL_SLIDE_REMARK_LENGTH_ERROR' => "幻灯片备注长度错误",
    'PORTAL_SLIDE_LINK_URL_ERROR' => "幻灯片外部地址错误",
    //友情链接
    'BASIS_LINK_NAME_EMPTY' => '链接名称不能为空',
    'BASIS_LINK_LINK_EMPTY' => '链接地址不能为空',
    'BASIS_LINK_LINK_URL_ERROR' => '链接地址不是有效的URL地址',
    //站点设置
    'BASIS_SITE_UPLOAD_TYPE_EMPTY' => '提交类型不能为空',
    'BASIS_SITE_UPLOAD_CONTENT_EMPTY' => '提交内容不能为空',
    'BASIS_SITE_UPLOAD_CONTENT_NOT_ARRAY' => '提交内容规则错误',
    'BASIS_SITE_UPLOAD_FILE_UPLOAD_TYPE_EMPTY' => '文件上传类型不能为空',
    'BASIS_SITE_UPLOAD_FILE_UPLOAD_SIZE_EMPTY' => '文件上传类型不能为空',
    'BASIS_SITE_UPLOAD_AUDIO_UPLOAD_TYPE_EMPTY' => '音频上传类型不能为空',
    'BASIS_SITE_UPLOAD_AUDIO_UPLOAD_SIZE_EMPTY' => '音频上传大小不能为空',
    'BASIS_SITE_UPLOAD_VIDEO_UPLOAD_TYPE_EMPTY' => '视频上传类型不能为空',
    'BASIS_SITE_UPLOAD_VIDEO_UPLOAD_SIZE_EMPTY' => '视频上传大小不能为空',
    'BASIS_SITE_UPLOAD_IMAGE_UPLOAD_TYPE_EMPTY' => '图片上传类型不能为空',
    'BASIS_SITE_UPLOAD_IMAGE_UPLOAD_SIZE_EMPTY' => '图片上传大小不能为空',
    'BASIS_SITE_SETTING_SEO_TITLE_EMPTY' => 'SEO标题不能为空',
    //通知公告
    'PORTAL_NOTICE_NAME_EMPTY' => "通知公告名称不能为空",
    'PORTAL_NOTICE_CONTENT_EMPTY' => "通知公告内容不能为空",
    //留言
    'PORTAL_MESSAGE_CONTENT_EMPTY' => '内容不能为空',
    //应用配置
    'PLUGIN_TYPE_EMPTY' => '应用配置类型不能为空',
    'PLUGIN_NAME_EMPTY' => '应用名称不能为空',
    'PLUGIN_PAGES_EMPTY' => '应用配置页面不能为空',
    'PLUGIN_VERSION_EMPTY' => '应用配置版本不能为空',
    'PLUGIN_APPID_EMPTY' => '应用授权ID不能为空',
    'PLUGIN_APPKEY_EMPTY' => '应用授权密钥不能为空',
    //未来接待量
    'CAPACITY_DATE_EMPTY' => '提交日期不能为空',
    'CAPACITY_DATA_FORMAT_ERROR' => '提交日期格式不正确',
    'CAPACITY_NUMBER_EMPTY' => '提交数量不能为空',
    'CAPACITY_NUMBER_FORMAT_ERROR' => '提交数量格式不正确',
];
