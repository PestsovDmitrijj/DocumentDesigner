<?php

class PanelPrimary extends ConfigObject {

	protected $requiredFields = null;
	protected $additionalFields = array(
		
	);

	
	protected $head;
	protected $body;

	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'Col';	// string with name senior object's or null value
		$this->down			= true;		// true if object has junior objects otherwise false
		// end default settings
	}
	
	public function getHTMLCode()
	{
		$stringCode .=	"<div class='panel panel-primary'>" . "\n";
		
		if ( $this->head != null ){
			$stringCode .= $this->head;
		}
		
		if ( $this->body != null ){
			$stringCode .= $this->body;
		}
		
		$stringCode .=	"</div>" . "\n";
		
		return $stringCode;
	}
	
}

?>