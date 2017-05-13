<?php
include 'InputField.php';
include 'Row.php';
include 'Content.php';
include 'PanelBody.php';
include 'PanelHeading.php';
include 'Col.php';
include 'PanelPrimary.php';
	
$inp = new InputField( "submit", false, "best_id" );
$inp->setStyle( 100 );
$inp->setValue( "I set the value for this input!" );

$con = new Content( "A simple text" );
$con->setStyle( 80 );

$pb = new PanelBody();
$pb->push( $inp->getHTMLCode() );
$pb->push( $con->getHTMLCode() );
	
$ph = new PanelHeading( "A best title!" );

$col2 = new Col( 5 );
$col = new Col( 5 );
$pp = new PanelPrimary();
$pp->setHead( $ph );
$pp->setBody( $pb );
$col->setPrimary( $pp );

$row = new Row();
$row->pushCol( $col2 );
$row->pushCol( $col );
echo $row->getHTMLCode();

?>	