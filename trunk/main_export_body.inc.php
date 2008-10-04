<div style="padding: 10px; padding-bottom: 0;"><?php echo lang('export_description'); ?></div>

<form id="ExportForm" name="ExportForm" method="get" action="main.php" class="HideHTML">

<input type="hidden" name="view" value="export">

<script language="JavaScript" type="text/javascript"><!-- //<![CDATA[
function checkAll(myForm, id, state) {
	// determine if ALL of the checkboxes is checked
	b = new Boolean( true );
	for (var cnt=0; cnt < myForm.elements.length; cnt++) {
		var ckb = myForm.elements[cnt];
		if (ckb.type == "checkbox" && ckb.name.indexOf(id) == 0) {
			if (ckb.checked == false) { b = false; }
		}
	}

	for (var cnt=0; cnt < myForm.elements.length; cnt++) {
		var ckb = myForm.elements[cnt];
		if (ckb.type == "checkbox" && ckb.name.indexOf(id) == 0) {
			if ( b == true ) { ckb.checked = false; }
			else { ckb.checked = true; };
		}
	}
}

function ToggleHTMLSections() {
	if (document.getElementById) {
		var oForm = document.getElementById("ExportForm");
		var oHTML = document.getElementById("format_html");
		if (oForm && oHTML) {
			if (oHTML.checked) {
				oForm.className = "";
			}
			else {
				oForm.className = "HideHTML";
			}
		}
	}
}
//]]> -->
</script>

<div class="FormSectionHeader"><h3><?php echo lang('export_settings'); ?>:</h3></div>

