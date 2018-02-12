<?php
if (!defined('ALLOWINCLUDES')) { exit; }

// Default Form Values
$Form_TITLEPREFIX = '';
$Form_TITLESUFFIX = '';
$Form_LANGUAGE = 'en';
$Form_ALLOWED_YEARS_AHEAD = '3';
$Form_DATABASE = '';
$Form_SCHEMANAME = '';
$Form_SQLLOGFILE = '';
$Form_REGEXVALIDUSERID = '/^[A-Za-z][\\._A-Za-z0-9\\-\\\\]{1,49}$/';
$Form_AUTH_DB = true;
$Form_AUTH_DB_USER_PREFIX = '';
$Form_AUTH_DB_NOTICE = '';
$Form_AUTH_LDAP = false;
$Form_LDAP_CHECK = true;
$Form_LDAP_HOST = '';
$Form_LDAP_PORT = '389';
$Form_LDAP_USERFIELD = '';
$Form_LDAP_BASE_DN = '';
$Form_LDAP_SEARCH_FILTER = '';
$Form_LDAP_BIND = false;
$Form_LDAP_BIND_USER = '';
$Form_LDAP_BIND_PASSWORD = '';
$Form_AUTH_HTTP = false;
$Form_AUTH_HTTP_URL = '';
$Form_BASEPATH = '';
$Form_BASEDOMAIN = '';
$Form_BASEURL = '';
$Form_SECUREBASEURL = '';
$Form_TIMEZONE = '';
$Form_WEEK_STARTING_DAY = '0';
$Form_USE_AMPM = true;
$Form_COLUMNSIDE = 'RIGHT';
$Form_SHOW_UPCOMING_TAB = true;
$Form_MAX_UPCOMING_EVENTS = '75';
$Form_SHOW_MONTH_OVERLAP = true;
$Form_COMBINED_JUMPTO = true;
$Form_CUSTOM_LOGIN_HTML = false;
$Form_INCLUDE_STATIC_PRE_HEADER = false;
$Form_INCLUDE_STATIC_POST_HEADER = false;
$Form_INCLUDE_STATIC_PRE_FOOTER = false;
$Form_INCLUDE_STATIC_POST_FOOTER = false;
$Form_MAX_CACHESIZE_CATEGORYNAME = '100';
$Form_CACHE_SUBSCRIBE_LINKS = false;
$Form_CACHE_SUBSCRIBE_LINKS_PATH = 'cache/subscribe/';
$Form_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR = '';
$Form_EXPORT_PATH = 'export/export.php';
$Form_MAX_EXPORT_EVENTS = '100';
$Form_EXPORT_CACHE_MINUTES = '5';
$Form_PUBLIC_EXPORT_VTCALXML = false;
$Form_EMAIL_USEPEAR = false;
$Form_EMAIL_SMTP_HOST = 'localhost';
$Form_EMAIL_SMTP_PORT = '25';
$Form_EMAIL_SMTP_AUTH = false;
$Form_EMAIL_SMTP_USERNAME = '';
$Form_EMAIL_SMTP_PASSWORD = '';
$Form_EMAIL_SMTP_HELO = 'localhost';
$Form_EMAIL_SMTP_TIMEOUT = '0';

