<?php
// Defines a single function that outputs the page header:
function pageheader($title, $navbaractive) {
	global $enableViewMonth, $timebegin, $queryStringExtension, $view;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo lang('lang'); ?>" lang="<?php echo lang('lang'); ?>"><head>

<title><?php echo TITLEPREFIX . $title . TITLESUFFIX; ?></title>

<meta http-equiv="language" content="<?php echo lang('lang'); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="<?php echo ($view == 'event')? 'index' : 'noindex'; ?>,follow" />
<?php
	// link RSS resource
	echo '<link type="application/rss+xml" rel="alternate" href="';
	if (CACHE_SUBSCRIBE_LINKS && $_SESSION['CALENDAR_VIEWAUTHREQUIRED'] == 0) {
		echo BASEURL . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '.xml';
	}
	else {
		echo BASEURL . EXPORT_PATH . '?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
		 '&amp;format=rss2_0&amp;timebegin=upcoming';
	}
	echo '" title="' . lang('rss_feed_title', false) . '" />' . "\n";
?>
<link type="text/css" rel="stylesheet" href="calendar.css" />
<?php echo siteColorStyles(); ?>
<link type="text/css" rel="stylesheet" href="print.css" media="print" />
<!--[if IE]><style type="text/css">/* <![CDATA[ */
#CalendarBlock a * { cursor: pointer; }
#CalendarBlock #calBar li.selTab a * { cursor: default; }
#CalendarBlock #calBar li.calUpdate a * { cursor: pointer; }
/* ]]> */</style><![endif]-->
<!--[if lt IE 8]><style type="text/css">/* <![CDATA[ */
.calLogo { margin-top: 10px; }
/* ]]> */</style><![endif]-->
<!--[if lt IE 7]><style type="text/css">/* <![CDATA[ */
img, .png { behavior: url('scripts/iepngfix.htc'); }
#CalendarBlock #calBar h2.calendartitle { margin: 0px 0px 0px 20px }
/* ]]> */</style><![endif]-->
<!--[if lte IE 6]><style type="text/css">/* <![CDATA[ */
#RightColumn #MonthTable div.DayNumber a { height: 1em; }
/* ]]> */</style><![endif]-->
<?php if (strpos($_SERVER['PHP_SELF'], 'changecolors.php') !== false) { ?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="scripts/colorpicker/colorpicker.css" />
<?php } ?>

<!-- Start Calendar HTML Header -->
<?php echo $_SESSION['CALENDAR_HTMLHEADER'] . "\n"; ?>
<!-- End Calendar HTML Header -->

</head><body><div id="wrapper">

<?php
	if (INCLUDE_STATIC_PRE_HEADER && $_SESSION['CALENDAR_ID'] != 'default') {
		require('static-includes/subcalendar-pre-header.inc');
	}
?>

<!-- Start Calendar Header -->
<?php echo $_SESSION['CALENDAR_HEADER'] . "\n"; ?>
<!-- End Calendar Header -->

<?php
	if (INCLUDE_STATIC_POST_HEADER && $_SESSION['CALENDAR_ID'] != 'default') {
		require('static-includes/subcalendar-post-header.inc');
	}

	$navbaractive = mb_strtolower($navbaractive, 'UTF-8');
	$calendartitle = (isset($_SESSION['CALENDAR_TITLE']) && $_SESSION['CALENDAR_TITLE'] != '')?
	 $_SESSION['CALENDAR_TITLE'] : lang('calendar');
	$calendarname = (isset($_SESSION['NAME']) && $_SESSION['NAME'] != '')?
	 $_SESSION['NAME'] : lang('event_page_header');

	echo '
<div id="CalendarBlock">';

	echo '
<div class="calLogo"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=' . (SHOW_UPCOMING_TAB? 'upcoming' : 'day') . $queryStringExtension . '"><img src="images/logo.gif" alt="Calendar Home" width="34" height="34" /></a></div>

<div id="calBar">
<h2 class="calendartitle">' . $calendartitle . '</h2>

<div class="navBar"><ul>' . "\n";

	if (SHOW_UPCOMING_TAB) {
		echo '
<li class="calUpcoming' . (($navbaractive == 'upcoming')? ' selTab"><a>' : '"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=upcoming">') . '<b>' . lang('upcoming') . '</b></a></li>' . "\n";
	}

	echo '
<li class="calDay' . (($navbaractive == 'day')? ' selTab"><a>' : '"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=day&amp;timebegin=' . urlencode($timebegin) . $queryStringExtension . '">') . '<b>' . lang('day') . '</b></a></li>

<li class="calWeek' . (($navbaractive == 'week')? ' selTab"><a>' : '"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=week&amp;timebegin=' . urlencode($timebegin) . $queryStringExtension . '">') . '<b>' . lang('week') . '</b></a></li>' . "\n";

	if ($enableViewMonth) {
		echo '
<li class="calMonth' . (($navbaractive == 'month')? ' selTab"><a>' :
 '"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=month&amp;timebegin=' . urlencode($timebegin) . $queryStringExtension . '">') . '<b>' . lang('month') . '</b></a></li>' . "\n";
	}

	echo '
