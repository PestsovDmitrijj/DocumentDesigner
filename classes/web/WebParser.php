<?php

class WebParser{
	
	private $obj;

	public function parseConfigString( $string )
	{
		$this->obj = new ConfigObjects();
		
		$classes = explode( "|", $string );
		
		$i = 0;
		foreach ( $classes as $exemplar ){
			$separate = explode( ":", $exemplar );
			$classNames[$i] 	= $separate[0];
			$classValues[$i] 	= $separate[1];
			$i++;
			
		}
		
		$this->obj->objNames = $classNames;
		
		for( $i = 0; $i < count( $classValues ); $i++ ){
			$bufferArray = explode( "-", $classValues[$i] );
			for( $j = 0; $j < count( $bufferArray ); $j++ ){
				$this->obj->objProperties[$i][$j] 
					= $bufferArray[$j];
			}
			
		}
		
		return $this->obj;
	}
	
	
	
}

?>