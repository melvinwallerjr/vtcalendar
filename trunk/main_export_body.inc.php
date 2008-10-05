<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

if (!$Submit_CreateExport || count($FormErrors) != 0) {
	echo '<div style="padding: 10px; padding-bottom: 0;">' . lang('export_preview_description') .'</div>';
}

?><form id="ExportForm" name="ExportForm" method="get" action="main.php" class="HideHTML">
<input type="hidden" name="view" value="export"><?php

if ($Submit_CreateExport && count($FormErrors) == 0) {

	echo '<table border="0" cellspacing="0" cellpadding="10"><tr><td>';
	
	// Create the query string and output hidden <input> so that we can return to the form.
	$URL = BASEURL."export/export.php?calendarid=" . $_SESSION['CALENDAR_ID'];
	foreach($FormData as $key => $val) {
		// Output separate <input> if the value is an array.
		if (is_array($val)) {
			foreach ($val as $arrayval) {
				$URL .= '&' .urlencode($key) . '=' . urlencode($arrayval);
				echo "\n".'<input type="hidden" name="'.htmlentities($key).'[]" value="'.htmlentities($arrayval).'">';
			}
		}
		// Otherwise, output the value if it does not match the default (assuming there was a default).
		elseif (!isset($FormDataDefaults[$key]) || $val != $FormDataDefaults[$key]) {
			$URL .= '&' . urlencode($key) . '=' . urlencode($val);
			echo "\n".'<input type="hidden" name="'.htmlentities($key).'" value="'.htmlentities($val).'">';
		}
	}
	?>
	
	<div><input type="submit" value="&lt;&lt; Return to the Form"></div>
	
	<p><b>Download Exported Events:</b><br>
	To save the exported events, <a href="<?php echo htmlentities($URL); ?>" onclick="return false;">right click this link</a> and select "Save Target As..." or "Save Link As..."</p>
	
	<p><b>Export URL:</b><br>
	The URL below will export events based on the settings you provided.<br>
	<input type="text" readonly="readonly" value="<?php echo htmlentities($URL); ?>" style="width: 100%"></p>
	
	<?php if ($FormData['format'] == 'html' && $FormData['jshtml'] == '1') { ?>
	<p><b>JavaScript Code:</b><br>
	The code below can be copy/pasted into your Web site to automatically display events based on the settings you provided.<br>
	<input type="text" readonly="readonly" value="<?php echo htmlentities('<script type="text/javascript" src="'.htmlentities($URL).'"></script>'); ?>" style="width: 100%"></p>
	<?php } ?>
	
	<p><b>Raw Export Preview:</b><br>
	The window below shows the raw output for the exported events.<br>
	<iframe style="margin-top: 4px; background-color: #FFFFFF;" src="<?php echo $URL; ?>&raw=1" width="99%" height="400" framebordder="1"><p><a href="<?php echo $URL; ?>&raw=1" target="_blank">Test the URL</a></p></iframe></p>

	<?php
	
	// Right click to save link
	
	// Export URL
	
	// Export Preview (depends on browser)
	
	// Raw Export Preview
	
	echo '</td></tr></table>';

}
else {
	require('main_export_body-form.inc.php');
}

?>
</form>