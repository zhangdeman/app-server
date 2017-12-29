<?php
/**
 * Created by PhpStorm.
 * User: didi
 * Date: 17/12/18
 * Time: 11:21
 */
namespace App\Library;
class ArrayTool
{
    /**
     * 对数组数据进行分组
     * @param array $dataSource 数据源
     * @param       $groupField 分组的字段
     * @param array $leaveFieldList 分组后保留的字段
     * @param null  $defaultValue 保留字段不存在时的默认值
     * @return array
     */
    public static function group(array $dataSource, $groupField, $leaveFieldList = array(), $defaultValue = null)
    {
        $groupArray = array();
        foreach ($dataSource as $key => $value) {
            $groupFieldValue = self::safeValue($value, $groupField, NULL);
            if (is_null($groupFieldValue)) {
                //分组的key不存在，丢弃
                continue;
            }

            $value = self::dataFilter($value, $leaveFieldList, $defaultValue);
            if (isset($groupArray[$groupFieldValue])) {
                $groupArray[$groupFieldValue][] = $value;
            } else {
                $groupArray[$groupFieldValue] = array($value);
            }
        }
        return $groupArray;
    }

    /**
     * 安全的从速组中取出一个key的值
     * @param      $dataSource 数据源
     * @param      $key 要获取的key, 支持多级获取.分割
     * @param null $defaultValue 不存在时的默认值
     * @return mixed|null
     */
    public static function safeValue($dataSource, $key, $defaultValue = NULL)
    {
        $dataSource = is_object($dataSource) ? (array)$dataSource : $dataSource;
        if (!is_array($dataSource)) {
            return $defaultValue;
        }

        $keyList = explode('.', $key);
        $returnValue = $dataSource;
        foreach ($keyList as $item) {
            $returnValue = isset($returnValue[$key]) ? $returnValue[$key] : $defaultValue;
            if (is_null($returnValue)) {
                break;
            }
        }
        return $returnValue;
    }

    /**
     * 数组只保留指定字段
     * @param array $dataSource 数据源
     * @param array $getFieldList 保留的字段列表
     * @param null  $defaultValue 字段不存在时默认值
     * @return array
     */
    public static function dataFilter(array $dataSource, $getFieldList = array(), $defaultValue = NULL)
    {
        if (empty($getFieldList)) {
            return $dataSource;
        }

        $returnData = array();

        foreach ($getFieldList as $field) {
            $returnData[$field] = self::safeValue($dataSource, $field, $defaultValue);
        }

        return $returnData;
    }

    /**
     * 集合二维数组指定的key值
     * @param $dataSource
     * @param $key
     * @return array
     */
    public static function getFiled($dataSource, $key)
    {
        if (is_object($dataSource)) {
            $dataSource = (array)$dataSource;
        }
        $returnData = array();
        foreach ($dataSource as $item) {
            if (isset($item[$key])) {
                $returnData[] = $item[$key];
            }
        }
        return $returnData;
    }

    /**
     * 转换为 key => value
     * @param $dataSource
     * @param $field
     * @param array $leaveField
     * @return array
     */
    public static function toHashMap($dataSource, $field, $leaveField = array())
    {
        $returnData = array();
        foreach ($dataSource as $item) {
            if (!isset($item[$field])) {
                continue;
            }
            $returnData[$item[$field]] = self::dataFilter($item, $leaveField);
        }
        return $returnData;
    }
}