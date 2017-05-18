<?php

class Col extends ConfigObject {
	
	protected $requiredFields = array(
		'width'
	);
	protected $additionalFields = array(
		'primary'
	);


	protected $width;
	protected $primary;

	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'Row';	// string with name senior object's or null value
		$this->down			= true;		// true if object has junior objects otherwise false
		// end default settings
	}
	
	public function getHTMLCode()
	{
		$stringCode =	"<div class='col-md-";
		$stringCode .=	$this->width . "'>" . "\n";
		if ( $this->primary != null )
			$stringCode .= $this->primary->getHTMLCode();
		$stringCode .=	"</div>" . "\n";
		
		return $stringCode;
	}
	
}

?>