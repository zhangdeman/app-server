<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/10/28
 * Time: 20:46
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin;

class Test extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 12345;
    }
}