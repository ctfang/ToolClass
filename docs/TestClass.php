<?php
namespace test;

require_once 'boostrap.php';

use ToolClass\ClassFile;

$value = ClassFile::classinfo( '../src/File.php' );
p( $value );

