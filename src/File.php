<?php
namespace ToolClass;

/**
* 文件工具
*/
class File
{
    /**
     * 获取文件内容
     * @param  string $filename 路径
     * @return string      
     */
    static public function get( $filename )
    {
        if( is_file($filename) )
            return file_get_contents( $filename );
        return false;
    }
    /**
     * 写入文件
     * @param  string $filename 路径
     * @param  string $data 内容
     * @return string      
     */
    static public function put( $filename,$data='' )
    {
        $dir = dirname($filename);
        if( !is_dir($dir) ) mkdir($dir,0777,true);
        if(false === file_put_contents($filename,$data)){
            return false;
        }
        return true;
    }
    /**
     * 获取文件大小
     * @param  string $filename 路径
     * @param  string $format   kb / mb / gb
     * @return string      
     */
    static public function size( $filename,$format='' )
    {
        if( is_file($filename) ){
            $size = filesize( $filename );
            if ( !$format ) {
                return $size;
            }else{
                $p = 0;
                $format = strtolower( $format );
                if ($format == 'kb') {  
                    $p = 1;  
                } elseif ($format == 'mb') {  
                    $p = 2;  
                } elseif ($format == 'gb') {  
                    $p = 3;  
                }  
                $size /= pow(1024, $p);  
                return $size;
            }
        }
        return false;
    }


    /**
     * 文件删除
     * @access public
     * @param string $filename  文件名
     * @return boolean     
     */
    static public function unlink($filename){
        return is_file($filename) ? unlink($filename) : false;
    }

    /**
     * 文件删除
     * @access public
     * @param string $dir  目录
     * @return boolean     
     */
    static public function rmdir($dir){
        if( !is_dir($dir) ) return false;

        $hb = opendir($dir);
        while ( $file=readdir( $hb ) ) {
            if( $file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    self::rmdir($fullpath);
                }
            }
        }
        closedir($hb);

        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }

}