<li class="calSearch' . (($navbaractive == 'search')? ' selTab"><a>' : '"><a href="main.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;view=search">') . '<b>' . lang('search') . '</b></a></li>

<li class="calUpdate' . (($navbaractive == 'update')? ' selTab' : '') .
 '"><a href="' . SECUREBASEURL . 'update.php"><b>' . lang('update') . '</b></a></li>

</ul></div></div><!-- calBar -->' . "\n";

	if (!empty($_SESSION['AUTH_SPONSORNAME']) || !empty($_SESSION['AUTH_USERID'])) {
		echo "\n" . '<div id="auxNav">';
		if ($navbaractive == 'update' && strpos($_SERVER['PHP_SELF'], 'update.php') === false) {
			echo '
<b class="MenuButton"><a href="update.php">' . lang('back_to_menu') . '</a></b>';
		}
		if (!empty($_SESSION['AUTH_SPONSORNAME'])) {
			if (isset($_SESSION['AUTH_SPONSORCOUNT']) && $_SESSION['AUTH_SPONSORCOUNT'] > 1) {
				echo '
<a href="' . SECUREBASEURL . 'update.php?authsponsorid=" title="Change Sponsor"><b>' . htmlspecialchars($_SESSION['AUTH_SPONSORNAME'], ENT_COMPAT, 'UTF-8') . '</b></a>';
			}
			else {
				echo '<b>' . htmlspecialchars($_SESSION['AUTH_SPONSORNAME'], ENT_COMPAT, 'UTF-8') . '</b>';
			}
			echo ' &nbsp;|&nbsp; ';
		}
		if (!empty($_SESSION['AUTH_USERID'])) {
			echo '
<a href="' . SECUREBASEURL . 'logout.php" title="' . lang('logout', false) . ': ' . $_SESSION['AUTH_USERID'] . (!empty($_SESSION['AUTH_SPONSORNAME'])? ' (' . $_SESSION['AUTH_SPONSORNAME'] . ')' : '') . '"><b>' . lang('logout') . ' ' . $_SESSION['AUTH_USERID'] . '</b></a>';
		}
		echo "\n" . '</div><!-- #auxNav -->' . "\n";
	}
	else {
		echo "\n" . '<div id="auxNav">&nbsp;</div>';
	}
}

function poweredBy()
{
	echo '<p id="PoweredBy">' . lang('powered_by') . ' <a href="http://vtcalendar.sourceforge.net/" target="_blank">VTCalendar</a>' . (defined('VERSION')? ' ' . VERSION . (defined('VERSION_EXTENSION')? VERSION_EXTENSION : '') : '') . '</p>' . "\n";
}

