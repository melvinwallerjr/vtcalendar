<?php
if (!defined("ALLOWINCLUDES")) exit;

if (isset($_POST['TITLEPREFIX'])) { $Form_TITLEPREFIX = $_POST['TITLEPREFIX']; } else { $Form_TITLEPREFIX = ''; }
if (isset($_POST['TITLESUFFIX'])) { $Form_TITLESUFFIX = $_POST['TITLESUFFIX']; } else { $Form_TITLESUFFIX = ''; }
if (isset($_POST['LANGUAGE'])) { $Form_LANGUAGE = $_POST['LANGUAGE']; } else { $Form_LANGUAGE = 'en'; }
if (isset($_POST['DATABASE'])) { $Form_DATABASE = $_POST['DATABASE']; } else { $Form_DATABASE = ''; }
if (isset($_POST['SQLLOGFILE'])) { $Form_SQLLOGFILE = $_POST['SQLLOGFILE']; } else { $Form_SQLLOGFILE = ''; }
if (isset($_POST['REGEXVALIDUSERID'])) { $Form_REGEXVALIDUSERID = $_POST['REGEXVALIDUSERID']; } else { $Form_REGEXVALIDUSERID = '/^[A-Za-z][\\._A-Za-z0-9\\-\\\\]{1,49}$/'; }
if (isset($_POST['AUTH_DB']) && strtolower($_POST['AUTH_DB']) == 'true') { $Form_AUTH_DB = 'true'; } else { $Form_AUTH_DB = 'false'; }
if (isset($_POST['AUTH_DB_USER_PREFIX'])) { $Form_AUTH_DB_USER_PREFIX = $_POST['AUTH_DB_USER_PREFIX']; } else { $Form_AUTH_DB_USER_PREFIX = ''; }
if (isset($_POST['AUTH_DB_NOTICE'])) { $Form_AUTH_DB_NOTICE = $_POST['AUTH_DB_NOTICE']; } else { $Form_AUTH_DB_NOTICE = ''; }
if (isset($_POST['AUTH_DB_CREATEADMIN']) && strtolower($_POST['AUTH_DB_CREATEADMIN']) == 'true') { $Form_AUTH_DB_CREATEADMIN = 'true'; } else { $Form_AUTH_DB_CREATEADMIN = 'false'; }
if (isset($_POST['AUTH_DB_CREATEADMIN_USERNAME'])) { $Form_AUTH_DB_CREATEADMIN_USERNAME = $_POST['AUTH_DB_CREATEADMIN_USERNAME']; } else { $Form_AUTH_DB_CREATEADMIN_USERNAME = ''; }
if (isset($_POST['AUTH_DB_CREATEADMIN_PASSWORD'])) { $Form_AUTH_DB_CREATEADMIN_PASSWORD = $_POST['AUTH_DB_CREATEADMIN_PASSWORD']; } else { $Form_AUTH_DB_CREATEADMIN_PASSWORD = ''; }
if (isset($_POST['AUTH_LDAP']) && strtolower($_POST['AUTH_LDAP']) == 'true') { $Form_AUTH_LDAP = 'true'; } else { $Form_AUTH_LDAP = 'false'; }
if (isset($_POST['LDAP_HOST'])) { $Form_LDAP_HOST = $_POST['LDAP_HOST']; } else { $Form_LDAP_HOST = ''; }
if (isset($_POST['LDAP_PORT'])) { $Form_LDAP_PORT = $_POST['LDAP_PORT']; } else { $Form_LDAP_PORT = '389'; }
if (isset($_POST['LDAP_USERFIELD'])) { $Form_LDAP_USERFIELD = $_POST['LDAP_USERFIELD']; } else { $Form_LDAP_USERFIELD = ''; }
if (isset($_POST['LDAP_BASE_DN'])) { $Form_LDAP_BASE_DN = $_POST['LDAP_BASE_DN']; } else { $Form_LDAP_BASE_DN = ''; }
if (isset($_POST['LDAP_SEARCH_FILTER'])) { $Form_LDAP_SEARCH_FILTER = $_POST['LDAP_SEARCH_FILTER']; } else { $Form_LDAP_SEARCH_FILTER = ''; }
if (isset($_POST['LDAP_BIND_USER'])) { $Form_LDAP_BIND_USER = $_POST['LDAP_BIND_USER']; } else { $Form_LDAP_BIND_USER = ''; }
if (isset($_POST['LDAP_BIND_PASSWORD'])) { $Form_LDAP_BIND_PASSWORD = $_POST['LDAP_BIND_PASSWORD']; } else { $Form_LDAP_BIND_PASSWORD = ''; }
if (isset($_POST['AUTH_HTTP']) && strtolower($_POST['AUTH_HTTP']) == 'true') { $Form_AUTH_HTTP = 'true'; } else { $Form_AUTH_HTTP = 'false'; }
if (isset($_POST['AUTH_HTTP_URL'])) { $Form_AUTH_HTTP_URL = $_POST['AUTH_HTTP_URL']; } else { $Form_AUTH_HTTP_URL = ''; }
if (isset($_POST['BASEPATH'])) { $Form_BASEPATH = $_POST['BASEPATH']; } else { $Form_BASEPATH = ''; }
if (isset($_POST['BASEDOMAIN'])) { $Form_BASEDOMAIN = $_POST['BASEDOMAIN']; } else { $Form_BASEDOMAIN = ''; }
if (isset($_POST['BASEURL'])) { $Form_BASEURL = $_POST['BASEURL']; } else { $Form_BASEURL = ''; }
if (isset($_POST['SECUREBASEURL'])) { $Form_SECUREBASEURL = $_POST['SECUREBASEURL']; } else { $Form_SECUREBASEURL = ''; }
if (isset($_POST['TIMEZONE_OFFSET'])) { $Form_TIMEZONE_OFFSET = $_POST['TIMEZONE_OFFSET']; } else { $Form_TIMEZONE_OFFSET = '5'; }
if (isset($_POST['WEEK_STARTING_DAY'])) { $Form_WEEK_STARTING_DAY = $_POST['WEEK_STARTING_DAY']; } else { $Form_WEEK_STARTING_DAY = '0'; }
if (isset($_POST['USE_AMPM']) && strtolower($_POST['USE_AMPM']) == 'true') { $Form_USE_AMPM = 'true'; } else { $Form_USE_AMPM = 'false'; }
if (isset($_POST['COLUMNSIDE'])) { $Form_COLUMNSIDE = $_POST['COLUMNSIDE']; } else { $Form_COLUMNSIDE = 'LEFT'; }
if (isset($_POST['SHOW_UPCOMING_TAB']) && strtolower($_POST['SHOW_UPCOMING_TAB']) == 'true') { $Form_SHOW_UPCOMING_TAB = 'true'; } else { $Form_SHOW_UPCOMING_TAB = 'false'; }
if (isset($_POST['MAX_UPCOMING_EVENTS'])) { $Form_MAX_UPCOMING_EVENTS = $_POST['MAX_UPCOMING_EVENTS']; } else { $Form_MAX_UPCOMING_EVENTS = '75'; }
if (isset($_POST['SHOW_MONTH_OVERLAP']) && strtolower($_POST['SHOW_MONTH_OVERLAP']) == 'true') { $Form_SHOW_MONTH_OVERLAP = 'true'; } else { $Form_SHOW_MONTH_OVERLAP = 'false'; }
if (isset($_POST['AUTH_HTTP_CACHE']) && strtolower($_POST['AUTH_HTTP_CACHE']) == 'true') { $Form_AUTH_HTTP_CACHE = 'true'; } else { $Form_AUTH_HTTP_CACHE = 'false'; }
if (isset($_POST['AUTH_HTTP_CACHE_EXPIRATIONDAYS'])) { $Form_AUTH_HTTP_CACHE_EXPIRATIONDAYS = $_POST['AUTH_HTTP_CACHE_EXPIRATIONDAYS']; } else { $Form_AUTH_HTTP_CACHE_EXPIRATIONDAYS = '4'; }
if (isset($_POST['MAX_CACHESIZE_CATEGORYNAME'])) { $Form_MAX_CACHESIZE_CATEGORYNAME = $_POST['MAX_CACHESIZE_CATEGORYNAME']; } else { $Form_MAX_CACHESIZE_CATEGORYNAME = '100'; }

