<?php

class Input {
	
	private $type; //string
	private $width; //integer range from 1 to 12
	private $head; //string
	private $extend; //bool
	private $required; //bool
	
	public function __construct( $t, $w, $h, $e, $r )
	{
		
		$this->type 		= $t;
		$this->width	 	= $w;
		$this->head			= $h;
		$this->extend		= $e;
		$this->required		= $r;
		
	}
	
	public function getWidth()
	{
		
		return $this->width;
		
	}
	
	public function printMessage()
	{
		
		echo $this->head;
		
	}
	
}

?>