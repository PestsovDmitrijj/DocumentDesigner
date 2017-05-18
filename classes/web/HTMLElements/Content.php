<?php

class Content extends ConfigObject {

	protected $requiredFields = array(
		'text'
	);
	protected $additionalFields = array(
		'style'
	);

	
	protected $text;
	protected $style;


	public function __construct(){
		// default settings
		$this->seniorObj	= 'PanelBody';	// string with name senior object's or null value
		$this->down			= false;		// true if object has junior objects otherwise false
		// end default settings
	}
	
	public function getHTMLCode()
	{
		$stringCode =		"<p>";
		$stringCode .=		$this->text;
		$stringCode .= 		"</p>" . "\n";
		
		return $stringCode;
	}
	
}

?>