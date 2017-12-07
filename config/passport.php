<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/10/28
 * Time: 20:37
 * @desc passport接口配置文件
 */

return [
    'validate_token_url'    =>  env('validate_token','http://127.0.0.1/passport/validate'),
    'create_token_url'      =>  env('create_token','http://127.0.0.1/passport/login'),
    'destroy_token_url'     =>  env('destroy_token','http://127.0.0.1/passport/logout'),
    ];