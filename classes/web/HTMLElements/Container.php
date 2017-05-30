<?php

class Container{
	
	protected $container = array();
	protected $counter;
	
	public function __construct()
	{
		$this->container = null;
		$this->counter = 0;
	}
	
	// get container
	public function getC()
	{
		return $this->container;
	}
	
	public function push( $value )
	{
		$this->container[ $this->counter ] = $value;
		$this->counter++;	
	}
	
	public function size()
	{
		return $this->counter;
	}
	
	public function pop( $pointer )
	{
		if ( $pointer >= 0 && $pointer <= $this->counter ){
			
			return $this->container[ $pointer ];
			
		} else
			echo '<br> wrong index! <br>';
	}
	
}

?>