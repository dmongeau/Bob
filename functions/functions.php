<?php



function bob_uuid() {
	
	$md5 = md5(uniqid('', true));
	return substr($md5, 0, 8 ) . '-' .
			substr($md5, 8, 4) . '-' .
			substr($md5, 12, 4) . '-' .
			substr($md5, 16, 4) . '-' .
			substr($md5, 20, 12);
	
}