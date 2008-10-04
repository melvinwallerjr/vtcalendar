<div style="padding: 10px; padding-bottom: 0;">SOME DESCRIPTION</div>

<form id="ExportForm" name="ExportForm" method="get" action="main.php">

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
//]]> -->
</script>

<div class="FormSectionHeader"><h3><?php echo lang('export_settings'); ?>:</h3></div>

<div style="padding-left: 10px;">
	<p><b><?php echo lang('export_format'); ?></b></p>
	
	<blockquote>
		<table  border="0" cellpadding="2" cellspacing="0">
	    	<tr>
	    		<td><input name="format" type="radio" value="html" id="format_html"></td>
	    		<td><label for="format_html">HTML</label></td>
	    	</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="js"></td>
		   		<td>JavaScript Array (e.g. <code>vtcalevents[0]['date']</code>)</td>
	    	</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="vtcalendar"></td>
	    		<td>VTCalendar (XML) </td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="rss0.91"></td>
	    		<td> RSS 0.91 (XML) </td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="rss1.0"></td>
	    		<td>RSS 1.0 (XML) </td>
	   		</tr>
	    	<tr>
	    		<td><input name="format" type="radio" value="voicexml"></td>
	    		<td>VoiceXML 2.0 (XML) </td>
	   		</tr>
	    </table>
	</blockquote>
	
	<p><b><?php echo lang('export_maxevents'); ?>: </b></p>
	
	<blockquote>
		<p><?php echo lang('export_maxevents_description'); ?></p>
		<p><input name="maxevents" type="text" id="maxevents" value="25">
			 (<?php echo lang('export_leaveblank'); ?>)</p>
	</blockquote>
	
	<p><b><?php echo lang('export_dates'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_dates_description'); ?></p>
		<table  border="0" cellspacing="0" cellpadding="4">
	    	<tr>
	    		<td style="padding-bottom: 2px;"><b><?php echo lang('export_dates_from'); ?>:</b></td>
	    		<td style="padding-bottom: 2px;"><input name="timebegin" type="text" id="timebegin"></td>
	    	</tr>
	    	<tr>
	    		<td style="padding-top: 0;">&nbsp;</td>
	    		<td style="padding-top: 0;"><?php echo lang('export_dates_from_description'); ?></td>
	    	</tr>
	    	<tr>
	    		<td style="padding-bottom: 2px;"><b><?php echo lang('export_dates_to'); ?>:</b></td>
	    		<td style="padding-bottom: 2px"><input name="timeend" type="text" id="timeend"></td>
	    	</tr>
	    	<tr>
	    		<td style="padding-top: 0;">&nbsp;</td>
	    		<td style="padding-top: 0;"><?php echo lang('export_dates_to_description'); ?></td>
	    	</tr>
	   	</table>
	</blockquote>
	
	<p><b><?php echo lang('export_categories'); ?>:</b></p>
	
	<blockquote>
		<p><a href="javascript:checkAll(document.ExportForm,'categories',true);"><?php echo lang('select_unselect'); ?></a></p>
		<table border="0" cellspacing="0" cellpadding="4"><tr><td valign="top">
		<table border="0" cellspacing="0" cellpadding="1">
		<?php
		
		// Create a list of category filter keys
		if (isset($categories)) {
			$selectedCategoryKeys = array_flip($categories);
		}
		
		// Determine how many categories are in each column.
		$percolumn = ceil($numcategories / 3);
		
		for ($c=0; $c<$numcategories; $c++) {
			$categoryselected = !isset($categories) || count($categories) == 0 || array_key_exists($categories_id[$c], $selectedCategoryKeys);
			
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
	    		<td><input name="sponsor" type="radio" value="all"></td>
	    		<td><?php echo lang('export_sponsor_all'); ?></td>
	    	</tr>
	    	<tr>
	    		<td valign="top"><input name="sponsor" type="radio" value="specific"></td>
	    		<td><?php echo lang('export_sponsor_specific'); ?>: 
	    			<input name="specificsponsor" type="text" id="specificsponsor"><br>
	    			(<?php echo lang('export_sponsor_specific_description'); ?>)</td>
	   		</tr>
	   	</table>
	</blockquote>

	<p><input type="Submit" name="createexport" value="<?php echo lang('export_submit'); ?>">
		<span><?php echo lang('export_keepscrolling'); ?></span></p>
</div>

<div class="HTMLOnly">

<div class="FormSectionHeader"><h3><?php echo lang('export_htmlsettings'); ?>:</h3></div>

<div style="padding-left: 10px;">
	<p><b><?php echo lang('export_keepcategoryfilter'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_keepcategoryfilter_description'); ?></p>
		<p><input name="keepcategoryfilter" type="checkbox" id="keepcategoryfilter" value="1" <?php if (isset($keepcategoryfilter)) echo "checked"; ?>><label for="keepcategoryfilter"> <?php echo lang('yes'); ?></label></p>
	</blockquote>
	
	<p><b><?php echo lang('export_htmltype'); ?>:</b></p>
	
	<blockquote>
	    	<p><?php echo lang('export_htmltype_description'); ?></p>
	    	<p><select name="htmltype" id="htmltype">
	    			<option <?php if (isset($htmltype) && $htmltype == 'paragraph') echo "selected"; ?>><?php echo lang('export_htmltype_paragraph'); ?></option>
		    		<option <?php if (isset($htmltype) && $htmltype == 'table') echo "selected"; ?>><?php echo lang('export_htmltype_table'); ?></option>
				</select></p>
	</blockquote>
	
	<p><b><?php echo lang('export_jsoutput'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_jsoutput_description'); ?></p>
	    <table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="jshtml" type="checkbox" id="jshtml" value="1" <?php if (isset($jshtml)) echo "checked"; ?>></td>
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
			<option value="huge" <?php if (isset($dateformat) && $dateformat == 'huge') echo "selected"; ?>>Wednesday, October 25, 2006</option>
			<option value="long" <?php if (isset($dateformat) && $dateformat == 'long') echo "selected"; ?>>Wed, October 25, 2006</option>
			<option value="normal" <?php if (isset($dateformat) && $dateformat == 'normal') echo "selected"; ?>>October 25, 2006</option>
			<option value="short" <?php if (isset($dateformat) && $dateformat == 'short') echo "selected"; ?>>Oct. 25, 2006</option>
			<option value="tiny" <?php if (isset($dateformat) && $dateformat == 'tiny') echo "selected"; ?>>Oct 25 '06</option>
			<option value="micro" <?php if (isset($dateformat) && $dateformat == 'micro') echo "selected"; ?>>Oct 25</option>
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
							<td><label for="timedisplay_StartEndLong">12:00pm to 12:30pm</label></td>
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
							<td><label for="timedisplay_StartDurationLong">12:00pm for 2 hours</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="timedisplay_StartDurationNormal" name="timedisplay" value="startdurationnormal"></td>
							<td><label for="timedisplay_StartDurationNormal">12:00pm (2 hours)</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="timedisplay_StartDurationShort" name="timedisplay" value="startdurationshort"></td>
							<td><label for="timedisplay_StartDurationShort">12:00pm 2 hours</label></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!--
		<select name="timedisplay">
			<option value="start" <?php if (isset($timedisplay) && $timedisplay == 'start') echo "selected"; ?>>12:00pm</option>
			<option value="startendlong" <?php if (isset($timedisplay) && $timedisplay == 'startendlong') echo "selected"; ?>>12:00pm to 12:30pm</option>
			<option value="startendnormal" <?php if (isset($timedisplay) && $timedisplay == 'startendnormal') echo "selected"; ?>>12:00pm - 12:30pm</option>
			<option value="startendtiny" <?php if (isset($timedisplay) && $timedisplay == 'startendtiny') echo "selected"; ?>>12:00pm-12:30pm</option>
			<option value="startdurationlong" <?php if (isset($timedisplay) && $timedisplay == 'startdurationlong') echo "selected"; ?>>12:00pm for 2 hours</option>
			<option value="startdurationnormal" <?php if (isset($timedisplay) && $timedisplay == 'startdurationnormal') echo "selected"; ?>>12:00pm (2 hours)</option>
			<option value="startdurationshort" <?php if (isset($timedisplay) && $timedisplay == 'startdurationshort') echo "selected"; ?>>12:00pm 2 hours</option>
		</select>
		-->
	</blockquote>
	
	<p><b><?php echo lang('export_timeformat'); ?>:</b></p>
	
	<blockquote>
		<p><?php echo lang('export_timeformat_description'); ?></p>
		<select name="timeformat">
			<option value="huge" <?php if (isset($timeformat) && $timeformat == 'huge') echo "selected"; ?>>12:00 PM EST</option>
			<option value="long" <?php if (isset($timeformat) && $timeformat == 'long') echo "selected"; ?>>12:00 PM</option>
			<option value="normal" <?php if (isset($timeformat) && $timeformat == 'normal') echo "selected"; ?>>12:00pm</option>
			<option value="short" <?php if (isset($timeformat) && $timeformat == 'short') echo "selected"; ?>>12:00p</option>
		</select>
		<!-- If you are using 24-hour time, then remove the select and option tags above and uncomment the section below -->
		<!--<select name="timeformat">
			<option value="long" <?php if (isset($timeformat) && $timeformat == 'long') echo "selected"; ?>>24:00 EST</option>
			<option value="normal" <?php if (isset($timeformat) && $timeformat == 'normal') echo "selected"; ?>>24:00</option>
		</select>-->
	</blockquote>
	
	<p><b><?php echo lang('export_durationformat'); ?>:</b></p>
	
	<blockquote>
		<select name="durationformat">
			<option value="long" <?php if (isset($durationformat) && $durationformat == 'long') echo "selected"; ?>>2 hours 30 minutes</option>
			<option value="normal" <?php if (isset($durationformat) && $durationformat == 'normal') echo "selected"; ?>>2 hours 30 min</option>
			<option value="short" <?php if (isset($durationformat) && $durationformat == 'short') echo "selected"; ?>>2 hrs 30 min</option>
			<option value="tiny" <?php if (isset($durationformat) && $durationformat == 'tiny') echo "selected"; ?>>2hrs 30min</option>
			<option value="micro" <?php if (isset($durationformat) && $durationformat == 'micro') echo "selected"; ?>>2hr 30m</option>
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
				<td><input name="showdatetime" id="showdatetime_yes" type="radio" value="1" <?php if (isset($showdatetime) && $showdatetime == '1') echo "checked"; ?>></td>
				<td><label for="showdatetime_yes"><?php echo lang('export_show'); ?></label></td>
			</tr>
			<tr>
				<td><input name="showdatetime" id="showdatetime_no" type="radio" value="0" <?php if (isset($showdatetime) && $showdatetime == '0') echo "checked"; ?>></td>
				<td><label for="showdatetime_no"><?php echo lang('export_hide'); ?></label></td>
			</tr>
		</table>
	</blockquote>
	
	<p><b><?php echo lang('export_showlocation'); ?>: </b></p>
	<blockquote>
		<p><?php echo lang('export_showlocation_description'); ?></p>
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="showlocation" id="showlocation_yes" type="radio" value="1" <?php if (isset($showlocation) && $showlocation == '1') echo "checked"; ?>></td>
				<td><label for="showlocation_yes"><?php echo lang('export_show'); ?></label></td>
			</tr>
			<tr>
				<td><input name="showlocation" id="showlocation_no" type="radio" value="0" <?php if (isset($showlocation) && $showlocation == '0') echo "checked"; ?>></td>
				<td><label for="showlocation_no"><?php echo lang('export_hide'); ?></label></td>
			</tr>
		</table>
	</blockquote>
	
	<p><b><?php echo lang('export_showallday'); ?>:</b></p>
	<blockquote>
		<p><?php echo lang('export_showallday_description'); ?></p>
		<table border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td><input name="showallday" id="showallday_yes" type="radio" value="1" <?php if (isset($showallday) && $showallday == '1') echo "checked"; ?>></td>
				<td><label for="showallday_yes"><?php echo lang('export_show'); ?></label></td>
			</tr>
			<tr>
				<td><input name="showallday" id="showallday_no" type="radio" value="0" <?php if (isset($showallday) && $showallday == '0') echo "checked"; ?>></td>
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
</td></tr></table>