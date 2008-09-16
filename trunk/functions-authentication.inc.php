<?php
/* Make sure the password meets standards for a new password (e.g. not the same as their old password */
function checknewpassword(&$user) {
  /* include more sophisticated constraints here */
  if ($user['newpassword1']!=$user['newpassword2']) { return 1; }
  elseif ((empty($user['newpassword1'])) || (strlen($user['newpassword1']) < 5)) { return 2; }
  else { return 0; }
}

/* Verify the  user's old password in the database */
function checkoldpassword(&$user, $userid) {
  $result =& DBQuery("SELECT * FROM vtcal_user WHERE id='".sqlescape($userid)."'" );
  $data =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	return ($data['password'] != crypt($user['oldpassword'], $data['password']));
}

// display login screen and errormsg (if exists)
function displaylogin($errormsg="") {
  global $lang;
  
  // Force HTTPS is the server is not being accessed via localhost.
	if ( $_SERVER['SERVER_ADDR'] != "127.0.0.1" ) {
		$protocol = "http";
		if ( isset($_SERVER['HTTPS'])) { $protocol .= "s"; }
		if ( BASEURL != SECUREBASEURL && $protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"] != SECUREBASEURL."update.php" ) {
			redirect2URL(SECUREBASEURL."update.php?calendar=".$_SESSION["CALENDARID"]);
		}
	}

  pageheader(lang('update_page_header'), "Update");
  contentsection_begin(lang('login'));

  if (!empty($errormsg)) {
    echo "<BR>\n";
    feedback($errormsg,1);
  }
	?>
  <DIV>
  <?php if (file_exists("static-includes/loginform-pre.txt")) { include('static-includes/loginform-pre.txt'); } ?>
  <FORM method="post" action="<?php echo SECUREBASEURL; ?>update.php" name="loginform">
	<?php
	if (isset($GLOBALS["eventid"])) { echo "<input type=\"hidden\" name=\"eventid\" value=\"",htmlentities($GLOBALS["eventid"]),"\">\n"; }
  if (isset($GLOBALS["httpreferer"])) {  echo "<input type=\"hidden\" name=\"httpreferer\" value=\"",htmlentities($GLOBALS["httpreferer"]),"\">\n"; }
	if (isset($GLOBALS["authsponsorid"])) { echo "<input type=\"hidden\" name=\"authsponsorid\" value=\"",htmlentities($GLOBALS["authsponsorid"]),"\">\n"; }
	?>
    <TABLE border="0" cellspacing="1" cellpadding="3">
      <TR>
        <TD class="inputbox" align="right" nowrap><b><?php echo lang('user_id'); ?>:</b></TD>
        <TD align="left"><INPUT type="text" name="login_userid" value=""></TD>
      </TR>
      <TR>
        <TD class="inputbox" align="right"><b><?php echo lang('password'); ?></b></TD>
        <TD align="left"><INPUT type="password" name="login_password" value="" maxlength="<?php echo constPasswordMaxLength; ?>"></TD>
      </TR>
      <TR>
        <TD class="inputbox">&nbsp;</TD>
        <TD align="left"><INPUT type="submit" name="login" value="&nbsp;&nbsp;&nbsp;<?php echo lang('login'); ?>&nbsp;&nbsp;&nbsp;"></TD>
      </TR>
    </TABLE>
  </FORM>
	<script language="JavaScript1.2"><!--
	  document.loginform.login_userid.focus();
	//--></script>
	<?php if (file_exists("static-includes/loginform-post.txt")) { include('static-includes/loginform-post.txt'); } ?>
  </DIV>
	<?php
  contentsection_end();

  pagefooter();
} // end: function displaylogin

