<?php



class Bob_String {
	
	protected $_string = array();
	
	public function __construct($string) {
		$this->_string = $string;	
	}
	
	public function toASCII() {
		
		$str = $this->_string;
		
		$str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
		$str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		$str = preg_replace('#&[^;]+;#', '', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/\*\?\!\@\$\%_|+ -]/", ' ', $str);
		
		return $clean;
		
	}
	
	public function toPermalink($delimiter = '-', $keepSlash = false) {
		
		$str = strtolower($this->toASCII());
		if(!$keepSlash) $str = preg_replace("/[\/_|+ -]+/", $delimiter, $str);
		return $str;
	}
	
	
}