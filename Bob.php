<?php


define('PATH_BOB',dirname(__FILE__));


require PATH_BOB.'/objects/Array.php';
require PATH_BOB.'/functions/functions.php';


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
		
		
		
	}
	
	/*
	 *
	 * Method to create instance of objects
	 *
	 *
	 */
	public static function create($name) {
		
		$className = str_replace(' ','_',ucwords(str_replace('_',' ',$name)));
		if(!empty(self::$config['namespace'])) {
			$className = self::$config['namespace'].'_'.$className;
		}
		
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
	
	
	public static function run($name,$args) {
		
		
		
		
	}
	
	
}