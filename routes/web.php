<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/article/getNavList', function (Request $request){
    $instance = new \App\Http\Controllers\Article\GetNavList();
    $instance->getNav($request);
});

Route::get('/article/getArticleList', function (Request $request){
    $instance = new \App\Http\Controllers\Article\GetArticleList();
    $instance->getList($request);
});

Route::get('/article/getArticleDetail', function (Request $request){
    $instance = new \App\Http\Controllers\Article\GetArticleDetail();
    $instance->getDetail($request);
});

Route::get('/developer/getDevelopInfo', function (Request $request){
    $instance = new \App\Http\Controllers\Admin\Developer();
    $instance->getDeveloperInfo($request);
});

Route::get('/recommend/getList', function (Request $request){
    $instance = new \App\Http\Controllers\Article\Recommend();
    $instance->getList($request);
});

Route::get('/hotArticle/getList', function (Request $request){
    $instance = new \App\Http\Controllers\Article\HotArticle();
    $instance->getList($request);
});

Route::get('/author/getAuthorInfo', function (Request $request){
    $instance = new \App\Http\Controllers\Article\HotArticle();
    $instance->getList($request);
});

//获取客户端信息
Route::get('/client/getClientInfo', function (Request $request){
    $instance = new \App\Http\Controllers\Auth\GetClientInfo();
    $instance->getInfo($request);
});

//获取最近文章信息
Route::get('/article/lastArticle', function (Request $request){
    $instance = new \App\Http\Controllers\Article\LastArticle();
    $instance->getList($request);
});
