<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

// ================================
// Display preview
// ================================

pageheader(lang('preview_event', false), 'Update');

// determine the text representation in the form "MM/DD/YYYY" and the day of the week
$day['text'] = Encode_Date_US($event['timebegin_month'], $event['timebegin_day'], $event['timebegin_year']);
//TODO: Remove instaces of dow_text?
//$day['dow_text'] = Day_of_Week_Abbreviation(Day_of_Week($event['timebegin_month'],
// $event['timebegin_day'], $event['timebegin_year']));
assemble_timestamp($event);
removeslashes($event);

// determine the name of the category
$result = DBQuery("
SELECT
	id,
	name AS category_name
FROM
	" . SCHEMANAME . "vtcal_category
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($event['categoryid']) . "'
");

if ($result->numRows() > 0) { // error checking, actually there should be always a category
	$e = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	$event['category_name'] = $e['category_name'];
}
else {
	$event['category_name'] = '???';
}

contentsection_begin(lang('preview_event'));
?>

<form action="changeeinfo.php" method="post">

<p><input type="submit" name="savethis" value="<?php echo htmlspecialchars(lang('save_changes', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="edit" value="<?php echo htmlspecialchars(lang('go_back_to_make_changes', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" onclick="location.href='<?php echo htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8'); ?>';return false;" /></p>

<h2 class="DateOrTitle"><?php
echo Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'], $event['timebegin_day'],
 $event['timebegin_year'])) . ', ' . Month_to_Text($event['timebegin_month']) . ' ' .
 $event['timebegin_day'] . ', ' . $event['timebegin_year'];
?></h2>

<table border="0" cellspacing="0" cellpadding="0">
<tbody><tr>
<td style="border:1px solid <?php echo $_SESSION['COLOR_BORDER']; ?>;"><?php print_event($event); ?></td>
</tr></tbody>
</table><br />

<?php
if (!checkeventtime($event)) {
	feedbackblock(lang('warning_ending_time_before_starting_time'), FEEDBACKNEG);
}
if ($event['timeend_hour'] == 0) {
	feedbackblock(lang('warning_no_ending_time'), FEEDBACKNEG);
}

if ($repeat['mode'] > 0) {
	echo lang('recurring_event'), ': ';
	$repeatdef = repeatinput2repeatdef($event, $repeat);
	printrecurrence($event['timebegin_year'], $event['timebegin_month'], $event['timebegin_day'], $repeatdef);
	echo '<br />';
	$repeatlist = producerepeatlist($event, $repeat);
	printrecurrencedetails($repeatlist);
}
else {
	//echo lang('no_recurrences_defined');
}

passeventvalues($event, $event['sponsorid'], $repeat); // add the common input fields

echo '
<input type="hidden" name="check" value="1" />
<input type="hidden" name="httpreferer" value="' . htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8') . '" />';
if (isset($eventid)) { echo '
<input type="hidden" name="eventid" value="' . htmlspecialchars($event['id'], ENT_COMPAT, 'UTF-8') . '" />'; }
if (isset($copy)) { echo '
<input type="hidden" name="copy" value="' . htmlspecialchars($copy, ENT_COMPAT, 'UTF-8') . '" />'; }
?>

<p><input type="submit" name="savethis" value="<?php echo htmlspecialchars(lang('save_changes', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="edit" value="<?php echo htmlspecialchars(lang('go_back_to_make_changes', false), ENT_COMPAT, 'UTF-8'); ?>" />
&nbsp;
<input type="submit" name="cancel" value="<?php echo htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8'); ?>" onclick="location.href='<?php echo htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8'); ?>';return false;" /></p>

</form>

<?php
contentsection_end();
?>