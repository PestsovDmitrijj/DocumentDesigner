<?php

class Row {
	
	private $FreeWidth;
	private $content;
	private $input = array();
	private $counter;
	
	public function __construct()
	{
		
		$this->FreeWidth = 12;
		$this->counter = 0;
		
	}
	
	public function pushInput( Input $input ) 
	{
		if( $input->getWidth() <= $this->FreeWidth )
		{
			
			array_push( $this->input, $input );
			$this->counter += 1;
			$this->FreeWidth -= $input->getWidth();
			
		} else {
			echo "В строке недостаточно места.";
		}
		 
	}
	
	public function printInputs()
	{
		for( $i = 0; $i < $this->counter; $i++ ) 
			echo $this->input[$i]->getHTMLCode();		
	}
	
}

?>