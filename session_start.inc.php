<?php
if (!defined('NOSESSION')) {
	session_name('VTCAL');
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
	if (BASEPATH != '' && BASEDOMAIN != '') { session_set_cookie_params(0, BASEPATH, BASEDOMAIN); }
	else { session_set_cookie_params(0); }
	session_start();
}
?>