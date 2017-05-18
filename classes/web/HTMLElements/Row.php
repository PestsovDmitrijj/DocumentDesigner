<?php

class Row extends ConfigObject {
	
	protected $requiredFields = array();
	protected $additionalFields = array(
		
	);

	
	
	protected $FreeWidth;
	protected $col = array();
	protected $counter;
	
	public function __construct(){
		// default settings
		$this->seniorObj	= null;		// string with name senior object's or null value
		$this->down			= true;		// true if object has junior objects otherwise false
		// end default settings
		
		$this->FreeWidth = 12;
		$this->counter = 0;
		
	}
	
	public function pushCol( Col $col ) 
	{
		if( $col->getProperty( 'width' ) <= $this->FreeWidth )
		{
			
			array_push( $this->col, $col );
			$this->counter += 1;
			$this->FreeWidth -= $col->getProperty( 'width' );
			
		} else {
			echo "В строке недостаточно места.";
		}
		 
	}

	public function getHTMLCode()
	{
		$stringCode =	"<div class='row'>" . "\n";
		
		for( $i = 0; $i < $this->counter; $i++ ) 
			$stringCode .= $this->col[$i]->getHTMLCode() . "";		
		
		$stringCode .=	"</div>"  . "\n";
		
		return $stringCode;
	}
	
}

?>