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
	
	public function createForm( $commandSrting )
	{
		$this->parser->parseString( $commandSrting );
		$this->parser->getResult();
		
	}
	
	public function create()
	{
		$obj = new $this->sheetOfElements[2]("text", false, "id");
		$properties = $obj->getProperties();
		foreach( $properties as $value ){
			echo $value . "<br>";
		}
	}
	
}

?>