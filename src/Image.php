<?php
namespace ToolClass;

class Image
{
    /**
     * @param $base64 图片字符串
     * @param $saveDir 保存目录
     * @param int $maxSize 最大允许，字节
     * @return bool|string
     */
    static public function base64($base64,$saveDir,$maxSize=0)
    {
        if( strpos($base64,',')!==false ){
            $img = substr(strstr($base64, ','),1);
            $img = str_replace(' ', '+', $img);
            $img = base64_decode($img);
        }else{
            $img = $base64;
        }
        if( $maxSize ){
            if( strlen($img)>$maxSize ){
                return false;
            }
        }
        if( !file_exists($saveDir) ){
            mkdir($saveDir,0775,true);
            file_put_contents($saveDir.'/index.html', '');// 安全目录
        }
        $fileName = uniqid('base64');
        $filePath = $saveDir.'/'.$fileName;
        file_put_contents($filePath,$img);
        return $filePath;
    }
}