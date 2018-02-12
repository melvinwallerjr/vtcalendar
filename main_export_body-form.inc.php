<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

// If you are using 24-hour time, then set the following to true
$twenty_four_hour_time = false;

$sel = ' selected="selected"';
$chk = ' checked="checked"';

if (count($FormErrors) > 0) {
	echo '
<p class="pad"><img src="install/failed32.png" class="png" width="32" height="32" alt="Failed" /> <b>' . lang('export_errorsfound') . '</b></p>' . "\n";
}
?>

<input type="hidden" name="view" value="export" />

<div class="FormSectionHeader">
<h3><?php echo lang('export_settings'); ?>:</h3>
</div>

<div class="pad">

<h4><?php echo lang('export_format'); ?></h4>

<?php
if (isset($FormErrors['format'])) {
	echo '
<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="Failed" /> ' . $FormErrors['format'] . '</p>' . "\n";
}
?>

<fieldset>
<table border="0" cellpadding="2" cellspacing="0">
<tbody><tr>
<td colspan="2"><b><?php echo lang('export_format_standard'); ?>:</b></td>

</tr><tr>

<td><input type="radio" id="format_ical" name="format" value="ical"<?php echo (isset($FormData['format']) && $FormData['format'] == 'ical')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_ical">iCalendar (ICS)</label></td>

</tr><tr>

<td><input type="radio" id="format_rss" name="format" value="rss"<?php echo (isset($FormData['format']) && $FormData['format'] == 'rss')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_rss">RSS 0.91 (XML)</label></td>

</tr><tr>

<td><input type="radio" id="format_rss1_0" name="format" value="rss1_0"<?php echo (isset($FormData['format']) && $FormData['format'] == 'rss1_0')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_rss1_0">RSS 1.0 (XML)</label></td>

</tr><tr>

<td><input type="radio" id="format_rss2_0" name="format" value="rss2_0"<?php echo (isset($FormData['format']) && $FormData['format'] == 'rss2_0')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_rss2_0">RSS 2.0 (XML)</label></td>

</tr><tr>

<td><input type="radio" id="format_vxml" name="format" value="vxml"<?php echo (isset($FormData['format']) && $FormData['format'] == 'vxml')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_vxml">VoiceXML 2.0 (XML)</label></td>

</tr><?php if (PUBLIC_EXPORT_VTCALXML || ISCALADMIN) { ?><tr>

<td colspan="2" style="padding-top:16px;"><b><?php echo lang('export_format_backup'); ?>:</b></td>

</tr><tr>

<td><input type="radio" id="format_xml" name="format" value="xml"<?php echo (isset($FormData['format']) && $FormData['format'] == 'xml')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_xml">VTCalendar (XML)</label><br />
<?php echo lang('export_xml_description'); ?></td>

</tr><?php } ?><tr>

<td colspan="2" style="padding-top:16px;"><b><?php echo lang('export_format_advanced'); ?>:</b></td>

</tr><tr>

<td><input type="radio" id="format_html" name="format" value="html"<?php echo (isset($FormData['format']) && $FormData['format'] == 'html')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_html">HTML</label></td>

</tr><tr>

<td><input type="radio" id="format_js" name="format" value="js"<?php echo (isset($FormData['format']) && $FormData['format'] == 'js')? $chk : ''; ?> onclick="ToggleHTMLSections();" /></td>
<td><label for="format_js">JavaScript Array (e.g. <code>vtcalevents[0]['date']</code>)</label></td>

</tr></tbody>
</table>
</fieldset>

<h4><label for="maxevents"><?php echo lang('export_maxevents'); ?>:</label></h4>

<?php
if (isset($FormErrors['maxevents'])) {
	echo '
<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="Failed" /> ' . $FormErrors['maxevents'] . '</p>' . "\n";
}
?>

<p><?php echo lang('export_maxevents_description'); ?></p>

<p><input type="text" id="maxevents" name="maxevents" size="4" value="<?php if (isset($FormData['maxevents'])) echo $FormData['maxevents']; ?>" />
<?php if (!ISCALADMIN) { echo ' (' . lang('export_maxevents_rangemessage') . ')'; } ?></p>


