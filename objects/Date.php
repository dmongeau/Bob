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
	
	
}