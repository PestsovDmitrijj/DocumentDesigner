<?php

class WebController {
	
	protected $parser;
	protected $elController;
	
	public function __construct()
	{
		$this->parser = new WebParser();
		$this->elController = new ElementController();
	}

	public function createForm( $commandSrting )
	{
		// passing a command string to the parser
		$obj = $this->parser->parseConfigString( $commandSrting );
		$this->elController->processing( $obj );
	}
	
}

?>