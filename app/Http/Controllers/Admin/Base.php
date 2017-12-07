<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/10/28
 * Time: 20:31
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class Base extends Controller
{
    /**
     * @var array
     * @desc 管理员信息
     */
    public static $adminInfo = array();
    public function __construct()
    {
    }

    /**
     * @param $token 参数中的token
     * @return array
     * @author phpcoder@yeah.net
     */
    public static function validateToken($token)
    {
        $adminInfo = array();
        return $adminInfo;
    }
}