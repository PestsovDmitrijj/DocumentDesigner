<?php
include 'WebParser.php';
include 'ConfigObjects.php';

class WebController {
	
	//список подчиненных классов
	private $sheetOfElements = array(
		'Col',
		'Content',
		'InputField',
		'PanelBody',
		'PanelHeading',
		'PanelPrimary',
		'Row',
	);
	
	private $parser;
	
	public function __construct()
	{
		$this->parser = new WebParser();
	}
	
	public function createObjects( $arrayNames )
	{
		$i = 0;
		foreach( $arrayNames as $value ){
			foreach( $this->sheetOfElements as $controledObj ){
				
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
	
	public function createForm( $commandSrting )
	{
		$obj = $this->parser->parseConfigString( $commandSrting );
		$arrayObjects = $this->createObjects( $obj->objNames );
		foreach( $arrayObjects as $obj ){
			echo $obj->getHTMLCode();
		}
	}
	
}

?>