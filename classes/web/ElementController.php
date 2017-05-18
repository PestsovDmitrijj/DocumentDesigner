<?php

class ElementController {
	
	// List of subordinate classes
	protected $listSC = array(
		'Col',
		'Content',
		'InputField',
		'PanelBody',
		'PanelHeading',
		'PanelPrimary',
		'Row',
	);
	
	protected $storageExemplars = null;
	
	// get protected property
	public function getPP( $property )
	{
		return $this->$property;
	}
	
	public function connection()
	{
		
	}
	
	// push exemplar into $storageExemplars
	public function pushST( $exemplar )
	{
		echo $this->storageExemplars;
		$i = count( $this-storageExemplars );
		echo '<' . $i . '>';
		$this->storageExemplars[ $i ] = $exemplar;	
	}
	
	public function createClass( $className ){
		
		$obj = new $className();
		return $obj;
	}
	
}

?>