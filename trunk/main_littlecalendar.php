<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
	require_once('globalsettings.inc.php');
	require_once('main_globalsettings.inc.php');
	
	displayMonthSelector();
	displayLittleCalendar($month, $view, $showdate, $queryStringExtension);
?>