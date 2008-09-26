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
<script type="text/javascript">
function verifyUpgrade() {
	return confirm("Are you sure you want to upgrade the database?");
}
</script>
</head>

<body>
<h1>Upgrade VTCalendar MySQL DB</h1>

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

if (isset($_POST['updatesql'])) {
	define("UPGRADESQL", $_POST['updatesql']);
}

?>
<h2>About this Page:</h2>
<blockquote>
<p>When upgrading VTCalendar, it is necessary to upgrade the database as well. This page will scan your current database and tell you what needs to be changed. You can then apply the changes to the database directly through this page, or copy/paste the necessary SQL into another program of your choice.</p>
<p><b style="color: #CC0000;">Backup Your Database!</b><br/>It is recommended that you backup your entire VTCalendar database before upgrading. Changes made by applying this upgrade CANNOT be undone without a backup.</p>
</blockquote>

<h2>Enter the Database Connection String:</h2>
<blockquote>
<form action="upgradedb.php" method="POST">
	<p><b>Database Connection String:</b><br /> 
    	<input name="DSN" type="text" id="DSN" size="60" value="<?php if (defined("DATABASE")) echo DATABASE; ?>" style="width: 600px;" /></p>
	<p><input type="submit" value="Preview Database Upgrades" /></p>
</form>
</blockquote>
<?php

if (isset($_GET['success'])) {
	?><h2>Upgrade Result:</h2><?php
	if ($_GET['success'] == "nochanges") {
		echo "<div class='Success'>No changes to the database were necessary.</div>";
	}
	else {
		echo "<div class='Success'><b>Success:</b> All upgrades were applied successfully!</div>";
	}
}
elseif (defined("DATABASE") && defined("UPGRADESQL")) {
	?><h2>Upgrade Result:</h2><?php
	
	$DBCONNECTION = DBOpen();
	if (is_string($DBCONNECTION)) {
		echo "<div class='Error'><b>Error:</b> Could not connect to the database: " . $DBCONNECTION . "</div>";
	}
	else {
		$queries = preg_split("/(\r\n\r\n)|(\n\n)/", UPGRADESQL);
		$queryError = false;
		
		for ($i = 0; $i < count($queries); $i++) {
			if (!trim($queries[$i]) == "") {
				$result =& DBquery($queries[$i]);
				if (is_string($result)) {
					$queryError = true;
					echo "<div class='Error'><b>Error:</b> Query # " . ($i+1) . " failed: " . $result . "</div>";
					?><textarea name="updatesql" cols="60" rows="5" readonly="readonly" onFocus="this.select();" onClick="this.select(); this.focus();"><?php echo htmlentities($queries[$i]); ?></textarea><?php
				}
				else {
					echo "<div class='Success'><b>Success:</b> Query # " . ($i+1) . " successful.</div>";
				}
			}
		}
		DBClose();
		
		if (!$queryError) {
			?><script type="text/javascript">location.replace("upgradedb.php?success=true")</script><?php
		}
	}
}
elseif (defined("DATABASE") && !defined("UPGRADESQL")) {
	?><h2>Upgrade Preview:</h2><p>The following is a preview of changes to the database that are needed.<br/>To apply any needed changes, proceed to the <a href="#Upgrade">Upgrade the Database</a> section at the bottom of this page.<?php
	
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
		
		?><h2><a name="Upgrade"></a>Upgrade Database:</h2><form action="upgradedb.php" method="post" onsubmit="return verifyUpgrade();"><input type="hidden" name="DSN" value="<?php echo DATABASE; ?>"/><blockquote><?php
		
		if (empty($FinalSQL)) {
			echo "<div class='Success'>No changes to the database were necessary.</div>";
			?><!--<script type="text/javascript">location.replace("upgradedb.php?success=nochanges")</script>--><?php
		}
		else {
			?>
			<p style="font-size: 18px; padding: 8px; background-color: #FFEEEE; border: 1px solid #FF3333;"><b>LAST WARNING!</b><br/>It is recommended that you backup your entire VTCalendar database before upgrading. Changes made by applying this upgrade CANNOT be undone without a backup.</p>
			<p>After reviewing the above upgrades you may <input type="submit" value="Upgrade the Database"/></p>
			<p style="font-size: 16px; font-weight: bold;">- or -</p>
			<div>If your account does not have permission to CREATE or ALTER tables,<br/>copy/paste the SQL code below to manually upgrade your database</div>
			<textarea name="updatesql" cols="60" rows="15" readonly="readonly" onFocus="this.select();" onClick="this.select(); this.focus();"><?php echo htmlentities($FinalSQL); ?></textarea>
			<?php
		}
		
		?></blockquote></form><?php
	}
}

?>

</body>
</html>