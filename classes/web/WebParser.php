<?php

class WebParser{
	
	private $obj;

	public function parseConfigString( $string )
	{
		// объявление структуры данных
		$this->obj = new ConfigObjects();
		
		$classes = explode( "|", $string );
		
		// формирование массивов с параметрами
		$i = 0;
		foreach ( $classes as $exemplar ){
			$separate = explode( ":", $exemplar );
			$classNames[$i] 	= $separate[0]; // массив имен объетов
			$classValues[$i] 	= $separate[1]; 
			$i++;
			
		}
		
		$this->obj->objNames = $classNames; // передача имен в структуру
		
		// формирование двумерного массива настроек объектов
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