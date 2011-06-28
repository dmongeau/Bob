<?php



class Bob_Url {
	
	protected $_url = array();
	
	protected static $_types = array(
		
		'url' => '^((https?|ftp|gopher|telnet|file|notes|ms-help):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)',
		'youtube' => '^https?\:\/\/(www\.)?youtube\.com\/',
		'vimeo' => '^https?\:\/\/(www\.)?vimeo\.com\/([0-9]+)',
		'facebook' => '^https?\:\/\/(www\.)?facebook\.com\/',
	
	);
	
	public function __construct($url) {
		$this->_url = $url;	
	}
	
	
	public function is($type = 'url') {
		
		$type = strtolower($type);
		
		if(!isset(self::$_types[$type])) return false;
		
		if(!preg_match('/'.self::$_types[$type].'/',$this->_url)) return false;
		
		return true;
		
	}
	
	
	public function getParam($name) {
		
		$pos = strpos($this->_url,'?');
		if($pos === false) return;
		
		$queryString = substr($this->_url,$pos+1);
		$hashPos = strpos($queryString,'#');
		if($hashPos !== false) $queryString = substr($queryString,0,$hashPos);
		
		$queryString = trim(html_entity_decode($queryString),'&');
		$params = explode('&',$queryString);
		
		foreach($params as $param) {
			
			$param = explode('=',$param);
			if(strtolower($name) == strtolower($param[0])) return rawurldecode($param[1]);
			
		}
		
		return;
		
	}
	
	
}