<?php

class Row {
	
	private $FreeWidth;
	private $content;
	private $input;
	
	public function getInput( $input ) 
	{
		
		array_push( this->input, $input );
		
	}
	
}

?>