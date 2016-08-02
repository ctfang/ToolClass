<?php
namespace ToolClass;

/**
* String 工具
*/
class StringTool
{
    /**
     * 判断字符串里是否包含另外的字符串
     * @param  string  $haystack 被搜索着
     * @param  string  $needle   寻找的值
     * @return boolean           
     */
    static public function is_have($haystack,$needle){
        if( strpos($haystack, $needle)===false ){
            return false;
        }
        return true;
    }
    /**
     * 获取字符串里中，某段字符串之后的字符，不包括搜索本身
     * @param  string  $haystack 被搜索着
     * @param  string  $needle   寻找的值
     * @return string           
     */
    static public function substring($haystack,$needle){
        return substr(strstr($haystack,$needle), strlen($needle));
    }
    /**
     * 字符串转换成utf8
     * @param  string  $string 转换者
     * @return string           
     */
    static public function to_utf8($string){
        $encode = mb_detect_encoding( $string, array('ASCII','UTF-8','GB2312','GBK'));
        if ( $encode !=='UTF-8' ){
            $string = iconv($encode,'UTF-8',$string);
        }
        return $string;
    }
}