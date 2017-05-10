<?php

class Input {
	
	private $type; 			//string
	private $width;			//integer range from 1 to 12
	private $head;			//string
	private $extend; 		//bool
	private $required; 		//bool
	private $id;			//int or string value
	
	public function __construct( 
		$type, $width, $head, $extend, $required, $id )
	{
		
		$this->type 		= $type;
		$this->width	 	= $width;
		$this->head			= $head;
		$this->extend		= $extend;
		$this->required		= $required;
		$this->id 			= $id;
		
	}
	
	public function getWidth()
	{
		return $this->width;	
	}
	
	public function getHTMLCode()
	{
		$stringCode 	 = "<input type='";
		$stringCode		.= $this->type . "' ";
		
		if( $this->required == true ){
			$stringCode .= "required ";
		}
		
		$stringCode 	.= "id='";
		$stringCode 	.= $this->id . "' ";
		$stringCode 	.= ">";
		
		return $stringCode;
	}
	
	public function printMessage()
	{
	
		echo $this->head;
		
	}
	
}

?>