<?xml version="1.0" encoding="UTF-8"?>
<DBSchema>
<?php
header("Content-Type: text/xml");

define("SQLLOGFILE", "");
define("DATABASE", "mysql://root:@localhost/vtcalendar");

require_once("DB.php");
require_once("../functions-db-generic.inc.php");

// Open the DB Connection
DBOpen();

// Process the Tables
GetTables();

// Close the DB Connection
DBClose();

function GetTables() {
	$result =& DBquery("SHOW TABLES");
	if (is_string($result)) {
		echo "Failed to get tables: " . $result;
	}
	else {
		$count = $result->numRows();
		for ($i = 0; $i < $count; $i++) {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			
			if (!isset($keyname)) {
				$keys = array_keys($record);
				$keyname = $keys[0];
			}
			
			ProcessTable($record[$keyname]);
		}
	}
}

function ProcessTable($TableName) {
	echo '<Table Name="'.$TableName.'">' ."\n";
	
	ProcessFields($TableName);
	ProcessKeys($TableName);
	
	echo "</Table>\n\n";
}

function ProcessFields($TableName) {
	$result =& DBquery("SHOW FIELDS FROM `" . $TableName . "`");
	
	if (is_string($result)) {
		echo "Failed to get fields: " + $result;
	}
	else {
		$count = $result->numRows();
		for ($i = 0; $i < $count; $i++) {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			
			echo "\t".'<Field Name="' . XMLEntities($record['Field']) . '" Type="' . XMLEntities($record['Type']) . '" NotNull="';
			echo (strtolower($record['Null']) == "no") ? "true" : "false";
			echo '" AutoIncrement="';
			echo (strpos($record['Extra'],"auto_increment") !== false) ? "true" : "false";
			echo '"/>'."\n";
		}
		$result->free();
	}
}

function ProcessKeys($TableName) {
	$result =& DBquery("SHOW INDEXES FROM `" . $TableName . "`");
	
	if (is_string($result)) {
		echo "Failed to get indexes: " + $result;
	}
	else {
		$count = $result->numRows();
		$keyName = "";
		for ($i = 0; $i < $count; $i++) {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			
			if ($keyName != $record['Key_name']) {
				if ($keyName != "") {
					if ($keyName == "PRIMARY") {
						echo "\t</PrimaryKey>\n";
					}
					else {
						echo "\t</Key>\n";
					}
					$keyName = "";
				}
				
				if ($record['Key_name'] == "PRIMARY") {
					echo "\t<PrimaryKey>\n";
				}
				else {
					echo "\t" . '<Key Name="' . XMLEntities($record['Key_name']) . '" Unique="';
					echo ($record['Non_unique'] != 0) ? "false" : "true";
					echo '">' . "\n";
				}
				
				$keyName = $record['Key_name'];
			}
			
			echo "\t\t".'<KeyField Name="' . XMLEntities($record['Column_name']) . '" SubPart="' . XMLEntities($record['Sub_part']) . '"/>' . "\n";
		}
		
		if ($keyName != "") {
			if ($record['Key_name'] == "PRIMARY") {
				echo "\t</PrimaryKey>\n";
			}
			else {
				echo "\t</Key>\n";
			}
		}
		$result->free();
	}
}

function XMLEntities($string)
{
	$string = preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '_privateXMLEntities("$0")', $string);
	return $string;
}

function _privateXMLEntities($num)
{
	$chars = array(
		128 => '&#8364;',
		130 => '&#8218;',
		131 => '&#402;',
		132 => '&#8222;',
		133 => '&#8230;',
		134 => '&#8224;',
		135 => '&#8225;',
		136 => '&#710;',
		137 => '&#8240;',
		138 => '&#352;',
		139 => '&#8249;',
		140 => '&#338;',
		142 => '&#381;',
		145 => '&#8216;',
		146 => '&#8217;',
		147 => '&#8220;',
		148 => '&#8221;',
		149 => '&#8226;',
		150 => '&#8211;',
		151 => '&#8212;',
		152 => '&#732;',
		153 => '&#8482;',
		154 => '&#353;',
		155 => '&#8250;',
		156 => '&#339;',
		158 => '&#382;',
		159 => '&#376;');
	$num = ord($num);
	return (($num > 127 && $num < 160) ? $chars[$num] : "&#".$num.";" );
} 

?>
</DBSchema>