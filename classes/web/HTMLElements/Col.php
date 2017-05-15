<?php

class Col {

	private $width;
	private $primary;
	
	public function __construct( $width )
	{
		$this->width = $width;
	}
	
	public function getWidth()
	{
		return $this->width;
	}
	
	public function setPrimary( PanelPrimary $obj )
	{
		$this->primary = $obj;
	}
	
	public function getHTMLCode()
	{
		$stringCode =	"<div class='col-md-";
		$stringCode .=	$this->width . "'>\n";
		if ( $this->primary != null )
			$stringCode .= $this->primary->getHTMLCode();
		$stringCode .=	"</div>\n";
		
		return $stringCode;
	}
	
}

?>