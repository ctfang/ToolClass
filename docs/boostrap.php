<?php
/**
 * 自动加载文件
 * @var [type]
 */
$json = file_get_contents('../composer.json');

$json = json_decode($json,true);

$arr_namepase = [];

if( is_array($json) ){
    // composer 字段加载解析
    $arr_namepase = $json['autoload']['psr-4'];
}

function autoload_src($class){
    $arr_namepase = $GLOBALS['arr_namepase'];
    foreach ($arr_namepase as $key => $value) {
        if( strpos($class, $key)!==false ){
            $class = str_replace($key, '../'.$value, $class).'.php';
            if( is_file($class) ){
                require_once $class;return true;
            }
        }
    }
}

spl_autoload_register('autoload_src');

//输出调试
function p(){
    $args=func_get_args();
    foreach($args as $value){
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }
}


