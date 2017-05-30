<?php

class Row extends ConfigContainer {
	
	protected $name = 'Row';
	
	protected $requiredFields = array();
	protected $additionalFields = array(
		
	);
	protected $arrayNames = array(
		'content'
	);
	
	
	protected $FreeWidth;
	protected $content;
	
	
	public function __construct(){
		// default settings
		$this->seniorObj	= null;		// string with name senior object's or null value
		$this->down			= true;		// true if object has junior objects otherwise false
		// end default settings
		
		$this->FreeWidth = 12;
		$this->content = new Container();
		
	}
	
	public function getHTMLCode()
	{
		$stringCode =	"<div class='row'>" . "\n";
		
		for( $i = 0; $i < $this->content->size(); $i++ ) 
			$stringCode .= $this->content->pop($i) . "";		
		
		$stringCode .=	"</div>"  . "\n";
		
		return $stringCode;
	}
	
}

?>