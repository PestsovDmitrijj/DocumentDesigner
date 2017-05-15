<?php

class PanelPrimary {
	
	private $head;
	private $body;

	public function setHead( PanelHeading $head )
	{
		$this->head = $head;
	}
	
	public function setBody( PanelBody $body )
	{
		$this->body = $body;
	}
	
	public function getHTMLCode()
	{
		$stringCode .=	"<div class='panel panel-primary'>\n";
		
		if ( $this->head != null ){
			$stringCode .= $this->head->getHTMLCode();
		}
		
		if ( $this->body != null ){
			$stringCode .= $this->body->getHTMLCode();
		}
		
		$stringCode .=	"</div>\n";
		
		return $stringCode;
	}
	
}

?>