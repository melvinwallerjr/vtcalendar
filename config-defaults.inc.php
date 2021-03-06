<?php
// ##############################################
// WARNING: If you want to override the defaults below, define them in config.inc.php.
// Any changes to this file may be overwritten when you upgrade to a newer version of VTCalendar.
// ##############################################

// START GENERATED

// =====================================
// General
// =====================================

// Config: Title Prefix
// OPTIONAL. Added at the beginning of the <title> tag.
if (!defined('TITLEPREFIX')) { define('TITLEPREFIX', ''); }

// Config: Title Suffix
// Example: " - My University"
// OPTIONAL. Added at the end of the <title> tag.
if (!defined('TITLESUFFIX')) { define('TITLESUFFIX', ''); }

// Config: Language
// Example: en (English), de (German), sv (Swedish)
// Language used (refers to language file in directory /languages)
if (!defined('LANGUAGE')) { define('LANGUAGE', 'en'); }

// Config: Max Year Ahead for New Events
// The number of years into the future that the calendar will allow users to create events for.
// For example, if the current year is 2000 then a value of '3' will allow users to create events up to 2003.
if (!defined('ALLOWED_YEARS_AHEAD')) { define('ALLOWED_YEARS_AHEAD', 3); }

// =====================================
// Database
// =====================================

// Config: Database Connection String
// Example: mysql://vtcal:abc123@localhost/vtcalendar
// This is the database connection string used by the PEAR library.
// It has the format: "mysql://user:password@host/databasename" or "pgsql://user:password@host/databasename"
if (!defined('DATABASE')) { define('DATABASE', ''); }

// Config: Schema Name
// Example: public
// In some databases (such as PostgreSQL) you may have multiple sets of VTCalendar tables within the same database, but in different schemas.
// If this is the case for you, enter the name of the schema here.
// It will be prefixed to the table name like so: SCHEMANAME.vtcal_calendars.
// If necessary quote the schema name using a backtick (`) for MySQL or double quotes (") for PostgreSQL.
// Note: If specified, the table prefix MUST end with a period.
if (!defined('SCHEMANAME')) { define('SCHEMANAME', ''); }

// Config: SQL Log File
// Example: /var/log/vtcalendarsql.log
// OPTIONAL. Put a name of a (folder and) file where the calendar logs every SQL query to the database.
// This is good for debugging but make sure you write into a file that's not readable by the webserver or else you may expose private information.
// If left blank ("") no log will be kept. That's the default.
if (!defined('SQLLOGFILE')) { define('SQLLOGFILE', ''); }

// =====================================
// Authentication
// =====================================

// Config: User ID Regular Expression
// This regular expression defines what is considered a valid user-ID.
if (!defined('REGEXVALIDUSERID')) { define('REGEXVALIDUSERID', '/^[A-Za-z][\\._A-Za-z0-9\\-\\\\]{1,49}$/'); }

// Config: Database Authentication
// Authenticate users against the database.
// If enabled, this is always performed before any other authentication.
if (!defined('AUTH_DB')) { define('AUTH_DB', true); }

// Config: Prefix for Database Usernames
// Example: db_
// OPTIONAL. This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."
// If you only use auth_db just leave it an empty string.
// Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP.
if (!defined('AUTH_DB_USER_PREFIX')) { define('AUTH_DB_USER_PREFIX', ''); }

// Config: Database Authentication Notice
// OPTIONAL. This displays a text (or nothing) on the Update tab behind the user user management options.
// It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users know that they should create local users only if they are not in the LDAP.
if (!defined('AUTH_DB_NOTICE')) { define('AUTH_DB_NOTICE', ''); }

// Config: LDAP Authentication
// Authenticate users against a LDAP server.
// If enabled, HTTP authenticate will be ignored.
if (!defined('AUTH_LDAP')) { define('AUTH_LDAP', false); }

// Config: LDAP Host Name
// Example: directory.myuniversity.edu or ldap://directory.myuniversity.edu/ or ldaps://secure-directory.myuniversity.edu/
// If you are using OpenLDAP 2.x.x you can specify a URL ('ldap://host/') instead of the hostname ('host').
if (!defined('LDAP_HOST')) { define('LDAP_HOST', ''); }

