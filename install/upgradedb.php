<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Install or Upgrade VTCalendar Database (MySQL Only)</title>
<link href="styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
function verifyUpgrade() {
	return confirm("Are you sure you want to upgrade the database?");
}
</script>
</head>

<body>


<?php

if (!file_exists("../VERSION.txt")) die("VERSION.txt was not found. Make sure it exists in the VTCalendar folder.");
if (($version = file_get_contents("../VERSION.txt")) === false) die("VERSION.txt exists but could not be read. May not have read access to the file.");

if (file_exists("../VERSION-DBCHECKED.txt")) {
	if (($dbVersionChecked = file_get_contents("../VERSION-DBCHECKED.txt")) === false) die("VERSION-DBCHECKED.txt exists but could not be. May not have read access to the file.");
	if (trim($version) == trim($dbVersionChecked)) {
		echo "<h1 style='color: red;'>Database Already Installed or Upgraded:</h1>"
			."<p><a href='../VERSION-DBCHECKED.txt'><code>VERSION-DBCHECKED.txt</code></a> already matches <a href='../VERSION.txt'><code>VERSION.txt</code></a>.</p>"
			."<p>If you would like to run this script, remove the <code>VERSION-DBCHECKED.txt</code> file in the VTCalendar folder.</p></body></html>";
		exit;
		//die("VERSION-DBCHECKED.txt already matches VERSION.txt.<br><br>If you would like to run this script, remove the VERSION-DBCHECKED.txt file in the VTCalendar folder.");
	}
}
?>


<h1>Install or Upgrade VTCalendar Database (MySQL Only)</h1>

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
<p>If this is a <b>fresh VTCalendar install</b> this script will create the necessary VTCalendar tables.</p>
<p>If you are <b>upgrading VTCalendar</b> it is necessary to upgrade the database as well. This page will scan your current database schema and tell you what needs to be changed. You can then apply the changes to the database directly through this page, or copy/paste the necessary SQL into another program of your choice.</p>
<p><b style="color: #CC0000;">Backup Your Database!</b><br/>If you are upgrading VTCalendar it is recommended that you backup your entire VTCalendar database. Changes made by applying this upgrade CANNOT be undone without a backup.</p>
</blockquote>

<h2>Enter the Database Connection String:</h2>
<blockquote>
<form action="upgradedb.php" method="POST">
	<p><b>Database Connection String:</b><br /> 
    	<input name="DSN" type="text" id="DSN" size="60" value="<?php if (defined("DATABASE")) echo DATABASE; ?>" style="width: 600px;" /><br/>
    	<i>Example: mysql://user:password@localhost/vtcalendar</i></p>
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
	
	$versionRecorded = (file_put_contents("../VERSION-DBCHECKED.txt", $version) !== false);
	
	if (!$versionRecorded) {
		echo "<div class='Error'><b>Warning:</b> The <code>VERSION-DBCHECKED.txt</code> file could not be created/changed. To avoid people from accessing this page (and potentially compromising your database), copy the <code>VERSION.txt</code> file to <code>VERSION-DBCHECKED.txt</code>. On Linux the file is case-sensitive.</div>";
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
					?><textarea name="updatesql" cols="60" rows="5" readonly="readonly" onfocus="this.select();" onclick="this.select(); this.focus();"><?php echo htmlentities($queries[$i]); ?></textarea><?php
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
			
			// Get the current table data.
			if (($CurrentTables = GetTables()) !== false) {
				
				?><p>The following is a preview of changes to the database that are needed.<br/>To apply any needed changes, proceed to the <a href="#Upgrade">Upgrade the Database</a> section at the bottom of this page.</p><?php
				
				// Check the current table data vs the final table data.
				$changes = CheckTables();
		
				?><h2><a name="Upgrade"></a>Upgrade Database:</h2><form action="upgradedb.php" method="post" onsubmit="return verifyUpgrade();"><input type="hidden" name="DSN" value="<?php echo DATABASE; ?>"/><blockquote><?php
				
				if ($changes < 1) {
					echo "<div class='Success'>No changes to the database were necessary.</div>";
					
					$versionRecorded = (file_put_contents("../VERSION-DBCHECKED.txt", $version) !== false);
					
					if (!$versionRecorded) {
						echo "<div class='Error'><b>Warning:</b> The <code>VERSION-DBCHECKED.txt</code> file could not be created/changed. To avoid people from accessing this page (and potentially compromising your database), copy the <code>VERSION.txt</code> file to <code>VERSION-DBCHECKED.txt</code>. On Linux the file is case-sensitive.</div>";
					}
					
					// Show a cleaner success page if no changes or notifications were outputted.
					elseif ($changes == 0) {
						?><script type="text/javascript">location.replace("upgradedb.php?success=nochanges")</script><?php
					}
				}
				else {
					?>
					<p style="font-size: 18px; padding: 8px; background-color: #FFEEEE; border: 1px solid #FF3333;"><b>LAST WARNING!</b><br/>If you are upgrading VTCalendar, it is recommended that you backup your entire VTCalendar database. Changes made by applying this upgrade CANNOT be undone without a backup.</p>
					<p>After reviewing the above upgrades you may <input type="submit" value="Upgrade the Database"/></p>
					<p style="font-size: 16px; font-weight: bold;">- or -</p>
					<div>If your account does not have permission to CREATE or ALTER tables,<br/>copy/paste the SQL code below to manually upgrade your database</div>
					<textarea name="updatesql" cols="60" rows="15" readonly="readonly" onfocus="this.select();" onclick="this.select(); this.focus();"><?php echo htmlentities($FinalSQL); ?></textarea>
					<?php
				}
				
				?></blockquote></form><?php
			}
			DBClose();
		}
	}
}

?>

</body>
</html>