<?php
$Submit_CreateExport = isset($_GET['createexport']);

// Defaults
$allcategories = '1';
$sponsor = 'all';
$htmltype = 'table';
$jshtml = '1';
$dateformat = 'normal';
$timedisplay = 'startdurationnormal';
$timeformat = 'normal';
$durationformat = 'normal';
$showdatetime = '1';
$showlocation = '1';
$showallday = '1';

$FormErrors = array();

// Generic messages
$lang['export_leaveblank'] = 'Leave blank for no maximum';
$lang['export_show'] = 'Show';
$lang['export_hide'] = 'Hide';

// Submit button for export
$lang['export_submit'] = 'Preview the Export';

// Message after the first submit button (only if HTML was selected)
$lang['export_keepscrolling'] = ' or keep scrolling down for more HTML settings.';

// Message after the second submit button (only if HTML was selected).
$lang['export_resetform'] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>- or -</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="export-new.php">Reset the Form</a>';

// Header for first section of export
$lang['export_settings'] = 'Export Settings';

$lang['export_format'] = 'Export Format';
$lang['export_format_error'] = 'You must select the &quot;'.$lang['export_format'].'&quot;';

$lang['export_maxevents'] = 'Maximum Events Returned';
$lang['export_maxevents_description'] = 'The maximum number of upcoming events that will be returned by this script.';
$lang['export_maxevents_error'] = 'You must either enter a number for &quot;' . $lang['export_maxevents'] . '&quot; or leave it blank.';

$lang['export_dates'] = 'Dates';
$lang['export_dates_description'] = 'The start and end date for which you want events.';

$lang['export_dates_from'] = 'From';
$lang['export_dates_from_description'] = 'Leave blank for no start date, enter a date in <code>YYYY-MM-DD</code> format, or enter &quot;Today&quot; to use today\'s date.';
$lang['export_dates_from_error'] = 'You must either enter a &quot;'. $lang['export_dates_from'] .'&quot; date in <code>yyyy-mm-dd</code> format or leave it blank for no &quot;'.$lang['export_dates_from'].'&quot; date.';

$lang['export_dates_to'] = 'To';
$lang['export_dates_to_description'] = 'Leave blank for no end date, enter a date in <code>YYYY-MM-DD</code> format, or enter a number to represent the number of days after the &quot;'.$lang['export_dates_from'].'&quot; date.';
$lang['export_dates_to_error'] = 'You must either enter a &quot;'. $lang['export_dates_to'] .'&quot; date in <code>yyyy-mm-dd</code> format or leave it blank for no &quot;'.$lang['export_dates_to'].'&quot; date.';

$lang['export_categories'] = 'Categories';
//$lang['export_categories_all'] = 'Select/Unselect All';
$lang['export_categories_error'] = 'You must select one or more categories.';

$lang['export_sponsor'] = 'Sponsor';
$lang['export_sponsor_all'] = 'All sponsors';
$lang['export_sponsor_specific'] = 'Specific sponsor';
$lang['export_sponsor_specific_description'] = 'case-insensitive substring search, e.g. school of the arts';
$lang['export_sponsor_error'] = 'You must either select &quot;'.$lang['export_sponsor_all'].'&quot; or select &quot;'.$lang['export_sponsor_specific'].'&quot; and enter sponsor search text.';

// Header of second section of export
$lang['export_htmlsettings'] = 'General HTML Settings';

$lang['export_keepcategoryfilter'] = 'Keep Category Filter in VTCalendar';
$lang['export_keepcategoryfilter_description'] = 'When events are clicked, and users go to the full VTCalendar screen, the category filter is not maintained.<br>Check the box below if you would like to pass the category filter to VTCalendar so the day, week, month, etc. views are also filtered.<br>This will be ignored if you did selected &quot;All categories&quot; in the previous section.';

$lang['export_htmltype'] = 'HTML Type';
$lang['export_htmltype_description'] = 'For the HTML export formats (including HTML via JavaScript), the output can either be a series of paragraphs or rows in a single table.';
$lang['export_htmltype_paragraph'] = 'Paragraph';
$lang['export_htmltype_table'] = 'Table';

$lang['export_jsoutput'] = 'Output via JavaScript';
$lang['export_jsoutput_description'] = 'Wrap the HTML in <code>document.write</code> calls so that it can be displayed easily on other pages.';

// Header of third  section of export
$lang['export_datetimesettings'] = 'HTML Date/Time Settings';

$lang['export_dateformat'] = 'Date Format';
$lang['export_timedisplay'] = 'Time Display';
$lang['export_timedisplay_description'] = 'The time can only display the starting time, display the start and end time, or display the start time and how long the event will last (aka: duration).';
$lang['export_timedisplay_startonly'] = 'Start Only';
$lang['export_timedisplay_startend'] = 'Start and End';
$lang['export_timedisplay_startduration'] = 'Start and Duration';

