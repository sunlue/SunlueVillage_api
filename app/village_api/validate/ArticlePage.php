<?php

namespace app\village_api\validate;

use app\village_api\model\PortalArticleData;
use app\village_api\model\PortalArticlePage;
use think\Validate;

class ArticlePage extends Validate {
    protected $rule = [
        'uniqid' => 'require|uniques',
        'title' => 'require',
        'excerpt' => 'require',
        'source' => 'max:150',
        'link' => 'max:100',
        'audio' => 'max:100',
        'video' => 'max:100',
        'content' => 'require',
        'show' => 'number',
        'comment' => 'number',
        'is_top' => 'number',
        'recommended' => 'number',
        'hot' => 'number',
        'sort' => 'number',
        'hits' => 'number',
        'like' => 'number',
        'favorites' => 'number',
        'comment_count' => 'number',
        'thumbnail' => 'max:100',
        'seo_keywords' => 'max:150',
        'seo_description' => 'max:255',
        'seo_title' => 'max:100',
        'field' => 'require',
        'value' => 'require'
    ];

    protected $message = [
        'uniqid.require' => 'UNIQID_EMPTY1',
        'uniqid.uniques' => 'UNIQID_EMPTY2',
        'title.require' => 'ARTICLE_DATA_TITLE_EMPTY',
        'excerpt.require' => 'ARTICLE_DATA_EXCERPT_EMPTY',
        'source.max' => 'ARTICLE_DATA_SOURCE_LENGTH_ERROR',
        'link.max' => 'ARTICLE_DATA_LINK_LENGTH_ERROR',
        'audio.max' => 'ARTICLE_DATA_AUDIO_LENGTH_ERROR',
        'video.max' => 'ARTICLE_DATA_VIDEO_LENGTH_ERROR',
        'content.require' => 'ARTICLE_DATA_CONTENT_EMPTY',
        'show.number' => 'ARTICLE_DATA_SHOW_TYPE_ERROR',
        'comment.number' => 'ARTICLE_DATA_COMMENT_TYPE_ERROR',
        'is_top.number' => 'ARTICLE_DATA_IS_TOP_ERROR',
        'recommended.number' => 'ARTICLE_DATA_RECOMMENDED_TYPE_ERROR',
        'hot.number' => 'ARTICLE_DATA_HOT_TYPE_ERROR',
        'sort.number' => 'ARTICLE_DATA_SORT_TYPE_ERROR',
        'hits.number' => 'ARTICLE_DATA_HITS_TYPE_ERROR',
        'like.number' => 'ARTICLE_DATA_LIKE_TYPE_ERROR',
        'favorites.number' => 'ARTICLE_DATA_FAVORITES_TYPE_ERROR',
        'comment_count.number' => 'ARTICLE_DATA_COMMENT_COUNT_TYPE_ERROR',
        'thumbnail.max' => 'ARTICLE_DATA_THUMBNAIL_LENGTH_ERROR',
        'seo_keywords.max' => 'ARTICLE_DATA_SEO_KEYWORDS_LENGTH_ERROR',
        'seo_description.max' => 'ARTICLE_DATA_SEO_DESCRIPTION_LENGTH_ERROR',
        'seo_title.max' => 'ARTICLE_DATA_SEO_TITLE_LENGTH_ERROR',
        'field.require' => 'FIELD_EMPTY',
        'value.require' => 'VALUE_EMPTY'
    ];

    protected function sceneCreate() {
        return $this->only(['title', 'excerpt', 'source', 'link', 'audio', 'video', 'content', 'show', 'comment', 'is_top', 'recommended', 'hot', 'sort', 'hits', 'like', 'favorites', 'comment_count', 'thumbnail', 'seo_keywords', 'seo_description', 'seo_title']);
    }

    protected function sceneUpdate() {
        return $this->only(['uniqid','title', 'excerpt', 'source', 'link', 'audio', 'video', 'content', 'show', 'comment', 'is_top', 'recommended', 'hot', 'sort', 'hits', 'like', 'favorites', 'comment_count', 'thumbnail', 'seo_keywords', 'seo_description', 'seo_title']);
    }

    protected function sceneDelete() {
        return $this->only(['uniqid']);
    }

    protected function sceneField() {
        return $this->only(['uniqid'])
            ->append('field', 'require')
            ->append('value', 'require');
    }

    protected function uniques($value) {
        return PortalArticlePage::getFind(array(
            'uniqid' => $value
        )) ? true : false;
    }
}