<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/7
 * Time: 23:21
 */
namespace App\Http\Controllers\Article;
use \App\Http\Controllers\Controller;
use \App\Library\ArticleLib;
use Illuminate\Http\Request;

class GetNavList extends Controller
{
    public function __construct()
    {
    }

    public function getNav(Request $request)
    {
        $this->success(ArticleLib::getArticleKind());
    }
}