// Output Title Prefix
$ConfigOutput .= '// Config: Title Prefix'."\n";
$ConfigOutput .= '// Added at the beginning of the <title> tag.'."\n";
$ConfigOutput .= 'define("TITLEPREFIX", \''. escapephpstring($Form_TITLEPREFIX) .'\');'."\n\n";

// Output Title Suffix
$ConfigOutput .= '// Config: Title Suffix'."\n";
$ConfigOutput .= '// Example: " - My University"'."\n";
$ConfigOutput .= '// Added at the end of the <title> tag.'."\n";
$ConfigOutput .= 'define("TITLESUFFIX", \''. escapephpstring($Form_TITLESUFFIX) .'\');'."\n\n";

// Output Language
$ConfigOutput .= '// Config: Language'."\n";
$ConfigOutput .= '// Example: en, de'."\n";
$ConfigOutput .= '// Language used (refers to language file in directory /languages)'."\n";
$ConfigOutput .= 'define("LANGUAGE", \''. escapephpstring($Form_LANGUAGE) .'\');'."\n\n";

// Output Database Connection String
$ConfigOutput .= '// Config: Database Connection String'."\n";
$ConfigOutput .= '// Example: mysql://vtcal:abc123@localhost/vtcalendar'."\n";
$ConfigOutput .= '// This is the database connection string used by the PEAR library.'."\n";
$ConfigOutput .= '// It has the format: "mysql://user:password@host/databasename" or "postgres://user:password@host/databasename"'."\n";
$ConfigOutput .= 'define("DATABASE", \''. escapephpstring($Form_DATABASE) .'\');'."\n\n";

