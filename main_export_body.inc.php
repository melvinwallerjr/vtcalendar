<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

if ($Submit_CreateExport && count($FormErrors) == 0) {
	echo '<div style="padding: 10px; padding-bottom: 0;">' . lang('export_preview_description') .'</div>';
}
else {
	echo '<div style="padding: 10px; padding-bottom: 0;">' . lang('export_form_description') .'</div>';
}

?><form id="ExportForm" name="ExportForm" method="get" action="main.php" class="HideHTML"><?php

if ($Submit_CreateExport && count($FormErrors) == 0) {
	$queryString = "";
	foreach($_GET as $key => $val) {
		if (is_array($val)) {
			foreach ($val as $arrayval) {
				if (!empty($queryString)) $queryString .= "&";
				$queryString .= urlencode($key) . "=" . urlencode($arrayval);
				echo "\n".'<input type="hidden" name="'.htmlentities($key).'[]" value="'.htmlentities($arrayval).'">';
			}
		}
		else {
			if (!empty($queryString)) $queryString .= "&";
			$queryString .= urlencode($key) . "=" . urlencode($val);
			echo "\n".'<input type="hidden" name="'.htmlentities($key).'" value="'.htmlentities($val).'">';
		}
	}
	
	echo htmlentities($queryString);
	
	?>
	
	<p><input type="submit" value="&lt;&lt; Return to the Form"></p>
	
	<?php
	
	// Right click to save link
	
	// Export URL
	
	// Export Preview (depends on browser)
	
	// Raw Export Preview

}
else {
	require('main_export_body-form.inc.php');
}

?>
</form>