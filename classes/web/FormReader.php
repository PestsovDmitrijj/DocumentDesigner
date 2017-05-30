<?php

class FormReader {
	
	private $listID = array();
	private $values = array();

	public function read(  $string  )
	{
		$ids = $this->parse( $string );
		for( $i = 0; $i < count( $ids ); $i++ ){
			$this->listID[$i] = $ids[$i];
		}
		
		for( $i = 0; $i < count( $this->listID ); $i++ ){
			$this->values[$i] = $_POST[ $this->listID[$i] ];
			$result[ $this->listID[$i] ] = $this->values[$i];
		}
		
		return $result;
	}
	
	public function parse( $string )
	{
		$arr = explode( ',', $string );
		return $arr;
	}
	
}

?>