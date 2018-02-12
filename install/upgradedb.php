<?php
define('NOLOADDB', true);
define('NOSESSION', true);

@(include_once('../config.inc.php')) or
die ('<html><head>
<title>Config Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>config.inc.php was not found. See: <a href="./">VTCalendar Installation</a></p>
</body></html>');

require_once('../application.inc.php');
require_once('upgradedb-functions.php');
require_once('upgradedb-data.php');

@(include_once('../version.inc.php')) or
die ('<html><head>
<title>Version Not Found</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<h1>Version Not Found</h1>
<p>version.inc.php was not found or could not be read. Make sure it exists in the VTCalendar folder and it defines a constant named "VERSION".</p>
</body></html>');
if (!defined('VERSION')) {
	echo '<html><head>
<title>Version Not Defined</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<h1>Version Not Defined</h1>
<p>VERSION was not defined. Make sure version.inc.php defines a constant named "VERSION" (e.g. <code>define("VERSION" . "2.3.0");</code>).</p>
</body></html>';
	exit;
}

if (file_exists('../VERSION-DBCHECKED.txt')) {
	if (($dbVersionChecked = file_get_contents('../VERSION-DBCHECKED.txt')) === false) {
		echo '<html><head>
<title>Version Not Defined</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<p>VERSION-DBCHECKED.txt exists but could not be. May not have read access to the file.</p>
</body></html>';
		exit;
	}
	if (trim(VERSION) == trim($dbVersionChecked)) {
		echo '<html><head>
<title>Version Not Defined</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<h1 class="txtWarn">Database Already Installed or Upgraded:</h1>
<p>The database has already been checked for ' . VERSION . ' version.</p>
<p>If you would like to run this script, remove the <code>VERSION-DBCHECKED.txt</code> file in the VTCalendar folder.</p>
</body></html>';
		exit;
	}
}

$Submit_Preview = (isset($_POST['Submit_Preview']) && $_POST['Submit_Preview'] != '');
$Submit_Upgrade = (isset($_POST['Submit_Upgrade']) && $_POST['Submit_Upgrade'] != '');

if (isset($_POST['UpgradeSQL'])) { setVar($UpgradeSQL, $_POST['UpgradeSQL']); }
if (isset($_GET['Success'])) { setVar($Success, $_GET['Success']); }

if (isset($_POST['DBTYPE']) && preg_match("/^(mysql|postgres)$/", $_POST['DBTYPE'])) {
	setVar($Form_DBTYPE, $_POST['DBTYPE']);
}
if (isset($_GET['DBTYPE']) && preg_match("/^(mysql|postgres)$/", $_GET['DBTYPE'])) {
	setVar($Form_DBTYPE, $_GET['DBTYPE']);
}

if (isset($_POST['POSTGRESSCHEMA']) && $_POST['POSTGRESSCHEMA'] != '') {
	setVar($Form_POSTGRESSCHEMA, $_POST['POSTGRESSCHEMA']);
}
if (isset($_GET['POSTGRESSCHEMA']) && $_GET['POSTGRESSCHEMA'] != '') {
	setVar($Form_POSTGRESSCHEMA, $_GET['POSTGRESSCHEMA']);
}

if (isset($_POST['DSN']) && $_POST['DSN'] != '') { setVar($Form_DSN, $_POST['DSN']); }
if (isset($_GET['DSN']) && $_GET['DSN'] != '') { setVar($Form_DSN, $_GET['DSN']); }
if (!isset($Form_DSN) && defined('DATABASE') && DATABASE != '') { setVar($Form_DSN, DATABASE); }

// Flag if the all form fields have been submitted.
$FormIsComplete = (isset($Form_DBTYPE) && isset($Form_DSN) && isset($Form_POSTGRESSCHEMA));

// Set the field qualifier for SQL output
if (isset($Form_DBTYPE) && $Form_DBTYPE == 'postgres') { define('FIELDQUALIFIER', '"'); }
else { define('FIELDQUALIFIER', '`'); }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

<title>Install or Upgrade VTCalendar Database (MySQL 4.2+ or PostgreSQL 8+)</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="styles.css" />
<script type="text/javascript">/* <![CDATA[ */
function verifyUpgrade()
{
	return confirm("Are you sure you want to upgrade the database?");
}
/* ]]> */</script>

</head><body id="UpgradeDB"><div id="wrapper">

<h1>Install or Upgrade VTCalendar Database (MySQL 4.2+ or PostgreSQL 8+)</h1>

<?php
if (isset($Success)) {
	// Display the success screen if successful.
	echo '
<h2>Upgrade Result:</h2>' . "\n";
	if ($Success == 'nochanges') {
		echo '
<p class="Success">No changes to the database were necessary.</p>' . "\n";
	}
	else {
		echo '
<p class="Success"><strong>Success:</strong> All upgrades were applied successfully!</p>' . "\n";
	}
	echo '
<p><a href="./">&laquo; Return to the VTCalendar Installation page.</a></p>' . "\n";
	$versionRecorded = (file_put_contents('../VERSION-DBCHECKED.txt', VERSION) !== false);
	if (!$versionRecorded) {
		echo '
<p class="Error"><strong>Warning:</strong> The <code>VERSION-DBCHECKED.txt</code> file could not be created/changed. To avoid people from accessing this page (and potentially compromising your database), create a file named <code>VERSION-DBCHECKED.txt</code> in the VTCalendar folder that contains the text &quot;' . VERSION . '&quot; (without the quotes). On Linux the file name is case-sensitive.</p>' . "\n";
	}
}
elseif ($Submit_Preview && $FormIsComplete) {
	// Display the preview screen if the DSN was submitted.
	echo '<h2>Upgrade Preview:</h2>' . "\n";
	$FinalSQL = "";
	$DBCONNECTION =& DBOpen($Form_DSN);
	if (is_string($DBCONNECTION)) {
		echo '
<p class="Error"><strong>Error:</strong> Could not connect to the database: ' . $DBCONNECTION . '</p>' . "\n";
	}
	else {
		if ($Form_DBTYPE == 'postgres') {
			define('SCHEMA', $Form_POSTGRESSCHEMA);
		}
		else {
			$result =& DBquery("SELECT DATABASE() AS SCHEMANAME");
			if (is_string($result)) {
				echo '
<p class="Error"><strong>Error:</strong> Failed to determine schema name: ' . $result . '</p>' . "\n";
			}
			else {
				$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
				define('SCHEMA', $record['SCHEMANAME']);
				$result->free();
			}
		}

		// Get the DB version
		$result =& DBQuery("SELECT version() AS ver");
		if (is_string($result)) {
			echo '
<p class="Error"><strong>Error:</strong> Failed to determine database version: ' . $result . '</p>' . "\n";
		}
		else {
			$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
			if ($Form_DBTYPE == 'mysql') {
				$matchResult = preg_match("/^([\d]+\.[\d]+)/", $record['ver'], $matches);
				define('DBVERSIONOK', $matchResult && !empty($matches[1]) && intval($matches[1]) >= 4.2);
			}
			elseif ($Form_DBTYPE == 'postgres') {
				define('DBVERSIONOK', preg_match("/^PostgreSQL 8\./i", $record['ver']));
			}
			$result->free();
		}
		if (defined('SCHEMA') && defined('DBVERSIONOK')) {
			// Get the current table data.
			if (($CurrentTables = GetTables()) !== false) {
				echo '
<p>The following is a preview of changes to the database that are needed.<br />
To apply any needed changes, proceed to the <a href="#Upgrade">Upgrade the Database</a> section at the bottom of this page.</p>' . "\n";

				// Check the current table data vs the final table data.
				$changes = CheckTables();
				echo '
<h3>Records</h3>

<div class="pad">' . "\n";

				$InsertDefaultRecord_Calendar = false;
				$InsertDefaultRecord_Category = false;
				$InsertDefaultRecord_Sponsor = false;

				// Check if the default calendar records exist
				if (!array_key_exists('vtcal_calendar', $CurrentTables)) {
					echo '
<p class="Create Record"><strong>Insert Record:</strong> The <b>default calendar</b> is missing and will be created.</p>' . "\n";
					$InsertDefaultRecord_Calendar = true;
				}
				else {
					$result =& DBQuery("
SELECT
	id
FROM
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_calendar" . FIELDQUALIFIER . "
WHERE
	id='default'
");
					if (is_string($result)) {
						echo '
<p class="Error"><strong>Error:</strong> Could not SELECT from ' . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . '.' . FIELDQUALIFIER . 'vtcal_calendar' . FIELDQUALIFIER . ' to determine if default calendar exists: ' . $result . '</p>' . "\n";
						$changes += 0.0001;
					}
					else {
						if ($result->numRows() == 0) {
							echo '
<p class="Create Record"><strong>Insert Record:</strong> The <b>default calendar</b> is missing and will be created.</p>' . "\n";
							$InsertDefaultRecord_Calendar = true;
						}
						else {
							echo '
<p class="Success"><strong>OK:</strong> Default calendar exists.</p>' . "\n";
						}
						$result->free();
					}
				}

				if ($InsertDefaultRecord_Calendar) {
					$FinalSQL .= "
INSERT INTO
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_calendar" . FIELDQUALIFIER . "
	(
		id,
		name,
		title,
		language,
		htmlheader,
		header,
		footer,
		viewauthrequired,
		forwardeventdefault
	)
VALUES
	(
		'default',
		'- Main Calendar -',
		'Events Calendar',
		'en',
		'',
		'',
		'',
		0,
		0
	);
";
					$changes++;
				}

				// Check if the default calendar has categories
				if (!array_key_exists('vtcal_category', $CurrentTables)) {
					echo '
<p class="Create Record"><strong>Insert Record:</strong> The default calendar is missing <b>categories</b>, so one will be created.</p>' . "\n";
					$InsertDefaultRecord_Category = true;
				}
				else {
					$result =& DBQuery("
SELECT
	id
FROM
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_category" . FIELDQUALIFIER . "
WHERE
	calendarid='default'
");
					if (is_string($result)) {
						echo '
<p class="Error"><strong>Error:</strong> Could not SELECT from ' . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . '.' . FIELDQUALIFIER . 'vtcal_category' . FIELDQUALIFIER . ' to determine if categories exist for the default: ' . $result . '</p>' . "\n";
						$changes += 0.0001;
					}
					else {
						if ($result->numRows() == 0) {
							echo '
<p class="Create Record"><strong>Insert Record:</strong> The default calendar is missing <b>categories</b>, so one will be created.</p>' . "\n";
							$InsertDefaultRecord_Category = true;
						}
						else {
							echo '
<p class="Success"><strong>OK:</strong> At least one category exists for the default calendar.</p>' . "\n";
						}
						$result->free();
					}
				}

				if ($InsertDefaultRecord_Category) {
					$FinalSQL .= "
INSERT INTO
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_category" . FIELDQUALIFIER . "
	(
		calendarid,
		name
	)
VALUES
	(
		'default',
		'" . sqlescape(lang('default_category_name')) . "'
	);
";
					$changes++;
				}

				// Check if the default calendar has an admin sponsor.
				if (!array_key_exists('vtcal_sponsor', $CurrentTables)) {
					echo '
<p class="Create Record"><strong>Insert Record:</strong> The default calendar is missing the <b>admin sponsor</b>, so it will be created.</p>' . "\n";
					$InsertDefaultRecord_Sponsor = true;
				}
				else {
					$result =& DBQuery("
SELECT
	id
FROM
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_sponsor" . FIELDQUALIFIER . "
WHERE
	calendarid='default'
	AND
	admin='1'
");
					if (is_string($result)) {
						echo '
<p class="Error"><strong>Error:</strong> Could not SELECT from ' . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . '.' . FIELDQUALIFIER . 'vtcal_sponsor' . FIELDQUALIFIER . ' to determine if the admin sponsor exists for the default calendar: ' . $result . '</p>' . "\n";
						$changes += 0.0001;
					}
					else {
						if ($result->numRows() == 0) {
							echo '
<p class="Create Record"><strong>Insert Record:</strong> The default calendar is missing the <b>admin sponsor</b>, so it will be created.</p>' . "\n";
							$InsertDefaultRecord_Sponsor = true;
						}
						else {
							echo '
<p class="Success"><b>OK:</b> The admin sponsor exists for the default calendar.</p>' . "\n";
						}
						$result->free();
					}
				}

				if ($InsertDefaultRecord_Sponsor) {
					$FinalSQL .= "
INSERT INTO
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_sponsor" . FIELDQUALIFIER . "
	(
		calendarid,
		name,
		url,
		email,
		admin
	)
VALUES
	(
		'default',
		'" . sqlescape(lang('default_sponsor_name')) . "',
		'',
		'',
		1
	);
";
					$changes++;
				}

				// Check if the URL column exists in the vtcal_event table.
				if (array_key_exists('vtcal_event', $CurrentTables) &&
				 array_key_exists('url', $CurrentTables['vtcal_event']['Fields'])) {

					// Check if the URL field contains any data.
					$result =& DBQuery("
SELECT
	count(*) AS reccount
FROM
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_event" . FIELDQUALIFIER . "
WHERE
	url != ''
");
					if (is_string($result)) {
						echo '
<p class="Error"><strong>Error:<strong> Could not SELECT from ' . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . '.' . FIELDQUALIFIER . 'vtcal_event' . FIELDQUALIFIER . ' to determine data exists in the <code>url</code> column: ' . $result . '</p>' . "\n";
						$changes += 0.0001;
					}
					else {
						// Concat the description and URL column if the URL columns contains data.
						$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
						if ($record['reccount'] > 0) {
							echo '
<p class="Alter Record"><strong>Update Records:</strong> Data exists in the <code>url</code> column in the <code>vtcal_event</code> table. The <code>url</code> column will be appended to the end of the description column, and then it will be set to an empty string.</p>' . "\n";
							if ($Form_DBTYPE == 'mysql') {
								$FinalSQL .= "
UPDATE
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_event" . FIELDQUALIFIER . "
SET
	description = concat(
		description,
		'\\n\\n',
		'" . sqlescape(lang('more_information')) . ": ',
		url
	),
	url = ''
WHERE
	URL != '';
";
							}
							elseif ($Form_DBTYPE == 'postgres') {
								$FinalSQL .= "
UPDATE
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_event" . FIELDQUALIFIER . "
SET
	description = description || E'\\n\\n' || '" . sqlescape(lang('more_information')) . ": ' || url,
	url = ''
WHERE
	URL != '';
";
							}
							$changes++;
						}
						$result->free();
					}
				}

				// Check if the URL column exists in the vtcal_event_public table.
				if (array_key_exists('vtcal_event_public', $CurrentTables) &&
				 array_key_exists('url', $CurrentTables['vtcal_event_public']['Fields'])) {

					// Check if the URL field contains any data.
					$result =& DBQuery("
SELECT
	count(*) AS reccount
FROM
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_event_public" . FIELDQUALIFIER . "
WHERE
	url != ''
");
					if (is_string($result)) {
						echo '
<p class="Error"><strong>Error:</strong> Could not SELECT from ' . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . '.' . FIELDQUALIFIER . 'vtcal_event_public' . FIELDQUALIFIER . ' to determine data exists in the <code>url</code> column: ' . $result . '</p>' . "\n";
						$changes += 0.0001;
					}
					else {
						// Concat the description and URL column if the URL columns contains data.
						$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
						if ($record['reccount'] > 0) {
							echo '
<p class="Alter Record"><strong>Update Records:</strong> Data exists in the <code>url</code> column in the <code>vtcal_event_public</code> table. The <code>url</code> column will be appended to the end of the description column, and then it will be set to an empty string.</p>' . "\n";
							if ($Form_DBTYPE == 'mysql') {
								$FinalSQL .= "
UPDATE
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_event_public" . FIELDQUALIFIER . "
SET
	description = concat(
		description,
		'\\n\\n',
		'" . sqlescape(lang('more_information')) . ": ',
		url
	),
	url = ''
WHERE
	URL != '';
";
							}
							elseif ($Form_DBTYPE == 'postgres') {
								$FinalSQL .= "
UPDATE
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_event_public" . FIELDQUALIFIER . "
SET
	description = description || E'\\n\\n' || '" . sqlescape(lang('more_information')) . ": ' || url,
	url = ''
WHERE
	URL != '';
";
							}
							$changes++;
						}
						$result->free();
					}
				}

				// Check if the URL column exists in the vtcal_template table.
				if (array_key_exists('vtcal_template', $CurrentTables) &&
				 array_key_exists('url', $CurrentTables['vtcal_template']['Fields'])) {

					// Check if the URL field contains any data.
					$result =& DBQuery("
SELECT
	count(*) AS reccount
FROM
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_template" . FIELDQUALIFIER . "
WHERE
	url != ''
");
					if (is_string($result)) {
						echo '
<p class="Error"><strong>Error:</strong> Could not SELECT from ' . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . '.' . FIELDQUALIFIER . 'vtcal_template' . FIELDQUALIFIER . ' to determine data exists in the <code>url</code> column: ' . $result . '</p>' . "\n";
						$changes += 0.0001;
					}
					else {
						// Concat the description and URL column if the URL columns contains data.
						$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
						if ($record['reccount'] > 0) {
							echo '
<p class="Alter Record"><strong>Update Records:</strong> Data exists in the <code>url</code> column in the <code>vtcal_template</code> table. The <code>url</code> column will be appended to the end of the description column, and then it will be set to an empty string.</p>' . "\n";
							if ($Form_DBTYPE == 'mysql') {
								$FinalSQL .= "
UPDATE
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_template" . FIELDQUALIFIER . "
SET
	description = concat(
		description,
		'\\n\\n',
		'" . sqlescape(lang('more_information')) . ": ',
		url
	),
	url = ''
WHERE
	URL != '';
";
							}
							elseif ($Form_DBTYPE == 'postgres') {
								$FinalSQL .= "
UPDATE
	" . FIELDQUALIFIER . SCHEMA . FIELDQUALIFIER . "." .
	 FIELDQUALIFIER . "vtcal_template" . FIELDQUALIFIER . "
SET
	description = description || E'\\n\\n' || '" . sqlescape(lang('more_information')) . ": ' || url,
	url = ''
WHERE
	URL != '';
";
							}
							$changes++;
						}
						$result->free();
					}
				}
				echo '
</div><br /><!-- .pad -->

<h2><a name="Upgrade"></a>Upgrade Database:</h2>

<form action="upgradedb.php" method="post" onsubmit="return verifyUpgrade();">
<input type="hidden" name="DBTYPE" value="' . htmlspecialchars($Form_DBTYPE, ENT_COMPAT, 'UTF-8') . '" />
<input type="hidden" name="DSN" value="' . htmlspecialchars($Form_DSN, ENT_COMPAT, 'UTF-8') . '" />
<input type="hidden" name="POSTGRESSCHEMA" value="' . htmlspecialchars($Form_POSTGRESSCHEMA, ENT_COMPAT, 'UTF-8') . '" />

<div class="pad">' . "\n";
				if ($changes < 1) {
					echo '
<p class="Success">No changes to the database were necessary.</p>' . "\n";

					// Show a cleaner success page if no changes or notifications were outputted.
					if ($changes == 0) {
						echo '
<script type="text/javascript">/* <![CDATA[ */
location.replace("upgradedb.php?Success=nochanges")
/* ]]> */</script>' . "\n";
					}
					else {
						$versionRecorded = (file_put_contents('../VERSION-DBCHECKED.txt', VERSION) !== false);
						if (!$versionRecorded) {
							echo '
<p class="Error"><strong>Warning:</strong> The <code>VERSION-DBCHECKED.txt</code> file could not be created/changed. To avoid people from accessing this page (and potentially compromising your database), create a file named <code>VERSION-DBCHECKED.txt</code> in the VTCalendar folder that contains the text &quot;' . VERSION . '&quot; (without the quotes). On Linux the file name is case-sensitive.</p>' . "\n";
						}
					}
				}
				else {
					echo '
<p class="warning"><strong>LAST WARNING!</strong><br/>
If you are upgrading VTCalendar, it is recommended that you backup your entire VTCalendar database. Changes made by applying this upgrade CANNOT be undone without a backup.</p>

<p>After reviewing the above upgrades you may <input type="submit" name="Submit_Upgrade" value="Upgrade the Database" /></p>

<p><big><strong>- or -</strong></big></p>

<p>If your account does not have permission to CREATE or ALTER tables,<br />
copy/paste the SQL code below to manually upgrade your database</p>
<textarea name="UpgradeSQL" cols="60" rows="15" readonly="readonly" onfocus="this.select();" onclick="this.select();this.focus();">' . htmlspecialchars($FinalSQL, ENT_COMPAT, 'UTF-8') . '</textarea>' . "\n";
				}
				echo '
</div><!-- .pad -->
</form>' . "\n";
			}
			DBClose();
		}
	}
}
elseif ($Submit_Upgrade && $FormIsComplete && isset($UpgradeSQL)) {
	// Upgrade the database if the DSN and SQL were submitted.
	echo '<h2>Upgrade Result:</h2>' . "\n";
	$DBCONNECTION =& DBOpen($Form_DSN);
	if (is_string($DBCONNECTION)) {
		echo '
<div class="Error"><strong>Error:</strong> Could not connect to the database: ' . $DBCONNECTION . '</div>' . "\n";
	}
	else {
		$queries = preg_split("/((\r\n\r\n)|(\n\n))/", $UpgradeSQL);
		$queryError = false;
		for ($i=0; $i < count($queries); $i++) {
			if (trim($queries[$i]) != '') {
				$result =& DBquery($queries[$i], null, true);
				if (is_string($result)) {
					$queryError = true;
					echo '
<div class="Error">

<form action="javascript:void(null)" method="get">
<p><strong>Error:<strong> Query # ' . ($i + 1) . ' failed: ' . $result . '</p>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
<tbody><tr>
<td><p><label for="query' . $i . '"><strong>Query:</strong></label></p>
<textarea id="query' . $i . '" name="query" cols="60" rows="5" readonly="readonly" onfocus="this.select();" onclick="this.select();this.focus();" style="width:100%">' . htmlspecialchars($queries[$i], ENT_COMPAT, 'UTF-8') . '</textarea></td>';
					if (isset($GLOBALS['DebugInfo']) && $GLOBALS['DebugInfo'] != '') {
						echo '
<td width="50%"><p><label for="detail' . $i . '"><strong>Error Details:</strong></label></p>
<textarea id="detail' . $i . '" name="detail" cols="60" rows="5" readonly="readonly" onfocus="this.select();" onclick="this.select();this.focus();" style="width:100%">' . htmlspecialchars(str_replace($queries[$i], '', $GLOBALS['DebugInfo']), ENT_COMPAT, 'UTF-8') . '</textarea></td>';
						$GLOBALS['DebugInfo'] = '';
					}
					echo '
</tr></tbody>
</table>
</form>

</div><br /><!-- .Error -->' . "\n";
				}
				else {
					echo '
<p class="Success"><strong>Success:</strong> Query # ' . ($i + 1) . ' successful.</p>' . "\n";
				}
			}
		}
		DBClose();
		if (!$queryError) {
			echo '
<script type="text/javascript">/* <![CDATA[ */
location.replace("upgradedb.php?Success=true");
/* ]]> */</script>';
		}
	}
}
else {
	// Otherwise display the intro form.
	echo '
<h2>About this Page:</h2>

<div class="pad">

<p>If this is a <b>fresh VTCalendar install</b> this script will create the necessary VTCalendar tables.</p>

<p>If you are <b>upgrading VTCalendar</b> it is necessary to upgrade the database as well. This page will scan your current database schema and tell you what needs to be changed. You can then apply the changes to the database directly through this page, or copy/paste the necessary SQL into another program of your choice.</p>

<p><strong class="txtWarn">Backup Your Database!</strong><br />
If you are upgrading VTCalendar it is recommended that you backup your entire VTCalendar database. Changes made by applying this upgrade CANNOT be undone without a backup.</p>

</div><!-- .pad -->

<h2>Enter the Database Connection String:</h2>

<script type="text/javascript">/* <![CDATA[ */
function ToggleBlocks()
{
	if (document.getElementById) {
		var objDBTYPE = document.getElementById("DBTYPE");
		var objPOSTGRESSCHEMA_Block = document.getElementById("POSTGRESSCHEMA_Block");
		var objMySQLExample = document.getElementById("mysql_example");
		var objPostgresExample = document.getElementById("postgres_example");
		if (objDBTYPE) {
			if (objPOSTGRESSCHEMA_Block) {
				objPOSTGRESSCHEMA_Block.style.display = (objDBTYPE.value == "postgres")? "" : "none";
			}
			if (objMySQLExample && objPostgresExample) {
				if (objDBTYPE.value == "mysql") {
					objMySQLExample.style.display = "";
					objPostgresExample.style.display = "none";
				}
				else {
					objMySQLExample.style.display = "none";
					objPostgresExample.style.display = "";
				}
			}
		}
	}
}
/* ]]> */</script>

<div class="pad">

<form action="upgradedb.php" method="post">

<p><strong>Select Database Type:</strong><br />
<select id="DBTYPE" name="DBTYPE" onchange="ToggleBlocks()" onclick="ToggleBlocks()">
<option value=""' . (!isset($Form_DBTYPE)? ' selected="selected"' : '') . '>(Select One)</option>
<option value="mysql"' . ((isset($Form_DBTYPE) && $Form_DBTYPE == 'mysql')? ' selected="selected"' : '') . '>MySQL</option>
<option value="postgres"' . ((isset($Form_DBTYPE) && $Form_DBTYPE == 'postgres')? ' selected="selected"' : '') . '>PostgreSQL</option>
</select></p>

<p><strong>Database Connection String:</strong><br />
<input type="text" id="DSN" name="DSN" size="60" value="' . (isset($Form_DSN)? htmlspecialchars($Form_DSN, ENT_COMPAT, 'UTF-8') : '') . '" style="width:600px" /><br />
<i id="mysql_example">Syntax: mysql://user:password@host/database</i>
<i id="postgres_example">Syntax: pgsql://user:password@host/database</i></p>

<p id="POSTGRESSCHEMA_Block"><strong>Schema (PostgreSQL Only):</strong><br />
<input type="text" id="POSTGRESSCHEMA" name="POSTGRESSCHEMA" value="' . (isset($Form_POSTGRESSCHEMA)? htmlspecialchars($Form_POSTGRESSCHEMA, ENT_COMPAT, 'UTF-8') : 'public') . '" size="60" style="width:200px" /><br />
<i>Example: public</i></p>

<p><input type="submit" name="Submit_Preview" value="Preview Database Upgrades" /></p>

</form>

</div><!-- .pad -->

<script type="text/javascript">/* <![CDATA[ */
ToggleBlocks();
/* ]]> */</script>' . "\n";
}
?>

</div></body></html>
