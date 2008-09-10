<?php
/*
1. Defines some color constants.
2. Includes other function files.
3. Defines various other contants.
4. Defines numerous functions:
		
		Misc Functions:
		----------------------------------------------------
		function getNewEventId()
		function feedback($msg,$type)
		function verifyCancelURL($httpreferer)
		function redirect2URL($url)
		function getFullCalendarURL()
		function sendemail2sponsor($sponsorname,$sponsoremail,$subject,$body)
		function sendemail2user($useremail,$subject,$body)
		function highlight_keyword($keyword, $text)
		function make_clickable($text)
		function removeslashes(&$event)
		function checkURL($url)
		function checkemail($email)
		function setVar(&$var,$value,$type)
		function lang($sTextKey)
		
		Generic Database Functions:
		----------------------------------------------------
		function DBopen()
		function DBclose($database)
		function DBQuery($database, $query)
		
		Authenticate users:
		----------------------------------------------------
		function checknewpassword(&$user)
		function checkoldpassword(&$user,$userid,$database)
		function displaylogin($errormsg,$database)
		function displaymultiplelogin($database, $errorMessage="")
		function displaynotauthorized($database)
		function userauthenticated($database,$userid,$password)
		function authorized($database)
		function viewauthorized($database)
		function logout()
		
		Get various information from the database:
		----------------------------------------------------
		function calendar_exists($calendarid)
		function setCalendarPreferences()
		function getNumCategories($database)
		function getCategoryName(&$database, $categoryid)
		function getCalendarName(&$database, $calendarid)
		function getSponsorCalendarName(&$database, $sponsorid)
		function getSponsorName(&$database, $sponsorid)
		function getSponsorURL(&$database, $sponsorid)
		function num_unapprovedevents($repeatid,$database)
		function userExistsInDB($database, $userid)
		function isValidUser($database, $userid)
		
		Date/Time Conversions & Formatting:
		----------------------------------------------------
		function datetocolor($month,$day,$year,$colorpast,$colortoday,$colorfuture)
		function datetoclass($month,$day,$year)
		function printeventdate(&$event)
		function printeventtime(&$event)
		function yearmonth2timestamp($year,$month)
		function yearmonthday2timestamp($year,$month,$day)
		function datetime2timestamp($year,$month,$day,$hour,$min,$ampm)
		function timestamp2datetime($timestamp)
		function timestamp2timenumber($timestamp)
		function timenumber2timelabel($timenum)
		function datetime2ISO8601datetime($year,$month,$day,$hour,$min,$ampm)
		function ISO8601datetime2datetime($ISO8601datetime)
		function disassemble_eventtime(&$event)
		function settimeenddate2timebegindate(&$event)
		function assemble_eventtime(&$event)
		function timestring($hour,$min,$ampm)
		function endingtime_specified(&$event)
		
		Message Windows:
		----------------------------------------------------
		function box_begin($class, $headertext, $showMenuButton=false)
		function box_end()
		function helpbox_begin()
		function helpbox_end()
		
		Event Date/Time Functions:
		----------------------------------------------------
		function inputdate($month,$monthvar,$day,$dayvar,$year,$yearvar)
		function readinrepeat($repeatid,&$event,&$repeat,$database)
		function repeatinput2repeatdef(&$event,&$repeat)
		function getfirstslice($s)
		function repeatdefdisassemble($repeatdef,&$frequency,&$interval,&$frequencymodifier,&$endyear,&$endmonth,&$endday)
		function printrecurrence($startyear,$startmonth,$startday,$repeatdef)
		function repeatdefdisassembled2repeatlist($startyear,$startmonth,$startday,$frequency,$interval,$frequencymodifier,$endyear, $endmonth, $endday)
		function producerepeatlist(&$event,&$repeat)
		function printrecurrencedetails(&$repeatlist)
		function repeatdef2repeatinput($repeatdef,&$event,&$repeat)
		
		Modification of events:
		----------------------------------------------------
		function deletefromevent($eventid,$database)
		function deletefromevent_public($eventid,$database)
		function repeatdeletefromevent($repeatid,$database)
		function repeatdeletefromevent_public($repeatid,$database)
		function deletefromrepeat($repeatid,$database)
		function insertintoevent($eventid,&$event,$database)
		function insertintoeventsql($calendarid,$eventid,&$event,$database)
		function insertintoevent_public(&$event,$database)
		function updateevent($eventid,&$event,$database)
		function updateevent_public($eventid,&$event,$database)
		function insertintotemplate($template_name,&$event,$database)
		function updatetemplate($templateid,$template_name,&$event,$database)
		function insertintorepeat($repeatid,&$event,&$repeat,$database)
		function updaterepeat($repeatid,&$event,&$repeat,$database)
		function publicizeevent($eventid,&$event,$database)
		function repeatpublicizeevent($eventid,&$event,$database)
*/
	
  require_once("datecalc.inc.php");
  require_once("header.inc.php");
  require_once("email.inc.php");
  
// Create an ID for an event that is as unique as possible.
function getNewEventId() {
  $random = rand(0,999);
  $id = time();
  if ($random<100) {
    if ($random<10) {
      $id .= "0";
    }
    $id .= "0";
  }
  return $id.$random;
}

// Used by the calendar admin scripts (e.g. update.php) to output small error messages.
function feedback($msg,$type) {
  echo '<span class="';
	if ($type==0) { echo "feedbackpos"; } // positive feedback
  if ($type==1) { echo "feedbackneg"; } // error message
  echo '">';
	echo $msg;
  echo '</span><br>';
}

// NOT USED
function verifyCancelURL($httpreferer) {
	if (empty($httpreferer)) {
		$httpreferer = "update.php";
	}
  return $httpreferer;
}

// Used by the calendar admin scripts (e.g. update.php)
// to fully redirect a visitor from one page to another
function redirect2URL($url) {
	if (empty($url)) {
		$url = "update.php";
	}
	if (preg_match("/^[a-z]+:\/\//i", $url) == 0)
	{
		$url = SECUREBASEURL . $url;
	}
	header("HTTP/1.1 301 Moved Permanently");
  header("Location: $url");
  return TRUE;
}

// Get the complete URL that points to the current calendar.
function getFullCalendarURL($calendarid) {
  if ( isset($_SERVER["HTTPS"]) ) { $calendarurl = "https"; } else { $calendarurl = "http"; } 
  $calendarurl .= "://".$_SERVER['HTTP_HOST'].substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'], "/"))."/main.php?calendarid=".urlencode($calendarid);
  return $calendarurl;
}

// Sends an email to a sponsor.
function sendemail2sponsor($sponsorname,$sponsoremail,$subject,$body) {
  $body.= "\n\n";
  $body.= "----------------------------------------\n";
  $body.= $_SESSION["NAME"]." \n";
  $body.= getFullCalendarURL($_SESSION["CALENDARID"])."\n";
  $body.= $_SESSION["ADMINEMAIL"]."\n";
  
  sendemail($sponsorname,$sponsoremail,lang('calendar_administration'),$_SESSION["ADMINEMAIL"],$subject,$body);
}

function sendemail2user($useremail,$subject,$body) {
  $body.= "\n\n";
  $body.= "----------------------------------------\n";
  $body.= $_SESSION["NAME"]."\n";
  $body.= getFullCalendarURL($_SESSION["CALENDARID"])."\n";
  $body.= $_SESSION["ADMINEMAIL"]."\n";
  
  sendemail($useremail,$useremail,lang('calendar_administration'),$_SESSION["ADMINEMAIL"],$subject,$body);
}

// highlights all occurrences of the keyword in the text
// case-insensitive
function highlight_keyword($keyword, $text) {
	$keyword = preg_quote($keyword);
	$newtext = preg_replace('/'.$keyword.'/Usi','<span style="background-color:#ffff99">\\0</span>',$text);
	return $newtext;
}

/**
 * Taken from phpBB 2.0.19 (from phpBB2/includes/bbcode.php)
 *
 * Rewritten by Nathan Codding - Feb 6, 2001.
 * - Goes through the given string, and replaces xxxx://yyyy with an HTML <a> tag linking
 * 	to that URL
 * - Goes through the given string, and replaces www.xxxx.yyyy[zzzz] with an HTML <a> tag linking
 * 	to http://www.xxxx.yyyy[/zzzz]
 * - Goes through the given string, and replaces xxxx@yyyy with an HTML mailto: tag linking
 *		to that email address
 * - Only matches these 2 patterns either after a space, or at the beginning of a line
 *
 * Notes: the email one might get annoying - it's easy to make it more restrictive, though.. maybe
 * have it require something like xxxx@yyyy.zzzz or such. We'll see.
 */
function make_clickable($text)
{
	$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);

	// pad it with a space so we can match things at the start of the 1st line.
	$ret = ' ' . $text;

	// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
	// xxxx can only be alpha characters.
	// yyyy is anything up to the first space, newline, comma, double quote or <
	$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);

	// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
	// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
	// zzzz is optional.. will contain everything up to the first space, newline, 
	// comma, double quote or <.
	$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);

	// matches an email@domain type address at the start of a line, or after a space.
	// Note: Only the followed chars are valid; alphanums, "-", "_" and or ".".
	$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

	// Remove our padding..
	$ret = substr($ret, 1);

	return($ret);
}

// remove slashes from event fields
function removeslashes(&$event) {
	if (get_magic_quotes_gpc()) {
	  $event['title']=stripslashes($event['title']);
	  $event['description']=stripslashes($event['description']);
	  $event['location']=stripslashes($event['location']);
	  $event['price']=stripslashes($event['price']);
	  $event['contact_name']=stripslashes($event['contact_name']);
	  $event['contact_phone']=stripslashes($event['contact_phone']);
	  $event['contact_email']=stripslashes($event['contact_email']);
	  $event['url']=stripslashes($event['url']);
	  $event['displayedsponsor']=stripslashes($event['displayedsponsor']);
	  $event['displayedsponsorurl']=stripslashes($event['displayedsponsorurl']);
  }
}

/* Make sure a URL starts with a protocol */
function checkURL($url) {
  return
    (empty($url) || 
		 strtolower(substr($url,0,7))=="http://" ||
		 strtolower(substr($url,0,8))=="https://"
		 );
}

/* Check that a e-mail address is valid */
function checkemail($email) {
  return
    ((!empty($email)) && (eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)));
}

// Run a sanity check on incoming request variables and set particular variables if checks are passed
function setVar(&$var,$value,$type) {
	// Since we are using the ISO-8859-1 we must handle characters from 127 to 159, which are invalid.
	// These typically come from Microsoft word or from other Web sites.
	$badchars = array(
		chr(133), // ...
		chr(145), // left single quote
		chr(146), // right single quote
		chr(147), // left double quote
		chr(148), // right double quote
		chr(149), // bullet
		chr(150), // ndash
		chr(151), // mdash
		chr(153)  // trademark
	);
	$goodchar = array(
		'...',    // ...
		"'",      // left single quote
		"'",      // right single quote
		'"',      // left double quote
		'"',      // right double quote
		chr(183), // bullet (converted to middle dot)
		'-',      // ndash
		'-',      // mdash
		'(TM)'    // trademark
	);
	$value = str_replace($badchars, $goodchar, $value);
	
	// Remove all other characters from 127 to 159
	$value = preg_replace("/[\x7F-\x9F]/","",$value);
	
	if (isset($value)) {
	  // first, remove any escaping that may have happened if magic_quotes_gpc is set to ON in php.ini
		if (get_magic_quotes_gpc()) {
		  if (is_array($value)) {
			  foreach ($value as $key=>$v) {
				  $value[$key] = stripslashes($v);
				}
			}
			else {
			  $value = stripslashes($value);
			}
		}
		
	  if (isValidInput($value, $type)) {
		  $var = $value;
			return;
		}
	}
	
  // unless something is explicitly allowed unset the variable
	$var = NULL;
	return;
}

