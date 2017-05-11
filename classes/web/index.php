<?php
echo "<meta charset=utf-8>";
include 'InputField.php';
include 'Row.php';
include 'Content.php';
include 'PanelBody.php';
include 'PanelHeading.php';
	
$inp = new InputField( "submit", false, "best_id" );
$inp->setStyle( 100 );
$inp->setValue( "I set the value for this input!" );
echo $inp->getHTMLCode();

echo "<hr>";

$con = new Content( "A simple text" );
$con->setStyle( 80 );
echo $con->getHTMLCode();

echo "<hr>";

$pb = new PanelBody();
$pb->push( $inp->getHTMLCode() );
$pb->push( $con->getHTMLCode() );
echo $pb->getHTMLCode();
	
echo "<hr>";	
	
$ph = new PanelHeading( "A best title!" );
echo $ph->getHTMLCode();	
?>	