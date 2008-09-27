<?php

define("ALLOWINCLUDES","true");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>VTCalendar Configuration</title>
<script type="text/javascript" src="../scripts/browsersniffer.js"></script>
<script type="text/javascript" src="../scripts/http.js"></script>
<script type="text/javascript" src="scripts.js"></script>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php

define("CONFIGFILENAME", '../config.inc.php');

if (file_exists(CONFIGFILENAME)) {
	echo "<h1 style='color: red;'>Calendar Already Configured:</h1> Cannot configure calendar since config.inc.php already exists.<br/>Edit the file manually, or remove/rename config.inc.php and try again.</body></html>";
	exit();
}

function escapephpstring($string) {
	return str_replace("'", "\\'", str_replace("\\", "\\\\", $string));
}

require("config-code.php");
	
if (isset($_POST['SaveConfig'])) {
	
	$ConfigOutput = "<?php\n\n";
	$ConfigOutput .= "// ===========================================================================\n";
	$ConfigOutput .= "// WARNING: Do not output ANYTHING in this file!\n";
	$ConfigOutput .= "// This include file is called before session_start(), so it must never output any data.\n";
	$ConfigOutput .= "// ===========================================================================\n\n";
	
	$ConfigOutput .= "// For a full list of config options (and default values) see config-defaults.inc.php.\n\n";
	
	BuildOutput($ConfigOutput);
	
	$ConfigOutput .= "?>";
	
	// TODO: Validate input.
	
	$WriteSuccess = true; //(file_put_contents(CONFIGFILENAME, $ConfigOutput) !== false);
	
	if ($WriteSuccess) {
		echo '<h1 style="color:#009900">Configuration File Successfully Created</h1>';
		echo "<p>If you want to make any configuration changes please modify the newly created file <code>config.inc.php</code>.</p>";
		echo '<form method="post" action="upgradedb.php?fromconfig=yes"><input type="hidden" name="DSN" value="' . $Form_DATABASE . '"/>If this is a <b>fresh install</b> or if you have <b>upgraded to a newer version</b> of VTCalendar, you should <input type="submit" value="Install or Upgrade Database"/> (MySQL databases only).</form>';
		echo '</body></html>';
		exit;
	}
}

?>
<h1>VTCalendar Configuration:</h1>

<?php
if (isset($_POST['SaveConfig']) && !$WriteSuccess) {
	?>
	<div id="SaveFailed">
	<p><b class="Title">Save Failed:</b><br/>The config file could not be saved. To manually create the config.inc.php, copy/paste the contents of the box below and paste it into a new file. Save that file to the vtcalendar folder and name it &quot;config.inc.php&quot;.<br/><br/>
	<b style="color: #FF0000;">Security Notice:</b> It is recommended that you remove or secure the <b>/install</b> directory.</p>
	<textarea style="width: 100%; height: 200px" cols="60" rows="15" name="code" readonly="readonly" onfocus="this.select();" onclick="this.select(); this.focus();"><?php echo htmlentities($ConfigOutput); ?></textarea>
	</div>
	<?php
}
else {
?>
<form name="ConfigForm" method="post" action="config.php">

<?php require("config-form.php"); ?>

<script type="text/javascript">
//<!--
AddCheckDSNLink();
//-->
</script>

<input type="submit" name="SaveConfig" value="Save Configuration"/>
</form>
<?php } ?>
</body>
</html>
