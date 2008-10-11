<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

define("CRLF", "\r\n");

/* ============================================================
         Constants that define valid values for fields.
				 TODO: Merge with section later in this file.
============================================================ */

define("REGEXVALIDCOLOR","/^#[ABCDEFabcdef0-9]{6,6}$/");
define("MAXLENGTH_SPONSOR","50"); // NOT CONSISTANT (see below) -- only in import.php
define("FEEDBACKPOS","0");
define("FEEDBACKNEG","1");

/* ============================================================
                   Current date and time
============================================================ */

define("NOW", time()); //debug: mktime(15, 0, 0, 9, 30, 2008)); 
define("NOW_AS_TEXT", date("Y-m-d H:i:s", NOW));
define("NOW_AS_TIMENUM",  timestamp2timenumber(NOW_AS_TEXT));

/* ============================================================
  Constants that define valid values/lengths for input data.
============================================================ */

// Regular Expressions that validate text input
define("constValidTextCharFullRegEx",'\s\x20-\x7E\xA0-\xFF'); // Includes all valid ISO-8859-1 characters
define("constValidTextCharWithoutSpacesRegEx",'\w~!@#\$%^&*\(\)\-+=\{\}\[\]\|\\\:";\'<>?,.\/'.chr(188).chr(189).chr(190)); //188, 189, 190 are 1/4, 1/2, 3/4 respectively
define("constValidTextCharWithSpacesRegEx",' '.constValidTextCharWithoutSpacesRegEx);
define("constValidTextCharWithWhitespaceRegEx",'\s'.constValidTextCharWithoutSpacesRegEx);

define("MAXLENGTH_PASSWORD",20);
define("constPasswordRegEx", '/^['.constValidTextCharWithoutSpacesRegEx.']{1,'.MAXLENGTH_PASSWORD.'}$/');

// Max length of input
define("MAXLENGTH_CALENDARID",50);
define("MAXLENGTH_CALENDARNAME",100);
define("MAXLENGTH_CALENDARTITLE",50);
define("MAXLENGTH_KEYWORD",100);
define("MAXLENGTH_SPECIFICSPONSOR",100);
define("MAXLENGTH_TITLE",1024);
define("MAXLENGTH_IMPORTURL",100);
define("MAXLENGTH_URL",100);
define("MAXLENGTH_LOCATION",100);
define("MAXLENGTH_PRICE",100);
define("MAXLENGTH_CONTACT_NAME",100);
define("MAXLENGTH_CONTACT_PHONE",100);
define("MAXLENGTH_DESCRIPTION",10000);
define("MAXLENGTH_DISPLAYEDSPONSOR",100);
define("MAXLENGTH_DISPLAYEDSPONSORURL",100);
define("MAXLENGTH_TEMPLATE_NAME",100);
define("MAXLENGTH_EMAIL",100);
define("MAXLENGTH_CATEGORY_NAME",100);
define("MAXLENGTH_SPONSOR_NAME",100);

// Special error messages for invalid input
define("constCalendaridVALIDMESSAGE", '1 to '.MAXLENGTH_CALENDARID.' characters (A-Z,a-z,0-9,-,.)');
define("constCalendarnameVALIDMESSAGE", '1 to '.MAXLENGTH_CALENDARNAME.' characters (A-Z,a-z,0-9,-,.,&amp;,\',[space],[comma])');

/* ============================================================
             Constants used for XML processing
============================================================ */

define("DEFAULTXMLSTARTELEMENTHANDLER", "");
define("DEFAULTXMLENDELEMENTHANDLER", "");
define("DEFAULTXMLERRORHANDLER", "");
define("FILEOPENERROR","2");
?>