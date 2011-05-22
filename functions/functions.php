<?php



function bob_uuid() {
	
	$md5 = md5(uniqid('', true));
	return substr($md5, 0, 8 ) . '-' .
			substr($md5, 8, 4) . '-' .
			substr($md5, 12, 4) . '-' .
			substr($md5, 16, 4) . '-' .
			substr($md5, 20, 12);
	
}

function bob_quo($str,$encoding = "utf-8") {
	return htmlspecialchars($str,ENT_QUOTES,$encoding);
}

function bob_unquo($str) {
	return htmlspecialchars_decode($str);
}

function bob_ne($array,$key,$empty = "") {
	return bob_quo(Bob::create('array',$array)->getKey($key,$empty));
}

function bob_nec($array,$key,$empty = "") {
	return Bob::create('array',$array)->getKey($key,$empty);
}

function bob_sel($input,$value,$type = "integer") {
	if($type == "integer") return ((int)$input == (int)$value) ? " selected='selected'":"";
	elseif($type == "string") return ((string)$input == (string)$value) ? " selected='selected'":"";
	else return ($input == $value) ? " selected='selected'":"";
}

function bob_cla($input,$value,$class = "selected",$type = "string") {
	if($type == "integer") return ((int)$input == (int)$value) ? " ".$class:"";
	elseif($type == "string") return ((string)$input == (string)$value) ? " ".$class:"";
	else return ($input == $value) ? " ".$class:"";
}
