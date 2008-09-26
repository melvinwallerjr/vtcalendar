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
div {
	padding: 5px;
}
div.Success, div.Table, div.Field, div.PrimaryKey, div.Index {
	background-repeat: no-repeat;
	background-position: 5px 5px;
	padding-left: 30px;
}
div.Success {
	background-image: url(success.png);
	background-color: #DDDDFF;
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

define("SQLLOGFILE", "");
define("DATABASE", "mysql://root:@localhost/vtcalendar2-2-2");

require_once("DB.php");
require_once("../functions-db-generic.inc.php");

$FinalSQL = "";

require_once("upgradedb-data.php");

$CreateTable['vtcal_adminuser'] = "CREATE `vtcal_adminuser` ()";
$CreateTable['vtcal_auth'] = "CREATE `vtcal_auth` ()";

function GetTables() {
	$TableData = array();
	
	$result =& DBquery("SHOW TABLES");
	if (is_string($result)) {
		echo "<div class='Error'><b>Error:</b> Failed to get tables: " . $result . "</div>";
		return false;
	}
	else {
		$count = $result->numRows();
		
		for ($i = 0; $i < $count; $i++) {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			
			if (!isset($keyname)) {
				$keys = array_keys($record);
				$keyname = $keys[0];
			}
			
			GetTableData($TableData, $record[$keyname]);
		}
		$result->free();
	}
	
	return $TableData;
}

function GetTableData(&$TableData, $TableName) {
	$TableData[$TableName] = array();
	
	$result =& DBquery("SHOW FIELDS FROM `" . $TableName . "`");
	
	if (is_string($result)) {
		echo "<div class='Error'><b>Error:</b> Failed to get fields for `<code>" . $TableName . "</code>`: " . $result . "</div>";
		return false;
	}
	else {
		$TableData[$TableName]['Fields'] = array();
		$TableData[$TableName]['Keys'] = array();
		
		$count = $result->numRows();
		for ($i = 0; $i < $count; $i++) {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			
			$TableData[$TableName]['Fields'][$record['Field']]['Type'] = $record['Type'];
			$TableData[$TableName]['Fields'][$record['Field']]['NotNull'] = strtolower($record['Null']) == "no";
			$TableData[$TableName]['Fields'][$record['Field']]['AutoIncrement'] = strpos($record['Extra'],"auto_increment") !== false;
		}
		$result->free();
	}
	
	$result =& DBquery("SHOW INDEXES FROM `" . $TableName . "`");
	
	if (is_string($result)) {
		echo "<div class='Error'><b>Error:</b> Failed to get indexes for `<code>" . $TableName . "</code>`: " . $result . "</div>";
		return false;
	}
	else {
		$count = $result->numRows();
		for ($i = 0; $i < $count; $i++) {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			
			$TableData[$TableName]['Keys'][$record['Key_name']]['Unique'] = !($record['Non_unique'] != 0);
			$TableData[$TableName]['Keys'][$record['Key_name']]['Fields'][$record['Column_name']] = empty($record['Sub_part']) ? "" : $record['Sub_part'];
		}
		$result->free();
	}
}

function CheckTables() {
	global $CurrentTables, $FinalTables;
	
	$CurrentTableNames = array_keys($CurrentTables);
	$FinalTableNames = array_keys($FinalTables);
	
	// Loop through the current tables to see what can be dropped.
	for ($i = 0; $i < count($CurrentTableNames); $i++) {
		if (!array_key_exists($CurrentTableNames[$i], $FinalTables)) {
			echo "<div class='Unused Table'><b>Unused Table Notice:</b> The `<code>" . $CurrentTableNames[$i] . "</code>` table is not used by VTCalendar (unless you've made moficiations).</div>";
		}
	}
	
	// Loop through the final tables to see what is missing.
	for ($i = 0; $i < count($FinalTableNames); $i++) {
		if (!array_key_exists($FinalTableNames[$i], $CurrentTables)) {
			echo "<div class='Create Table'><b>Create Table:</b> The `<code>" . $FinalTableNames[$i] . "</code>` table is missing and will be created.</div>";
			CreateTable($FinalTableNames[$i]);
		}
		else {
			CheckTable($FinalTableNames[$i]);
		}
	}
}

function CreateTable($TableName) {
	global $FinalTables;

	$sql = "";
	
	$FieldNames = array_keys($FinalTables[$TableName]['Fields']);
	for ($i = 0; $i < count($FieldNames); $i++) {
		if ($sql != "") {
			$sql .= ",";
		}
		$sql .= "\n\t`" . $FieldNames[$i] . "` " . GetFieldSQL($FinalTables, $TableName, $FieldNames[$i]);
	}
		
	$KeyNames = array_keys($FinalTables[$TableName]['Keys']);
	for ($i = 0; $i < count($KeyNames); $i++) {
		if ($sql != "") {
			$sql .= ",";
		}
		if ($KeyNames[$i] == "PRIMARY") {
			$sql .= "\n\t" . GetIndexFieldSQL($FinalTables, $TableName, $KeyNames[$i]);
		}
		else {
			$sql .= "\n\t" . GetIndexFieldSQL($FinalTables, $TableName, $KeyNames[$i]);
		}
	}
	
	$sql = "CREATE TABLE `" . SCHEMA . "`.`" . $TableName . "` (" . $sql . "\n);\n\n";

	$GLOBALS['FinalSQL'] .= $sql;
}

function CheckTable($TableName) {
	global $CurrentTables, $FinalTables;
	
	$CurrentTableFields = array_keys($CurrentTables[$TableName]['Fields']);
	$FinalTablesFields = array_keys($FinalTables[$TableName]['Fields']);
	
	$AlterFieldSQL = "";
	
	// Loop through the current table fields to see what can be dropped.
	for ($i = 0; $i < count($CurrentTableFields); $i++) {
		if (!array_key_exists($CurrentTableFields[$i], $FinalTables[$TableName]['Fields'])) {
			echo "<div class='Unused Field'><b>Unused Field Notice:</b> The `<code>" . $CurrentTableFields[$i] . "</code>` field in the `<code>" . $TableName . "</code>` table is not used by VTCalendar (unless you've made moficiations).</div>";
		}
	}
	
	// Loop through the final table fields to see what is missing.
	for ($i = 0; $i < count($FinalTablesFields); $i++) {
		if (!array_key_exists($FinalTablesFields[$i], $CurrentTables[$TableName]['Fields'])) {
			echo "<div class='Create Field'><b>New Field:</b> The `<code>" . $FinalTablesFields[$i] . "</code>` field in the `<code>" . $TableName . "</code>` table is missing and will be created as `<code>" . GetFieldSQL($FinalTables, $TableName, $FinalTablesFields[$i]) . "</code>`.</div>";
			
			if (!empty($AlterFieldSQL)) {
				$AlterFieldSQL .= ", \n";
			}
			$AlterFieldSQL .= "\tADD COLUMN `" . $FinalTablesFields[$i] . "` " . GetFieldSQL($FinalTables, $TableName, $FinalTablesFields[$i]);
			//TODO: Add 'AFTER `abccolumn`'
		}
		else {
			
			if (!CheckField($TableName, $FinalTablesFields[$i])) {
				if (!empty($AlterFieldSQL)) {
					$AlterFieldSQL .= ", \n";
				}
				$AlterFieldSQL .= "\tMODIFY COLUMN `" . $FinalTablesFields[$i] . "` " . GetFieldSQL($FinalTables, $TableName, $FinalTablesFields[$i]);
			}
		}
	}
	
	$CurrentTableIndexes = array_keys($CurrentTables[$TableName]['Keys']);
	$FinalTablesIndexes = array_keys($FinalTables[$TableName]['Keys']);
	
	// Loop through the current table indexes to see what can be dropped.
	for ($i = 0; $i < count($CurrentTableIndexes); $i++) {
		if (!array_key_exists($CurrentTableIndexes[$i], $FinalTables[$TableName]['Keys'])) {
			echo "<div class='Unused Index'><b>Unused Index Notice:</b> The `<code>" . $CurrentTableIndexes[$i] . "</code>` index in the `<code>" . $TableName . "</code>` table is not specified by VTCalendar (unless you've made moficiations).</div>";
		}
	}
	
	// Loop through the final table indexes to see what is missing.
	for ($i = 0; $i < count($FinalTablesIndexes); $i++) {
		$addIndex = false;
		$modifyIndex = false;
		
		// The index does not exist.
		if (!array_key_exists($FinalTablesIndexes[$i], $CurrentTables[$TableName]['Keys'])) {
			echo "<div class='Create " . ($FinalTablesIndexes[$i] == "PRIMARY" ? "PrimaryKey" : "Index") . "'><b>New " . ($FinalTablesIndexes[$i] == "PRIMARY" ? "Primary Key" : "Index") . ":</b> The " . ($FinalTablesIndexes[$i] == "PRIMARY" ? "primary key" : "`<code>" . $FinalTablesIndexes[$i] . "</code>` index") . " in the `<code>" . $TableName . "</code>` table is missing and will be created as `<code>" . GetIndexFieldSQL($FinalTables, $TableName, $FinalTablesIndexes[$i]) . "</code>`.</div>";
			$addIndex = true;
		}
		
		// The index exists and needs to be changed.
		elseif (!CheckIndex($TableName, $FinalTablesIndexes[$i])) {
			$modifyIndex = true;
		}
		
		// Drop and add the recreate the index if it needs to be added/changed.
		if ($addIndex || $modifyIndex) {
			if (!empty($AlterFieldSQL)) $AlterFieldSQL .= ", \n";
			
			$AlterFieldSQL .= "\t";
			
			if ($modifyIndex) {
				// The PRIMARY KEY has a different syntax when being dropped.
				if ($FinalTablesIndexes[$i] == "PRIMARY") {
					$AlterFieldSQL .= "DROP PRIMARY KEY, ";
				}
				
				// Normal synatx for dropping indexes.
				else {
					$AlterFieldSQL .= "DROP INDEX `" . $FinalTablesIndexes[$i] . "`, ";
				}
			}
			
			// Add the index.
			$AlterFieldSQL .= "ADD " . GetIndexFieldSQL($FinalTables, $TableName, $FinalTablesIndexes[$i]);
		}
	}
	
	// Add the ALTER TABLE header to the SQL for this table, if there were any changes.
	if ($AlterFieldSQL != "") {
		$GLOBALS['FinalSQL'] .= "ALTER TABLE `" . SCHEMA . "`.`" . $TableName . "` \n" . $AlterFieldSQL . ";\n\n";
	}
	
	return true;
}

function CheckField($TableName, $FieldName) {
	global $CurrentTables, $FinalTables;
	
	$CurrentField = $CurrentTables[$TableName]['Fields'][$FieldName];
	$FinalField = $FinalTables[$TableName]['Fields'][$FieldName];
	
	if ($CurrentField['Type'] != $FinalField['Type']
		|| $CurrentField['NotNull'] != $FinalField['NotNull']
		|| $CurrentField['AutoIncrement'] != $FinalField['AutoIncrement']) {
		
		echo "<div class='Alter Field'><b>Alter Field:</b> The `<code>" . $FieldName . "</code>` field in the `<code>" . $TableName . "</code>` table needs to be altered from `<code>" . GetFieldSQL($CurrentTables, $TableName, $FieldName) . "</code>` to `<code>" . GetFieldSQL($FinalTables, $TableName, $FieldName) . "</code>`.</div>";
		return false;
	}
	return true;
}

function CheckIndex($TableName, $IndexName) {
	global $CurrentTables, $FinalTables;
	
	$CurrentIndex = $CurrentTables[$TableName]['Keys'][$IndexName];
	$FinalIndex = $FinalTables[$TableName]['Keys'][$IndexName];
	
	if (GetIndexFieldSQL($CurrentTables, $TableName, $IndexName) != GetIndexFieldSQL($FinalTables, $TableName, $IndexName)) {
		
		echo "<div class='Alter " . ($IndexName == "PRIMARY" ? "PrimaryKey" : "Index") . "'><b>Alter " . ($IndexName == "PRIMARY" ? "Primary Key" : "Index") . ":</b> The `<code>" . $IndexName . "</code>` index in the `<code>" . $TableName . "</code>` table needs to be altered from `<code>" . GetIndexFieldSQL($CurrentTables, $TableName, $IndexName) . "</code>` to `<code>" . GetIndexFieldSQL($FinalTables, $TableName, $IndexName) . "</code>`.</div>";
		return false;
	}
	return true;
}

function CheckIndexFields($TableName, $IndexName) {
	return true;
}

function GetFieldSQL(&$TableData, $TableName, $FieldName) {
	$Field = $TableData[$TableName]['Fields'][$FieldName];
	
	$sql = $Field['Type'];
	if ($Field['NotNull']) $sql .= " NOT NULL";
	if ($Field['AutoIncrement']) $sql .= " auto_increment";
	
	return $sql;
}

function GetIndexFieldSQL(&$TableData, $TableName, $IndexName) {
	$Index = $TableData[$TableName]['Keys'][$IndexName];
	$IndexFields = array_keys($Index['Fields']);
	
	$sql = "";
	for ($i = 0; $i < count($IndexFields); $i++) {
		if ($i >= 1) {
			$sql .= ", ";
		}
	
		$subPart = $Index['Fields'][$IndexFields[$i]];
		
		$sql .= $IndexFields[$i];
		if (!empty($subPart)) $sql .= "(" . $subPart . ")";
	}
	
	if ($IndexName == 'PRIMARY') {
		return "PRIMARY KEY (" . $sql . ")";
	}
	else {
		if ($Index['Unique']) {
			return "UNIQUE INDEX `" . $IndexName . "` (" . $sql . ")";
		}
		else {
			return "INDEX `" . $IndexName . "` (" . $sql . ")";
		}
	}
}

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
	
	if (empty($FinalSQL)) {
		echo "<div class='Success'><b>Success:</b> No changes to the database were necessary.</div>";
	}
	else {
		?><hr><pre><?php echo htmlentities($FinalSQL); ?></pre><?php
	}
}

?>

</body>
</html>