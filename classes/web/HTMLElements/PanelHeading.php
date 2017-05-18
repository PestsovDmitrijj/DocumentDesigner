<?php

class PanelHeading extends ConfigObject {

	protected $requiredFields = array(
		'title'
	);
	protected $additionalFields = null;


	protected $title;


	public function __construct(){
		// default settings
		$this->seniorObj	= 'PanelPrimary';	// string with name senior object's or null value
		$this->down			= false;			// true if object has junior objects otherwise false
		// end default settings
	}
	
	public function getHTMLCode()
	{
		$stringCode = 	"<div class='panel-heading'>" . "\n";
		$stringCode .= 	"<h3 class='panel-title'>";
		$stringCode .=	$this->title . "</h3>" . "\n";
		$stringCode .= 	"</div>" . "\n";
		
		return $stringCode;
	}

}

?>