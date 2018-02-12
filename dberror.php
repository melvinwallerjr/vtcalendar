<?php
header('HTTP/1.1 500 Internal Server Error');
header('Expires: ' . gmdate('D, d M Y H:i:s', mktime(0, 0, 0, 1, 1, 1975)) . ' GMT');
header('Cache-Control: no-store');

if (!defined('HIDEDBERROR')) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

<title>Database Error</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">/* <![CDATA[ */
.ErrorTable {
	border: 1px solid #A60004;
	background-color: #FFEAEB;
}
.ErrorTable td {
	font-family: 'Arial', 'Helvetica', sans-serif;
	font-size: 13px;
}
.ErrorTable h1 {
	margin: 0px;
	padding: 0px;
	font-size: 16px;
}
/* ]]> */</style>

</head><body>

<table class="ErrorTable" border="0" cellspacing="0" cellpadding="8">
<tbody><tr>
<td><img src="images/warning_48w.gif" width="48" height="48" alt="Warning" /></td>
<td><h1>Database Error:</h1>
<p>An error was encountered when attempting to connect to the database.<?php
if (isset($DBCONNECTION) && is_string($DBCONNECTION)) {
	echo '<br />
<b>' . htmlspecialchars($DBCONNECTION, ENT_COMPAT, 'UTF-8') . '</b>' . "\n";
}
if (isset($_GET['message'])) {
	// Use setVar just in case magic_quotes_gpc is on
	setVar($errormessage, $_GET['message']);
	echo '<br />
<b>' . htmlspecialchars($errormessage, ENT_COMPAT, 'UTF-8') . '</b>' . "\n";
}
?></p></td>
</tr></tbody>
</table>

</body></html>
<?php } ?>