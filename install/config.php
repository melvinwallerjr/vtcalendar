<?php
define('ALLOWINCLUDES', 'true');
define('CONFIGFILENAME', '../config.inc.php');

// Output a message if the calendar has already been configured.
if (file_exists(CONFIGFILENAME)) {
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<title>Calendar Already Configured</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<h1 class="txtWarn">Calendar Already Configured:</h1>
<p>Cannot configure calendar since <code>config.inc.php</code> already exists.<br />
Edit the file manually, or remove/rename <code>config.inc.php</code> and try again.</p>
</body></html>';
	exit;
}

require_once('../functions-io.inc.php');
require_once('../functions-misc.inc.php');
require_once('config-code.php');
require_once('config-functions.inc.php');

// An array of error messages about the submitted form values.
$FormErrors = array();

if (isset($_POST['DATABASE']) && $_POST['DATABASE'] != '') { setVar($Form_DSN, $_POST['DATABASE']); }
if (!isset($Form_DSN) && isset($_GET['DSN']) && $_GET['DSN'] != '') { setVar($Form_DSN, $_GET['DSN']); }
if (!isset($Form_DSN) && defined('DATABASE') && DATABASE != '') { setVar($Form_DSN, DATABASE); }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

<title>VTCalendar Configuration</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../scripts/general.js"></script>
<script type="text/javascript" src="scripts.js"></script>
<link type="text/css" rel="stylesheet" href="styles.css" />

</head><body><div id="wrapper">