$lang['export_timeformat'] = 'Time Format';
$lang['export_timeformat_description'] = 'You can change how much information is included when a time is displayed (this effects both start and end times).';

$lang['export_durationformat'] = 'Duration Format';

// Header of fourth section of export
$lang['export_htmldisplaysettings'] = 'HTML Display Settings';

$lang['export_showdatetime'] = 'Show Date/Time';
$lang['export_showdatetime_description'] = 'You may show or hide the date and time in the returned events.<br>This can be done if you have a limited amount of space on your web site.<br>&nbsp;<br><i>Note:</i> It is recommended to show the date and time.';

$lang['export_showlocation'] = 'Show Location';
$lang['export_showlocation_description'] = 'You may show or hide the location in the returned events.<br>This can be done if you have a limited amount of space on your web site.';

$lang['export_showallday'] = 'Show &quot;All Day&quot;';
$lang['export_showallday_description'] = 'If an event is all day (aka: it does not have a start time) you may show or hide the &quot;All Day&quot; text.<br>This helps to keep the event listing clean if you have a lot of events that are all day.<br>&nbsp;<br>Note: It is recommended to show &quot;All Day&quot;.';

$lang['export_maxtitlechars'] = 'Maximum Characters for the Title';
$lang['export_maxtitlechars_description'] = 'If you have a limited amount of space on your Web site, you may limit the length of the event title.<br>Any titles that are beyond this length will be truncated and an ellipse (...) will be added to the end.';
$lang['export_maxtitlechars_error'] = 'You must either enter a number for &quot;' . $lang['export_maxtitlechars'] . '&quot; or leave it blank.';

$lang['export_maxlocationchars'] = 'Maximum Characters for the Location';
$lang['export_maxlocationchars_description'] = 'If you have a limited amount of space on your Web site, you may limit the length of the event location.<br>Any locations that are beyond this length will be truncated and an ellipse (...) will be added to the end.';
$lang['export_maxlocationchars_error'] = 'You must either enter a number for &quot;' . $lang['export_maxlocationchars'] . '&quot; or leave it blank.';

if (isset($_GET['format'])) setVar($format,$_GET['format'],'exportformat');
if (isset($_GET['maxevents']) && !setVar($maxevents,$_GET['maxevents'],'int_gte1')) $FormErrors['maxevents'] = lang('export_maxevents_error');

if (isset($_GET['timebegin']) && (strtolower($_GET['timebegin']) == "today" || isValidInput($_GET['timebegin'] . " 00:00:00", 'timebegin'))) $timebegin = $_GET['timebegin']; else $FormErrors['timebegin'] = lang('export_dates_from_error');
if (isset($_GET['timeend']) && isValidInput($_GET['timeend'] . " 23:59:59", 'timeend')) $timeend = $_GET['timeend']; else $FormErrors['timeend'] = lang('export_dates_to_error');

if (isset($_GET['allcategories']) && !setVar($allcategories,$_GET['allcategories'],'boolean_checkbox')) unset($allcategories);
if (isset($_GET['categories'])) setVar($categories,$_GET['categories'],'categoryfilter');

if (isset($_GET['sponsor'])) setVar($sponsor,$_GET['sponsor'],'sponsortype');
if (isset($_GET['specificsponsor'])) setVar($specificsponsor,$_GET['specificsponsor'],'specificsponsor');

if (isset($_GET['keepcategoryfilter'])) setVar($keepcategoryfilter,$_GET['keepcategoryfilter'],'boolean_checkbox');
if (isset($_GET['htmltype'])) setVar($htmltype,$_GET['htmltype'],'htmltype');
if (isset($_GET['jshtml']) && !setVar($jshtml,$_GET['jshtml'],'boolean_checkbox')) unset($jshtml);

if (isset($_GET['dateformat'])) setVar($dateformat,$_GET['dateformat'],'dateformat');
if (isset($_GET['timedisplay'])) setVar($timedisplay,$_GET['timedisplay'],'timedisplay');
if (isset($_GET['timeformat'])) setVar($timeformat,$_GET['timeformat'],'timeformat');
if (isset($_GET['durationformat'])) setVar($durationformat,$_GET['durationformat'],'durationformat');

if (isset($_GET['showdatetime'])) setVar($showdatetime,$_GET['showdatetime'],'boolean');
if (isset($_GET['showlocation'])) setVar($showlocation,$_GET['showlocation'],'boolean');
if (isset($_GET['showallday'])) setVar($showallday,$_GET['showallday'],'boolean');
if (isset($_GET['maxtitlecharacters'])) setVar($maxtitlecharacters,$_GET['maxtitlecharacters'],'int_gte1');
if (isset($_GET['maxlocationcharacters'])) setVar($maxlocationcharacters,$_GET['maxlocationcharacters'],'int_gte1');
?>