// Config: LDAP Port
// The port to connect to. Ignored if LDAP Host Name is a URL.
if (!defined('LDAP_PORT')) { define('LDAP_PORT', 389); }

// Config: LDAP Username Attribute
// Example: sAMAccountName
// The attribute which contains the username.
if (!defined('LDAP_USERFIELD')) { define('LDAP_USERFIELD', ''); }

// Config: LDAP Base DN
// Example: DC=myuniversity,DC=edu
if (!defined('LDAP_BASE_DN')) { define('LDAP_BASE_DN', ''); }

// Config: Additional LDAP Search Filter
// Example: (objectClass=person)
// OPTIONAL. A filter to add to the LDAP search.
if (!defined('LDAP_SEARCH_FILTER')) { define('LDAP_SEARCH_FILTER', ''); }

// Config: LDAP Username
// Before authenticating the user, we first check if the username exists.
// If your LDAP server does not allow anonymous connections, specific a username here.
// Leave this blank to connect anonymously.
if (!defined('LDAP_BIND_USER')) { define('LDAP_BIND_USER', ''); }

// Config: LDAP Password
// If you specified LDAP_BIND_USER you must also enter a password here.
if (!defined('LDAP_BIND_PASSWORD')) { define('LDAP_BIND_PASSWORD', ''); }

// Config: HTTP Authentication
// Authenticate users by sending an HTTP request to a server.
// A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.
// If LDAP authentication is enabled, this will be ignored.
if (!defined('AUTH_HTTP')) { define('AUTH_HTTP', false); }

// Config: HTTP Authorizaton URL
// Example: http://localhost/customauth.php
// The URL to use for the BASIC HTTP Authentication.
if (!defined('AUTH_HTTP_URL')) { define('AUTH_HTTP_URL', ''); }

// =====================================
// Cookies
// =====================================

// Config: Cookie Path
// Example: /calendar/
// OPTIONAL. If you are hosting more than one VTCalendar on your server, you may want to set this to this calendar's path.
// Otherwise, the cookie will be submitted with a default path.
// This must start and end with a forward slash (/), unless the it is exactly "/".
if (!defined('BASEPATH')) { define('BASEPATH', ''); }

// Config: Cookie Host Name
// Example: localhost
// OPTIONAL. If you are hosting more than one VTCalendar on your server, you may want to set this to your server's host name.
// Otherwise, the cookie will be submitted with a default host name.
if (!defined('BASEDOMAIN')) { define('BASEDOMAIN', ''); }

// =====================================
// URL
// =====================================

// Config: Calendar Base URL
// Example: http://localhost/calendar/
// This is the absolute URL where your calendar software is located.
// This MUST end with a slash "/"
if (!defined('BASEURL')) { define('BASEURL', ''); }

// Config: Secure Calendar Base URL
// Example: https://localhost/calendar/
// This is the absolute path where the secure version of the calendar is located.
// If you are not using URL, set this to the same address as BASEURL.
// This MUST end with a slash "/"
if (!defined('SECUREBASEURL')) { define('SECUREBASEURL', BASEURL); }

// =====================================
// Date/Time
// =====================================

// Config: Timezone
// Example: America/New_York
// The timezone in which the calendar will set the local time for. All new events, logs, etc will be affected by this setting.
// For a list of supported timezone identifiers see http://us.php.net/manual/en/timezones.php
if (!defined('TIMEZONE')) { define('TIMEZONE', ''); }

// Config: Week Starting Day
// Defines the week starting day
// Allowable values - 0 for "Sunday" or 1 for "Monday"
if (!defined('WEEK_STARTING_DAY')) { define('WEEK_STARTING_DAY', 0); }

// Config: Use AM/PM
// Defines time format e.g. 1am-11pm (true) or 1:00-23:00 (false)
if (!defined('USE_AMPM')) { define('USE_AMPM', true); }

// =====================================
// Display
// =====================================

// Config: Column Position
// Which side the little calendar, 'jump to', 'today is', etc. will be on.
// RIGHT is more user friendly for users with low resolutions.
// Values must be LEFT or RIGHT.
if (!defined('COLUMNSIDE')) { define('COLUMNSIDE', 'RIGHT'); }

