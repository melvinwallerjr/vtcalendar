<?php

// Put $lang entries here

/* Escape a string to be outputted in an XML document */
function xmlEscape($string, $full = false) {
	$string = str_replace('>','&gt;',str_replace('<','&lt;',str_replace('&','&amp;',str_replace('\'', '\\\'', $string))));
	if ($full) {
		$string = str_replace("'",'&apos;',str_replace('"','&quot;', $string));
	}
	return $string;
}

$items = array_keys($lang);
for ($i = 0; $i < count($items); $i++) {
	echo '<Item Name="'.xmlEscape($items[$i]).'">\''.xmlEscape($lang[$items[$i]]).'\'</Item>'."\n";
}
?>