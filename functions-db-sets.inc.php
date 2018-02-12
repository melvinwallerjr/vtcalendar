<?php
function AddMainAdmin($username)
{ // Add a username as a main admin.
	// Check that the account does not already exist
	$result =& DBQuery("
SELECT
	count(*) AS idcount
FROM
	" . SCHEMANAME . "vtcal_adminuser
WHERE
	(
		id='" . sqlescape($username) . "'
	)
");
	// Return the error message if the SELECT failed.
	if (is_string($result)) { return $result; }
	$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	if ($record['idcount'] != '0') { return false; } // Return false since the user already exists.
	$result->free();
	// Insert the account if it does not exist.
	$result =& DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_adminuser
	(
		id
	)
VALUES
	(
		'" . sqlescape($username) . "'
	)
");
	// Return the error message if the INSERT failed.
	if (is_string($result)) { return $result; }
	// Return that the user was added successfully.
	return true;
}

function AddUser($username, $password, $email='')
{ // Add a local DB user account.
	// Check that the account does not already exist
	$result =& DBQuery("
SELECT
	count(*) AS idcount
FROM
	" . SCHEMANAME . "vtcal_user
WHERE
	(
		id='" . sqlescape($username) . "'
	)
");
	// Return the error message if the SELECT failed.
	if (is_string($result)) { return $result; }
	$record =& $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
	if ($record['idcount'] != '0') { return false; } // Return false since the user already exists.
	$result->free();
	// Insert the account if it does not exist.
	$result =& DBQuery("
INSERT INTO
	" . SCHEMANAME . "vtcal_user
	(
		id,
		password,
		email
	)
VALUES
	(
		'" . sqlescape($username) . "',
		'" . sqlescape(crypt($password)) . "',
		''
	)
");
	// Return the error message if the INSERT failed.
	if (is_string($result)) { return $result; }
	// Return that the user was added successfully.
	return true;
}
?>