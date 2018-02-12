<?php
function checknewpassword(&$user)
{ // Make sure the password meets standards for a new password (e.g. not the same as their old password
	/* TODO: Include more sophisticated constraints */
	if ($user['newpassword1'] != $user['newpassword2']) { return 1; }
	elseif (empty($user['newpassword1']) || strlen($user['newpassword1']) < 5) { return 2; }
	return 0;
}

function checkoldpassword(&$user, $userid)
{ // Verify the  user's old password in the database
	$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_user
WHERE
	id='" . sqlescape($userid) . "'
");
	$data =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	return ($data['password'] != crypt($user['oldpassword'], $data['password']));
}

function displaylogin($errormsg='')
{ // display login screen and errormsg (if exists)
	global $eventid, $httpreferer, $authsponsorid;
	// Do not show the login if asked not to.
	if (defined('HIDELOGIN')) { return; }
	pageheader(lang('login', false), 'Update');
	if (CUSTOM_LOGIN_HTML) { contentsection_begin(); }
	else {
		echo '
<table border="0" cellspacing="0" cellpadding="8">
<tbody><tr><td class="pad" style="border:1px solid ' . $_SESSION['COLOR_BORDER'] . ';">
<h2>' . lang('login') . ':</h2>' . "\n";
	}
	// Capture the login form if the login page is customized.
	if (CUSTOM_LOGIN_HTML) { ob_start(); }
	if (!empty($errormsg)) { feedbackblock($errormsg, 1); }
	echo '
<form name="loginform" action="' . SECUREBASEURL . basename($_SERVER['PHP_SELF']) . '?' . $_SERVER['QUERY_STRING'] . '" method="post">
<input type="hidden" name="authuser" value="true" />';
	if (isset($eventid)) {
		echo '
<input type="hidden" name="eventid" value="' . htmlspecialchars($eventid, ENT_COMPAT, 'UTF-8') . '" />';
	}
	if (isset($httpreferer)) {
		echo '
<input type="hidden" name="httpreferer" value="' . htmlspecialchars($httpreferer, ENT_COMPAT, 'UTF-8') . '" />';
	}
	if (isset($authsponsorid)) {
		echo '
<input type="hidden" name="authsponsorid" value="' . htmlspecialchars($authsponsorid, ENT_COMPAT, 'UTF-8') . '" />';
	}

	echo '
<table border="0" cellspacing="1" cellpadding="3">
<tbody><tr>
<td class="inputbox alignRight" nowrap="nowrap"><label for="login_userid"><strong>' . lang('user_id') . ':</strong></label></td>
<td><input type="text" id="login_userid" name="login_userid" value="" autocomplete="off" /></td>
</tr><tr>
<td class="inputbox alignRight"><label for="login_password"><strong>' . lang('password') . '</strong></label></td>
<td><input type="password" id="login_password" name="login_password" value="" maxlength="' . MAXLENGTH_PASSWORD . '" autocomplete="off" /></td>
</tr><tr>
<td class="inputbox">&nbsp;</td>
<td><input type="submit" name="login" value="' . htmlspecialchars(lang('login', false), ENT_COMPAT, 'UTF-8') . '" /></td>
</tr></tbody>
</table>
</form>
<script type="text/javascript">/* <![CDATA[ */
document.loginform.login_userid.focus();
/* ]]> */</script>';

	if (CUSTOM_LOGIN_HTML) {
		// End capture and output a custom login page if it is being customized.
		$formhtml = ob_get_contents();
		ob_end_clean();

		ob_start();
		require('static-includes/loginform.inc');
		$customhtml = ob_get_contents();
		ob_end_clean();

		if ($customhtml === false) {
			echo '
<h2>' . lang('login') . ':</h2>
' . $formhtml . '
<p>' . lang('login_failed_include') . '</p>';
		}
		else {
			echo str_replace('@@LOGIN_HEADER@@', lang('login'),
			 str_replace('@@LOGIN_FORM@@', $formhtml, $customhtml));
		}
		contentsection_end();
	}
	else {
		// Otherwise, output the default signup message.
		echo '
</td>
<td class="LightCellBG pad" style="border:solid ' . $_SESSION['COLOR_BORDER'] . '; border-width:1px 1px 1px 0px">';
		$adminemail = strip_tags(html_entity_decode($_SESSION['CALENDAR_ADMINEMAIL']));
		if ($adminemail == '') {
			echo '
<h2>' . lang('edit_calendar') . ':</h2>';
		}
		else {
			echo '
<h2>' . lang('help_signup') . ':</h2>
<p>' . lang('help_signup_authorization') . ' <a href="' . ((strpos($adminemail, '://') === false)? 'mailto:' : '') . htmlspecialchars($adminemail, ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars($adminemail, ENT_COMPAT, 'UTF-8') . '</a>.</p>';
		}
		echo '
<p>' . lang('help_signup_contents') . '</p></td>
</tr></tbody>
</table>';
	}
	pagefooter();
}