// Display a list of sponsors that the user belongs to
// so they can choose the one they wish to login as.
function displaymultiplelogin($errorMessage="") {
  pageheader(lang('login'), "Update");
  
  contentsection_begin(lang('choose_sponsor_role'));
  
  if (!empty($errorMessage)) {
  	echo "<p>", htmlentities($errorMessage) ,"</p>";
  } else {
  	echo "<div>&nbsp;</div>";
  }
	
	// Allow a main admin to become any sponsor.
	if (isset($_SESSION["AUTH_MAINADMIN"]) && $_SESSION["AUTH_MAINADMIN"]) {
		$query = "SELECT id, name, admin FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY admin DESC, name";
	}
  // Otherwise, check which sponsors the user can become.
	else {
		$query = "SELECT a.sponsorid as id, s.name, s.admin FROM vtcal_auth a LEFT JOIN vtcal_sponsor s ON a.calendarid = s.calendarid AND a.sponsorid = s.id WHERE a.calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND a.userid='".sqlescape($_SESSION["AUTH_USERID"])."'  ORDER BY s.admin DESC, s.name";
	}
	
	$result =& DBQuery($query); //"SELECT * FROM vtcal_auth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND userid='".sqlescape($_SESSION["AUTH_USERID"])."'");
	
	if (is_string($result)) {
		echo $result;
	}
	else {
		echo "<ul>";
		$adminfound = false;
    for ($i = 0; $i < $result->numRows(); $i++) {
      $sponsor =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);			
			
			echo '<li><a href="' . $_SERVER["PHP_SELF"] . "?authsponsorid=" . urlencode($sponsor['id']);
    	if (isset($GLOBALS["eventid"])) { 
			  echo "&eventid=",urlencode($GLOBALS["eventid"]);
			}
      if (isset($GLOBALS["httpreferer"])) { 
			  echo "&httpreferer=",urlencode($GLOBALS["httpreferer"]); 
			}
			echo '">' . htmlentities($sponsor['name']) . "</a>";
			
			if ($sponsor['admin'] == 1) {
				$adminfound = true;
				echo " **";
			}
			
			echo "</li>\n";
		}
		echo "</ul>";
		
		if ($adminfound) {
			?><p>Note: The sponsor marked with a ** is the administrative sponsor of this calendar..</p><?php
		}
		
		$result->free();
	}
	
  contentsection_end();

  pagefooter();
} // end: function displaymultiplelogin

function displaynotauthorized() {
  pageheader(lang('login'), "Update");
  contentsection_begin(lang('error_not_authorized'));
	?>
	<?php echo lang('error_not_authorized_message'); ?><br>
	<br>
	    <a href="helpsignup.php" target="newWindow"	onclick="new_window(this.href); return false"><?php echo lang('help_signup_link'); ?></a><br>
	<BR>
	<?php
  contentsection_end();

  pagefooter();
} // end: Function displaynotauthorized


/**
	* Validate the username and password.
	* 
	* Returns true if the user was authenticated.
	* Returns false if they were not authenticated.
	* Returns a string if an error occurred.
	*/