<div style="padding-left: 10px;">
	<p><b><?php echo lang('export_format'); ?></b></p>
	
	<blockquote>
		<table  border="0" cellpadding="2" cellspacing="0">
	    	<tr>
	    		<td colspan="2"><b><?php echo lang('export_format_standard'); ?>:</b></td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="xml" id="format_xml" onclick="ToggleHTMLSections();" <?php if (isset($Form_format) && $Form_format == "xml") echo "CHECKED"; ?>></td>
	    		<td><label for="format_xml">VTCalendar (XML) </td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="rss" id="format_rss" onclick="ToggleHTMLSections();" <?php if (isset($Form_format) && $Form_format == "rss") echo "CHECKED"; ?>></td>
	    		<td><label for="format_rss">RSS 0.91 (XML) </td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="rss1_0" id="format_rss1_0" onclick="ToggleHTMLSections();" <?php if (isset($Form_format) && $Form_format == "rss1_0") echo "CHECKED"; ?>></td>
	    		<td><label for="format_rss1_0">RSS 1.0 (XML) </td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="vxml" id="format_vxml" onclick="ToggleHTMLSections();" <?php if (isset($Form_format) && $Form_format == "vxml") echo "CHECKED"; ?>></td>
	    		<td><label for="format_vxml">VoiceXML 2.0 (XML) </td>
	   		</tr>
	    	<tr>
	    		<td colspan="2" style="padding-top: 16px;"><b><?php echo lang('export_format_advanced'); ?>:</b></td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="html" id="format_html" onclick="ToggleHTMLSections();" <?php if (isset($Form_format) && $Form_format == "html") echo "CHECKED"; ?>></td>
	    		<td><label for="format_html">HTML</label></td>
	    	</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="js" id="format_js" onclick="ToggleHTMLSections();" <?php if (isset($Form_format) && $Form_format == "js") echo "CHECKED"; ?>></td>
		   		<td><label for="format_js">JavaScript Array (e.g. <code>vtcalevents[0]['date']</code>)</td>
	    	</tr>
	    </table>
	</blockquote>
	
	<p><b><?php echo lang('export_maxevents'); ?>: </b></p>
	
	<blockquote>
		<p><?php echo lang('export_maxevents_description'); ?></p>
		<p><input name="maxevents" type="text" id="maxevents" value="<?php if (isset($Form_maxevents)) echo $Form_maxevents; ?>">
			 (<?php echo lang('export_leaveblank'); ?>)</p>
	</blockquote>
	
	<p><b><?php echo lang('export_dates'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_dates_description'); ?></p>
		<table  border="0" cellspacing="0" cellpadding="4">
	    	<tr>
	    		<td style="padding-bottom: 2px;"><b><?php echo lang('export_dates_from'); ?>:</b></td>
	    		<td style="padding-bottom: 2px;"><input name="timebegin" type="text" id="timebegin" value="<?php if (isset($Form_timebegin)) echo $Form_timebegin; ?>"></td>
	    	</tr>
	    	<tr>
	    		<td style="padding-top: 0;">&nbsp;</td>
	    		<td style="padding-top: 0;"><?php echo lang('export_dates_from_description'); ?></td>
	    	</tr>
	    	<tr>
	    		<td style="padding-bottom: 2px;"><b><?php echo lang('export_dates_to'); ?>:</b></td>
	    		<td style="padding-bottom: 2px"><input name="timeend" type="text" id="timeend" value="<?php if (isset($Form_timeend)) echo $Form_timeend; ?>"></td>
	    	</tr>
	    	<tr>
	    		<td style="padding-top: 0;">&nbsp;</td>
	    		<td style="padding-top: 0;"><?php echo lang('export_dates_to_description'); ?></td>
	    	</tr>
	   	</table>
	</blockquote>
	
	<p><b><?php echo lang('export_categories'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_categories_description'); ?>:</p>
		<p><a href="javascript:checkAll(document.ExportForm,'categories',true);"><?php echo lang('select_unselect'); ?></a></p>
		<table border="0" cellspacing="0" cellpadding="4"><tr><td valign="top">
		<table border="0" cellspacing="0" cellpadding="1">
		<?php
		
		// Create a list of category filter keys
		if (isset($Form_categories)) {
			$selectedCategoryKeys = array_flip($Form_categories);
		}
		
		// Determine how many categories are in each column.
		$percolumn = ceil($numcategories / 3);
		
		for ($c=0; $c<$numcategories; $c++) {
			$categoryselected = !isset($Form_categories) || count($Form_categories) == 0 || array_key_exists($categories_id[$c], $selectedCategoryKeys);
			
			// Go to the next column if we've reached the limit of categories per column.
			if ($c > 0 && $c % $percolumn == 0) {
				echo '</table></td><td valign="top"><table border="0" cellspacing="0" cellpadding="1">';
			}
			
			?>
	    	<tr>
	    		<td><input type="checkbox" name="categories[]" value="<?php echo $categories_id[$c]; ?>" id="category<?php echo $categories_id[$c]; ?>" <?php if ($categoryselected) echo "CHECKED"; ?>></td>
	    		<td><label for="category<?php echo $categories_id[$c]; ?>"><?php echo htmlentities($categories_name[$c]); ?></label></td>
	    	</tr>
	    	<?php
		}
		?>
		</table>
		</td></tr></table>
	</blockquote>
	
	<p><b><?php echo lang('export_sponsor'); ?>:</b></p>
	
	<blockquote>
		<table border="0" cellspacing="0" cellpadding="4">
	    	<tr>
	    		<td><input name="sponsor" type="radio" value="all" <?php if ($Form_sponsor == "all") echo "CHECKED"; ?>></td>
	    		<td><?php echo lang('export_sponsor_all'); ?></td>
	    	</tr>
	    	<tr>
	    		<td valign="top"><input name="sponsor" type="radio" value="specific" <?php if ($Form_sponsor == "specific") echo "CHECKED"; ?>></td>
	    		<td><?php echo lang('export_sponsor_specific'); ?>: 
	    			<input name="specificsponsor" type="text" id="specificsponsor" value=" <?php if (!empty($Form_specificsponsor)) echo htmlentities($Form_specificsponsor); ?>"><br>
	    			(<?php echo lang('export_sponsor_specific_description'); ?>)</td>
	   		</tr>
	   	</table>
	</blockquote>

	<p><input type="Submit" name="createexport" value="<?php echo lang('export_submit'); ?>">
		<span class="HTMLOnly"><?php echo lang('export_keepscrolling'); ?></span></p>
</div>

<div class="HTMLOnly">

<div class="FormSectionHeader"><h3><?php echo lang('export_htmlsettings'); ?>:</h3></div>

<div style="padding-left: 10px;">
	<p><b><?php echo lang('export_keepcategoryfilter'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_keepcategoryfilter_description'); ?></p>
		<p><input name="keepcategoryfilter" type="checkbox" id="keepcategoryfilter" value="1" <?php if (isset($Form_keepcategoryfilter)) echo "checked"; ?>><label for="keepcategoryfilter"> <?php echo lang('yes'); ?></label></p>
	</blockquote>
	
	<p><b><?php echo lang('export_htmltype'); ?>:</b></p>
	
	<blockquote>
	    	<p><?php echo lang('export_htmltype_description'); ?></p>
	    	<p><select name="htmltype" id="htmltype">
	    			<option <?php if (isset($Form_htmltype) && $Form_htmltype == 'paragraph') echo "selected"; ?>><?php echo lang('export_htmltype_paragraph'); ?></option>
		    		<option <?php if (isset($Form_htmltype) && $Form_htmltype == 'table') echo "selected"; ?>><?php echo lang('export_htmltype_table'); ?></option>
				</select></p>
	</blockquote>
	
	<p><b><?php echo lang('export_jsoutput'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_jsoutput_description'); ?></p>
	    <table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="jshtml" type="checkbox" id="jshtml" value="1" <?php if (isset($Form_jshtml)) echo "checked"; ?>></td>
				<td><label for="jshtml"><?php echo lang('yes'); ?></label></td>
			</tr>
		</table>
	</blockquote>
</div>

<div class="FormSectionHeader"><h3><?php echo lang('export_datetimesettings'); ?>:</h3></div>

<div style="padding-left: 10px;">
	<p><b><?php echo lang('export_dateformat'); ?>:</b></p>
	<blockquote>
		<select name="dateformat">
			<option value="huge" <?php if (isset($Form_dateformat) && $Form_dateformat == 'huge') echo "selected"; ?>><?php echo lang('wednesday'); ?>, <?php echo lang('october'); ?> 25, 2006</option>
			<option value="long" <?php if (isset($Form_dateformat) && $Form_dateformat == 'long') echo "selected"; ?>><?php echo lang('wed'); ?>, <?php echo lang('october'); ?> 25, 2006</option>
			<option value="normal" <?php if (isset($Form_dateformat) && $Form_dateformat == 'normal') echo "selected"; ?>><?php echo lang('october'); ?> 25, 2006</option>
			<option value="short" <?php if (isset($Form_dateformat) && $Form_dateformat == 'short') echo "selected"; ?>><?php echo lang('oct'); ?>. 25, 2006</option>
			<option value="tiny" <?php if (isset($Form_dateformat) && $Form_dateformat == 'tiny') echo "selected"; ?>><?php echo lang('oct'); ?> 25 '06</option>
			<option value="micro" <?php if (isset($Form_dateformat) && $Form_dateformat == 'micro') echo "selected"; ?>><?php echo lang('oct'); ?> 25</option>
		</select>
	</blockquote>
	
	<p><b><?php echo lang('export_timedisplay'); ?>:</b></p>
	<blockquote>
		<p><?php echo lang('export_timedisplay_description'); ?></p>
		<table border="0" cellpadding="4" cellspacing="0">
			<tr>
				<td style="border-bottom: 1px solid #999999; padding-right: 8px;"><b><?php echo lang('export_timedisplay_startonly'); ?>:</b></td>
				<td style="border-bottom: 1px solid #999999; padding-left: 8px; border-left: 1px solid #666666;"><b><?php echo lang('export_timedisplay_startend'); ?>:</b></td>
				<td style="border-bottom: 1px solid #999999; padding-left: 8px; border-left: 1px solid #666666;"><b><?php echo lang('export_timedisplay_startduration'); ?>:</b></td>
			</tr>
			<tr>
				<td style="padding-right: 8px;" valign="top">
					<table border="0" cellpadding="0" cellspacing="2">
						<tr><td><input type="radio" id="timedisplay_Start"  name="timedisplay" value="start"></td><td><label for="timedisplay_Start">12:00pm</label></td></tr>
					</table>
				</td>
				<td style="padding-left: 8px; border-left: 1px solid #666666;" valign="top">
					<table border="0" cellpadding="0" cellspacing="2">
						<tr>
							<td><input type="radio" id="timedisplay_StartEndLong" name="timedisplay" value="startendlong"></td>
							<td><label for="timedisplay_StartEndLong">12:00pm <?php echo lang('export_output_to'); ?> 12:30pm</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="timedisplay_StartEndNormal" name="timedisplay" value="startendnormal"></td>
							<td><label for="timedisplay_StartEndNormal">12:00pm - 12:30pm</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="timedisplay_StartEndTiny" name="timedisplay" value="startendtiny"></td>
							<td><label for="timedisplay_StartEndTiny">12:00pm-12:30pm</label></td>
						</tr>
					</table>
				</td>
				<td style="padding-left: 8px; border-left: 1px solid #666666;" valign="top">
					<table border="0" cellpadding="0" cellspacing="2">
						<tr>
							<td><input type="radio" id="timedisplay_StartDurationLong" name="timedisplay" value="startdurationlong"></td>
							<td><label for="timedisplay_StartDurationLong">12:00pm <?php echo lang('export_output_for'); ?> 2 <?php echo lang('export_output_hours'); ?></label></td>
						</tr>
						<tr>
							<td><input type="radio" id="timedisplay_StartDurationNormal" name="timedisplay" value="startdurationnormal"></td>
							<td><label for="timedisplay_StartDurationNormal">12:00pm (2 <?php echo lang('export_output_hours'); ?>)</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="timedisplay_StartDurationShort" name="timedisplay" value="startdurationshort"></td>
							<td><label for="timedisplay_StartDurationShort">12:00pm 2 <?php echo lang('export_output_hours'); ?></label></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!--
		<select name="timedisplay">
			<option value="start" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'start') echo "selected"; ?>>12:00pm</option>
			<option value="startendlong" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'startendlong') echo "selected"; ?>>12:00pm to 12:30pm</option>
			<option value="startendnormal" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'startendnormal') echo "selected"; ?>>12:00pm - 12:30pm</option>
			<option value="startendtiny" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'startendtiny') echo "selected"; ?>>12:00pm-12:30pm</option>
			<option value="startdurationlong" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'startdurationlong') echo "selected"; ?>>12:00pm for 2 <?php echo lang('export_output_hours'); ?></option>
			<option value="startdurationnormal" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'startdurationnormal') echo "selected"; ?>>12:00pm (2 <?php echo lang('export_output_hours'); ?>)</option>
			<option value="startdurationshort" <?php if (isset($Form_timedisplay) && $Form_timedisplay == 'startdurationshort') echo "selected"; ?>>12:00pm 2 <?php echo lang('export_output_hours'); ?></option>
		</select>
		-->
	</blockquote>
	
	<p><b><?php echo lang('export_timeformat'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_timeformat_description'); ?></p>
		<select name="timeformat">
			<option value="huge" <?php if (isset($Form_timeformat) && $Form_timeformat == 'huge') echo "selected"; ?>>12:00 PM EST</option>
			<option value="long" <?php if (isset($Form_timeformat) && $Form_timeformat == 'long') echo "selected"; ?>>12:00 PM</option>
			<option value="normal" <?php if (isset($Form_timeformat) && $Form_timeformat == 'normal') echo "selected"; ?>>12:00pm</option>
			<option value="short" <?php if (isset($Form_timeformat) && $Form_timeformat == 'short') echo "selected"; ?>>12:00p</option>
		</select>
		<!-- If you are using 24-hour time, then remove the select and option tags above and uncomment the section below -->
		<!--<select name="timeformat">
			<option value="long" <?php if (isset($Form_timeformat) && $Form_timeformat == 'long') echo "selected"; ?>>24:00 EST</option>
			<option value="normal" <?php if (isset($Form_timeformat) && $Form_timeformat == 'normal') echo "selected"; ?>>24:00</option>
		</select>-->
	</blockquote>
	
	<p><b><?php echo lang('export_durationformat'); ?>:</b></p>
	
	<blockquote>
		<select name="durationformat">
			<option value="long" <?php if (isset($Form_durationformat) && $Form_durationformat == 'long') echo "selected"; ?>>2 <?php echo lang('export_output_hours'); ?> 30 <?php echo lang('export_output_minutes'); ?></option>
			<option value="normal" <?php if (isset($Form_durationformat) && $Form_durationformat == 'normal') echo "selected"; ?>>2 <?php echo lang('export_output_hours'); ?> 30 <?php echo lang('export_output_min'); ?></option>
			<option value="short" <?php if (isset($Form_durationformat) && $Form_durationformat == 'short') echo "selected"; ?>>2 <?php echo lang('export_output_hrs'); ?> 30 <?php echo lang('export_output_min'); ?></option>
			<option value="tiny" <?php if (isset($Form_durationformat) && $Form_durationformat == 'tiny') echo "selected"; ?>>2<?php echo lang('export_output_hrs'); ?> 30<?php echo lang('export_output_min'); ?></option>
			<option value="micro" <?php if (isset($Form_durationformat) && $Form_durationformat == 'micro') echo "selected"; ?>>2<?php echo lang('export_output_hr'); ?> 30<?php echo lang('export_output_m'); ?></option>
		</select>
	</blockquote>
</div>

<div class="FormSectionHeader"><h3><?php echo lang('export_htmldisplaysettings'); ?>:</h3></div>

<div style="padding-left: 10px;">
	<p><b><?php echo lang('export_showdatetime'); ?>:</b></p>
	<blockquote>
		<p><?php echo lang('export_showdatetime_description'); ?></p>
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="showdatetime" id="showdatetime_yes" type="radio" value="1" <?php if (isset($Form_showdatetime) && $Form_showdatetime == '1') echo "checked"; ?>></td>
				<td><label for="showdatetime_yes"><?php echo lang('export_show'); ?></label></td>
			</tr>
			<tr>
				<td><input name="showdatetime" id="showdatetime_no" type="radio" value="0" <?php if (isset($Form_showdatetime) && $Form_showdatetime == '0') echo "checked"; ?>></td>
				<td><label for="showdatetime_no"><?php echo lang('export_hide'); ?></label></td>
			</tr>
		</table>
	</blockquote>
	
	<p><b><?php echo lang('export_showlocation'); ?>: </b></p>
	<blockquote>
		<p><?php echo lang('export_showlocation_description'); ?></p>
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="showlocation" id="showlocation_yes" type="radio" value="1" <?php if (isset($Form_showlocation) && $Form_showlocation == '1') echo "checked"; ?>></td>
				<td><label for="showlocation_yes"><?php echo lang('export_show'); ?></label></td>
			</tr>
			<tr>
				<td><input name="showlocation" id="showlocation_no" type="radio" value="0" <?php if (isset($Form_showlocation) && $Form_showlocation == '0') echo "checked"; ?>></td>
				<td><label for="showlocation_no"><?php echo lang('export_hide'); ?></label></td>
			</tr>
		</table>
	</blockquote>
	
	<p><b><?php echo lang('export_showallday'); ?>:</b></p>
	<blockquote>
		<p><?php echo lang('export_showallday_description'); ?></p>
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="showallday" id="showallday_yes" type="radio" value="1" <?php if (isset($Form_showallday) && $Form_showallday == '1') echo "checked"; ?>></td>
				<td><label for="showallday_yes"><?php echo lang('export_show'); ?></label></td>
			</tr>
			<tr>
				<td><input name="showallday" id="showallday_no" type="radio" value="0" <?php if (isset($Form_showallday) && $Form_showallday == '0') echo "checked"; ?>></td>
				<td><label for="showallday_no"><?php echo lang('export_hide'); ?></label></td>
			</tr>
		</table>
	</blockquote>
	
	<p><b><?php echo lang('export_maxtitlechars'); ?>:</b></p>
	<blockquote>
		<p><?php echo lang('export_maxtitlechars_description'); ?></p>
		<p><input name="maxtitlecharacters" type="text" id="maxtitlecharacters" value=""> (<?php echo lang('export_leaveblank'); ?>)</p>
	</blockquote>
	
	<p><b><?php echo lang('export_maxlocationchars'); ?>:</b></p>
	<blockquote>
		<p><?php echo lang('export_maxlocationchars_description'); ?></p>
		<p><input name="maxlocationcharacters" type="text" id="maxlocationcharacters" value=""> (<?php echo lang('export_leaveblank'); ?>)</p>
	</blockquote>
	
	<p><input type="Submit" name="createexport" value="<?php echo lang('export_submit'); ?>"><?php echo lang('export_resetform'); ?></p>
</div>

<!-- end of <div class="HTMLOnly"> -->
</div>


</form>
<script type="text/javascript">
ToggleHTMLSections();
</script>
</td></tr></table>