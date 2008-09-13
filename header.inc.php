<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

// Defines a single function that outputs the page header:
function pageheader($title, $navbaractive) {
	global $enableViewMonth, $lang, $timebegin, $queryStringExtension, $view;
	
	?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
		<head>
		<title><?php echo TITLEPREFIX; ?><?php echo $title; ?><?php echo TITLESUFFIX; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo lang('encoding'); ?>">
		<meta content="en-us" http-equiv=language>
		<?php if ($view == "event") { ?>
			<meta name="robots" content="index,follow">
		<?php } else { ?>
			<meta name="robots" content="noindex,follow">
		<?php } ?>
		<script type="text/javascript" src="scripts/browsersniffer.js"></script>
		<script type="text/javascript" src="scripts/general.js"></script>
		<script type="text/javascript" src="scripts/update.js"></script>
		<script type="text/javascript"><!--
		// If the browser does not support try/catch, then do not let it run the ChangeCalendar() scripts.
		if (is_ie3 || is_ie4 || is_js < 1.3) {
			document.write("<s"+"cript type=\"text/javascript\">function ChangeCalendar() { return true; }</s"+"cript>");
		}
		else {
			document.write("<s"+"cript type=\"text/javascript\" src=\"scripts/http.js\"></s"+"cript>");
			document.write("<s"+"cript type=\"text/javascript\" src=\"scripts/main.js\"></s"+"cript>");
		}
		//--></script>
		<!--[if gte IE 5.5000]>
		<script src="scripts/fix-ie6.js" type="text/javascript"></script>
		<![endif]-->
		<link href="stylesheet.php" rel="stylesheet" type="text/css">
		<link href="calendar.css.php" rel="stylesheet" type="text/css" media="screen">
		<link href="print.css" rel="stylesheet" type="text/css" media="print">
		<link href="navi-top-gold.css" rel="stylesheet" type="text/css">
		<!--[if lte IE 6]><style>
		#RightColumn #MonthTable div.DayNumber a { height: 1em; }
		</style><![endif]-->
	</head>
	<body bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
	
	<!-- Start Header --><?php echo $_SESSION["HEADER"]; ?><!-- End Header -->

	<?php
	echo '<div id="CalendarBlock">';
	require("topnavbar.inc.php");
}
?>