// returns a string in a particular language
function lang($sTextKey) {
  if (isset($GLOBALS['lang'][$sTextKey])) {
		return $GLOBALS['lang'][$sTextKey];
  }
  else {
    require('languages/en.inc.php');
  	return $lang[$sTextKey];
  }
}

// opens a DB connection to postgres
function DBopen() {
  $database = DB::connect( DATABASE );
  return $database;
}

// closes a DB connection to postgres
function DBclose($database) {
  $database->disconnect();
}

function DBQuery($database, $query) {
	$result = $database->query( $query );
	
	// Write to the SQL log file if one is defined.
	if ( SQLLOGFILE!="" ) {
		$logfile = fopen(SQLLOGFILE, "a");
		if (!empty($_SESSION["AUTH_USERID"])) { $user = $_SESSION["AUTH_USERID"]; } else { $user = "anonymous"; }
		fputs($logfile, date( "Y-m-d H:i:s", time() )." ".$_SERVER["REMOTE_ADDR"]." ".$user." ".$_SERVER["PHP_SELF"]." ".$query."\n");
		fclose($logfile);	
	}
	
	return $result;
}

/* Make sure the password meets standards for a new password (e.g. not the same as their old password */
function checknewpassword(&$user) {
  /* include more sophisticated constraints here */
  if ($user['newpassword1']!=$user['newpassword2']) { return 1; }
  elseif ((empty($user['newpassword1'])) || (strlen($user['newpassword1']) < 5)) { return 2; }
  else { return 0; }
}

/* Verify the  user's old password in the database */
function checkoldpassword(&$user,$userid,$database) {
  $result = DBQuery($database, "SELECT * FROM vtcal_user WHERE id='".sqlescape($userid)."'" ); 
  $data = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	return
    ($data['password']!=crypt($user['oldpassword'],$data['password']));
}

// display login screen and errormsg (if exists)
function displaylogin($errormsg,$database) {
  global $lang;
  
  // Force HTTPS is the server is not being accessed via localhost.
	if ( $_SERVER['SERVER_ADDR'] != "127.0.0.1" ) {
		$protocol = "http";
		if ( isset($_SERVER['HTTPS'])) { $protocol .= "s"; }
		if ( BASEURL != SECUREBASEURL && $protocol."://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"] != SECUREBASEURL."update.php" ) {
			redirect2URL(SECUREBASEURL."update.php?calendar=".$_SESSION["CALENDARID"]);
		}
	}

  pageheader(lang('update_page_header'),
             "Login",
            "Update","",$database);
  box_begin("inputbox",lang('login'));

  if (!empty($errormsg)) {
    echo "<BR>\n";
    feedback($errormsg,1);
  }
	?>
  <DIV>
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
  </DIV>
	<?php
  box_end();

  require("footer.inc.php");
} // end: Function displaylogin

// display login screen
function displaymultiplelogin($database, $errorMessage="") {
  pageheader(lang('login'),
             lang('login'),
            "Update","",$database);
  box_begin("inputbox",lang('choose_sponsor_role'));
  
  if (!empty($errorMessage)) {
  	echo "<p>", htmlentities($errorMessage) ,"</p>";
  } else {
  	echo "<div>&nbsp;</div>";
  }
	?>
	<table cellpadding="2" cellspacing="2" border="0">
	<?php
	$result = DBQuery($database, "SELECT * FROM vtcal_auth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND userid='".sqlescape($_SESSION["AUTH_USERID"])."'");
	if ($result->numRows() > 0) {
    for ($i=0;$i < $result->numRows();$i++) {
      $authorization = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
  
	    // read sponsor name from DB
	    $r = DBQuery($database, "SELECT name FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($authorization['sponsorid'])."'");

      $sponsor = $r->fetchRow(DB_FETCHMODE_ASSOC,0);			
			
			echo "<tr><td>&nbsp;&nbsp;&nbsp;\n";
			echo "<a href=\"".$_SERVER["PHP_SELF"]."?authsponsorid=".urlencode($authorization['sponsorid']);
    	if (isset($GLOBALS["eventid"])) { 
			  echo "&eventid=",urlencode($GLOBALS["eventid"]);
			}
      if (isset($GLOBALS["httpreferer"])) { 
			  echo "&httpreferer=",urlencode($GLOBALS["httpreferer"]); 
			}
			echo "\">";
			echo htmlentities($sponsor['name']);
			echo "</a>";
			echo "</td></tr>\n";
		}
	}
	?>
	</table><?php
  box_end();

  require("footer.inc.php");
} // end: function displaymultiplelogin

function displaynotauthorized($database) {
  pageheader(lang('login'),
             lang('login'),
            "Update","",$database);
  box_begin("inputbox",lang('error_not_authorized'));
	?>
	<?php echo lang('error_not_authorized_message'); ?><br>
	<br>
	    <a href="helpsignup.php" target="newWindow"	onclick="new_window(this.href); return false"><?php echo lang('help_signup_link'); ?></a><br>
	<BR>
	<?php
  box_end();

  require("footer.inc.php");
} // end: Function displaynotauthorized


// Validate the username and password.
function userauthenticated($database,$userid,$password) {
	if ( AUTH_DB ) {
		$result = DBQuery( $database, "SELECT * FROM vtcal_user WHERE id='".sqlescape($userid)."'" ); 
    if ($result->numRows() > 0) {
			$u = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			if ( crypt($password,$u['password'])==$u['password'] ) {
				$_SESSION["AUTH_TYPE"] = "DB";
			  return true;
			}
		}
	}
	if ( AUTH_LDAP ) {
		//$host = LDAP_HOST;
		//$port = LDAP_PORT;
		//$bindUser = LDAP_BIND_USER;
		//$bindPassword = LDAP_BIND_PASSWORD;
		//$pid = $userid;
		//$credential = $password;
		
		// Create the base search filter using the specified userfield.
		$searchFilter = '(' . LDAP_USERFIELD . '=' . $userid . ')';
		
		// If an additional search filter was specified, then append it to the userfield filter
		if (LDAP_SEARCH_FILTER != '') {
			$searchFilter = '(&' . $searchFilter . LDAP_SEARCH_FILTER . ')';
		}
		
		// Make sure the userid and password are specified.
		if (isset($userid) && $userid != '' && isset($password)) {
		
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
								return true;
							} 
							else {
								//print('LDAP failure');
								return "Password is incorrect. Please try again. (LDAP)";
							}
						}
						else {
							//print('User not found in LDAP');
							return "User-ID not found. (LDAP)";
						}
						
						// Clean up
						ldap_free_result($result);
						
					}
					else {
						return "An error occured while searching the LDAP server for your username.";
					}
					ldap_close($ldap);
				}
				else {
					return "Could not connect to the LDAP server due to an authentication problem.";
				}
			} 
			else {
				return "Could not connect to the login server. (LDAP)";
			}
		}
	}
	
	if (AUTH_HTTP ) {
		require_once("HTTP/Request.php");

		$req =& new HTTP_Request(AUTH_HTTP_URL);
		$req->setBasicAuth($userid, $password);
		
		$response = $req->sendRequest();
		
		if (PEAR::isError($response)) {
			return "An error occurred while connecting to the login server. (HTTP)";
		}
		else {
			if ($req->getResponseCode() == 200) {
				$_SESSION["AUTH_TYPE"] = "HTTP";
				
				if (AUTH_HTTP_CACHE) {
					$passhash = crypt($password);
					$result = DBQuery( $database, "INSERT INTO vtcal_auth_httpcache (ID, PassHash, CacheDate) VALUES ('".sqlescape($userid)."', '".sqlescape($passhash)."', Now()) ON DUPLICATE KEY UPDATE PassHash='".sqlescape($passhash)."', CacheDate=Now()" );
				}
				
				return true;
			}
			else {
				if (AUTH_HTTP_CACHE) {
					$result = DBQuery( $database, "SELECT PassHash FROM vtcal_auth_httpcache WHERE ID = '".sqlescape($userid)."' AND DateDiff(CacheDate, Now()) > -".AUTH_HTTP_CACHE_EXPIRATIONDAYS);
					if ($result->numRows() > 0) {
						$record = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
						$passhash = $record['PassHash'];
						
						if (crypt($password, $passhash) == $passhash) {
							return true;
						}
					}
				}
			}
		}
	}
	
	return false; // default rule
}

/**
 * authorized() checks if the person is logged in and has authorization to view the calendar management pages (e.g. update.php)
 *
 * This is how the following function executes:
 * 1. Grab the login username/password from _POST, if they exist.
 * 2. 
 */