function userauthenticated($userid, $password) {
	// Return false if the arguments are invalid or not set.
	if (!isset($userid) || $userid == "" || !isset($password)) return false;

	$returnValue = false;

	// Check against the DB if it is allowed.
	if (AUTH_DB) {
		$result =& DBQuery("SELECT password FROM vtcal_user WHERE id='".sqlescape($userid)."'"); 
		if (is_string($result)) {
			$returnValue = $lang['dberror_generic'] . ": " . $result;
		}
		else {
	    if ($result->numRows() > 0) {
				$userRecord =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
				if ( crypt($password, $userRecord['password']) == $userRecord['password'] ) {
					$_SESSION["AUTH_TYPE"] = "DB";
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
		
		$ldap = ldap_connect(LDAP_HOST, LDAP_PORT);
		if (isset($ldap) && $ldap !== false) {
		
			// Bind to the LDAP as a specific user, if defined
			if (LDAP_BIND_USER == '' || ldap_bind($ldap, LDAP_BIND_USER, LDAP_BIND_PASSWORD)) {
			
				// Search for users name to dn
				$result = ldap_search($ldap, LDAP_BASE_DN, $searchFilter, array('dn'));
				
				if ($result) {
					// Get a multi-dimentional array from the results
					$entries = ldap_get_entries($ldap, $result);
					
					// Determine the distinguished name (dn) of the found username.
					$principal = $entries[0]['dn'];
					if (isset($principal)) {
					
						/* bind (or rebind) as the DN and the password that was supplied via the login form */
						if (@ldap_bind($ldap, $principal, $password)) {
							//print('LDAP Success');
							$_SESSION["AUTH_TYPE"] = "LDAP";
							$returnValue = true;
						} 
						else {
							//print('LDAP failure');
							$returnValue = "Password is incorrect. Please try again. (LDAP)";
						}
					}
					else {
						//print('User not found in LDAP');
						$returnValue = "User-ID not found. (LDAP)";
					}
					
					// Clean up
					ldap_free_result($result);
					
				}
				else {
					$returnValue = "An error occured while searching the LDAP server for your username.";
				}
				ldap_close($ldap);
			}
			else {
				$returnValue = "Could not connect to the LDAP server due to an authentication problem.";
			}
		} 
		else {
			$returnValue = "Could not connect to the login server. (LDAP)";
		}
	}
	
	// Check using a HTTP request if it is allowed.
	if ($returnValue === false && AUTH_HTTP) {
		require_once("HTTP/Request.php");

		$req =& new HTTP_Request(AUTH_HTTP_URL);
		$req->setBasicAuth($userid, $password);
		
		$response = $req->sendRequest();
		
		if (PEAR::isError($response)) {
			$returnValue = "An error occurred while connecting to the login server. (HTTP)";
		}
		else {
			if ($req->getResponseCode() == 200) {
				$_SESSION["AUTH_TYPE"] = "HTTP";
				
				if (AUTH_HTTP_CACHE) {
					$passhash = crypt($password);
					DBQuery( "INSERT INTO vtcal_auth_httpcache (ID, PassHash, CacheDate) VALUES ('".sqlescape($userid)."', '".sqlescape($passhash)."', Now()) ON DUPLICATE KEY UPDATE PassHash='".sqlescape($passhash)."', CacheDate=Now()" );
				}
				
				$returnValue = true;
			}
			else {
				if (AUTH_HTTP_CACHE) {
					$result =& DBQuery( "SELECT PassHash FROM vtcal_auth_httpcache WHERE ID = '".sqlescape($userid)."' AND DateDiff(CacheDate, Now()) > -".AUTH_HTTP_CACHE_EXPIRATIONDAYS);
					
					if (is_string($result)) {
						$returnValue = $lang['dberror_generic'] . ": " . $result;
					}
					elseif ($result->numRows() > 0) {
						$record =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
						$passhash = $record['PassHash'];
						
						if (crypt($password, $passhash) == $passhash) {
							$returnValue = true;
						}
						
						$result->free();
					}
				}
			}
		}
	}
	
	return $returnValue;
}

/**
 * authorized() checks if the person is logged in and has authorization to view the calendar management pages (e.g. update.php)
 *
 * This is how the following function executes:
 * 1. Grab the login username/password from _POST, if they exist.
 * 2. 
 */
function authorized() {
	$returnValue = true;
	
	// Get sponsor related URL values
  if (isset($_GET['authsponsorid'])) {
  	setVar($authsponsorid, $_GET['authsponsorid'], 'sponsorid');
  	if ($authsponsorid === NULL) unset($authsponsorid);
		unset($_SESSION["AUTH_SPONSORNAME"]);
  	unset($_SESSION["AUTH_SPONSORID"]);
  }
  else {
  	unset($authsponsorid);
  }
  
  // Get username/password POST values.
  if (isset($_POST['login_userid']) && isset($_POST['login_password'])) {
  	setVar($userid, strtolower($_POST['login_userid']), 'userid');
	  $password = $_POST['login_password'];
  }
  else {
  	unset($userid);
  	unset($password);
  }
  
  // Log out the user if the user ID submitted is different than the currently logged in user.
  if (isset($userid) && isset($_SESSION["AUTH_USERID"]) && $userid != $_SESSION["AUTH_USERID"]) {
	  logout();
  }
  
  // Attempt to authenticate the user if the user isn't already logged in.
  if (!isset($_SESSION["AUTH_USERID"])) {
  
  	if (isset($userid) && isset($password)) {
  		
	  	// Check the username/password.
			if ( ($authresult = userauthenticated($userid,$password)) === true ) {
				$_SESSION["AUTH_USERID"] = $userid;
  
				// Determine if the user is an main admin
	      $result =& DBQuery("SELECT id FROM vtcal_adminuser WHERE id='".sqlescape($_SESSION["AUTH_USERID"])."'" );
	      
	      if (is_string($result)) {
				  displaylogin(lang('login_failed') . "<br>Reason: A database error was encountered: " . $result);
					$returnValue = false;
	      }
	      else {
	 			  $_SESSION["AUTH_MAINADMIN"] = $result->numRows() > 0;
				  $result->free();
				}
			}
	    else {
			  displaylogin(lang('login_failed') . "<br>Reason: " . $authresult);
				$returnValue = false;
	    }
    }
    else {
		  displaylogin();
			$returnValue = false;
    }
  }
  
  // Continue processing if successful so far.
  if ($returnValue === true) {
  
		// The user wants to set or change sponsor...
	  if (isset($authsponsorid)) {
	  	
  		// Just verify that the sponsor does exist for main admins.
	  	if ($_SESSION["AUTH_MAINADMIN"]) {
	  		$query = "SELECT name FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($authsponsorid)."'";
	  	}
	    // Otherwise, verify that the user belongs to that sponsor group.
	  	else {
	  		$query = "SELECT a.sponsorid, s.name, s.admin FROM vtcal_auth a LEFT JOIN vtcal_sponsor s ON a.calendarid = s.calendarid AND a.sponsorid = s.id WHERE a.calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND a.userid='".sqlescape($_SESSION["AUTH_USERID"])."' AND a.sponsorid='".sqlescape($authsponsorid)."'";
	  	}
	  	
  		$result =& DBQuery($query);
	  	
  		if (is_string($result)) {
			  displaylogin($lang['dberror_generic'] . ": " . $result);
				$returnValue = false;
  		}
  		else {
	  		if ($result->numRows() != 1) {
					displaymultiplelogin(lang('error_bad_sponsorid'));
					$returnValue = false;
	  		}
	  		else {
	  			$record = $result->fetchRow(DB_FETCHMODE_ASSOC, 0);
					$_SESSION["AUTH_SPONSORID"]= $authsponsorid;
		 			$_SESSION["AUTH_SPONSORNAME"] = $record['name'];
			  	$_SESSION["AUTH_ADMIN"] = $_SESSION["AUTH_MAINADMIN"] || $record["admin"] == 1;
	  		}
		  	$result->free();
  		}
		}
		
		// If the sponsor ID is not set, then we need to verify the user's access to this calendar...
	  elseif (!isset($_SESSION["AUTH_SPONSORID"])) {
	  	
  		// Allow a main admin to become any sponsor.
	  	if (isset($_SESSION["AUTH_MAINADMIN"]) && $_SESSION["AUTH_MAINADMIN"]) {
	  		$query = "SELECT name FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."'";
	  	}
	    // Otherwise, check which sponsors the user can become.
	  	else {
	  		$query = "SELECT a.sponsorid, s.name, s.admin FROM vtcal_auth a LEFT JOIN vtcal_sponsor s ON a.calendarid = s.calendarid AND a.sponsorid = s.id WHERE a.calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND a.userid='".sqlescape($_SESSION["AUTH_USERID"])."'";
	  	}
	  	
	  	$result =& DBQuery($query);
	  	
	  	// Display an error message if the query failed.
	  	if (is_string($result)) {
			  displaylogin($lang['dberror_generic'] . ": " . $result);
				$returnValue = false;
	  	}
	  	else {
		  	// If the user does not have a sponsor for this calendar, then the user is not authorized or there are no sponsors (!).
				if ($result->numRows() == 0) {
					if ($_SESSION["AUTH_MAINADMIN"]) {
					  displaylogin($lang['dberror_nosponsor']);
					}
					else {
					  displaynotauthorized();
					}
					$returnValue = false;
				}
				
				// Assign the user's sponsor if only one record was found from the query.
				elseif ($result->numRows() == 1) {
				  $authorization =& $result->fetchRow(DB_FETCHMODE_ASSOC,0);
					$_SESSION["AUTH_SPONSORID"]= $authorization['sponsorid'];
		 			$_SESSION["AUTH_SPONSORNAME"] = $authorization['name'];
		 			$_SESSION["AUTH_SPONSORCOUNT"] = 1;
		 			$_SESSION["AUTH_ADMIN"] = ($_SESSION["AUTH_ADMIN"] || $authorization["admin"] == 1);
				}
				
				// If the user belongs to more than one sponsor, then display the form to select a sponsor.
				else {
		 			$_SESSION["AUTH_SPONSORCOUNT"] = $result->numRows();
		  		displaymultiplelogin();
			  	$returnValue = false;	
				}
				
				$result->free();
			}
		}
	}
	
	return $returnValue;
} // end: Function authorized()

/**
 * viewauthorized() checks if a user is allowed to view the main calendar (main.php) or export data (export.php, icalendar.php).
 * 
 * This is how the viewauthorized function executes:
 * 	1. If the userid and password are in the _POST, then set them (local scope only).
 * 	2a. If the calendar does not require authentication to view, then set that the user is allowed to view.
 * 	2b. If the userid and password is set...
 * 		A. If the username and password combo is valid then verify that the user has access to the calendar.
 * 		B. If the combo was bad or the user does not have access then output a message and set that the user is not allowed to view.
 * 	2c. If the user is already logged in then they should have access, so set that the user is allowed to view.
 * 	2d. Otherwise...
 * 		A. If the user is not using SSL, redirect them.
 * 		B. Show the login page.
 */
function viewauthorized() {
  $authok = 0; // Default that view authorization is not allowed.
  
  if (isset($_POST['login_userid']) && isset($_POST['login_password'])) {
	  $userid = $_POST['login_userid'];
	  $password = $_POST['login_password'];
	  $userid=strtolower($userid);
  }
	
	// If the calendar does not require authorization...
	if ( $_SESSION["VIEWAUTHREQUIRED"] == 0 ) {
	  $authok = 1;
	}
  
  // If it requires authorization,
  // and the username/password were submitted via POST...
	elseif (isset($userid) && isset($password)) {
    $userid=strtolower($userid);

    // checking authentication
		if ( ($authresult = userauthenticated($userid,$password)) === true ) {
			// checking authorization
			$result = DBQuery("SELECT * FROM vtcal_calendarviewauth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND userid='".sqlescape($userid)."'" );
			if ($result->numRows() > 0) {
  			$_SESSION["AUTH_USERID"] = $userid;
				$_SESSION["CALENDAR_LOGIN"] = $_SESSION["CALENDARID"];
				$authok = 1;
			}
		}
    
    if (!$authok) {
			// display login error message
      displaylogin($lang['login_failed']);
    }
  }
  
  // If it requires authorization,
  // and the username/password are stored in the session...
  elseif ( isset($_SESSION["AUTH_USERID"]) && !empty($_SESSION["AUTH_USERID"]) ) {
		$authok = 1;
	}
	
	// Otherwise, make sure the user is using HTTPS and give them the login page.
	else {
		$protocol = "http";
		$path = substr($_SERVER["PHP_SELF"],0,strrpos($_SERVER["PHP_SELF"],"/")+1);
		$page = substr($_SERVER["PHP_SELF"],strrpos($_SERVER["PHP_SELF"],"/")+1);
		if ( isset($_SERVER['HTTPS'])) { $protocol .= "s"; }
		if ( BASEURL != SECUREBASEURL && 
		    $protocol."://".$_SERVER["HTTP_HOST"].$path != SECUREBASEURL ) {
			redirect2URL(SECUREBASEURL.$page."?calendar=".$_SESSION["CALENDARID"]);
		}
		
    displaylogin();
  }
  
  return $authok;
} // end: function viewauthorized()

function logout() {
	unset($_SESSION["AUTH_USERID"]);
	unset($_SESSION["AUTH_SPONSORID"]);
	unset($_SESSION["AUTH_SPONSORNAME"]);
	unset($_SESSION["AUTH_ADMIN"]);
	unset($_SESSION["AUTH_MAINADMIN"]);
	unset($_COOKIE['CategoryFilter']);
	setcookie ("CategoryFilter", "", time()-(3600*24), BASEPATH, BASEDOMAIN); // delete filter cookie
}
?>