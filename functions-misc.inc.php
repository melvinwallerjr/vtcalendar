<?php
function getNewEventId()
{ // Create an ID for an event that is as unique as possible.
	return sprintf('%010s%03s', time(), rand(0, 999));
}

function feedback($msg, $type)
{ // Used by the calendar admin scripts (e.g. update.php) to output small error messages.
	echo '<b' . (($type == 0)? ' class="txtInfo"' : (($type == 1)? ' class="txtWarn"' : '')) .
	 '>' .$msg . '</b><br />' . "\n";
}

function feedbackblock($msg, $type)
{ // Used by the calendar admin scripts (e.g. update.php) to output small error messages.
	echo '<p><b' . (($type == 0)? ' class="txtInfo"' : (($type == 1)? ' class="txtWarn"' : '')) .
	 '>' .$msg . '</b></p>' . "\n";
}

function verifyCancelURL($httpreferer)
{ // NOT USED
	if (empty($httpreferer)) { return 'update.php'; }
	return $httpreferer;
}

/**
 * Used by the calendar admin scripts (e.g. update.php)
 * to fully redirect a visitor from one page to another
 */
function redirect2URL($url)
{
	if (empty($url)) { $url = 'update.php'; }
	if (preg_match("/^[a-z]+:\/\//i", $url) == 0) { $url = SECUREBASEURL . $url; }
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $url);
	return true;
}

function getFullCalendarURL($calendarid)
{ // Get the complete URL that points to the current calendar.
	return BASEURL . 'main.php?calendarid=' . urlencode($calendarid);
}

function sendemail2sponsor($sponsorname, $sponsoremail, $subject, $body)
{ // Sends an email to a sponsor.
	$body.= "\n\n----------------------------------------\n";
	$body.= $_SESSION['CALENDAR_NAME'] . " \n";
	$body.= getFullCalendarURL($_SESSION['CALENDAR_ID']) . "\n";
	$body.= $_SESSION['CALENDAR_ADMINEMAIL'] . "\n";
	sendemail($sponsorname, $sponsoremail, lang('calendar_administration', false),
	 $_SESSION['CALENDAR_ADMINEMAIL'], $subject, $body);
}

function sendemail2user($useremail, $subject, $body)
{
	$body.= "\n\n----------------------------------------\n";
	$body.= $_SESSION['CALENDAR_NAME'] . "\n";
	$body.= getFullCalendarURL($_SESSION['CALENDAR_ID']) . "\n";
	$body.= $_SESSION['CALENDAR_ADMINEMAIL'] . "\n";
	sendemail($useremail, $useremail, lang('calendar_administration', false),
	 $_SESSION['CALENDAR_ADMINEMAIL'], $subject, $body);
}

function highlight_keyword($keyword, $text)
{ // highlights all occurrences of the keyword in the text, case-insensitive
	$keyword = preg_quote($keyword, '/');
	$newtext = preg_replace('/' . $keyword . '/Usi', '<span class="KeywordHighlight">\\0</span>', $text);
	return $newtext;
}

/**
 * Taken from phpBB 2.0.19 (from phpBB2/includes/bbcode.php)
 *
 * Rewritten by Nathan Codding - Feb 6, 2001.
 * - Goes through the given string, and replaces xxxx://yyyy with an HTML <a> tag linking
 *   to that URL
 * - Goes through the given string, and replaces www.xxxx.yyyy[zzzz] with an HTML <a> tag linking
 *   to http://www.xxxx.yyyy[/zzzz]
 * - Goes through the given string, and replaces xxxx@yyyy with an HTML mailto: tag linking
 *   to that email address
 * - Only matches these 2 patterns either after a space, or at the beginning of a line
 *
 * Notes: the email one might get annoying - it's easy to make it more restrictive, though.. maybe
 * have it require something like xxxx@yyyy.zzzz or such. We'll see.
 */
function make_clickable($text)
{
	$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);
	// pad it with a space so we can match things at the start of the 1st line.
	$ret = ' ' . $text;
	// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
	// xxxx can only be alpha characters.
	// yyyy is anything up to the first space, newline, comma, double quote or <
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",
	 "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
	// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
	// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
	// zzzz is optional.. will contain everything up to the first space, newline,
	// comma, double quote or <.
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",
	 "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
	// matches an email@domain type address at the start of a line, or after a space.
	// Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".
	$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i",
	 "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
	// Remove our padding..
	$ret = substr($ret, 1);
	return($ret);
}

