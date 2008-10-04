<?php
if (!defined("ALLOWINCLUDES")) { exit; }

// determine today's date
$today = Decode_Date_US(date("m/d/Y", NOW));

// check if some input params are set, and if not set them to default
if (!isset($timebegin_year)) $timebegin_year = $today['year'];
if (!isset($timebegin_month)) $timebegin_month = $today['month'];
if (!isset($timebegin_day)) $timebegin_day = $today['day'];

if (!isset($timeend_year)) $timeend_year = $timebegin_year;
if (!isset($timeend_month)) {
	$timeend_month = $timebegin_month+6;
	if ($timeend_month >= 13) {
		$timeend_month = $timeend_month-12;
		$timeend_year++;
	}
}
if (!isset($timeend_day)) {
	$timeend_day = $timebegin_day;
	while (!checkdate($timeend_month,$timeend_day,$timeend_year)) { $timeend_day--; };
}

pageheader(lang('export_events'), "");
contentsection_begin(lang('export_events'));

?>
<p><a target="newWindow" onclick="new_window(this.href); return false" 
	 href="helpexport.php"><img src="images/help.gif" width="16" height="16" alt="" border="0"> 
	 <?php echo lang('how_to_export_events'); ?></a></p>

<form method="get" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<table border="0" cellspacing="0" cellpadding="6">
	<tr>
		<td class="bodytext" valign="top">
			<strong><?php echo lang('output_format'); ?></strong>&nbsp;
		</td>
		<td><select name="type">
				<option value="xml">XML/VT Calendar</option>
				<option value="ical">iCalendar</option>
				<option value="rss">XML/RSS 0.91</option>
				<option value="rss1_0">XML/RSS 1.0</option>
				<option value="vxml">VoiceXML 2.0</option>
			</select></td>
	</tr>
	<tr>
		<td class="bodytext" valign="top">
			<strong><?php echo lang('category'); ?>:</strong>
		</td>
		<td class="bodytext" valign="top">
				<?php
				$result =& DBQuery("SELECT * FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION['CALENDAR_ID'])."'" ); 
				
				if (is_string($result)) {
					// TODO: Need DB failed message.
				}
				else {
					echo '<select name="categoryid" size="1">';
					
					// print list with categories from the DB
					echo "<option ";
					if (empty($categoryid) || $categoryid==0) {
						echo "selected ";
					}
					echo "value=\"0\">all</option>\n";
					
					for ($i=0; $i<$result->numRows(); $i++) {
						$category = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
						echo "<option ";
						if (!empty($categoryid) && $categoryid==$category['id']) { echo "selected "; }
						echo "value=\"",htmlentities($category['id']),"\">",htmlentities($category['name']),"</option>\n";
					}
					
					echo '</select>';
				}
				?></td>
	</tr>
	<tr>
		<td class="bodytext" valign="top">
			<strong><?php echo lang('sponsor'); ?>:</strong>
		</td>
		<td class="bodytext" valign="top">
			<input type="radio" name="sponsortype" value="all" checked> <?php echo lang('all'); ?><br>
<?php
	if (!empty($_SESSION["AUTH_SPONSORID"])) {
		echo '<input type="radio" name="sponsortype" value="self"> ',$_SESSION["AUTH_SPONSORNAME"],"<br>\n";
	}
?>
				<input type="radio" name="sponsortype" value="specific"> <?php echo lang('specific_sponsor'); ?>:
				
				<?php
				// TODO: Is having a drop-down list or a %x% search better?
				//$result =& DBQuery("SELECT count(*) as sponsorcount, displayedsponsor FROM vtcal_event_public WHERE calendarid='". sqlescape($_SESSION['CALENDAR_ID']) ."' GROUP BY displayedsponsor ORDER BY displayedsponsor");
				$result = "disabled";
				
				if (is_string($result)) {
					?><input type="text" size="28" maxlength="<?php echo constSpecificsponsorMaxLength; ?>" name="specificsponsor" value=""><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i><?php echo lang('specific_sponsor_example'); ?></i><?php
				}
				else {
					echo '<select name="specificsponsor" id="specificsponsor">';
					
					for ($i=0; $i<$result->numRows(); $i++) {
						$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
						if ($sponsor['displayedsponsor'] == "") {
							echo '<option value="">&lt;&lt;Events with no sponsor. Records: '. htmlentities($sponsor['sponsorcount']) .'&gt;&gt;</option>';
						}
						else {
							echo '<option value="'. htmlentities($sponsor['displayedsponsor']) .'">'. htmlentities($sponsor['displayedsponsor']) .' (Records: '. htmlentities($sponsor['sponsorcount']) .')</option>';
						}
					}
					
					echo '</select>';
				}
				?>
			</td>
	</tr>
	<tr>
		<td class="bodytext" valign="top">
			<strong><?php echo lang('date'); ?>:</strong>
		</td>
		<td class="bodytext" valign="top">
			<table border="0">
				<tr>
					<td class="bodytext" valign="top"><?php echo lang('from'); ?>:</td>
					<td class="bodytext" valign="top">
						<select name="timebegin_month" size="1">
<?php
// print list with months
for ($i=1; $i<=12; $i++) {
	print '<option ';
	if ($timebegin_month==$i) { echo "selected "; }
	echo "value=\"$i\">",Month_to_Text($i),"</option>\n";
}
?>
					</select>
				</td>
				<td class="bodytext" valign="top">
					<select name="timebegin_day" size="1">
<?php
// print list with days
for ($i=1; $i<=31; $i++) {
	echo "<option ";
	if ($timebegin_day==$i) { echo "selected "; }
	echo "value=\"$i\">$i</option>\n";
}
?>
				</select>
			</td>
			<td class="bodytext" valign="top">
				<select name="timebegin_year" size="1">
<?php
// print list with years
for ($i=date("Y", NOW)-1; $i<=date("Y", NOW)+3; $i++) {
	echo "<option ";
	if ($timebegin_year==$i) { echo "selected "; }
	echo "value=\"$i\">$i</option>\n";
}
?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="bodytext" valign="top"><?php echo lang('to'); ?>:</td>
			<td class="bodytext" valign="top">
				<select name="timeend_month" size="1">
<?php
// print list with months
for ($i=1; $i<=12; $i++) {
	print '<option ';
	if ($timeend_month==$i) { echo "selected "; }
	echo "value=\"$i\">",Month_to_Text($i),"</option>\n";
}
?>
				</select>
			</td>
			<td>
				<select name="timeend_day" size="1">
<?php
// print list with days
for ($i=1; $i<=31; $i++) {
	echo "<option ";
	if ($timeend_day==$i) { echo "selected "; }
	echo "value=\"$i\">$i</option>\n";
}
?>
				</select>
			</td>
			<td class="bodytext" valign="top">
				<select name="timeend_year" size="1">
<?php
// print list with years
for ($i=date("Y", NOW)-1; $i<=date("Y", NOW)+3; $i++) {
	echo "<option ";
	if ($timeend_year==$i) { echo "selected "; }
	echo "value=\"$i\">$i</option>\n";
}
?>
				</select>
			</td>
		</tr>
	</table>
</table>

<p><?php echo lang('export_message'); ?></p>

<p><input type="submit" name="startexport" value="<?php echo lang('ok_button_text'); ?>">
<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>"></p>
</form>

<?php    
contentsection_end();
pagefooter();
?>