<h4><?php echo lang('export_dates'); ?>:</h4>

<p><?php echo lang('export_dates_description'); ?></p>

<?php
if (isset($FormErrors['timebegin'])) {
	echo '
<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="Failed" /> ' . $FormErrors['timebegin'] . '</p>' . "\n";
}
if (isset($FormErrors['timeend'])) {
	echo '
<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="Failed" /> ' . $FormErrors['timeend'] . '</p>' . "\n";
}
?>

<fieldset>
<table border="0" cellspacing="0" cellpadding="4">
<tbody><tr>

<td><label for="exporttimebegin"><strong><?php echo lang('export_dates_from'); ?>:</strong></label></td>
<td><input type="text" id="exporttimebegin" name="timebegin" value="<?php if (isset($FormData['timebegin'])) { echo $FormData['timebegin']; } ?>" /></td>

</tr><tr>

<td>&nbsp;</td>
<td><?php echo lang('export_dates_from_description'); ?></td>

</tr><tr>

<td><label for="exporttimeend"><strong><?php echo lang('export_dates_to'); ?>:</strong></label></td>
<td><input type="text" id="exporttimeend" name="timeend" value="<?php if (isset($FormData['timeend'])) { echo $FormData['timeend']; } ?>" /></td>

</tr><tr>

<td>&nbsp;</td>
<td><?php echo lang('export_dates_to_description'); ?></td>

</tr></tbody>
</table>
</fieldset>


<h4><?php echo lang('export_categories'); ?>:</h4>

<p><?php echo lang('export_categories_description'); ?>:</p>

<?php
if (isset($FormErrors['categories'])) {
	echo '
<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="Failed" /> ' . $FormErrors['categories'] . '</p>' . "\n";
}
?>

<p><a href="javascript:checkAll(document.ExportForm,'c',true)"><?php echo lang('select_unselect'); ?></a></p>

<fieldset>
<table border="0" cellspacing="0" cellpadding="1">
<tbody><tr>
<td><?php
// Create a list of category filter keys
if (isset($FormData['categories'])) {
	$selectedCategoryKeys = array_flip($FormData['categories']);
}
// Determine how many categories are in each column.
$percolumn = ceil($numcategories / 2);
if (count($numcategories) == 0) { echo '&nbsp;'; }
else for ($c=0; $c < $numcategories; $c++) {
	$categoryselected = (!isset($FormData['categories']) || count($FormData['categories']) == 0 ||
	 array_key_exists($categories_id[$c], $selectedCategoryKeys))? $chk : '';
	// Go to the next column if we've reached the limit of categories per column.
	if ($c > 0 && $c % $percolumn == 0) { echo '</td><td>'; }
	echo '
<p><input type="checkbox" id="category' . $categories_id[$c] . '" name="c[]" value="' . $categories_id[$c] . '"' . $categoryselected . ' />
<label for="category' . $categories_id[$c] . '">' . htmlspecialchars($categories_name[$c], ENT_COMPAT, 'UTF-8') . '</label>' . ((PUBLIC_EXPORT_VTCALXML || ISCALADMIN)? ' (<code>' . htmlspecialchars($categories_id[$c], ENT_COMPAT, 'UTF-8') . '</code>)' : '') . '</p>' . "\n";
}
?></td>
</tr></tbody>
</table>
</fieldset>

<?php if (PUBLIC_EXPORT_VTCALXML || ISCALADMIN) { ?>
<p><?php echo lang('export_categoryid_note'); ?></p>
<?php } ?>


<h4><?php echo lang('export_sponsor'); ?>:</h4>

<?php
if (isset($FormErrors['sponsor'])) {
	echo '
<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="Failed" /> ' . $FormErrors['sponsor'] . '</p>' . "\n";
}
?>

<fieldset>
<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>

<td><input type="radio" id="sponsor_all" name="sponsor" value="all"<?php echo ($FormData['sponsor'] == "all")? $chk : ''; ?> /></td>
<td><label for="sponsor_all"><?php echo lang('export_sponsor_all'); ?></label></td>

</tr><tr>

