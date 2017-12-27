<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/2
 * Time: 23:51
 */
namespace App\Library;

class ArticleLib extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取文章类别
     * @return bool
     */
    public static function getArticleKind($params)
    {
        $list = self::curl('get_article_kind', $params);
        $list = $list['article_kind_list'];
        return $list;
    }

    /**
     * 获取文章列表
     * @param array $params
     * @return bool
     */
    public static function getArticleList(array $params = array())
    {
        $articleList = self::curl('get_article_list', $params);
        if (empty($articleList)) {
            return array();
        }

        foreach ($articleList['article_list'] as &$singleArticle) {
            $singleArticle['create_time'] = date('Y-m-d H:i:s', $singleArticle['create_time']);
            $singleArticle['text_content'] = str_limit($singleArticle['text_content'], 256, '...');
        }

        return $articleList;
    }

    /**
     * 获取文章详情
     * @param array $params
     * @return bool
     */
    public static function getArticleDetail(array $params = array())
    {
        return self::curl('get_article_detail', $params);
    }

}