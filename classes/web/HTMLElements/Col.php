<?php

class Col extends ConfigContainer {

	protected $name = 'Col';
	
	protected $requiredFields = array(
		'width'
	);
	protected $additionalFields = array(
		'content'
	);


	protected $width;
	protected $content;

	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'Row';	// string with name senior object's or null value
		$this->down			= true;		// true if object has junior objects otherwise false
		// end default settings
		$this->content = new Container();
	}
	
	public function getHTMLCode()
	{
		$stringCode =	"<div class='col-md-";
		$stringCode .=	$this->width . "'>" . "\n";
		for( $i = 0; $i < $this->content->size(); $i++ ) 
			$stringCode .= $this->content->pop($i) . "";		
		$stringCode .=	"</div>" . "\n";
		
		return $stringCode;
	}
	
}

?>