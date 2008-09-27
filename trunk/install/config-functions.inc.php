<?php

function escapephpstring($string) {
	return str_replace("'", "\\'", str_replace("\\", "\\\\", $string));
}

function ProcessMainAdminAccountList($accountlist, &$finallist) {
	global $Form_REGEXVALIDUSERID, $FormErrors;
	
	$splitLDAPAdmins = split("[\n\r]+", $accountlist);
	for ($i = 0; $i < count($splitLDAPAdmins); $i++) {
		if (trim($splitLDAPAdmins[$i]) != "") {
			if (preg_match($Form_REGEXVALIDUSERID, $splitLDAPAdmins[$i]) == 0) {
				$FormErrors[count($FormErrors)] = "The username '" . htmlentities($splitLDAPAdmins[$i]) . "' must match the User ID Regular Expression.";
			}
			else {
				$finallist[count($finallist)] = $splitLDAPAdmins[$i];
			}
		}
	}
}

function AddMainAdmin($username) {
	global $FormErrors;
	
	// Check that the account does not already exist
	$result =& DBQuery("SELECT count(*) as idcount FROM vtcal_adminuser WHERE (id='".sqlescape($username)."')");
	if (is_string($result)) {
		$FormErrors[count($FormErrors)] = "Could not SELECT from the vtcal_adminuser table. Does the user specified in the Database Connection String have access?<br/>Error: <code>" . htmlentities($result) . "</code>";
	}
	else {
		$record =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		if ($record['idcount'] == "0") {
			// Insert the account if it does not exist.
			$result =& DBQuery("INSERT INTO vtcal_adminuser (id) VALUES ('".sqlescape($username)."')");
			if (is_string($result)) {
				$FormErrors[count($FormErrors)] = "Could not assign '" . htmlentities($username) . "' as an admin user.<br/>Error: <code>" . htmlentities($result) . "</code>";
			}
		}
		else {
			$FormErrors[count($FormErrors)] = "'" . htmlentities($username) . "' is already an admin user.";
		}
	}
}

function AddUser($username, $password) {
	global $FormErrors;
	
	// Check that the account does not already exist
	$result =& DBQuery("SELECT count(*) as idcount FROM vtcal_user WHERE (id='".sqlescape($username)."')");
	if (is_string($result)) {
		$FormErrors[count($FormErrors)] = "Could not SELECT from the vtcal_user table. Does the user specified in the Database Connection String have access?<br/>Error: <code>" . htmlentities($result) . "</code>";
	}
	else {
		$record =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
		if ($record['idcount'] == "0") {
			// Insert the account if it does not exist.
			$result =& DBQuery("INSERT INTO vtcal_user (id, password, email) VALUES ('".sqlescape($username)."','".sqlescape(crypt($password))."','')");
			if (is_string($result)) {
				$FormErrors[count($FormErrors)] = "Could not create the '" . htmlentities($username) . "' account.<br/>Error: <code>" . htmlentities($result) . "</code>";
			}
		}
		else {
			$FormErrors[count($FormErrors)] = "The '" . htmlentities($username) . "' account already exists.";
		}
	}
}

?>