function removeslashes(&$event)
{ // remove slashes from event fields
	if (get_magic_quotes_gpc()) {
		$event['title'] = textString(stripslashes($event['title']));
		if (isset($event['description'])) {
			$event['description'] = stripslashes($event['description']);
		}
		if (isset($event['location'])) {
			$event['location'] = textString(stripslashes($event['location']));
		}
		if (isset($event['webmap'])) {
			$event['webmap'] = textString(stripslashes($event['webmap']));
		}
		if (isset($event['price'])) {
			$event['price'] = textString(stripslashes($event['price']));
		}
		if (isset($event['contact_name'])) {
			$event['contact_name'] = textString(stripslashes($event['contact_name']));
		}
		if (isset($event['contact_phone'])) {
			$event['contact_phone'] = textString(stripslashes($event['contact_phone']));
		}
		if (isset($event['contact_email'])) {
			$event['contact_email'] = textString(stripslashes($event['contact_email']));
		}
		if (isset($event['displayedsponsor'])) {
			$event['displayedsponsor'] = textString(stripslashes($event['displayedsponsor']));
		}
		if (isset($event['displayedsponsorurl'])) {
			$event['displayedsponsorurl'] = textString(stripslashes($event['displayedsponsorurl']));
		}
	}
}

function textString($str)
{ // remove all multiple spaces, carriage returns, line feeds, tabs, and HTML; then trim the result
	return trim(strip_tags(preg_replace("/\s\s+/", ' ', $str)));
}

function checkURL($url)
{ // Make sure a URL starts with a protocol
	return (empty($url) || mb_strtolower(substr($url, 0, 7), 'UTF-8') == 'http://' ||
	  mb_strtolower(substr($url, 0, 8), 'UTF-8') == 'https://');
}

function checkemail($email)
{ // Check that a e-mail address is valid
	$validEmailRegex = '/^[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])*' .
	 '@[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])+$/';
	return (!empty($email) && (preg_match($validEmailRegex, $email) > 0 ||
	 (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,100}$/', $email) > 0 &&
	 strpos($email, '://') !== false)));
}

function xmlhtmlEntities($str)
{
	$badchars = array(
		chr(128), chr(130), chr(131), chr(132), chr(133), chr(134), chr(135), chr(136), chr(137),
		chr(138), chr(139), chr(140), chr(142), chr(145), chr(146), chr(147), chr(148), chr(149),
		chr(150), chr(151), chr(152), chr(153), chr(154), chr(155), chr(156), chr(158), chr(159),
		chr(161), chr(162), chr(163), chr(164), chr(165), chr(166), chr(167), chr(168), chr(169),
		chr(170), chr(171), chr(172), chr(174), chr(175), chr(176), chr(177), chr(178), chr(179),
		chr(180), chr(181), chr(182), chr(183), chr(184), chr(185), chr(186), chr(187), chr(188),
		chr(189), chr(190), chr(191), chr(192), chr(193), chr(194), chr(195), chr(196), chr(197),
		chr(198), chr(199), chr(200), chr(201), chr(202), chr(203), chr(204), chr(205), chr(206),
		chr(207), chr(208), chr(209), chr(210), chr(211), chr(212), chr(213), chr(214), chr(215),
		chr(216), chr(217), chr(218), chr(219), chr(220), chr(221), chr(222), chr(223), chr(224),
		chr(225), chr(226), chr(227), chr(228), chr(229), chr(230), chr(231), chr(232), chr(233),
		chr(234), chr(235), chr(236), chr(237), chr(238), chr(239), chr(240), chr(241), chr(242),
		chr(243), chr(244), chr(245), chr(246), chr(247), chr(248), chr(249), chr(250), chr(251),
		chr(252), chr(253), chr(254), chr(255)
	);
	$goodchar = array(
		'&euro;', '&bsquo;', '&fnof;', '&bdquo;', '&hellip;', '&dagger;', '&Dagger;', '&circ;', '&permil;',
		'&Scaron;', '&lsaquo;', '&OElig;', '&Zcaron;', '&lsquo;', '&rsquo;', '&ldquo;', '&rdquo;', '&bull;',
		'&ndash;', '&mdash;', '&tilde;', '&trade;', '&scaron;', '&rsaquo;', '&oelig;', '&zcaron;', '&Yuml;',
		'&iexcl;', '&cent;', '&pound;', '&curren;', '&yen;', '&brvbar;', '&sect;', '&uml;', '&copy;',
		'&ordf;', '&laquo;', '&not;', '&reg;', '&macr;', '&deg;', '&plusmn;', '&sup2;', '&sup3;',
		'&acute;', '&micro;', '&para;', '&middot;', '&cedil;', '&sup1;', '&ordm;', '&raquo;', '&frac14;',
		'&frac12;', '&frac34;', '&iquest;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;',
		'&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;',
		'&Iuml;', '&ETH;', '&Ntilde;', '&Ograve;', '&Oacute;', '&Ocirc;', '&Otilde;', '&Ouml;', '&times;',
		'&Oslash;', '&Ugrave;', '&Uacute;', '&Ucirc;', '&Uuml;', '&Yacute;', '&THORN;', '&szlig;', '&agrave;',
		'&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;',
		'&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&eth;', '&ntilde;', '&ograve;',
		'&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&divide;', '&oslash;', '&ugrave;', '&uacute;', '&ucirc;',
		'&uuml;', '&yacute;', '&thorn;', '&yuml;'
	);
	return str_replace($badchars, $goodchar, $str);
}

