<?php
// =====================================
// GENERATED Config Validation
// =====================================

if (!is_string(TITLEPREFIX)) exit('TITLEPREFIX must be a string.');
if (!is_string(TITLESUFFIX)) exit('TITLESUFFIX must be a string.');
if (!is_string(LANGUAGE)) exit('LANGUAGE must be a string.');
if (LANGUAGE == '') exit('LANGUAGE cannot be an empty string.');
if (!is_string(DATABASE)) exit('DATABASE must be a string.');
if (DATABASE == '') exit('DATABASE cannot be an empty string.');
if (!is_string(SQLLOGFILE)) exit('SQLLOGFILE must be a string.');
if (!is_string(REGEXVALIDUSERID)) exit('REGEXVALIDUSERID must be a string.');
if (REGEXVALIDUSERID == '') exit('REGEXVALIDUSERID cannot be an empty string.');
if (!is_bool(AUTH_DB)) exit('AUTH_DB must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_string(AUTH_DB_USER_PREFIX)) exit('AUTH_DB_USER_PREFIX must be a string.');
if (!is_string(AUTH_DB_NOTICE)) exit('AUTH_DB_NOTICE must be a string.');
if (!is_bool(AUTH_LDAP)) exit('AUTH_LDAP must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_string(LDAP_HOST)) exit('LDAP_HOST must be a string.');
if (LDAP_HOST == '') exit('LDAP_HOST cannot be an empty string.');
if (!is_numeric(LDAP_PORT)) exit('LDAP_PORT must be an numeric.');
if (!is_string(LDAP_USERFIELD)) exit('LDAP_USERFIELD must be a string.');
if (LDAP_USERFIELD == '') exit('LDAP_USERFIELD cannot be an empty string.');
if (!is_string(LDAP_BASE_DN)) exit('LDAP_BASE_DN must be a string.');
if (LDAP_BASE_DN == '') exit('LDAP_BASE_DN cannot be an empty string.');
if (!is_string(LDAP_SEARCH_FILTER)) exit('LDAP_SEARCH_FILTER must be a string.');
if (!is_string(LDAP_BIND_USER)) exit('LDAP_BIND_USER must be a string.');
if (LDAP_BIND_USER == '') exit('LDAP_BIND_USER cannot be an empty string.');
if (!is_string(LDAP_BIND_PASSWORD)) exit('LDAP_BIND_PASSWORD must be a string.');
if (LDAP_BIND_PASSWORD == '') exit('LDAP_BIND_PASSWORD cannot be an empty string.');
if (!is_bool(AUTH_HTTP)) exit('AUTH_HTTP must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_string(AUTH_HTTP_URL)) exit('AUTH_HTTP_URL must be a string.');
if (AUTH_HTTP_URL == '') exit('AUTH_HTTP_URL cannot be an empty string.');
if (!is_string(BASEPATH)) exit('BASEPATH must be a string.');
if (!is_string(BASEDOMAIN)) exit('BASEDOMAIN must be a string.');
if (!is_string(BASEURL)) exit('BASEURL must be a string.');
if (BASEURL == '') exit('BASEURL cannot be an empty string.');
if (!is_string(SECUREBASEURL)) exit('SECUREBASEURL must be a string.');
if (!is_numeric(TIMEZONE_OFFSET)) exit('TIMEZONE_OFFSET must be an numeric.');
if (!is_numeric(WEEK_STARTING_DAY)) exit('WEEK_STARTING_DAY must be an numeric.');
if (!is_bool(USE_AMPM)) exit('USE_AMPM must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_string(COLUMNSIDE)) exit('COLUMNSIDE must be a string.');
if (COLUMNSIDE == '') exit('COLUMNSIDE cannot be an empty string.');
if (!is_bool(SHOW_UPCOMING_TAB)) exit('SHOW_UPCOMING_TAB must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_numeric(MAX_UPCOMING_EVENTS)) exit('MAX_UPCOMING_EVENTS must be an numeric.');
if (!is_bool(SHOW_MONTH_OVERLAP)) exit('SHOW_MONTH_OVERLAP must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_bool(AUTH_HTTP_CACHE)) exit('AUTH_HTTP_CACHE must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_numeric(AUTH_HTTP_CACHE_EXPIRATIONDAYS)) exit('AUTH_HTTP_CACHE_EXPIRATIONDAYS must be an numeric.');
if (!is_numeric(MAX_CACHESIZE_CATEGORYNAME)) exit('MAX_CACHESIZE_CATEGORYNAME must be an numeric.');
if (!is_bool(CACHE_ICS)) exit('CACHE_ICS must be a boolean true or false. Make sure it is not enclosed in quotes.');
if (!is_string(EXPORT_PATH)) exit('EXPORT_PATH must be a string.');
if (EXPORT_PATH == '') exit('EXPORT_PATH cannot be an empty string.');
if (!is_numeric(MAX_EXPORT_EVENTS)) exit('MAX_EXPORT_EVENTS must be an numeric.');
if (!is_numeric(EXPORT_CACHE_MINUTES)) exit('EXPORT_CACHE_MINUTES must be an numeric.');
if (!is_bool(PUBLIC_EXPORT_VTCALXML)) exit('PUBLIC_EXPORT_VTCALXML must be a boolean true or false. Make sure it is not enclosed in quotes.');

// =====================================
// Manual Config Validation
// =====================================

// Check for an LDAP function if AUTH_LDAP is true.
if (AUTH_LDAP && !function_exists("ldap_connect")) {
	exit("PHP LDAP does not seem to be installed or configured. Make sure the extension is included in your php.ini file.");
}

// Make sure the HTTP auth URL is specified if AUTH_HTTP is true.
if (AUTH_HTTP && (!defined("AUTH_HTTP_URL") || AUTH_HTTP_URL == "")) {
	exit("You must set AUTH_HTTP_URL if AUTH_HTTP is set to true.");
}

// Check that the required LDAP settings were set if AUTH_LDAP is true.
if (AUTH_LDAP && (!defined("LDAP_HOST") || LDAP_HOST == "" || !defined("LDAP_USERFIELD") || LDAP_USERFIELD == "" || !defined("LDAP_BASE_DN") || LDAP_BASE_DN == "")) {
	exit("You must set LDAP_HOST, LDAP_USERFIELD and LDAP_BASE_DN if AUTH_LDAP is set to true.");
}

if (!defined("BASEURL") || substr(BASEURL, -1) != "/") {
	exit("You must set BASEURL and it MUST end with a slash ('/').");
}

if (substr(SECUREBASEURL, -1) != "/") {
	exit("SECUREBASEURL MUST end with a slash ('/').");
}

if (WEEK_STARTING_DAY != 0 && WEEK_STARTING_DAY != 1) {
	exit("WEEK_STARTING_DAY MUST be 0 or 1.");
}
?>