function displaymultiplelogin($errorMessage='')
{ // Display a list of sponsors that the user belongs to so they can choose the one they wish to login as.
	global $eventid, $httpreferer, $authsponsorid;
	// Do not show the login if asked not to.
	if (defined('HIDELOGIN')) return;
	pageheader(lang('login', false), 'Update');
	contentsection_begin(lang('choose_sponsor_role'));
	if (!empty($errorMessage)) { echo '<p>' . htmlspecialchars($errorMessage, ENT_COMPAT, 'UTF-8') . '</p>' . "\n"; }
	// Allow a main admin to become any sponsor.
	if (isset($_SESSION['AUTH_ISMAINADMIN']) && $_SESSION['AUTH_ISMAINADMIN']) {
		$query = "
SELECT
	id,
	name,
	admin
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
ORDER BY
	admin DESC,
	name
";
	}
	// Otherwise, check which sponsors the user can become.
	else {
		$query = "
SELECT
	a.sponsorid AS id,
	s.name,
	s.admin
FROM
	" . SCHEMANAME . "vtcal_auth a
LEFT JOIN
	" . SCHEMANAME . "vtcal_sponsor s
ON
	a.calendarid=s.calendarid
	AND
	a.sponsorid=s.id
WHERE
	a.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	a.userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
ORDER BY
	s.admin DESC,
	s.name
";
	}
	$result =& DBQuery($query);
	if (is_string($result)) {
		DBErrorBox($result);
		$returnValue = false;
	}
	else {
		echo "\n" . '<ul>';
		$adminfound = false;
		for ($i=0; $i < $result->numRows(); $i++) {
			$sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			echo "\n" . '<li><a href="' . $_SERVER['PHP_SELF'] . '?authsponsorid=' . urlencode($sponsor['id']);
			if (isset($eventid)) { echo '&amp;eventid=', urlencode($eventid); }
			if (isset($httpreferer)) { echo '&amp;httpreferer=', urlencode($httpreferer); }
			echo '">' . htmlspecialchars($sponsor['name'], ENT_COMPAT, 'UTF-8') . '</a>';
			if ($sponsor['admin'] == 1) {
				$adminfound = true;
				echo ' **';
			}
			echo '</li>';
		}
		echo "\n" . '</ul>' . "\n";
		if ($adminfound) { echo "\n" . '<p>' . lang('sponsor_twin_asterisk_note') . '</p>' . "\n"; }
		$result->free();
	}
	contentsection_end();
	pagefooter();
}

