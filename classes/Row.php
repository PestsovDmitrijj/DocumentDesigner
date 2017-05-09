<?php

class Row {
	
	static private $FreeWidth = 12;
	private $content;
	private $input = array(null);
	
	public function pushInput( $input ) 
	{
		
		array_push( $this->input, $input );
		echo $this->input;
		
	}
	
	public function printInputs()
	{
		
		foreach( $this->input as $value )
		{
			
			
		
		}
		
	}
	
}

?>