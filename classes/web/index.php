<?php
echo "<meta charset=utf-8>";
include 'InputField.php';
include 'Row.php';
include 'Content.php';
	
$inp = new InputField( "submit", false, "best_id" );
$inp->setStyle( 100 );
$inp->setValue( "I set the value for this input!" );
echo $inp->getHTMLCode();

$con = new Content( "A simple text" );
$con->setStyle( 80 );
echo $con->getHTMLCode();
	
?>	