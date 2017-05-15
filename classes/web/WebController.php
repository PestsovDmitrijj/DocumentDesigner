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
		foreach( $classNames as $values )
			echo $values . "<br>";
		foreach( $classValues as $values )
			echo $values . "<br>";

		for( $i = 0; $i < array_count_values($classNames); $i++ ){
			
			$config[$i]['class_name'] = $classNames[$i];
			$config[$i]['class_properties'] = explode( "-", $classValues[$i] );
			
		}
		
		return $config;
	}
	
	public function createForm( $commandSrting )
	{
		$config =  $this->parseString( $commandSrting );
		for( $i = 0; $i < array_count_values( $config ); $i++ ){
			echo $config[$i]['class_name'] . "<br>";
			for( $j = 0;
				$j < array_count_values( $config[$i]['class_properties'] );
				$j++ )
			{
				
				echo $config[$i]['class_properties'][$j] . " ";
				
			}
		}
		
	}
	
}

?>