function displaynotauthorized()
{
	// Do not show the login if asked not to.
	if (defined('HIDELOGIN')) return;
	pageheader(lang('login', false), 'Update');
	contentsection_begin(lang('error_not_authorized'));
	echo "\n" . '<p>' . lang('error_not_authorized_message') . '</p>' . "\n";
	/*
	if (@(readfile('static-includes/loginform-post.inc')) === false) {
		echo '
<div class="LightCellBG pad">
<h2>' . lang('help_signup') . ':</h2>
' . lang('help_signup_authorization') . '
<p><a href="mailto:' . htmlspecialchars(strip_tags(html_entity_decode($_SESSION['CALENDAR_ADMINEMAIL'])), ENT_COMPAT, 'UTF-8') . '">' . htmlspecialchars(strip_tags(html_entity_decode($_SESSION['CALENDAR_ADMINEMAIL'])), ENT_COMPAT, 'UTF-8') . '</a>. ' . lang('help_signup_contents') . '</p>
</div>' . "\n";
	}
	*/
	contentsection_end();
	pagefooter();
}

/**
 * Validate the username and password.
 *
 * Returns true if the user was authenticated.
 * Returns false if they were not authenticated.
 * Returns a string if an error occurred.
 */
function userauthenticated($userid, $password)
{
	// Return false if the arguments are invalid or not set.
	if (!isset($userid) || $userid == '' || !isset($password)) { return false; }
	$returnValue = false;
	// Check against the DB if it is allowed.
	if (AUTH_DB) {
		$result =& DBQuery("
SELECT
	password
FROM
	" . SCHEMANAME . "vtcal_user
WHERE
	id='" . sqlescape($userid) . "'
");
		if (is_string($result)) { $returnValue = lang('dberror_generic') . ': ' . $result; }
		else {
			if ($result->numRows() > 0) {
				$userRecord =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
				if (crypt($password, $userRecord['password']) == $userRecord['password']) {
					$_SESSION['AUTH_LOGINSOURCE'] = 'DB';
					$returnValue = true;
				}
			}
			$result->free();
		}
	}
	// Check using LDAP if it is allowed.
	if ($returnValue === false && AUTH_LDAP) {
		// Create the base search filter using the specified userfield.
		$searchFilter = '(' . LDAP_USERFIELD . '=' . $userid . ')';
		// If an additional search filter was specified, then append it to the userfield filter
		if (LDAP_SEARCH_FILTER != '') {
			$searchFilter = '(&' . $searchFilter . LDAP_SEARCH_FILTER . ')';
		}
		if (preg_match("/^ldap(s?):\\/\\//", LDAP_HOST) == 1) {
			$ldap = ldap_connect(LDAP_HOST);
		}
		else {
			$ldap = ldap_connect(LDAP_HOST, LDAP_PORT);
		}
		if (!isset($ldap) || $ldap === false) {
			$returnValue = 'Could not connect to the login server. (LDAP)';
		}
		else {
			// Bind to the LDAP as a specific user, if defined
			if (LDAP_BIND_USER == '' || ldap_bind($ldap, LDAP_BIND_USER, LDAP_BIND_PASSWORD)) {
				// Search for users name to dn
				$result = ldap_search($ldap, LDAP_BASE_DN, $searchFilter, array('dn'));
				if ($result === false) {
					$returnValue = 'An error occured while searching the LDAP server for your username.';
				}
				else {
					// Get a multi-dimentional array from the results
					$entries = ldap_get_entries($ldap, $result);
					if ($entries === false) {
						$returnValue = 'An error occured while retrieving information' .
						 ' for your username from the LDAP server.';
					}
					elseif ($entries['count'] == 0) {
						$returnValue = 'User-ID not found. (LDAP)';
					}
					else {
						// Determine the distinguished name (dn) of the found username.
						$principal = $entries[0]['dn'];
						/* bind (or rebind) as the DN and the password that was supplied via the login form */
						if (@ldap_bind($ldap, $principal, $password)) {
							$_SESSION['AUTH_LOGINSOURCE'] = 'LDAP';
							$returnValue = true;
						}
						else {
							$returnValue = 'Password is incorrect. Please try again. (LDAP)';
						}
					}
					// Clean up
					ldap_free_result($result);
				}
				ldap_close($ldap);
			}
			else {
				$returnValue = 'Could not connect to the LDAP server due to an authentication problem.';
			}
		}
	}

	// Check using a HTTP request if it is allowed.
	if ($returnValue === false && AUTH_HTTP) {
		$req =& new HTTP_Request(AUTH_HTTP_URL);
		$req->setBasicAuth($userid, $password);
		$response = $req->sendRequest();
		if (PEAR::isError($response)) {
			$returnValue = 'An error occurred while connecting to the login server. (HTTP)';
		}
		else {
			if ($req->getResponseCode() == 200) {
				$_SESSION['AUTH_LOGINSOURCE'] = 'HTTP';
				if (AUTH_HTTP_CACHE) {
					$passhash = crypt($password);
					DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_auth_httpcache
	(
		id,
		passhash,
		cachedate
	)
VALUES
	(
		'" . sqlescape($userid) . "',
		'" . sqlescape($passhash) . "',
		Now()
	)
ON DUPLICATE KEY
UPDATE
	passhash='" . sqlescape($passhash) . "',
	cachedate=Now()
");
				}
				$returnValue = true;
			}
			else {
				if (AUTH_HTTP_CACHE) {
					$result =& DBQuery("
SELECT
	passhash
FROM
	" . SCHEMANAME . "vtcal_auth_httpcache
WHERE
	id='" . sqlescape($userid) . "'
	AND
	DateDiff(cachedate, Now()) > -" . AUTH_HTTP_CACHE_EXPIRATIONDAYS . "
");
					if (is_string($result)) {
						$returnValue = lang('dberror_generic') . ": " . $result;
					}
					elseif ($result->numRows() > 0) {
						$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
						$passhash = $record['PassHash'];
						if (crypt($password, $passhash) == $passhash) { $returnValue = true; }
						$result->free();
					}
				}
			}
		}
	}
	return $returnValue;
}

/**
 * Authenticate the user. If successful, AUTH_USERID and AUTH_MAINADMIN are set.
 *
 * Returns true if successful; false or a string if unsuccessful. The string is the reason for failure.
 */
function logUserIn()
{
	// Get username/password POST values.
	if (isset($_POST['login_userid']) && isset($_POST['login_password'])) {
		if (!setVar($userid, mb_strtolower($_POST['login_userid'], 'UTF-8'), 'userid')) { unset($userid); }
		setVar($password, $_POST['login_password']);
	}
	else {
		unset($userid);
		unset($password);
	}
	// Log out the user if the user ID submitted is different than the currently logged in user.
	if (isset($userid) && isset($_SESSION['AUTH_USERID']) && $userid != $_SESSION['AUTH_USERID']) { logout(); }
	// Return true if the user is already logged in.
	if (isset($_SESSION['AUTH_USERID'])) { return true; }
	// Return false if the user isn't logged in but no credentials were provided.
	elseif (!isset($userid) || !isset($password)) { return false; }
	// Otherwise, attempt to authenticate the user with the supplied credentials
	else {
		// Check the username/password.
		$authresult = userauthenticated($userid, $password);
		// Mark the user as logged in if successfully authenticated.
		if ($authresult === true) {
			$_SESSION['AUTH_USERID'] = $userid;
			// Determine if the user is an main admin
			$result =& DBQuery("
SELECT
	id
FROM
	" . SCHEMANAME . "vtcal_adminuser
WHERE
	id='" . sqlescape($_SESSION['AUTH_USERID']) . "'
");
			// Return an error message if the query failed.
			if (is_string($result)) {
				return lang('login_failed') . '<br />' . "\n" .
				 'Reason: A database error was encountered: ' . $result;
			}
			else {
 			  $_SESSION['AUTH_ISMAINADMIN'] = $result->numRows() > 0;
				$result->free();
				return true;
			}
		}
	}
	// Otherwise, return that the login attempt failed.
	return lang('login_failed') . (is_string($authresult)? '<br />' . "\n" . $authresult : '');
}

function isSponsor()
{ // tests to see if user is admin and has editing rights, minimized version of authorized()
	if (isset($_GET['authsponsorid'])) {
		setVar($authsponsorid, $_GET['authsponsorid'], 'sponsorid');
		unset($_SESSION['AUTH_SPONSORNAME']);
		unset($_SESSION['AUTH_SPONSORID']);
	}
	elseif (isset($_SESSION['AUTH_SPONSORID'])) {
		setVar($authsponsorid, $_SESSION['AUTH_SPONSORID'], 'sponsorid');
		unset($_SESSION['AUTH_SPONSORNAME']);
		unset($_SESSION['AUTH_SPONSORID']);
	}
	else { unset($authsponsorid); }
	if (isset($authsponsorid) && ($authresult = logUserIn()) === true) {
		if (isset($authsponsorid)) {
			if ($_SESSION['AUTH_ISMAINADMIN']) {
				$query = "
SELECT
	admin,
	name
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($authsponsorid) . "'
";
			}
			else {
				$query = "
SELECT
	a.sponsorid,
	s.name,
	s.admin
FROM
	" . SCHEMANAME . "vtcal_auth a
LEFT JOIN
	" . SCHEMANAME . "vtcal_sponsor s
ON
	a.calendarid=s.calendarid
	AND
	a.sponsorid=s.id
WHERE
	a.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	a.userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
	AND
	a.sponsorid='" . sqlescape($authsponsorid) . "'
";
			}
			$result =& DBQuery($query);
			if (!is_string($result)) {
				if ($result->numRows() == 1) {
					$record = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
					$_SESSION['AUTH_SPONSORID'] = $authsponsorid;
		 			$_SESSION['AUTH_SPONSORNAME'] = $record['name'];
					$_SESSION['AUTH_ISCALENDARADMIN'] = ($record['admin'] == 1);
				}
				$result->free();
			}
		}
		elseif (!isset($_SESSION['AUTH_SPONSORID'])) {
			if (isset($_SESSION['AUTH_ISMAINADMIN']) && $_SESSION['AUTH_ISMAINADMIN']) {
				$query = "
SELECT
	id,
	name,
	admin
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
";
			}
			else {
				$query = "
SELECT
	s.id,
	a.sponsorid,
	s.name,
	s.admin
FROM
	" . SCHEMANAME . "vtcal_auth a
LEFT JOIN
	" . SCHEMANAME . "vtcal_sponsor s
ON
	a.calendarid=s.calendarid
	AND
	a.sponsorid=s.id
WHERE
	a.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	a.userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
";
			}
			$result =& DBQuery($query);
			if (!is_string($result)) {
				if ($result->numRows() == 1) {
					$authorization =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
					$_SESSION['AUTH_SPONSORID']= $authorization['id'];
		 			$_SESSION['AUTH_SPONSORNAME'] = $authorization['name'];
		 			$_SESSION['AUTH_SPONSORCOUNT'] = 1;
		 			$_SESSION['AUTH_ISCALENDARADMIN'] = ($authorization['admin'] == 1);
				}
				else { $_SESSION['AUTH_SPONSORCOUNT'] = $result->numRows(); }
				$result->free();
			}
		}
	}
}

/**
 * Checks if the person is logged in and has authorization to view
 * the calendar management pages (e.g. update.php)
 */
function authorized()
{
	$returnValue = true;
	// Get sponsor related URL values
	if (isset($_GET['authsponsorid'])) {
		setVar($authsponsorid, $_GET['authsponsorid'], 'sponsorid');
		unset($_SESSION['AUTH_SPONSORNAME']);
		unset($_SESSION['AUTH_SPONSORID']);
	}
	elseif (isset($_SESSION['AUTH_SPONSORID'])) {
		setVar($authsponsorid, $_SESSION['AUTH_SPONSORID'], 'sponsorid');
		unset($_SESSION['AUTH_SPONSORNAME']);
		unset($_SESSION['AUTH_SPONSORID']);
	}
	else {
		unset($authsponsorid);
	}
	if (($authresult = logUserIn()) !== true) {
		displaylogin(is_string($authresult)? $authresult : '');
		$returnValue = false;
	}
	elseif (isset($_POST['authuser'])) {
		header('Location: ' . basename($_SERVER['PHP_SELF']) . '?' . $_SERVER['QUERY_STRING']);
		exit;
	}
	else {
		// Continue processing if the user is logged in.
		// The user wants to set or change sponsor...
		if (isset($authsponsorid)) {
			// Just verify that the sponsor does exist for main admins.
			if ($_SESSION['AUTH_ISMAINADMIN']) {
				$query = "
SELECT
	admin,
	name
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	id='" . sqlescape($authsponsorid) . "'
";
			}
			// Otherwise, verify that the user belongs to that sponsor group.
			else {
				$query = "
SELECT
	a.sponsorid,
	s.name,
	s.admin
FROM
	" . SCHEMANAME . "vtcal_auth a
LEFT JOIN
	" . SCHEMANAME . "vtcal_sponsor s
ON
	a.calendarid=s.calendarid
	AND
	a.sponsorid=s.id
WHERE
	a.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	a.userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
	AND
	a.sponsorid='" . sqlescape($authsponsorid) . "'
";
			}
			$result =& DBQuery($query);
			if (is_string($result)) {
				displaylogin(lang('dberror_generic') . ': ' . $result);
				$returnValue = false;
			}
			else {
				if ($result->numRows() != 1) {
					displaymultiplelogin(lang('error_bad_sponsorid'));
					$returnValue = false;
				}
				else {
					$record = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
					$_SESSION['AUTH_SPONSORID'] = $authsponsorid;
		 			$_SESSION['AUTH_SPONSORNAME'] = $record['name'];
					$_SESSION['AUTH_ISCALENDARADMIN'] = ($record['admin'] == 1);
				}
				$result->free();
			}
		}
		// If the sponsor ID is not set, then we need to verify the user's access to this calendar...
		elseif (!isset($_SESSION['AUTH_SPONSORID'])) {
			// Allow a main admin to become any sponsor.
			if (isset($_SESSION['AUTH_ISMAINADMIN']) && $_SESSION['AUTH_ISMAINADMIN']) {
				$query = "
SELECT
	id,
	name,
	admin
FROM
	" . SCHEMANAME . "vtcal_sponsor
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
";
			}
			// Otherwise, check which sponsors the user can become.
			else {
				$query = "
SELECT
	s.id,
	a.sponsorid,
	s.name,
	s.admin
FROM
	" . SCHEMANAME . "vtcal_auth a
LEFT JOIN
	" . SCHEMANAME . "vtcal_sponsor s
ON
	a.calendarid=s.calendarid
	AND
	a.sponsorid=s.id
WHERE
	a.calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	a.userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
";
			}
			$result =& DBQuery($query);
			// Display an error message if the query failed.
			if (is_string($result)) {
				displaylogin(lang('dberror_generic') . ': ' . $result);
				$returnValue = false;
			}
			else {
				// If the user does not have a sponsor for this calendar,
				// then the user is not authorized or there are no sponsors (!).
				if ($result->numRows() == 0) {
					if ($_SESSION['AUTH_ISMAINADMIN']) { displaylogin(lang('dberror_nosponsor')); }
					else { displaynotauthorized(); }
					$returnValue = false;
				}
				// Assign the user's sponsor if only one record was found from the query.
				elseif ($result->numRows() == 1) {
					$authorization =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
					$_SESSION['AUTH_SPONSORID']= $authorization['id'];
		 			$_SESSION['AUTH_SPONSORNAME'] = $authorization['name'];
		 			$_SESSION['AUTH_SPONSORCOUNT'] = 1;
		 			$_SESSION['AUTH_ISCALENDARADMIN'] = ($authorization['admin'] == 1);
				}
				// If the user belongs to more than one sponsor, then display the form to select a sponsor.
				else {
		 			$_SESSION['AUTH_SPONSORCOUNT'] = $result->numRows();
					displaymultiplelogin();
					$returnValue = false;
				}
				$result->free();
			}
		}
	}
	return $returnValue;
}

/**
 * Checks if a user is allowed to view the main calendar (main.php) or export data (export/export.php).
 * @return boolean true if the user is authorized; otherwise, false.
 */
function viewauthorized()
{
	// Return true if the calendar does not require authorization.
	if ($_SESSION['CALENDAR_VIEWAUTHREQUIRED'] == 0) return true;
	// Default that the user does not have access.
	$returnValue = false;
	if (($authresult = logUserIn()) !== true) {
		// Make sure the user is logged in.
		displaylogin(is_string($authresult)? $authresult : '');
	}
	elseif (isset($_SESSION['AUTH_ISMAINADMIN']) || (isset($_SESSION['CALENDAR_LOGIN']) &&
	 $_SESSION['CALENDAR_LOGIN'] == $_SESSION['CALENDAR_ID']) ||
	 $_SESSION['CALENDAR_VIEWAUTHREQUIRED'] == 2) {
		// Allow the user to view the calendar if they are already marked
		// as having access or if any user is allowed view access.
		$returnValue = true;
	}
	else {
		// Check if the user should be able to view the calendar.
		// Check if user is assigned to one of this calendar's sponsors.
		$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_auth v
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
");
		if (is_string($result)) {
			displaylogin(lang('login_failed') . '<br />' . "\n" .
			 'Reason: A database error was encountered: ' . $result);
		}
		else {
			$sponsorCount = $result->numRows();
			$result->free();
			if ($sponsorCount > 0) {
				$_SESSION['CALENDAR_LOGIN'] = $_SESSION['CALENDAR_ID'];
				$returnValue = true;
			}
			else {
				// Check if the user is marked as having view authorization.
				$result =& DBQuery("
SELECT
	*
FROM
	" . SCHEMANAME . "vtcal_calendarviewauth
WHERE
	calendarid='" . sqlescape($_SESSION['CALENDAR_ID']) . "'
	AND
	userid='" . sqlescape($_SESSION['AUTH_USERID']) . "'
");
				if (is_string($result)) {
					displaylogin(lang('login_failed') . '<br />' . "\n" .
					 'Reason: A database error was encountered: ' . $result);
				}
				else {
					if ($result->numRows() > 0) {
						$_SESSION['CALENDAR_LOGIN'] = $_SESSION['CALENDAR_ID'];
						$returnValue = true;
					}
					else {
						displaylogin(lang('login_failed'));
					}
					$result->free();
				}
			}
		}
	}
	return $returnValue;
}

function calendarlogout()
{ // Only log the user out of a calendar
	unset($_SESSION['AUTH_SPONSORID']);
	unset($_SESSION['AUTH_SPONSORNAME']);
	unset($_SESSION['AUTH_ISCALENDARADMIN']);
	unset($_SESSION['CALENDAR_LOGIN']);
	unset($_SESSION['CATEGORY_NAMES']);
	unset($_SESSION['CATEGORY_FILTER']);
	unset($_SESSION['AUTH_SPONSORCOUNT']);
}

function logout()
{ // Completely logout the user.
	unset($_SESSION['AUTH_USERID']);
	unset($_SESSION['AUTH_ISMAINADMIN']);
	unset($_SESSION['AUTH_LOGINSOURCE']);
	calendarlogout();
}
?>