// Output SQL Log File
$ConfigOutput .= '// Config: SQL Log File'."\n";
$ConfigOutput .= '// Example: /var/log/vtcalendarsql.log'."\n";
$ConfigOutput .= '// Put a name of a (folder and) file where the calendar logs every SQL query to the database.'."\n";
$ConfigOutput .= '// This is good for debugging but make sure you write into a file that\'s not readable by the webserver or else you may expose private information.'."\n";
$ConfigOutput .= '// If left blank ("") no log will be kept. That\'s the default.'."\n";
$ConfigOutput .= 'define("SQLLOGFILE", \''. escapephpstring($Form_SQLLOGFILE) .'\');'."\n\n";

// Output User ID Regular Expression
$ConfigOutput .= '// Config: User ID Regular Expression'."\n";
$ConfigOutput .= '// This regular expression defines what is considered a valid user-ID.'."\n";
$ConfigOutput .= 'define("REGEXVALIDUSERID", \''. escapephpstring($Form_REGEXVALIDUSERID) .'\');'."\n\n";

// Output Database Authentication
$ConfigOutput .= '// Config: Database Authentication'."\n";
$ConfigOutput .= '// Authenticate users against the database.'."\n";
$ConfigOutput .= '// If enabled, this is always performed before any other authentication.'."\n";
$ConfigOutput .= 'define("AUTH_DB", ' . $Form_AUTH_DB .');'."\n\n";

// Output Prefix for Database Usernames
$ConfigOutput .= '// Config: Prefix for Database Usernames'."\n";
$ConfigOutput .= '// Example: db_'."\n";
$ConfigOutput .= '// This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."'."\n";
$ConfigOutput .= '// If you only use auth_db just leave it an empty string.'."\n";
$ConfigOutput .= '// Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP.'."\n";
$ConfigOutput .= 'define("AUTH_DB_USER_PREFIX", \''. escapephpstring($Form_AUTH_DB_USER_PREFIX) .'\');'."\n\n";

