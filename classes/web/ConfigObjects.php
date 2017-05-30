<?php

class ConfigObjects{
	
	public $objNames = array();
	public $objProperties = array();
	
	public function pop( $i )
	{
		return $arr = array( "$objNames[$i]"=>"$objProperties[$i]" );
	}

}

?>