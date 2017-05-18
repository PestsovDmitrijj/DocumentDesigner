<?php

$elController = new ElementController();

echo 'I am a tester of ElementController!';

echo '<hr>';
echo 'test method getPP( listSC )';
foreach ( $elController->getPP( 'listSC' ) as $value ){
	echo $value . ' ';
}

echo '<hr>';
echo 'test method createClass()';



?>