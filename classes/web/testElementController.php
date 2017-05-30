<?php

$elController = new ElementController();

echo '<center>';

echo 'Testing ElementController!';

echo '<hr>';
echo 'test method getProperty( listSC )' . '<br>';
foreach ( $elController->getProperty( 'listSC' ) as $value ){
	echo $value . ' ';
}

echo '<hr>';
echo 'test class Container()' . '<br>';

$container = new Container();
echo 'size = ' . $container->size() . '<br>';
$container->push( $elController );
echo 'size = ' . $container->size() . '<br>';

echo '<hr>';
echo 'test method run( $arrayNames )';
$elController->processing( $elController->getProperty( 'listSC' ) );

echo '</center>';

//echo '<plaintext>';

?>