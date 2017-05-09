<?php

class Input {
	
	private $type; //string
	private $width; //integer range from 1 to 12
	private $head; //string
	private $extend; //bool
	private $required; //bool
	
	public function __construct( 
		$type, $width, $head, $extend, $required )
	{
		
		this->type 		= $type;
		this->width	 	= $width;
		this->head		= $head;
		this->extend	= $extend;
		this->required	= $required;
		
	}
	
	public function getWidth()
	{
		
		return this->width;
		
	}
	
}

?>