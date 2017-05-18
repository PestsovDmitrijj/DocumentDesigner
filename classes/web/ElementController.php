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
	
	protected $storageExemplars = array();
	
	// get protected property
	public function getPP( $property )
	{
		return $this->$property;
	}
	
	public function createClass( $className ){
		
		$obj = new $className();
		return $obj;
	}
	
}

?>