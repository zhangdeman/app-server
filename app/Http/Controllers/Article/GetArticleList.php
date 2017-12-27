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
class GetArticleList extends Controller
{
    public function __construct()
    {

    }

    /**
     * 获取文章列表
     * @param Request $request
     */
    public function getList(Request $request)
    {
        $articleParentType = $request->input('parent_type', null);
        $articleSonType = $request->input('son_type', null);
        $where = array();
        if (!is_null($articleParentType)) {
            $where['parent_kind'] = $articleParentType;
        }

        if (!is_null($articleSonType)) {
            $where['son_kind'] = $articleSonType;
        }

        $where['page_size'] = $request->input('page_size', 20);
        $where['current_page'] = $request->input('current_page', 1);
        $where['order_field'] = 'create_time';
        $where['order_rule'] = 'desc';

        $articleList = ArticleLib::getArticleList($where);
        $this->success($articleList);
    }
}