<?php
require_once('application.inc.php');
require_once('main_globalsettings.inc.php');

// Verify that the user is authorized.
if (!viewauthorized()) { exit; }
isSponsor(); // when switching calendars this will set edit rights for authorized sponsors

// By default, do not show the "today" color.
$IsTodayBodyColor = 0;

// if only today is shown highlight it
if ($view == 'day') {
	if ($showdate['day'] == $today['day'] && $showdate['month'] == $today['month'] &&
	 $showdate['year'] == $today['year']) {
		$IsTodayBodyColor = 1;
	}
}

// Load the category names from the DB if they are not stored in the session.
if (empty($_SESSION['CATEGORY_NAMES'])) {
	// Retrieve all categories from the DB
	$result =& DBQuery("
SELECT
	id,
	name
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	name
");
	if (is_string($result)) {
		DBErrorBox($result);
		exit;
	}
	else {
		$numcategories = $result->numRows();
		// Setup a variable to hold the data to store in the session variable.
		if ($numcategories <= MAX_CACHESIZE_CATEGORYNAME) { $sessiondata = ''; }
		// Loop through all the categories for this calendar.
		for ($c=0; $c < $numcategories; $c++) {
			$categorydata =& $result->fetchRow(DB_FETCHMODE_ASSOC, $c);
			if ($numcategories <= MAX_CACHESIZE_CATEGORYNAME) {
				if ($c > 0) { $sessiondata .= "\n"; }
				$sessiondata .= $categorydata['id'] . "\t" . $categorydata['name'];
			}
			$categories_id[$c]= $categorydata['id'];
			$categories_name[$c]= $categorydata['name'];
		}
		// Set the session data to a session variable.
		if ($numcategories <= MAX_CACHESIZE_CATEGORYNAME) { $_SESSION['CATEGORY_NAMES'] = $sessiondata; }
	}
}
else {
	// Otherwise, process the category names stored in the session.
	$splitSessionData = explode("\n", $_SESSION['CATEGORY_NAMES']);
	$numcategories = count($splitSessionData);
	for ($i=0; $i < count($splitSessionData); $i++) {
		$splitCategoryData = explode("\t", $splitSessionData[$i]);
		$categories_id[$i]= $splitCategoryData[0];
		$categories_name[$i]= $splitCategoryData[1];
	}
}

// Split the category filter if it was specified as a string.
if (isset($CategoryFilter) && is_string($CategoryFilter)) {
	$CategoryFilter = explode(',', $CategoryFilter);
}

// Clear the category filter if the number of categories in the
// filter matches the total number of categories for the calendar.
if (isset($CategoryFilter) && count($CategoryFilter) == $numcategories) {
	unset($CategoryFilter);
	unset($_SESSION['CATEGORY_FILTER']);
}
elseif (isset($CategoryFilter)) {
	// Process filtered categories if they were set in the URL
	$SessionData = '';
	for ($i=0; $i < count($CategoryFilter); $i++) {
		if ($i > 0) { $SessionData .= ','; }
		$SessionData .= $CategoryFilter[$i];
	}
	// Set the category filter to the session.
	$_SESSION['CATEGORY_FILTER'] = $SessionData;
}
elseif (isset($_SESSION['CATEGORY_FILTER'])) {
	// Otherwise, check for existence of a cookie and process it.
	$CategoryFilter = split(',', $_SESSION['CATEGORY_FILTER']);
}

// The base text for the page title, which can be changed by the main_(view)_data.inc.php files.
$basetitle = '';

// Load any information that we may need to display in the header.
// Typically this only changes the base title, however, it may load data from the database.
// A situation where it will do this is with events, since it will want to output
// the event title in the <title> tag.
if ($view != '') { require('main_' . $view . '_data.inc.php'); }

// Output the header HTML
if ($view == 'upcoming') {
	pageheader(lang('upcoming_page_header', false) . $basetitle, 'Upcoming');
}
elseif ($view == 'day') {
	pageheader(lang('day_page_header', false) . $basetitle, 'Day');
}
elseif ($view == 'week') {
	pageheader(lang('week_page_header', false) . $basetitle, 'Week');
}
elseif ($view == 'month') {
	pageheader(lang('month_page_header', false) . $basetitle, 'Month');
}
elseif ($view == 'event') {
	pageheader(lang('event_page_header', false) . $basetitle, '');
}
elseif ($view == 'search') {
	pageheader(lang('search_page_header', false) . $basetitle, 'Search');
}
elseif ($view == 'searchresults') {
	pageheader(lang('searchresults_page_header', false) . $basetitle, 'SearchResults');
}
elseif ($view == 'subscribe') {
	pageheader(lang('subscribe_page_header', false) . $basetitle, 'Subscribe');
}
elseif ($view == 'filter') {
	pageheader(lang('filter_page_header', false) . $basetitle, 'Filter');
}
elseif ($view == 'export') {
	pageheader(lang('export_page_header', false) . $basetitle, 'Export');
}

// Output the calendar table.
?>
<table id="CalendarTable" width="100%" border="0" cellspacing="0" cellpadding="8">
<tbody><tr>
<?php
if (COLUMNSIDE == 'LEFT') {
	// If the column should be on the left, output it first then the body.
	include('main_column.inc.php');
	include('main_body.inc.php');
}
elseif (COLUMNSIDE == 'RIGHT') {
	// If the column should be on the right, output the body then the column.
	include('main_body.inc.php');
	include('main_column.inc.php');
}
?>
</tr></tbody>
</table>

<?php
pagefooter();
DBclose();
?>