// Config: Show Upcoming Tab
// Whether or not the upcoming tab will be shown.
if (!defined('SHOW_UPCOMING_TAB')) { define('SHOW_UPCOMING_TAB', true); }

// Config: Max Upcoming Events
// The maximum number of upcoming events displayed.
if (!defined('MAX_UPCOMING_EVENTS')) { define('MAX_UPCOMING_EVENTS', 25); }

// Config: Show Month Overlap
// Whether or not events in month view on days that are not actually part of the current month should be shown.
// For example, if the first day of the month starts on a Wednesday, then Sunday-Tuesday are from the previous month.
if (!defined('SHOW_MONTH_OVERLAP')) { define('SHOW_MONTH_OVERLAP', true); }

// Config: Combined 'Jump To' Drop-Down
// Whether or not the 'jump to' drop-down in the column will be combined into a single drop-down box or not.
// When set to true, the list will contain all possible month/years combinations for the next X years (where X is ALLOWED_YEARS_AHEAD).
// Only the last 3 months will be included in this list.
if (!defined('COMBINED_JUMPTO')) { define('COMBINED_JUMPTO', true); }

// Config: Use Custom Login Page
// By default the login page includes the login form and a message about how to request a login to the calendar.
// When set to true, a file at ./static-includes/loginform.inc will be used as a custom login page:
//  * It must include @@LOGIN_FORM@@ which will be replaced with the login form itself.
//  * You can also include @@LOGIN_HEADER@@ which will be replaced with the "Login" header text for the translation you specified.
//  * See the ./static-includes/loginform-EXAMPLE.inc file for an example.
if (!defined('CUSTOM_LOGIN_HTML')) { define('CUSTOM_LOGIN_HTML', false); }

// Config: Include Static Pre-Header HTML
// Include the file located at ./static-includes/subcalendar-pre-header.inc before the calendar header HTML for all calendars.
// This allows you to enforce a standard header for all calendars.
// This does not affect the default calendar.
if (!defined('INCLUDE_STATIC_PRE_HEADER')) { define('INCLUDE_STATIC_PRE_HEADER', false); }

// Config: Include Static Post-Header HTML
// Include the file located at ./static-includes/subcalendar-post-header.inc after the calendar header HTML for all calendars.
// This allows you to enforce a standard header for all calendars.
// This does not affect the default calendar.
if (!defined('INCLUDE_STATIC_POST_HEADER')) { define('INCLUDE_STATIC_POST_HEADER', false); }

// Config: Include Static Pre-Footer HTML
// Include the file located at ./static-includes/subcalendar-pre-footer.inc before the calendar footer HTML for all calendars.
// This allows you to enforce a standard footer for all calendars.
// This does not affect the default calendar.
if (!defined('INCLUDE_STATIC_PRE_FOOTER')) { define('INCLUDE_STATIC_PRE_FOOTER', false); }

// Config: Include Static Post-Footer HTML
// Include the file located at ./static-includes/subcalendar-post-footer.inc after the calendar footer HTML for all calendars.
// This allows you to enforce a standard footer for all calendars.
// This does not affect the default calendar.
if (!defined('INCLUDE_STATIC_POST_FOOTER')) { define('INCLUDE_STATIC_POST_FOOTER', false); }

// =====================================
// Cache
// =====================================

// Config: Max Category Name Cache Size
// Cache the list of category names in memory if the calendar has less than or equal to this number.
if (!defined('MAX_CACHESIZE_CATEGORYNAME')) { define('MAX_CACHESIZE_CATEGORYNAME', 100); }

// Config: 'Subscribe & Download' Links to Static Files
// When a lot of users subscribe to your calendar via the 'Subscribe & Download' page, this can put a heavy load on your server.
// To avoid this you can enable this feature and either use a server or add-on that supports caching (i.e. Apache 2.2, squid-cache) or you can use a script to periodically retrieve and cache the files linked to from the 'Subscribe & Download' page.
// The 'Subscribe & Download' page will then link to the static files rather than the export page.
//  * This also affects the RSS <link> in the HTML header.
//  * Enabling this feature does not stop users from accessing the export page.
//  * This has no effect on calendars that require users to login before viewing events.
// For detailed instructions see http://vtcalendar.sourceforge.net/jump.php?name=cachesubscribe
if (!defined('CACHE_SUBSCRIBE_LINKS')) { define('CACHE_SUBSCRIBE_LINKS', false); }

