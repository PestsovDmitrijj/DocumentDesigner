<?php

class PanelPrimary extends ConfigContainer {

	protected $name = 'PanelPrimary';

	protected $requiredFields = null;
	protected $additionalFields = array(
		
	);
	protected $arrayNames = array(
		'content'
	);
	
//	protected $head;
//	protected $body;

	protected $content;

	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'Col';	// string with name senior object's or null value
		$this->down			= true;		// true if object has junior objects otherwise false
		// end default settings
		$this->content = new Container();
	}
	
	public function getHTMLCode()
	{
		$stringCode .=	"<div class='panel panel-primary'>" . "\n";
		for( $i = 0; $i < $this->content->size(); $i++ ) 
			$stringCode .= $this->content->pop($i) . "";		
		
		$stringCode .=	"</div>" . "\n";
		
		return $stringCode;
	}
	
}

?>