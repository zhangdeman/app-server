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
     * @return array
     */
    public static function getArticleDetail(array $params = array())
    {
        $articleDetail = self::curl('get_article_detail', $params);
        if (empty($articleDetail)) {
            return array();
        }

        $articleDetail['create_time'] = Time::formatTime($articleDetail['create_time']);

        //类别信息
        $params = array(
            'id'    =>  $articleDetail['parent_kind'].','.$articleDetail['son_kind'],
            'current_page' => 1,
            'page_limit'    =>  1,
        );
        $kindInfo = self::getArticleKind($params);
        $kindInfo = ArrayTool::toHashMap($kindInfo, 'id');
        $articleDetail['show_kind'] = $kindInfo[$articleDetail['parent_kind']]['title'].'/'.$kindInfo[$articleDetail['son_kind']]['title'];
        //作者信息
        $adminParams = array(
            'id'    =>  $articleDetail['admin_id'],
            'current_page' => 1,
            'page_limit'    =>  1,
        );
        $adminInfo = Admin::getAdminInfo($adminParams);
        $articleDetail['author_name'] = $adminInfo['admin_list'][0]['nickname'];

        return $articleDetail;
    }

}