<?php

class WebController {
	
	private $sheetOfElements = array(
		'Col',
		'Content',
		'InputField',
		'PanelBody',
		'PanelHeading',
		'PanelPrimary',
		'Row',
	);
	
	private function parseString( $string )
	{
		$elements = explode( "|", $string );
		
		
		return $elements;
	}
	
	public function createForm( $commandSrting )
	{
		echo $this->parseString( $commandSrting );
		
	}
	
}

?>