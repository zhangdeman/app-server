<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/28
 * Time: 22:25
 * 获取热门文章
 */

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Library\ArrayTool;
use App\Library\ArticleLib;
use Illuminate\Http\Request;

class HotArticle extends Controller
{
    public function __construct()
    {
    }

    public function getList(Request $request)
    {
        $params = array(
            'current_page'  =>  1,
            'page_limit'    =>  10,
            'order_field'   =>  'create_time',
            'order_rule'    =>  'DESC'
        );
        $articleList = ArticleLib::getArticleList($params);
        $articleList = $articleList['article_list'];
        $parentKindId = ArrayTool::getFiled($articleList,'parent_kind');
        $sonKind = ArrayTool::getFiled($articleList, 'son_kind');
        $kindIds = array_unique(array_merge($parentKindId, $sonKind));

        $kindListParams = array(
            'current_page'  =>  1,
            'page_limit'    =>  count($kindIds),
            'order_field'   =>  'create_time',
            'order_rule'    =>  'DESC',
            'id'            =>  implode(',' , $kindIds),
        );

        $kindInfo = ArticleLib::getArticleKind($kindListParams);

        $kindInfo = ArrayTool::toHashMap($kindInfo, 'id');
        foreach ($articleList as &$item){
            $item['show_kind'] = $kindInfo[$item['parent_kind']]['title'].' -- '.$kindInfo[$item['son_kind']]['title'];
        }

        $this->success($articleList);
    }
}