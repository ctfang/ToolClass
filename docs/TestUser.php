<?php
namespace test;

require_once 'boostrap.php';

use ToolClass\User;

$value = User::is_username( 'fdsfs' );
var_dump( $value );