<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

// ================================
// Display preview
// ================================

pageheader(lang('preview_event'), "Update");

// determine the text representation in the form "MM/DD/YYYY" and the day of the week
$day['text'] = Encode_Date_US($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']);
$day['dow_text'] = Day_of_Week_Abbreviation(Day_of_Week($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year']));
assemble_timestamp($event);
$event['color'] = datetocolor($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year'],$colorpast,$colortoday,$colorfuture);
removeslashes($event);

// determine the name of the category
$result = DBQuery("SELECT id,name AS category_name FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."' AND id='".sqlescape($event['categoryid'])."'" ); 

if ($result->numRows() > 0) { // error checking, actually there should be always a category
	$e = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	$event['category_name']=$e['category_name'];
}
else {
	$event['category_name']="???";
}

contentsection_begin(lang('preview_event'));

?>
<form method="post" action="changeeinfo.php">
<p><input type="submit" name="savethis" value="<?php echo lang('save_changes'); ?>">
<?php
/*
		if ($repeat['mode'] > 0 && !empty($event['repeatid'])) {
			if (!recurrenceschanged($event['repeatid'],$repeat,$event)) {
				echo '<input type="submit" name="saveall" value="Save changes for ALL recurrences"><BR><BR>';
			}
		}
*/
?>
<input type="submit" name="edit" value="<?php echo lang('go_back_to_make_changes'); ?>"> &nbsp;&nbsp;&nbsp;
<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" onclick="location.href = '<?php echo $httpreferer; ?>'; return false;"></p>
<p style="font-size: 18px; font-weight: bold; padding-bottom: 6px; margin-bottom: 0;"><?php
  echo Day_of_Week_to_Text(Day_of_Week($event['timebegin_month'],$event['timebegin_day'],$event['timebegin_year'])),", ";
  echo Month_to_Text($event['timebegin_month'])," ",$event['timebegin_day'],", ",$event['timebegin_year'];
?></p>

<table border="0" cellpadding="0" cellspacing="0"><tr><td style="border: 1px solid #666666;"><?php
print_event($event);
?></td></tr></table>

<BR>
<?php
if (!checkeventtime($event)) {
	echo "<BR>";
	feedback(lang('warning_ending_time_before_starting_time'),1);
}
if ($event['timeend_hour']==0) {
	echo "<BR>";
	feedback(lang('warning_no_ending_time'),1);
}

echo '<span class="bodytext">';
if ($repeat['mode'] > 0) {
	echo lang('recurring_event'),": ";
	$repeatdef = repeatinput2repeatdef($event,$repeat);
	printrecurrence($event['timebegin_year'],
									$event['timebegin_month'],
									$event['timebegin_day'],
									$repeatdef);
	echo "<BR>";
	$repeatlist = producerepeatlist($event,$repeat);
	printrecurrencedetails($repeatlist);
}
else {
	//echo lang('no_recurrences_defined');
}

if (isset($detailscaller)) { echo "<INPUT type=\"hidden\" name=\"detailscaller\" value=\"",$detailscaller,"\">\n"; }
passeventvalues($event,$event['sponsorid'],$repeat); // add the common input fields

?><INPUT type="hidden" name="check" value="1"><?php

echo '<INPUT type="hidden" name="httpreferer" value="',$httpreferer,'">',"\n";
if (isset($eventid)) { echo "<INPUT type=\"hidden\" name=\"eventid\" value=\"",$event['id'],"\">\n"; }
if (isset($copy)) { echo "<INPUT type=\"hidden\" name=\"copy\" value=\"",$copy,"\">\n"; }
?>
<p><input type="submit" name="savethis" value="<?php echo lang('save_changes'); ?>">
<input type="submit" name="edit" value="<?php echo lang('go_back_to_make_changes'); ?>"> &nbsp;&nbsp;&nbsp;
<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" onclick="location.href = '<?php echo $httpreferer; ?>'; return false;"></p>
</span>
</form>
<?php
contentsection_end();
?>