<td><input type="radio" id="sponsor_specific" name="sponsor" value="specific"<?php echo ($FormData['sponsor'] == "specific")? $chk : ''; ?> /></td>
<td><label for="specificsponsor"><?php echo lang('export_sponsor_specific'); ?>:</label>
<input name="specificsponsor" type="text" id="specificsponsor" onchange="SpecificSponsorChanged()" onkeyup="SpecificSponsorChanged()" value="<?php if (!empty($FormData['specificsponsor'])) echo htmlspecialchars($FormData['specificsponsor'], ENT_COMPAT, 'UTF-8'); ?>" /><br />
(<?php echo lang('export_sponsor_specific_description'); ?>)</td>

</tr></tbody>
</table>
</fieldset>

<p><input type="submit" name="createexport" value="<?php echo lang('export_submit', false); ?>" />
<span class="HTMLOnly"><?php echo lang('export_keepscrolling'); ?></span></p>

</div><!-- .pad -->


<div class="HTMLOnly">

<div class="FormSectionHeader">
<h3><?php echo lang('export_htmlsettings'); ?>:</h3>
</div>

<div class="pad">

<h4><?php echo lang('export_keepcategoryfilter'); ?>:</h4>

<p><?php echo lang('export_keepcategoryfilter_description'); ?></p>

<fieldset><p>
<input name="keepcategoryfilter" id="keepcategoryfilter_yes" type="radio" value="1"<?php echo (isset($FormData['keepcategoryfilter']) && $FormData['keepcategoryfilter'] == '1')? $chk : ''; ?> />
<label for="keepcategoryfilter_yes"><?php echo lang('yes'); ?></label>
&nbsp; &nbsp;
<input name="keepcategoryfilter" id="keepcategoryfilter_no" type="radio" value="0"<?php echo (isset($FormData['keepcategoryfilter']) && $FormData['keepcategoryfilter'] == '0')? $chk : ''; ?> />
<label for="keepcategoryfilter_no"><?php echo lang('no'); ?></label>
</p></fieldset>


<h4><label for="htmltype"><?php echo lang('export_htmltype'); ?>:</label></h4>

<p><?php echo lang('export_htmltype_description'); ?></p>

<p><select id="htmltype" name="htmltype">
<option value="paragraph" <?php echo (isset($FormData['htmltype']) && $FormData['htmltype'] == 'paragraph')? $sel : ''; ?>><?php echo lang('export_htmltype_paragraph', false); ?></option>
<option value="table" <?php echo (isset($FormData['htmltype']) && $FormData['htmltype'] == 'table')? $sel : ''; ?>><?php echo lang('export_htmltype_table', false); ?></option>
</select></p>


<h4><?php echo lang('export_jsoutput'); ?>:</h4>

<p><?php echo lang('export_jsoutput_description'); ?></p>

<fieldset><p>
<input type="radio" id="jshtml_yes" name="jshtml" value="1"<?php echo (isset($FormData['jshtml']) && $FormData['jshtml'] == '1')? $chk : ''; ?> />
<label for="jshtml_yes"><?php echo lang('yes'); ?></label>
&nbsp; &nbsp;
<input type="radio" id="jshtml_no" name="jshtml" value="0"<?php echo (isset($FormData['jshtml']) && $FormData['jshtml'] == '0')? $chk : ''; ?> />
<label for="jshtml_no"><?php echo lang('no'); ?></label>
</p></fieldset>

</div><!-- .pad -->


<div class="FormSectionHeader">
<h3><?php echo lang('export_datetimesettings'); ?>:</h3>
</div>

<div class="pad">

<h4><label for="dateformat"><?php echo lang('export_dateformat'); ?>:</label></h4>