function setVar(&$var, $value, $type=NULL, $default=NULL)
{ // Run a sanity check on incoming request variables and set particular variables if checks are passed
	if (isset($value)) {
		// first, remove any escaping that may have happened if magic_quotes_gpc is set to ON in php.ini
		if (get_magic_quotes_gpc()) {
			if (is_array($value)) {
				foreach ($value as $key => $v) {
					$v = xmlhtmlEntities($v); // replace problem characters with XML/HTML equiv.
					$v = preg_replace("/[\x7F-\x9F]/", '', $v); // remove remaining characters from 127 to 159
					$value[$key] = stripslashes($v);
				}
			}
			else { $value = stripslashes($value); }
		}
		if ($type === NULL || isValidInput($value, $type)) {
			$value = xmlhtmlEntities($value); // replace problem characters with XML/HTML equiv.
			$value = preg_replace("/[\x7F-\x9F]/", '', $value); // remove all other characters from 127 to 159
			$var = $value;
			return true;
		}
	}
	// Set the var to the default if the value was invalid and a default was set.
	if ($default !== NULL) { $var = $default; }
	return false;
}

function lang($sTextKey, $htmlOk=true)
{ // returns a string in a particular language
	global $lang;
	if (!isset($lang[$sTextKey])) {
		trigger_error('Lang key \'' . $sTextKey . '\' not found.', E_USER_WARNING);
		if ($sTextKey != 'lang' && isset($_SESSION['DEBUG']) &&
		 $_SESSION['DEBUG'] == 'true') { // debug mode output, not lang option
			$text = '{X{' . $sTextKey . '}X}';
			if ($htmlOk) {
				$text = '<span title="Key: ' . $sTextKey .
				 '" style="color:#c00; background:#ff0 none; font-weight:bold;">' .
				 $text . '</span>'; // match not found, display bebug in red
			}
			return $text;
		}
		return '';
	}
	else {
		$text = $lang[$sTextKey];
		if (strpos($text, '@FILE:') === 0) { $text = file_get_contents(substr($text, 6)); }
		if ($sTextKey != 'lang' && isset($_SESSION['DEBUG']) &&
		 $_SESSION['DEBUG'] == 'true') { // bebug mode output, not lang option
			if (isset($_SESSION['DEFAULT_LANGUAGE'][$sTextKey]) &&
			 $lang[$sTextKey] == $_SESSION['DEFAULT_LANGUAGE'][$sTextKey]) { // compare to default
				$text = '{D{' . $text . '}D}';
				if ($htmlOk) {
					$text = '<span title="Key: ' . $sTextKey .
					 '" style="color:#fefefe; background:#99f none;">' .
					 $text . '</span>'; // match found, display debug in blue
				}
			}
			else { // current string does not match default language
				$text = '{S{' . $text . '}S}';
				if ($htmlOk) {
					$text = '<span title="Key: ' . $sTextKey .
					 '" style="color:#fefefe; background:#3c3 none;">' .
					 $text . '</span>'; // match found, display debug in green
				}
			}
		}
		return $text; // regular output, no bebug code
	}
}

function escapeJavaScriptString($string)
{ // Formats a string so that it can be placed inside of a JavaScript string (e.g. document.write('');)
	return str_replace(
		array('\\',   "\t", "\r", "\n", '"',  '</'),
		array('\\\\', '\t', '\r', '\n', '\"', '<\\/'),
		$string
	);
}

if (!function_exists('html_entity_decode')) {
	function html_entity_decode($string, $quote_style=NULL, $charset=NULL)
	{
		return str_replace(
			array('&amp;', '&lt;', '&gt;', '&quot;'),
			array('&',     '<',    '>',    '"'),
			$string
		);
	}
}

// PHP < 5 Compatibility Function
if (!function_exists('http_build_query')) {
	function http_build_query($data, $prefix=null, $sep='', $key='')
	{ // By mqchen at http://us3.php.net/manual/en/function.http-build-query.php#72911
		$ret = array();
		foreach ((array)$data as $k => $v) {
			$k = urlencode($k);
			if (is_int($k) && $prefix != null) { $k = $prefix . $k; }
			if (!empty($key)) { $k = $key . '[' . $k . ']'; }
			if (is_array($v) || is_object($v)) { array_push($ret, http_build_query($v, '', $sep, $k)); }
			else { array_push($ret, $k . '=' . urlencode($v)); };
		};
		if (empty($sep)) { $sep = ini_get('arg_separator.output'); }
		return implode($sep, $ret);
	}
};
?>