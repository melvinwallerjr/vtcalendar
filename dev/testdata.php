<?php
Header("Content-Type: text/plain");

$records = 15000;
$tablePrefix = '"2-2-2".';

$maxlength['vtcal_auth']['calendarid'] = 50;
$maxlength['vtcal_auth']['userid'] = 50;

// Create a list of calendar names.
$calendarNames = array("default");
for ($i = 1; $i < $records; $i++) {
	$calendarNames[count($calendarNames)] = createRandomString(50);
}

/*// vtcal_auth
echo "INSERT INTO ".$tablePrefix."vtcal_auth(calendarid, userid, sponsorid) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".createRandomString(50)."', '1')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

// vtcal_calendar
echo "INSERT INTO ".$tablePrefix."vtcal_calendar (id, name, title, header, footer, bgcolor, maincolor, todaycolor, pastcolor, futurecolor, textcolor, linkcolor, gridcolor, viewauthrequired, forwardeventdefault) VALUES \n";
for ($i = 1; $i < $records; $i++) {
	echo "\t";
	echo "('".$calendarNames[$i]."', '".createRandomString(100)."', '".createRandomString(50)."', '".createRandomString(1024)."', '".createRandomString(1024)."', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', '#FFFFFF', 0, 0)";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

//vtcal_calendarviewauth
echo "INSERT INTO ".$tablePrefix."vtcal_calendarviewauth (calendarid, userid) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".createRandomString(50)."')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

//vtcal_category
echo "INSERT INTO ".$tablePrefix."vtcal_category (calendarid, id, name) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".($i+10)."', '".createRandomString(100)."')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

//vtcal_event
echo "INSERT INTO ".$tablePrefix."vtcal_event (calendarid, id, timebegin, timeend, sponsorid, title, wholedayevent, categoryid, description, location, price, contact_name, contact_phone, contact_email, url, recordchangedtime, recordchangeduser, approved, rejectreason, displayedsponsor, displayedsponsorurl, repeatid, showondefaultcal, showincategory) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".createRandomString(18)."', '2008-10-21 10:00:00', '2008-10-21 24:00:00', '1', '".createRandomString(1024)."', '0', '1', '".createRandomString(1024)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', 'http://www.testdata.com/', '2008-01-01 00:00:00', '".createRandomString(1024)."', '1', '".createRandomString(1024)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(13)."', '0', '0')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";*/

//vtcal_event_public
echo "INSERT INTO ".$tablePrefix."vtcal_event_public (calendarid, id, timebegin, timeend, sponsorid, title, wholedayevent, categoryid, description, location, price, contact_name, contact_phone, contact_email, url, displayedsponsor, displayedsponsorurl, repeatid) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".createRandomString(18)."', '2008-10-21 10:00:00', '2008-10-21 24:00:00', '1', '".createRandomString(1024)."', '0', '1', '".createRandomString(1024)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', 'http://www.testdata.com/', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(13)."')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

/*//vtcal_event_repeat
echo "INSERT INTO ".$tablePrefix."vtcal_event_repeat (calendarid, id, repeatdef, startdate, enddate, recordchangedtime, recordchangeduser) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".createRandomString(13)."', '".createRandomString(1024)."', '2008-01-01 00:00:00', '2008-02-01 00:00:00', '2008-02-01 00:00:00', '".createRandomString(1024)."')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

//vtcal_sponsor
echo "INSERT INTO ".$tablePrefix."vtcal_sponsor (calendarid, id, name, url, email, admin) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".getRandomArrayItem($calendarNames)."', '".($i+10)."', '".createRandomString(100)."', '".createRandomString(100)."', '".createRandomString(100)."', '0')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";

//vtcal_user
echo "INSERT INTO ".$tablePrefix."vtcal_user (id, password, email) VALUES \n";
for ($i = 0; $i < $records; $i++) {
	echo "\t";
	echo "('".createRandomString(50)."', '".($i+10)."', '".createRandomString(255)."')";
	if ($i < $records - 1) echo ",\n";
	if ($i == $records - 1) echo ";";
}
echo "\n\n";*/

function getRandomArrayItem($array) {
	return $array[rand(0, count($array)-1)];
}

function createRandomString($maxlen=100) {
    $chars = 'abcdefghijkmnopqrstuvwxyz023456789'; //_-=!@#$%^&*(){}|?<>~:;
    $charsLen = strlen($chars);
	$len = rand(1, $maxlen);
	$str = "";
	
	for ($i = 1; $i <= $len; $i++) {
		$str .= substr($chars, rand(0, $charsLen-1), 1);
	}
	
	return $str;
}
?>