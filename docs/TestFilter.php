<?php
namespace test;

require_once 'boostrap.php';

use ToolClass\Filter;

$value = Filter::is_email( 'tet@hh.com' );
var_dump( $value );

$value = Filter::is_int( 9 ,['min_range'=>0,'max_range'=>200]);
var_dump( $value );

$value = Filter::is_url( 'http://www.w3school.com.cn/php/php_ref_filter.asp' );
var_dump( $value );

$value = Filter::is_ip( '192.168.1.1' );
var_dump( $value );


$value = Filter::is_mobile( '15189046469' );
var_dump( $value );