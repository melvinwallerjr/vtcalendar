<?php

define("ALLOWINCLUDES","true");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>VTCalendar Configuration</title>
<style type="text/css">
<!--
body, th, td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
}

h1 {
	font-size: 24px;
	padding-bottom: 8px;
	border-bottom: 2px solid #333333;
}
h2 {
	font-size: 16px;
	padding: 6px;
	background-color: #CCDBFF;
	border-top: 1px solid #666666;
}
table.VariableTable {
	border-right: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
}
td.VariableName {
	background-color: #EEEEEE;
}
td.VariableName, td.VariableBody {
	border-top: 1px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
}
td.DataField {
	padding-top: 0;
}
td.Comment {
	padding-top: 0;
}
label {
	cursor: pointer;
}
blockquote {
	margin-left: 22px;
	margin-right: 0px;
}
#SaveFailed {
	border: 1px solid #660000;
	background-color: #FFEEEE;
	padding: 8px;
	font-weight: none;
}
#SaveFailed b.Title {
	font-size: 18px;
}
#SaveFailed p {
	padding-top: 0;
	margin-top: 0;
}
-->
</style>
<script type="text/javascript">
//<!--
function ToggleDependant(variableid) {
	if (document.getElementById) {
		objCheckbox = document.getElementById("CheckBox_" + variableid);
		objRow = document.getElementById("Dependants_" + variableid);
		if (objCheckbox && objRow) {
			if (objCheckbox.checked) {
				objRow.style.display = "";
			}
			else {
				objRow.style.display = "none";
			}
		}
	}
}
//-->
</script>
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

if (isset($_POST['SaveConfig'])) {
	
	$ConfigOutput = "<?php\n\n";
	$ConfigOutput .= "// ===========================================================================\n";
	$ConfigOutput .= "// WARNING: Do not output ANYTHING in this file!\n";
	$ConfigOutput .= "// This include file is called before session_start(), so it must never output any data.\n";
	$ConfigOutput .= "// ===========================================================================\n\n";
	
	$ConfigOutput .= "// For a full list of config options (and default values) see config-defaults.inc.php.\n\n";
	
	require("index-code.php");
	
	$ConfigOutput .= "?>";
	
	// TODO: Validate input.
	
	$WriteSuccess = false; //(file_put_contents(CONFIGFILENAME, $ConfigOutput) !== false);
	
	if ($WriteSuccess) {
		echo '<h1 style="color:#009900">Configuration File Successfully Created</h1>';
		echo "<p>If you want to make any configuration changes please modify the newly created file <b>config.inc.php</b>.<br><br>";
		echo '<b style="color: #FF0000;">Security Notice:</b> It is recommended that you remove or secure the <b>/install</b> directory.</p>';
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
	<p><b class="Title">Save Failed:</b><br/>The config file could not be saved. To manually create the config.inc.php, copy/paste the contents of the box below and paste it into a new file. Save that file to the vtcalendar folder and name it "config.inc.php".<br/><br/>
	<b style="color: #FF0000;">Security Notice:</b> It is recommended that you remove or secure the <b>/install</b> directory.</p>
	<textarea style="width: 100%; height: 200px" readonly="readonly" onfocus="this.select();" onclick="this.select(); this.focus();"><?php echo htmlentities($ConfigOutput); ?></textarea>
	</div>
	<?php
}
else {
?>
<form name="ConfigForm" method="post" action="index.php">

<?php require("index-form.php"); ?>

<input type="submit" name="SaveConfig" value="Save Configuration"/>
</form>
<?php } ?>
</body>
</html>
