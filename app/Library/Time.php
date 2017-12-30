<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/30
 * Time: 16:10
 * 时间操作类库
 */

namespace App\Library;

class Time extends BaseLibrary
{
    public static function formatTime($time, $format= 'Y-m-d H:i:s')
    {
        return date($format, $time);
    }
}