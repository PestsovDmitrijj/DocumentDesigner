<?php

$elController = new ElementController();

echo '<center>';

echo 'I am a tester of ElementController!';

echo '<hr>';
echo 'test method getPP( listSC )' . '<br>';
foreach ( $elController->getPP( 'listSC' ) as $value ){
	echo $value . ' ';
}

echo '<hr>';
echo 'test method pushST( $exemplar )' . '<br>';
$obj 	= new Content();
$obj2 	= new InputField();
echo count( $elController->getPP( 'storageExemplars' ) );
$elController->pushST( $obj );
echo count( $elController->getPP( 'storageExemplars' ) );
$elController->pushST( $obj2 );
echo count( $elController->getPP( 'storageExemplars' ) );
$storage = $elController->getPP( 'storageExemplars' );
foreach( $storage as $value ){
	foreach( $value->connection() as $secondValue ){
		echo $secondValue . ' ';
	}
	echo '<br>';
}

echo '<hr>';
echo 'test method createClass()';

echo '</center>';

//echo '<plaintext>';

?>