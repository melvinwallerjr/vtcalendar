<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

echo '<td id="CalMainCol"' . ($IsTodayBodyColor? ' class="TodayHighlighted"' : '') . '>';

if (($view == 'upcoming' || $view == 'day' || $view == 'week' || $view == 'month' ||
 $view == 'search' || $view == 'searchresults') && (isset($CategoryFilter) ||
 (!empty($keyword) && $view != 'search' && $view != 'searchresults'))) {
	echo '
<table id="FilterNotice" width="100%" border="0" cellspacing="0" cellpadding="4">
<tbody><tr>
<td><b>' . lang('showing_filtered_events') . ':</b>';
	if (!empty($keyword)) {
		echo '
&quot;' . htmlspecialchars($keyword, ENT_COMPAT, 'UTF-8') . '&quot;';
	}
	if (!empty($keyword) && isset($CategoryFilter)) { echo ' &amp; '; }
	if (isset($CategoryFilter)) {
		echo '
<a href="main.php?calendarid=' . $_SESSION['CALENDAR_ID'] . '&amp;view=filter&amp;oldview=' . urlencode($view) . '">(';
		// The list of categories that will be outputted.
		$activecategories = '';
		// Create a lookup for getting the array index by category ID.
		$CategoryIdFlip = array_flip($categories_id);
		for ($i=0; $i < count($CategoryFilter) && strlen($activecategories) <= 70; $i++) {
			if (isset($CategoryIdFlip[$CategoryFilter[$i]])) {
				if ($i > 0) { $activecategories .= ', '; }
				$activecategories .= $categories_name[$CategoryIdFlip[$CategoryFilter[$i]]];
			}
		}
		// Add an elipse if the output got too long.
		if (strlen($activecategories) > 70) { $activecategories .= ', &hellip;'; }
		// Output the list of categories.
		echo $activecategories . ')</a>';
	}
	echo '</td>
</tr></tbody>
</table><!-- #FilterNotice -->' . "\n";
}
?>

<div id="TitleAndNavi"<?php echo ($IsTodayBodyColor)? ' class="TodayHighlighted"' : ''; ?>><table border="0" cellspacing="0" cellpadding="4">
<tbody><tr>
<td id="DateOrTitle"><h2><?php require('main_' . $view . '_datetitle.inc.php'); ?></h2></td>
<td id="NavPreviousNext" class="alignRight"><?php require('main_' . $view . '_navpreviousnext.inc.php'); ?></td>
</tr></tbody>
</table></div><!-- #TitleAndNavi -->

<!-- Start Body -->
<table width="100%" border="0" cellspacing="0" cellpadding="8">
<tbody><tr>
<td id="CalendarContent"><?php
require('main_' . $view . '_body.inc.php');
?></td>
</tr></tbody>
</table>
<!-- End Body -->

</td><!-- #CalMainCol -->
