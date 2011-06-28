<?php



class Bob_Array {
	
	protected $_array = array();
	
	public function __construct(array $array) {
		$this->_array = $array;	
	}
	
	public function getKey($key,$empty = null) {
		return isset($this->_array[$key]) && $this->_array[$key] != '' ? $this->_array[$key]:$empty;
	}
	
	public function getItems($namespace, $primaryKey) {
		
		$items = array();
		$inItems = $this->getByNamespace($namespace);
		if(isset($inItems[$primaryKey])) {
			for($i = 0; $i < sizeof($inItems[$primaryKey]); $i++) {
				if(!empty($inItems[$primaryKey][$i])) {
					$arr = new self($inItems);
					$items[] = $arr->getByIndex($i);
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
	
	public function toXML( $rootNodeName = 'data', &$xml=null ) {
		
		$data = $this->_array;
		
        // turn off compatibility mode as simple xml throws a wobbly if you don't.
        if ( ini_get('zend.ze1_compatibility_mode') == 1 ) ini_set ( 'zend.ze1_compatibility_mode', 0 );
        if ( is_null( $xml ) ) //$xml = simplexml_load_string( "" );
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />",'SimpleXMLElement',LIBXML_NOCDATA);

        // loop through the data passed in.
        foreach( $data as $key => $value ) {

            $numeric = false;
            
            // no numeric keys in our xml please!
            if ( is_numeric( $key ) ) {
                $numeric = 1;
                $key = $rootNodeName;
            }

            // delete any char not allowed in XML element names
            $key = preg_replace('/[^a-z0-9\-\_\.\:]/i', '', $key);

            // if there is another array found recrusively call this function
            if ( is_array( $value ) ) {
                $node = self::isAssociative( $value ) || $numeric ? $xml->addChild( $key ) : $xml;

                // recrusive call.
                if ( $numeric ) $key = 'anon';
                Bob::create('array',$value)->toXml( $key, $node );
            } else {

                // add single node.
                $value = $value;
                $xml->addChild( $key, !$value ? '0':$value);
            }
        }

        // pass back as XML
        return $xml->asXML();

    // if you want the XML to be formatted, use the below instead to return the XML
        //$doc = new DOMDocument('1.0');
        //$doc->preserveWhiteSpace = false;
        //$doc->loadXML( $xml->asXML() );
        //$doc->formatOutput = true;
        //return $doc->saveXML();
    }
	
	public static function isAssociative( $array ) {
        return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
    }
	
}