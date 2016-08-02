<?php
namespace test;

require_once 'boostrap.php';

use ToolClass\StringTool;

$value = StringTool::substring("Hello world! world2 world3","world");
p( $value );


$string = iconv('UTF-8','gbk','你好世界');
$value = StringTool::to_utf8( $string );
p( mb_detect_encoding( $value, array('ASCII','UTF-8','GB2312','GBK')) );

