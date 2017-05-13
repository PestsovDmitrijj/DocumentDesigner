<?php

class PanelHeading {

	private $title;
	
	public function __construct( $title )
	{
		$this->title = $title;
	}
	
	public function getHTMLCode()
	{
		$stringCode = 	"<div class='panel-heading'>\n";
		$stringCode .= 	"<h3 class='panel-title'>";
		$stringCode .=	$this->title . "</h3>\n</div>\n";
		
		return $stringCode;
	}

}

?>