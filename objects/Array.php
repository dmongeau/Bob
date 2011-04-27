<?php



class Bob_Array {
	
	protected $_array = array();
	
	public function __construct(array $array) {
		$this->_array = $array;	
	}
	
	public function getItems($namespace, $primaryKey) {
		
		$items = array();
		$inItems = self::getItemsByNamespace($this->_array,$namespace);
		if(isset($inItems[$primaryKey])) {
			for($i = 0; $i < sizeof($inItems[$primaryKey]); $i++) {
				if(!empty($inItems[$primaryKey][$i])) {
					$items[] = self::getItemsByIndex($inItems,$i);
				}
			}
			unset($inItems);
		}
		
		return $items;
		
	}
	 
	 
	public function getByKey($key) {
		
		$items = array();
		foreach($this->_array as $v) {
			if(isset($v[$key])) $items[] = $v[$key];
		}
		return $items;
		
	}
	
	public function getByNamespace($key, $separator = '_') {
		
		$items = array();
		foreach($this->_array as $k => $v) {
			$namespace = $key.$separator;
			if($k == $key || substr($k,0,strlen($namespace)) == $namespace) {
				$newkey = substr($k,strlen($namespace));
				$items[$newkey] = $v;
			}
		}
		
		return $items;
		
	}
	
	public function getByIndex($index) {
		
		$items = array();
		foreach($this->_array as $k => $v) {
			if(is_array($v) && isset($v[$index])) {
				$items[$k] = $v[$index];
			}
		}
		
		return $items;
		
	}
	
}