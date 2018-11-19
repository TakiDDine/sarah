
<!-- if you dont add utf-8 in your page this function wont work ! -->
<meta charset="utf-8" />

<?php 

	// Replace alts characters to nothing (null) .
	function cleanFromALTS($val) {
	    global $cleanFromALTS;
	    $string = str_replace($cleanFromALTS, null , $val);
	    return $string;
	}


	// the array of alts 
	$cleanFromALTS = array(
	chr(0xC2) . chr(0xA0), // c2a0; Alt+255; Alt+0160; Alt+511; Alt+99999999;
	chr(0xC2) . chr(0x90), // c290; Alt+0144
	chr(0xC2) . chr(0x9D), // cd9d; Alt+0157
	chr(0xC2) . chr(0x81), // c281; Alt+0129
	chr(0xC2) . chr(0x8D), // c28d; Alt+0141
	chr(0xC2) . chr(0x8F), // c28f; Alt+0143
	chr(0xC2) . chr(0xAD), // cdad; Alt+0173
	chr(0xAD)); // Soft-Hyphen; AD


	// how to use this function ! just add your text in $val and will clean your text from alts 
	cleanFromALTS($val)

?>