<select id="dateformat" name="dateformat">
<option value="huge" <?php echo (isset($FormData['dateformat']) && $FormData['dateformat'] == 'huge')? $sel : ''; ?>><?php echo lang('wednesday', false); ?>, <?php echo lang('october', false); ?> 25, 2006</option>
<option value="long" <?php echo (isset($FormData['dateformat']) && $FormData['dateformat'] == 'long')? $sel : ''; ?>><?php echo lang('wed', false); ?>, <?php echo lang('october', false); ?> 25, 2006</option>
<option value="normal" <?php echo (isset($FormData['dateformat']) && $FormData['dateformat'] == 'normal')? $sel : ''; ?>><?php echo lang('october', false); ?> 25, 2006</option>
<option value="short" <?php echo (isset($FormData['dateformat']) && $FormData['dateformat'] == 'short')? $sel : ''; ?>><?php echo lang('oct', false); ?>. 25, 2006</option>
<option value="tiny" <?php echo (isset($FormData['dateformat']) && $FormData['dateformat'] == 'tiny')? $sel : ''; ?>><?php echo lang('oct', false); ?> 25 '06</option>
<option value="micro" <?php echo (isset($FormData['dateformat']) && $FormData['dateformat'] == 'micro')? $sel : ''; ?>><?php echo lang('oct', false); ?> 25</option>
</select>


<h4><?php echo lang('export_timedisplay'); ?>:</h4>

<p><?php echo lang('export_timedisplay_description'); ?></p>

<fieldset>
<table border="0" cellspacing="1" cellpadding="4">
<thead><tr class="TableHeaderBG">
<th><?php echo lang('export_timedisplay_startonly'); ?>:</th>
<th><?php echo lang('export_timedisplay_startend'); ?>:</th>
<th><?php echo lang('export_timedisplay_startduration'); ?>:</th>
</tr></thead>
<tbody><tr class="even">
<td>
<p><input type="radio" id="timedisplay_Start"  name="timedisplay" value="start"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'start')? $chk : ''; ?> />
<label for="timedisplay_Start">12:00pm</label></p>
</td><td>
<p><input type="radio" id="timedisplay_StartEndLong" name="timedisplay" value="startendlong"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startendlong')? $chk : ''; ?> />
<label for="timedisplay_StartEndLong">12:00pm <?php echo lang('export_output_to'); ?> 12:30pm</label></p>
<p><input type="radio" id="timedisplay_StartEndNormal" name="timedisplay" value="startendnormal"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startendnormal')? $chk : ''; ?> />
<label for="timedisplay_StartEndNormal">12:00pm - 12:30pm</label></p>
<p><input type="radio" id="timedisplay_StartEndTiny" name="timedisplay" value="startendtiny"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startendtiny')? $chk : ''; ?> />
<label for="timedisplay_StartEndTiny">12:00pm-12:30pm</label></p>
</td><td>
<p><input type="radio" id="timedisplay_StartDurationLong" name="timedisplay" value="startdurationlong"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startdurationlong')? $chk : ''; ?> />
<label for="timedisplay_StartDurationLong">12:00pm <?php echo lang('export_output_for'); ?> 2 <?php echo lang('export_output_hours'); ?></label></p>
<p><input type="radio" id="timedisplay_StartDurationNormal" name="timedisplay" value="startdurationnormal"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startdurationnormal')? $chk : ''; ?> />
<label for="timedisplay_StartDurationNormal">12:00pm (2 <?php echo lang('export_output_hours'); ?>)</label></p>
<p><input type="radio" id="timedisplay_StartDurationShort" name="timedisplay" value="startdurationshort"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startdurationshort')? $chk : ''; ?> />
<label for="timedisplay_StartDurationShort">12:00pm 2 <?php echo lang('export_output_hours'); ?></label></p>
</td>
</tr></tbody>
</table>
</fieldset>

<?php if ($twenty_four_hour_time) { ?>
<select name="timedisplay">
<option value="start"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'start')? $sel : ''; ?>>12:00pm</option>
<option value="startendlong"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startendlong')? $sel : ''; ?>>12:00pm to 12:30pm</option>
<option value="startendnormal"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startendnormal')? $sel : ''; ?>>12:00pm - 12:30pm</option>
<option value="startendtiny"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startendtiny')? $sel : ''; ?>>12:00pm-12:30pm</option>
<option value="startdurationlong"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startdurationlong')? $sel : ''; ?>>12:00pm for 2 <?php echo lang('export_output_hours', false); ?></option>
<option value="startdurationnormal"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startdurationnormal')? $sel : ''; ?>>12:00pm (2 <?php echo lang('export_output_hours', false); ?>)</option>
<option value="startdurationshort"<?php echo (isset($FormData['timedisplay']) && $FormData['timedisplay'] == 'startdurationshort')? $sel : ''; ?>>12:00pm 2 <?php echo lang('export_output_hours', false); ?></option>
</select>
<?php } ?>


