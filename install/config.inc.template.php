<?php
// ===========================================================================
// WARNING: Do not output ANYTHING in this file!
// This include file is called before session_start(), so it must never output any data.
// ===========================================================================

// This is the database connection string used by the PEAR library.
// It has the format: "mysql://dbuser:dbpassword@dbhost/dbname" or "postgres://dbuser:dbpassword@dbhost/dbname"
define("DATABASE", "mysql://vtcalendar:afx779@localhost/vtcalendar");

// These parameters define whether or not local authentication (via DB)
// and/or LDAP authentication are enabled
// If enabled, local authentication (via DB) is always performed first
// WARNING: Do NOT set both AUTH_HTTP and AUTH_LDAP to TRUE.
define("AUTH_DB", true);
define("AUTH_LDAP", false);
define("AUTH_HTTP", false);

// This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."
// If you only use auth_db just leave it an empty string
// Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP
define("AUTH_DB_USER_PREFIX", "");

// This displays a text (or nothing) on the Update tab behind the user user management options
// It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users
// know that they should create local users only if they are not in the LDAP.
define("AUTH_DB_NOTICE", "");

// These regular expression defines what is considered a valid user-ID
// make sure to include
define("REGEXVALIDUSERID","/^[A-Za-z][\._A-Za-z0-9\-\\\\]{1,49}$/");

// The URL to use for the BASIC HTTP Authentication.
define("AUTH_HTTP_URL", "http://127.0.0.1:7780/admin/auth.txt");

// These parameters define if passwords are cached in the database from successfull HTTP authentication.
// If the HTTP auth fails, it will check against the HTTP cache.
// This allows for a failsafe for when the HTTP auth server is not working properly.
define("AUTH_HTTP_CACHE", true);
define("AUTH_HTTP_CACHE_EXPIRATIONDAYS", 60);

// These parameters define the connection to your ldap server.
// They only matter if "AUTH_LDAP" is set to TRUE
define("LDAP_HOST","ldap://directory.myorg.edu");
define("LDAP_PORT", "389"); // Default is 389
define("LDAP_USERFIELD","uid");
define("LDAP_BASE_DN","ou=users,dc=myorg,dc=edu");

// An optional filter to add to the LDAP search. Example: "(objectClass=person)"
define("LDAP_SEARCH_FILTER", "");

// Leave LDAP_BIND_USER empty to connect anonymously
define("LDAP_BIND_USER", "");
define("LDAP_BIND_PASSWORD", "huweb&$788");

// This is the absolute path and domain where your calendar software is located
// The PATH needs to start and end with a slash "/"
define("BASEPATH", "/calendar/");
define("BASEDOMAIN", "myorg.edu");

// This is the absolute URL where your calendar software is located
// The URL needs to end with a slash "/"
define("BASEURL","http://www.myorg.edu/calendar/");

// This is the absolute URL where the secure version of the calendar is located
// The software automatically redirects to this URL when you try to go to the "update" tab
// If it is identical to BASEURL no redirect takes place
// Note that NO redirect takes place if the server is "localhost". This is done to simplify testing.
// The URL needs to end with a slash "/"
define("SECUREBASEURL","https://www.myorg.edu/calendar/");

// put a name of a (folder and) file where the calendar logs every
// SQL query to the database. This is good for debugging but make
// sure you write into a file that's not readable by the webserver or
// else you may expose private information.
// If left blank ("") no log will be kept. That's the default.
define("SQLLOGFILE","");

// defines the offset to GMT, can be positive or negative
define("TIMEZONE_OFFSET","5");

// language used (refers to language file in directory /languages)
define("LANGUAGE","en");

// Which side the little calendar, 'jump to', 'today is', etc. will be on.
// Values should be LEFT or RIGHT.
define("COLUMNSIDE", "LEFT");

// defines the week starting day - allowable values - 0 for "Sunday" or 1 for "Monday"
define("WEEK_STARTING_DAY","0");

// defines time format e.g. 1am-11pm (TRUE) or 1:00-23:00 (FALSE)
define("USE_AMPM", TRUE);

// ---------- The following functions allow you to customize processing based on your database -------

// escapes a value to make it safe for a SQL query
function sqlescape($value) {
  if (preg_match("/^pgsql/",DATABASE)) {
	  return pg_escape_string($value);
	}
	else {
		return mysql_escape_string($value);
	}
}

// --------------- The following functions allow you to customize the date format display ------------
 
// formats date output for date title in day and event view
function day_view_date_format($date,$dow,$month, $year) {
  // US format
  return $dow.", ".$month." ".$date.", ".$year;
  // Latvian format
  // return $dow.", ".$date.". ".$month.", ".$year;
}

// formats date output for datetitle in week view
function week_view_date_format($date_from, $month_from, $year_from, $date_to, $month_to, $year_to) {
  // US format
  $date_str = $month_from . " " . $date_from; 
  if ($year_from != $year_to) {
     $date_str.=", ".$year_from;
  }
  $date_str.=" - ";
  if($month_from != $month_to){
     $date_str .= $month_to . " ";
  }
  $date_str .= $date_to . ", " . $year_to; 
  return  $date_str;

  // Latvian format
/*
  $date_str=$date_from.". "; // "13. "
  if($month_from != $month_to){
     $date_str.=strtolower($month_from);   //"13. janvaris"
  }
  if( $year_from != $year_to){
     $date_str.=", ".$year_from; //  "13. janvaris, 2003"
  }
  $date_str.=" - ";
  $date_str.=$date_to.". ".strtolower($month_to).", ".$year_to;   
  return  $date_str;
*/  
}

// formats date output for date title in month view
function month_view_date_format($month, $year) {
  // US format
  return $month." ".$year;
  
  // Latvian format
  // return $month.", ".$year;
}

// formats date output for date above little calendar (month browsing link)
function above_lit_cal_date_format($month, $year) {
  // US format
  return substr($month,0,3)." ".$year;

  // Latvian format
  // return substr($month,0,3).", ".$year;
}

// formats date output for todays date under little calendar
function today_is_date_format($date, $dow, $month, $year) {
  // US format
  return substr($dow,0,3).", ".substr($month,0,3)." ".ltrim($date,"0").", ".$year;

  // Latvian format
  // return $dow.", ".$date.". ".strtolower($month).", ".$year;
}

// formats date for weeks view day's header
function week_header_date_format($date, $month){
  // US format
  return substr($month,0,3)." ".$date;
  
  // Latvian format
  // return $date.". ".strtolower(substr($month,0,3));
}

// formats date for searchresult in found items list
function searchresult_date_format($date, $dow, $month, $year) {
  // US format
  return substr($dow,0,3).", ".substr($month,0,3)." ".$date.", ".$year;

  // Latvian format
  // return $dow.", ".$date.". ".strtolower(substr($month,0,3)).", ".$year;
}
?>