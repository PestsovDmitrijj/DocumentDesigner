<?php
echo "<meta charset=utf-8>";
include 'Input.php';
include 'Row.php';

$inp = new Input( "select", 6, "this is a test input", false, false, "1" );
$inp2 = new Input( "select", 6, "this is a second test input", false, false, 2 );
$row = new Row();
$row->pushInput($inp);
$row->pushInput($inp2);
$row->printInputs();	

?>	