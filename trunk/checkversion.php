<?php
define('JSSTART', '<script type="text/javascript"><!-- //<![CDATA[');
define('JSEND', '// ]]> --></script>');

$Width = '';
if (isset($_GET['width']) && preg_match("/^[0-9]+(%)?$/", $_GET['width'])) {
	$Width = 'width="' . $_GET['width'] . '"';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Check VTCalendar Version</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
<script type="text/javascript"><!-- //<![CDATA[
resultHTML = "";
function VersionResult(image, messageHTML) {
	var tableHTML = '<table border="0" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top" style="padding-top: 4px; padding-right: 8px;"><img src="'+image+'" class="png" width="32" height="32" alt=""/></td><td <?php echo $Width; ?>>'+messageHTML+'</td></tr></table>';
	if (<?php if (isset($_GET['nocallback'])) echo 'false && '; ?>parent && parent.CheckVersionHandler) {
		parent.CheckVersionHandler(image, messageHTML, tableHTML);
	}
	else {
		resultHTML = tableHTML;
	}
}
// ]]> --></script>

<?php
@(include_once('version.inc.php'));
if (!defined("VERSION")) {
	?><script type="text/javascript"><!-- //<![CDATA[
	VersionResult('install/failed32.png', 'VERSION was not defined. Make sure version.inc.php defines a constant named "VERSION" (e.g. <code>define("VERSION", 2.3.0);</code>).');
	// ]]> --></script><?php
}
else {
	?>
	<script type="text/javascript" src="http://vtcalendar.sourceforge.net/version.js.php"></script>
	<script type="text/javascript" src="scripts/checkversion.js"></script>
	<script type="text/javascript"><!-- //<![CDATA[
	
	var InstalledVTCalendarVersion = "<?php echo VERSION; ?>";
	var Result = CheckVTCalendarVersion(InstalledVTCalendarVersion, document.LatestVTCalendarVersion);
	
	if (Result == "EQUAL") {
		VersionResult('install/success32.png', 'Your version of VTCalendar (' + InstalledVTCalendarVersion + ') is <b>up-to-date</b>.');
	}
	else if (Result == "OLDER") {
		VersionResult('install/down32.png', 'Your version of VTCalendar is ' + InstalledVTCalendarVersion + ' but a <b>newer version (' + document.LatestVTCalendarVersion + ') is available</b>.<br/>Visit <a href="http://vtcalendar.sourceforge.net/" target="_blank">http://vtcalendar.sourceforge.net/</a> for details.');
	}
	else if (Result == "NEWER") {
		VersionResult('install/warning32.png', 'Your version of VTCalendar (' + InstalledVTCalendarVersion + ') is <b>newer than the latest release version (' + document.LatestVTCalendarVersion + ')</b>.<br/>You may be running a alpha or beta build, which are not recommended for production.');
	}
	else {
		VersionResult('install/failed32.png', 'An <b>error occurred while attempting to check for a newer version</b> of VTCalendar.<br/>Visit <a href="http://vtcalendar.sourceforge.net/" target="_blank">http://vtcalendar.sourceforge.net/</a> to manually check for a new version.');
	}
	// ]]> --></script>
	<?php
}
?>
</head><body><script type="text/javascript"><!-- //<![CDATA[
document.write(resultHTML);
// ]]> --></script></body>
</html>
