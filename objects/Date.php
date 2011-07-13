<?php

define('BOB_DATE_SECOND',1);
define('BOB_DATE_MINUTE',60);
define('BOB_DATE_HOUR',3600);
define('BOB_DATE_DAY',3600*24);
define('BOB_DATE_WEEK',3600*24*7);
define('BOB_DATE_MONTH',3600*24*30.5);


class Bob_Date {
	
	protected $_timestamp = null;
	
	public static $days = array(
		array('fr'=>'Dimanche','en'=>'Sunday'),
		array('fr'=>'Lundi','en'=>'Monday'),
		array('fr'=>'Mardi','en'=>'Tuesday'),
		array('fr'=>'Mercredi','en'=>'Wednesday'),
		array('fr'=>'Jeudi','en'=>'Thursday'),
		array('fr'=>'Vendredi','en'=>'Friday'),
		array('fr'=>'Samedi','en'=>'Saturday')
	);
	
	public static $months = array(
		array('fr'=>'Janvier','en'=>'January'),
		array('fr'=>'Février','en'=>'February'),
		array('fr'=>'Mars','en'=>'March'),
		array('fr'=>'Avril','en'=>'April'),
		array('fr'=>'Mai','en'=>'May'),
		array('fr'=>'Juin','en'=>'June'),
		array('fr'=>'Juillet','en'=>'July'),
		array('fr'=>'Août','en'=>'August'),
		array('fr'=>'Septembre','en'=>'September'),
		array('fr'=>'Octobre','en'=>'October'),
		array('fr'=>'Novembre','en'=>'November'),
		array('fr'=>'Décembre','en'=>'December')
	);
	
	public function __construct($date) {
		
		$this->_timestamp = is_numeric($date) ? (int)$date:strtotime($date);
			
	}
	
	public function format($format = "d MMMM YYYY") {
		
		$time = $this->_timestamp;
		$day = (int)date('j',$time);
		$daySuffix = ($day == 1) ? 'er':'';
		
		if($time > 0 && $format == "d MMMM") {
			return $day.$daySuffix.' '.self::$months[((int)date('n',$time)-1)]['fr'];
		} elseif($time > 0 && $format == "d MMMM YYYY") {
			return $day.$daySuffix.' '.self::$months[((int)date('n',$time)-1)]['fr'].' '.date('Y',$time);
		} elseif($time > 0 && $format == "d MMMM YYYY, HH:mm") {
			return $day.$daySuffix.' '.self::$months[((int)date('n',$time)-1)]['fr'].' '.date('Y',$time).', '.date('H:i',$time);
		}
	
		
		$key = $date.$format;
		$date = new Zend_Date($date, null, 'fr_CA');
		return $date->toString($format,'fr_CA');
	}
	
	public function enlapsed($opts = array()) {
		
		$time = $this->_timestamp;
		
		$opts = array_merge(array(
			"lang" => 'fr',
			"max" => null,
			"precision" => 1,
			"remaining" => true
		),$opts);
		
		$lang = $opts['lang'];
		
		$abbr = array(
			"since" => array("fr"=>"il y a","en"=>"ago"),
			"now" => array("fr"=>"à l'instant","en"=>"now"),
			"remaining" => array("fr"=>"dans","en"=>"in"),
			"days" => array("fr"=>" jour(s)","en"=>" day(s)"),
			"hours" => array("fr"=>" heure(s)","en"=>" hour(s)"),
			"minuts" => array("fr"=>"min","en"=>"min"),
			"seconds" => array("fr"=>"sec","en"=>"sec")
		);
		
		if(time() > $time) $diff = time() - $time;
		else $diff = $time - time();
		
		if(isset($opts["max"]) && $diff > $opts["max"]) return "le ".$this->format();
			
		$days = floor($diff/BOB_DATE_DAY);
		$hours = floor(( $diff-($days*BOB_DATE_DAY) )/BOB_DATE_HOUR);
		$minuts = floor(( $diff-(($days*BOB_DATE_DAY) + ($hours*BOB_DATE_HOUR)) )/BOB_DATE_MINUTE);
		$seconds = floor(( $diff-(($days*BOB_DATE_DAY) + ($hours*BOB_DATE_HOUR) + ($minuts*BOB_DATE_MINUTE)) ));
		
		$string = "";
		$string .= (($days > 0 && $opts["precision"] <= BOB_DATE_DAY)? $days.$abbr["days"][$lang]." ":"");
		$string .= ((($days > 0 || $hours > 0) && $opts["precision"] <= BOB_DATE_HOUR && $hours != 0)? $hours.$abbr["hours"][$lang]." ":"");
		$string .= ((($days > 0 || $hours > 0 || $minuts >= 0) && $opts["precision"] <= BOB_DATE_MINUTE && $minuts != 0)? $minuts.$abbr["minuts"][$lang]." ":"");
		$string .= ((($days > 0 || $hours > 0 || $minuts >= 0 || $seconds >= 0) && $opts["precision"] <= BOB_DATE_SECOND && $seconds != 0)? $seconds.$abbr["seconds"][$lang]." ":"");
		
		if(empty($string)) {
			if($diff < BOB_DATE_SECOND) $string = 'moins d\'une seconde';
			else if($diff < BOB_DATE_MINUTE) $string = 'moins d\'une minute';
			else if($diff < BOB_DATE_HOUR) $string = 'moins d\'une heure';
			else if($diff < BOB_DATE_DAY) $string = 'moins d\'une journée';
		}
		
		if(time() > $time || $opts["remaining"]) {
			if($opts["remaining"] && (time() < $time || $time == 0)) $string = $abbr["now"][$lang];
			else {
				if($lang == "en") $string = $string." ".$abbr["since"]["en"];
				else $string = $abbr["since"]["fr"]." ".$string;
			}
		} else {
			$string = $abbr["remaining"][$lang]." ".$string;
		}
		
		return $string;
		
	}
	
	
}