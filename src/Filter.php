<?php
namespace ToolClass;

/**
* 验证 工具
*/
class Filter
{
    /**
     * 验证是否是邮件格式
     * @param  string  $variable 
     * @return boolean           
     */
    static public function is_email($variable)
    {
        if( !filter_var($variable, FILTER_VALIDATE_EMAIL) ){
            return false;
        }
        return true;
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
}