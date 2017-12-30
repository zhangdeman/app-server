<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/30
 * Time: 20:36
 * 获取客户端信息
 */

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetClientInfo extends Controller
{
    public function __construct()
    {
    }

    public function getInfo(Request $request)
    {
        $info = array(
            'ip'    =>  $request->getClientIp()
        );
        $this->success($info);
    }
}