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


require PATH_BOB.'/objects/Array.php';
require PATH_BOB.'/objects/Date.php';
require PATH_BOB.'/objects/String.php';
require PATH_BOB.'/functions/functions.php';
require PATH_BOB.'/functions/network.php';


class Bob {
	
	public static $config = array(
		'namespace' => 'Bob'
	);
	
	/*
	 *
	 * Method to load files and classes that are needed
	 *
	 *
	 */
	public static function need($name) {
		
		$className = self::_getObjectName($name);
		
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