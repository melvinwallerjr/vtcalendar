<?php
define('JSSTART', '<script type="text/javascript">/* <![CDATA[ */');
define('JSEND', '/* ]]> */</script>');

@(include_once('config.inc.php'));
@(include_once('version.inc.php'));
require_once('config-defaults.inc.php');

$Width = (isset($_GET['width']) && preg_match("/^[0-9]+(%)?$/", $_GET['width']))?
 ' width="' . $_GET['width'] . '"' : '';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

<title>Check VTCalendar Version</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
<script type="text/javascript" src="scripts/basicfunctions.js"></script>
<script type="text/javascript">/* <![CDATA[ */
var resultHTML = "";
function VersionResult(image, messageHTML)
{
	var i, ii, tableHTML="<table border=\"0\" cellspacing=\"0\" cellpadding=\"6\">\n<tbody>";
	if (isArray(messageHTML)) {
		for (i=0, ii=messageHTML.length; i < ii; i++) {
			tableHTML += "<tr>\n<td><img src=\"" + image[i] +
			 "\" class=\"png\" width=\"32\" height=\"32\" alt=\"o\" /><\/td>\n<td<?php echo $Width; ?>>" +
			 messageHTML[i] + "<\/td>\n<\/tr>";
		}
	}
	else {
		tableHTML += "<tr>\n<td><img src=\"" + image +
		 "\" class=\"png\" width=\"32\" height=\"32\" alt=\"o\" /><\/td>\n<td<?php echo $Width; ?>>" +
		 messageHTML + "<\/td>\n<\/tr>";
	}
	tableHTML += "<\/tbody>\n<\/table><br />\n\n";
	if (<?php echo isset($_GET['nocallback'])? 'false' : 'true'; ?> && window.parent &&
	 window.parent.CheckVersionHandler) {
		window.parent.CheckVersionHandler(image, messageHTML, tableHTML);
	}
	else {
		resultHTML = tableHTML;
	}
}
<?php if (!defined('VERSION')) { ?>
VersionResult("install/failed32.png", "<p>VERSION was not defined. Make sure version.inc.php defines a constant named \"VERSION\" (e.g. <code>define('VERSION', '2.3.0');<\/code>).<\/p>\n");
<?php } elseif (!CHECKVERSION) { ?>
VersionResult("install/failed32.png", "<p id=\"ReleaseMessage\"><b>Version checking is disabled.<\/b><\/p>\n<p id=\"ReleaseNote\">Visit the <a href=\"http://vtcalendar.sourceforge.net/jump.php?name=release\" target=\"_blank\">download<\/a> page to manually check for a new version.</p>\n");
<?php } else { ?>
/* ]]> */</script>
<?php
	if (ini_get('allow_url_fopen') &&
	 ($versionData = file_get_contents('http://vtcalendar.sourceforge.net/version.php?type=data')) !== false) {
		$jsoutput = '<script type="text/javascript">/* <![CDATA[ */' . "\n" . 'if (document) {' . "\n";
		$splitPairs = explode(';', $versionData);
		foreach ($splitPairs as $pair) {
			$splitPair = explode(':', $pair);
			$jsoutput .= "\t" . 'document.' . $splitPair[0] . ' = "' . $splitPair[1] . '";' . "\n";
		}
		$jsoutput .= '}' . "\n" . '/* ]]> */</script>' . "\n";
		echo $jsoutput;
	}
	else { // TODO: Change so this uses a Flash app to get the data.
		echo '<script type="text/javascript" src="http://vtcalendar.sourceforge.net/version.php?type=js"></script>' . "\n";
	}
?>
<script type="text/javascript">/* <![CDATA[ */
var Images=new Array(), Messages=new Array(), InstalledVTCalendarVersion="<?php echo VERSION; ?>";
var Result = CheckVTCalendarVersion(InstalledVTCalendarVersion, document.LatestVTCalendarVersion);
if (Result == "EQUAL") {
	Images[0] = "install/success32.png";
	Messages[0] = "<p id=\"ReleaseMessage\">Your version of VTCalendar (" + InstalledVTCalendarVersion + ") is <b>up-to-date<\/b>.<\/p>\n";
}
else if (Result == "OLDER") {
	Images[0] = "install/down32.png";
	Messages[0] = "<p id=\"ReleaseMessage\">Your version of VTCalendar is " + InstalledVTCalendarVersion + " but a <b>newer version (" + document.LatestVTCalendarVersion + ") is available<\/b>.<\/p>\n<p id=\"ReleaseNote\">Visit the <a href=\"http://vtcalendar.sourceforge.net/jump.php?name=release\" target=\"_blank\">download<\/a> page to upgrade.<\/p>\n";
}
else if (Result == "NEWER") {
	Images[0] = "install/warning32.png";
	Messages[0] = "<p id=\"ReleaseMessage\">Your version of VTCalendar (" + InstalledVTCalendarVersion + ") is <b>newer than the latest release version (" + document.LatestVTCalendarVersion + ")<\/b>.<\/p>\n<p id=\"ReleaseNote\">You may be running an alpha or beta build, which are not recommended for production.<\/p>\n";
	var PreReleaseResult = CheckVTCalendarVersion(InstalledVTCalendarVersion, document.LatestVTCalendarPreReleaseVersion);
	if (PreReleaseResult == "OLDER") {
		Images[1] = "install/down32.png";
		Messages[1] = "<p id=\"PreReleaseMessage\">However, a <b>newer version of pre-release (" + document.LatestVTCalendarPreReleaseVersion + ")<\/b> is available. Visit the <a href=\"http://vtcalendar.sourceforge.net/jump.php?name=prerelease\" target=\"_blank\">pre-release documentation<\/a> to upgrade.<\/p>\n";
	}
	else if (PreReleaseResult == "EQUAL") {
		Images[1] = "install/success32.png";
		Messages[1] = "<div id=\"PreReleaseMessage\">However, your <b>pre-release version is up-to-date<\/b>.<\/p>\n";
	}
	else if (Result == "NEWER") {
		Images[1] = "install/warning32.png";
		Messages[1] = "<p id=\"PreReleaseMessage\">Your pre-release version is also <b>newer than the latest pre-release version (" + document.LatestVTCalendarPreReleaseVersion + ")<\/b>.<\/p>\n<p id=\"PreReleaseNote\">You may be running a trunk build, which is not recommended as it is likely broken.<\/p>\n";
	}
	else if (Result == "ERROR") {
		Images[1] = "install/failed32.png";
		Messages[1] = "<p id=\"PreReleaseMessage\">An <b>error occurred while attempting to check for a newer pre-release version<\/b> of VTCalendar.<\/p><p id=\"PreReleaseNote\">Visit the <a href=\"http://vtcalendar.sourceforge.net/jump.php?name=prerelease\" target=\"_blank\">pre-release documentation<\/a> to manually check for a new version.<\/p>\n";
	}
}
else {
	Images[0] = "install/failed32.png";
	Messages[0] = "<p id=\"ReleaseMessage\">An <b>error occurred while attempting to check for a newer version<\/b> of VTCalendar.<\/p>\n<p id=\"ReleaseNote\">Visit <a href=\"http://vtcalendar.sourceforge.net/\" target=\"_blank\">http://vtcalendar.sourceforge.net/<\/a> to manually check for a new version.<\/p>\n";
}
VersionResult(Images, Messages);
/* ]]> */</script>
<?php } ?>

</head><body>

<script type="text/javascript">/* <![CDATA[ */
document.write(resultHTML);
/* ]]> */</script>

</body></html>
