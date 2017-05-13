<?php

class Row {
	
	private $FreeWidth;
	private $col = array();
	private $counter;
	
	public function __construct()
	{
		
		$this->FreeWidth = 12;
		$this->counter = 0;
		
	}
	
	public function pushCol( Col $col ) 
	{
		if( $col->getWidth() <= $this->FreeWidth )
		{
			
			array_push( $this->col, $col );
			$this->counter += 1;
			$this->FreeWidth -= $col->getWidth();
			
		} else {
			echo "В строке недостаточно места.";
		}
		 
	}
	
	public function getHTMLCode()
	{
		$stringCode =	"<div class='row'>\n";
		
		for( $i = 0; $i < $this->counter; $i++ ) 
			$stringCode .= $this->col[$i]->getHTMLCode() . "";		
		
		$stringCode .=	"</div>\n";
		
		return $stringCode;
	}
	
}

?>