function pagefooter()
{
	global $query;
	poweredBy();
	if (isset($_SESSION['AUTH_ISMAINADMIN']) && $_SESSION['AUTH_ISMAINADMIN'] == 1 &&
	 isset($_SESSION['DEBUG']) && $_SESSION['DEBUG'] == 'true') {
		echo '<pre>SESSION '; print_r($_SESSION); echo '</pre>';
		if (isset($query)) { echo '<pre>LAST QUERY '; print_r($query); echo '</pre>'; }
	}
	echo '</div><!-- #CalendarBlock -->';
	if (INCLUDE_STATIC_PRE_FOOTER && $_SESSION['CALENDAR_ID'] != 'default') {
		require('static-includes/subcalendar-pre-footer.inc');
	}
	echo'
<!-- Start Calendar Footer -->
' . $_SESSION['CALENDAR_FOOTER'] . '
<!-- End Calendar Footer -->';
	if (INCLUDE_STATIC_POST_FOOTER && $_SESSION['CALENDAR_ID'] != 'default') {
		require('static-includes/subcalendar-post-footer.inc');
	}
	echo '
<script type="text/javascript" src="scripts/general.js"></script>

</div></body></html>' . "\n";
}

// Output the beginning of a section where content can be displayed.
// Normally, the background is colored and the background of the calendar cells are colored white.
// When any other content needs to be displayed, it should be enclosed by contentsection_begin and contentsection_end.
function contentsection_begin($headertext='', $showBackToMenuButton=false)
{
	/*
	if ($showBackToMenuButton && $navbaractive == 'update') {
		echo '
<div id="MenuButton"><table border="0" cellpadding="3" cellspacing="0">
<tbody><tr>
<td><b><a href="update.php">' . lang('back_to_menu') . '</a></b></td>
</tr></tbody>
</table></div>' . "\n";
	}
	*/
	echo '
<div id="UpdateBlock"><div class="pad" style="border:1px solid ' . $_SESSION['COLOR_BORDER'] . ';">';
	if (!empty($headertext)) {
		echo '
<h3>' . $headertext . ':</h3>' . "\n";
	}
}

/**
 * Output the end of a section where content can be displayed.
 * Normally, the background is colored and the background of the calendar cells are colored white.
 * When any other content needs to be displayed, it should be enclosed by
 * contentsection_begin and contentsection_end.
 */
function contentsection_end()
{
	echo '
</div></div><!-- #UpdateBlock -->' . "\n";
}

function helpwindow_header()
{ // Outputs the header HTML code for a pop-up help window. See helpwindow_footer() as well.
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo lang('lang'); ?>" lang="<?php echo lang('lang'); ?>"><head>

<title><?php echo lang('help', false); ?></title>
<meta http-equiv="language" content="<?php echo lang('lang'); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="calendar.css" />
<?php echo siteColorStyles(); ?>

</head><body onload="this.window.focus()"><div id="wrapper">

<div class="bgLight pad">
<?php
}

function helpwindow_footer()
{ // Outputs the footer HTML code for a pop-up help window. See helpwindow_header() as well.
?>
</div><!-- .bgLight -->

</div></body></html>
<?php
}