// Output Database Authentication Notice
$ConfigOutput .= '// Config: Database Authentication Notice'."\n";
$ConfigOutput .= '// This displays a text (or nothing) on the Update tab behind the user user management options.'."\n";
$ConfigOutput .= '// It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users know that they should create local users only if they are not in the LDAP.'."\n";
$ConfigOutput .= 'define("AUTH_DB_NOTICE", \''. escapephpstring($Form_AUTH_DB_NOTICE) .'\');'."\n\n";

// Output LDAP Authentication
$ConfigOutput .= '// Config: LDAP Authentication'."\n";
$ConfigOutput .= '// Authenticate users against a LDAP server.'."\n";
$ConfigOutput .= '// If enabled, HTTP authenticate will be ignored.'."\n";
$ConfigOutput .= 'define("AUTH_LDAP", ' . $Form_AUTH_LDAP .');'."\n\n";

// Output LDAP Host Name
$ConfigOutput .= '// Config: LDAP Host Name'."\n";
$ConfigOutput .= '// Example: directory.myuniversity.edu or ldap://directory.myuniversity.edu/ or ldaps://secure-directory.myuniversity.edu/'."\n";
$ConfigOutput .= '// If you are using OpenLDAP 2.x.x you can specify a URL (\'ldap://host/\') instead of the hostname (\'host\').'."\n";
$ConfigOutput .= 'define("LDAP_HOST", \''. escapephpstring($Form_LDAP_HOST) .'\');'."\n\n";

// Output LDAP Port
$ConfigOutput .= '// Config: LDAP Port'."\n";
$ConfigOutput .= '// The port to connect to. Ignored if LDAP Host Name is a URL.'."\n";
$ConfigOutput .= 'define("LDAP_PORT", \''. escapephpstring($Form_LDAP_PORT) .'\');'."\n\n";

// Output LDAP Username Attribute
$ConfigOutput .= '// Config: LDAP Username Attribute'."\n";
$ConfigOutput .= '// Example: sAMAccountName'."\n";
$ConfigOutput .= '// The attribute which contains the username.'."\n";
$ConfigOutput .= 'define("LDAP_USERFIELD", \''. escapephpstring($Form_LDAP_USERFIELD) .'\');'."\n\n";

// Output LDAP Base DN
$ConfigOutput .= '// Config: LDAP Base DN'."\n";
$ConfigOutput .= '// Example: DC=myuniversity,DC=edu'."\n";
$ConfigOutput .= 'define("LDAP_BASE_DN", \''. escapephpstring($Form_LDAP_BASE_DN) .'\');'."\n\n";

// Output Additional LDAP Search Filter
$ConfigOutput .= '// Config: Additional LDAP Search Filter'."\n";
$ConfigOutput .= '// Example: (objectClass=person)'."\n";
$ConfigOutput .= '// An optional filter to add to the LDAP search.'."\n";
$ConfigOutput .= 'define("LDAP_SEARCH_FILTER", \''. escapephpstring($Form_LDAP_SEARCH_FILTER) .'\');'."\n\n";

// Output LDAP Search Bind Username.
$ConfigOutput .= '// Config: LDAP Search Bind Username.'."\n";
$ConfigOutput .= '// Before authenticating the user, we first check if the username exists.'."\n";
$ConfigOutput .= '// If your LDAP server does not allow anonymous connections, specific a username here.'."\n";
$ConfigOutput .= '// Leave this blank to connect anonymously.'."\n";
$ConfigOutput .= 'define("LDAP_BIND_USER", \''. escapephpstring($Form_LDAP_BIND_USER) .'\');'."\n\n";

