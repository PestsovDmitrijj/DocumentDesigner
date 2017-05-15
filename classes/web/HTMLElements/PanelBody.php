<?php

class PanelBody {
	
	private $content = array();
	private $counter;
	
	public function __construct()
	{
		$this->counter = 0;
	}
	
	public function push( $content )
	{
		array_push( $this->content, $content );
		$this->counter++;
	}
	
	public function getHTMLCode()
	{
		$this->counter;
		$stringCode = "<div class='panel-body'>\n";
		
		for( $i = 0; $i < $this->counter; $i++ )
			$stringCode .= $this->content[$i] . "\n";
			
		$stringCode .= "</div>\n";
		
		return $stringCode;
	}
	
}

?>