<?php
// The user has submitted the form.
if (isset($_POST['SaveConfig'])) {
	$validUserIDReg = true;
	$assignMainAdmins = array();

	// Check if language file exists.
	if (!file_exists('../languages/' . $Form_LANGUAGE . '.inc.php')) {
		$FormErrors[count($FormErrors)] = 'Language file was not found. Make sure a file named <code>' . htmlspecialchars($Form_LANGUAGE, ENT_COMPAT, 'UTF-8') . '.inc.php</code> exists in the languages directory.';
	}

	// Check database connection string
	if (@(preg_match($Form_REGEXVALIDUSERID, '')) === false) {
		$lastError = error_get_last();
		$FormErrors[count($FormErrors)] = 'The regular expression entered for \'User ID Regular Expression\' is invalid.<br />
Error: <code>' . htmlspecialchars($lastError['message'], ENT_COMPAT, 'UTF-8') . '</code>';
		$validUserIDReg = false;
	}

	// Check that the SQL Log File can be appended to.
	if (!empty($Form_SQLLOGFILE)) {
		if (@($sqllog = fopen($Form_SQLLOGFILE, 'a')) === false) {
			$lastError = error_get_last();
			$FormErrors[count($FormErrors)] = 'Could not open the SQL Log File for writing. Make sure the Web server has access to write to that location.<br />
Error: <code>' . htmlspecialchars($lastError['message'], ENT_COMPAT, 'UTF-8') . '</code>';
		}
		else {
			fclose($sqllog);
		}
	}

	// Assign the submitted DSN to be used to connect to the database.
	define('DATABASE', $Form_DATABASE);

	// Check the DSN
	/*
	if (is_string($CONNECTION =& DBOpen())) {
		$FormErrors[count($FormErrors)] = 'Could not connect to the database using the supplied Database Connection String.<br />
Error: <code>' . htmlspecialchars($CONNECTION, ENT_COMPAT, 'UTF-8') . '</code>';
	}
	*/

	// Check LDAP Authentication fields.
	if ($Form_AUTH_LDAP) {
		if (!function_exists('ldap_connect')) {
				$FormErrors[count($FormErrors)] = 'PHP LDAP does not seem to be installed or configured. Make sure the extension is included in your php.ini file.';
		}
		else {
			$ldapfieldsok = true;
			if (empty($Form_LDAP_HOST)) {
				$FormErrors[count($FormErrors)] = 'You must specify the LDAP Host Name.';
				$ldapfieldsok = false;
			}
			if (!empty($Form_LDAP_HOST) && preg_match("/^ldap(s?):\\/\\//", $Form_LDAP_HOST) == 0 &&
			 empty($Form_LDAP_PORT)) {
				$FormErrors[count($FormErrors)] = 'You must specify the LDAP Port if the LDAP Host Name is not a URL.';
				$ldapfieldsok = false;
			}
			if (empty($Form_LDAP_USERFIELD)) {
				$FormErrors[count($FormErrors)] = 'You must specify the LDAP Username Attribute.';
			}
			if (empty($Form_LDAP_BASE_DN)) {
				$FormErrors[count($FormErrors)] = 'You must specify the LDAP Base DN.';
				$ldapfieldsok = false;
			}
			if ($Form_LDAP_BIND) {
				if (empty($Form_LDAP_BIND_USER)) {
					$FormErrors[count($FormErrors)] = 'You must specify the LDAP Username to bind as.';
					$ldapfieldsok = false;
				}
				if (empty($Form_LDAP_BIND_PASSWORD)) {
					$FormErrors[count($FormErrors)] = 'You must specify the LDAP Password for the LDAP Username.';
					$ldapfieldsok = false;
				}
			}
			if ($ldapfieldsok && $Form_LDAP_CHECK) {
				if (preg_match("/^ldap(s?):\\/\\//", $Form_LDAP_HOST) == 1) {
					$ldap = @(ldap_connect($Form_LDAP_HOST));
				}
				else {
					$ldap = @(ldap_connect($Form_LDAP_HOST, $Form_LDAP_PORT));
				}
				if (!isset($ldap) || $ldap === false) {
					$FormErrors[count($FormErrors)] = 'Could not connect to the LDAP server.';
				}
				elseif ($Form_LDAP_BIND &&
				 !@(ldap_bind($ldap, $Form_LDAP_BIND_USER, $Form_LDAP_BIND_PASSWORD))) {
					$lastError = error_get_last();
					$FormErrors[count($FormErrors)] = 'Could not bind to the LDAP server.<br />
Error: <code>' . htmlspecialchars($lastError['message'], ENT_COMPAT, 'UTF-8') . '</code>';
				}

				// Search for users name to dn
				if (($result = @(ldap_search($ldap, $Form_LDAP_BASE_DN, "(objectclass=*)",
				 array('dn'), 1, 1))) === false) {
					$lastError = error_get_last();
					$FormErrors[count($FormErrors)] = 'Could not perform a LDAP search. May not have permissions to search anonymously.<br />
Error: <code>' . htmlspecialchars($lastError['message'], ENT_COMPAT, 'UTF-8') . '</code>';
				}
			}

			//ProcessMainAdminAccountList($Form_LDAP_MAINADMINS, $assignMainAdmins);
		}
	}

	// URL and Secure URL
	if (empty($Form_BASEURL)) {
		$FormErrors[count($FormErrors)] = 'You must specify the Calendar Base URL.';
	}
	if (empty($Form_SECUREBASEURL)) {
		$FormErrors[count($FormErrors)] = 'You must specify the Secure Calendar Base URL.';
	}

	if ($Form_SHOW_UPCOMING_TAB && preg_match("/^[0-9]+$/", $Form_MAX_UPCOMING_EVENTS) == 0) {
		$FormErrors[count($FormErrors)] = 'The Max Upcoming Events must be an integer.';
	}

	// TODO: Disabled feature.
	/*
	if ($Form_AUTH_HTTP_CACHE && preg_match("/^[0-9]+$/", $Form_AUTH_HTTP_CACHE_EXPIRATIONDAYS) == 0) {
		$FormErrors[count($FormErrors)] = 'The HTTP Authentication Cache Expiration must be an integer.';
	}
	*/

	if (preg_match("/^[0-9]+$/", $Form_MAX_CACHESIZE_CATEGORYNAME) == 0) {
		$FormErrors[count($FormErrors)] = 'The Max Category Name Cache Size must be an integer.';
	}

	// Check HTTP Authentication fields.
	if ($Form_AUTH_HTTP) {
		if (empty($Form_AUTH_HTTP_URL)) {
			$FormErrors[count($FormErrors)] = 'You must specify the HTTP Authorizaton URL.';
		}
	}

	// Do not make any changes if errors occurred.
	if (count($FormErrors) == 0) {

		// Do not save the file if any errors were encountered after the DB changes
		if (count($FormErrors) == 0) {
			$ConfigOutput = '<?php
// ===========================================================================
// WARNING: Do not output ANYTHING in this file!
// This include file is called before session_start(), so it must never output any data.
// ===========================================================================

// For a full list of config options (and default values) see config-defaults.inc.php.' . "\n";
			BuildOutput($ConfigOutput);
			$ConfigOutput .= '?>';
			if (@file_put_contents(CONFIGFILENAME, $ConfigOutput) !== false) {
?>
<h1 class="txtGood">Configuration File Successfully Created</h1>

<p>If you want to make any configuration changes please modify the newly created file <code>config.inc.php</code>.</p>

<form action="upgradedb.php?fromconfig=yes" method="post">
<input type="hidden" name="DSN" value="<?php echo htmlspecialchars($Form_DSN, ENT_COMPAT, 'UTF-8'); ?>" />

If this is a <b>fresh install</b> or if you have <b>upgraded to a newer version</b> of VTCalendar, you should <input type="submit" value="Install or Upgrade the Database" />.

</form>
<?php
			}
			else {
?>
<div id="SaveFailed">

<p><strong>Save Failed:</strong><br />
The config file could not be saved. To manually create the <code>config.inc.php</code>, copy/paste the contents of the box below and paste it into a new file. Save that file to the vtcalendar folder and name it <code>config.inc.php</code>.</p>

<p><strong class="txtWarn">Security Notice:</strong><br />
It is recommended that you remove or secure the <code>/install</code> directory.</p>

<textarea id="code" name="code" cols="60" rows="15" readonly="readonly" onfocus="this.select();" onclick="this.select();this.focus();" style="width:100%; height:200px"><?php echo htmlspecialchars($ConfigOutput, ENT_COMPAT, 'UTF-8'); ?></textarea>

</div><!-- #SaveFailed -->
<?php
			}
		}
	}
}

if (!isset($_POST['SaveConfig']) || count($FormErrors) > 0) {
?>
<h1>VTCalendar Configuration:</h1>

<?php
	if (count($FormErrors) > 0) {
		echo '<p>Some errors were found:</p>' . "\n" . '<ul>', "\n";
		for ($i=0; $i < count($FormErrors); $i++) {
			echo '<li>' . $FormErrors[$i] . '</li>', "\n";
		}
		echo '</ul>', "\n";
	}
?>

<form name="ConfigForm" action="config.php" method="post">

<?php require('config-form.php'); ?>

<input type="submit" name="SaveConfig" value="Save Configuration" />

</form>

<script type="text/javascript">/* <![CDATA[ */
AddCheckDSNLink();
/* ]]> */</script>

<?php
}
?>

</div></body></html>
