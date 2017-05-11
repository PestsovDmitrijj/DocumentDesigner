<?php

class PanelHeading {

	private $title;
	
	public function __construct( $title )
	{
		$this->title = $title;
	}
	
	public function getHTMLCode()
	{
		$stringCode = 	"<div class='panel-heading'>";
		$stringCode .= 	"<h3 class='panel-title'>";
		$stringCode .=	$this->title . "</h3></div>";
		
		return $stringCode;
	}

}

?>