function authorized($database) {
	// Get sponsor related URL values
  if (isset($_GET['authsponsorid'])) { setVar($authsponsorid,$_GET['authsponsorid'],'sponsorid'); } else { unset($authsponsorid); }
  $changesponsorid = isset($_GET['changesponsorid']);
  
  // Get username/password POST values.
  if (isset($_POST['login_userid']) && isset($_POST['login_password'])) {
  	setVar($userid,strtolower($_POST['login_userid']),'userid');
	  $password = $_POST['login_password'];
  }
  else {
  	unset($userid);
  	unset($password);
  }
  
  $authresult = false;
  
  // Check the authenticity of the username/password, if they are set and are not different from the currently logged in user.
	if ( $_SESSION["AUTH_USERID"] != $userid && isset($userid) && isset($password) ) {
    // checking authentication of PID/password
		if ( ($authresult = userauthenticated($database,$userid,$password)) === true ) {
			$_SESSION["AUTH_USERID"] = $userid;
		}
    else {
		  displaylogin(lang('login_failed') . "<br>Reason: " . $authresult, $database);
			return false;
    }
  }
  
  // Removed the current sponsor ID if we are changing the sponsor
  if ($changesponsorid) {
  	unset($_SESSION["AUTH_SPONSORID"]);
  }
	
	// The user is already logged in, but wants to change his/her sponsor...
  if ( isset($_SESSION["AUTH_USERID"]) && isset($authsponsorid) ) {
    
    // Verify that the user does in fact belong to that sponsor group.
  	$result = DBQuery( $database, "SELECT * FROM vtcal_auth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND userid='".sqlescape($_SESSION["AUTH_USERID"])."' AND sponsorid='".sqlescape($authsponsorid)."'" );
  	
  	// If the user does not belong to the sponsor that he/she submitted...
		if ($result->numRows() == 0) {
			displaymultiplelogin($database, lang('error_bad_sponsorid'));
			return FALSE;
		}
		
		// Otherwise, assign the user to the requested sponsor.
		else {
			$_SESSION["AUTH_SPONSORID"]= $authsponsorid;
 			$_SESSION["AUTH_SPONSORNAME"] = getSponsorName($database, $authsponsorid);
			
			// determine if the sponsor is administrator for the calendar
		  $_SESSION["AUTH_ADMIN"] = false;
      $result = DBQuery($database, "SELECT admin FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($authsponsorid)."'" );
  		if ($result->numRows() > 0) {
			  $s = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			  if ( $s["admin"]==1 ) {
  			  $_SESSION["AUTH_ADMIN"] = true;
	      }
			}

			// determine if the user is one of the main administrators
		  $_SESSION["AUTH_MAINADMIN"] = false;
      $result = DBQuery($database, "SELECT * FROM vtcal_adminuser WHERE id='".sqlescape($_SESSION["AUTH_USERID"])."'" );
  		if ($result->numRows() > 0) {
			  $a = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			  if ( $a["id"]==$_SESSION["AUTH_USERID"] ) { 
  			  $_SESSION["AUTH_MAINADMIN"] = true;
	      }
			}
			
			return TRUE;
	  }
	} // end: if ( isset($_SESSION["AUTH_USERID"]) && isset($authsponsorid) )
	
	
	// If the sponsor ID is not set, then we need to verify the user's access to this calendar...
  if ( isset($_SESSION["AUTH_USERID"]) && !isset($_SESSION["AUTH_SPONSORID"]) ) {
  	$result = DBQuery($database, "SELECT * FROM vtcal_auth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND userid='".sqlescape($_SESSION["AUTH_USERID"])."'" );
  	
  	// if the user does not have a sponsor for this calendar, then the user is not authorized.
		if ($result->numRows() == 0) {
		  displaynotauthorized($database);
			return false;
		}
		
		// The user has only access to one sponsor
		elseif ($result->numRows() == 1) {
		  $authorization = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			$_SESSION["AUTH_SPONSORID"]= $authorization['sponsorid'];
 			$_SESSION["AUTH_SPONSORNAME"] = getSponsorName($database, $authorization['sponsorid']);
 			$_SESSION["AUTH_SPONSORCOUNT"] = 1;

			// determine if the sponsor is administrator for the calendar
		  $_SESSION["AUTH_ADMIN"] = false;
      $result = DBQuery($database, "SELECT admin FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($authorization['sponsorid'])."'" );
  		if ($result->numRows() > 0) {
			  $s = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			  if ( $s["admin"]==1 ) { 
  			  $_SESSION["AUTH_ADMIN"] = true;
	      }			
			}

			// determine if the user is one of the main administrators
		  $_SESSION["AUTH_MAINADMIN"] = false;
      $result = DBQuery($database, "SELECT * FROM vtcal_adminuser WHERE id='".sqlescape($_SESSION["AUTH_USERID"])."'" );
  		if ($result->numRows() > 0) {
			  $a = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
			  if ( $a["id"]==$_SESSION["AUTH_USERID"] ) { 
  			  $_SESSION["AUTH_MAINADMIN"] = true;
	      }			
			}
			
			return true;
		}
		
		// If the user belongs to more than one sponsor, then display the form to select a sponsor.
		else {
 			$_SESSION["AUTH_SPONSORCOUNT"] = $result->numRows();
  		displaymultiplelogin($database);
	  	return false;	
		}
	}
	
	// If the user is fully logged in...
  if ( isset($_SESSION["AUTH_USERID"]) && isset($_SESSION["AUTH_SPONSORID"]) && $_SESSION["AUTH_SPONSORNAME"] ) {
    return true;
	}
	
	// Otherwise, show the login form.
	else {
	  displaylogin("",$database);
		return false;
	}
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
function viewauthorized($database) {
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
		if ( ($authresult = userauthenticated($database,$userid,$password)) === true ) {
			// checking authorization
			$result = DBQuery($database, "SELECT * FROM vtcal_calendarviewauth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND userid='".sqlescape($userid)."'" );
			if ($result->numRows() > 0) {
  			$_SESSION["AUTH_USERID"] = $userid;
				$_SESSION["CALENDAR_LOGIN"] = $_SESSION["CALENDARID"];
				$authok = 1;
			}
		}
    
    if (!$authok) {
			// display login error message
      displaylogin("Error! Your login failed. Please try again.",$database);
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
		
    displaylogin("",$database);
  }
  
  return $authok;
} // end: function viewauthorized()

function logout() {
	unset($_SESSION["AUTH_USERID"]);
	unset($_SESSION["AUTH_SPONSORID"]);
	unset($_SESSION["AUTH_SPONSORNAME"]);
	unset($_SESSION["AUTH_ADMIN"]);
	unset($_COOKIE['CategoryFilter']);
	setcookie ("CategoryFilter", "", time()-(3600*24), BASEPATH, BASEDOMAIN); // delete filter cookie
}

function getCalendarData($calendarid, $database) {
	if ( DB::isError( $result = $database->query( "SELECT * FROM vtcal_calendar WHERE id='".sqlescape($calendarid)."'" ) ) ) {
		return DB::errorMessage($result);
	}
	elseif ($result->numRows() != 1) {
		return $result->numRows();
	}
	else {
		return $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	}
}

function calendar_exists($calendarid) {
  $database = DBopen();
  $result = DBQuery($database, "SELECT count(id) FROM vtcal_calendar WHERE id='".sqlescape($calendarid)."'" ); 
  $r = $result->fetchRow(0);
  $database->disconnect();
  return ($r[0]==1);
}

function setCalendarPreferences() {
	$database = DBopen();
	$result = DBQuery($database, "SELECT * FROM vtcal_calendar WHERE id='".sqlescape($_SESSION["CALENDARID"])."'" );
	$calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	
	$_SESSION["TITLE"] = $calendar['title'];
	$_SESSION["NAME"] = $calendar['name'];
	$_SESSION["HEADER"] = $calendar['header'];
	$_SESSION["FOOTER"] = $calendar['footer'];
	$_SESSION["VIEWAUTHREQUIRED"] = $calendar['viewauthrequired'];
	$_SESSION["FORWARDEVENTDEFAULT"] = $calendar['forwardeventdefault'];
	
	$_SESSION["BGCOLOR"] = $calendar['bgcolor'];
	$_SESSION["MAINCOLOR"] = $calendar['maincolor'];
	$_SESSION["TODAYCOLOR"] = $calendar['todaycolor'];
	$_SESSION["PASTCOLOR"] = $calendar['pastcolor'];		
	$_SESSION["FUTURECOLOR"] = $calendar['futurecolor'];		
	$_SESSION["TEXTCOLOR"] = $calendar['textcolor'];		
	$_SESSION["LINKCOLOR"] = $calendar['linkcolor'];		
	$_SESSION["GRIDCOLOR"] = $calendar['gridcolor'];
	
	$result = DBQuery($database, "SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND admin='1'" ); 
	$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
	$_SESSION["ADMINEMAIL"] = $sponsor['email'];
}

function getNumCategories($database) {
  $result = DBQuery($database, "SELECT count(*) FROM vtcal_category WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."'" ); 
  $r = $result->fetchRow(0);
  return $r[0];
}

/* Get the name of a category from the database */
function getCategoryName(&$database, $categoryid) {
	$result = DBQuery($database, "SELECT name FROM vtcal_category WHERE id='".sqlescape($categoryid)."'" );
  if ($result->numRows() > 0) {
    $category = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    return $category['name'];
	}
	else {
	  return "";
	}
}

/* Get the name of a calendar from the database */
function getCalendarName(&$database, $calendarid) {
	$result = DBQuery($database, "SELECT name FROM vtcal_calendar WHERE id='".sqlescape($calendarid)."'" );
  if ($result->numRows() > 0) {
    $calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    return $calendar['name'];
	}
	else {
	  return "";
	}
}

/* Get the name of a calendar that a sponsor belongs to from the database */
function getSponsorCalendarName(&$database, $sponsorid) {
	$result = DBQuery($database, "SELECT c.name FROM vtcal_sponsor AS s, vtcal_calendar AS c WHERE s.id = '".sqlescape($sponsorid)."' AND c.id = s.calendarid");
  if ($result->numRows() > 0) {
    $calendar = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    return $calendar['name'];
	}
	else {
	  return "";
	}
}

/* Get the name of a sponsor from the database */
function getSponsorName(&$database, $sponsorid) {
	$result = DBQuery($database, "SELECT name FROM vtcal_sponsor WHERE id='".sqlescape($sponsorid)."'" );
  if ($result->numRows() > 0) {
    $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    return $sponsor['name'];
	}
	else {
	  return "";
	}
}

/* Get the URL of a sponsor from the database */
function getSponsorURL(&$database, $sponsorid) {
	$result = DBQuery($database, "SELECT url FROM vtcal_sponsor WHERE id='".sqlescape($sponsorid)."'" );
  if ($result->numRows() > 0) {
    $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    return $sponsor['url'];
	}
	else {
	  return "";
	}
}

// Get the number of unapproved events for an entire calendar. */
function num_unapprovedevents($repeatid,$database) {
  $result = DBQuery($database, "SELECT id FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND repeatid='".sqlescape($repeatid)."' AND approved=0"); 
  return $result->numRows();
}

// returns true if a particular userid exists in the database
function userExistsInDB($database, $userid) {
  if ( AUTH_DB ) {
  	$query = "SELECT count(id) FROM vtcal_user WHERE id='".sqlescape($userid)."'";
    $result = DBQuery($database, $query ); 
    $r = $result->fetchRow(0);
    if ($r[0]>0) { return true; }
	}
	
  return false; // default rule
}

// returns true if the user-id is valid
function isValidUser($database, $userid) {
	
	// If we are using HTTP authentication, we must assume all
	// users are valid, since we have no way of verifying HTTP users.
	if ( AUTH_HTTP ) {
		return true;
	}
	
  if ( AUTH_DB ) {
  	$query = "SELECT count(id) FROM vtcal_user WHERE id='".sqlescape($userid)."'";
    $result = DBQuery($database, $query ); 
    $r = $result->fetchRow(0);
    if ($r[0]>0) { return true; }
	}
	
	if ( AUTH_LDAP ) {
	  // in the future have some code that checks against LDAP
	  return preg_match(REGEXVALIDUSERID, $userid);
	}

  return false; // default rule
}

// determines a background color according to the day
function datetocolor($month,$day,$year,$colorpast,$colortoday,$colorfuture) {
  $datediff = Delta_Days($month,$day,$year,date("m"),date("d"),date("Y"));

  if ($datediff > 0) {
    $color=$colorpast;
  }
  elseif ($datediff < 0) {
    $color=$colorfuture;
  }
  else {
    $color=$colortoday;
  }

  return $color;
}

// determines the CSS class (past, today, future) according to the day
function datetoclass($month,$day,$year) {
  $datediff = Delta_Days($month,$day,$year,date("m"),date("d"),date("Y"));

  if ($datediff > 0) {
    $class="past";
  }
  elseif ($datediff < 0) {
    $class="future";
  }
  else {
    $class="today";
  }

  return $class;
}

// NOT USED
function printeventdate(&$event) {
  $event_timebegin_month = $event['timebegin_month'];
  if (strlen($event_timebegin_month) == 1) { $event_timebegin_month = "0".$event_timebegin_month; }
  $event_timebegin_day   = $event['timebegin_day'];
  if (strlen($event_timebegin_day) == 1) { $event_timebegin_day = "0".$event_timebegin_day; }

  return $event_timebegin_month.'/'.$event_timebegin_day.'/'.$event['timebegin_year'];
}

// NOT USED
function printeventtime(&$event) {
  $event_timebegin_hour = $event['timebegin_hour'];
  if (strlen($event_timebegin_hour) == 1) { $event_timebegin_hour = "0".$event_timebegin_hour; }
  $event_timebegin_min = $event['timebegin_min'];
  if (strlen($event_timebegin_min) == 1) { $event_timebegin_min = "0".$event_timebegin_min; }
  $event_timeend_hour = $event['timeend_hour'];
  if (strlen($event_timeend_hour) == 1) { $event_timeend_hour = "0".$event_timeend_hour; }
  $event_timeend_min = $event['timeend_min'];
  if (strlen($event_timeend_min) == 1) { $event_timeend_min = "0".$event_timeend_min; }

  return $event_timebegin_hour.':'.$event_timebegin_min.$event['timebegin_ampm'].'-'.$event_timeend_hour.':'.$event_timeend_min.$event['timeend_ampm'];
}

// NOTUSED
/* converts a year/month-pair to a timestamp in the format "1999-09" */
function yearmonth2timestamp($year,$month) {
  $timestamp="$year-";
  if (strlen($month)==1) { $timestamp.="0"; }
  $timestamp.="$month";

  return $timestamp;
}

// converts a year/month/day-pair to a timestamp in the format "1999-09-17"
function yearmonthday2timestamp($year,$month,$day) {
  $timestamp="$year-";
  if (strlen($month)==1) { $timestamp.="0"; }
  $timestamp.="$month";
  if (strlen($day)==1) { $timestamp.="0"; }
  $timestamp.="$day";

  return $timestamp;
}

/* converts a date/time to a timestamp in the format "1999-09-16 18:57:00" */
function datetime2timestamp($year,$month,$day,$hour,$min,$ampm) {
  global $use_ampm;
  $timestamp="$year-";
  if (strlen($month)==1) { $timestamp.="0$month-"; } else { $timestamp.="$month-"; }
  if (strlen($day)==1) { $timestamp.="0$day "; } else { $timestamp.="$day "; }
  if($use_ampm){  // if am, pm format is used
	 if (($ampm=="pm") && ($hour!=12)) { $hour+=12; }; /* 12pm is noon */
     if (($ampm=="am") && ($hour==12)) { $hour=0; }; /* 12am is midnight */
  }
  if (strlen($hour)==1) { $timestamp.="0$hour:"; } else { $timestamp.="$hour:"; }
  if (strlen($min)==1) { $timestamp.="0$min:00"; } else { $timestamp.="$min:00"; }

  return $timestamp;
}

/* converts a timestamp "1999-09-16 18:57:00" to a date/time format */
function timestamp2datetime($timestamp) {
   global $use_ampm;
  /* split the date/time field-info into its parts */
  /* format returned by postgres is "1999-09-10 07:30:00" */
  $datetime['year']  = substr($timestamp,0,4);
  $datetime['month'] = substr($timestamp,5,2);
  if (substr($datetime['month'],0,1)=="0") { /* remove leading "0" */
    $datetime['month'] = substr($datetime['month'],1,1);
  }
  $datetime['day']   = substr($timestamp,8,2);
  if (substr($datetime['day'],0,1)=="0") { /* remove leading "0" */
    $datetime['day'] = substr($datetime['day'],1,1);
  }

  $datetime['hour']  = substr($timestamp,11,2);

  /* convert 24 hour into 1-12am/pm  if am, pm in data format is used*/
  if($use_ampm){  
     $datetime['ampm'] = "pm";
     if ($datetime['hour'] < 12) {
       if ($datetime['hour'] == 0) { $datetime['hour'] = 12; }
       $datetime['ampm'] = "am";
     } else {
       if ($datetime['hour'] > 12) { $datetime['hour'] -= 12; }
     }
  }
  
  if (substr($datetime['hour'],0,1)=="0") { /* remove leading "0" */
    $datetime['hour'] = substr($datetime['hour'],1,1);
  }
  $datetime['min']=substr($timestamp,14,2);

  return $datetime;
}

/* converts the time from a timestamp "1999-09-16 18:57:00" to a number representing the number of seconds that have passed in that day. */
function timestamp2timenumber($timestamp) {
  $hour  = substr($timestamp,11,2);
  $minute = substr($timestamp,14,2);
  return ($hour * 60) + $minute;
}

// converts the number of minutes from 00:00:00 to a label for output.
function timenumber2timelabel($timenum) {
	//$hoursText = "";
	//$minutesText = "";
	
	if ($timenum > 59) {
		$hours = floor($timenum / 60);
		$timenum -= $hours * 60;
		//$hoursText = $hours . "hr";
	}

	if ($timenum > 0) {
		$minutes = $timenum;
		//$minutesText = $timenum . "m";
	}
	
	if (isset($hours) && isset($minutes)) {
		return $hours . 'hr ' . $minutes . 'm';
	}
	elseif (isset($hours) && !isset($minutes)) {
		if ($hours > 1) { return $hours . ' hours'; }
		else { return $hours . ' hour'; }
	}
	elseif (!isset($hours) && isset($minutes)) {
		return $minutes . ' min';
	}
	else {
		return "";
	}
}

// returns the date&time in the ISO8601format: 20000211T235900 (used by vCalendar)
function datetime2ISO8601datetime($year,$month,$day,$hour,$min,$ampm) {
  $datetime = strtr(datetime2timestamp($year,$month,$day,$hour,$min,$ampm)," ","T");
  $datetime = str_replace("-","",$datetime);
  $datetime = str_replace(":","",$datetime);

  return $datetime;
}

// converts a vCalendar timestamp "20000211T235900" to a date/time format
function ISO8601datetime2datetime($ISO8601datetime) {
  $datetime['year']  = substr($ISO8601datetime,0,4);
  $datetime['month'] = substr($ISO8601datetime,4,2);
  if (substr($datetime['month'],0,1)=="0") { // remove leading "0"
    $datetime['month'] = substr($datetime['month'],1,1);
  }
  $datetime['day']   = substr($ISO8601datetime,6,2);
  if (substr($datetime['day'],0,1)=="0") { // remove leading "0"
    $datetime['day'] = substr($datetime['day'],1,1);
  }

  $datetime['hour']  = substr($ISO8601datetime,9,2);

  // convert 24 hour into 1-12am/pm
  $datetime['ampm'] = "pm";
  if ($datetime['hour'] < 12) {
    if ($datetime['hour'] == 0) { $datetime['hour'] = 12; }
    $datetime['ampm'] = "am";
  } else {
    if ($datetime['hour'] > 12) { $datetime['hour'] -= 12; }
  }
  if (substr($datetime['hour'],0,1)=="0") { // remove leading "0"
    $datetime['hour'] = substr($datetime['hour'],1,1);
  }
  $datetime['min']=substr($ISO8601datetime,11,2);

  return $datetime;
}

/* construct event_timbegin(timeend)_month/day/year/hour/min/ampm from timestamp */
function disassemble_eventtime(&$event) {
  $timebegin = timestamp2datetime($event['timebegin']);
  $event['timebegin_year']  = $timebegin['year'];
  $event['timebegin_month'] = $timebegin['month'];
  $event['timebegin_day']   = $timebegin['day'];
  $event['timebegin_hour']  = $timebegin['hour'];
  $event['timebegin_min']   = $timebegin['min'];
  $event['timebegin_ampm']  = $timebegin['ampm'];

  $timeend = timestamp2datetime($event['timeend']);
  $event['timeend_year']  = $timeend['year'];
  $event['timeend_month'] = $timeend['month'];
  $event['timeend_day']   = $timeend['day'];
  $event['timeend_hour']  = $timeend['hour'];
  $event['timeend_min']   = $timeend['min'];
  $event['timeend_ampm']  = $timeend['ampm'];

  return 0;
}

// returns a string like "5:00pm" from the input "5", "0", "pm"
function timestring($hour,$min,$ampm) {
  if (strlen($min)==1) { $min = "0".$min; }

  return $hour.":".$min.$ampm;
}

// returns true if the ending time is not 11:59pm (meaning: not specified)
function endingtime_specified(&$event) {
  return !($event['timeend_hour']==11 &&
          $event['timeend_min']==59 &&
          $event['timeend_ampm']=="pm");
}

// for non-recurring events the ending time equals the starting time
function settimeenddate2timebegindate(&$event) {
  $event['timeend_year'] = $event['timebegin_year'];
  $event['timeend_month'] = $event['timebegin_month'];
  $event['timeend_day'] = $event['timebegin_day'];
}

// construct event timestamps "timebegin&timeend" from month/day/year/hour/min/ampm
function assemble_eventtime(&$event) {
  global $day_beg_h, $day_end_h, $use_ampm;
  $event['timebegin'] = datetime2timestamp(
                        $event['timebegin_year'],
                        $event['timebegin_month'],
                        $event['timebegin_day'],
                        $event['timebegin_hour'],
                        $event['timebegin_min'],
                        $event['timebegin_ampm']);

  // if event doesn't have an ending time, set it to the end of the day
  if ($event['timeend_hour']==0) {
    $event['timeend_hour']=$day_end_h;
    $event['timeend_min']=59;
    if($use_ampm)
       $event['timeend_ampm']="pm";
  }

  $event['timeend'] =   datetime2timestamp(
                        $event['timeend_year'],
                        $event['timeend_month'],
                        $event['timeend_day'],
                        $event['timeend_hour'],
                        $event['timeend_min'],
                        $event['timeend_ampm']);
  return 0;
}

// prints out the HTML code a box begins with, use box_end to finish the box
function box_begin($class, $headertext, $showMenuButton=false) {
	
	if ($showMenuButton) {
		?><div id="MenuButton"><table border="0" cellpadding="3" cellspacing="0"><tr><td><b><a href="update.php"><?php echo lang('back_to_menu'); ?></a></b></td></tr></table></div><?php
	}
	
	?><div id="UpdateBlock"><div style="border: 1px solid #666666; padding: 8px;"><?php
	
  if (!empty($headertext)) {
    echo "<h2>".htmlentities($headertext).":</h2>";
	}
	
}

// prints out the HTML code a box ends with, use box_begin to begin the box
function box_end() {
	?></div></div><?php
}

// prints out the HTML code a helpbox begins with, use helpbox_end to finish the helpbox
function helpbox_begin() {
	?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
  <head>
    <title><?php echo lang('help'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta content="en-us" http-equiv=language>
    <link href="stylesheet.php" rel="stylesheet" type="text/css">
  </head>
  <body bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onLoad="this.window.focus()">
		<br>
		<table border="0" cellPadding="5" cellSpacing="0">
			<tr>
				<td bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>">&nbsp;</td>
				<td bgcolor="#eeeeee">  
				<?php
				} // end: function helpbox_begin
				
				// prints out the HTML code a helpbox ends with, use helpbox_begin to begin the helpbox
				function helpbox_end() {
				?>
				<td bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>">&nbsp;</td>
			</tr>
		</table>
		<br>
  </body>
	</html>
	<?php
}

// display input fields for a date (month, day, year)
function inputdate($month,$monthvar,$day,$dayvar,$year,$yearvar) {
  $unknownvalue = "???"; // this is printed when the value of input field is unspecified
  echo "<SELECT name=\"",$monthvar,"\" id=\"",$monthvar,"\">\n";

  //if ($month==0) {
  //  echo "<OPTION selected value=\"0\">",$unknownvalue,"</OPTION>\n";
  //}
  /* print list with months and select the one read from the DB */
  for ($i=1; $i<=12; $i++) {
    print '<OPTION ';
    if ($month==$i) { echo "selected "; }
    if (date("n")==$i && $month==0) { echo "selected "; }
    echo "value=\"$i\">",Month_to_Text($i),"</OPTION>\n";
  }
  echo "</SELECT>\n";
  echo "<SELECT name=\"",$dayvar,"\" id=\"",$dayvar,"\">\n";

  // if ($day==0) {
  // echo "<OPTION selected value=\"0\">",$unknownvalue,"</OPTION>\n";
  //}

  // print list with days and select the one read from the DB
  for ($i=1;$i<=31;$i++) {
    echo "<OPTION ";
    if ($day==$i) { echo "selected "; }
    if (date("j")==$i && $day==0) { echo "selected "; }
    echo "value=\"",$i,"\">",$i,"</OPTION>\n";
  }
  echo "</SELECT>\n";
  echo "<SELECT name=\"",$yearvar,"\" id=\"",$yearvar,"\">\n";

  // print list with years and select the one read from the DB
  if (!empty($year) && $year < date("Y")) { echo "<OPTION selected value=\"",$year,"\">",$year,"</OPTION>\n"; }
  for ($i=date("Y");$i<=date("Y")+3;$i++) {
    echo "<OPTION ";
    if ($year==$i) { echo "selected "; }
    echo "value=\"",$i,"\">",$i,"</OPTION>\n";
  }
  echo "</SELECT>\n";
  
  if (!isset($GLOBALS['popupCalendarJavascriptIsLoaded'])) {
     $calendarLanguageFile = 'scripts/jscalendar/lang/calendar-'.LANGUAGE.'.js';
	 if (!file_exists($calendarLanguageFile)) {
	     $calendarLanguageFile = 'scripts/jscalendar/lang/calendar-en.js';
	 }
	 echo '
  <link rel="stylesheet" type="text/css" media="all" href="scripts/jscalendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <script type="text/javascript" src="scripts/jscalendar/calendar.js"></script>
  <script type="text/javascript" src="',$calendarLanguageFile,'"></script>
  <script type="text/javascript" src="scripts/jscalendar/calendar-setup.js"></script>
';
	  $GLOBALS['popupCalendarJavascriptIsLoaded'] = TRUE;
  }
  
  $uniqueid = strtr($monthvar, '[]','__');
  
  $firstDay = WEEK_STARTING_DAY;
  echo <<<END
<input type="hidden" name="popupCalendarDate" id="popupCalendarDate_$uniqueid" value="$month/$day/$year">
<img src="images/nuvola/16x16/apps/date.png" width="16" height="16" id="showPopupCalendarImage_$uniqueid" 
title="Date selector" border="0" align="baseline" style="cursor: pointer;" hspace="3">
<script type="text/javascript"><!--
function onSelectDate(cal) {
  var p = cal.params;
  if (cal.dateClicked) {
	  cal.callCloseHandler();
	  var month = document.getElementById("$monthvar");
	  monthPerhapsWithLeadingZero = cal.date.print("%m");
	  if (monthPerhapsWithLeadingZero.charAt(0) == "0") {
	  	month.value = monthPerhapsWithLeadingZero.substr(1);
	  }
	  else {
	    month.value = monthPerhapsWithLeadingZero;
	  }
	  var date = document.getElementById("$dayvar");
	  date.value = cal.date.print("%e");
	  var year = document.getElementById("$yearvar");
	  year.value = cal.date.print("%Y");
	  
	  document.getElementById("popupCalendarDate_$uniqueid").value = cal.date.print("%m/%e/%Y");
  }
};

Calendar.setup({
	inputField     :    "popupCalendarDate_$uniqueid",     // id of the input field
	ifFormat       :    "%m/%e/%Y",      // format of the input field
	button         :    "showPopupCalendarImage_$uniqueid",  // trigger for the calendar (button ID)
	align          :    "br",           // alignment (defaults to "Bl")
	weekNumbers    :    false,
	firstDay       :    $firstDay,
	onSelect       :    onSelectDate
});
//--></script>

END;
} // end: function inputdate

function readinrepeat($repeatid,&$event,&$repeat,$database) {
  $query = "SELECT * FROM vtcal_event_repeat WHERE id = '".sqlescape($repeatid)."'";
	$result = DBQuery($database, $query ); 
  $r = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

  repeatdef2repeatinput($r['repeatdef'],$event,$repeat);

  $startdate = timestamp2datetime($r['startdate']);
  $event['timebegin_year']  = $startdate['year'];
  $event['timebegin_month'] = $startdate['month'];
  $event['timebegin_day']   = $startdate['day'];
}

// takes the values from the inputfields on the form and constructs a
// repeat-definition string in vCalendar format, e.g. "MP2 3+ TH 20000211T235900"
function repeatinput2repeatdef(&$event,&$repeat) {
  if ($repeat['mode'] == 1) {
     if ($repeat['interval1']=="every") { $interval = "1"; }
     if ($repeat['interval1']=="everyother") { $interval = "2"; }
     if ($repeat['interval1']=="everythird") { $interval = "3"; }
     if ($repeat['interval1']=="everyfourth") { $interval = "4"; }

     if ($repeat['frequency1']=="day") { $frequency = "D"; }
     if ($repeat['frequency1']=="week") { $frequency = "W"; }
     if ($repeat['frequency1']=="month") { $frequency = "M"; }
     if ($repeat['frequency1']=="year") { $frequency = "YD"; }
     if ($repeat['frequency1']=="monwedfri") { $frequency = "W"; $frequencymodifier="MO WE FR"; }
     if ($repeat['frequency1']=="tuethu") { $frequency = "W"; $frequencymodifier="TU TH"; }
     if ($repeat['frequency1']=="montuewedthufri") { $frequency = "W"; $frequencymodifier="MO TU WE TH FR"; }
     if ($repeat['frequency1']=="satsun") { $frequency = "W"; $frequencymodifier="SA SU"; }
     if ($repeat['frequency1']=="sunday") { $frequency = "W"; $frequencymodifier="SU"; }
     if ($repeat['frequency1']=="monday") { $frequency = "W"; $frequencymodifier="MO"; }
     if ($repeat['frequency1']=="tuesday") { $frequency = "W"; $frequencymodifier="TU"; }
     if ($repeat['frequency1']=="wednesday") { $frequency = "W"; $frequencymodifier="WE"; }
     if ($repeat['frequency1']=="thursday") { $frequency = "W"; $frequencymodifier="TH"; }
     if ($repeat['frequency1']=="friday") { $frequency = "W"; $frequencymodifier="FR"; }
     if ($repeat['frequency1']=="saturday") { $frequency = "W"; $frequencymodifier="SA"; }
  }
  elseif ($repeat['mode'] == 2) {
     $frequency = "MP";

     if ($repeat['frequency2modifier1']=="first") { $frequencymodifier = "1+"; }
     if ($repeat['frequency2modifier1']=="second") { $frequencymodifier = "2+"; }
     if ($repeat['frequency2modifier1']=="third") { $frequencymodifier = "3+"; }
     if ($repeat['frequency2modifier1']=="fourth") { $frequencymodifier = "4+"; }
     if ($repeat['frequency2modifier1']=="last") { $frequencymodifier = "1-"; }

     if ($repeat['frequency2modifier2']=="sun") { $frequencymodifier.=" SU"; }
     if ($repeat['frequency2modifier2']=="mon") { $frequencymodifier.=" MO"; }
     if ($repeat['frequency2modifier2']=="tue") { $frequencymodifier.=" TU"; }
     if ($repeat['frequency2modifier2']=="wed") { $frequencymodifier.=" WE"; }
     if ($repeat['frequency2modifier2']=="thu") { $frequencymodifier.=" TH"; }
     if ($repeat['frequency2modifier2']=="fri") { $frequencymodifier.=" FR"; }
     if ($repeat['frequency2modifier2']=="sat") { $frequencymodifier.=" SA"; }

     if ($repeat['interval2']=="month") { $interval="1"; }
     if ($repeat['interval2']=="2months") { $interval="2"; }
     if ($repeat['interval2']=="3months") { $interval="3"; }
     if ($repeat['interval2']=="4months") { $interval="4"; }
     if ($repeat['interval2']=="6months") { $interval="6"; }
     if ($repeat['interval2']=="year") { $interval="12"; }
  } // end: elseif ($repeat[mode] == 2)

  // construct a repeat definition using the vCalendar standard
  $repeatdef = $frequency.$interval." ";
  if (!empty($frequencymodifier)) { $repeatdef.=$frequencymodifier." "; }
  $repeatdef .= datetime2ISO8601datetime($event['timeend_year'],
                                         $event['timeend_month'],
                                         $event['timeend_day'],
                                         11,59,"pm");
  return $repeatdef;
} // end: function repeatinput2repeatdef(&$event,&$repeat)

// separate the string at the first space
function getfirstslice($s) {
  $spacepos = strpos($s," ");
  if ($spacepos==0) {
    $part1 = $s;
    $part2 = "";
  }
  else {
    $part1 = substr($s,0,$spacepos);
    $part2 = substr($s,$spacepos+1,strlen($s)-$spacepos-1);
  }

  return array($part1, $part2);
}

// splits a vcalendar-style repeatdef string like "MP2 3+ TH 20000211T235900" into
// its parts "frequency","interval","frequencymodifier" and enddatetime (year,month,day,hour,min,ampm)
// Attention!: it does not implement the whole vCalendar recurrence grammar, but rather
//             the subset used by the VTEC interface
function repeatdefdisassemble($repeatdef,
                              &$frequency,&$interval,&$frequencymodifier,
                              &$endyear,&$endmonth,&$endday) {
  $frequencymodifier = "";
  list($frequencyinterval,$remainder) = getfirstslice($repeatdef);

  if (substr($frequencyinterval,0,2)=="MP") {  // it's of the format: "MP2 3+ TH 19991224T135000"
    $frequency = "MP";
    $interval = substr($frequencyinterval,2,strlen($frequencyinterval)-2);
    list($frequencymodifier1,$frequencymodifier2,$enddatetimeISO8601) = explode(" ",$remainder);

    $frequencymodifier = $frequencymodifier1." ".$frequencymodifier2;
    $enddatetime = ISO8601datetime2datetime($enddatetimeISO8601);
  }
  elseif (substr($frequencyinterval,0,2)=="YD") {
    $frequency = "YD";
    $interval = $frequencyinterval[2];
    $enddatetime = ISO8601datetime2datetime($remainder);
  }
  elseif ($frequencyinterval[0]=="D" || $frequencyinterval[0]=="M") {
    $frequency = $frequencyinterval[0];
    $interval = $frequencyinterval[1];
    $enddatetime = ISO8601datetime2datetime($remainder);
  }
  elseif ($frequencyinterval[0]=="W") {
    $frequency = $frequencyinterval[0];
    $interval = $frequencyinterval[1];

    // parse the string and add all but the last component (which is the date) to the "modifier"
    do {
      list($part,$newremainder) = getfirstslice($remainder);

      if (!empty($newremainder)) {
       if (!empty($frequencymodifier)) { $frequencymodifier.=" "; }
       $frequencymodifier.=$part;
       $remainder = $newremainder;
      }
      else {
       $enddatetime = ISO8601datetime2datetime($part);
      }
    } while (!empty($newremainder));
  }

  $endyear = $enddatetime['year'];
  $endmonth = $enddatetime['month'];
  $endday = $enddatetime['day'];

  return 1;
} // end: Function repeatdefdisassemble

// prints the definition for a recurring event
function printrecurrence($startyear,$startmonth,$startday,
                         $repeatdef) {
  if (!empty($repeatdef)) {
    repeatdefdisassemble($repeatdef,
                         $frequency,$interval,$frequencymodifier,
                         $endyear,$endmonth,$endday);
    echo lang('recurring')," ";
    if ($frequency=="MP") {
      list($frequencymodifiernumber,$frequencymodifierday) = getfirstslice($frequencymodifier);
      echo lang('on_the'),' ';

      if ($frequencymodifiernumber[1]=="-") { echo lang('last'); }
      else {
	if ($frequencymodifiernumber=="1+") { echo lang('first'); }
        elseif ($frequencymodifiernumber=="2+") { lang('second'); }
        elseif ($frequencymodifiernumber=="3+") { lang('third'); }
        elseif ($frequencymodifiernumber=="4+") { lang('fourth'); }
      }
      echo " ";
      if ($frequencymodifierday=="SU") { echo lang('sunday'); }
      elseif ($frequencymodifierday=="MO") { echo lang('monday'); }
      elseif ($frequencymodifierday=="TU") { echo lang('tuesday'); }
      elseif ($frequencymodifierday=="WE") { echo lang('wednesday'); }
      elseif ($frequencymodifierday=="TH") { echo lang('thursday'); }
      elseif ($frequencymodifierday=="FR") { echo lang('friday'); }
      elseif ($frequencymodifierday=="SA") { echo lang('saturday'); }

      echo ' ',lang('of_the_month_every'),' ';

      if ($interval==1) { echo lang("month"); }
      elseif ($interval==2) { echo lang("other_month"); }
      elseif ($interval>=3 && $interval<=6) { echo $interval,' ',lang('months'); }
      elseif ($interval==12) { echo lang("year"); }

    } // end: if ($frequency=="MP")
    else {
      if ($interval==1) { echo lang("every"); }
      elseif ($interval==2) { echo lang("every_other"); }
      elseif ($interval==3) { echo lang("every_third"); }
      elseif ($interval==4) { echo lang("every_fourth"); }
      echo ' ';

      if ($frequency=="D") { echo lang("day"); }
      elseif ($frequency=="M") { echo lang("month"); }
      elseif ($frequency=="Y") { echo lang("year"); }
      elseif ($frequency=="W") {
        echo " ";
        if (empty($frequencymodifier)) { echo lang("week"); }
        else {
          $frequencymodifier = " ".$frequencymodifier;

	  $comma = 0;
	  if (strpos($frequencymodifier,"SU")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("sunday");
            $comma=1;
	  }
	  if (strpos($frequencymodifier,"MO")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("monday");
            $comma=1;
	  }
	  if (strpos($frequencymodifier,"TU")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("tuesday");
            $comma=1;
	  }
	  if (strpos($frequencymodifier,"WE")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("wednesday");
            $comma=1;
	  }
	  if (strpos($frequencymodifier,"TH")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("thursday");
            $comma=1;
	  }
	  if (strpos($frequencymodifier,"FR")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("friday");
            $comma=1;
	  }
	  if (strpos($frequencymodifier,"SA")!=0) {
	    if ($comma) { echo ", "; }
	    echo lang("saturday");
            $comma=1;
	  }
	} // end: else: if (empty($frequencymodifier))
      } // end: elseif ($frequency=="W")
    } // end: else: if ($frequency=="MP")

    echo '; ',lang('starting'),' ',Encode_Date_US($startmonth,$startday,$startyear);
    echo '; ',lang('ending'),' ',Encode_Date_US($endmonth,$endday,$endyear);

  } // end: if (!empty($repeatdef))
  else {
    echo lang('no_recurrences_defined');
  }
} // end: function printrecurrence

// transform a startdate and a repeat-definition in the vCalendar format,
// e.g. "MP2 3+ TH 20000211T235900" into an array of single dates
function repeatdefdisassembled2repeatlist($startyear,$startmonth,$startday,
                                          $frequency,
                                          $interval,
                                          $frequencymodifier,
                                          $endyear, $endmonth, $endday) {

  $repeatlist = array();
  $startdateJD = JulianToJD($startmonth,$startday,$startyear);
  $enddateJD = JulianToJD($endmonth,$endday,$endyear);
  $ecount = 0;

  if ($frequency=="D") { // recurring daily
    $dateJD = $startdateJD + $ecount * $interval;
    while ($dateJD <= $enddateJD) {
      $repeatlist[$ecount]=$dateJD; // store this date in the list (array)
      $ecount++;
      $dateJD = $startdateJD + $ecount * $interval;
    }
  }
  elseif ($frequency=="M") { // recurring same date monthly
    $enddate = yearmonthday2timestamp($endyear,$endmonth,$endday);
    $year = $startyear;
    $month = $startmonth;
    $date=yearmonthday2timestamp($year,$month,$startday);
    while ($date <= $enddate) {
      // check if it is a valid date and not for example Feb, 30th,...
      if (checkdate($month,$startday,$year)) {
        $dateJD = JulianToJD($month,$startday,$year);
        $repeatlist[$ecount]=$dateJD; // store this date in the list (array)
        $ecount++;
      }
      $month+=$interval;
      if ($month>12) { $month -= 12; $year++; }
      $date=yearmonthday2timestamp($year,$month,$startday);
    }
  }
  elseif ($frequency=="YD") { // recurring same date yearly
    $enddate = yearmonthday2timestamp($endyear,$endmonth,$endday);
    $year = $startyear;
    $date=yearmonthday2timestamp($year,$startmonth,$startday);
    while ($date <= $enddate) {
      // check if it is a valid date
      if (checkdate($startmonth,$startday,$year)) {
        $dateJD = JulianToJD($startmonth,$startday,$year);
        $repeatlist[$ecount]=$dateJD; // store this date in the list (array)
        $ecount++;
      }
      $year+=$interval;
      $date=yearmonthday2timestamp($year,$startmonth,$startday);
    }
  }
  elseif ($frequency=="W") { // recurring in weekly cycles
    if (empty($frequencymodifier)) {
      $dateJD = $startdateJD + $ecount * $interval*7;
      while ($dateJD <= $enddateJD) {
        $repeatlist[$ecount]=$dateJD; // store this date in the list (array)
        $ecount++;
        $dateJD = $startdateJD + $ecount * $interval*7;
      }
    }
    else {
      // determine the Sunday of the week
      $dow = Day_of_Week($startmonth,$startday,$startyear);
      $weekfrom = Add_Delta_Days($startmonth,$startday,$startyear,-$dow);

      $weekfromJD = JulianToJD($weekfrom[month],$weekfrom[day],$weekfrom[year]);

      // prepend a space to allow searching the string by testing "strpos(..) != 0"
      $frequencymodifier = " ".$frequencymodifier;

      $i = 0;
      $dateJD = $weekfromJD + $i * $interval*7;

      while ($dateJD <= $enddateJD) {
	      if (strpos($frequencymodifier,"MO")!=0) {
          if ($dateJD+1 >= $startdateJD && $dateJD+1 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+1; $ecount++; }
        }
	     if (strpos($frequencymodifier,"TU")!=0) {
          if ($dateJD+2 >= $startdateJD && $dateJD+2 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+2; $ecount++; }
        }
	     if (strpos($frequencymodifier,"WE")!=0) {
          if ($dateJD+3 >= $startdateJD && $dateJD+3 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+3; $ecount++; }
        }
	     if (strpos($frequencymodifier,"TH")!=0) {
          if ($dateJD+4 >= $startdateJD && $dateJD+4 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+4; $ecount++; }
        }
	     if (strpos($frequencymodifier,"FR")!=0) {
          if ($dateJD+5 >= $startdateJD && $dateJD+5 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+5; $ecount++; }
        }
	     if (strpos($frequencymodifier,"SA")!=0) {
          if ($dateJD+6 >= $startdateJD && $dateJD+6 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+6; $ecount++; }
        }
        if (strpos($frequencymodifier,"SU")!=0) {
          if ($dateJD+7 >= $startdateJD && $dateJD+7 <= $enddateJD) { $repeatlist[$ecount]=$dateJD+7; $ecount++; }
        }

        $i++;
	      $dateJD = $weekfromJD + $i * $interval*7;
      }
    }
  }
  elseif ($frequency=="MP") { // recurring in monthly cycles like "MP2 3+ TH 20000512T..." or "MP12 1- FR 19990922T..."
    list($frequencymodifiernumber,$frequencymodifierday) = explode(" ",$frequencymodifier);

    if ($frequencymodifiernumber[1]=="-") { $last = 1; } else { $last = 0; }
    $frequencymodifiernumber = $frequencymodifiernumber[0];

    if ($frequencymodifierday=="SU") { $dow = 0; }
    elseif ($frequencymodifierday=="MO") { $dow = 1; }
    elseif ($frequencymodifierday=="TU") { $dow = 2; }
    elseif ($frequencymodifierday=="WE") { $dow = 3; }
    elseif ($frequencymodifierday=="TH") { $dow = 4; }
    elseif ($frequencymodifierday=="FR") { $dow = 5; }
    elseif ($frequencymodifierday=="SA") { $dow = 6; }

    $enddate = yearmonthday2timestamp($endyear,$endmonth,$endday);
    $year = $startyear;
    $month = $startmonth;
    $date=yearmonthday2timestamp($year,$month,1);
    while ($date <= $enddate) {

      $monthfromJD = JulianToJD($month,1,$year);
      $firstofmonth_dow = Day_of_Week($month,1,$year);

      // determine the date of the first occurrence of the specified weekday
      if ($firstofmonth_dow<=$dow) { $firstday = 1 + $dow-$firstofmonth_dow; }
      else { $firstday = 1 + (7-$firstofmonth_dow)+$dow; }
      $firstdayJD = $monthfromJD + $firstday-1;

      if ($last) {
        // determine if "last" means the 4th or the 5th weekday of the months
        // by testing whether the 5th weekday exist
	if (checkdate($month,$firstday+28,$year)) { $weeks=4; }
        else { $weeks=3; }
      }
      else {
        $weeks = $frequencymodifiernumber-1;
      }
      // e.g. we get the 3rd Thursday by adding 2 weeks to the first Thursday
      $dayJD = $firstdayJD + $weeks*7;

      if ($dayJD <= $enddateJD && $dayJD >= $startdateJD) {
        $repeatlist[$ecount]=$dayJD; // store this date in the list (array)
	      $ecount++;
      }

      $month+=$interval;
      if ($month>12) { $month -= 12; $year++; }
      $date=yearmonthday2timestamp($year,$month,1);
    }

  } // end: elseif ($frequency=="MP")


  return $repeatlist;
} // end: function repeatdefdisassembled2repeatlist

// takes the values from the input form and outputs a list containing dates
// it uses the vCalendar specification to store repeating event information
function producerepeatlist(&$event,&$repeat) {
  $repeatdef = repeatinput2repeatdef($event,$repeat);

  repeatdefdisassemble($repeatdef,
                       $frequency,$interval,$frequencymodifier,
                       $endyear,$endmonth,$endday);

  $repeatlist = repeatdefdisassembled2repeatlist($event['timebegin_year'],
                                                 $event['timebegin_month'],
                                                 $event['timebegin_day'],
                                                 $frequency,
                                                 $interval,
                                                 $frequencymodifier,
                                                 $endyear,
                                                 $endmonth,
                                                 $endday);
  return $repeatlist;
}

// prints out all the days contained in a recurrencelist (array)
function printrecurrencedetails(&$repeatlist) {
  if (sizeof($repeatlist)==0) {
    echo lang('recurrence_produces_no_dates');
  }
  else {
    echo "(",lang('resulting_dates_are');

    $comma = 0;
    while ($dateJD = each($repeatlist)) {
      if ($comma) { echo "; "; }
      $d = Decode_Date_US(JDToJulian($dateJD['value']));
      echo " ",Day_of_Week_Abbreviation(Day_of_Week($d['month'],$d['day'],$d['year'])),", ",JDToJulian($dateJD['value']);
      $comma = 1;
    }
    echo ")";
  }
}

// translates the contents of a repeat definition string in vCalendar format
// to the input variables required for the input form
function repeatdef2repeatinput($repeatdef,&$event,&$repeat) {
  repeatdefdisassemble($repeatdef,$frequency,$interval,$frequencymodifier,$endyear,$endmonth,$endday);

  if ($frequency=="MP") {
    $repeat['mode'] = 2;
    list($frequency2modifier1,$frequency2modifier2) = explode(" ",$frequencymodifier);

    if ($frequency2modifier1=="1+") { $repeat['frequency2modifier1']="first"; }
    if ($frequency2modifier1=="2+") { $repeat['frequency2modifier1']="second"; }
    if ($frequency2modifier1=="3+") { $repeat['frequency2modifier1']="third"; }
    if ($frequency2modifier1=="4+") { $repeat['frequency2modifier1']="fourth"; }
    if ($frequency2modifier1=="1-") { $repeat['frequency2modifier1']="last"; }

    if ($frequency2modifier2=="SU") { $repeat['frequency2modifier2']="sun"; }
    if ($frequency2modifier2=="MO") { $repeat['frequency2modifier2']="mon"; }
    if ($frequency2modifier2=="TU") { $repeat['frequency2modifier2']="tue"; }
    if ($frequency2modifier2=="WE") { $repeat['frequency2modifier2']="wed"; }
    if ($frequency2modifier2=="TH") { $repeat['frequency2modifier2']="thu"; }
    if ($frequency2modifier2=="FR") { $repeat['frequency2modifier2']="fri"; }
    if ($frequency2modifier2=="SA") { $repeat['frequency2modifier2']="sat"; }

    if ($interval=="1") { $repeat['interval2']="month"; }
    if ($interval=="2") { $repeat['interval2']="2months"; }
    if ($interval=="3") { $repeat['interval2']="3months"; }
    if ($interval=="4") { $repeat['interval2']="4months"; }
    if ($interval=="6") { $repeat['interval2']="6months"; }
    if ($interval=="12") { $repeat['interval2']="year"; }
  }
  else {
    $repeat['mode'] = 1;

    if ($interval=="1") { $repeat['interval1']="every"; }
    if ($interval=="2") { $repeat['interval1']="everyother"; }
    if ($interval=="3") { $repeat['interval1']="everythird"; }
    if ($interval=="4") { $repeat['interval1']="everyfourth"; }

    if ($frequency=="D") { $repeat['frequency1']="day"; }
    if ($frequency=="M") { $repeat['frequency1']="month"; }
    if ($frequency=="YD") { $repeat['frequency1']="year"; }
    if ($frequency=="W") {
      if (empty($frequencymodifier)) { $repeat['frequency1']="week"; }
      elseif ($frequencymodifier=="MO WE FR") { $repeat['frequency1']="monwedfri"; }
      elseif ($frequencymodifier=="TU TH") { $repeat['frequency1']="tuethu"; }
      elseif ($frequencymodifier=="MO TU WE TH FR") { $repeat['frequency1']="montuewedthufri"; }
      elseif ($frequencymodifier=="SA SU") { $repeat['frequency1']="satsun"; }
      elseif ($frequencymodifier=="SU") { $repeat['frequency1']="sunday"; }
      elseif ($frequencymodifier=="MO") { $repeat['frequency1']="monday"; }
      elseif ($frequencymodifier=="TU") { $repeat['frequency1']="tuesday"; }
      elseif ($frequencymodifier=="WE") { $repeat['frequency1']="wednesday"; }
      elseif ($frequencymodifier=="TH") { $repeat['frequency1']="thursday"; }
      elseif ($frequencymodifier=="FR") { $repeat['frequency1']="friday"; }
      elseif ($frequencymodifier=="SA") { $repeat['frequency1']="saturday"; }
    }
  } // end: else:   if ($frequency=="MP")

  $event['timeend_year'] = $endyear;
  $event['timeend_month'] = $endmonth;
  $event['timeend_day'] = $endday;

  return 1;
} // end: Function repeatdef2repeatinput($repeatdef,&$event,&$repeat)

/* Remove an event from the event table (aka: still under review) for the current calendar,
and from the default calendar if the event was submitted to it. */
function deletefromevent($eventid,$database) {
  $query = "DELETE FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'";
  $result = DBQuery($database, $query ); 

  // delete event from default calendar if it had been forwarded
	if ( $_SESSION["CALENDARID"] != "default" ) {
	  // delete existing events in default calendar with same id
    $query = "DELETE FROM vtcal_event WHERE calendarid='default' AND id='".sqlescape($eventid)."'";
    $result = DBQuery($database, $query ); 
	} // end: if ( $_SESSION["CALENDARID"] != "default" )
}

/* Remove an event from the event_public table (aka: the event will no longer be public) */
function deletefromevent_public($eventid,$database) {
  $query = "DELETE FROM vtcal_event_public WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'";
  $result = DBQuery($database, $query ); 
}

/* Remove all repeating entries from the event table (aka: still under review) for the current calendar,
and from the default calendar if the event was submitted to it. */
function repeatdeletefromevent($repeatid,$database) {
  if (!empty($repeatid)) {
		$query = "DELETE FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND repeatid='".sqlescape($repeatid)."'";
		$result = DBQuery($database, $query ); 
	
		// delete event from default calendar if it had been forwarded
		if ( $_SESSION["CALENDARID"] != "default" ) {
			// delete existing events in default calendar with same id
			$query = "DELETE FROM vtcal_event WHERE calendarid='default' AND repeatid='".sqlescape($repeatid)."'";
			$result = DBQuery($database, $query ); 
		} // end: if ( $_SESSION["CALENDARID"] != "default" )
	}
}

/* Remove all repeating entries from the event_public table (aka: the event will no longer be public),
and from the default calendar if the event was submitted to it. */
function repeatdeletefromevent_public($repeatid,$database) {
  if (!empty($repeatid)) {
    $query = "DELETE FROM vtcal_event_public WHERE calendarid='".$_SESSION["CALENDARID"]."' AND repeatid='".sqlescape($repeatid)."'";
    $result = DBQuery($database, $query ); 

		// delete event from default calendar if it had been forwarded
		if ( $_SESSION["CALENDARID"] != "default" ) {
			// delete existing events in default calendar with same id
			$query = "DELETE FROM vtcal_event_public WHERE calendarid='default' AND repeatid='".sqlescape($repeatid)."'";
			$result = DBQuery($database, $query ); 
		} // end: if ( $_SESSION["CALENDARID"] != "default" )
	}
}

/* Remove all repeating entries from the event table (aka: still under review) for the current calendar. */
function deletefromrepeat($repeatid,$database) {
  if (!empty($repeatid)) {
    $query = "DELETE FROM vtcal_event_repeat WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($repeatid)."'";
    $result = DBQuery($database, $query ); 
	}
}

function insertintoevent($eventid,&$event,$database) {
  return insertintoeventsql($_SESSION["CALENDARID"],$eventid,$event,$database);
}

function insertintoeventsql($calendarid,$eventid,&$event,$database) {
  $changed = date ("Y-m-d H:i:s");
  $query = "INSERT INTO vtcal_event (calendarid,id,approved,rejectreason,timebegin,timeend,repeatid,sponsorid,displayedsponsor,displayedsponsorurl,title,wholedayevent,categoryid,description,location,price,contact_name,contact_phone,contact_email,url,recordchangedtime,recordchangeduser,showondefaultcal,showincategory) ";
  $query.= "VALUES ('".sqlescape($calendarid)."','".sqlescape($eventid)."',0,'";
  if (!empty($event['rejectreason'])) {
		$query.= sqlescape($event['rejectreason']);
	}
	$query.= "','";
	$query.= sqlescape($event['timebegin'])."','";
	$query.= sqlescape($event['timeend'])."','".sqlescape($event['repeatid'])."','";
	$query.= sqlescape($event['sponsorid'])."','".sqlescape($event['displayedsponsor'])."','";
	$query.= sqlescape($event['displayedsponsorurl'])."','".sqlescape($event['title'])."','";
	$query.= sqlescape($event['wholedayevent'])."','".sqlescape($event['categoryid'])."','";
	$query.= sqlescape($event['description'])."','".sqlescape($event['location'])."','";
	$query.= sqlescape($event['price'])."','".sqlescape($event['contact_name'])."','";
	$query.= sqlescape($event['contact_phone'])."','".sqlescape($event['contact_email'])."','";
	$query.= sqlescape($event['url'])."','".sqlescape($changed)."','";
	if (isset($event['showondefaultcal'])) { $showondefaultcal = $event['showondefaultcal']; } else { $showondefaultcal = 0; }
	$query.= sqlescape($_SESSION["AUTH_USERID"])."','".sqlescape($showondefaultcal)."','";
	if (isset($event['showincategory'])) { $showincategory = $event['showincategory']; } else { $showincategory = 0; }
	$query.= sqlescape($showincategory)."')";
  $result = DBQuery($database, $query ); 
  echo $result;
  return $eventid;
}

function insertintoevent_public(&$event,$database) {
  $changed = date ("Y-m-d H:i:s");
  $query = "INSERT INTO vtcal_event_public (calendarid,id,timebegin,timeend,repeatid,sponsorid,displayedsponsor,displayedsponsorurl,title,wholedayevent,categoryid,description,location,price,contact_name,contact_phone,contact_email,url,recordchangedtime,recordchangeduser) VALUES ";
  $query.= "('".sqlescape($_SESSION["CALENDARID"])."','".sqlescape($event['id'])."','";
	$query.= sqlescape($event['timebegin'])."','";
	$query.= sqlescape($event['timeend'])."','".sqlescape($event['repeatid'])."','";
	$query.= sqlescape($event['sponsorid'])."','".sqlescape($event['displayedsponsor'])."','";
	$query.= sqlescape($event['displayedsponsorurl'])."','".sqlescape($event['title'])."','";
	$query.= sqlescape($event['wholedayevent'])."','".sqlescape($event['categoryid'])."','";
	$query.= sqlescape($event['description'])."','".sqlescape($event['location'])."','";
	$query.= sqlescape($event['price'])."','".sqlescape($event['contact_name'])."','";
	$query.= sqlescape($event['contact_phone'])."','".sqlescape($event['contact_email'])."','";
	$query.= sqlescape($event['url'])."','".sqlescape($changed)."','";
	$query.= sqlescape($_SESSION["AUTH_USERID"])."')";

  $result = DBQuery($database, $query ); 
}

function updateevent($eventid,&$event,$database) {
  $changed = date ("Y-m-d H:i:s");
  $query = "UPDATE vtcal_event SET approved=0, rejectreason='".sqlescape($event['rejectreason']);
	$query.= "',timebegin='".sqlescape($event['timebegin'])."',timeend='".sqlescape($event['timeend']);
	$query.= "',repeatid='".sqlescape($event['repeatid'])."',sponsorid='".sqlescape($event['sponsorid']);
	$query.= "',displayedsponsor='".sqlescape($event['displayedsponsor'])."',displayedsponsorurl='".sqlescape($event['displayedsponsorurl']);
	$query.= "',title='".sqlescape($event['title'])."',wholedayevent='".sqlescape($event['wholedayevent']);
	$query.= "',categoryid='".sqlescape($event['categoryid'])."',description='".sqlescape($event['description']);
	$query.= "',location='".sqlescape($event['location'])."',price='".sqlescape($event['price']);
	$query.= "',contact_name='".sqlescape($event['contact_name'])."',contact_phone='".sqlescape($event['contact_phone']);
	$query.= "',contact_email='".sqlescape($event['contact_email'])."',url='".sqlescape($event['url']);
	$query.= "',recordchangedtime='".sqlescape($changed)."',recordchangeduser='".sqlescape($_SESSION["AUTH_USERID"]);
	$query.= "',showondefaultcal='".sqlescape($event['showondefaultcal'])."',showincategory='".sqlescape($event['showincategory'])."' ";
	$query.= "WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'";
  $result = DBQuery($database, $query ); 
}

function updateevent_public($eventid,&$event,$database) {
  $changed = date ("Y-m-d H:i:s");
  $query = "UPDATE vtcal_event_public SET timebegin='".sqlescape($event['timebegin']);
  $query.= "',timeend='".sqlescape($event['timeend'])."',repeatid='".sqlescape($event['repeatid']);
	$query.= "',sponsorid='".sqlescape($event['sponsorid'])."',displayedsponsor='".sqlescape($event['displayedsponsor']);
	$query.= "',displayedsponsorurl='".sqlescape($event['displayedsponsorurl'])."',title='".sqlescape($event['title']);
	$query.= "',wholedayevent='".sqlescape($event['wholedayevent'])."',categoryid='".sqlescape($event['categoryid']);
	$query.= "',description='".sqlescape($event['description'])."',location='".sqlescape($event['location']);
	$query.= "',price='".sqlescape($event['price'])."',contact_name='".sqlescape($event['contact_name']);
	$query.= "',contact_phone='".sqlescape($event['contact_phone'])."',contact_email='".sqlescape($event['contact_email']);
	$query.= "',url='".sqlescape($event['url'])."',recordchangedtime='".sqlescape($changed);
	$query.= "',recordchangeduser='".sqlescape($_SESSION["AUTH_USERID"]);
	$query.= "' WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'";
  $result = DBQuery($database, $query ); 
}

function insertintotemplate($template_name,&$event,$database) {
  $changed = date ("Y-m-d H:i:s");
  $query = "INSERT INTO vtcal_template (calendarid,name,sponsorid,displayedsponsor,displayedsponsorurl,title,wholedayevent,categoryid,description,location,price,contact_name,contact_phone,contact_email,url,recordchangedtime,recordchangeduser) ";
  $query.= "VALUES ('".sqlescape($_SESSION["CALENDARID"])."','".sqlescape($template_name);
	$query.= "','".sqlescape($event['sponsorid'])."','".sqlescape($event['displayedsponsor']);
	$query.= "','".sqlescape($event['displayedsponsorurl'])."','".sqlescape($event['title']);
	$query.= "','".sqlescape($event['wholedayevent'])."','".sqlescape($event['categoryid']);
	$query.= "','".sqlescape($event['description'])."','".sqlescape($event['location']);
	$query.= "','".sqlescape($event['price'])."','".sqlescape($event['contact_name']);
	$query.= "','".sqlescape($event['contact_phone'])."','".sqlescape($event['contact_email']);
	$query.= "','".sqlescape($event['url'])."','".sqlescape($changed)."','".sqlescape($_SESSION["AUTH_USERID"])."')";
  $result = DBQuery($database, $query ); 
}

function updatetemplate($templateid,$template_name,&$event,$database) {
  $changed = date ("Y-m-d H:i:s");
  $query = "UPDATE vtcal_template SET name='".sqlescape($template_name)."',sponsorid='".sqlescape($event['sponsorid']);
	$query.= "',displayedsponsor='".sqlescape($event['displayedsponsor'])."',displayedsponsorurl='".sqlescape($event['displayedsponsorurl']);
	$query.= "',title='".sqlescape($event['title'])."',wholedayevent='".sqlescape($event['wholedayevent']);
	$query.= "',categoryid='".sqlescape($event['categoryid'])."',description='".sqlescape($event['description']);
	$query.= "',location='".sqlescape($event['location'])."',price='".sqlescape($event['price']);
	$query.= "',contact_name='".sqlescape($event['contact_name'])."',contact_phone='".sqlescape($event['contact_phone']);
	$query.= "',contact_email='".sqlescape($event['contact_email'])."',url='".sqlescape($event['url']);
	$query.= "',recordchangedtime='".sqlescape($changed)."',recordchangeduser='".sqlescape($_SESSION["AUTH_USERID"]);
	$query.= "' WHERE sponsorid='".sqlescape($_SESSION["AUTH_SPONSORID"])."' AND id='".sqlescape($templateid)."'";
  $result = DBQuery($database, $query ); 
}

function insertintorepeat($repeatid,&$event,&$repeat,$database) {
  $repeat['startdate'] = datetime2timestamp($event['timebegin_year'],$event['timebegin_month'],$event['timebegin_day'],0,0,"am");
  $repeat['enddate'] = datetime2timestamp($event['timeend_year'],$event['timeend_month'],$event['timeend_day'],0,0,"am");
  $repeatdef = repeatinput2repeatdef($event,$repeat);
  $changed = date ("Y-m-d H:i:s");

  // write record into repeat table
  $query = "INSERT INTO vtcal_event_repeat (calendarid,id,repeatdef,startdate,enddate,recordchangedtime,recordchangeduser) ";
	$query.= "VALUES ('".sqlescape($_SESSION["CALENDARID"])."','".sqlescape($repeatid)."','".sqlescape($repeatdef)."','".sqlescape($repeat['startdate'])."','".sqlescape($repeat['enddate'])."','".sqlescape($changed)."','".sqlescape($_SESSION["AUTH_USERID"])."')";
  $result = DBQuery($database, $query ); 
  $repeat['id'] = $repeatid;
  
  return $repeat['id'];
}

function updaterepeat($repeatid,&$event,&$repeat,$database) {
  $repeat['startdate'] = datetime2timestamp($event['timebegin_year'],$event['timebegin_month'],$event['timebegin_day'],0,0,"am");
  $repeat['enddate'] = datetime2timestamp($event['timeend_year'],$event['timeend_month'],$event['timeend_day'],0,0,"am");
  $repeatdef = repeatinput2repeatdef($event,$repeat);

  // write record into repeat table
  $query = "UPDATE vtcal_event_repeat SET repeatdef='".sqlescape($repeatdef)."',startdate='";
	$query.= sqlescape($repeat['startdate'])."',enddate='".sqlescape($repeat['enddate']);
	$query.= "' WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($repeatid)."'";
  $result = DBQuery($database, $query ); 

  return $repeatid;
}

// Make a non-repeating event public and remove the old event if a previous version existed.
function publicizeevent($eventid,&$event,$database) {
  if (!empty($event['repeatid'])) { // if event delivers repeatid that's fine
    $r['repeatid'] = $event['repeatid'];
  }
  else { // get repeatid from old entry in event_public (important if event changes from recurring to one-time)
    $result = DBQuery($database, "SELECT repeatid FROM vtcal_event_public WHERE id='".sqlescape($eventid)."'" ); 
    if ($result->numRows()>0) { 
      $r = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
    }
  }

  if (!empty($r['repeatid'])) { repeatdeletefromevent_public($r['repeatid'],$database); }
  else { deletefromevent_public($eventid,$database); }
  
	$event['id'] = $eventid; // this line should not be necessary but some functions still have a bug that doesn't pass the id in event['id']
  
	insertintoevent_public($event,$database);

  $result = DBQuery($database, "UPDATE vtcal_event SET approved=1 WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($eventid)."'" ); 

  // forward event to default calendar if that's indicated
	if ( $_SESSION["CALENDARID"] != "default" ) {
		// delete existing events in default calendar with same id
		$query = "DELETE FROM vtcal_event WHERE calendarid='default' AND id='".sqlescape($eventid)."'";
		$result = DBQuery($database, $query ); 
		
	  if ( $event['showondefaultcal'] == 1 ) {
		  // add new event in default calendar (with approved=0)
			$eventcategoryid = $event['categoryid'];
			$event['categoryid'] = $event['showincategory'];
			insertintoeventsql("default",$eventid,$event,$database);
			$event['categoryid'] = $eventcategoryid;
		} 
		else {
			$query = "DELETE FROM vtcal_event_public WHERE calendarid='default' AND id='".sqlescape($eventid)."'";
			$result = DBQuery($database, $query ); 
		}
	} // end: if ( $_SESSION["CALENDARID"] != "default" )
} // end: publicizeevent

// Make a repeating event public and remove the old event if a previous version existed.
function repeatpublicizeevent($eventid,&$event,$database) {
  deletefromevent_public($eventid,$database);
  if (!empty($event['repeatid'])) {
    repeatdeletefromevent_public($event['repeatid'],$database);
  }

	// forward events to default calendar: delete old events
	if ( $_SESSION["CALENDARID"] != "default" ) {
		// delete existing events in default calendar with same id
		$e = $eventid;
		$dashpos = strpos($e, "-");
		if ( $dashpos ) { 
		  $e = substr($e,0,$dashpos); 
		}
		$query = "DELETE FROM vtcal_event WHERE calendarid='default' AND id='".sqlescape($e)."'";
		$result = DBQuery($database, $query ); 
    
		if (!empty($event['repeatid'])) {
  		$query = "DELETE FROM vtcal_event WHERE calendarid='default' AND repeatid='".sqlescape($event['repeatid'])."'";
		  $result = DBQuery($database, $query ); 
		}
		
		if ( $event['showondefaultcal'] != 1 ) { // remove events if checkmark for forwarding is removed
			$query = "DELETE FROM vtcal_event_public WHERE calendarid='default' AND id='".sqlescape($e)."'";
			$result = DBQuery($database, $query ); 
			if (!empty($event['repeatid'])) {
  			$query = "DELETE FROM vtcal_event_public WHERE calendarid='default' AND repeatid='".sqlescape($event['repeatid'])."'";
		  	$result = DBQuery($database, $query ); 
			}
		}
	} // end: if ( $_SESSION["CALENDARID"] != "default" )

  // copy all events into event_public
  $result = DBQuery($database, "SELECT * FROM vtcal_event WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND repeatid='".sqlescape($event['repeatid'])."'" );
  for ($i=0;$i<$result->numRows();$i++) {
    $event = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
//    eventaddslashes($event);
    insertintoevent_public($event,$database);
		
		// forward event to default calendar if that's indicated
		if ( $_SESSION["CALENDARID"] != "default" ) {
			if ( $event['showondefaultcal'] == 1 ) {
				// add new event in default calendar (with approved=0)
				$eventcategoryid = $event['categoryid'];
				$event['categoryid'] = $event['showincategory'];
				insertintoeventsql("default",$event['id'],$event,$database);
				$event['categoryid'] = $eventcategoryid;
			}
		} // end: if ( $_SESSION["CALENDARID"] != "default" )
  } // end: for(...

  $query = "UPDATE vtcal_event SET approved=1 WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND approved=0 AND repeatid='".sqlescape($event['repeatid'])."'";
	$result = DBQuery($database, $query ); 
} // end: repeatpublicizeevent

// Formats a string so that it can be placed inside of a JavaScript string (e.g. document.write('');)
function escapeJavaScriptString($string) {
	return str_replace("\t", "\\t", str_replace("\r", "\\r", str_replace("\n", "\\n", str_replace("\"", "\\\"", str_replace("'", "\\'", str_replace("\\", "\\\\", $string))))));
}
?>