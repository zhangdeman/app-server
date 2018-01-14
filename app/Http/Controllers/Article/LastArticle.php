<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/30
 * Time: 20:22
 * 获取最近的文章
 */

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\ArrayTool;
use App\Library\ArticleLib;

class LastArticle extends Controller
{
    public function __construct()
    {
    }

    public function getList(Request $request)
    {
        $params = array(
            'current_page'  =>  1,
            'page_limit'    =>  3,
            'order_field'   =>  'create_time',
            'order_rule'    =>  'DESC'
        );
        $articleList = ArticleLib::getArticleList($params);
        $articleList = $articleList['article_list'];

        $this->success($articleList);
    }
}