<?php

class Row {
	
	static private $FreeWidth = 12;
	private $content;
	private $input;
	
	public function pushInput( Input $input ) 
	{
		
		$this->input = $input;
		
	}
	
	public function printInputs()
	{
		
		$this->input->printMessage();
		$widnt = $this->input->getWidth();
		echo "<br>" . $widnt;
		
	}
	
}

?>