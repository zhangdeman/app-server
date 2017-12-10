<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/11/20
 * Time: 22:38
 */
namespace App\Library;
use Curl\Curl;

class BaseLibrary
{
    public static $instance = null;
    //请求错误码
    protected static $errorCode = 0;
    //请求错误信息
    protected static $errorMsg = '';

    public function __construct()
    {
    }

    /**
     * @return BaseLibrary|null
     * 获取当前类实例
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 生成请求签名
     * @param $params 请求参数
     * @return string
     */
    public static function genSign($params)
    {
        $signKey = env('REQUEST_BASE_SERVICE_KEY');
        ksort($params);
        $str = http_build_query($params).'&'.$signKey;
        return md5($str);
    }

    /**
     * 格式化请求参数
     * @param $params
     * @return mixed
     */
    public static function formatParams($params)
    {
        //此处统一添加请求来源
        $params['from'] = 'admin_server';
        foreach ($params as $key => $value) {
            if (is_bool($value)) {
                $params[$key] = intval($value);
            }
            $params[$key] = strval($value);
        }
        return $params;
    }

    /**
     * @param $configKey 请求的配置
     * @return bool
     * 发送curl请求
     */
    public static function curl($configKey, $params = array())
    {
        $baseConfig = config('api.base');
        $config = config("api.{$configKey}");
        if (empty($baseConfig) || empty($config)) {
            //设置错误码
            return false;
        }
        $requestUrl = "{$baseConfig['protocol']}://{$baseConfig['ip']}:{$baseConfig['port']}{$config['uri']}";

        $method = $config['method'];
        $headers = $config['header'];
        $options = $config['options'];
        $connectTime = $config['connect_time_out'];
        $executeTime = $config['execute_time_out'];
        $retryTimes = $config['retry_times'];

        $curlInstance = new Curl($requestUrl);
        $curlInstance->setHeaders($headers);
        $curlInstance->setOpts($options);
        if ($connectTime > 0) {
            //设置连接超时时间
            $curlInstance->setConnectTimeout($connectTime);
        }

        if ($executeTime > 0) {
            //设置请求超时时间
            $curlInstance->setTimeout($executeTime);
        }

        $requestResult = false;
        for ($reqTime = 0; $reqTime <= $retryTimes; $reqTime++) {
            if ('post' == strtolower($method)) {
                $requestResult = $curlInstance->post($requestUrl, $params);
            } else {
                $requestResult = $curlInstance->get($requestUrl, $params);
            }
            if (!empty($requestResult)) {
                break;
            }
        }

        $httpCode = $curlInstance->getInfo(CURLINFO_HTTP_CODE);

        if (200 == $httpCode && $requestResult) {
            $returnData = json_decode($requestResult, true);
            self::setErrorCode($returnData['error_code']);
            self::setErrorMsg($returnData['error_msg']);
            if ($returnData['error_code'] == 0) {
                return $returnData['data'];
            }
            return false;
        } else {
            self::setErrorCode(999);
            self::setErrorMsg('请求异常');
            return false;
        }
    }

    /**
     * 设置请求错误码
     * @param $errorCode
     */
    public static function setErrorCode($errorCode)
    {
        self::$errorCode = $errorCode;
    }

    /**
     * 设置请求错误信息
     * @param $errorMsg
     */
    public static function setErrorMsg($errorMsg)
    {
        self::$errorMsg = $errorMsg;
    }

    /**
     * 获取错误码
     * @return int
     */
    public static function getErrorCode()
    {
        return self::$errorCode;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public static function getErrorMsg()
    {
        return self::$errorMsg;
    }
}