// Output LDAP Search Bind Password
$ConfigOutput .= '// Config: LDAP Search Bind Password'."\n";
$ConfigOutput .= '// Before authenticating the user, we first check if the username exists.'."\n";
$ConfigOutput .= '// If your LDAP server does not allow anonymous connections, specific a password here.'."\n";
$ConfigOutput .= '// Leave this blank to connect anonymously.'."\n";
$ConfigOutput .= 'define("LDAP_BIND_PASSWORD", \''. escapephpstring($Form_LDAP_BIND_PASSWORD) .'\');'."\n\n";

// Output HTTP Authentication
$ConfigOutput .= '// Config: HTTP Authentication'."\n";
$ConfigOutput .= '// Authenticate users by sending an HTTP request to a server.'."\n";
$ConfigOutput .= '// A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.'."\n";
$ConfigOutput .= '// If LDAP authentication is enabled, this will be ignored.'."\n";
$ConfigOutput .= 'define("AUTH_HTTP", ' . $Form_AUTH_HTTP .');'."\n\n";

// Output HTTP Authorizaton URL
$ConfigOutput .= '// Config: HTTP Authorizaton URL'."\n";
$ConfigOutput .= '// Example: http://localhost/customauth.php'."\n";
$ConfigOutput .= '// The URL to use for the BASIC HTTP Authentication.'."\n";
$ConfigOutput .= 'define("AUTH_HTTP_URL", \''. escapephpstring($Form_AUTH_HTTP_URL) .'\');'."\n\n";

// Output Cookie Base URL
$ConfigOutput .= '// Config: Cookie Base URL'."\n";
$ConfigOutput .= '// Example: /calendar/'."\n";
$ConfigOutput .= '// If you are hosting more than one VTCalendar on your server, you may want to set this to this calendar\'s base URL.'."\n";
$ConfigOutput .= '// Otherwise, the cookie will be submitted with a default path.'."\n";
$ConfigOutput .= '// This must start and end with a forward slash (/), unless the it is exactly "/".'."\n";
$ConfigOutput .= 'define("BASEPATH", \''. escapephpstring($Form_BASEPATH) .'\');'."\n\n";

// Output Cookie Host Name
$ConfigOutput .= '// Config: Cookie Host Name'."\n";
$ConfigOutput .= '// Example: localhost'."\n";
$ConfigOutput .= '// If you are hosting more than one VTCalendar on your server, you may want to set this to your server\'s host name.'."\n";
$ConfigOutput .= '// Otherwise, the cookie will be submitted with a default host name.'."\n";
$ConfigOutput .= 'define("BASEDOMAIN", \''. escapephpstring($Form_BASEDOMAIN) .'\');'."\n\n";

// Output Calendar Base URL
$ConfigOutput .= '// Config: Calendar Base URL'."\n";
$ConfigOutput .= '// Example: http://localhost/calendar/'."\n";
$ConfigOutput .= '// This is the absolute URL where your calendar software is located.'."\n";
$ConfigOutput .= '// This MUST end with a slash "/"'."\n";
$ConfigOutput .= 'define("BASEURL", \''. escapephpstring($Form_BASEURL) .'\');'."\n\n";

// Output Secure Calendar Base URL
$ConfigOutput .= '// Config: Secure Calendar Base URL'."\n";
$ConfigOutput .= '// Example: https://localhost/calendar/'."\n";
$ConfigOutput .= '// This is the absolute path where the secure version of the calendar is located.'."\n";
$ConfigOutput .= '// If you are not using URL, set this to the same address as BASEURL.'."\n";
$ConfigOutput .= '// This MUST end with a slash "/"'."\n";
$ConfigOutput .= 'define("SECUREBASEURL", \''. escapephpstring($Form_SECUREBASEURL) .'\');'."\n\n";

// Output Timezone Offset
$ConfigOutput .= '// Config: Timezone Offset'."\n";
$ConfigOutput .= '// Example: -5'."\n";
$ConfigOutput .= '// Defines the offset to GMT, can be positive or negative'."\n";
$ConfigOutput .= 'define("TIMEZONE_OFFSET", \''. escapephpstring($Form_TIMEZONE_OFFSET) .'\');'."\n\n";

