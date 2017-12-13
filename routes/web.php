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
