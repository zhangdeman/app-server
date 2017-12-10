<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Themis\Api\Out;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 输出成功的信息
     * @param $data
     * @param bool $isQuit
     */
    public function success($data, $isQuit = true)
    {
        header('Access-Control-Allow-Origin:*');

        $returnData = array(
            'error_code'    => 0,
            'error_msg'     =>  'success',
            'data'          =>  $data
        );
        echo json_encode($returnData);
        if ($isQuit) {
            exit(0);
        }

        //完成请求提前返回，但可以继续后续逻辑
        fastcgi_finish_request();
    }

    /**
     * 输出错误信息
     * @param $errorCode
     * @param string $errorMsg
     * @param array $errorData
     * @param bool $isQuit
     */
    public function error($errorCode, $errorMsg = '', $errorData = array(), $isQuit = true)
    {
        header('Access-Control-Allow-Origin:*');
        $errorMsg = empty($errorMsg) ? Out::getErrorMsg($errorCode) : $errorMsg;
        $outData = array(
            'error_code'    =>  $errorCode,
            'error_msg'     =>  $errorMsg,
            'data'          =>  $errorData
        );
        echo json_encode($outData);
        if ($isQuit) {
            exit(0);
        }
        fastcgi_finish_request();
    }
}