<h4><label for="timeformat"><?php echo lang('export_timeformat'); ?>:</label></h4>

<p><?php echo lang('export_timeformat_description'); ?></p>

<select id="timeformat" name="timeformat">
<option value="huge"<?php echo (isset($FormData['timeformat']) && $FormData['timeformat'] == 'huge')? $sel : ''; ?>>12:00 PM EST</option>
<option value="long"<?php echo (isset($FormData['timeformat']) && $FormData['timeformat'] == 'long')? $sel : ''; ?>>12:00 PM</option>
<option value="normal"<?php echo (isset($FormData['timeformat']) && $FormData['timeformat'] == 'normal')? $sel : ''; ?>>12:00pm</option>
<option value="short"<?php echo (isset($FormData['timeformat']) && $FormData['timeformat'] == 'short')? $sel : ''; ?>>12:00p</option>
</select>

<?php if ($twenty_four_hour_time) { ?>
<select name="timeformat">
<option value="long"<?php echo (isset($FormData['timeformat']) && $FormData['timeformat'] == 'long')? $sel : ''; ?>>23:59 EST</option>
<option value="normal"<?php echo (isset($FormData['timeformat']) && $FormData['timeformat'] == 'normal')? $sel : ''; ?>>23:59</option>
</select>
<?php } ?>


<h4><label for="durationformat"><?php echo lang('export_durationformat'); ?>:</label></h4>

<select id="durationformat" name="durationformat">
<option value="long"<?php echo (isset($FormData['durationformat']) && $FormData['durationformat'] == 'long')? $sel : ''; ?>>2 <?php echo lang('export_output_hours', false); ?> 30 <?php echo lang('export_output_minutes', false); ?></option>
<option value="normal"<?php echo (isset($FormData['durationformat']) && $FormData['durationformat'] == 'normal')? $sel : ''; ?>>2 <?php echo lang('export_output_hours', false); ?> 30 <?php echo lang('export_output_min', false); ?></option>
<option value="short"<?php echo (isset($FormData['durationformat']) && $FormData['durationformat'] == 'short')? $sel : ''; ?>>2 <?php echo lang('export_output_hrs', false); ?> 30 <?php echo lang('export_output_min', false); ?></option>
<option value="tiny"<?php echo (isset($FormData['durationformat']) && $FormData['durationformat'] == 'tiny')? $sel : ''; ?>>2<?php echo lang('export_output_hrs', false); ?> 30<?php echo lang('export_output_min', false); ?></option>
<option value="micro"<?php echo (isset($FormData['durationformat']) && $FormData['durationformat'] == 'micro')? $sel : ''; ?>>2<?php echo lang('export_output_hr', false); ?> 30<?php echo lang('export_output_m', false); ?></option>
</select>

</div><!-- .pad -->


<div class="FormSectionHeader">
<h3><?php echo lang('export_htmldisplaysettings'); ?>:</h3>
</div>

<div class="pad">

<h4><?php echo lang('export_showdatetime'); ?>:</h4>

<p><?php echo lang('export_showdatetime_description'); ?></p>

<fieldset><p>
<input name="showdatetime" id="showdatetime_yes" type="radio" value="1"<?php echo (isset($FormData['showdatetime']) && $FormData['showdatetime'] == '1')? $chk : ''; ?> />
<label for="showdatetime_yes"><?php echo lang('export_show'); ?></label>
&nbsp; &nbsp;
<input name="showdatetime" id="showdatetime_no" type="radio" value="0"<?php echo (isset($FormData['showdatetime']) && $FormData['showdatetime'] == '0')? $chk : ''; ?> />
<label for="showdatetime_no"><?php echo lang('export_hide'); ?></label>
</p></fieldset>


<h4><?php echo lang('export_showlocation'); ?>: </h4>

<p><?php echo lang('export_showlocation_description'); ?></p>

