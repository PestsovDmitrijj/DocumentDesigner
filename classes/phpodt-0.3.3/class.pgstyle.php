<?php

include_once 'phpodt.php';

class pgStyle extends ContentAutoStyle {
	
	private $pgProp;
	
	public function __construct($name) {
		parent::__construct($name);
		$this->styleElement->setAttribute('style:family', 'paragraph');
		$this->styleElement->setAttribute('style:master-page-name', $name);
		$this->pgProp = $this->contentDocument->createElement('style:paragraph-properties');
		$this->styleElement->appendChild($this->pgProp);
		//$this->cellProp->setAttribute('style:master-page-name', $vAlign);
	}
}