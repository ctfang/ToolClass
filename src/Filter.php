<?php
namespace ToolClass;

/**
* 验证 工具
*/
class Filter
{
    /**
     * 手机验证
     * @param  string  $variable 
     * @return boolean           
     */
    static public function is_phone($variable)
    {
        if( !preg_match("/^1[34578]{1}\d{9}$/",$variable) ){  
            return false;
        }else{  
            return true;
        }
    }
    /**
     * 整数验证
     * @param  string  $variable 
     * @param  array   $int_options array("min_range"=>0, "max_range"=>256);
     * @return boolean           
     */
    static public function is_int($variable,$options=[])
    {
        if( !$options ){
            if( !filter_var($variable, FILTER_VALIDATE_INT) ){
                return false;
            }
            return true;
        }else{
            $int_options = array("options"=>$options);
            if( !filter_var($variable, FILTER_VALIDATE_INT,$int_options) ){
                return false;
            }
            return true;
        }
    }
    /**
     * 简单只需要一个参数的 filter_var 过滤
     * @param  string   $func  调用方法
     * @param  array    $param 参数
     * @return boolean        
     */
    public static function __callStatic($func, $param)
    {
        $filter = 'validate_'.end( explode('is_', $func) );
        if( in_array($filter,filter_list()) ){
            if( !filter_var($param['0'], filter_id($filter)) ){
                return false;
            }
            return true;
        }else{
            die('没有'.$func);
        }
    }
}