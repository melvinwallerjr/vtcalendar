<?php
// Allow any script that includes this file to include php files that restrict their access.
define('ALLOWINCLUDES', true);

// Include Pear::DB or output an error message if it does not exist.
@(include_once('DB.php')) or
die ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Pear::DB Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>Pear::DB does not seem to be installed. See: <a href="http://pear.php.net/package/DB">http://pear.php.net/package/DB</a></p>
</body></html>');

// Include the necessary VTCalendar files.
@(include_once('version.inc.php')); // TODO: Should this fail if the file cannot be loaded?
@(include_once('config.inc.php')) or
die ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Config Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>config.inc.php was not found. See: <a href="install/">VTCalendar Installation</a></p>
</body></html>');

require_once('config-defaults.inc.php');
require_once('config-colordefaults.inc.php');
require_once('config-validation.inc.php');
require_once('session_start.inc.php');
require_once('functions.inc.php');
require_once('constants.inc.php');
require_once('languages/en.inc.php');

/* ======= Load the calendar preferences and logout ======== */
// Get the specified calendar ID from the query string, either as 'calendarid' or 'calendar'.
if (isset($_GET['calendarid'])) {
	if (!setVar($calendarid, $_GET['calendarid'], 'calendarid')) { unset($calendarid); }
}
elseif (isset($_GET['calendar'])) {
	if (!setVar($calendarid, $_GET['calendar'], 'calendarid')) { unset($calendarid); }
}

// Unset the calendar ID if it is already set in the session.
if (isset($_SESSION['CALENDAR_ID']) && isset($calendarid) && $_SESSION['CALENDAR_ID'] == $calendarid) {
	unset($calendarid);
}

// Set a default calendar if one was not specified in the query string or session.
if (!isset($_SESSION['CALENDAR_ID']) && !isset($calendarid)) {
	$calendarid = 'default';
}

// If the calendar ID was specified then load that calendar
if (isset($calendarid) && !defined('NOLOADDB')) {
	if (calendar_exists($calendarid)) {
		$_SESSION['CALENDAR_ID'] = $calendarid;
		setCalendarPreferences();
		calendarlogout();
	}
}

$language = isset($_SESSION['CALENDAR_LANGUAGE'])? $_SESSION['CALENDAR_LANGUAGE'] :
 (defined(LANGUAGE)? LANGUAGE : 'en');
if ($language != 'en') {
	$tmp_array = $lang; // store base language array
	require_once('languages/' . $language . '.inc.php'); // load selected language array
	foreach ($lang as $key => $val) if ($val != '') { $tmp_array[$key] = $val; } // replace non empty fields
	// Replacing non-empty fields is not as efficient as joining, but it prevents missing text in the calendar.
	$lang = $tmp_array; // restore updated language array
}

if (AUTH_LDAP && !function_exists('ldap_connect')) {
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>PHP LDAP Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>PHP LDAP does not seem to be installed or configured. Make sure the extension is included in your php.ini file.</p>
</body></html>';
	exit;
}

// Include Pear::Mail or output an error message if it does not exist.
if (EMAIL_USEPEAR) {
	@(include_once('Mail.php')) or
	die ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>PHP Mail Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>Pear::Mail is required when EMAIL_USERPEAR is set to true. See: <a href="http://pear.php.net/package/Mail">http://pear.php.net/package/Mail</a></p>
</body></html>');
}

// Include Pear::HTTP_Request if AUTH_HTTP is true, or output an error message if it does not exist.
if (AUTH_HTTP) {
	@(include_once('HTTP/Request.php')) or
	die ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>PHP HTTP_Request Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>Pear::HTTP_Request is required when using HTTP authentication. See: <a href="http://pear.php.net/package/HTTP_Request">http://pear.php.net/package/HTTP_Request</a></p>
</body></html>');
}

/* ============ Open the database connection =============== */
if (!defined('NOLOADDB')) {
	$DBCONNECTION =& DBOpen();
	if (is_string($DBCONNECTION)) {
		include('dberror.php');
		exit;
	}
}

/* ============== Fixes for slow browsers ================== */
if (isset($_SERVER['HTTP_USER_AGENT']) &&
 $_SERVER['HTTP_USER_AGENT'] == 'Mozilla/4.0 (compatible; MSIE 5.22; Mac_PowerPC)') {
	$enableViewMonth = false;
}
else {
	$enableViewMonth = true;
}
?>