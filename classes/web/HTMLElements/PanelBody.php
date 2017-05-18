<?php

class PanelBody extends ConfigObject {
	
	protected $requiredFields = null;
	protected $additionalFields = array(
		'counter'
	);

	
	protected $content = array();
	protected $counter;

	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'PanelPrimary';	// string with name senior object's or null value
		$this->down			= true;				// true if object has junior objects otherwise false
		// end default settings
		
		$this->counter = 0;
	}
	
	public function push( $content )
	{
		array_push( $this->content, $content );
		$this->counter++;
	}
	
	public function getHTMLCode()
	{
		$this->counter;
		$stringCode = "<div class='panel-body'>" . "\n";
		
		for( $i = 0; $i < $this->counter; $i++ )
			$stringCode .= $this->content[$i] . "\n";
			
		$stringCode .= "</div>" . "\n";
		
		return $stringCode;
	}
	
}

?>