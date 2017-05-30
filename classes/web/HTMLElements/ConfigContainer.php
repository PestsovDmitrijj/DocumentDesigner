<?php

class ConfigContainer extends ConfigObject {
	
	protected $defaultProperties = array(
		'config',
		'requiredFields',
		'additionalFields',
		'arrayNames'
	);
	
	public function pushVIP( $array )
	{
		foreach ( $array as $key => $value ){
			$this->$key->push( $value );
		}
	}
	
}

?>