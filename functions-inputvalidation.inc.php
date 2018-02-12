<?php
function isValidInput($value, $type)
{ // checks the input against regular expressions
	if (!isset($value)) { return false; }
	if ($type == 'approveall') {
		if ($value == '1') { return true; }
	}
	elseif ($type == 'approveallevents') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'approvethis') {
		if ($value == '1') { return true; }
	}
	elseif ($type == 'calendarFooter') { // needs refinement
		return true;
	}
	elseif ($type == 'calendarHeader') { // needs refinement
		return true;
	}
	elseif ($type == 'calendarHTMLHeader') { // needs refinement
		return true;
	}
	elseif ($type == 'calendarid') {
		if (preg_match('/^[A-Z0-9\-\.]{1,' . MAXLENGTH_CALENDARID . '}$/i', $value)) { return true; }
	}
	elseif ($type == 'calendarTitle') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_CALENDARTITLE . '}$/', $value)) { return true; }
	}
	elseif ($type == 'cancel') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'categoryid') {
		if (is_numeric($value) && $value >= 0 && $value <= 100000) { return true; }
	}
	elseif ($type == 'categoryidlist') {
		// TODO: is '== 1' correct? This was '== 0' but that didn't seem to make sense.
		return (preg_match('/^[0-9]+(,[0-9]+)*$/', $value) == 1);
	}
	elseif ($type == 'category_name') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_SPACES . ']{1,' .
		 MAXLENGTH_CATEGORY_NAME . '}$/i', $value)) { return true; }
	}
	elseif ($type == 'calendarname') {
		if (preg_match('/^[A-Z0-9\-\.\&#;\(\)\!\' ,]{1,' . MAXLENGTH_CALENDARNAME .
		 '}$/i', $value)) { return true; }
	}
	elseif ($type == 'calendarlanguage') {
		if (!empty($value)) {
			if ($dh = opendir('languages')) { // PHP4 compatable directory read
				while (($file = readdir($dh)) !== false) {
					if (preg_match("|^(.*)\.inc\.php$|", $file, $matches)) { $languages[] = $matches[1]; }
				}
				closedir($dh);
			}
			if (isset($languages) && count($languages) > 0) { // compare to available languages
				foreach ($languages as $language) {
					if (mb_strtolower($language, 'UTF-8') == mb_strtolower($value, 'UTF-8')) { return true; }
				}
			}
		}
	}
	elseif ($type == 'newlang') {
		if (preg_match('/^[a-z]{2,2}$/', $value)) { return true; }
	}
	elseif ($type == 'check') {
		if ($value == '1') { return true; }
	}
	elseif ($type == 'choosetemplate') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'chooseuser') {
		if ($value == '0' || $value == '1') { return true; }
	}
	elseif ($type == 'color') {
		if (preg_match('/^#[0-9a-fA-F]{6,6}$/', $value)) { return true; }
	}
	elseif ($type == 'background') { // TODO: Does this need improving?
		return true;
	}
	elseif ($type == 'contact_name') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_CONTACT_NAME . '}$/', $value)) { return true; }
	}
	elseif ($type == 'contact_phone') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_CONTACT_PHONE . '}$/', $value)) { return true; }
	}
	elseif ($type == 'contact_email') {
		$validEmailRegex = '/^[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])*' .
		 '@[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])+$/';
		if (empty($value) || preg_match($validEmailRegex, $value) > 0 || (preg_match('/^[' .
		 REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' . MAXLENGTH_EMAIL . '}$/', $value) > 0 &&
		 strpos($value, '://') !== false)) { return true; }
	}
	elseif ($type == 'copy') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'delete') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'deleteall') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'deleteconfirmed') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'deleteevents') {
		if ($value == '0' || $value == '1') { return true; }
	}
	elseif ($type == 'deletethis') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'deleteuser') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'description') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_DESCRIPTION . '}$/', $value)) { return true; }
	}
	elseif ($type == 'displayedsponsor') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_DISPLAYEDSPONSOR . '}$/', $value)) { return true; }
	}
	elseif ($type == 'duration') {
		if ($value == '1' || $value == '2' || $value == '3') { return true; }
	}
	elseif ($type == 'edit') { // 'Go back and make changes' button
		if (strlen($value) > 1) { return true; }
	}
	elseif ($type == 'email') {
		$validEmailRegex = '/^[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])*' .
		 '@[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])+$/';
		if (empty($value) || preg_match($validEmailRegex, $value) > 0 || (preg_match('/^[' .
		 REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' . MAXLENGTH_EMAIL . '}$/', $value) > 0 &&
		 strpos($value, '://') !== false)) { return true; }
	}
	elseif ($type == 'eventid') { // e.g. "1064818293904-0017"
		if (preg_match('/^[0-9]{13}$/', $value) ||
		 preg_match('/^[0-9]{13}-[0-9]{4}$/', $value)) { return true; }
	}
	elseif ($type == 'eventidlist') { // e.g. "1064818293904,1064818293934-0002"
		if (!empty($value)) {
			$eventids=split(',', $value);
			for ($i=0; $i < count($eventids); $i++) {
				$eventid = $eventids[$i];
				if (!isValidInput($eventid, 'eventid')) { return false; }
			}
			return true;
		}
	}
	elseif ($type == 'featuretext') { // needs refinement
		return true;
	}
	elseif ($type == 'categoryfilter') { // Array of category ids, e.g. [0]=>5, [1]=>7, [2]=>12
		if (is_string($value)) {
			if (strlen($value) > 1000) { return false; }
			$categoryids = split(',', $value);
			if (count($categoryids) == 0) { return true; }
			foreach ($categoryids as $categoryid) {
				if (!isValidInput($categoryid, 'categoryid')) { return false; }
			}
			return true;
		}
		elseif (is_array($value)) {
			if (count($value) == 0) { return true; }
			if (count($value) > 1000) { return false; }
			foreach ($value as $categoryid) {
				if (!isValidInput($categoryid, 'categoryid')) { return false; }
			}
			return true;
		}
		else { return false; }
	}
	elseif ($type == 'forwardeventdefault') {
		if ($value == '1') { return true; }
	}
	elseif ($type == 'frequency1') {
		if ($value == 'day' || $value == 'week' || $value == 'month' || $value == 'year' ||
		 $value == 'monwedfri' || $value == 'tuethu' || $value == 'montuewedthufri' || $value == 'satsun' ||
		 $value == 'sunday' || $value == 'monday' || $value == 'tuesday' || $value == 'wednesday' ||
		 $value == 'thursday' || $value == 'friday' || $value == 'saturday') { return true; }
	}
	elseif ($type == 'frequency2modifier1') {
		if ($value == 'first' || $value == 'second' || $value == 'third' ||
		 $value == 'fourth' || $value == 'last') { return true; }
	}
	elseif ($type == 'frequency2modifier2') {
		if ($value == 'sun' || $value == 'mon' || $value == 'tue' || $value == 'wed' ||
		 $value == 'thu' || $value == 'fri' || $value == 'sat') { return true; }
	}
	elseif ($type == 'httpreferer') { // note: need to design a better test
		if (strlen($value) < 500) { return true; }
	}
	elseif ($type == 'importurl') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_IMPORTURL . '}$/', $value)) { return true; }
	}
	elseif ($type == 'interval1') {
		if ($value == 'every' || $value == 'everyother' || $value == 'everythird' ||
		 $value == 'everyfourth') { return true; }
	}
	elseif ($type == 'interval2') {
		if ($value == 'month' || $value == '2months' || $value == '3months' ||
		 $value == '4months' || $value == '6months' || $value == 'year') { return true; }
	}
	elseif ($type == 'keyword') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_KEYWORD . '}$/', $value)) { return true; }
	}
	elseif ($type == 'location') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_LOCATION . '}$/', $value)) { return true; }
	}
	elseif ($type == 'webmap') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_WEBMAP . '}$/', $value)) { return true; }
	}
	elseif ($type == 'mode') { // repeat['mode']
		if (is_numeric($value) && $value >= 0 && $value <= 10) { return true; }
	}
	elseif ($type == 'password') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR . ']{1,' .
		 MAXLENGTH_PASSWORD . '}$/', $value)) { return true; }
	}
	elseif ($type == 'preview') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'price') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_PRICE . '}$/', $value)) { return true; }
	}
	elseif ($type == 'reject') {
		if ($value == '1') { return true; }
	}
	elseif ($type == 'rejectconfirmedall') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'rejectconfirmedthis') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'rejectreason') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,500}$/', $value)) { return true; }
	}
	elseif ($type == 'repeatid') { // e.g. "1064818293904"
		if (preg_match('/^[0-9]{13}$/', $value)) { return true; }
	}
	elseif ($type == 'repeatdef') { // e.g. "D1 20040629T235900"
		if (preg_match('/^[A-Z 0-9\+\-]{0,100}$/', $value)) { return true; }
	}
	elseif ($type == 'save') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'savetemplate') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'savethis') { // 'Save changes' button
		if (strlen($value) > 1) { return true; }
	}
	elseif ($type == 'searchkeywordid') {
		if (is_numeric($value) && $value >= 0 && $value <= 100000) { return true; }
	}
	elseif ($type == 'showondefaultcal') {
		if ($value == '0' || $value == '1') { return true; }
	}
	elseif ($type == 'sponsorid') {
		if ($value == 'all' || (is_numeric($value) && $value >= 1 && $value <= 100000)) { return true; }
	}
	elseif ($type == 'sponsor_admins') { // needs refinement, allow newlines
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,500}$/', $value)) { return true; }
	}
	elseif ($type == 'sponsor_email') {
		$validEmailRegex = '/^[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])*' .
		 '@[0-9a-zA-Z\~\!#$%&_\-]([.]?[0-9a-zA-Z\~\!#$%&_\-])+$/';
		if (empty($value) || preg_match($validEmailRegex, $value) > 0 || (preg_match('/^[' .
		 REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' . MAXLENGTH_EMAIL . '}$/', $value) > 0 &&
		 strpos($value, '://') !== false)) { return true; }
	}
	elseif ($type == 'sponsor_name') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_SPONSOR_NAME . '}$/', $value)) { return true; }
	}
	elseif ($type == 'sponsor_url') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_URL . '}$/', $value)) { return true; }
	}
	elseif ($type == 'startimport') {
		if (!empty($value)) { return true; }
	}
	elseif ($type == 'templateid') {
		if (is_numeric($value) && $value >= 0 && $value <= 100000) { return true; }
	}
	elseif ($type == 'template_name') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_TEMPLATE_NAME . '}$/', $value)) { return true; }
	}
	elseif ($type == 'timebegin' || $type == 'timeend' || $type == 'littlecal') {
		// e.g. "2004-05-26 00:00:00" or "today"
		if ($value == 'today' || $value == 'now') { return true; }
		if (strlen($value) == 19 && isDate(substr($value, 0, 10)) &&
		 $value{0} && isTime(substr($value, 11, 8))) { return true; }
	}
	elseif ($type == 'timebegin_year' || $type == 'timeend_year') {
		if (is_numeric($value) && $value >= 1900 && $value <= 2100) { return true; }
	}
	elseif ($type == 'timebegin_month' || $type == 'timeend_month') {
		if (is_numeric($value) && $value >= 1 && $value <= 12) { return true; }
	}
	elseif ($type == 'timebegin_day' || $type == 'timeend_day') {
		if (is_numeric($value) && $value >= 1 && $value <= 31) { return true; }
	}
	elseif ($type == 'timebegin_hour' || $type == 'timeend_hour') {
		if (is_numeric($value) && (($value >= 1 && $value <= 12 && USE_AMPM) ||
		 ($value >= 0 && $value <= 23 && !USE_AMPM))) { return true; }
	}
	elseif ($type == 'timebegin_min' || $type == 'timeend_min') {
		if (is_numeric($value) && $value >= 0 && $value <= 59) { return true; }
	}
	elseif ($type == 'timebegin_ampm' || $type == 'timeend_ampm') {
		if ($value == 'am' || $value == 'pm') { return true; }
	}
	elseif ($type == 'title') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_TITLE . '}$/', $value)) { return true; }
	}
	elseif ($type == 'viewauthrequired') {
		if ($value == '0' || $value == '1' || $value == '2') { return true; }
	}
	elseif ($type == 'url') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_URL . '}$/', $value)) { return true; }
	}
	elseif ($type == 'userid') {
		if (preg_match(REGEXVALIDUSERID, $value)) { return true; }
	}
	elseif ($type == 'users') { // needs refinement, white-space allowed
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . '\s]{1,2000}$/', $value)) { return true; }
	}
	elseif ($type == 'view') {
		return ($value == 'upcoming' || $value == 'day' || $value == 'week' || $value == 'month' ||
		 $value == 'search' || $value == 'searchresults' || $value == 'event' || $value == 'subscribe' ||
		 $value == 'filter' || $value == 'export');
	}
	elseif ($type == 'wholedayevent') {
		if ($value == '0' || $value == '1') { return true; }
	}
	elseif ($type == 'page') {
		if (is_numeric($value) && $value > 0) { return true; }
	}

	/* =========================================================
	                      Generic Types
	========================================================= */
	// Used for two radio <input> where one is yes and the other is no.
	elseif ($type == 'boolean') {
		if ($value === '1' || $value === '0') { return true; }
	}
	// Used for a checkbox <input> where it does not submit a value if not checked.
	elseif ($type == 'boolean_checkbox') {
		if ($value === '1') { return true; }
	}
	elseif ($type == 'int') {
		return (preg_match("/^-?[0-9]+$/", $value) === 1);
	}
	elseif ($type == 'int_gte1') {
		if (preg_match("/^[0-9]+$/", $value) && intval($value) >= 1) { return true; }
	}

	/* =========================================================
	                   Export Page Validation
	========================================================= */
	elseif ($type == 'type') {
		if ($value == 'xml' || $value == 'rss' || $value == 'ical' ||
		 $value == 'rss1_0' || $value == 'vxml') { return true; }
	}
	elseif ($type == 'exportformat') {
		if ($value == 'html' || $value == 'js' || $value == 'xml' || $value == 'rss' ||
		 $value == 'ical' || $value == 'rss1_0' || $value == 'rss2_0' || $value == 'vxml') { return true; }
	}
	elseif ($type == 'rangedays') {
		if (is_numeric($value) && $value >= 1 && $value <= 100000) { return true; }
	}
	elseif ($type == 'sponsortype') {
		if ($value == 'all' || $value == 'self' || $value == 'specific') { return true; }
	}
	elseif ($type == 'specificsponsor') {
		if (preg_match('/^[' . REGEX_VALIDTEXTCHAR_WITH_WHITESPACE . ']{1,' .
		 MAXLENGTH_SPECIFICSPONSOR . '}$/', $value)) { return true; }
	}
	elseif ($type == 'htmltype') {
		if ($value == 'table' || $value == 'paragraph' || $value == 'mainsite') { return true; }
	}
	elseif ($type == 'dateformat') {
		return (preg_match("/^(huge|long|normal|short|tiny|micro)$/", $value) === 1);
	}
	elseif ($type == 'timedisplay') {
		return (preg_match("/^(start|startendlong|startendnormal|startendtiny|" .
		 "startdurationlong|startdurationnormal|startdurationshort)$/", $value) === 1);
	}
	elseif ($type == 'timeformat') {
		return (preg_match("/^(huge|long|normal|short)$/", $value) === 1);
	}
	elseif ($type == 'durationformat') {
		return (preg_match("/^(long|normal|short|tiny|micro)$/", $value) === 1);
	}
	return false;
}

function isDate($value)
{ // returns TRUE if $value is of format e.g. "2004-05-26" otherwise FALSE
	if (strlen($value) != 10) { return false; }
	elseif ($value{4} != '-' || $value{7} != '-') { return false; }
	else { return checkdate(substr($value, 5, 2), substr($value, 8, 2), substr($value, 0, 4)); }
}

function isTime($value)
{ // returns TRUE if $value is of format e.g. "14:34:22" otherwise FALSE
	if (strlen($value) != 8) { return false; }
	elseif ($value{2} != ':' || $value{5} != ':') { return false; }
	else {
		$hour = substr($value, 0, 2);
		$min = substr($value, 3, 2);
		$sec = substr($value, 6, 2);
		if ($hour{0} >= '0' && $hour{0} <= '2' && $hour{1} >= '0' && $hour{1} <= '9' &&
		 intval($hour) >= 0 && intval($hour) <= 24 && $min{0} >= '0' && $min{0} <= '5' &&
		 $min{1} >= '0' && $min{1} <= '9' && $sec{0} >= '0' && $sec{0} <= '5' &&
		 $sec{1} >= '0' && $sec{1} <= '9') { return true; }
	}
	return false;
}
?>