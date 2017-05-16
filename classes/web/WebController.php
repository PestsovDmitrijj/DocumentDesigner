<?php

class WebController {
	
	private $sheetOfElements = array(
		'Col',
		'Content',
		'InputField',
		'PanelBody',
		'PanelHeading',
		'PanelPrimary',
		'Row',
	);
	private $classNames = array();
	private $classProperties = array();
	
	private function parseString( $string )
	{
		$classes = explode( "|", $string );
		
		$i = 0;
		foreach ( $classes as $exemplar ){
			$separate = explode( ":", $exemplar );
			$classNames[$i] 	= $separate[0];
			$classValues[$i] 	= $separate[1];
			$i++;
			
		}
		
		$this->classNames = $classNames;
		
		for( $i = 0; $i < count( $classValues ); $i++ ){
			$bufferArray = explode( "-", $classValues[$i] );
			for( $j = 0; $j < count( $bufferArray ); $j++ ){
				$this->classProperties[$i][$j] 
					= $bufferArray[$j];
			}
			
		}
		
	}
	
	public function createForm( $commandSrting )
	{
		$this->parseString( $commandSrting );
		
		foreach( $this->classProperties as $name => $properties ){
			echo $name . "<br>";
			foreach( $properties as $value ){
				echo $value . " ";
			}
			echo "<br>";
		}
		
	}
	
}

?>