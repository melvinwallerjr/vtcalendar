<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

// Unset the selected categories if they are all selected.
// This prevents a huge query string in the export URL.
if (isset($FormData['categories']) && count($FormData['categories']) == $numcategories) { unset($FormData['categories']); }

if (!DOPREVIEW || count($FormErrors) != 0) {
	echo '
<div class="pad">
<p>' . lang('export_form_description') .'</p>
</div><!-- .pad -->';
}

echo '
<form id="ExportForm" name="ExportForm" method="get" action="main.php" class="HideHTML">
<input type="hidden" name="view" value="export" />';

if (DOPREVIEW && count($FormErrors) == 0) {
	// Create the query string and output hidden <input> so that we can return to the form.
	$URL = BASEURL . EXPORT_PATH . '?calendarid=' . $_SESSION['CALENDAR_ID'];
	foreach ($FormData as $key => $val) {
		// Output separate <input> if the value is an array.
		if (is_array($val)) {
			$URL .= '&amp;' . urlencode($key) . '=' . urlencode(implode(',', $val));
			foreach ($val as $v) {
				echo '
<input type="hidden" name="' . (($key == 'categories')? 'c' : htmlspecialchars($key, ENT_COMPAT, 'UTF-8')) . '[]" value="' . htmlspecialchars($v, ENT_COMPAT, 'UTF-8') . '" />';
			}
		}
		else {
			if (!isset($FormDataDefaults[$key]) || $val != $FormDataDefaults[$key]) {
				$URL .= '&amp;' . urlencode($key) . '=' . urlencode($val);
			}
			echo '
<input type="hidden" name="' . htmlspecialchars($key, ENT_COMPAT, 'UTF-8') . '" value="' . htmlspecialchars($val, ENT_COMPAT, 'UTF-8') . '" />';
		}
	}
	if (ISCALADMIN) { $URL .= '&amp;adminexport=1'; }
	echo '
<div class="pad">
<p><input type="submit" value="&laquo; ' . htmlspecialchars(lang('export_preview_return', false), ENT_COMPAT, 'UTF-8') . '" /></p>

<p><strong>' . lang('export_preview_download') . ':</strong><br />
' . str_replace('%URL%', $URL, lang('export_preview_download_text')) . '</p>

<p><label for="preview_url"><strong>' . lang('export_preview_url') . ':</strong></label><br />
' . lang('export_preview_url_text') . '<br />
<input type="text" id="preview_url" name="preview_url" value="' . htmlspecialchars($URL, ENT_COMPAT, 'UTF-8') . '" readonly="readonly" style="width:100%" onfocus="this.select();" onclick="this.select();this.focus();" /></p>';
	if ($FormData['format'] == 'js' || ($FormData['format'] == 'html' && $FormData['jshtml'] == '1')) {
		echo '
<p><label for="preview_js"><strong>' . lang('export_preview_js') . ':</strong></label><br />
' . lang('export_preview_js_text') . '<br />
<input type="text" id="preview_js" name="preview_js" value="' . htmlspecialchars('<script type="text/javascript" src="' . $URL . '"></script>', ENT_COMPAT, 'UTF-8') . '" readonly="readonly" style="width:100%" onfocus="this.select();" onclick="this.select();this.focus();" /></p>';
	}
	echo '
<p><strong>' . lang('export_preview_raw') . ':</strong><br />
' . lang('export_preview_raw_text') . '</p>
<div class="pre" style="padding:0px;"><iframe src="' . $URL . '&amp;raw=1" width="100%" height="400" frameborder="0"><p><a href="' . $URL . '&amp;raw=1" target="_blank">Test the URL</a></p></iframe></div>';
	echo '</div><!-- .pad -->' . "\n";

}
else {
	require('main_export_body-form.inc.php');
}
echo '
</form>' . "\n";
?>