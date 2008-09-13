<?php
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
	
	<!-- Start Calendar Header --><?php echo $_SESSION["HEADER"]; ?><!-- End Calendar Header -->

	<?php
	echo '<div id="CalendarBlock">';
	require("topnavbar.inc.php");
}

function pagefooter() {
	?>
	</div>

<!-- Start Calendar Footer --><?php echo $_SESSION["FOOTER"]; ?><!-- End Calendar Footer -->

  </body>
</html>
	<?php
}

// Output the beginning of a section where content can be displayed.
// Normally, the background is colored and the background of the calendar cells are colored white.
// When any other content needs to be displayed, it should be enclosed by contentsection_begin and contentsection_end.
function contentsection_begin($headertext="", $showBackToMenuButton=false) {
	
	if ($showBackToMenuButton) {
		?><div id="MenuButton"><table border="0" cellpadding="3" cellspacing="0"><tr><td><b><a href="update.php"><?php echo lang('back_to_menu'); ?></a></b></td></tr></table></div><?php
	}
	
	?><div id="UpdateBlock"><div style="border: 1px solid #666666; padding: 8px;"><?php
	
  if (!empty($headertext)) {
    echo "<h2>".htmlentities($headertext).":</h2>";
	}
}

// Output the end of a section where content can be displayed.
// Normally, the background is colored and the background of the calendar cells are colored white.
// When any other content needs to be displayed, it should be enclosed by contentsection_begin and contentsection_end.
function contentsection_end() {
	?></div></div><?php
}

// Outputs the header HTML code for a pop-up help window. See helpwindow_footer() as well.
function helpwindow_header() {
	?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
		<title><?php echo lang('help'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta content="en-us" http-equiv=language>
		<link href="stylesheet.php" rel="stylesheet" type="text/css">
	</head>
	<body bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onLoad="this.window.focus()">
		<br>
		<table border="0" cellPadding="5" cellSpacing="0">
			<tr>
			<td bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>">&nbsp;</td>
			<td bgcolor="#eeeeee"><?php
} // end: function helpwindow_header
	
// Outputs the footer HTML code for a pop-up help window. See helpwindow_header() as well.
function helpwindow_footer() {
  ?></td>
				<td bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>">&nbsp;</td>
			</tr>
		</table>
		<br>
	</body>
	</html>
	<?php
} // end: function helpwindow_footer
?>