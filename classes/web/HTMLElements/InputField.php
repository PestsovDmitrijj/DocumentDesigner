<?php

class InputField {
	
	private $type; 		//string
	private $required; 	//bool
	private $id;		//int or string value
	private $value;		//string
	private $style;		//range from 1 to 100 percents
	private $propertyNames = array(
	'type',
	'required',
	'id',
	'value',
	'style',
	);
	private $noDefaultMethods = array(
	'setStyle',
	'setValue',
	);
	
	public function __construct( $type, $required, $id )
	{
		
		$this->type 	= $type;
		$this->required	= $required;
		$this->id 		= $id;
		$this->style	= null;
		$this->value	= null;
		
	}
	
	public function getProperties()
	{
		return $this->propertyNames;
	}
	
	public function getNoDefaultMethods()
	{
		return $this->noDefaultMethods;
	}
	
	public function setStyle( $style )
	{
		$this->style = $style;
	}
	
	public function setValue( $value )
	{
		$this->value = $value;
	}
	
	public function getHTMLCode()
	{
		$stringCode 	 = "<input type='";
		$stringCode		.= $this->type . "' ";
		
		if( $this->required == true ){
			$stringCode .= "required ";
		}
		
		if( $this->style != null )
		{
			$stringCode .= "style='width:";
			$stringCode .= $this->style . "%' ";
		}
		
		if( $this->value != null )
		{
			$stringCode .= "value='";
			$stringCode .= $this->value . "' ";
		}
		
		$stringCode 	.= "id='";
		$stringCode 	.= $this->id . "' ";
		$stringCode 	.= ">\n";
		
		return $stringCode;
	}
	
}

?>