<fieldset><p>
<input name="showlocation" id="showlocation_yes" type="radio" value="1"<?php echo (isset($FormData['showlocation']) && $FormData['showlocation'] == '1')? $chk : ''; ?> />
<label for="showlocation_yes"><?php echo lang('export_show'); ?></label>
&nbsp; &nbsp;
<input name="showlocation" id="showlocation_no" type="radio" value="0"<?php echo (isset($FormData['showlocation']) && $FormData['showlocation'] == '0')? $chk : ''; ?> />
<label for="showlocation_no"><?php echo lang('export_hide'); ?></label>
</p></fieldset>


<h4><?php echo lang('export_showwebmap'); ?>: </h4>

<p><?php echo lang('export_showwebmap_description'); ?></p>

<fieldset><p>
<input name="showwebmap" id="showwebmap_yes" type="radio" value="1"<?php echo (isset($FormData['showwebmap']) && $FormData['showwebmap'] == '1')? $chk : ''; ?> />
<label for="showwebmap_yes"><?php echo lang('export_show'); ?></label>
&nbsp; &nbsp;
<input name="showwebmap" id="showwebmap_no" type="radio" value="0"<?php echo (isset($FormData['showwebmap']) && $FormData['showwebmap'] == '0')? $chk : ''; ?> />
<label for="showwebmap_no"><?php echo lang('export_hide'); ?></label>
</p></fieldset>


<h4><?php echo lang('export_showallday'); ?>:</h4>

<p><?php echo lang('export_showallday_description'); ?></p>

<fieldset><p>
<input name="showallday" id="showallday_yes" type="radio" value="1"<?php echo (isset($FormData['showallday']) && $FormData['showallday'] == '1')? $chk : ''; ?> />
<label for="showallday_yes"><?php echo lang('export_show'); ?></label>
&nbsp; &nbsp;
<input name="showallday" id="showallday_no" type="radio" value="0"<?php echo (isset($FormData['showallday']) && $FormData['showallday'] == '0')? $chk : ''; ?> />
<label for="showallday_no"><?php echo lang('export_hide'); ?></label>
</p></fieldset>


<h4><label for="maxtitlecharacters"><?php echo lang('export_maxtitlechars'); ?>:</label></h4>

<?php if (isset($FormErrors['maxtitlecharacters'])) echo '<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="" /> ' . $FormErrors['maxtitlecharacters'] . '</p>'; ?>

<p><?php echo lang('export_maxtitlechars_description'); ?></p>

<p><input type="text" id="maxtitlecharacters" name="maxtitlecharacters" value="" size="4" /> (<?php echo lang('export_leaveblank'); ?>)</p>


<h4><label for="maxlocationcharacters"><?php echo lang('export_maxlocationchars'); ?>:</label></h4>

<?php if (isset($FormErrors['maxlocationcharacters'])) echo '<p class="FormError"><img src="install/failed.png" class="png" width="16" height="16" alt="" /> ' . $FormErrors['maxlocationcharacters'] . '</p>'; ?>

<p><?php echo lang('export_maxlocationchars_description'); ?></p>

<p><input type="text" id="maxlocationcharacters" name="maxlocationcharacters" value="" size="4" /> (<?php echo lang('export_leaveblank'); ?>)</p>

<p><input type="submit" name="createexport" value="<?php echo lang('export_submit', false); ?>" /><?php echo lang('export_resetform'); ?></p>

</div><!-- .pad -->

</div><!-- .HTMLOnly -->

<script type="text/javascript">/* <![CDATA[ */
function ToggleHTMLSections()
{
	if (document.getElementById) {
		var oForm = document.getElementById("ExportForm");
		var oHTML = document.getElementById("format_html");
		if (oForm && oHTML) {
			if (oHTML.checked) { oForm.className = ""; }
			else { oForm.className = "HideHTML"; }
		}
	}
}

function SpecificSponsorChanged()
{
	if (document.getElementById) {
		var oAll = document.getElementById("sponsor_all");
		var oSpecific = document.getElementById("sponsor_specific");
		var oText = document.getElementById("specificsponsor");
		if (oText.value.replace(/^\s+|\s+$/g, "") == "") { oAll.checked = true; }
		else { oSpecific.checked = true; }
	}
}
ToggleHTMLSections();
SpecificSponsorChanged();
/* ]]> */</script>