// Config: URL Extension to Static Files
// The path from the VTCalendar URL to the static 'Subscribe & Download' files.
// It will be appended to the BASEURL (e.g. http://localhost/vtcalendar/cache/subscribe/)
// Must end with a slash.
if (!defined('CACHE_SUBSCRIBE_LINKS_PATH')) { define('CACHE_SUBSCRIBE_LINKS_PATH', 'cache/subscribe/'); }

// Config: Static Files Output Directory
// The directory path where the static 'Subscribe & Download' files will be outputted by the ./cache/export script.
// Must be an absolute path (e.g. /var/www/htdocs/vtcalendar/cache/subscribe/).
// Must end with a slash.
if (!defined('CACHE_SUBSCRIBE_LINKS_OUTPUTDIR')) { define('CACHE_SUBSCRIBE_LINKS_OUTPUTDIR', ''); }

// =====================================
// Export
// =====================================

// Config: Export Path
// The URL extension to the export script. Must NOT being with a slash (/).
if (!defined('EXPORT_PATH')) { define('EXPORT_PATH', 'export/export.php'); }

// Config: Maximum Exported Events
// The maximum number of events that can be exported using the subscribe, download or export pages.
// Calendar and main admins can export all data using the VTCalendar (XML) format.
if (!defined('MAX_EXPORT_EVENTS')) { define('MAX_EXPORT_EVENTS', 100); }

// Config: Export Data Lifetime (in minutes)
// The number of minutes that a browser will be told to cache exported data.
if (!defined('EXPORT_CACHE_MINUTES')) { define('EXPORT_CACHE_MINUTES', 5); }

// Config: Allow Public to Export in VTCalendar (XML) Format
// The VTCalendar (XML) export format contains all information about an event, which you may not want to allow the public to view.
// However, users that are part of the admin sponsor, or are main admins, can always export in this format.
if (!defined('PUBLIC_EXPORT_VTCALXML')) { define('PUBLIC_EXPORT_VTCALXML', false); }

// =====================================
// E-Mail
// =====================================

// Config: Send E-mail via Pear::Mail
// Send e-mail using Pear::Mail rather than the built-in PHP Mail function.
// This should be used if you are on Windows or do not have sendmail installed.
if (!defined('EMAIL_USEPEAR')) { define('EMAIL_USEPEAR', false); }

// Config: SMTP Host
// The SMTP host name to connect to.
if (!defined('EMAIL_SMTP_HOST')) { define('EMAIL_SMTP_HOST', 'localhost'); }

// Config: SMTP Port
// The SMTP port number to connect to.
if (!defined('EMAIL_SMTP_PORT')) { define('EMAIL_SMTP_PORT', 25); }

// Config: SMTP Authentication
// Whether or not to use SMTP authentication.
if (!defined('EMAIL_SMTP_AUTH')) { define('EMAIL_SMTP_AUTH', false); }

// Config: SMTP Username
// The username to use for SMTP authentication.
if (!defined('EMAIL_SMTP_USERNAME')) { define('EMAIL_SMTP_USERNAME', ''); }

// Config: SMTP Password
// The password to use for SMTP authentication.
if (!defined('EMAIL_SMTP_PASSWORD')) { define('EMAIL_SMTP_PASSWORD', ''); }

// Config: SMTP EHLO/HELO
// The value to give when sending EHLO or HELO.
if (!defined('EMAIL_SMTP_HELO')) { define('EMAIL_SMTP_HELO', 'localhost'); }

// Config: SMTP Timeout
// The SMTP connection timeout.
// Set the value to 0 to have no timeout.
if (!defined('EMAIL_SMTP_TIMEOUT')) { define('EMAIL_SMTP_TIMEOUT', 0); }

// END GENERATED

