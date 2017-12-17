<?php
/**
 * Created by PhpStorm.
 * User: zhangdeman
 * Date: 2017/12/17
 * Time: 20:27
 */
namespace App\Library;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Log\Writer;

class MyLog
{
    // 所有的LOG都要求在这里注册
    const LOG_DEBUG = 'debug';
    const LOG_INFO  = 'info';
    const LOG_NOTICE= 'notice';
    const LOG_WARNING = 'warning';
    const LOG_ERROR = 'error';
    const LOG_CRITICAL = 'critical';
    const LOG_ALERT = 'alert';

    private static $loggers = array();

    // 获取一个实例
    public static function getLogger($type = self::LOG_ERROR, $day = 30)
    {
        if (empty(self::$loggers[$type])) {
            self::$loggers[$type] = new Writer(new Logger($type));
            self::$loggers[$type]->useDailyFiles(storage_path().'/logs/'. $type .'.log', $day);
        }

        $log = self::$loggers[$type];
        return $log;
    }

    /**
     * 记录debug日志
     * @param $message
     */
    public static function debug($message)
    {
        self::log($message, self::LOG_DEBUG);
    }

    /**
     * 记录info日志
     * @param $message
     */
    public static function info($message)
    {
        self::log($message, self::LOG_INFO);
    }

    /**
     * 记录notice日志
     * @param $message
     */
    public static function notice($message)
    {
        self::log($message, self::LOG_NOTICE);
    }

    /**
     * 记录warning日志
     * @param $message
     */
    public static function warning($message)
    {
        self::log($message, self::LOG_WARNING);
    }

    /**
     * 记录warning日志
     * @param $message
     */
    public static function error($message)
    {
        self::log($message, self::LOG_ERROR);
    }

    /**
     * 记录critical日志
     * @param $message
     */
    public static function critical($message)
    {
        self::log($message, self::LOG_CRITICAL);
    }

    /**
     * 记录alert日志
     * @param $message
     */
    public static function alert($message)
    {
        self::log($message, self::LOG_ALERT);
    }

    /**
     * 记录日志
     * @param $message 日志内容
     * @param string $type 日志类型
     */
    public static function log($message, $type = self::LOG_INFO)
    {
        $message = is_object($message) ? (array)$message : $message;
        $logInfo = is_array($message) ? 'log_data='.json_encode($message) : 'log_data='.$message;

        $logInstance = self::getLogger($type, 30);
        switch ($type) {
            case self::LOG_DEBUG:
                $logInstance->debug($logInfo);
                break;
            case self::LOG_INFO:
                $logInstance->info($logInfo);
                break;
            case self::LOG_NOTICE:
                $logInstance->notice($logInfo);
                break;
            case self::LOG_WARNING:
                $logInstance->warning($logInfo);
                break;
            case self::LOG_ERROR:
                $logInstance->error($logInfo);
                break;
            case self::LOG_CRITICAL:
                $logInstance->critical($logInfo);
                break;
            case self::LOG_ALERT:
                $logInstance->alert($logInfo);
                break;
            default:
        }
    }
}