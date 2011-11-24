<?php



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
	
	public function format($format = "d MMMM YYYY", $lang = 'fr') {
		
		$time = $this->_timestamp;
		$day = (int)date('j',$time);
		if($lang == 'en') {
			if($day == 1) $daySuffix = 'st';
			else if($day == 2) $daySuffix = 'nd';
			else if($day == 3) $daySuffix = 'rd';
			else $daySuffix = 'th';
		} else {
			$daySuffix = ($day == 1) ? 'er':'';
		}
		
		if($time > 0 && $format == "d MMMM") {
			if($lang == 'en') return self::$months[((int)date('n',$time)-1)][$lang].' '.$day.$daySuffix;
			else return $day.$daySuffix.' '.self::$months[((int)date('n',$time)-1)][$lang];
		} elseif($time > 0 && $format == "d MMMM YYYY") {
			if($lang == 'en') return self::$months[((int)date('n',$time)-1)][$lang].' '.$day.$daySuffix.', '.date('Y',$time);
			else return $day.$daySuffix.' '.self::$months[((int)date('n',$time)-1)][$lang].' '.date('Y',$time);
		} elseif($time > 0 && $format == "d MMMM YYYY, HH:mm") {
			if($lang == 'en') return self::$months[((int)date('n',$time)-1)][$lang].' '.$day.$daySuffix.' '.date('Y',$time).', '.date('H:i',$time);
			else return $day.$daySuffix.' '.self::$months[((int)date('n',$time)-1)][$lang].' '.date('Y',$time).', '.date('H:i',$time);
		}
	
		
		//$key = $date.$format;
		$date = new Zend_Date($time, null, $lang.'_CA');
		return $date->toString($format,$lang.'_CA');
	}
	
	
}