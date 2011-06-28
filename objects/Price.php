<?php



class Bob_Price {
	
	protected $_price = array();
	
	public function __construct($price) {
		$this->_price = (float)$price;	
	}
	
	public function toString($end = ' $') {
		
		return number_format($this->_price,2,'.',' ').$end;	
		
	}
	
	
}