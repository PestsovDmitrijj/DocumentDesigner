<?php

class WebController {
	
	// список подчиненных классов
	private $sheetOfElements = array(
		'Col',
		'Content',
		'InputField',
		'PanelBody',
		'PanelHeading',
		'PanelPrimary',
		'Row',
	);
	
	protected $parser;
	
	public function __construct()
	{
		$this->parser = new WebParser();
	}

	public function createObjects( $arrayNames )
	{
		// поиск соответствий списка полученных из управляющей строки имен
		// в списке подчиненных классов
		$i = 0;
		foreach( $arrayNames as $value ){
			foreach( $this->sheetOfElements as $controledObj ){
			// создание массива объектов на основе списка соответствий	
				if ( $value == $controledObj ){
					$obj = new $controledObj();
					$arrayObjects[$i] = $obj;
					$i++;
					break;
				}
				
			}
		}
		
		return $arrayObjects;
	}

	// метод для создания веб-формы
	public function createForm( $commandSrting )
	{
		// передача управляющей строки в парсер
		$obj = $this->parser->parseConfigString( $commandSrting );
		$arrayObjects = $this->createObjects( $obj->objNames );
		// тестирование механизма
		// вызов метода созданных классов
		/*
		$array = array( 'one' => 'valOne', 'two' => 'valTwo' );
		foreach( $arrayObjects as $obj ){
			$obj->setVIP( $array );
			foreach( $array as $key => $value ){
				echo $obj->getProperty($key) . " ";
			}
			echo "<br>";
		}
		*/
	}
	
}

?>