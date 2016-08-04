<?php
namespace ToolClass;

/**
* 常用用户信息验证 工具
*/
class User
{
    /**
     * 验证用户名
     * @param  string  $string 用户名
     * @param  array   $config 配置
     * @return boolean         
     */
    static public function is_username( $string,$config=[] )
    {
        $default_con = [
            'min'=>2,
            'max'=>20,
        ];
        $config = array_merge($default_con,$config);
        $strlen = strlen($string);
        if( $strlen>$config['max'] || $strlen<=$config['min'] ){
            return false;
        }
        if( !preg_match('/^[a-zA-Z\x4E00-\xFA29][a-zA-Z0-9_\x4E00-\xFA29]+$/',$string) ){
            return false;
        }
        return true;
    }
    /**
     * 验证用户密码
     * @param  string  $value  密码
     * @param  integer $minLen 最短
     * @param  integer $maxLen 最长
     * @return boolean         
     */
    static public function is_password( $value,$minLen=5,$maxLen=16 )
    {
        $match='/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{'.$minLen.','.$maxLen.'}$/';
        $v = trim($value);
        if(empty($v)) 
            return false;
        return preg_match($match,$v);
    }
}