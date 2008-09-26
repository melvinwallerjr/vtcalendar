<?php
// Returns a DB connection to the database, or a string that represents an error message.
function DBopen() {
	global $DBCONNECTION;
	$DBCONNECTION = DB::connect( DATABASE );
	
	if (DB::isError($DBCONNECTION)) {
		return $DBCONNECTION->getMessage();
	}
	
	return $DBCONNECTION;
}

// closes a DB connection to the database
function DBclose() {
	global $DBCONNECTION;
	$DBCONNECTION->disconnect();
}

// Runs a query against the database connection.
// Returns a record list if successful.
// Returns a string with an error message if unsuccessful.
function DBQuery($query) {
	global $DBCONNECTION;
	$result = $DBCONNECTION->query($query);
	
	if (DB::isError($result)) {
		return DB::errorMessage($result);
	}
	
	// Write to the SQL log file if one is defined.
	if (defined("SQLLOGFILE") && SQLLOGFILE != "") {
		$logfile = fopen(SQLLOGFILE, "a");
		
		// Log the username if logged in.
		if (!empty($_SESSION["AUTH_USERID"])) {
			$user = $_SESSION["AUTH_USERID"];
		}
		else {
			$user = "anonymous";
		}
		
		// Write the log entry and close the log.
		fputs($logfile, date( "Y-m-d H:i:s", time() )." ".$_SERVER["REMOTE_ADDR"]." ".$user." ".$_SERVER["PHP_SELF"]." ".$query."\n");
		fclose($logfile);	
	}
	
	return $result;
}

function DBErrorBox($message="") {
	?>
	<style type="text/css">
	.ErrorTable {
		background-color: #FFEAEB;
		border-width: 1px;
		border-style: solid;
		border-color: #A60004;
	}
	.ErrorTable td {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 13px;
	}
	.ErrorTable h1 {
		margin: 0;
		padding: 0;
		font-size: 16px;
	}
	</style>
	<table class="ErrorTable" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td style="padding: 8px;"><img src="images/warning_48w.gif" width="48" height="48"></td>
				<td style="padding: 8px;"><h1>Database Error:</h1>
				<div>An error was encountered when attempting to access the database.<?php
					if (!empty($message)) {
						?><br><b>Error Message: <?php echo htmlentities($message); ?></b><?php
					}
					?></div></td>
		</tr>
	</table>
	<?php
}
?>