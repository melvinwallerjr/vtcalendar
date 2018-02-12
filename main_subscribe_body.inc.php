<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

$color = 'even';
$iCalDirName = 'calendars/';

$color = ($color == 'even')? 'odd' : 'even';

echo lang('subscribe_message') . '

<h3>' . lang('whole_calendar') . ':</h3>

<div class="pad"><table border="0" cellspacing="2" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th>' . lang('calendar') . '</th>
<th nowrap="nowrap">' . lang('upcoming_events') . '</th>
<th nowrap="nowrap">' . lang('ways_to_subscribe') . '</th>
</tr></thead>
<tbody><tr class="' . $color . '">
<td>' . htmlspecialchars($_SESSION['CALENDAR_NAME'], ENT_COMPAT, 'UTF-8') . '</td>';

// Get the categories from the DB
$result =& DBQuery("
SELECT
	count(*) AS eventcount
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
");
if (!is_string($result)) {
	$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	echo '
<td class="alignRight">' . $record['eventcount'] . '</td>';
	$result->free();
}

if (CACHE_SUBSCRIBE_LINKS && $_SESSION['CALENDAR_VIEWAUTHREQUIRED'] == 0) {
	echo '
<td><a href="' . BASEURL . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '.xml' . '">' . lang('rss_feed') . '</a>
&nbsp;|&nbsp;
<a href="webcal://' . preg_replace('/^[A-Za-z]+:\/\//', '', BASEURL) . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '.ics">' . lang('subscribe') . '</a>
&nbsp;|&nbsp;
<a href="' . BASEURL . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '.ics">' . lang('download') . '</a></td>';
}
else {
	echo '
<td><a href="' . BASEURL . EXPORT_PATH . '?calendar=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;format=rss2_0&amp;timebegin=upcoming">' . lang('rss_feed') . '</a>
&nbsp;|&nbsp;
<a href="webcal://' . preg_replace('/^[A-Za-z]+:\/\//', '', BASEURL) . EXPORT_PATH . '?calendar=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;format=ical&amp;timebegin=upcoming">' . lang('subscribe') . '</a>
&nbsp;|&nbsp;
<a href="' . BASEURL . EXPORT_PATH . '?calendar=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;format=ical&amp;timebegin=upcoming">' . lang('download') . '</a></td>';
}

echo '</tr></tbody>
</table></div><!-- .pad -->

<h3>' . lang('category') . ':</h3>

<div class="pad"><table border="0" cellspacing="2" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th nowrap="nowrap">' . lang('category') . '</th>
<th nowrap="nowrap">' . lang('upcoming_events') . '</th>
<th nowrap="nowrap">' . lang('ways_to_subscribe') . '</th>
</tr></thead>
<tbody>';

// Get the categories from the DB
$result =& DBQuery("
SELECT
	count(e.id) AS eventcount,
	c.id,
	c.name
FROM
	" . SCHEMANAME . "vtcal_category c
LEFT JOIN
	" . SCHEMANAME . "vtcal_event_public e
ON
	c.calendarid=e.calendarid
	AND
	c.id=e.categoryid
	AND
	e.timeend > '" . sqlescape(NOW_AS_TEXT) . "'
WHERE
	c.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
GROUP BY
	c.id
ORDER BY
	c.name
");
if (is_string($result)) { DBErrorBox($result); }
else {
	for ($i=0; $i < $result->numRows(); $i++) {
		$category =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		echo '<tr class="' . $color . '">
<td>' . htmlspecialchars($category['name'], ENT_COMPAT, 'UTF-8') . '</td>
<td class="alignRight">' . $category['eventcount'] . '</td>
<td>';
		if (CACHE_SUBSCRIBE_LINKS) {
			echo '<a href="' . BASEURL . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '_' . htmlspecialchars($category['id'], ENT_COMPAT, 'UTF-8') . '.xml">' . lang('rss_feed') . '</a>
&nbsp;|&nbsp;
<a href="webcal://' . preg_replace('/^[A-Za-z]+:\/\//', '', BASEURL) . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '_' . htmlspecialchars($category['id'], ENT_COMPAT, 'UTF-8') . '.ics">' . lang('subscribe') . '</a>
&nbsp;|&nbsp;
<a href="' . BASEURL . CACHE_SUBSCRIBE_LINKS_PATH . htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8') . '_' . htmlspecialchars($category['id'], ENT_COMPAT, 'UTF-8') . '.ics">' . lang('download') . '</a>';
		}
		else {
			echo '<a href="' . BASEURL . EXPORT_PATH . '?calendar=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;format=rss2_0&amp;timebegin=upcoming&amp;categories=' . $category['id'] . '">' . lang('rss_feed') . '</a>
&nbsp;|&nbsp;
<a href="webcal://' . preg_replace('/^[A-Za-z]+:\/\//', '', BASEURL) . EXPORT_PATH . '?calendar=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;format=ical&amp;timebegin=upcoming&amp;categories=' . $category['id'] . '">' . lang('subscribe') . '</a>
&nbsp;|&nbsp;
<a href="' . BASEURL . EXPORT_PATH . '?calendar=' . urlencode($_SESSION['CALENDAR_ID']) . '&amp;format=ical&amp;timebegin=upcoming&amp;categories=' . $category['id'] . '">' . lang('download') . '</a>';
		}
		echo '</td>
</tr>';
	}
}
echo '</tbody>
</table></div>' . "\n";
?>