function siteColorStyles()
{ // stylesheet values defined by changecalendarsettings.php
	// NOTE: Pure white text (#FFFFFF) is not printable, when pure white text
	// is defined it is changed here to the lightest grey possible.
	echo '
<style type="text/css">/* <![CDATA[ */
pre, kbd, code, .pre {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
}
.odd {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
.even {
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
}
.greyed {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
.bgDefault {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
.bgDark {
	background-color: ' . $_SESSION['COLOR_TABLE_HEADER_BG'] . ';
}
.bgLight {
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
}
.txtWarn {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_WARNING'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_WARNING']) . ';
}
.highlight {
	background-color: ' . $_SESSION['COLOR_KEYWORD_HIGHLIGHT'] . ';
}
.fromCal {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
#CalendarBlock, #CalendarBlock td, #CalendarBlock p, #CalendarBlock h2 {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT']) . ';
}
#CalendarBlock a {
	color: ' . ((mb_strtolower($_SESSION['COLOR_LINK'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_LINK']) . ';
}
thead tr.TableHeaderBG, tfoot tr.TableHeaderBG, th.TableHeaderBG {
	background-color: ' . $_SESSION['COLOR_TABLE_HEADER_BG'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TABLE_HEADER_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TABLE_HEADER_TEXT']) . ';
}
#CalendarBlock .txtWarn {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_WARNING'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_WARNING']) . ';
}
#CalendarBlock h2 {
	color: ' . ((mb_strtolower($_SESSION['COLOR_H2'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_H2']) . ';
}
#CalendarBlock h3 {
	color: ' . ((mb_strtolower($_SESSION['COLOR_H3'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_H3']) . ';
}
#CalendarBlock h4 {
	color: ' . ((mb_strtolower($_SESSION['COLOR_H3'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_H3']) . ';
}
#CalendarBlock .KeywordHighlight {
	background-color: ' . $_SESSION['COLOR_KEYWORD_HIGHLIGHT'] . ';
}
#CalendarBlock div.FormSectionHeader {
	border-top-color: ' . $_SESSION['COLOR_BORDER'] . ';
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
}
#CalendarBlock .LightCellBG {
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
}
#calBar {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
}
#calBar li a b {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
}
#calBar li a:link, #calBar li a:visited {
	background-color: ' . $_SESSION['COLOR_TABGRAYED_BG'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TABGRAYED_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TABGRAYED_TEXT']) . ';
}
#calBar li.selTab a { /* selected tab */
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
#calBar li.selTab a { /* selected tab */
	color: ' . ((mb_strtolower($_SESSION['COLOR_TITLE'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TITLE']) . ';
}
#calBar li a:focus, #calBar li a:active, #calBar li a:hover {
	background-color: ' . $_SESSION['COLOR_TABGRAYED_TEXT'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TABGRAYED_BG'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TABGRAYED_BG']) . ';
}
#calBar li, #calBar li.selTab a:link, #calBar li.selTab a:visited { /* selected tab */
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TITLE'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TITLE']) . ';
}
#calBar li.selTab a:focus, #calBar li.selTab a:active, #calBar li.selTab a:hover {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TITLE'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TITLE']) . ';
}
#auxNav {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
#CalendarTable {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
#MonthSelector div#LeftArrowButtonDisabled, #MonthSelector div#RightArrowButtonDisabled {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
div#LittleCalendar-Padding {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
table#LittleCalendar {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
table#LittleCalendar .LittleCalendar-Week {
	border-right-color: ' . $_SESSION['COLOR_LITTLECAL_LINE'] . ';
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
}
table#LittleCalendar thead th {
	border-bottom-color: ' . $_SESSION['COLOR_LITTLECAL_LINE'] . ';
}
table#LittleCalendar td.SelectedDay {
	background-color: ' . $_SESSION['COLOR_LITTLECAL_HIGHLIGHT'] . ';
}
a.LittleCal-Today, a.LittleCal-TodayGrayedOut {
	border: 1px solid ' . $_SESSION['COLOR_LITTLECAL_TODAY'] . ';
	background-color: ' . $_SESSION['COLOR_TODAY'] . ';
}
a.LittleCal-GrayedOut, a.LittleCal-TodayGrayedOut {
	color: ' . ((mb_strtolower($_SESSION['COLOR_LITTLECAL_FONTFADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_LITTLECAL_FONTFADED']) . ' !important;
}
table#LittleCalendar a:focus, table#LittleCalendar a:active, table#LittleCalendar a:hover {
	border-color: ' . $_SESSION['COLOR_GOBTN_BORDER'] . ';
	background-color: ' . $_SESSION['COLOR_GOBTN_BG'] . ';
}
input.buttonGo {
	border-color: ' . $_SESSION['COLOR_GOBTN_BORDER'] . ';
	background-color: ' . $_SESSION['COLOR_GOBTN_BG'] . ';
}
input.buttonGo:focus, input.buttonGo:active, input.buttonGo:hover {
	border-color: ' . $_SESSION['COLOR_GOBTN_BG'] . ';
}
td#CalSideCol table#TodaysDate td {
	background-color: ' . $_SESSION['COLOR_TODAY'] . ';
}
td#CalMainCol {
	border-color: ' . $_SESSION['COLOR_BODY'] . ';
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
td#CalMainCol.TodayHighlighted {
	border-color: ' . $_SESSION['COLOR_TODAY'] . ' !important;
}
table#FilterNotice td {
	background: ' . $_SESSION['COLOR_FILTERNOTICE_BG'] . ' ' .
	 (empty($_SESSION['COLOR_FILTERNOTICE_BGIMAGE'])? 'none' :
	 'url(\'' . $_SESSION['COLOR_FILTERNOTICE_BGIMAGE']) . '\') no-repeat left top' . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_FILTERNOTICE_FONT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_FILTERNOTICE_FONT']) . ';
}
table#FilterNotice a {
	color: ' . ((mb_strtolower($_SESSION['COLOR_FILTERNOTICE_FONTFADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_FILTERNOTICE_FONTFADED']) . ';
}
table#FilterNotice a:hover {
	color: ' . ((mb_strtolower($_SESSION['COLOR_FILTERNOTICE_FONT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_FILTERNOTICE_FONT']) . ';
}
div#TitleAndNavi {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
div#TitleAndNavi.TodayHighlighted {
	background-color: ' . $_SESSION['COLOR_TODAY'] . ';
}
#EventTable {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
#EventTable #EventRightColumn {
	border-left-color: ' . $_SESSION['COLOR_EVENTBAR_CURRENT'] . ';
}
table#EventDetail td {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
}
td.EventDetail-Label {
	background-color: ' . $_SESSION['COLOR_TABLE_HEADER_BG'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TABLE_HEADER_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TABLE_HEADER_TEXT']) . ' !important;
}
#DayTable tr.BorderTop td {
	border-top-color: ' . $_SESSION['COLOR_BORDER'] . ';
}
#DayTable div.EventLeftBar {
	border-left-color: ' . $_SESSION['COLOR_EVENTBAR_CURRENT'] . ';
}
#DayTable td.DateRow div#TodayDateRow {
	background-color: ' . $_SESSION['COLOR_TODAY'] . ';
}
#DayTable td.DateRow div {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
#DayTable td.TimeColumn-Past, #DayTable td.DataColumn-Past {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
#DayTable td.DataColumn-Past a {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
#DayTable td.DataColumn-Past div.EventLeftBar {
	border-left-color: ' . $_SESSION['COLOR_EVENTBAR_PAST'] . ';
}
#WeekdayTable th, #WeekdayTable td {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
}
#WeekdayTable thead th {
	background-color: ' . $_SESSION['COLOR_TABLE_HEADER_BG'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TABLE_HEADER_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TABLE_HEADER_TEXT']) . ' !important;
}
#WeekdayTable thead th.Weekday-Today {
	background-color: ' . $_SESSION['COLOR_TODAY'] . ' !important;
}
#WeekdayTable tbody td.Weekday-Today {
	background-color: ' . $_SESSION['COLOR_TODAYLIGHT'] . ';
}
#WeekdayTable tbody div.WeekEvent-Past {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
#WeekdayTable tbody div.WeekEvent-Past a {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
#WeekdayTable tbody div.WeekEvent-Title, #WeekdayTable tbody div.WeekEvent-Category {
	border-left-color: ' . $_SESSION['COLOR_EVENTBAR_FUTURE'] . ';
}
#WeekdayTable tbody td.Weekday-Today div.WeekEvent-Title,
#WeekdayTable tbody td.Weekday-Today div.WeekEvent-Category {
	border-left-color: ' . $_SESSION['COLOR_EVENTBAR_CURRENT'] . ';
}
#WeekdayTable tbody div.WeekEvent-Past div.WeekEvent-Title,
#WeekdayTable tbody div.WeekEvent-Past div.WeekEvent-Category {
	border-left-color: ' . $_SESSION['COLOR_EVENTBAR_PAST'] . ';
}
#MonthTable {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
#MonthTable th, #MonthTable td {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
}
#MonthTable thead th {
	background-color: ' . $_SESSION['COLOR_TABLE_HEADER_BG'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TABLE_HEADER_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TABLE_HEADER_TEXT']) . ' !important;
}
#MonthTable div.DayNumber a:hover, #MonthTable div.DayNumber a:focus {
	background-color: ' . $_SESSION['COLOR_MONTHDAYLABELS_FUTURE'] . ';
}
#MonthTable tbody td.MonthDay-Today {
	background-color: ' . $_SESSION['COLOR_TODAYLIGHT'] . ';
}
#MonthTable tbody td.MonthDay-Today div.DayNumber {
	background-color: ' . $_SESSION['COLOR_TODAY'] . ' !important;
}
#MonthTable td.MonthDay-Past div.DayNumber a, #MonthTable p.EventItem-Past a {
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT_FADED'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT_FADED']) . ';
}
#MonthTable td.MonthDay-Past div.DayNumber a:hover,
#MonthTable td.MonthDay-Past div.DayNumber a:focus {
	background-color: ' . $_SESSION['COLOR_MONTHDAYLABELS_PAST'] . ';
}
#MonthTable td.MonthDay-Today div.DayNumber a:hover,
#MonthTable td.MonthDay-Today div.DayNumber a:focus {
	background-color: ' . $_SESSION['COLOR_MONTHDAYLABELS_CURRENT'] . ';
}
#MonthTable td.MonthDay-OtherMonth {
	background-color: ' . $_SESSION['COLOR_OTHERMONTH'] . ' !important;
}
#ExportForm p.FormError {
	border-top-color: ' . $_SESSION['COLOR_TEXT_WARNING'] . ';
}
body #PoweredBy {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
table.AdminButtons a {
	border-color: ' . $_SESSION['COLOR_BORDER'] . ';
	background-color: ' . $_SESSION['COLOR_LIGHT_CELL_BG'] . ';
	color: ' . ((mb_strtolower($_SESSION['COLOR_TEXT'], 'UTF-8') == '#ffffff')?
	 '#fefefe' : $_SESSION['COLOR_TEXT']) . ';
}
table.AdminButtons a.AdminButtons-New, div.AdminButtons-Small table.AdminButtons a.AdminButtons-New {
	border-color: ' . $_SESSION['COLOR_NEWBORDER'] . ';
	background-color: ' . $_SESSION['COLOR_NEWBG'] . ';
}
table.AdminButtons a.AdminButtons-Edit, div.AdminButtons-Small table.AdminButtons a.AdminButtons-Edit {
	border-color: ' . $_SESSION['COLOR_NEWBORDER'] . ';
	background-color: ' . $_SESSION['COLOR_NEWBG'] . ';
}
table.AdminButtons .AdminButtons-Copy, div.AdminButtons-Small table.AdminButtons a.AdminButtons-Copy {
	border-color: ' . $_SESSION['COLOR_COPYBORDER'] . ';
	background-color: ' . $_SESSION['COLOR_COPYBG'] . ';
}
table.AdminButtons .AdminButtons-Delete, table.AdminButtons .AdminButtons-Reject,
div.AdminButtons-Small table.AdminButtons a.AdminButtons-Delete,
div.AdminButtons-Small table.AdminButtons a.AdminButtons-Reject {
	border-color: ' . $_SESSION['COLOR_DELETEBORDER'] . ';
	background-color: ' . $_SESSION['COLOR_DELETEBG'] . ';
}
table.AdminButtons a.AdminButtons-Approve, div.AdminButtons-Small table.AdminButtons a.AdminButtons-Approve {
	border-color: ' . $_SESSION['COLOR_APPROVEBORDER'] . ';
	background-color: ' . $_SESSION['COLOR_APPROVEBG'] . ';
}
div#UpdateBlock {
	background-color: ' . $_SESSION['COLOR_BG'] . ';
}
div#MenuButton {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
div#MenuButton a, b.MenuButton a {
	background-color: ' . $_SESSION['COLOR_BODY'] . ';
}
div#MenuButton a:hover, div#MenuButton a:focus {
	background-color: ' . $_SESSION['COLOR_TODAY'] . ';
}
/* ]]> */</style>';
}
?>