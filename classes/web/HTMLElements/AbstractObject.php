<?php

abstract class AbstractObject {
	
	abstract public function __construct();
	
	// точка входа в класс, единая для всех классов-потомков
	public function connection()
	{
		return $this->defaultProperties;
	}
	
	// возвращает значение свойства класса по его названию
	public function getProperty( $property )
	{
		return $this->$property;
	}
	
	// Метод принимает ассоциативный массив вида: "имя_свойства" => "значение"
	// и заполняет поле свойств
	// set values into propersties
	public function setVIP( $array )
	{
		foreach ( $array as $key => $value ){
			$this->$key = $value;
		}
	}
	
	abstract public function getHTMLCode();
	
}

?> 