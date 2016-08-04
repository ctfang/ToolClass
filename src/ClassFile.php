<?php
namespace ToolClass;

/**
* 类文件 工具
* 文件名必须和类名有关系
*/
class ClassFile
{
    /**
     * 获取文件里的类名
     * @param  string $filename 路径
     * @return array      
     */
    static public function classinfo( $filename )
    {
        if( !is_file($filename) ) return false;
        
        $content = file_get_contents( $filename );
        // 获取类名称calssname
        $pathinfo     = pathinfo($filename);
        $string       = strstr($content, '{',true);
        $calssname    = strstr($string, $pathinfo['filename']);
        $calssname    = reset( explode(' ', $calssname) );
        $calssname    = trim( str_replace(array('
'),'',$calssname) );// 替换换行
        if( empty($calssname) ) return false;

        // 获取注释
        if( $notes = strstr($string,'/*') ){
            // 多行注释
            $notes = strstr($notes,'*/',true);
        }elseif( $notes = strstr($string,'//') ){
            // 单行注释
            $notes = strstr($notes,'class ',true);
        }else{
            // 没有注释
            $notes = $pathinfo['filename'].' class';
        }
        $notes = trim( str_replace(array('/','*','
'),'',$notes) );// 替换换行
        return ['name'=>$calssname,'notes'=>$notes,'function'=>self::functioninfo( $filename )];
    }
    /**
     * 获取类的方法信息
     * @param  string $filename 路径
     * @return array      
     */
    static public function functioninfo( $filename )
    {
        if( !is_file($filename) ) return false;
        
        $content    = file_get_contents( $filename );

        $content    = strstr($content, '{');

        preg_match_all('/[^\}\{]+(?:public|protected|private|static) function [^\(]+\(/', $content, $arr);

        $arr        = $arr['0'];

        foreach ($arr as $value) {
            // 获取方法名称
            $list['name']   = trim( substr(strstr(strstr($value, '(',true), ' function '),strlen(' function ')) );

            // 获取注释
            if( $remark = strstr($value,'/*') ){
                // 多行注释
                $remark = strstr($remark,'*/',true);
            }elseif( $remark = strstr($string,'//') ){
                // 单行注释
                $remark = strstr($remark,'class ',true);
            }else{
                // 没有注释
                $remark = $list['name'].' function';
            }
            $remark = trim( str_replace(array('/','*','
'),'',$remark) );// 替换换行
            $param = [];
            if( strpos($remark, '@')){
                $notes = strstr($remark, '@',true);
                $param = explode( '@',$remark);
                unset($param['0']);
            }
            $list['notes']  = $notes;
            $list['param']  = $param;

            $return[] = $list;
        }
        return $return;
    }

}