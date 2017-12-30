<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/9
 * Time: 23:51
 */
namespace App\Http\Controllers\Article;
use \App\Http\Controllers\Controller;
use \App\Library\ArticleLib;
use Illuminate\Http\Request;
class GetArticleDetail extends Controller
{
    public function __construct()
    {

    }

    /**
     * 获取文章列表
     * @param Request $request
     */
    public function getDetail(Request $request)
    {
        $articleId = $request->input('article_id', null);

        $where = array(
            'article_id'    =>  $articleId
        );

        $articleDetail = ArticleLib::getArticleDetail($where);


        $this->success($articleDetail);
    }
}