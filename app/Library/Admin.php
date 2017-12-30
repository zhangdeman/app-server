<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/30
 * Time: 16:36
 * 管理员操作
 */

namespace App\Library;

class Admin extends BaseLibrary
{
    /**
     * 获取管理员信息
     * @param $params
     * @return bool
     */
    public static function getAdminInfo($params)
    {
        $adminInfo = self::curl('get_admin_list', $params);
        return $adminInfo;
    }
}