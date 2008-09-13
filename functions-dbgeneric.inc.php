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
	if (SQLLOGFILE != "") {
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
?>