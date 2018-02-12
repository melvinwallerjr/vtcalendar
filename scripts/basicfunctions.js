/**
 * Checks the installed version of VTCalendar against the latest release version.
 *
 * Returns "OLDER" if the installed version is older than the latest release version;
 *         "EQUAL" if the the installed version matches the latest release version;
 *         "NEWER" if the installed version is newer than the latest release version (possibly beta);
 *         or "ERROR" if something went wrong.
 */
function CheckVTCalendarVersion(InstalledVersion, LatestVersion)
{
	if (InstalledVersion && LatestVersion && typeof InstalledVersion == "string" &&
	 typeof LatestVersion == "string" && VersionIsNumeric(InstalledVersion) &&
	 VersionIsNumeric(LatestVersion)) {
		// If the strings are equal, then the versions must be equal as well.
		if (InstalledVersion == LatestVersion) { return "EQUAL"; }
		else {
			// Split the versions at the periods.
			var splitInstalledVersion = InstalledVersion.split(".");
			var i, ii, splitLatestVersion=LatestVersion.split(".");
			// Check each part of the versions
			for (i=0, ii=splitInstalledVersion.length; i < ii; i++) {
				if (splitLatestVersion.length <= i) { return "NEWER"; }
				var installedNum = parseInt(splitInstalledVersion[i]);
				var latestNum = parseInt(splitLatestVersion[i]);
				if (installedNum < latestNum) { return "OLDER"; }
				else if (installedNum > latestNum) { return "NEWER"; }
			}
			if (splitInstalledVersion.length < splitLatestVersion.length) { return "OLDER"; }
			// If all parts are numerically equal, then return EQUAL.
			// This can happen if the versions are something like 2.3.0 and 2.03.0.
			// The '3' and '03' are not equal strings but are numerically equal.
			return "EQUAL";
		}
	}
	else { return "ERROR"; }
}

function VersionIsNumeric(strtocheck)
{
	var i, ii, ValidCharacters="0123456789.";
	for (i=0, ii=strtocheck.length; i < ii; i++) {
		if (ValidCharacters.indexOf(strtocheck.charAt(i)) < 0) { return false; }
	}
	return true;
}

// Thanks to Douglas Crockford for the functions below.
// http://javascript.crockford.com/remedial.html

function isAlien(a)
{
	return (isObject(a) && typeof a.constructor != "function");
}

function isArray(a)
{
	return (isObject(a) && a.constructor == Array);
}

function isBoolean(a)
{
	return (typeof a == "boolean");
}

function isEmpty(o)
{
	var i, v;
	if (isObject(o)) {
		for (i in o) {
			v = o[i];
			if (isUndefined(v) && isFunction(v)) { return false; }
		}
	}
	return true;
}

function isFunction(a)
{
	return (typeof a == "function");
}

function isNull(a)
{
	return (a === null);
}

function isNumber(a)
{
	return (typeof a == "number" && isFinite(a));
}

function isObject(a)
{
	return ((a && typeof a == "object") || isFunction(a));
}

function isString(a)
{
	return (typeof a == "string");
}

function isUndefined(a)
{
	return (typeof a == "undefined");
}
