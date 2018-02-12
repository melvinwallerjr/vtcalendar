<?php
function DBOpen($DSN=null, $DebugInfo=false)
{ // Returns a DB connection to the database, or a string that represents an error message.
	$Connection = DB::connect(($DSN === null)? DATABASE : $DSN);
	if (DB::isError($Connection)) {
		if ($DebugInfo) {
			$GLOBALS['DebugInfo'] = $Connection->getDebugInfo();
			echo '<strong>QUERY</strong><pre>' . $query . '</pre>';
			echo '<strong>' . DB::errorMessage($result) . '</strong><pre>';
			print_r($Connection);
			echo '</pre>';
		}
		return $Connection->getMessage();
	}
	return $Connection;
}

function DBClose($Connection=null)
{ // Closes a DB connection to the database
	global $DBCONNECTION;
	if ($Connection === null) { $DBCONNECTION->disconnect(); }
	else { $Connection->disconnect(); }
}

/**
 * Runs a query against the database connection.
 * Returns a record list if successful.
 * Returns a string with an error message if unsuccessful.
 */
function DBQuery($query, $Connection=null, $DebugInfo=false)
{
	global $DBCONNECTION;
	if ($Connection === null) {
		$Connection = isset($DBCONNECTION)? $DBCONNECTION : DB::connect(DATABASE);
	}
	$result = $Connection->query($query);
	if (DB::isError($result)) {
		if ($DebugInfo) {
			$GLOBALS['DebugInfo'] = $Connection->getDebugInfo();
			echo "\n\n" . '<div><strong>QUERY</strong><pre>' . $query . '</pre></div>' . "\n\n";
			echo '<div><strong>' . DB::errorMessage($result) . '</strong><pre>';
			print_r($Connection);
			echo '</pre></div>' . "\n\n";
		}
		return DB::errorMessage($result);
	}
	// Write to the SQL log file if one is defined.
	if (defined('SQLLOGFILE') && SQLLOGFILE != '') {
		$logfile = fopen(SQLLOGFILE, 'a');
		// Log the username if logged in.
		if (!empty($_SESSION['AUTH_USERID'])) { $user = $_SESSION['AUTH_USERID']; }
		else { $user = 'anonymous'; }
		// Write the log entry and close the log.
		fputs($logfile, date('Y-m-d H:i:s', time()) . ' ' . $_SERVER['REMOTE_ADDR'] .
		 ' ' . $user . ' ' . $_SERVER['PHP_SELF'] . ' ' . $query . "\n");
		fclose($logfile);
	}
	return $result;
}

if (!function_exists('sqlescape')) {
	function sqlescape($value)
	{ // escapes a value to make it safe for a SQL query
		if (preg_match("/^pgsql/", DATABASE)) { return pg_escape_string($value); }
		else { return mysql_escape_string($value); }
	}
}

function DBErrorBox($message='')
{
?>
<table class="ErrorTable" border="0" cellspacing="0" cellpadding="8">
<tbody><tr>
<td><img src="images/warning_48w.gif" width="48" height="48" alt="Warning" /></td>
<td>
<h1>Database Error:</h1>
<p>An error was encountered when attempting to access the database.
<?php
	if (!empty($message)) {
		echo '<br />
<b>Error Message: ' . htmlspecialchars($message, ENT_COMPAT, 'UTF-8') . '</b>';
	}
?></p></td>
</tr></tbody>
</table>
<?php
}
?>