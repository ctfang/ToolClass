<?php
namespace test;

require_once 'boostrap.php';

use ToolClass\File;

// $value = File::get( './test.php' );
// var_dump( $value );

// $value = File::put( './test/test.php','123' );
// var_dump( $value );

$value = File::size( 'D:\tu.png','mb' );
var_dump( $value );


// $value = File::unlink( 'test.php' );
// var_dump( $value );


// $value = File::rmdir( './test/' );
// var_dump( $value );