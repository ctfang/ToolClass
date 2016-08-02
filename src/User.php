<?php
namespace ToolClass;

/**
* 常用用户信息验证 工具
*/
class User
{
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
    static public function is_password( $string,$config=[] )
    {
        
    }
}