// Load Submitted Form Values
if (isset($_POST['SaveConfig'])) {
	setVar($Form_TITLEPREFIX, $_POST['TITLEPREFIX']);
	setVar($Form_TITLESUFFIX, $_POST['TITLESUFFIX']);
	setVar($Form_LANGUAGE, $_POST['LANGUAGE']);
	setVar($Form_ALLOWED_YEARS_AHEAD, $_POST['ALLOWED_YEARS_AHEAD']);
	setVar($Form_DATABASE, $_POST['DATABASE']);
	setVar($Form_SCHEMANAME, $_POST['SCHEMANAME']);
	setVar($Form_SQLLOGFILE, $_POST['SQLLOGFILE']);
	setVar($Form_REGEXVALIDUSERID, $_POST['REGEXVALIDUSERID']);
	$Form_AUTH_DB = isset($_POST['AUTH_DB']);
	if ($Form_AUTH_DB) {
		setVar($Form_AUTH_DB_USER_PREFIX, $_POST['AUTH_DB_USER_PREFIX']);
		setVar($Form_AUTH_DB_NOTICE, $_POST['AUTH_DB_NOTICE']);
	}
	$Form_AUTH_LDAP = isset($_POST['AUTH_LDAP']);
	if ($Form_AUTH_LDAP) {
		$Form_LDAP_CHECK = isset($_POST['LDAP_CHECK']);
		setVar($Form_LDAP_HOST, $_POST['LDAP_HOST']);
		setVar($Form_LDAP_PORT, $_POST['LDAP_PORT']);
		setVar($Form_LDAP_USERFIELD, $_POST['LDAP_USERFIELD']);
		setVar($Form_LDAP_BASE_DN, $_POST['LDAP_BASE_DN']);
		setVar($Form_LDAP_SEARCH_FILTER, $_POST['LDAP_SEARCH_FILTER']);
		$Form_LDAP_BIND = isset($_POST['LDAP_BIND']);
		if ($Form_LDAP_BIND) {
			setVar($Form_LDAP_BIND_USER, $_POST['LDAP_BIND_USER']);
			setVar($Form_LDAP_BIND_PASSWORD, $_POST['LDAP_BIND_PASSWORD']);
		}
	}
	$Form_AUTH_HTTP = isset($_POST['AUTH_HTTP']);
	if ($Form_AUTH_HTTP) {
		setVar($Form_AUTH_HTTP_URL, $_POST['AUTH_HTTP_URL']);
	}
	setVar($Form_BASEPATH, $_POST['BASEPATH']);
	setVar($Form_BASEDOMAIN, $_POST['BASEDOMAIN']);
	setVar($Form_BASEURL, $_POST['BASEURL']);
	setVar($Form_SECUREBASEURL, $_POST['SECUREBASEURL']);
	setVar($Form_TIMEZONE, $_POST['TIMEZONE']);
	setVar($Form_WEEK_STARTING_DAY, $_POST['WEEK_STARTING_DAY']);
	$Form_USE_AMPM = isset($_POST['USE_AMPM']);
	setVar($Form_COLUMNSIDE, $_POST['COLUMNSIDE']);
	$Form_SHOW_UPCOMING_TAB = isset($_POST['SHOW_UPCOMING_TAB']);
	if ($Form_SHOW_UPCOMING_TAB) {
		setVar($Form_MAX_UPCOMING_EVENTS, $_POST['MAX_UPCOMING_EVENTS']);
	}
	$Form_SHOW_MONTH_OVERLAP = isset($_POST['SHOW_MONTH_OVERLAP']);
	$Form_COMBINED_JUMPTO = isset($_POST['COMBINED_JUMPTO']);
	$Form_CUSTOM_LOGIN_HTML = isset($_POST['CUSTOM_LOGIN_HTML']);
	$Form_INCLUDE_STATIC_PRE_HEADER = isset($_POST['INCLUDE_STATIC_PRE_HEADER']);
	$Form_INCLUDE_STATIC_POST_HEADER = isset($_POST['INCLUDE_STATIC_POST_HEADER']);
	$Form_INCLUDE_STATIC_PRE_FOOTER = isset($_POST['INCLUDE_STATIC_PRE_FOOTER']);
	$Form_INCLUDE_STATIC_POST_FOOTER = isset($_POST['INCLUDE_STATIC_POST_FOOTER']);
	setVar($Form_MAX_CACHESIZE_CATEGORYNAME, $_POST['MAX_CACHESIZE_CATEGORYNAME']);
	$Form_CACHE_SUBSCRIBE_LINKS = isset($_POST['CACHE_SUBSCRIBE_LINKS']);
	if ($Form_CACHE_SUBSCRIBE_LINKS) {
		setVar($Form_CACHE_SUBSCRIBE_LINKS_PATH, $_POST['CACHE_SUBSCRIBE_LINKS_PATH']);
		setVar($Form_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR, $_POST['CACHE_SUBSCRIBE_LINKS_OUTPUTDIR']);
	}
	setVar($Form_EXPORT_PATH, $_POST['EXPORT_PATH']);
	setVar($Form_MAX_EXPORT_EVENTS, $_POST['MAX_EXPORT_EVENTS']);
	setVar($Form_EXPORT_CACHE_MINUTES, $_POST['EXPORT_CACHE_MINUTES']);
	$Form_PUBLIC_EXPORT_VTCALXML = isset($_POST['PUBLIC_EXPORT_VTCALXML']);
	$Form_EMAIL_USEPEAR = isset($_POST['EMAIL_USEPEAR']);
	if ($Form_EMAIL_USEPEAR) {
		setVar($Form_EMAIL_SMTP_HOST, $_POST['EMAIL_SMTP_HOST']);
		setVar($Form_EMAIL_SMTP_PORT, $_POST['EMAIL_SMTP_PORT']);
		$Form_EMAIL_SMTP_AUTH = isset($_POST['EMAIL_SMTP_AUTH']);
		if ($Form_EMAIL_SMTP_AUTH) {
			setVar($Form_EMAIL_SMTP_USERNAME, $_POST['EMAIL_SMTP_USERNAME']);
			setVar($Form_EMAIL_SMTP_PASSWORD, $_POST['EMAIL_SMTP_PASSWORD']);
		}
		setVar($Form_EMAIL_SMTP_HELO, $_POST['EMAIL_SMTP_HELO']);
		setVar($Form_EMAIL_SMTP_TIMEOUT, $_POST['EMAIL_SMTP_TIMEOUT']);
	}
}

