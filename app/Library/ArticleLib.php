<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/2
 * Time: 23:51
 */
namespace App\Library;
use App\Library\Time;
use Themis\Article\Article;
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
            return array(
                'article_list' => array(),
                'total_page' => 1,
                'current_page' => 1,
                'page_limit' => 20,
                'total_count' => 0
            );
        }

        foreach ($articleList['article_list'] as &$singleArticle) {
            //已发布时长
            $singleArticle['has_publish_time'] = Time::getTimeLong($singleArticle['create_time'], time());
            $singleArticle['create_time'] = date('Y-m-d H:i:s', $singleArticle['create_time']);
            $singleArticle['text_content'] = str_limit($singleArticle['text_content'], 256, '...');
            //标题
            $singleArticle['title'] = '【'.Article::getIsOriginalValue($singleArticle['is_original']).'】'.$singleArticle['title'];
        }

        $parentKindId = ArrayTool::getFiled($articleList['article_list'],'parent_kind');
        $sonKind = ArrayTool::getFiled($articleList['article_list'], 'son_kind');
        $kindIds = array_unique(array_merge($parentKindId, $sonKind));

        $kindListParams = array(
            'current_page'  =>  1,
            'page_limit'    =>  count($kindIds),
            'order_field'   =>  'create_time',
            'order_rule'    =>  'DESC',
            'id'            =>  implode(',' , $kindIds),
        );

        $kindInfo = self::getArticleKind($kindListParams);

        $kindInfo = ArrayTool::toHashMap($kindInfo, 'id');
        foreach ($articleList['article_list'] as &$item){
            $item['show_kind'] = $kindInfo[$item['parent_kind']]['title'].'/'.$kindInfo[$item['son_kind']]['title'];
        }

        //处理发布的管理员姓名
        $adminIds = array_unique(ArrayTool::getFiled($articleList['article_list'],'admin_id'));

        $adminListParams = array(
            'current_page'  =>  1,
            'page_limit'    =>  count($adminIds),
            'order_field'   =>  'create_time',
            'order_rule'    =>  'DESC',
            'id'            =>  implode(',' , $adminIds),
        );
        $adminInfo = Admin::getAdminInfo($adminListParams);
        $adminInfo = ArrayTool::toHashMap($adminInfo['admin_list'], 'id');
        foreach ($articleList['article_list'] as &$item){
            $item['show_admin_name'] = $adminInfo[$item['admin_id']]['nickname'];
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
        $articleDetail['title'] = '【'.Article::getIsOriginalValue($articleDetail['is_original']).'】'.$articleDetail['title'];

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