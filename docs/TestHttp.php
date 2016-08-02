<?php
namespace test;

require_once 'boostrap.php';

use ToolClass\Http;

$value = Http::post( 'http://localhost/PXJG/',['time'=>time()] );
p( $value );



