<?php

class WebParser{
	
	private $config;
	private $classNames = array();
	private $classProperties = array();
	
	public function __construct()
	{
		$this->config = new ConfigObjects();
	}
	
	public function parseString( $string )
	{
		$classes = explode( "|", $string );
		
		$i = 0;
		foreach ( $classes as $exemplar ){
			$separate = explode( ":", $exemplar );
			$classNames[$i] 	= $separate[0];
			$classValues[$i] 	= $separate[1];
			$i++;
			
		}
		
		$this->config->objNames = $classNames;
		
		for( $i = 0; $i < count( $classValues ); $i++ ){
			$bufferArray = explode( "-", $classValues[$i] );
			for( $j = 0; $j < count( $bufferArray ); $j++ ){
				$this->config->objProperties[$i][$j] 
					= $bufferArray[$j];
			}
			
		}
		
	}
	
	public function getResult()
	{
		foreach( $this->config->objProperties as $name => $properties ){
			echo $name . "<br>";
			foreach( $properties as $value ){
				echo $value . " ";
			}
			echo "<br>";
		}
		
		foreach( $this->config->objNames as $name ){
			echo $name . " ";
		}
		
	}
	
}

?>