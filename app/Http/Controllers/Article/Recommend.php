<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/28
 * Time: 22:25
 * 推荐文章
 */

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Library\ArticleLib;
use Illuminate\Http\Request;

class Recommend extends Controller
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
        $this->success($articleList['article_list']);
    }
}