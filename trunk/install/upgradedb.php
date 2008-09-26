<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upgrade MySQL DB</title>
<style type="text/css">
body {
	font-family: Arial;
	font-size: 13px;
}
form {
	margin: 0;
	padding: 0;
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
h3.Table {
	background-image: url(table-big.png);
	background-repeat: no-repeat;
	height: 24px;
	padding: 0;
	padding-left: 38px;
	padding-top: 8px;
	margin: 0;
}
div {
	margin-bottom: 2px;
	padding: 5px;
}
div.Error, div.Success, div.Table, div.Field, div.PrimaryKey, div.Index {
	background-repeat: no-repeat;
	background-position: 5px 5px;
	padding-left: 30px;
}
div.Error {
	background-image: url(failed.png);
}
div.Success {
	background-image: url(success.png);
}
div.Table {
	background-image: url(table.png);
}
div.PrimaryKey {
	background-image: url(primarykey.png);
}
div.Index {
	background-image: url(index.png);
}
div.Field {
	background-image: url(field.png);
}
div.Error {
	background-color: #FFDDDD;
}
div.Unused {
	background-color: #EEEEEE;
}
div.Create {
	background-color: #DDFFDD;
}
div.Alter {
	background-color: #FFFF99;
}
code {
	color: #0000FF;
}
</style>
</head>

<body>
<?php

@(include_once('DB.php')) or die('Pear::DB does not seem to be installed. See: http://pear.php.net/package/DB');
require_once("../functions-db-generic.inc.php");
require_once("upgradedb-functions.php");
require_once("upgradedb-data.php");

if (isset($_GET['DSN'])) {
	define("DATABASE", $_GET['DSN']);
}
elseif (isset($_POST['DSN'])) {
	define("DATABASE", $_POST['DSN']);
}

?>
<h1>Upgrade VTCalendar MySQL DB</h1>
<h2>Enter the Database Connection String:</h2>
<blockquote>
<form action="upgradedb.php" method="POST">
	<p><b>Database Connection String:</b><br /> 
    	<input name="DSN" type="text" id="DSN" size="60" value="<?php if (defined("DATABASE")) echo DATABASE; ?>" style="width: 600px;" /></p>
	<p><input type="submit" value="Preview Database Upgrades" /></p>
</form>
</blockquote>
<?php

if (defined("DATABASE")) {
	?><h2>Upgrade Preview:</h2><?php
	
	$FinalSQL = "";
	
	$DBCONNECTION = DBOpen();
	if (is_string($DBCONNECTION)) {
		echo "<div class='Error'><b>Error:</b> Could not connect to the database: " . $DBCONNECTION . "</div>";
	}
	else {
	
		$result =& DBquery("SELECT DATABASE() as SCHEMANAME");
		if (is_string($result)) {
			echo "<div class='Error'><b>Error:</b> Failed to determine schema name: " . $result . "</div>";
		}
		else {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
			define("SCHEMA", $record['SCHEMANAME']);
			$result->free();
			
			$CurrentTables =& GetTables();
			CheckTables();
			DBClose();
		}
		
		?><h2>Upgrade Database:</h2><blockquote><?php
		
		if (empty($FinalSQL)) {
			echo "<div class='Success'>No changes to the database were necessary.</div>";
		}
		else {
			?>
			<textarea name="updatesql" cols="60" rows="15" readonly="readonly" onFocus="this.select();" onClick="this.select(); this.focus();"><?php echo htmlentities($FinalSQL); ?></textarea>
			<?php
		}
		
		?></blockquote><?php
	}
}

?>

</body>
</html>