// Build Code for config.inc.php
function BuildOutput(&$ConfigOutput) {
	// Output Title Prefix
	$ConfigOutput .= '
/**
 * Config: Title Prefix
 * OPTIONAL. Added at the beginning of the <title> tag.
 */
define(\'TITLEPREFIX\', \'' .  escapephpstring($GLOBALS['Form_TITLEPREFIX']) . '\');' . "\n";

	// Output Title Suffix
	$ConfigOutput .= '
/**
 * Config: Title Suffix
 * Example: " - My University"
 * OPTIONAL. Added at the end of the <title> tag.
 */
define(\'TITLESUFFIX\', \'' . escapephpstring($GLOBALS['Form_TITLESUFFIX']) . '\');' . "\n";

	// Output Language
	$ConfigOutput .= '
/**
 * Config: Language
 * Example: en (English), de (German), sv (Swedish)
 * Default: en
 * Language used (refers to language file in directory /languages)
 */
define(\'LANGUAGE\', \'' . escapephpstring($GLOBALS['Form_LANGUAGE']) . '\');' . "\n";

	// Output Max Year Ahead for New Events
	$ConfigOutput .= '
/**
 * Config: Max Year Ahead for New Events
 * Default: 3
 * The number of years into the future that the calendar will allow users to create events for.
 * For example, if the current year is 2000 then a value of \'3\' will allow users to create events up to 2003.
 */
define(\'ALLOWED_YEARS_AHEAD\', \'' . escapephpstring($GLOBALS['Form_ALLOWED_YEARS_AHEAD']) . '\');' . "\n";

	// Output Database Connection String
	$ConfigOutput .= '
/**
 * Config: Database Connection String
 * Example: mysql://vtcal:abc123@localhost/vtcalendar
 * This is the database connection string used by the PEAR library.
 * It has the format: "mysql://user:password@host/databasename" or "pgsql://user:password@host/databasename"
 */
define(\'DATABASE\', \'' . escapephpstring($GLOBALS['Form_DATABASE']) . '\');' . "\n";

	// Output Schema Name
	$ConfigOutput .= '
/**
 * Config: Schema Name
 * Example: public
 * In some databases (such as PostgreSQL) you may have multiple sets of VTCalendar
 * tables within the same database, but in different schemas.
 * If this is the case for you, enter the name of the schema here.
 * It will be prefixed to the table name like so: SCHEMANAME.vtcal_calendars.
 * If necessary quote the schema name using a backtick (`) for MySQL or double quotes (") for PostgreSQL.
 * Note: If specified, the table prefix MUST end with a period.
 */
define(\'SCHEMANAME\', \'' . escapephpstring($GLOBALS['Form_SCHEMANAME']) . '\');' . "\n";

	// Output SQL Log File
	$ConfigOutput .= '
/**
 * Config: SQL Log File
 * Example: /var/log/vtcalendarsql.log
 * OPTIONAL. Put a name of a (folder and) file where the calendar logs every SQL query to the database.
 * This is good for debugging but make sure you write into a file that\'s not readable by the
 * web server or else you may expose private information.
 * If left blank ("") no log will be kept. That\'s the default.
 */
define(\'SQLLOGFILE\', \'' . escapephpstring($GLOBALS['Form_SQLLOGFILE']) . '\');' . "\n";

	// Output User ID Regular Expression
	$ConfigOutput .= '
/**
 * Config: User ID Regular Expression
 * Default: /^[A-Za-z][\\._A-Za-z0-9\\-\\\\]{1,49}$/
 * This regular expression defines what is considered a valid user-ID.
 */
define(\'REGEXVALIDUSERID\', \''. escapephpstring($GLOBALS['Form_REGEXVALIDUSERID']) . '\');' . "\n";

	// Output Database Authentication
	$ConfigOutput .= '
/**
 * Config: Database Authentication
 * Default: true
 * Authenticate users against the database.
 * If enabled, this is always performed before any other authentication.
 */
define(\'AUTH_DB\', ' . ($GLOBALS['Form_AUTH_DB']? 'true' : 'false') . ');' . "\n";

	// Output Prefix for Database Usernames
	$ConfigOutput .= '
/**
 * Config: Prefix for Database Usernames
 * Example: db_
 * OPTIONAL. This prefix is used when creating/editing a local user-ID
 * (in the DB "user" table), e.g. "calendar."
 * If you only use auth_db just leave it an empty string.
 * Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP.
 */
define(\'AUTH_DB_USER_PREFIX\', \'' . escapephpstring($GLOBALS['Form_AUTH_DB_USER_PREFIX']) . '\');' . "\n";

	// Output Database Authentication Notice
	$ConfigOutput .= '
/**
 * Config: Database Authentication Notice
 * OPTIONAL. This displays a text (or nothing) on the Update tab behind the user user management options.
 * It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users know
 * that they should create local users only if they are not in the LDAP.
 */
define(\'AUTH_DB_NOTICE\', \'' . escapephpstring($GLOBALS['Form_AUTH_DB_NOTICE']) . '\');' . "\n";

	// Output LDAP Authentication
	$ConfigOutput .= '
/**
 * Config: LDAP Authentication
 * Default: false
 * Authenticate users against a LDAP server.
 * If enabled, HTTP authenticate will be ignored.
 */
define(\'AUTH_LDAP\', ' . ($GLOBALS['Form_AUTH_LDAP']? 'true' : 'false') . ');' . "\n";

	// Output LDAP Host Name
	$ConfigOutput .= '
/**
 * Config: LDAP Host Name
 * Example: directory.myuniversity.edu or ldap://directory.myuniversity.edu/ or
 * ldaps://secure-directory.myuniversity.edu/
 * If you are using OpenLDAP 2.x.x you can specify a URL (\'ldap://host/\')
 * instead of the hostname (\'host\').
 */
define(\'LDAP_HOST\', \'' . escapephpstring($GLOBALS['Form_LDAP_HOST']) . '\');' . "\n";

	// Output LDAP Port
	$ConfigOutput .= '
/**
 * Config: LDAP Port
 * Default: 389
 * The port to connect to. Ignored if LDAP Host Name is a URL.
 */
define(\'LDAP_PORT\', \'' . escapephpstring($GLOBALS['Form_LDAP_PORT']) . '\');' . "\n";

	// Output LDAP Username Attribute
	$ConfigOutput .= '
/**
 * Config: LDAP Username Attribute
 * Example: sAMAccountName
 * The attribute which contains the username.
 */
define(\'LDAP_USERFIELD\', \'' . escapephpstring($GLOBALS['Form_LDAP_USERFIELD']) . '\');' . "\n";

	// Output LDAP Base DN
	$ConfigOutput .= '
/**
 * Config: LDAP Base DN
 * Example: DC=myuniversity,DC=edu
 */
define(\'LDAP_BASE_DN\', \'' . escapephpstring($GLOBALS['Form_LDAP_BASE_DN']) . '\');' . "\n";

	// Output Additional LDAP Search Filter
	$ConfigOutput .= '
/**
 * Config: Additional LDAP Search Filter
 * Example: (objectClass=person)
 * OPTIONAL. A filter to add to the LDAP search.
 */
define(\'LDAP_SEARCH_FILTER\', \'' . escapephpstring($GLOBALS['Form_LDAP_SEARCH_FILTER']) . '\');' . "\n";

	// Output LDAP Username
	$ConfigOutput .= '
/**
 * Config: LDAP Username
 * Before authenticating the user, we first check if the username exists.
 * If your LDAP server does not allow anonymous connections, specific a username here.
 * Leave this blank to connect anonymously.
 */
define(\'LDAP_BIND_USER\', \'' . escapephpstring($GLOBALS['Form_LDAP_BIND_USER']) . '\');' . "\n";

	// Output LDAP Password
	$ConfigOutput .= '
/**
 * Config: LDAP Password
 * If you specified LDAP_BIND_USER you must also enter a password here.
 */
define(\'LDAP_BIND_PASSWORD\', \'' . escapephpstring($GLOBALS['Form_LDAP_BIND_PASSWORD']) . '\');' . "\n";

	// Output HTTP Authentication
	$ConfigOutput .= '
/**
 * Config: HTTP Authentication
 * Default: false
 * Authenticate users by sending an HTTP request to a server.
 * A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.
 * If LDAP authentication is enabled, this will be ignored.
 */
define(\'AUTH_HTTP\', ' . ($GLOBALS['Form_AUTH_HTTP']? 'true' : 'false') . ');' . "\n";

	// Output HTTP Authorizaton URL
	$ConfigOutput .= '
/**
 * Config: HTTP Authorizaton URL
 * Example: http://localhost/customauth.php
 * The URL to use for the BASIC HTTP Authentication.
 */
define(\'AUTH_HTTP_URL\', \'' . escapephpstring($GLOBALS['Form_AUTH_HTTP_URL']) . '\');' . "\n";

	// Output Cookie Path
	$ConfigOutput .= '
/**
 * Config: Cookie Path
 * Example: /calendar/
 * OPTIONAL. If you are hosting more than one VTCalendar on your server,
 * you may want to set this to this calendar\'s path.
 * Otherwise, the cookie will be submitted with a default path.
 * This must start and end with a forward slash (/), unless the it is exactly "/".
 */
define(\'BASEPATH\', \'' . escapephpstring($GLOBALS['Form_BASEPATH']) . '\');' . "\n";

	// Output Cookie Host Name
	$ConfigOutput .= '
/**
 * Config: Cookie Host Name
 * Example: localhost
 * OPTIONAL. If you are hosting more than one VTCalendar on your server,
 * you may want to set this to your server\'s host name.
 * Otherwise, the cookie will be submitted with a default host name.
 */
define(\'BASEDOMAIN\', \'' . escapephpstring($GLOBALS['Form_BASEDOMAIN']) . '\');' . "\n";

	// Output Calendar Base URL
	$ConfigOutput .= '
/**
 * Config: Calendar Base URL
 * Example: http://localhost/calendar/
 * This is the absolute URL where your calendar software is located.
 * This MUST end with a slash "/"
 */
define(\'BASEURL\', \'' . escapephpstring($GLOBALS['Form_BASEURL']) . '\');' . "\n";

	// Output Secure Calendar Base URL
	$ConfigOutput .= '
/**
 * Config: Secure Calendar Base URL
 * Example: https://localhost/calendar/
 * Default:
 * This is the absolute path where the secure version of the calendar is located.
 * If you are not using URL, set this to the same address as BASEURL.
 * This MUST end with a slash "/"
 */
define(\'SECUREBASEURL\', \'' . escapephpstring($GLOBALS['Form_SECUREBASEURL']) . '\');' . "\n";

	// Output Timezone
	$ConfigOutput .= '
/**
 * Config: Timezone
 * Example: America/New_York
 * Default:
 * The timezone in which the calendar will set the local time for.
 * All new events, logs, etc will be affected by this setting.
 * For a list of supported timezone identifiers see http://us.php.net/manual/en/timezones.php
 */
define(\'TIMEZONE\', \'' . escapephpstring($GLOBALS['Form_TIMEZONE']) . '\');' . "\n";

	// Output Week Starting Day
	$ConfigOutput .= '
/**
 * Config: Week Starting Day
 * Default: 0
 * Defines the week starting day
 * Allowable values - 0 for "Sunday" or 1 for "Monday"
 */
define(\'WEEK_STARTING_DAY\', \'' . escapephpstring($GLOBALS['Form_WEEK_STARTING_DAY']) . '\');' . "\n";

	// Output Use AM/PM
	$ConfigOutput .= '
/**
 * Config: Use AM/PM
 * Default: true
 * Defines time format e.g. 1am-11pm (true) or 1:00-23:00 (false)
 */
define(\'USE_AMPM\', ' . ($GLOBALS['Form_USE_AMPM']? 'true' : 'false') . ');' . "\n";

	// Output Column Position
	$ConfigOutput .= '
/**
 * Config: Column Position
 * Default: RIGHT
 * Which side the little calendar, \'jump to\', \'today is\', etc. will be on.
 * RIGHT is more user friendly for users with low resolutions.
 * Values must be LEFT or RIGHT.
 */
define(\'COLUMNSIDE\', \'' . escapephpstring($GLOBALS['Form_COLUMNSIDE']) . '\');' . "\n";

	// Output Show Upcoming Tab
	$ConfigOutput .= '
/**
 * Config: Show Upcoming Tab
 * Default: true
 * Whether or not the upcoming tab will be shown.
 */
define(\'SHOW_UPCOMING_TAB\', ' . ($GLOBALS['Form_SHOW_UPCOMING_TAB']? 'true' : 'false') . ');' . "\n";

	// Output Max Upcoming Events
	$ConfigOutput .= '
/**
 * Config: Max Upcoming Events
 * Default: 75
 * The maximum number of upcoming events displayed.
 */
define(\'MAX_UPCOMING_EVENTS\', \'' . escapephpstring($GLOBALS['Form_MAX_UPCOMING_EVENTS']) . '\');' . "\n";

	// Output Show Month Overlap
	$ConfigOutput .= '
/**
 * Config: Show Month Overlap
 * Default: true
 * Whether or not events in month view on days that are not actually part
 * of the current month should be shown.
 * For example, if the first day of the month starts on a Wednesday,
 * then Sunday-Tuesday are from the previous month.
 */
define(\'SHOW_MONTH_OVERLAP\', ' . ($GLOBALS['Form_SHOW_MONTH_OVERLAP']? 'true' : 'false') . ');' . "\n";

	// Output Combined 'Jump To' Drop-Down
	$ConfigOutput .= '
/**
 * Config: Combined \'Jump To\' Drop-Down
 * Default: true
 * Whether or not the \'jump to\' drop-down in the column will be combined
 * into a single drop-down box or not.
 * When set to true, the list will contain all possible month/years combinations
 * for the next X years (where X is ALLOWED_YEARS_AHEAD).
 * Only the last 3 months will be included in this list.
 */
define(\'COMBINED_JUMPTO\', ' . ($GLOBALS['Form_COMBINED_JUMPTO']? 'true' : 'false') . ');' . "\n";

	// Output Use Custom Login Page
	$ConfigOutput .= '
/**
 * Config: Use Custom Login Page
 * Default: false
 * By default the login page includes the login form and a message
 * about how to request a login to the calendar.
 * When set to true, a file at ./static-includes/loginform.inc will be used as a custom login page:
 * - It must include @@LOGIN_FORM@@ which will be replaced with the login form itself.
 * - You can also include @@LOGIN_HEADER@@ which will be replaced with the "Login"
 * header text for the translation you specified.
 * - See the ./static-includes/loginform-EXAMPLE.inc file for an example.
 */
define(\'CUSTOM_LOGIN_HTML\', ' . ($GLOBALS['Form_CUSTOM_LOGIN_HTML']? 'true' : 'false') . ');' . "\n";

	// Output Include Static Pre-Header HTML
	$ConfigOutput .= '
/**
 * Config: Include Static Pre-Header HTML
 * Default: false
 * Include the file located at ./static-includes/subcalendar-pre-header.inc
 * before the calendar header HTML for all calendars.
 * This allows you to enforce a standard header for all calendars.
 * This does not affect the default calendar.
 */
define(\'INCLUDE_STATIC_PRE_HEADER\', ' . ($GLOBALS['Form_INCLUDE_STATIC_PRE_HEADER']? 'true' : 'false') . ');' . "\n";

	// Output Include Static Post-Header HTML
	$ConfigOutput .= '
/**
 * Config: Include Static Post-Header HTML
 * Default: false
 * Include the file located at ./static-includes/subcalendar-post-header.inc
 * after the calendar header HTML for all calendars.
 * This allows you to enforce a standard header for all calendars.
 * This does not affect the default calendar.
 */
define(\'INCLUDE_STATIC_POST_HEADER\', ' . ($GLOBALS['Form_INCLUDE_STATIC_POST_HEADER']? 'true' : 'false') . ');' ."\n";

	// Output Include Static Pre-Footer HTML
	$ConfigOutput .= '
/**
 * Config: Include Static Pre-Footer HTML
 * Default: false
 * Include the file located at ./static-includes/subcalendar-pre-footer.inc
 * before the calendar footer HTML for all calendars.
 * This allows you to enforce a standard footer for all calendars.
 * This does not affect the default calendar.
 */
define(\'INCLUDE_STATIC_PRE_FOOTER\', ' . ($GLOBALS['Form_INCLUDE_STATIC_PRE_FOOTER']? 'true' : 'false') . ');' . "\n";

	// Output Include Static Post-Footer HTML
	$ConfigOutput .= '
/**
 * Config: Include Static Post-Footer HTML
 * Default: false
 * Include the file located at ./static-includes/subcalendar-post-footer.inc
 * after the calendar footer HTML for all calendars.
 * This allows you to enforce a standard footer for all calendars.
 * This does not affect the default calendar.
 */
define(\'INCLUDE_STATIC_POST_FOOTER\', ' . ($GLOBALS['Form_INCLUDE_STATIC_POST_FOOTER']? 'true' : 'false') . ');' . "\n";

	// Output Max Category Name Cache Size
	$ConfigOutput .= '
/**
 * Config: Max Category Name Cache Size
 * Default: 100
 * Cache the list of category names in memory if the calendar has less than or equal to this number.
 */
define(\'MAX_CACHESIZE_CATEGORYNAME\', \'' . escapephpstring($GLOBALS['Form_MAX_CACHESIZE_CATEGORYNAME']) . '\');' . "\n";

	// Output 'Subscribe & Download' Links to Static Files
	$ConfigOutput .= '
/**
 * Config: \'Subscribe & Download\' Links to Static Files
 * Default: false
 * When a lot of users subscribe to your calendar via the \'Subscribe & Download\' page,
 * this can put a heavy load on your server.
 * To avoid this you can enable this feature and either use a server or add-on
 * that supports caching (i.e. Apache 2.2, squid-cache) or you can use a script
 * to periodically retrieve and cache the files linked to from the \'Subscribe & Download\' page.
 * The \'Subscribe & Download\' page will then link to the static files rather than the export page.
 * - This also affects the RSS <link> in the HTML header.
 * - Enabling this feature does not stop users from accessing the export page.
 * - This has no effect on calendars that require users to login before viewing events.
 * For detailed instructions see http://vtcalendar.sourceforge.net/jump.php?name=cachesubscribe
 */
define(\'CACHE_SUBSCRIBE_LINKS\', ' . ($GLOBALS['Form_CACHE_SUBSCRIBE_LINKS']? 'true' : 'false') . ');' ."\n";

	// Output URL Extension to Static Files
	$ConfigOutput .= '
/**
 * Config: URL Extension to Static Files
 * Default: cache/subscribe/
 * The path from the VTCalendar URL to the static \'Subscribe & Download\' files.
 * It will be appended to the BASEURL (e.g. http://localhost/vtcalendar/cache/subscribe/)
 * Must end with a slash.
 */
define(\'CACHE_SUBSCRIBE_LINKS_PATH\', \'' . escapephpstring($GLOBALS['Form_CACHE_SUBSCRIBE_LINKS_PATH']) . '\');' . "\n";

	// Output Static Files Output Directory
	$ConfigOutput .= '
/**
 * Config: Static Files Output Directory
 * The directory path where the static \'Subscribe & Download\' files will be
 * outputted by the ./cache/export script.
 * Must be an absolute path (e.g. /var/www/htdocs/vtcalendar/cache/subscribe/).
 * Must end with a slash.
 */
define(\'CACHE_SUBSCRIBE_LINKS_OUTPUTDIR\', \'' . escapephpstring($GLOBALS['Form_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR']) . '\');' . "\n";

	// Output Export Path
	$ConfigOutput .= '
/**
 * Config: Export Path
 * Default: export/export.php
 * The URL extension to the export script. Must NOT being with a slash (/).
 */
define(\'EXPORT_PATH\', \'' . escapephpstring($GLOBALS['Form_EXPORT_PATH']) . '\');' . "\n";

	// Output Maximum Exported Events
	$ConfigOutput .= '
/**
 * Config: Maximum Exported Events
 * Default: 100
 * The maximum number of events that can be exported using the subscribe, download or export pages.
 * Calendar and main admins can export all data using the VTCalendar (XML) format.
 */
define(\'MAX_EXPORT_EVENTS\', \'' . escapephpstring($GLOBALS['Form_MAX_EXPORT_EVENTS']) . '\');' . "\n";

	// Output Export Data Lifetime (in minutes)
	$ConfigOutput .= '
/**
 * Config: Export Data Lifetime (in minutes)
 * Default: 5
 * The number of minutes that a browser will be told to cache exported data.
 */
define(\'EXPORT_CACHE_MINUTES\', \'' . escapephpstring($GLOBALS['Form_EXPORT_CACHE_MINUTES']) . '\');' . "\n";

	// Output Allow Public to Export in VTCalendar (XML) Format
	$ConfigOutput .= '
/**
 * Config: Allow Public to Export in VTCalendar (XML) Format
 * Default: false
 * The VTCalendar (XML) export format contains all information about an event,
 * which you may not want to allow the public to view.
 * However, users that are part of the admin sponsor, or are main admins,
 * can always export in this format.
 */
define(\'PUBLIC_EXPORT_VTCALXML\', ' . ($GLOBALS['Form_PUBLIC_EXPORT_VTCALXML']? 'true' : 'false') . ');' . "\n";

	// Output Send E-mail via Pear::Mail
	$ConfigOutput .= '
/**
 * Config: Send E-mail via Pear::Mail
 * Default: false
 * Send e-mail using Pear::Mail rather than the built-in PHP Mail function.
 * This should be used if you are on Windows or do not have sendmail installed.
 */
define(\'EMAIL_USEPEAR\', ' . ($GLOBALS['Form_EMAIL_USEPEAR']? 'true' : 'false') . ');' . "\n";

	// Output SMTP Host
	$ConfigOutput .= '
/**
 * Config: SMTP Host
 * Default: localhost
 * The SMTP host name to connect to.
 */
define(\'EMAIL_SMTP_HOST\', \'' . escapephpstring($GLOBALS['Form_EMAIL_SMTP_HOST']) . '\');' . "\n";

	// Output SMTP Port
	$ConfigOutput .= '
/**
 * Config: SMTP Port
 * Default: 25
 * The SMTP port number to connect to.
 */
define(\'EMAIL_SMTP_PORT\', \'' . escapephpstring($GLOBALS['Form_EMAIL_SMTP_PORT']) . '\');' . "\n";

	// Output SMTP Authentication
	$ConfigOutput .= '
/**
 * Config: SMTP Authentication
 * Default: false
 * Whether or not to use SMTP authentication.
 */
define(\'EMAIL_SMTP_AUTH\', ' . ($GLOBALS['Form_EMAIL_SMTP_AUTH']? 'true' : 'false') . ');' . "\n";

	// Output SMTP Username
	$ConfigOutput .= '
/**
 * Config: SMTP Username
 * The username to use for SMTP authentication.
 */
define(\'EMAIL_SMTP_USERNAME\', \'' . escapephpstring($GLOBALS['Form_EMAIL_SMTP_USERNAME']) . '\');' . "\n";

	// Output SMTP Password
	$ConfigOutput .= '
/**
 * Config: SMTP Password
 * The password to use for SMTP authentication.
 */
define(\'EMAIL_SMTP_PASSWORD\', \'' . escapephpstring($GLOBALS['Form_EMAIL_SMTP_PASSWORD']) . '\');' . "\n";

	// Output SMTP EHLO/HELO
	$ConfigOutput .= '
/**
 * Config: SMTP EHLO/HELO
 * Default: localhost
 * The value to give when sending EHLO or HELO.
 */
define(\'EMAIL_SMTP_HELO\', \'' . escapephpstring($GLOBALS['Form_EMAIL_SMTP_HELO']) . '\');' . "\n";

	// Output SMTP Timeout
	$ConfigOutput .= '
/**
 * Config: SMTP Timeout
 * Default: 0
 * The SMTP connection timeout.
 * Set the value to 0 to have no timeout.
 */
define(\'EMAIL_SMTP_TIMEOUT\', \'' . escapephpstring($GLOBALS['Form_EMAIL_SMTP_TIMEOUT']) . '\');' . "\n";

}
?>
