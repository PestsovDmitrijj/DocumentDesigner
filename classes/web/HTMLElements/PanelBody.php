<?php

class PanelBody extends ConfigContainer {

	protected $name = 'PanelBody';
	
	protected $requiredFields = null;
	protected $additionalFields = null;
	protected $arrayNames = array(
		'content'
	);
	
	protected $content;
	
	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'PanelPrimary';	// string with name senior object's or null value
		$this->down			= true;				// true if object has junior objects otherwise false
		// end default settings
		
		$this->content = new Container();
	}

	public function getHTMLCode()
	{
		$stringCode = "<div class='panel-body'>" . "\n";
		
		for( $i = 0; $i < $this->content->size(); $i++ )
			$stringCode .= $this->content->pop($i) . "\n";
			
		$stringCode .= "</div>" . "\n";
		
		return $stringCode;
	}
	
}

?>