// TODO: Disabled feature.
define('AUTH_HTTP_CACHE', false);
define('AUTH_HTTP_CACHE_EXPIRATIONDAYS', 4);

// Config: Version Check
// Whether or not VTCalendar will check for a newer version when main admins log in.
if (!defined('CHECKVERSION')) { define('CHECKVERSION', true); }

// If 00:00 - 23:00 time format is used, appropriate day start/end hours will be used in datetime2timestamp functions where calculating day edges
define('DAY_BEG_H', 0);
define('DAY_END_H', USE_AMPM? 11 : 23);

// Make sure the TIMEZONE is not set or is valid.
if (TIMEZONE != '') {
	if (!(function_exists('date_default_timezone_set')?
	 @date_default_timezone_set(TIMEZONE) : @putenv('TZ=' . TIMEZONE))) {
		exit('TIMEZONE in config.inc.php was set to an invalid identifier.');
	}
}

// ---------- The following functions allow you to customize processing based on your database -------

// Escapes a value to make it safe for a SQL query
//function sqlescape($value) { }

// --------------- The following functions allow you to customize the date format display ------------
if (!function_exists('day_view_date_format')) {
	function day_view_date_format($date, $dow, $month, $year)
	{ // formats date output for date title in day and event view
		if (lang('lang') == 'lv') {
			return $dow . ', ' . $date . '. ' . $month.  ', ' . $year; // Latvian format
		}
		return $dow . ', ' . $month . ' ' . $date . ', ' . $year; // US format
	}
}

if (!function_exists('week_view_date_format')) {
	function week_view_date_format($date_from, $month_from, $year_from, $date_to, $month_to, $year_to)
	{ // formats date output for datetitle in week view
		if (lang('lang') == 'lv') { // Latvian format
			$date_str = $date_from . '. '; // "13. "
			if ($month_from != $month_to) { $date_str .= $month_from; } //"13. janvaris"
			if ($year_from != $year_to) { $date_str .= ', ' . $year_from; } //  "13. janvaris, 2003"
			$date_str .= ' - ';
			$date_str .= $date_to . '. ' . $month_to . ', ' . $year_to;
			return  $date_str;
		}
		else { // US format
			$date_str = $month_from . ' ' . $date_from;
			if ($year_from != $year_to) { $date_str .= ', ' . $year_from; }
			$date_str .= ' - ';
			if ($month_from != $month_to) { $date_str .= $month_to . ' '; }
			$date_str .= $date_to . ', ' . $year_to;
			return  $date_str;
		}
	}
}

if (!function_exists('month_view_date_format')) {
	function month_view_date_format($month, $year)
	{ // formats date output for date title in month view
		if (lang('lang') == 'lv') { return $month . ', ' . $year; } // Latvian format
		return $month . ' ' . $year; // US format
	}
}

if (!function_exists('above_lit_cal_date_format')) {
	function above_lit_cal_date_format($month, $year)
	{ // formats date output for date above little calendar (month browsing link)
		if (lang('lang') == 'lv') { return $month . ', ' . $year; }
		return $month . ' ' . $year; // US format
	}
}

if (!function_exists('today_is_date_format')) {
	function today_is_date_format($date, $dow, $month, $year)
	{ // formats date output for todays date under little calendar
		if (lang('lang') == 'lv') { // Latvian format
			return $dow . ', ' . $date . '. ' . $month . ', ' . $year;
		}
		return $dow . ', ' . $month . ' ' . ltrim($date, '0') . ', ' . $year; // US format
	}
}

if (!function_exists('week_header_date_format')) {
	function week_header_date_format($date, $month)
	{ // formats date for weeks view day's header
		if (lang('lang') == 'lv') { // Latvian format
			return $date . '. ' . $month;
		}
		return $month . ' ' . $date; // US format
	}
}

// formats date for searchresult in found items list
if (!function_exists('searchresult_date_format')) {
	function searchresult_date_format($date, $dow, $month, $year) {
		if (lang('lang') == 'lv') { // Latvian format
			return $dow . ', ' . $date . '. ' . $month . ', ' . $year;
		}
		return $dow . ', ' . $month . ' ' . $date . ', ' . $year; // US format
	}
}
?>