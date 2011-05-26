<?php
/*
 *
 * Bob the builder
 *
 * Bob is a static class to organize libraries of functions and classes
 *
 * @author David Mongeau-Petitpas <dmp@commun.ca>
 * @version 0.1
 *
 */

define('PATH_BOB',dirname(__FILE__));
define('PATH_BOB_FUNCTIONS',dirname(__FILE__).'/functions');
define('PATH_BOB_OBJECTS',dirname(__FILE__).'/objects');


//require PATH_BOB.'/objects/Array.php';
//require PATH_BOB.'/objects/Date.php';
//require PATH_BOB.'/objects/String.php';
//require PATH_BOB.'/functions/functions.php';
//require PATH_BOB.'/functions/network.php';


class Bob {
	
	public static $config = array(
		'namespace' => 'Bob',
		'path' => array(
			'functions' => array(PATH_BOB_FUNCTIONS),
			'objects' => array(PATH_BOB_OBJECTS)
		)
	);
	
	public static $data = array();
	
	protected static $_loaded = array();
	
	/*
	 *
	 * Method to load files and classes that are needed
	 *
	 *
	 */
	public static function need($name) {
		
		if(in_array($name,self::$_loaded)) return;
		
		if(substr($name,0,4) == 'bob_' && !function_exists($name)) {
			
			$parts = explode('_',$name);
			
			if(sizeof($parts) == 2) $filename = 'functions.php';
			else if(sizeof($parts) > 2) $filename = $parts[1].'.php';
			
			foreach(self::$config['path']['functions'] as $path) {
				$path = rtrim($path,'/').'/'.$filename;
				if(file_exists($path)) {
					require $path;
					self::$_loaded[] = $name;
				}
			}
			
		} else if(substr($name,0,4) == 'Bob_' && !class_exists($name)) {
			
			$filename = str_replace('Bob_','',$name).'.php';
			
			foreach(self::$config['path']['objects'] as $path) {
				$path = rtrim($path,'/').'/'.$filename;
				if(file_exists($path)) {
					require $path;
					self::$_loaded[] = $name;
				}
			}
			
		}
		
	}
	
	/*
	 *
	 * Method to create instance of objects
	 *
	 *
	 */
	public static function create($name) {
		
		$className = self::_getObjectName($name);
		
		self::need($className);
		
		if(class_exists($className)) {
			
			$args = func_get_args();
			switch (sizeof($args)) {
				case 2:
					return new $className($args[1]);
				case 3:
					return new $className($args[1], $args[2]);
				case 4:
					return new $className($args[1], $args[2], $args[3]);
				case 5:
					return new $className($args[1], $args[2], $args[3], $args[4]);
				case 6:
					return new $className($args[1], $args[2], $args[3], $args[4], $args[5]);
				default:
					return new $className();
			}
			
		} else {
			throw new Exception('Object does not exist');	
		}
		
		
	}
	
	
	public static function run($name,$args = array()) {
		
		$functionName = self::_getFunctionName($name);
		
		self::need($functionName);
		
		if(function_exists($functionName)) {
			
			return call_user_func_array($functionName, $args);
			
		}
		
	}
	
	
	
	protected static function _getFunctionName($name, $withNamespace = true) {
		if($withNamespace && !empty(self::$config['namespace'])) {
			$name = self::$config['namespace'].'_'.str_replace('.','_',$name);
		}
		return strtolower($name);
	}
	
	
	
	protected static function _getObjectName($name, $withNamespace = true) {
		$name = str_replace(' ','_',ucwords(str_replace('_',' ',$name)));
		if($withNamespace && !empty(self::$config['namespace'])) {
			$name = self::$config['namespace'].'_'.$name;
		}
		return $name;
	}
	
	
	public static function x($name) {
		$functionName = self::_getFunctionName($name);
		
		self::need($functionName);
		
		if(function_exists($functionName))  {
			$args = func_get_args();
			$args = sizeof($args) > 1 ? array_slice($args,1):array();
			return call_user_func_array($functionName, $args);
		}
		
	}
	
	
}