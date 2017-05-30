<?php

class InputField extends ConfigObject {

	protected $name = 'InputField';

	protected $requiredFields = array(
		'type',
		'id'
	);
	protected $additionalFields = array(
		'value',
		'style'
	);

	
	protected $type; 		//string
//	protected $required; 	//bool
	protected $id;			//int or string value
	protected $value;		//string
	protected $style;		//range from 1 to 100 percents

	
	public function __construct(){
		// default settings
		$this->seniorObj	= 'PanelBody';	// string with name senior object's or null value
		$this->down			= false;		// true if object has junior objects otherwise false
		// end default settings
	}
	
	public function getHTMLCode()
	{
		$stringCode 	 = "<input type='";
		$stringCode		.= $this->type . "' ";
		if( $this->type == 'submit' ){
			$stringCode	.= ' class="btn btn-large btn-primary" ';
		}
/*		
		if( $this->required == true ){
			$stringCode .= "required ";
		}
*/		
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
		$stringCode 	.= ">" . "\n";
		
		return $stringCode;
	}
	
}

?>