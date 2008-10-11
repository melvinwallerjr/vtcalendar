<?php
if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files

define("CRLF", "\r\n");

/* ============================================================
         Constants that define valid values for fields.
				 TODO: Merge with section later in this file.
============================================================ */

define("REGEXVALIDCOLOR","/^#[ABCDEFabcdef0-9]{6,6}$/");
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

define("constPasswordMaxLength",20);
define("constPasswordRegEx", '/^['.constValidTextCharWithoutSpacesRegEx.']{1,'.constPasswordMaxLength.'}$/');

// Max length of input
define("constCalendaridMAXLENGTH",50);
define("constCalendarnameMAXLENGTH",100);
define("constCalendarTitleMAXLENGTH",50);
define("constKeywordMaxLength",100);
define("constSpecificsponsorMaxLength",100);
define("constTitleMaxLength",1024);
define("constImporturlMaxLength",100);
define("constUrlMaxLength",100);
define("constLocationMaxLength",100);
define("constPriceMaxLength",100);
define("constContact_nameMaxLength",100);
define("constContact_phoneMaxLength",100);
define("constDescriptionMaxLength",10000);
define("constDisplayedsponsorMaxLength",100);
define("constDisplayedsponsorurlMaxLength",100);
define("constTemplate_nameMaxLength",100);
define("constEmailMaxLength",100);
define("constCategory_nameMaxLength",100);
define("constSponsor_nameMaxLength",100);

// Special error messages for invalid input
define("constCalendaridVALIDMESSAGE", '1 to '.constCalendaridMAXLENGTH.' characters (A-Z,a-z,0-9,-,.)');
define("constCalendarnameVALIDMESSAGE", '1 to '.constCalendarnameMAXLENGTH.' characters (A-Z,a-z,0-9,-,.,&amp;,\',[space],[comma])');

/* ============================================================
             Constants used for XML processing
============================================================ */

define("DEFAULTXMLSTARTELEMENTHANDLER", "");
define("DEFAULTXMLENDELEMENTHANDLER", "");
define("DEFAULTXMLERRORHANDLER", "");
define("FILEOPENERROR","2");
?>