// Output Week Starting Day
$ConfigOutput .= '// Config: Week Starting Day'."\n";
$ConfigOutput .= '// defines the week starting day - allowable values - 0 for "Sunday" or 1 for "Monday"'."\n";
$ConfigOutput .= 'define("WEEK_STARTING_DAY", \''. escapephpstring($Form_WEEK_STARTING_DAY) .'\');'."\n\n";

// Output Use AM/PM
$ConfigOutput .= '// Config: Use AM/PM'."\n";
$ConfigOutput .= '// defines time format e.g. 1am-11pm (true) or 1:00-23:00 (false)'."\n";
$ConfigOutput .= 'define("USE_AMPM", ' . $Form_USE_AMPM .');'."\n\n";

// Output Column Position
$ConfigOutput .= '// Config: Column Position'."\n";
$ConfigOutput .= '// Which side the little calendar, \'jump to\', \'today is\', etc. will be on.'."\n";
$ConfigOutput .= '// Values must be LEFT or RIGHT.'."\n";
$ConfigOutput .= 'define("COLUMNSIDE", \''. escapephpstring($Form_COLUMNSIDE) .'\');'."\n\n";

// Output Show Upcoming Tab
$ConfigOutput .= '// Config: Show Upcoming Tab'."\n";
$ConfigOutput .= '// Whether or not the upcoming tab will be shown.'."\n";
$ConfigOutput .= 'define("SHOW_UPCOMING_TAB", ' . $Form_SHOW_UPCOMING_TAB .');'."\n\n";

// Output Max Upcoming Events
$ConfigOutput .= '// Config: Max Upcoming Events'."\n";
$ConfigOutput .= '// Whether or not the upcoming tab will be shown.'."\n";
$ConfigOutput .= 'define("MAX_UPCOMING_EVENTS", \''. escapephpstring($Form_MAX_UPCOMING_EVENTS) .'\');'."\n\n";

// Output Show Month Overlap
$ConfigOutput .= '// Config: Show Month Overlap'."\n";
$ConfigOutput .= '// Whether or not events in month view on days that are not actually part of the current month should be shown.'."\n";
$ConfigOutput .= '// For example, if the first day of the month starts on a Wednesday, then Sunday-Tuesday are from the previous month.'."\n";
$ConfigOutput .= '// Values must be true or false.'."\n";
$ConfigOutput .= 'define("SHOW_MONTH_OVERLAP", ' . $Form_SHOW_MONTH_OVERLAP .');'."\n\n";

// Output HTTP Authentication Cache
$ConfigOutput .= '// Config: HTTP Authentication Cache'."\n";
$ConfigOutput .= '// Cache successful HTTP authentication attempts as hashes in DB.'."\n";
$ConfigOutput .= '// This acts as a failover if the HTTP authentication fails due to a server error.'."\n";
$ConfigOutput .= 'define("AUTH_HTTP_CACHE", ' . $Form_AUTH_HTTP_CACHE .');'."\n\n";

// Output HTTP Authentication Cache Expiration
$ConfigOutput .= '// Config: HTTP Authentication Cache Expiration'."\n";
$ConfigOutput .= '// The number of days in which data in the HTTP authentication cache is valid.'."\n";
$ConfigOutput .= 'define("AUTH_HTTP_CACHE_EXPIRATIONDAYS", \''. escapephpstring($Form_AUTH_HTTP_CACHE_EXPIRATIONDAYS) .'\');'."\n\n";

// Output Max Category Name Cache Size
$ConfigOutput .= '// Config: Max Category Name Cache Size'."\n";
$ConfigOutput .= '// Cache the list of category names in memory if the calendar has less than or equal to this number.'."\n";
$ConfigOutput .= 'define("MAX_CACHESIZE_CATEGORYNAME", \''. escapephpstring($Form_MAX_CACHESIZE_CATEGORYNAME) .'\');'."\n\n";

?>