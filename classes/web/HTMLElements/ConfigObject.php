<?php

class ConfigObject extends AbstractObject {
	
	// config block
	
	protected $seniorObj; // object class name
	protected $down  = null;
	
	// end config block
	
	protected $config = array(
		'seniorObj',
		'down'
	);
	
	protected $defaultProperties = array(
		'config',
		'requiredFields',
		'additionalFields'
	);
	
	/*
	public function __construct(){
		// default settings
		$this->seniorObj	= <val>;	// string with name senior object's or null value
		$this->down			= <val>;	// true if object has junior objects otherwise false
		// end default settings
	}
	*/
	
	public function __construct(){}
	public function getHTMLCode(){}
	
}

?>