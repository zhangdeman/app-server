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
    /**
     * 格式化时间
     * @param $time 时间戳
     * @param string $format 格式
     * @return false|string
     */
    public static function formatTime($time, $format= 'Y-m-d H:i:s')
    {
        return date($format, $time);
    }

    /**
     * 获取两个时间之间的时间差
     * @param $leftTime 时间戳左值
     * @param $rightTime 时间戳 右值
     * @return string
     */
    public static function getTimeLong($leftTime, $rightTime)
    {
        $leave = $rightTime - $leftTime;
        $str = '';
        //计算天
        $day = floor($leave / (24 * 3600));
        if ($day >= 1) {
            $str .= $day.' 天 ';
        }

        $hour = $leave - ($day * 24 * 3600);
        //计算小时
        $leaveHour = floor($hour / 3600);
        if ($leaveHour >= 1) {
            $str .= $leaveHour.' 小时 ';
        }

        //计算分
        $min = $hour - $leaveHour * 3600;
        $leaveMin = ceil($min / 60);
        $str .= $leaveMin.' 分钟 ';

        return $str;
    }
}