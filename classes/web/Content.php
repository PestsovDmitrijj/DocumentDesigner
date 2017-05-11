<?php

class Content {

	private $text;
	private $style;
	
	public function __construct( $text )
	{
		$this->text 	= $text;
		$this->style	= null;
	}
	
	public function setStyle( $style )
	{
		$this->style = $style;
	}
	
	public function getHTMLCode()
	{
		$stringCode =		"<p>";
		$stringCode .=		$this->text;
		$stringCode .= 		"</p>";
		
		return $stringCode;
	}
	
}

?>