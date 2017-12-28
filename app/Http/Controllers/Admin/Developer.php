<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/28
 * Time: 21:43
 * 获取开发者信息
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Developer extends Controller
{
    public function getDeveloperInfo(Request $request)
    {
        $developerInfo = array(
            'real_name'  =>  '张德满',
            'nick_name'  =>  '孤鸟 | 红尘狂客',
            'job'   =>  'PHP研发工程师',
            'tel'   =>  '17710580607',
            'qq'    =>  '2215508028',
            'mail'  =>  'phpcoder@yeah.net',
        );

        $this->success($developerInfo);
    }
}