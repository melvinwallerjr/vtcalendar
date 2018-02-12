<?php
if (!defined('ALLOWINCLUDES')) { exit; }

$chk = ' checked="checked"';
$sel = ' selected="selected"';
$tzn = isset($GLOBALS['Form_TIMEZONE'])? $GLOBALS['Form_TIMEZONE'] : '';
?>

<h2>General:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_TITLEPREFIX">Title Prefix:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_TITLEPREFIX" name="TITLEPREFIX" value="<?php echo htmlspecialchars($GLOBALS['Form_TITLEPREFIX'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_TITLEPREFIX">&nbsp;</span></div>
<p class="CommentLine">OPTIONAL. Added at the beginning of the <code>&lt;title&gt;</code> tag.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_TITLESUFFIX">Title Suffix:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_TITLESUFFIX" name="TITLESUFFIX" value="<?php echo htmlspecialchars($GLOBALS['Form_TITLESUFFIX'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_TITLESUFFIX">&nbsp;</span></div>
<p class="Example"><i>Example: " - My Business"</i></p>
<p class="CommentLine">OPTIONAL. Added at the end of the <code>&lt;title&gt;</code> tag.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_LANGUAGE">Language:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><select id="Input_LANGUAGE" name="LANGUAGE" size="1">
<?php
if ($dh = opendir('../languages')) { // PHP4 compatable directory read
	while (($file = readdir($dh)) !== false) {
		if (preg_match("|^(.*)\.inc\.php$|", $file, $matches)) { $languages[] = $matches[1]; }
	}
	closedir($dh);
}
if (isset($languages) && count($languages) > 0) {
	foreach ($languages as $language) {
	    echo '<option value="' . $language . '"' .
		 (($language == $GLOBALS['Form_LANGUAGE'])? ' selected="selected"' : '') .
		 '>' . mb_strtoupper($language, 'UTF-8') . '</option>', "\n";
	}
}
else { echo '<option value="en">EN</option>' . "\n"; }
?>
</select>
<span id="DataFieldInputExtra_LANGUAGE">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>EN</code> (English), <code>DE</code> (German), <code>SV</code> (Swedish)</p>
<p class="CommentLine">Language used (refers to language file in directory <code>/languages</code>)</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_ALLOWED_YEARS_AHEAD">Max Year Ahead for New Events:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_ALLOWED_YEARS_AHEAD" name="ALLOWED_YEARS_AHEAD" value="<?php echo htmlspecialchars($GLOBALS['Form_ALLOWED_YEARS_AHEAD'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_ALLOWED_YEARS_AHEAD">&nbsp;</span></div>
<p class="CommentLine">The number of years into the future that the calendar will allow users to create events for.</p>
<p class="CommentLine">For example, if the current year is 2000 then a value of '3' will allow users to create events up to 2003.</p>
</td>

</tr></tbody>
</table>
</div><!-- .pad -->

<h2>Database:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_DATABASE">Database Connection String:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_DATABASE" name="DATABASE" value="<?php echo htmlspecialchars($GLOBALS['Form_DATABASE'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_DATABASE">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>mysql://vtcal:abc123@localhost/vtcalendar</code></p>
<p class="CommentLine">This is the database connection string used by the PEAR library.</p>
<p class="CommentLine">It has the format: <code>mysql://user:password@host/databasename</code> or <code>pgsql://user:password@host/databasename</code></p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_SCHEMANAME">Schema Name:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_SCHEMANAME" name="SCHEMANAME" value="<?php echo htmlspecialchars($GLOBALS['Form_SCHEMANAME'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_SCHEMANAME">&nbsp;</span></div>
<p class="Example"><i>Example: public</i></p>
<p class="CommentLine">In some databases (such as PostgreSQL) you may have multiple sets of VTCalendar tables within the same database, but in different schemas.</p>
<p class="CommentLine">If this is the case for you, enter the name of the schema here.</p>
<p class="CommentLine">It will be prefixed to the table name like so: <code>SCHEMANAME.vtcal_calendars.</code></p>
<p class="CommentLine">If necessary quote the schema name using a backtick (`) for MySQL or double quotes (") for PostgreSQL.</p>
<p class="CommentLine">Note: If specified, the table prefix MUST end with a period.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_SQLLOGFILE">SQL Log File:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_SQLLOGFILE" name="SQLLOGFILE" value="<?php echo htmlspecialchars($GLOBALS['Form_SQLLOGFILE'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_SQLLOGFILE">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>/var/log/vtcalendarsql.log</code></p>
<p class="CommentLine">OPTIONAL. Put a name of a (folder and) file where the calendar logs every SQL query to the database.</p>
<p class="CommentLine">This is good for debugging but make sure you write into a file that's not readable by the webserver or else you may expose private information.</p>
<p class="CommentLine">If left blank ("") no log will be kept. That's the default.</p>
</td>

</tr></tbody>
</table>
</div><!-- .pad -->

<h2>Authentication:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_REGEXVALIDUSERID">User ID Regular Expression:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_REGEXVALIDUSERID" name="REGEXVALIDUSERID" value="<?php echo htmlspecialchars($GLOBALS['Form_REGEXVALIDUSERID'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_REGEXVALIDUSERID">&nbsp;</span></div>
<p class="CommentLine">This regular expression defines what is considered a valid user-ID.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_AUTH_DB">Database Authentication:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_AUTH_DB"><input type="checkbox" id="CheckBox_AUTH_DB" name="AUTH_DB" value="true" onclick="ToggleDependant('AUTH_DB');" onchange="ToggleDependant('AUTH_DB');"<?php echo ($GLOBALS['Form_AUTH_DB'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_AUTH_DB">&nbsp;</span></div>
<p class="CommentLine">Authenticate users against the database.</p>
<p class="CommentLine">If enabled, this is always performed before any other authentication.</p>

<div id="Dependants_AUTH_DB"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_AUTH_DB_USER_PREFIX">Prefix for Database Usernames:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_AUTH_DB_USER_PREFIX" name="AUTH_DB_USER_PREFIX" value="<?php echo htmlspecialchars($GLOBALS['Form_AUTH_DB_USER_PREFIX'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_AUTH_DB_USER_PREFIX">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>db_</code></p>
<p class="CommentLine">OPTIONAL. This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."</p>
<p class="CommentLine">If you only use auth_db just leave it an empty string.</p>
<p class="CommentLine">Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_AUTH_DB_NOTICE">Database Authentication Notice:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_AUTH_DB_NOTICE" name="AUTH_DB_NOTICE" value="<?php echo htmlspecialchars($GLOBALS['Form_AUTH_DB_NOTICE'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_AUTH_DB_NOTICE">&nbsp;</span></div>
<p class="CommentLine">OPTIONAL. This displays a text (or nothing) on the Update tab behind the user user management options.</p>
<p class="CommentLine">It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users know that they should create local users only if they are not in the LDAP.</p>
</td>
</tr></tbody>
</table></div>

<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("AUTH_DB");
/* ]]> */</script>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_AUTH_LDAP">LDAP Authentication:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_AUTH_LDAP"><input type="checkbox" id="CheckBox_AUTH_LDAP" name="AUTH_LDAP" value="true" onclick="ToggleDependant('AUTH_LDAP');" onchange="ToggleDependant('AUTH_LDAP');"<?php echo ($GLOBALS['Form_AUTH_LDAP'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_AUTH_LDAP">&nbsp;</span></div>
<p class="CommentLine">Authenticate users against a LDAP server.</p>
<p class="CommentLine">If enabled, HTTP authenticate will be ignored.</p>

<div id="Dependants_AUTH_LDAP"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="CheckBox_LDAP_CHECK">Verify LDAP Settings:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_LDAP_CHECK"><input type="checkbox" id="CheckBox_LDAP_CHECK" name="LDAP_CHECK" value="true"<?php echo ($GLOBALS['Form_LDAP_CHECK'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_LDAP_CHECK">&nbsp;</span></div>
<p class="CommentLine">Check this box if you would like to verify the LDAP settings when submitting this form.</p>
<p class="CommentLine">Uncheck this box if you know the settings are correct, but your LDAP server is currently unavailable.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_HOST">LDAP Host Name:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_HOST" name="LDAP_HOST" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_HOST'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_HOST">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>directory.example.com</code> or <code>ldap://directory.example.com/</code> or <code>ldaps://secure-directory.example.com/</code></p>
<p class="CommentLine">If you are using OpenLDAP 2.x.x you can specify a URL (<code>ldap://host/</code>) instead of the hostname (<code>host</code>).</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_PORT">LDAP Port:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_PORT" name="LDAP_PORT" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_PORT'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_PORT">&nbsp;</span></div>
<p class="CommentLine">The port to connect to. Ignored if LDAP Host Name is a URL.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_USERFIELD">LDAP Username Attribute:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_USERFIELD" name="LDAP_USERFIELD" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_USERFIELD'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_USERFIELD">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>sAMAccountName</code></p>
<p class="CommentLine">The attribute which contains the username.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_BASE_DN">LDAP Base DN:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_BASE_DN" name="LDAP_BASE_DN" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_BASE_DN'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_BASE_DN">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>DC=example,DC=com</code></p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_SEARCH_FILTER">Additional LDAP Search Filter:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_SEARCH_FILTER" name="LDAP_SEARCH_FILTER" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_SEARCH_FILTER'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_SEARCH_FILTER">&nbsp;</span></div>
<p class="Example"><i>Example: (objectClass=person)</i></p>
<p class="CommentLine">OPTIONAL. A filter to add to the LDAP search.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="CheckBox_LDAP_BIND">Authenticate When Connecting to LDAP:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_LDAP_BIND"><input type="checkbox" id="CheckBox_LDAP_BIND" name="LDAP_BIND" value="true" onclick="ToggleDependant('LDAP_BIND');" onchange="ToggleDependant('LDAP_BIND');"<?php echo ($GLOBALS['Form_LDAP_BIND'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_LDAP_BIND">&nbsp;</span></div>
<p class="CommentLine">Before authenticating the user, we first check if the username exists.</p>
<p class="CommentLine">If your LDAP server does not allow anonymous searches, you will need to specify a username and password to bind as.</p>

<div id="Dependants_LDAP_BIND"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_BIND_USER">LDAP Username:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_BIND_USER" name="LDAP_BIND_USER" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_BIND_USER'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_BIND_USER">&nbsp;</span></div>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_LDAP_BIND_PASSWORD">LDAP Password:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_LDAP_BIND_PASSWORD" name="LDAP_BIND_PASSWORD" value="<?php echo htmlspecialchars($GLOBALS['Form_LDAP_BIND_PASSWORD'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_LDAP_BIND_PASSWORD">&nbsp;</span></div>
</td>
</tr></tbody>
</table></div>

<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("LDAP_BIND");
/* ]]> */</script>
</td>
</tr></tbody>
</table></div>

<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("AUTH_LDAP");
/* ]]> */</script>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_AUTH_HTTP">HTTP Authentication:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_AUTH_HTTP"><input type="checkbox" id="CheckBox_AUTH_HTTP" name="AUTH_HTTP" value="true" onclick="ToggleDependant('AUTH_HTTP');" onchange="ToggleDependant('AUTH_HTTP');"<?php echo ($GLOBALS['Form_AUTH_HTTP'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_AUTH_HTTP">&nbsp;</span></div>
<p class="CommentLine">Authenticate users by sending an HTTP request to a server.</p>
<p class="CommentLine">A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.</p>
<p class="CommentLine">If LDAP authentication is enabled, this will be ignored.</p>
<div id="Dependants_AUTH_HTTP"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_AUTH_HTTP_URL">HTTP Authorizaton URL:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_AUTH_HTTP_URL" name="AUTH_HTTP_URL" value="<?php echo htmlspecialchars($GLOBALS['Form_AUTH_HTTP_URL'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_AUTH_HTTP_URL">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>http://localhost/customauth.php</code></p>
<p class="CommentLine">The URL to use for the BASIC HTTP Authentication.</p>
</td>
</tr></tbody>
</table></div>
<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("AUTH_HTTP");
/* ]]> */</script>
</td>
</tr></tbody>
</table></div>

<h2>Cookies:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_BASEPATH">Cookie Path:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_BASEPATH" name="BASEPATH" value="<?php echo htmlspecialchars($GLOBALS['Form_BASEPATH'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_BASEPATH">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>/calendar/</code></p>
<p class="CommentLine">OPTIONAL. If you are hosting more than one VTCalendar on your server, you may want to set this to this calendar's path.</p>
<p class="CommentLine">Otherwise, the cookie will be submitted with a default path.</p>
<p class="CommentLine">This must start and end with a forward slash (/), unless the it is exactly "/".</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_BASEDOMAIN">Cookie Host Name:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_BASEDOMAIN" name="BASEDOMAIN" value="<?php echo htmlspecialchars($GLOBALS['Form_BASEDOMAIN'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_BASEDOMAIN">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>localhost</code></p>
<p class="CommentLine">OPTIONAL. If you are hosting more than one VTCalendar on your server, you may want to set this to your server's host name.</p>
<p class="CommentLine">Otherwise, the cookie will be submitted with a default host name.</p>
</td>
</tr></tbody>
</table></div>

<h2>URL:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_BASEURL">Calendar Base URL:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_BASEURL" name="BASEURL" value="<?php echo htmlspecialchars($GLOBALS['Form_BASEURL'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_BASEURL">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>http://localhost/calendar/</code></p>
<p class="CommentLine">This is the absolute URL where your calendar software is located.</p>
<p class="CommentLine">This MUST end with a slash "/"</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_SECUREBASEURL">Secure Calendar Base URL:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_SECUREBASEURL" name="SECUREBASEURL" value="<?php echo htmlspecialchars($GLOBALS['Form_SECUREBASEURL'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_SECUREBASEURL">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>https://localhost/calendar/</code></p>
<p class="CommentLine">This is the absolute path where the secure version of the calendar is located.</p>
<p class="CommentLine">If you are not using URL, set this to the same address as BASEURL.</p>
<p class="CommentLine">This MUST end with a slash "/"</p>
</td>
</tr></tbody>
</table></div>

<h2>Date/Time:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_TIMEZONE">Timezone:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><select id="Input_TIMEZONE" name="TIMEZONE">
<option value=""<?php echo ($tzn == '')? $sel : ''; ?>>(Use the server's local time)</option>
<option value="Africa/Abidjan"<?php echo ($tzn == 'Africa/Abidjan')? $sel : ''; ?>>Africa/Abidjan</option>
<option value="Africa/Accra"<?php echo ($tzn == 'Africa/Accra')? $sel : ''; ?>>Africa/Accra</option>
<option value="Africa/Addis_Ababa"<?php echo ($tzn == 'Africa/Addis_Ababa')? $sel : ''; ?>>Africa/Addis_Ababa</option>
<option value="Africa/Algiers"<?php echo ($tzn == 'Africa/Algiers')? $sel : ''; ?>>Africa/Algiers</option>
<option value="Africa/Asmara"<?php echo ($tzn == 'Africa/Asmara')? $sel : ''; ?>>Africa/Asmara</option>
<option value="Africa/Asmera"<?php echo ($tzn == 'Africa/Asmera')? $sel : ''; ?>>Africa/Asmera</option>
<option value="Africa/Bamako"<?php echo ($tzn == 'Africa/Bamako')? $sel : ''; ?>>Africa/Bamako</option>
<option value="Africa/Bangui"<?php echo ($tzn == 'Africa/Bangui')? $sel : ''; ?>>Africa/Bangui</option>
<option value="Africa/Banjul"<?php echo ($tzn == 'Africa/Banjul')? $sel : ''; ?>>Africa/Banjul</option>
<option value="Africa/Bissau"<?php echo ($tzn == 'Africa/Bissau')? $sel : ''; ?>>Africa/Bissau</option>
<option value="Africa/Blantyre"<?php echo ($tzn == 'Africa/Blantyre')? $sel : ''; ?>>Africa/Blantyre</option>
<option value="Africa/Brazzaville"<?php echo ($tzn == 'Africa/Brazzaville')? $sel : ''; ?>>Africa/Brazzaville</option>
<option value="Africa/Bujumbura"<?php echo ($tzn == 'Africa/Bujumbura')? $sel : ''; ?>>Africa/Bujumbura</option>
<option value="Africa/Cairo"<?php echo ($tzn == 'Africa/Cairo')? $sel : ''; ?>>Africa/Cairo</option>
<option value="Africa/Casablanca"<?php echo ($tzn == 'Africa/Casablanca')? $sel : ''; ?>>Africa/Casablanca</option>
<option value="Africa/Ceuta"<?php echo ($tzn == 'Africa/Ceuta')? $sel : ''; ?>>Africa/Ceuta</option>
<option value="Africa/Conakry"<?php echo ($tzn == 'Africa/Conakry')? $sel : ''; ?>>Africa/Conakry</option>
<option value="Africa/Dakar"<?php echo ($tzn == 'Africa/Dakar')? $sel : ''; ?>>Africa/Dakar</option>
<option value="Africa/Dar_es_Salaam"<?php echo ($tzn == 'Africa/Dar_es_Salaam')? $sel : ''; ?>>Africa/Dar_es_Salaam</option>
<option value="Africa/Djibouti"<?php echo ($tzn == 'Africa/Djibouti')? $sel : ''; ?>>Africa/Djibouti</option>
<option value="Africa/Douala"<?php echo ($tzn == 'Africa/Douala')? $sel : ''; ?>>Africa/Douala</option>
<option value="Africa/El_Aaiun"<?php echo ($tzn == 'Africa/El_Aaiun')? $sel : ''; ?>>Africa/El_Aaiun</option>
<option value="Africa/Freetown"<?php echo ($tzn == 'Africa/Freetown')? $sel : ''; ?>>Africa/Freetown</option>
<option value="Africa/Gaborone"<?php echo ($tzn == 'Africa/Gaborone')? $sel : ''; ?>>Africa/Gaborone</option>
<option value="Africa/Harare"<?php echo ($tzn == 'Africa/Harare')? $sel : ''; ?>>Africa/Harare</option>
<option value="Africa/Johannesburg"<?php echo ($tzn == 'Africa/Johannesburg')? $sel : ''; ?>>Africa/Johannesburg</option>
<option value="Africa/Kampala"<?php echo ($tzn == 'Africa/Kampala')? $sel : ''; ?>>Africa/Kampala</option>
<option value="Africa/Khartoum"<?php echo ($tzn == 'Africa/Khartoum')? $sel : ''; ?>>Africa/Khartoum</option>
<option value="Africa/Kigali"<?php echo ($tzn == 'Africa/Kigali')? $sel : ''; ?>>Africa/Kigali</option>
<option value="Africa/Kinshasa"<?php echo ($tzn == 'Africa/Kinshasa')? $sel : ''; ?>>Africa/Kinshasa</option>
<option value="Africa/Lagos"<?php echo ($tzn == 'Africa/Lagos')? $sel : ''; ?>>Africa/Lagos</option>
<option value="Africa/Libreville"<?php echo ($tzn == 'Africa/Libreville')? $sel : ''; ?>>Africa/Libreville</option>
<option value="Africa/Lome"<?php echo ($tzn == 'Africa/Lome')? $sel : ''; ?>>Africa/Lome</option>
<option value="Africa/Luanda"<?php echo ($tzn == 'Africa/Luanda')? $sel : ''; ?>>Africa/Luanda</option>
<option value="Africa/Lubumbashi"<?php echo ($tzn == 'Africa/Lubumbashi')? $sel : ''; ?>>Africa/Lubumbashi</option>
<option value="Africa/Lusaka"<?php echo ($tzn == 'Africa/Lusaka')? $sel : ''; ?>>Africa/Lusaka</option>
<option value="Africa/Malabo"<?php echo ($tzn == 'Africa/Malabo')? $sel : ''; ?>>Africa/Malabo</option>
<option value="Africa/Maputo"<?php echo ($tzn == 'Africa/Maputo')? $sel : ''; ?>>Africa/Maputo</option>
<option value="Africa/Maseru"<?php echo ($tzn == 'Africa/Maseru')? $sel : ''; ?>>Africa/Maseru</option>
<option value="Africa/Mbabane"<?php echo ($tzn == 'Africa/Mbabane')? $sel : ''; ?>>Africa/Mbabane</option>
<option value="Africa/Mogadishu"<?php echo ($tzn == 'Africa/Mogadishu')? $sel : ''; ?>>Africa/Mogadishu</option>
<option value="Africa/Monrovia"<?php echo ($tzn == 'Africa/Monrovia')? $sel : ''; ?>>Africa/Monrovia</option>
<option value="Africa/Nairobi"<?php echo ($tzn == 'Africa/Nairobi')? $sel : ''; ?>>Africa/Nairobi</option>
<option value="Africa/Ndjamena"<?php echo ($tzn == 'Africa/Ndjamena')? $sel : ''; ?>>Africa/Ndjamena</option>
<option value="Africa/Niamey"<?php echo ($tzn == 'Africa/Niamey')? $sel : ''; ?>>Africa/Niamey</option>
<option value="Africa/Nouakchott"<?php echo ($tzn == 'Africa/Nouakchott')? $sel : ''; ?>>Africa/Nouakchott</option>
<option value="Africa/Ouagadougou"<?php echo ($tzn == 'Africa/Ouagadougou')? $sel : ''; ?>>Africa/Ouagadougou</option>
<option value="Africa/Porto-Novo"<?php echo ($tzn == 'Africa/Porto-Novo')? $sel : ''; ?>>Africa/Porto-Novo</option>
<option value="Africa/Sao_Tome"<?php echo ($tzn == 'Africa/Sao_Tome')? $sel : ''; ?>>Africa/Sao_Tome</option>
<option value="Africa/Timbuktu"<?php echo ($tzn == 'Africa/Timbuktu')? $sel : ''; ?>>Africa/Timbuktu</option>
<option value="Africa/Tripoli"<?php echo ($tzn == 'Africa/Tripoli')? $sel : ''; ?>>Africa/Tripoli</option>
<option value="Africa/Tunis"<?php echo ($tzn == 'Africa/Tunis')? $sel : ''; ?>>Africa/Tunis</option>
<option value="Africa/Windhoek"<?php echo ($tzn == 'Africa/Windhoek')? $sel : ''; ?>>Africa/Windhoek</option>
<option value="America/Adak"<?php echo ($tzn == 'America/Adak')? $sel : ''; ?>>America/Adak</option>
<option value="America/Anchorage"<?php echo ($tzn == 'America/Anchorage')? $sel : ''; ?>>America/Anchorage</option>
<option value="America/Anguilla"<?php echo ($tzn == 'America/Anguilla')? $sel : ''; ?>>America/Anguilla</option>
<option value="America/Antigua"<?php echo ($tzn == 'America/Antigua')? $sel : ''; ?>>America/Antigua</option>
<option value="America/Araguaina"<?php echo ($tzn == 'America/Araguaina')? $sel : ''; ?>>America/Araguaina</option>
<option value="America/Argentina/Buenos_Aires"<?php echo ($tzn == 'America/Argentina/Buenos_Aires')? $sel : ''; ?>>America/Argentina/Buenos_Aires</option>
<option value="America/Argentina/Catamarca"<?php echo ($tzn == 'America/Argentina/Catamarca')? $sel : ''; ?>>America/Argentina/Catamarca</option>
<option value="America/Argentina/ComodRivadavia"<?php echo ($tzn == 'America/Argentina/ComodRivadavia')? $sel : ''; ?>>America/Argentina/ComodRivadavia</option>
<option value="America/Argentina/Cordoba"<?php echo ($tzn == 'America/Argentina/Cordoba')? $sel : ''; ?>>America/Argentina/Cordoba</option>
<option value="America/Argentina/Jujuy"<?php echo ($tzn == 'America/Argentina/Jujuy')? $sel : ''; ?>>America/Argentina/Jujuy</option>
<option value="America/Argentina/La_Rioja"<?php echo ($tzn == 'America/Argentina/La_Rioja')? $sel : ''; ?>>America/Argentina/La_Rioja</option>
<option value="America/Argentina/Mendoza"<?php echo ($tzn == 'America/Argentina/Mendoza')? $sel : ''; ?>>America/Argentina/Mendoza</option>
<option value="America/Argentina/Rio_Gallegos"<?php echo ($tzn == 'America/Argentina/Rio_Gallegos')? $sel : ''; ?>>America/Argentina/Rio_Gallegos</option>
<option value="America/Argentina/San_Juan"<?php echo ($tzn == 'America/Argentina/San_Juan')? $sel : ''; ?>>America/Argentina/San_Juan</option>
<option value="America/Argentina/San_Luis"<?php echo ($tzn == 'America/Argentina/San_Luis')? $sel : ''; ?>>America/Argentina/San_Luis</option>
<option value="America/Argentina/Tucuman"<?php echo ($tzn == 'America/Argentina/Tucuman')? $sel : ''; ?>>America/Argentina/Tucuman</option>
<option value="America/Argentina/Ushuaia"<?php echo ($tzn == 'America/Argentina/Ushuaia')? $sel : ''; ?>>America/Argentina/Ushuaia</option>
<option value="America/Aruba"<?php echo ($tzn == 'America/Aruba')? $sel : ''; ?>>America/Aruba</option>
<option value="America/Asuncion"<?php echo ($tzn == 'America/Asuncion')? $sel : ''; ?>>America/Asuncion</option>
<option value="America/Atikokan"<?php echo ($tzn == 'America/Atikokan')? $sel : ''; ?>>America/Atikokan</option>
<option value="America/Atka"<?php echo ($tzn == 'America/Atka')? $sel : ''; ?>>America/Atka</option>
<option value="America/Bahia"<?php echo ($tzn == 'America/Bahia')? $sel : ''; ?>>America/Bahia</option>
<option value="America/Barbados"<?php echo ($tzn == 'America/Barbados')? $sel : ''; ?>>America/Barbados</option>
<option value="America/Belem"<?php echo ($tzn == 'America/Belem')? $sel : ''; ?>>America/Belem</option>
<option value="America/Belize"<?php echo ($tzn == 'America/Belize')? $sel : ''; ?>>America/Belize</option>
<option value="America/Blanc-Sablon"<?php echo ($tzn == 'America/Blanc-Sablon')? $sel : ''; ?>>America/Blanc-Sablon</option>
<option value="America/Boa_Vista"<?php echo ($tzn == 'America/Boa_Vista')? $sel : ''; ?>>America/Boa_Vista</option>
<option value="America/Bogota"<?php echo ($tzn == 'America/Bogota')? $sel : ''; ?>>America/Bogota</option>
<option value="America/Boise"<?php echo ($tzn == 'America/Boise')? $sel : ''; ?>>America/Boise</option>
<option value="America/Buenos_Aires"<?php echo ($tzn == 'America/Buenos_Aires')? $sel : ''; ?>>America/Buenos_Aires</option>
<option value="America/Cambridge_Bay"<?php echo ($tzn == 'America/Cambridge_Bay')? $sel : ''; ?>>America/Cambridge_Bay</option>
<option value="America/Campo_Grande"<?php echo ($tzn == 'America/Campo_Grande')? $sel : ''; ?>>America/Campo_Grande</option>
<option value="America/Cancun"<?php echo ($tzn == 'America/Cancun')? $sel : ''; ?>>America/Cancun</option>
<option value="America/Caracas"<?php echo ($tzn == 'America/Caracas')? $sel : ''; ?>>America/Caracas</option>
<option value="America/Catamarca"<?php echo ($tzn == 'America/Catamarca')? $sel : ''; ?>>America/Catamarca</option>
<option value="America/Cayenne"<?php echo ($tzn == 'America/Cayenne')? $sel : ''; ?>>America/Cayenne</option>
<option value="America/Cayman"<?php echo ($tzn == 'America/Cayman')? $sel : ''; ?>>America/Cayman</option>
<option value="America/Chicago"<?php echo ($tzn == 'America/Chicago')? $sel : ''; ?>>America/Chicago</option>
<option value="America/Chihuahua"<?php echo ($tzn == 'America/Chihuahua')? $sel : ''; ?>>America/Chihuahua</option>
<option value="America/Coral_Harbour"<?php echo ($tzn == 'America/Coral_Harbour')? $sel : ''; ?>>America/Coral_Harbour</option>
<option value="America/Cordoba"<?php echo ($tzn == 'America/Cordoba')? $sel : ''; ?>>America/Cordoba</option>
<option value="America/Costa_Rica"<?php echo ($tzn == 'America/Costa_Rica')? $sel : ''; ?>>America/Costa_Rica</option>
<option value="America/Cuiaba"<?php echo ($tzn == 'America/Cuiaba')? $sel : ''; ?>>America/Cuiaba</option>
<option value="America/Curacao"<?php echo ($tzn == 'America/Curacao')? $sel : ''; ?>>America/Curacao</option>
<option value="America/Danmarkshavn"<?php echo ($tzn == 'America/Danmarkshavn')? $sel : ''; ?>>America/Danmarkshavn</option>
<option value="America/Dawson"<?php echo ($tzn == 'America/Dawson')? $sel : ''; ?>>America/Dawson</option>
<option value="America/Dawson_Creek"<?php echo ($tzn == 'America/Dawson_Creek')? $sel : ''; ?>>America/Dawson_Creek</option>
<option value="America/Denver"<?php echo ($tzn == 'America/Denver')? $sel : ''; ?>>America/Denver</option>
<option value="America/Detroit"<?php echo ($tzn == 'America/Detroit')? $sel : ''; ?>>America/Detroit</option>
<option value="America/Dominica"<?php echo ($tzn == 'America/Dominica')? $sel : ''; ?>>America/Dominica</option>
<option value="America/Edmonton"<?php echo ($tzn == 'America/Edmonton')? $sel : ''; ?>>America/Edmonton</option>
<option value="America/Eirunepe"<?php echo ($tzn == 'America/Eirunepe')? $sel : ''; ?>>America/Eirunepe</option>
<option value="America/El_Salvador"<?php echo ($tzn == 'America/El_Salvador')? $sel : ''; ?>>America/El_Salvador</option>
<option value="America/Ensenada"<?php echo ($tzn == 'America/Ensenada')? $sel : ''; ?>>America/Ensenada</option>
<option value="America/Fort_Wayne"<?php echo ($tzn == 'America/Fort_Wayne')? $sel : ''; ?>>America/Fort_Wayne</option>
<option value="America/Fortaleza"<?php echo ($tzn == 'America/Fortaleza')? $sel : ''; ?>>America/Fortaleza</option>
<option value="America/Glace_Bay"<?php echo ($tzn == 'America/Glace_Bay')? $sel : ''; ?>>America/Glace_Bay</option>
<option value="America/Godthab"<?php echo ($tzn == 'America/Godthab')? $sel : ''; ?>>America/Godthab</option>
<option value="America/Goose_Bay"<?php echo ($tzn == 'America/Goose_Bay')? $sel : ''; ?>>America/Goose_Bay</option>
<option value="America/Grand_Turk"<?php echo ($tzn == 'America/Grand_Turk')? $sel : ''; ?>>America/Grand_Turk</option>
<option value="America/Grenada"<?php echo ($tzn == 'America/Grenada')? $sel : ''; ?>>America/Grenada</option>
<option value="America/Guadeloupe"<?php echo ($tzn == 'America/Guadeloupe')? $sel : ''; ?>>America/Guadeloupe</option>
<option value="America/Guatemala"<?php echo ($tzn == 'America/Guatemala')? $sel : ''; ?>>America/Guatemala</option>
<option value="America/Guayaquil"<?php echo ($tzn == 'America/Guayaquil')? $sel : ''; ?>>America/Guayaquil</option>
<option value="America/Guyana"<?php echo ($tzn == 'America/Guyana')? $sel : ''; ?>>America/Guyana</option>
<option value="America/Halifax"<?php echo ($tzn == 'America/Halifax')? $sel : ''; ?>>America/Halifax</option>
<option value="America/Havana"<?php echo ($tzn == 'America/Havana')? $sel : ''; ?>>America/Havana</option>
<option value="America/Hermosillo"<?php echo ($tzn == 'America/Hermosillo')? $sel : ''; ?>>America/Hermosillo</option>
<option value="America/Indiana/Indianapolis"<?php echo ($tzn == 'America/Indiana/Indianapolis')? $sel : ''; ?>>America/Indiana/Indianapolis</option>
<option value="America/Indiana/Knox"<?php echo ($tzn == 'America/Indiana/Knox')? $sel : ''; ?>>America/Indiana/Knox</option>
<option value="America/Indiana/Marengo"<?php echo ($tzn == 'America/Indiana/Marengo')? $sel : ''; ?>>America/Indiana/Marengo</option>
<option value="America/Indiana/Petersburg"<?php echo ($tzn == 'America/Indiana/Petersburg')? $sel : ''; ?>>America/Indiana/Petersburg</option>
<option value="America/Indiana/Tell_City"<?php echo ($tzn == 'America/Indiana/Tell_City')? $sel : ''; ?>>America/Indiana/Tell_City</option>
<option value="America/Indiana/Vevay"<?php echo ($tzn == 'America/Indiana/Vevay')? $sel : ''; ?>>America/Indiana/Vevay</option>
<option value="America/Indiana/Vincennes"<?php echo ($tzn == 'America/Indiana/Vincennes')? $sel : ''; ?>>America/Indiana/Vincennes</option>
<option value="America/Indiana/Winamac"<?php echo ($tzn == 'America/Indiana/Winamac')? $sel : ''; ?>>America/Indiana/Winamac</option>
<option value="America/Indianapolis"<?php echo ($tzn == 'America/Indianapolis')? $sel : ''; ?>>America/Indianapolis</option>
<option value="America/Inuvik"<?php echo ($tzn == 'America/Inuvik')? $sel : ''; ?>>America/Inuvik</option>
<option value="America/Iqaluit"<?php echo ($tzn == 'America/Iqaluit')? $sel : ''; ?>>America/Iqaluit</option>
<option value="America/Jamaica"<?php echo ($tzn == 'America/Jamaica')? $sel : ''; ?>>America/Jamaica</option>
<option value="America/Jujuy"<?php echo ($tzn == 'America/Jujuy')? $sel : ''; ?>>America/Jujuy</option>
<option value="America/Juneau"<?php echo ($tzn == 'America/Juneau')? $sel : ''; ?>>America/Juneau</option>
<option value="America/Kentucky/Louisville"<?php echo ($tzn == 'America/Kentucky/Louisville')? $sel : ''; ?>>America/Kentucky/Louisville</option>
<option value="America/Kentucky/Monticello"<?php echo ($tzn == 'America/Kentucky/Monticello')? $sel : ''; ?>>America/Kentucky/Monticello</option>
<option value="America/Knox_IN"<?php echo ($tzn == 'America/Knox_IN')? $sel : ''; ?>>America/Knox_IN</option>
<option value="America/La_Paz"<?php echo ($tzn == 'America/La_Paz')? $sel : ''; ?>>America/La_Paz</option>
<option value="America/Lima"<?php echo ($tzn == 'America/Lima')? $sel : ''; ?>>America/Lima</option>
<option value="America/Los_Angeles"<?php echo ($tzn == 'America/Los_Angeles')? $sel : ''; ?>>America/Los_Angeles</option>
<option value="America/Louisville"<?php echo ($tzn == 'America/Louisville')? $sel : ''; ?>>America/Louisville</option>
<option value="America/Maceio"<?php echo ($tzn == 'America/Maceio')? $sel : ''; ?>>America/Maceio</option>
<option value="America/Managua"<?php echo ($tzn == 'America/Managua')? $sel : ''; ?>>America/Managua</option>
<option value="America/Manaus"<?php echo ($tzn == 'America/Manaus')? $sel : ''; ?>>America/Manaus</option>
<option value="America/Marigot"<?php echo ($tzn == 'America/Marigot')? $sel : ''; ?>>America/Marigot</option>
<option value="America/Martinique"<?php echo ($tzn == 'America/Martinique')? $sel : ''; ?>>America/Martinique</option>
<option value="America/Mazatlan"<?php echo ($tzn == 'America/Mazatlan')? $sel : ''; ?>>America/Mazatlan</option>
<option value="America/Mendoza"<?php echo ($tzn == 'America/Mendoza')? $sel : ''; ?>>America/Mendoza</option>
<option value="America/Menominee"<?php echo ($tzn == 'America/Menominee')? $sel : ''; ?>>America/Menominee</option>
<option value="America/Merida"<?php echo ($tzn == 'America/Merida')? $sel : ''; ?>>America/Merida</option>
<option value="America/Mexico_City"<?php echo ($tzn == 'America/Mexico_City')? $sel : ''; ?>>America/Mexico_City</option>
<option value="America/Miquelon"<?php echo ($tzn == 'America/Miquelon')? $sel : ''; ?>>America/Miquelon</option>
<option value="America/Moncton"<?php echo ($tzn == 'America/Moncton')? $sel : ''; ?>>America/Moncton</option>
<option value="America/Monterrey"<?php echo ($tzn == 'America/Monterrey')? $sel : ''; ?>>America/Monterrey</option>
<option value="America/Montevideo"<?php echo ($tzn == 'America/Montevideo')? $sel : ''; ?>>America/Montevideo</option>
<option value="America/Montreal"<?php echo ($tzn == 'America/Montreal')? $sel : ''; ?>>America/Montreal</option>
<option value="America/Montserrat"<?php echo ($tzn == 'America/Montserrat')? $sel : ''; ?>>America/Montserrat</option>
<option value="America/Nassau"<?php echo ($tzn == 'America/Nassau')? $sel : ''; ?>>America/Nassau</option>
<option value="America/New_York"<?php echo ($tzn == 'America/New_York')? $sel : ''; ?>>America/New_York</option>
<option value="America/Nipigon"<?php echo ($tzn == 'America/Nipigon')? $sel : ''; ?>>America/Nipigon</option>
<option value="America/Nome"<?php echo ($tzn == 'America/Nome')? $sel : ''; ?>>America/Nome</option>
<option value="America/Noronha"<?php echo ($tzn == 'America/Noronha')? $sel : ''; ?>>America/Noronha</option>
<option value="America/North_Dakota/Center"<?php echo ($tzn == 'America/North_Dakota/Center')? $sel : ''; ?>>America/North_Dakota/Center</option>
<option value="America/North_Dakota/New_Salem"<?php echo ($tzn == 'America/North_Dakota/New_Salem')? $sel : ''; ?>>America/North_Dakota/New_Salem</option>
<option value="America/Panama"<?php echo ($tzn == 'America/Panama')? $sel : ''; ?>>America/Panama</option>
<option value="America/Pangnirtung"<?php echo ($tzn == 'America/Pangnirtung')? $sel : ''; ?>>America/Pangnirtung</option>
<option value="America/Paramaribo"<?php echo ($tzn == 'America/Paramaribo')? $sel : ''; ?>>America/Paramaribo</option>
<option value="America/Phoenix"<?php echo ($tzn == 'America/Phoenix')? $sel : ''; ?>>America/Phoenix</option>
<option value="America/Port-au-Prince"<?php echo ($tzn == 'America/Port-au-Prince')? $sel : ''; ?>>America/Port-au-Prince</option>
<option value="America/Port_of_Spain"<?php echo ($tzn == 'America/Port_of_Spain')? $sel : ''; ?>>America/Port_of_Spain</option>
<option value="America/Porto_Acre"<?php echo ($tzn == 'America/Porto_Acre')? $sel : ''; ?>>America/Porto_Acre</option>
<option value="America/Porto_Velho"<?php echo ($tzn == 'America/Porto_Velho')? $sel : ''; ?>>America/Porto_Velho</option>
<option value="America/Puerto_Rico"<?php echo ($tzn == 'America/Puerto_Rico')? $sel : ''; ?>>America/Puerto_Rico</option>
<option value="America/Rainy_River"<?php echo ($tzn == 'America/Rainy_River')? $sel : ''; ?>>America/Rainy_River</option>
<option value="America/Rankin_Inlet"<?php echo ($tzn == 'America/Rankin_Inlet')? $sel : ''; ?>>America/Rankin_Inlet</option>
<option value="America/Recife"<?php echo ($tzn == 'America/Recife')? $sel : ''; ?>>America/Recife</option>
<option value="America/Regina"<?php echo ($tzn == 'America/Regina')? $sel : ''; ?>>America/Regina</option>
<option value="America/Resolute"<?php echo ($tzn == 'America/Resolute')? $sel : ''; ?>>America/Resolute</option>
<option value="America/Rio_Branco"<?php echo ($tzn == 'America/Rio_Branco')? $sel : ''; ?>>America/Rio_Branco</option>
<option value="America/Rosario"<?php echo ($tzn == 'America/Rosario')? $sel : ''; ?>>America/Rosario</option>
<option value="America/Santiago"<?php echo ($tzn == 'America/Santiago')? $sel : ''; ?>>America/Santiago</option>
<option value="America/Santo_Domingo"<?php echo ($tzn == 'America/Santo_Domingo')? $sel : ''; ?>>America/Santo_Domingo</option>
<option value="America/Sao_Paulo"<?php echo ($tzn == 'America/Sao_Paulo')? $sel : ''; ?>>America/Sao_Paulo</option>
<option value="America/Scoresbysund"<?php echo ($tzn == 'America/Scoresbysund')? $sel : ''; ?>>America/Scoresbysund</option>
<option value="America/Shiprock"<?php echo ($tzn == 'America/Shiprock')? $sel : ''; ?>>America/Shiprock</option>
<option value="America/St_Barthelemy"<?php echo ($tzn == 'America/St_Barthelemy')? $sel : ''; ?>>America/St_Barthelemy</option>
<option value="America/St_Johns"<?php echo ($tzn == 'America/St_Johns')? $sel : ''; ?>>America/St_Johns</option>
<option value="America/St_Kitts"<?php echo ($tzn == 'America/St_Kitts')? $sel : ''; ?>>America/St_Kitts</option>
<option value="America/St_Lucia"<?php echo ($tzn == 'America/St_Lucia')? $sel : ''; ?>>America/St_Lucia</option>
<option value="America/St_Thomas"<?php echo ($tzn == 'America/St_Thomas')? $sel : ''; ?>>America/St_Thomas</option>
<option value="America/St_Vincent"<?php echo ($tzn == 'America/St_Vincent')? $sel : ''; ?>>America/St_Vincent</option>
<option value="America/Swift_Current"<?php echo ($tzn == 'America/Swift_Current')? $sel : ''; ?>>America/Swift_Current</option>
<option value="America/Tegucigalpa"<?php echo ($tzn == 'America/Tegucigalpa')? $sel : ''; ?>>America/Tegucigalpa</option>
<option value="America/Thule"<?php echo ($tzn == 'America/Thule')? $sel : ''; ?>>America/Thule</option>
<option value="America/Thunder_Bay"<?php echo ($tzn == 'America/Thunder_Bay')? $sel : ''; ?>>America/Thunder_Bay</option>
<option value="America/Tijuana"<?php echo ($tzn == 'America/Tijuana')? $sel : ''; ?>>America/Tijuana</option>
<option value="America/Toronto"<?php echo ($tzn == 'America/Toronto')? $sel : ''; ?>>America/Toronto</option>
<option value="America/Tortola"<?php echo ($tzn == 'America/Tortola')? $sel : ''; ?>>America/Tortola</option>
<option value="America/Vancouver"<?php echo ($tzn == 'America/Vancouver')? $sel : ''; ?>>America/Vancouver</option>
<option value="America/Virgin"<?php echo ($tzn == 'America/Virgin')? $sel : ''; ?>>America/Virgin</option>
<option value="America/Whitehorse"<?php echo ($tzn == 'America/Whitehorse')? $sel : ''; ?>>America/Whitehorse</option>
<option value="America/Winnipeg"<?php echo ($tzn == 'America/Winnipeg')? $sel : ''; ?>>America/Winnipeg</option>
<option value="America/Yakutat"<?php echo ($tzn == 'America/Yakutat')? $sel : ''; ?>>America/Yakutat</option>
<option value="America/Yellowknife"<?php echo ($tzn == 'America/Yellowknife')? $sel : ''; ?>>America/Yellowknife</option>
<option value="Antarctica/Casey"<?php echo ($tzn == 'Antarctica/Casey')? $sel : ''; ?>>Antarctica/Casey</option>
<option value="Antarctica/Davis"<?php echo ($tzn == 'Antarctica/Davis')? $sel : ''; ?>>Antarctica/Davis</option>
<option value="Antarctica/DumontDUrville"<?php echo ($tzn == 'Antarctica/DumontDUrville')? $sel : ''; ?>>Antarctica/DumontDUrville</option>
<option value="Antarctica/Mawson"<?php echo ($tzn == 'Antarctica/Mawson')? $sel : ''; ?>>Antarctica/Mawson</option>
<option value="Antarctica/McMurdo"<?php echo ($tzn == 'Antarctica/McMurdo')? $sel : ''; ?>>Antarctica/McMurdo</option>
<option value="Antarctica/Palmer"<?php echo ($tzn == 'Antarctica/Palmer')? $sel : ''; ?>>Antarctica/Palmer</option>
<option value="Antarctica/Rothera"<?php echo ($tzn == 'Antarctica/Rothera')? $sel : ''; ?>>Antarctica/Rothera</option>
<option value="Antarctica/South_Pole"<?php echo ($tzn == 'Antarctica/South_Pole')? $sel : ''; ?>>Antarctica/South_Pole</option>
<option value="Antarctica/Syowa"<?php echo ($tzn == 'Antarctica/Syowa')? $sel : ''; ?>>Antarctica/Syowa</option>
<option value="Antarctica/Vostok"<?php echo ($tzn == 'Antarctica/Vostok')? $sel : ''; ?>>Antarctica/Vostok</option>
<option value="Arctic/Longyearbyen"<?php echo ($tzn == 'Arctic/Longyearbyen')? $sel : ''; ?>>Arctic/Longyearbyen</option>
<option value="Asia/Aden"<?php echo ($tzn == 'Asia/Aden')? $sel : ''; ?>>Asia/Aden</option>
<option value="Asia/Almaty"<?php echo ($tzn == 'Asia/Almaty')? $sel : ''; ?>>Asia/Almaty</option>
<option value="Asia/Amman"<?php echo ($tzn == 'Asia/Amman')? $sel : ''; ?>>Asia/Amman</option>
<option value="Asia/Anadyr"<?php echo ($tzn == 'Asia/Anadyr')? $sel : ''; ?>>Asia/Anadyr</option>
<option value="Asia/Aqtau"<?php echo ($tzn == 'Asia/Aqtau')? $sel : ''; ?>>Asia/Aqtau</option>
<option value="Asia/Aqtobe"<?php echo ($tzn == 'Asia/Aqtobe')? $sel : ''; ?>>Asia/Aqtobe</option>
<option value="Asia/Ashgabat"<?php echo ($tzn == 'Asia/Ashgabat')? $sel : ''; ?>>Asia/Ashgabat</option>
<option value="Asia/Ashkhabad"<?php echo ($tzn == 'Asia/Ashkhabad')? $sel : ''; ?>>Asia/Ashkhabad</option>
<option value="Asia/Baghdad"<?php echo ($tzn == 'Asia/Baghdad')? $sel : ''; ?>>Asia/Baghdad</option>
<option value="Asia/Bahrain"<?php echo ($tzn == 'Asia/Bahrain')? $sel : ''; ?>>Asia/Bahrain</option>
<option value="Asia/Baku"<?php echo ($tzn == 'Asia/Baku')? $sel : ''; ?>>Asia/Baku</option>
<option value="Asia/Bangkok"<?php echo ($tzn == 'Asia/Bangkok')? $sel : ''; ?>>Asia/Bangkok</option>
<option value="Asia/Beirut"<?php echo ($tzn == 'Asia/Beirut')? $sel : ''; ?>>Asia/Beirut</option>
<option value="Asia/Bishkek"<?php echo ($tzn == 'Asia/Bishkek')? $sel : ''; ?>>Asia/Bishkek</option>
<option value="Asia/Brunei"<?php echo ($tzn == 'Asia/Brunei')? $sel : ''; ?>>Asia/Brunei</option>
<option value="Asia/Calcutta"<?php echo ($tzn == 'Asia/Calcutta')? $sel : ''; ?>>Asia/Calcutta</option>
<option value="Asia/Choibalsan"<?php echo ($tzn == 'Asia/Choibalsan')? $sel : ''; ?>>Asia/Choibalsan</option>
<option value="Asia/Chongqing"<?php echo ($tzn == 'Asia/Chongqing')? $sel : ''; ?>>Asia/Chongqing</option>
<option value="Asia/Chungking"<?php echo ($tzn == 'Asia/Chungking')? $sel : ''; ?>>Asia/Chungking</option>
<option value="Asia/Colombo"<?php echo ($tzn == 'Asia/Colombo')? $sel : ''; ?>>Asia/Colombo</option>
<option value="Asia/Dacca"<?php echo ($tzn == 'Asia/Dacca')? $sel : ''; ?>>Asia/Dacca</option>
<option value="Asia/Damascus"<?php echo ($tzn == 'Asia/Damascus')? $sel : ''; ?>>Asia/Damascus</option>
<option value="Asia/Dhaka"<?php echo ($tzn == 'Asia/Dhaka')? $sel : ''; ?>>Asia/Dhaka</option>
<option value="Asia/Dili"<?php echo ($tzn == 'Asia/Dili')? $sel : ''; ?>>Asia/Dili</option>
<option value="Asia/Dubai"<?php echo ($tzn == 'Asia/Dubai')? $sel : ''; ?>>Asia/Dubai</option>
<option value="Asia/Dushanbe"<?php echo ($tzn == 'Asia/Dushanbe')? $sel : ''; ?>>Asia/Dushanbe</option>
<option value="Asia/Gaza"<?php echo ($tzn == 'Asia/Gaza')? $sel : ''; ?>>Asia/Gaza</option>
<option value="Asia/Harbin"<?php echo ($tzn == 'Asia/Harbin')? $sel : ''; ?>>Asia/Harbin</option>
<option value="Asia/Ho_Chi_Minh"<?php echo ($tzn == 'Asia/Ho_Chi_Minh')? $sel : ''; ?>>Asia/Ho_Chi_Minh</option>
<option value="Asia/Hong_Kong"<?php echo ($tzn == 'Asia/Hong_Kong')? $sel : ''; ?>>Asia/Hong_Kong</option>
<option value="Asia/Hovd"<?php echo ($tzn == 'Asia/Hovd')? $sel : ''; ?>>Asia/Hovd</option>
<option value="Asia/Irkutsk"<?php echo ($tzn == 'Asia/Irkutsk')? $sel : ''; ?>>Asia/Irkutsk</option>
<option value="Asia/Istanbul"<?php echo ($tzn == 'Asia/Istanbul')? $sel : ''; ?>>Asia/Istanbul</option>
<option value="Asia/Jakarta"<?php echo ($tzn == 'Asia/Jakarta')? $sel : ''; ?>>Asia/Jakarta</option>
<option value="Asia/Jayapura"<?php echo ($tzn == 'Asia/Jayapura')? $sel : ''; ?>>Asia/Jayapura</option>
<option value="Asia/Jerusalem"<?php echo ($tzn == 'Asia/Jerusalem')? $sel : ''; ?>>Asia/Jerusalem</option>
<option value="Asia/Kabul"<?php echo ($tzn == 'Asia/Kabul')? $sel : ''; ?>>Asia/Kabul</option>
<option value="Asia/Kamchatka"<?php echo ($tzn == 'Asia/Kamchatka')? $sel : ''; ?>>Asia/Kamchatka</option>
<option value="Asia/Karachi"<?php echo ($tzn == 'Asia/Karachi')? $sel : ''; ?>>Asia/Karachi</option>
<option value="Asia/Kashgar"<?php echo ($tzn == 'Asia/Kashgar')? $sel : ''; ?>>Asia/Kashgar</option>
<option value="Asia/Katmandu"<?php echo ($tzn == 'Asia/Katmandu')? $sel : ''; ?>>Asia/Katmandu</option>
<option value="Asia/Kolkata"<?php echo ($tzn == 'Asia/Kolkata')? $sel : ''; ?>>Asia/Kolkata</option>
<option value="Asia/Krasnoyarsk"<?php echo ($tzn == 'Asia/Krasnoyarsk')? $sel : ''; ?>>Asia/Krasnoyarsk</option>
<option value="Asia/Kuala_Lumpur"<?php echo ($tzn == 'Asia/Kuala_Lumpur')? $sel : ''; ?>>Asia/Kuala_Lumpur</option>
<option value="Asia/Kuching"<?php echo ($tzn == 'Asia/Kuching')? $sel : ''; ?>>Asia/Kuching</option>
<option value="Asia/Kuwait"<?php echo ($tzn == 'Asia/Kuwait')? $sel : ''; ?>>Asia/Kuwait</option>
<option value="Asia/Macao"<?php echo ($tzn == 'Asia/Macao')? $sel : ''; ?>>Asia/Macao</option>
<option value="Asia/Macau"<?php echo ($tzn == 'Asia/Macau')? $sel : ''; ?>>Asia/Macau</option>
<option value="Asia/Magadan"<?php echo ($tzn == 'Asia/Magadan')? $sel : ''; ?>>Asia/Magadan</option>
<option value="Asia/Makassar"<?php echo ($tzn == 'Asia/Makassar')? $sel : ''; ?>>Asia/Makassar</option>
<option value="Asia/Manila"<?php echo ($tzn == 'Asia/Manila')? $sel : ''; ?>>Asia/Manila</option>
<option value="Asia/Muscat"<?php echo ($tzn == 'Asia/Muscat')? $sel : ''; ?>>Asia/Muscat</option>
<option value="Asia/Nicosia"<?php echo ($tzn == 'Asia/Nicosia')? $sel : ''; ?>>Asia/Nicosia</option>
<option value="Asia/Novosibirsk"<?php echo ($tzn == 'Asia/Novosibirsk')? $sel : ''; ?>>Asia/Novosibirsk</option>
<option value="Asia/Omsk"<?php echo ($tzn == 'Asia/Omsk')? $sel : ''; ?>>Asia/Omsk</option>
<option value="Asia/Oral"<?php echo ($tzn == 'Asia/Oral')? $sel : ''; ?>>Asia/Oral</option>
<option value="Asia/Phnom_Penh"<?php echo ($tzn == 'Asia/Phnom_Penh')? $sel : ''; ?>>Asia/Phnom_Penh</option>
<option value="Asia/Pontianak"<?php echo ($tzn == 'Asia/Pontianak')? $sel : ''; ?>>Asia/Pontianak</option>
<option value="Asia/Pyongyang"<?php echo ($tzn == 'Asia/Pyongyang')? $sel : ''; ?>>Asia/Pyongyang</option>
<option value="Asia/Qatar"<?php echo ($tzn == 'Asia/Qatar')? $sel : ''; ?>>Asia/Qatar</option>
<option value="Asia/Qyzylorda"<?php echo ($tzn == 'Asia/Qyzylorda')? $sel : ''; ?>>Asia/Qyzylorda</option>
<option value="Asia/Rangoon"<?php echo ($tzn == 'Asia/Rangoon')? $sel : ''; ?>>Asia/Rangoon</option>
<option value="Asia/Riyadh"<?php echo ($tzn == 'Asia/Riyadh')? $sel : ''; ?>>Asia/Riyadh</option>
<option value="Asia/Saigon"<?php echo ($tzn == 'Asia/Saigon')? $sel : ''; ?>>Asia/Saigon</option>
<option value="Asia/Sakhalin"<?php echo ($tzn == 'Asia/Sakhalin')? $sel : ''; ?>>Asia/Sakhalin</option>
<option value="Asia/Samarkand"<?php echo ($tzn == 'Asia/Samarkand')? $sel : ''; ?>>Asia/Samarkand</option>
<option value="Asia/Seoul"<?php echo ($tzn == 'Asia/Seoul')? $sel : ''; ?>>Asia/Seoul</option>
<option value="Asia/Shanghai"<?php echo ($tzn == 'Asia/Shanghai')? $sel : ''; ?>>Asia/Shanghai</option>
<option value="Asia/Singapore"<?php echo ($tzn == 'Asia/Singapore')? $sel : ''; ?>>Asia/Singapore</option>
<option value="Asia/Taipei"<?php echo ($tzn == 'Asia/Taipei')? $sel : ''; ?>>Asia/Taipei</option>
<option value="Asia/Tashkent"<?php echo ($tzn == 'Asia/Tashkent')? $sel : ''; ?>>Asia/Tashkent</option>
<option value="Asia/Tbilisi"<?php echo ($tzn == 'Asia/Tbilisi')? $sel : ''; ?>>Asia/Tbilisi</option>
<option value="Asia/Tehran"<?php echo ($tzn == 'Asia/Tehran')? $sel : ''; ?>>Asia/Tehran</option>
<option value="Asia/Tel_Aviv"<?php echo ($tzn == 'Asia/Tel_Aviv')? $sel : ''; ?>>Asia/Tel_Aviv</option>
<option value="Asia/Thimbu"<?php echo ($tzn == 'Asia/Thimbu')? $sel : ''; ?>>Asia/Thimbu</option>
<option value="Asia/Thimphu"<?php echo ($tzn == 'Asia/Thimphu')? $sel : ''; ?>>Asia/Thimphu</option>
<option value="Asia/Tokyo"<?php echo ($tzn == 'Asia/Tokyo')? $sel : ''; ?>>Asia/Tokyo</option>
<option value="Asia/Ujung_Pandang"<?php echo ($tzn == 'Asia/Ujung_Pandang')? $sel : ''; ?>>Asia/Ujung_Pandang</option>
<option value="Asia/Ulaanbaatar"<?php echo ($tzn == 'Asia/Ulaanbaatar')? $sel : ''; ?>>Asia/Ulaanbaatar</option>
<option value="Asia/Ulan_Bator"<?php echo ($tzn == 'Asia/Ulan_Bator')? $sel : ''; ?>>Asia/Ulan_Bator</option>
<option value="Asia/Urumqi"<?php echo ($tzn == 'Asia/Urumqi')? $sel : ''; ?>>Asia/Urumqi</option>
<option value="Asia/Vientiane"<?php echo ($tzn == 'Asia/Vientiane')? $sel : ''; ?>>Asia/Vientiane</option>
<option value="Asia/Vladivostok"<?php echo ($tzn == 'Asia/Vladivostok')? $sel : ''; ?>>Asia/Vladivostok</option>
<option value="Asia/Yakutsk"<?php echo ($tzn == 'Asia/Yakutsk')? $sel : ''; ?>>Asia/Yakutsk</option>
<option value="Asia/Yekaterinburg"<?php echo ($tzn == 'Asia/Yekaterinburg')? $sel : ''; ?>>Asia/Yekaterinburg</option>
<option value="Asia/Yerevan"<?php echo ($tzn == 'Asia/Yerevan')? $sel : ''; ?>>Asia/Yerevan</option>
<option value="Atlantic/Azores"<?php echo ($tzn == 'Atlantic/Azores')? $sel : ''; ?>>Atlantic/Azores</option>
<option value="Atlantic/Bermuda"<?php echo ($tzn == 'Atlantic/Bermuda')? $sel : ''; ?>>Atlantic/Bermuda</option>
<option value="Atlantic/Canary"<?php echo ($tzn == 'Atlantic/Canary')? $sel : ''; ?>>Atlantic/Canary</option>
<option value="Atlantic/Cape_Verde"<?php echo ($tzn == 'Atlantic/Cape_Verde')? $sel : ''; ?>>Atlantic/Cape_Verde</option>
<option value="Atlantic/Faeroe"<?php echo ($tzn == 'Atlantic/Faeroe')? $sel : ''; ?>>Atlantic/Faeroe</option>
<option value="Atlantic/Faroe"<?php echo ($tzn == 'Atlantic/Faroe')? $sel : ''; ?>>Atlantic/Faroe</option>
<option value="Atlantic/Jan_Mayen"<?php echo ($tzn == 'Atlantic/Jan_Mayen')? $sel : ''; ?>>Atlantic/Jan_Mayen</option>
<option value="Atlantic/Madeira"<?php echo ($tzn == 'Atlantic/Madeira')? $sel : ''; ?>>Atlantic/Madeira</option>
<option value="Atlantic/Reykjavik"<?php echo ($tzn == 'Atlantic/Reykjavik')? $sel : ''; ?>>Atlantic/Reykjavik</option>
<option value="Atlantic/South_Georgia"<?php echo ($tzn == 'Atlantic/South_Georgia')? $sel : ''; ?>>Atlantic/South_Georgia</option>
<option value="Atlantic/St_Helena"<?php echo ($tzn == 'Atlantic/St_Helena')? $sel : ''; ?>>Atlantic/St_Helena</option>
<option value="Atlantic/Stanley"<?php echo ($tzn == 'Atlantic/Stanley')? $sel : ''; ?>>Atlantic/Stanley</option>
<option value="Australia/ACT"<?php echo ($tzn == 'Australia/ACT')? $sel : ''; ?>>Australia/ACT</option>
<option value="Australia/Adelaide"<?php echo ($tzn == 'Australia/Adelaide')? $sel : ''; ?>>Australia/Adelaide</option>
<option value="Australia/Brisbane"<?php echo ($tzn == 'Australia/Brisbane')? $sel : ''; ?>>Australia/Brisbane</option>
<option value="Australia/Broken_Hill"<?php echo ($tzn == 'Australia/Broken_Hill')? $sel : ''; ?>>Australia/Broken_Hill</option>
<option value="Australia/Canberra"<?php echo ($tzn == 'Australia/Canberra')? $sel : ''; ?>>Australia/Canberra</option>
<option value="Australia/Currie"<?php echo ($tzn == 'Australia/Currie')? $sel : ''; ?>>Australia/Currie</option>
<option value="Australia/Darwin"<?php echo ($tzn == 'Australia/Darwin')? $sel : ''; ?>>Australia/Darwin</option>
<option value="Australia/Eucla"<?php echo ($tzn == 'Australia/Eucla')? $sel : ''; ?>>Australia/Eucla</option>
<option value="Australia/Hobart"<?php echo ($tzn == 'Australia/Hobart')? $sel : ''; ?>>Australia/Hobart</option>
<option value="Australia/LHI"<?php echo ($tzn == 'Australia/LHI')? $sel : ''; ?>>Australia/LHI</option>
<option value="Australia/Lindeman"<?php echo ($tzn == 'Australia/Lindeman')? $sel : ''; ?>>Australia/Lindeman</option>
<option value="Australia/Lord_Howe"<?php echo ($tzn == 'Australia/Lord_Howe')? $sel : ''; ?>>Australia/Lord_Howe</option>
<option value="Australia/Melbourne"<?php echo ($tzn == 'Australia/Melbourne')? $sel : ''; ?>>Australia/Melbourne</option>
<option value="Australia/North"<?php echo ($tzn == 'Australia/North')? $sel : ''; ?>>Australia/North</option>
<option value="Australia/NSW"<?php echo ($tzn == 'Australia/NSW')? $sel : ''; ?>>Australia/NSW</option>
<option value="Australia/Perth"<?php echo ($tzn == 'Australia/Perth')? $sel : ''; ?>>Australia/Perth</option>
<option value="Australia/Queensland"<?php echo ($tzn == 'Australia/Queensland')? $sel : ''; ?>>Australia/Queensland</option>
<option value="Australia/South"<?php echo ($tzn == 'Australia/South')? $sel : ''; ?>>Australia/South</option>
<option value="Australia/Sydney"<?php echo ($tzn == 'Australia/Sydney')? $sel : ''; ?>>Australia/Sydney</option>
<option value="Australia/Tasmania"<?php echo ($tzn == 'Australia/Tasmania')? $sel : ''; ?>>Australia/Tasmania</option>
<option value="Australia/Victoria"<?php echo ($tzn == 'Australia/Victoria')? $sel : ''; ?>>Australia/Victoria</option>
<option value="Australia/West"<?php echo ($tzn == 'Australia/West')? $sel : ''; ?>>Australia/West</option>
<option value="Australia/Yancowinna"<?php echo ($tzn == 'Australia/Yancowinna')? $sel : ''; ?>>Australia/Yancowinna</option>
<option value="Brazil/Acre"<?php echo ($tzn == 'Brazil/Acre')? $sel : ''; ?>>Brazil/Acre</option>
<option value="Brazil/DeNoronha"<?php echo ($tzn == 'Brazil/DeNoronha')? $sel : ''; ?>>Brazil/DeNoronha</option>
<option value="Brazil/East"<?php echo ($tzn == 'Brazil/East')? $sel : ''; ?>>Brazil/East</option>
<option value="Brazil/West"<?php echo ($tzn == 'Brazil/West')? $sel : ''; ?>>Brazil/West</option>
<option value="Canada/Atlantic"<?php echo ($tzn == 'Canada/Atlantic')? $sel : ''; ?>>Canada/Atlantic</option>
<option value="Canada/Central"<?php echo ($tzn == 'Canada/Central')? $sel : ''; ?>>Canada/Central</option>
<option value="Canada/East-Saskatchewan"<?php echo ($tzn == 'Canada/East-Saskatchewan')? $sel : ''; ?>>Canada/East-Saskatchewan</option>
<option value="Canada/Eastern"<?php echo ($tzn == 'Canada/Eastern')? $sel : ''; ?>>Canada/Eastern</option>
<option value="Canada/Mountain"<?php echo ($tzn == 'Canada/Mountain')? $sel : ''; ?>>Canada/Mountain</option>
<option value="Canada/Newfoundland"<?php echo ($tzn == 'Canada/Newfoundland')? $sel : ''; ?>>Canada/Newfoundland</option>
<option value="Canada/Pacific"<?php echo ($tzn == 'Canada/Pacific')? $sel : ''; ?>>Canada/Pacific</option>
<option value="Canada/Saskatchewan"<?php echo ($tzn == 'Canada/Saskatchewan')? $sel : ''; ?>>Canada/Saskatchewan</option>
<option value="Canada/Yukon"<?php echo ($tzn == 'Canada/Yukon')? $sel : ''; ?>>Canada/Yukon</option>
<option value="CET"<?php echo ($tzn == 'CET')? $sel : ''; ?>>CET</option>
<option value="Chile/Continental"<?php echo ($tzn == 'Chile/Continental')? $sel : ''; ?>>Chile/Continental</option>
<option value="Chile/EasterIsland"<?php echo ($tzn == 'Chile/EasterIsland')? $sel : ''; ?>>Chile/EasterIsland</option>
<option value="CST6CDT"<?php echo ($tzn == 'CST6CDT')? $sel : ''; ?>>CST6CDT</option>
<option value="Cuba"<?php echo ($tzn == 'Cuba')? $sel : ''; ?>>Cuba</option>
<option value="EET"<?php echo ($tzn == 'EET')? $sel : ''; ?>>EET</option>
<option value="Egypt"<?php echo ($tzn == 'Egypt')? $sel : ''; ?>>Egypt</option>
<option value="Eire"<?php echo ($tzn == 'Eire')? $sel : ''; ?>>Eire</option>
<option value="EST"<?php echo ($tzn == 'EST')? $sel : ''; ?>>EST</option>
<option value="EST5EDT"<?php echo ($tzn == 'EST5EDT')? $sel : ''; ?>>EST5EDT</option>
<option value="Etc/GMT"<?php echo ($tzn == 'Etc/GMT')? $sel : ''; ?>>Etc/GMT</option>
<option value="Etc/GMT+0"<?php echo ($tzn == 'Etc/GMT+0')? $sel : ''; ?>>Etc/GMT+0</option>
<option value="Etc/GMT+1"<?php echo ($tzn == 'Etc/GMT+1')? $sel : ''; ?>>Etc/GMT+1</option>
<option value="Etc/GMT+10"<?php echo ($tzn == 'Etc/GMT+10')? $sel : ''; ?>>Etc/GMT+10</option>
<option value="Etc/GMT+11"<?php echo ($tzn == 'Etc/GMT+11')? $sel : ''; ?>>Etc/GMT+11</option>
<option value="Etc/GMT+12"<?php echo ($tzn == 'Etc/GMT+12')? $sel : ''; ?>>Etc/GMT+12</option>
<option value="Etc/GMT+2"<?php echo ($tzn == 'Etc/GMT+2')? $sel : ''; ?>>Etc/GMT+2</option>
<option value="Etc/GMT+3"<?php echo ($tzn == 'Etc/GMT+3')? $sel : ''; ?>>Etc/GMT+3</option>
<option value="Etc/GMT+4"<?php echo ($tzn == 'Etc/GMT+4')? $sel : ''; ?>>Etc/GMT+4</option>
<option value="Etc/GMT+5"<?php echo ($tzn == 'Etc/GMT+5')? $sel : ''; ?>>Etc/GMT+5</option>
<option value="Etc/GMT+6"<?php echo ($tzn == 'Etc/GMT+6')? $sel : ''; ?>>Etc/GMT+6</option>
<option value="Etc/GMT+7"<?php echo ($tzn == 'Etc/GMT+7')? $sel : ''; ?>>Etc/GMT+7</option>
<option value="Etc/GMT+8"<?php echo ($tzn == 'Etc/GMT+8')? $sel : ''; ?>>Etc/GMT+8</option>
<option value="Etc/GMT+9"<?php echo ($tzn == 'Etc/GMT+9')? $sel : ''; ?>>Etc/GMT+9</option>
<option value="Etc/GMT-0"<?php echo ($tzn == 'Etc/GMT-0')? $sel : ''; ?>>Etc/GMT-0</option>
<option value="Etc/GMT-1"<?php echo ($tzn == 'Etc/GMT-1')? $sel : ''; ?>>Etc/GMT-1</option>
<option value="Etc/GMT-10"<?php echo ($tzn == 'Etc/GMT-10')? $sel : ''; ?>>Etc/GMT-10</option>
<option value="Etc/GMT-11"<?php echo ($tzn == 'Etc/GMT-11')? $sel : ''; ?>>Etc/GMT-11</option>
<option value="Etc/GMT-12"<?php echo ($tzn == 'Etc/GMT-12')? $sel : ''; ?>>Etc/GMT-12</option>
<option value="Etc/GMT-13"<?php echo ($tzn == 'Etc/GMT-13')? $sel : ''; ?>>Etc/GMT-13</option>
<option value="Etc/GMT-14"<?php echo ($tzn == 'Etc/GMT-14')? $sel : ''; ?>>Etc/GMT-14</option>
<option value="Etc/GMT-2"<?php echo ($tzn == 'Etc/GMT-2')? $sel : ''; ?>>Etc/GMT-2</option>
<option value="Etc/GMT-3"<?php echo ($tzn == 'Etc/GMT-3')? $sel : ''; ?>>Etc/GMT-3</option>
<option value="Etc/GMT-4"<?php echo ($tzn == 'Etc/GMT-4')? $sel : ''; ?>>Etc/GMT-4</option>
<option value="Etc/GMT-5"<?php echo ($tzn == 'Etc/GMT-5')? $sel : ''; ?>>Etc/GMT-5</option>
<option value="Etc/GMT-6"<?php echo ($tzn == 'Etc/GMT-6')? $sel : ''; ?>>Etc/GMT-6</option>
<option value="Etc/GMT-7"<?php echo ($tzn == 'Etc/GMT-7')? $sel : ''; ?>>Etc/GMT-7</option>
<option value="Etc/GMT-8"<?php echo ($tzn == 'Etc/GMT-8')? $sel : ''; ?>>Etc/GMT-8</option>
<option value="Etc/GMT-9"<?php echo ($tzn == 'Etc/GMT-9')? $sel : ''; ?>>Etc/GMT-9</option>
<option value="Etc/GMT0"<?php echo ($tzn == 'Etc/GMT0')? $sel : ''; ?>>Etc/GMT0</option>
<option value="Etc/Greenwich"<?php echo ($tzn == 'Etc/Greenwich')? $sel : ''; ?>>Etc/Greenwich</option>
<option value="Etc/UCT"<?php echo ($tzn == 'Etc/UCT')? $sel : ''; ?>>Etc/UCT</option>
<option value="Etc/Universal"<?php echo ($tzn == 'Etc/Universal')? $sel : ''; ?>>Etc/Universal</option>
<option value="Etc/UTC"<?php echo ($tzn == 'Etc/UTC')? $sel : ''; ?>>Etc/UTC</option>
<option value="Etc/Zulu"<?php echo ($tzn == 'Etc/Zulu')? $sel : ''; ?>>Etc/Zulu</option>
<option value="Europe/Amsterdam"<?php echo ($tzn == 'Europe/Amsterdam')? $sel : ''; ?>>Europe/Amsterdam</option>
<option value="Europe/Andorra"<?php echo ($tzn == 'Europe/Andorra')? $sel : ''; ?>>Europe/Andorra</option>
<option value="Europe/Athens"<?php echo ($tzn == 'Europe/Athens')? $sel : ''; ?>>Europe/Athens</option>
<option value="Europe/Belfast"<?php echo ($tzn == 'Europe/Belfast')? $sel : ''; ?>>Europe/Belfast</option>
<option value="Europe/Belgrade"<?php echo ($tzn == 'Europe/Belgrade')? $sel : ''; ?>>Europe/Belgrade</option>
<option value="Europe/Berlin"<?php echo ($tzn == 'Europe/Berlin')? $sel : ''; ?>>Europe/Berlin</option>
<option value="Europe/Bratislava"<?php echo ($tzn == 'Europe/Bratislava')? $sel : ''; ?>>Europe/Bratislava</option>
<option value="Europe/Brussels"<?php echo ($tzn == 'Europe/Brussels')? $sel : ''; ?>>Europe/Brussels</option>
<option value="Europe/Bucharest"<?php echo ($tzn == 'Europe/Bucharest')? $sel : ''; ?>>Europe/Bucharest</option>
<option value="Europe/Budapest"<?php echo ($tzn == 'Europe/Budapest')? $sel : ''; ?>>Europe/Budapest</option>
<option value="Europe/Chisinau"<?php echo ($tzn == 'Europe/Chisinau')? $sel : ''; ?>>Europe/Chisinau</option>
<option value="Europe/Copenhagen"<?php echo ($tzn == 'Europe/Copenhagen')? $sel : ''; ?>>Europe/Copenhagen</option>
<option value="Europe/Dublin"<?php echo ($tzn == 'Europe/Dublin')? $sel : ''; ?>>Europe/Dublin</option>
<option value="Europe/Gibraltar"<?php echo ($tzn == 'Europe/Gibraltar')? $sel : ''; ?>>Europe/Gibraltar</option>
<option value="Europe/Guernsey"<?php echo ($tzn == 'Europe/Guernsey')? $sel : ''; ?>>Europe/Guernsey</option>
<option value="Europe/Helsinki"<?php echo ($tzn == 'Europe/Helsinki')? $sel : ''; ?>>Europe/Helsinki</option>
<option value="Europe/Isle_of_Man"<?php echo ($tzn == 'Europe/Isle_of_Man')? $sel : ''; ?>>Europe/Isle_of_Man</option>
<option value="Europe/Istanbul"<?php echo ($tzn == 'Europe/Istanbul')? $sel : ''; ?>>Europe/Istanbul</option>
<option value="Europe/Jersey"<?php echo ($tzn == 'Europe/Jersey')? $sel : ''; ?>>Europe/Jersey</option>
<option value="Europe/Kaliningrad"<?php echo ($tzn == 'Europe/Kaliningrad')? $sel : ''; ?>>Europe/Kaliningrad</option>
<option value="Europe/Kiev"<?php echo ($tzn == 'Europe/Kiev')? $sel : ''; ?>>Europe/Kiev</option>
<option value="Europe/Lisbon"<?php echo ($tzn == 'Europe/Lisbon')? $sel : ''; ?>>Europe/Lisbon</option>
<option value="Europe/Ljubljana"<?php echo ($tzn == 'Europe/Ljubljana')? $sel : ''; ?>>Europe/Ljubljana</option>
<option value="Europe/London"<?php echo ($tzn == 'Europe/London')? $sel : ''; ?>>Europe/London</option>
<option value="Europe/Luxembourg"<?php echo ($tzn == 'Europe/Luxembourg')? $sel : ''; ?>>Europe/Luxembourg</option>
<option value="Europe/Madrid"<?php echo ($tzn == 'Europe/Madrid')? $sel : ''; ?>>Europe/Madrid</option>
<option value="Europe/Malta"<?php echo ($tzn == 'Europe/Malta')? $sel : ''; ?>>Europe/Malta</option>
<option value="Europe/Mariehamn"<?php echo ($tzn == 'Europe/Mariehamn')? $sel : ''; ?>>Europe/Mariehamn</option>
<option value="Europe/Minsk"<?php echo ($tzn == 'Europe/Minsk')? $sel : ''; ?>>Europe/Minsk</option>
<option value="Europe/Monaco"<?php echo ($tzn == 'Europe/Monaco')? $sel : ''; ?>>Europe/Monaco</option>
<option value="Europe/Moscow"<?php echo ($tzn == 'Europe/Moscow')? $sel : ''; ?>>Europe/Moscow</option>
<option value="Europe/Nicosia"<?php echo ($tzn == 'Europe/Nicosia')? $sel : ''; ?>>Europe/Nicosia</option>
<option value="Europe/Oslo"<?php echo ($tzn == 'Europe/Oslo')? $sel : ''; ?>>Europe/Oslo</option>
<option value="Europe/Paris"<?php echo ($tzn == 'Europe/Paris')? $sel : ''; ?>>Europe/Paris</option>
<option value="Europe/Podgorica"<?php echo ($tzn == 'Europe/Podgorica')? $sel : ''; ?>>Europe/Podgorica</option>
<option value="Europe/Prague"<?php echo ($tzn == 'Europe/Prague')? $sel : ''; ?>>Europe/Prague</option>
<option value="Europe/Riga"<?php echo ($tzn == 'Europe/Riga')? $sel : ''; ?>>Europe/Riga</option>
<option value="Europe/Rome"<?php echo ($tzn == 'Europe/Rome')? $sel : ''; ?>>Europe/Rome</option>
<option value="Europe/Samara"<?php echo ($tzn == 'Europe/Samara')? $sel : ''; ?>>Europe/Samara</option>
<option value="Europe/San_Marino"<?php echo ($tzn == 'Europe/San_Marino')? $sel : ''; ?>>Europe/San_Marino</option>
<option value="Europe/Sarajevo"<?php echo ($tzn == 'Europe/Sarajevo')? $sel : ''; ?>>Europe/Sarajevo</option>
<option value="Europe/Simferopol"<?php echo ($tzn == 'Europe/Simferopol')? $sel : ''; ?>>Europe/Simferopol</option>
<option value="Europe/Skopje"<?php echo ($tzn == 'Europe/Skopje')? $sel : ''; ?>>Europe/Skopje</option>
<option value="Europe/Sofia"<?php echo ($tzn == 'Europe/Sofia')? $sel : ''; ?>>Europe/Sofia</option>
<option value="Europe/Stockholm"<?php echo ($tzn == 'Europe/Stockholm')? $sel : ''; ?>>Europe/Stockholm</option>
<option value="Europe/Tallinn"<?php echo ($tzn == 'Europe/Tallinn')? $sel : ''; ?>>Europe/Tallinn</option>
<option value="Europe/Tirane"<?php echo ($tzn == 'Europe/Tirane')? $sel : ''; ?>>Europe/Tirane</option>
<option value="Europe/Tiraspol"<?php echo ($tzn == 'Europe/Tiraspol')? $sel : ''; ?>>Europe/Tiraspol</option>
<option value="Europe/Uzhgorod"<?php echo ($tzn == 'Europe/Uzhgorod')? $sel : ''; ?>>Europe/Uzhgorod</option>
<option value="Europe/Vaduz"<?php echo ($tzn == 'Europe/Vaduz')? $sel : ''; ?>>Europe/Vaduz</option>
<option value="Europe/Vatican"<?php echo ($tzn == 'Europe/Vatican')? $sel : ''; ?>>Europe/Vatican</option>
<option value="Europe/Vienna"<?php echo ($tzn == 'Europe/Vienna')? $sel : ''; ?>>Europe/Vienna</option>
<option value="Europe/Vilnius"<?php echo ($tzn == 'Europe/Vilnius')? $sel : ''; ?>>Europe/Vilnius</option>
<option value="Europe/Volgograd"<?php echo ($tzn == 'Europe/Volgograd')? $sel : ''; ?>>Europe/Volgograd</option>
<option value="Europe/Warsaw"<?php echo ($tzn == 'Europe/Warsaw')? $sel : ''; ?>>Europe/Warsaw</option>
<option value="Europe/Zagreb"<?php echo ($tzn == 'Europe/Zagreb')? $sel : ''; ?>>Europe/Zagreb</option>
<option value="Europe/Zaporozhye"<?php echo ($tzn == 'Europe/Zaporozhye')? $sel : ''; ?>>Europe/Zaporozhye</option>
<option value="Europe/Zurich"<?php echo ($tzn == 'Europe/Zurich')? $sel : ''; ?>>Europe/Zurich</option>
<option value="Factory"<?php echo ($tzn == 'Factory')? $sel : ''; ?>>Factory</option>
<option value="GB"<?php echo ($tzn == 'GB')? $sel : ''; ?>>GB</option>
<option value="GB-Eire"<?php echo ($tzn == 'GB-Eire')? $sel : ''; ?>>GB-Eire</option>
<option value="GMT"<?php echo ($tzn == 'GMT')? $sel : ''; ?>>GMT</option>
<option value="GMT+0"<?php echo ($tzn == 'GMT+0')? $sel : ''; ?>>GMT+0</option>
<option value="GMT-0"<?php echo ($tzn == 'GMT-0')? $sel : ''; ?>>GMT-0</option>
<option value="GMT0"<?php echo ($tzn == 'GMT0')? $sel : ''; ?>>GMT0</option>
<option value="Greenwich"<?php echo ($tzn == 'Greenwich')? $sel : ''; ?>>Greenwich</option>
<option value="Hongkong"<?php echo ($tzn == 'Hongkong')? $sel : ''; ?>>Hongkong</option>
<option value="HST"<?php echo ($tzn == 'HST')? $sel : ''; ?>>HST</option>
<option value="Iceland"<?php echo ($tzn == 'Iceland')? $sel : ''; ?>>Iceland</option>
<option value="Indian/Antananarivo"<?php echo ($tzn == 'Indian/Antananarivo')? $sel : ''; ?>>Indian/Antananarivo</option>
<option value="Indian/Chagos"<?php echo ($tzn == 'Indian/Chagos')? $sel : ''; ?>>Indian/Chagos</option>
<option value="Indian/Christmas"<?php echo ($tzn == 'Indian/Christmas')? $sel : ''; ?>>Indian/Christmas</option>
<option value="Indian/Cocos"<?php echo ($tzn == 'Indian/Cocos')? $sel : ''; ?>>Indian/Cocos</option>
<option value="Indian/Comoro"<?php echo ($tzn == 'Indian/Comoro')? $sel : ''; ?>>Indian/Comoro</option>
<option value="Indian/Kerguelen"<?php echo ($tzn == 'Indian/Kerguelen')? $sel : ''; ?>>Indian/Kerguelen</option>
<option value="Indian/Mahe"<?php echo ($tzn == 'Indian/Mahe')? $sel : ''; ?>>Indian/Mahe</option>
<option value="Indian/Maldives"<?php echo ($tzn == 'Indian/Maldives')? $sel : ''; ?>>Indian/Maldives</option>
<option value="Indian/Mauritius"<?php echo ($tzn == 'Indian/Mauritius')? $sel : ''; ?>>Indian/Mauritius</option>
<option value="Indian/Mayotte"<?php echo ($tzn == 'Indian/Mayotte')? $sel : ''; ?>>Indian/Mayotte</option>
<option value="Indian/Reunion"<?php echo ($tzn == 'Indian/Reunion')? $sel : ''; ?>>Indian/Reunion</option>
<option value="Iran"<?php echo ($tzn == 'Iran')? $sel : ''; ?>>Iran</option>
<option value="Israel"<?php echo ($tzn == 'Israel')? $sel : ''; ?>>Israel</option>
<option value="Jamaica"<?php echo ($tzn == 'Jamaica')? $sel : ''; ?>>Jamaica</option>
<option value="Japan"<?php echo ($tzn == 'Japan')? $sel : ''; ?>>Japan</option>
<option value="Kwajalein"<?php echo ($tzn == 'Kwajalein')? $sel : ''; ?>>Kwajalein</option>
<option value="Libya"<?php echo ($tzn == 'Libya')? $sel : ''; ?>>Libya</option>
<option value="MET"<?php echo ($tzn == 'MET')? $sel : ''; ?>>MET</option>
<option value="Mexico/BajaNorte"<?php echo ($tzn == 'Mexico/BajaNorte')? $sel : ''; ?>>Mexico/BajaNorte</option>
<option value="Mexico/BajaSur"<?php echo ($tzn == 'Mexico/BajaSur')? $sel : ''; ?>>Mexico/BajaSur</option>
<option value="Mexico/General"<?php echo ($tzn == 'Mexico/General')? $sel : ''; ?>>Mexico/General</option>
<option value="MST"<?php echo ($tzn == 'MST')? $sel : ''; ?>>MST</option>
<option value="MST7MDT"<?php echo ($tzn == 'MST7MDT')? $sel : ''; ?>>MST7MDT</option>
<option value="Navajo"<?php echo ($tzn == 'Navajo')? $sel : ''; ?>>Navajo</option>
<option value="NZ"<?php echo ($tzn == 'NZ')? $sel : ''; ?>>NZ</option>
<option value="NZ-CHAT"<?php echo ($tzn == 'NZ-CHAT')? $sel : ''; ?>>NZ-CHAT</option>
<option value="Pacific/Apia"<?php echo ($tzn == 'Pacific/Apia')? $sel : ''; ?>>Pacific/Apia</option>
<option value="Pacific/Auckland"<?php echo ($tzn == 'Pacific/Auckland')? $sel : ''; ?>>Pacific/Auckland</option>
<option value="Pacific/Chatham"<?php echo ($tzn == 'Pacific/Chatham')? $sel : ''; ?>>Pacific/Chatham</option>
<option value="Pacific/Easter"<?php echo ($tzn == 'Pacific/Easter')? $sel : ''; ?>>Pacific/Easter</option>
<option value="Pacific/Efate"<?php echo ($tzn == 'Pacific/Efate')? $sel : ''; ?>>Pacific/Efate</option>
<option value="Pacific/Enderbury"<?php echo ($tzn == 'Pacific/Enderbury')? $sel : ''; ?>>Pacific/Enderbury</option>
<option value="Pacific/Fakaofo"<?php echo ($tzn == 'Pacific/Fakaofo')? $sel : ''; ?>>Pacific/Fakaofo</option>
<option value="Pacific/Fiji"<?php echo ($tzn == 'Pacific/Fiji')? $sel : ''; ?>>Pacific/Fiji</option>
<option value="Pacific/Funafuti"<?php echo ($tzn == 'Pacific/Funafuti')? $sel : ''; ?>>Pacific/Funafuti</option>
<option value="Pacific/Galapagos"<?php echo ($tzn == 'Pacific/Galapagos')? $sel : ''; ?>>Pacific/Galapagos</option>
<option value="Pacific/Gambier"<?php echo ($tzn == 'Pacific/Gambier')? $sel : ''; ?>>Pacific/Gambier</option>
<option value="Pacific/Guadalcanal"<?php echo ($tzn == 'Pacific/Guadalcanal')? $sel : ''; ?>>Pacific/Guadalcanal</option>
<option value="Pacific/Guam"<?php echo ($tzn == 'Pacific/Guam')? $sel : ''; ?>>Pacific/Guam</option>
<option value="Pacific/Honolulu"<?php echo ($tzn == 'Pacific/Honolulu')? $sel : ''; ?>>Pacific/Honolulu</option>
<option value="Pacific/Johnston"<?php echo ($tzn == 'Pacific/Johnston')? $sel : ''; ?>>Pacific/Johnston</option>
<option value="Pacific/Kiritimati"<?php echo ($tzn == 'Pacific/Kiritimati')? $sel : ''; ?>>Pacific/Kiritimati</option>
<option value="Pacific/Kosrae"<?php echo ($tzn == 'Pacific/Kosrae')? $sel : ''; ?>>Pacific/Kosrae</option>
<option value="Pacific/Kwajalein"<?php echo ($tzn == 'Pacific/Kwajalein')? $sel : ''; ?>>Pacific/Kwajalein</option>
<option value="Pacific/Majuro"<?php echo ($tzn == 'Pacific/Majuro')? $sel : ''; ?>>Pacific/Majuro</option>
<option value="Pacific/Marquesas"<?php echo ($tzn == 'Pacific/Marquesas')? $sel : ''; ?>>Pacific/Marquesas</option>
<option value="Pacific/Midway"<?php echo ($tzn == 'Pacific/Midway')? $sel : ''; ?>>Pacific/Midway</option>
<option value="Pacific/Nauru"<?php echo ($tzn == 'Pacific/Nauru')? $sel : ''; ?>>Pacific/Nauru</option>
<option value="Pacific/Niue"<?php echo ($tzn == 'Pacific/Niue')? $sel : ''; ?>>Pacific/Niue</option>
<option value="Pacific/Norfolk"<?php echo ($tzn == 'Pacific/Norfolk')? $sel : ''; ?>>Pacific/Norfolk</option>
<option value="Pacific/Noumea"<?php echo ($tzn == 'Pacific/Noumea')? $sel : ''; ?>>Pacific/Noumea</option>
<option value="Pacific/Pago_Pago"<?php echo ($tzn == 'Pacific/Pago_Pago')? $sel : ''; ?>>Pacific/Pago_Pago</option>
<option value="Pacific/Palau"<?php echo ($tzn == 'Pacific/Palau')? $sel : ''; ?>>Pacific/Palau</option>
<option value="Pacific/Pitcairn"<?php echo ($tzn == 'Pacific/Pitcairn')? $sel : ''; ?>>Pacific/Pitcairn</option>
<option value="Pacific/Ponape"<?php echo ($tzn == 'Pacific/Ponape')? $sel : ''; ?>>Pacific/Ponape</option>
<option value="Pacific/Port_Moresby"<?php echo ($tzn == 'Pacific/Port_Moresby')? $sel : ''; ?>>Pacific/Port_Moresby</option>
<option value="Pacific/Rarotonga"<?php echo ($tzn == 'Pacific/Rarotonga')? $sel : ''; ?>>Pacific/Rarotonga</option>
<option value="Pacific/Saipan"<?php echo ($tzn == 'Pacific/Saipan')? $sel : ''; ?>>Pacific/Saipan</option>
<option value="Pacific/Samoa"<?php echo ($tzn == 'Pacific/Samoa')? $sel : ''; ?>>Pacific/Samoa</option>
<option value="Pacific/Tahiti"<?php echo ($tzn == 'Pacific/Tahiti')? $sel : ''; ?>>Pacific/Tahiti</option>
<option value="Pacific/Tarawa"<?php echo ($tzn == 'Pacific/Tarawa')? $sel : ''; ?>>Pacific/Tarawa</option>
<option value="Pacific/Tongatapu"<?php echo ($tzn == 'Pacific/Tongatapu')? $sel : ''; ?>>Pacific/Tongatapu</option>
<option value="Pacific/Truk"<?php echo ($tzn == 'Pacific/Truk')? $sel : ''; ?>>Pacific/Truk</option>
<option value="Pacific/Wake"<?php echo ($tzn == 'Pacific/Wake')? $sel : ''; ?>>Pacific/Wake</option>
<option value="Pacific/Wallis"<?php echo ($tzn == 'Pacific/Wallis')? $sel : ''; ?>>Pacific/Wallis</option>
<option value="Pacific/Yap"<?php echo ($tzn == 'Pacific/Yap')? $sel : ''; ?>>Pacific/Yap</option>
<option value="Poland"<?php echo ($tzn == 'Poland')? $sel : ''; ?>>Poland</option>
<option value="Portugal"<?php echo ($tzn == 'Portugal')? $sel : ''; ?>>Portugal</option>
<option value="PRC"<?php echo ($tzn == 'PRC')? $sel : ''; ?>>PRC</option>
<option value="PST8PDT"<?php echo ($tzn == 'PST8PDT')? $sel : ''; ?>>PST8PDT</option>
<option value="ROC"<?php echo ($tzn == 'ROC')? $sel : ''; ?>>ROC</option>
<option value="ROK"<?php echo ($tzn == 'ROK')? $sel : ''; ?>>ROK</option>
<option value="Singapore"<?php echo ($tzn == 'Singapore')? $sel : ''; ?>>Singapore</option>
<option value="Turkey"<?php echo ($tzn == 'Turkey')? $sel : ''; ?>>Turkey</option>
<option value="UCT"<?php echo ($tzn == 'UCT')? $sel : ''; ?>>UCT</option>
<option value="Universal"<?php echo ($tzn == 'Universal')? $sel : ''; ?>>Universal</option>
<option value="US/Alaska"<?php echo ($tzn == 'US/Alaska')? $sel : ''; ?>>US/Alaska</option>
<option value="US/Aleutian"<?php echo ($tzn == 'US/Aleutian')? $sel : ''; ?>>US/Aleutian</option>
<option value="US/Arizona"<?php echo ($tzn == 'US/Arizona')? $sel : ''; ?>>US/Arizona</option>
<option value="US/Central"<?php echo ($tzn == 'US/Central')? $sel : ''; ?>>US/Central</option>
<option value="US/East-Indiana"<?php echo ($tzn == 'US/East-Indiana')? $sel : ''; ?>>US/East-Indiana</option>
<option value="US/Eastern"<?php echo ($tzn == 'US/Eastern')? $sel : ''; ?>>US/Eastern</option>
<option value="US/Hawaii"<?php echo ($tzn == 'US/Hawaii')? $sel : ''; ?>>US/Hawaii</option>
<option value="US/Indiana-Starke"<?php echo ($tzn == 'US/Indiana-Starke')? $sel : ''; ?>>US/Indiana-Starke</option>
<option value="US/Michigan"<?php echo ($tzn == 'US/Michigan')? $sel : ''; ?>>US/Michigan</option>
<option value="US/Mountain"<?php echo ($tzn == 'US/Mountain')? $sel : ''; ?>>US/Mountain</option>
<option value="US/Pacific"<?php echo ($tzn == 'US/Pacific')? $sel : ''; ?>>US/Pacific</option>
<option value="US/Pacific-New"<?php echo ($tzn == 'US/Pacific-New')? $sel : ''; ?>>US/Pacific-New</option>
<option value="US/Samoa"<?php echo ($tzn == 'US/Samoa')? $sel : ''; ?>>US/Samoa</option>
<option value="UTC"<?php echo ($tzn == 'UTC')? $sel : ''; ?>>UTC</option>
<option value="W-SU"<?php echo ($tzn == 'W-SU')? $sel : ''; ?>>W-SU</option>
<option value="WET"<?php echo ($tzn == 'WET')? $sel : ''; ?>>WET</option>
<option value="Zulu"<?php echo ($tzn == 'Zulu')? $sel : ''; ?>>Zulu</option>
</select>
<span id="DataFieldInputExtra_TIMEZONE">&nbsp;</span></div>
<p class="Example"><i>Example: America/New_York</i></p>
<p class="CommentLine">The timezone in which the calendar will set the local time for. All new events, logs, etc will be affected by this setting.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_WEEK_STARTING_DAY">Week Starting Day:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><select id="Input_WEEK_STARTING_DAY" name="WEEK_STARTING_DAY">
<option value="0"<?php echo ($GLOBALS['Form_WEEK_STARTING_DAY'] == '0')? $sel : ''; ?>>Sunday (0)</option>
<option value="1"<?php echo ($GLOBALS['Form_WEEK_STARTING_DAY'] == '1')? $sel : ''; ?>>Monday (1)</option>
</select>
<span id="DataFieldInputExtra_WEEK_STARTING_DAY">&nbsp;</span></div>
<p class="CommentLine">Defines the week starting day</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_USE_AMPM">Use AM/PM:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_USE_AMPM"><input type="checkbox" id="CheckBox_USE_AMPM" name="USE_AMPM" value="true"<?php echo ($GLOBALS['Form_USE_AMPM'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_USE_AMPM">&nbsp;</span></div>
<p class="CommentLine">Defines time format e.g. 1am-11pm (true) or 1:00-23:00 (false)</p>
</td>

</tr></tbody>
</table></div>

<h2>Display:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_COLUMNSIDE">Column Position:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><select id="Input_COLUMNSIDE" name="COLUMNSIDE">
<option value="LEFT"<?php echo ($GLOBALS['Form_COLUMNSIDE'] == 'LEFT')? $sel : ''; ?>>LEFT</option>
<option value="RIGHT"<?php echo ($GLOBALS['Form_COLUMNSIDE'] == 'RIGHT')? $sel : ''; ?>>RIGHT</option>
</select>
<span id="DataFieldInputExtra_COLUMNSIDE">&nbsp;</span></div>
<p class="CommentLine">Which side the little calendar, 'jump to', 'today is', etc. will be on.</p>
<p class="CommentLine">RIGHT is more user friendly for users with low resolutions.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_SHOW_UPCOMING_TAB">Show Upcoming Tab:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_SHOW_UPCOMING_TAB"><input type="checkbox" id="CheckBox_SHOW_UPCOMING_TAB" name="SHOW_UPCOMING_TAB" value="true" onclick="ToggleDependant('SHOW_UPCOMING_TAB');" onchange="ToggleDependant('SHOW_UPCOMING_TAB');"<?php echo ($GLOBALS['Form_SHOW_UPCOMING_TAB'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_SHOW_UPCOMING_TAB">&nbsp;</span></div>
<p class="CommentLine">Whether or not the upcoming tab will be shown.</p>

<div id="Dependants_SHOW_UPCOMING_TAB"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_MAX_UPCOMING_EVENTS">Max Upcoming Events:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_MAX_UPCOMING_EVENTS" name="MAX_UPCOMING_EVENTS" value="<?php echo htmlspecialchars($GLOBALS['Form_MAX_UPCOMING_EVENTS'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_MAX_UPCOMING_EVENTS">&nbsp;</span></div>
<p class="CommentLine">The maximum number of upcoming events displayed.</p>
</td>
</tr></tbody>
</table></div>

<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("SHOW_UPCOMING_TAB");
/* ]]> */</script>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_SHOW_MONTH_OVERLAP">Show Month Overlap:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_SHOW_MONTH_OVERLAP"><input type="checkbox" id="CheckBox_SHOW_MONTH_OVERLAP" name="SHOW_MONTH_OVERLAP" value="true"<?php echo ($GLOBALS['Form_SHOW_MONTH_OVERLAP'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_SHOW_MONTH_OVERLAP">&nbsp;</span></div>
<p class="CommentLine">Whether or not events in month view on days that are not actually part of the current month should be shown.</p>
<p class="CommentLine">For example, if the first day of the month starts on a Wednesday, then Sunday-Tuesday are from the previous month.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_COMBINED_JUMPTO">Combined 'Jump To' Drop-Down:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_COMBINED_JUMPTO"><input type="checkbox" id="CheckBox_COMBINED_JUMPTO" name="COMBINED_JUMPTO" value="true"<?php echo ($GLOBALS['Form_COMBINED_JUMPTO'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_COMBINED_JUMPTO">&nbsp;</span></div>
<p class="CommentLine">Whether or not the 'jump to' drop-down in the column will be combined into a single drop-down box or not.</p>
<p class="CommentLine">When set to true, the list will contain all possible month/years combinations for the next X years (where X is ALLOWED_YEARS_AHEAD).</p>
<p class="CommentLine">Only the last 3 months will be included in this list.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_CUSTOM_LOGIN_HTML">Use Custom Login Page:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_CUSTOM_LOGIN_HTML"><input type="checkbox" id="CheckBox_CUSTOM_LOGIN_HTML" name="CUSTOM_LOGIN_HTML" value="true"<?php echo ($GLOBALS['Form_CUSTOM_LOGIN_HTML'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_CUSTOM_LOGIN_HTML">&nbsp;</span></div>
<p class="CommentLine">By default the login page includes the login form and a message about how to request a login to the calendar.</p>
<p class="CommentLine">When set to true, a file at <code>./static-includes/loginform.inc</code> will be used as a custom login page:</p>
<ul>
<li>It must include <code>@@LOGIN_FORM@@</code> which will be replaced with the login form itself.</li>
<li>You can also include <code>@@LOGIN_HEADER@@</code> which will be replaced with the "Login" header text for the translation you specified.</li>
<li>See the <code>./static-includes/loginform-EXAMPLE.inc</code> file for an example.</li>
</ul>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_INCLUDE_STATIC_PRE_HEADER">Include Static Pre-Header HTML:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_INCLUDE_STATIC_PRE_HEADER"><input type="checkbox" id="CheckBox_INCLUDE_STATIC_PRE_HEADER" name="INCLUDE_STATIC_PRE_HEADER" value="true"<?php echo ($GLOBALS['Form_INCLUDE_STATIC_PRE_HEADER'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_INCLUDE_STATIC_PRE_HEADER">&nbsp;</span></div>
<p class="CommentLine">Include the file located at <code>./static-includes/subcalendar-pre-header.inc</code> before the calendar header HTML for all calendars.</p>
<p class="CommentLine">This allows you to enforce a standard header for all calendars.</p>
<p class="CommentLine">This does not affect the default calendar.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_INCLUDE_STATIC_POST_HEADER">Include Static Post-Header HTML:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_INCLUDE_STATIC_POST_HEADER"><input type="checkbox" id="CheckBox_INCLUDE_STATIC_POST_HEADER" name="INCLUDE_STATIC_POST_HEADER" value="true"<?php echo ($GLOBALS['Form_INCLUDE_STATIC_POST_HEADER'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_INCLUDE_STATIC_POST_HEADER">&nbsp;</span></div>
<p class="CommentLine">Include the file located at <code>./static-includes/subcalendar-post-header.inc</code> after the calendar header HTML for all calendars.</p>
<p class="CommentLine">This allows you to enforce a standard header for all calendars.</p>
<p class="CommentLine">This does not affect the default calendar.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_INCLUDE_STATIC_PRE_FOOTER">Include Static Pre-Footer HTML:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_INCLUDE_STATIC_PRE_FOOTER"><input type="checkbox" id="CheckBox_INCLUDE_STATIC_PRE_FOOTER" name="INCLUDE_STATIC_PRE_FOOTER" value="true"<?php echo ($GLOBALS['Form_INCLUDE_STATIC_PRE_FOOTER'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_INCLUDE_STATIC_PRE_FOOTER">&nbsp;</span></div>
<p class="CommentLine">Include the file located at <code>./static-includes/subcalendar-pre-footer.inc</code> before the calendar footer HTML for all calendars.</p>
<p class="CommentLine">This allows you to enforce a standard footer for all calendars.</p>
<p class="CommentLine">This does not affect the default calendar.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_INCLUDE_STATIC_POST_FOOTER">Include Static Post-Footer HTML:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_INCLUDE_STATIC_POST_FOOTER"><input type="checkbox" id="CheckBox_INCLUDE_STATIC_POST_FOOTER" name="INCLUDE_STATIC_POST_FOOTER" value="true"<?php echo ($GLOBALS['Form_INCLUDE_STATIC_POST_FOOTER'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_INCLUDE_STATIC_POST_FOOTER">&nbsp;</span></div>
<p class="CommentLine">Include the file located at <code>./static-includes/subcalendar-post-footer.inc</code> after the calendar footer HTML for all calendars.</p>
<p class="CommentLine">This allows you to enforce a standard footer for all calendars.</p>
<p class="CommentLine">This does not affect the default calendar.</p>
</td>

</tr></tbody>
</table></div>

<h2>Cache:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_MAX_CACHESIZE_CATEGORYNAME">Max Category Name Cache Size:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_MAX_CACHESIZE_CATEGORYNAME" name="MAX_CACHESIZE_CATEGORYNAME" value="<?php echo htmlspecialchars($GLOBALS['Form_MAX_CACHESIZE_CATEGORYNAME'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_MAX_CACHESIZE_CATEGORYNAME">&nbsp;</span></div>
<p class="CommentLine">Cache the list of category names in memory if the calendar has less than or equal to this number.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_CACHE_SUBSCRIBE_LINKS">'Subscribe &amp; Download' Links to Static Files:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_CACHE_SUBSCRIBE_LINKS"><input type="checkbox" id="CheckBox_CACHE_SUBSCRIBE_LINKS" name="CACHE_SUBSCRIBE_LINKS" value="true" onclick="ToggleDependant('CACHE_SUBSCRIBE_LINKS');" onchange="ToggleDependant('CACHE_SUBSCRIBE_LINKS');"<?php echo ($GLOBALS['Form_CACHE_SUBSCRIBE_LINKS'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_CACHE_SUBSCRIBE_LINKS">&nbsp;</span></div>
<p class="CommentLine">When a lot of users subscribe to your calendar via the 'Subscribe &amp; Download' page, this can put a heavy load on your server.</p>
<p class="CommentLine">To avoid this you can enable this feature and either use a server or add-on that supports caching (i.e. Apache 2.2, squid-cache) or you can use a script to periodically retrieve and cache the files linked to from the 'Subscribe &amp; Download' page.</p>
<p class="CommentLine">The 'Subscribe &amp; Download' page will then link to the static files rather than the export page.</p>
<ul>
<li>This also affects the RSS &lt;link&gt; in the HTML header.</li>
<li>Enabling this feature does not stop users from accessing the export page.</li>
<li>This has no effect on calendars that require users to login before viewing events.</li>
</ul>
<p class="CommentLine">For detailed instructions see <a href="http://vtcalendar.sourceforge.net/jump.php?name=cachesubscribe" target="_blank">http://vtcalendar.sourceforge.net/jump.php?name=cachesubscribe</a></p>

<div id="Dependants_CACHE_SUBSCRIBE_LINKS"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_CACHE_SUBSCRIBE_LINKS_PATH">URL Extension to Static Files:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_CACHE_SUBSCRIBE_LINKS_PATH" name="CACHE_SUBSCRIBE_LINKS_PATH" value="<?php echo htmlspecialchars($GLOBALS['Form_CACHE_SUBSCRIBE_LINKS_PATH'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_CACHE_SUBSCRIBE_LINKS_PATH">&nbsp;</span></div>
<p class="CommentLine">The path from the VTCalendar URL to the static 'Subscribe &amp; Download' files.</p>
<p class="CommentLine">It will be appended to the BASEURL (e.g. <code>http://localhost/vtcalendar/cache/subscribe/</code>)</p>
<p class="CommentLine">Must end with a slash.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR">Static Files Output Directory:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR" name="CACHE_SUBSCRIBE_LINKS_OUTPUTDIR" value="<?php echo htmlspecialchars($GLOBALS['Form_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_CACHE_SUBSCRIBE_LINKS_OUTPUTDIR">&nbsp;</span></div>
<p class="CommentLine">The directory path where the static 'Subscribe &amp; Download' files will be outputted by the <code>./cache/export</code> script.</p>
<p class="CommentLine">Must be an absolute path (e.g. <code>/var/www/htdocs/vtcalendar/cache/subscribe/</code>).</p>
<p class="CommentLine">Must end with a slash.</p>
</td>
</tr></tbody>
</table></div>
<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("CACHE_SUBSCRIBE_LINKS");
/* ]]> */</script>
</td>

</tr></tbody>
</table></div>

<h2>Export:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_EXPORT_PATH">Export Path:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EXPORT_PATH" name="EXPORT_PATH" value="<?php echo htmlspecialchars($GLOBALS['Form_EXPORT_PATH'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EXPORT_PATH">&nbsp;</span></div>
<p class="CommentLine">The URL extension to the export script. Must NOT being with a slash (/).</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_MAX_EXPORT_EVENTS">Maximum Exported Events:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_MAX_EXPORT_EVENTS" name="MAX_EXPORT_EVENTS" value="<?php echo htmlspecialchars($GLOBALS['Form_MAX_EXPORT_EVENTS'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_MAX_EXPORT_EVENTS">&nbsp;</span></div>
<p class="CommentLine">The maximum number of events that can be exported using the subscribe, download or export pages.</p>
<p class="CommentLine">Calendar and main admins can export all data using the VTCalendar (XML) format.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_EXPORT_CACHE_MINUTES">Export Data Lifetime (in minutes):</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EXPORT_CACHE_MINUTES" name="EXPORT_CACHE_MINUTES" value="<?php echo htmlspecialchars($GLOBALS['Form_EXPORT_CACHE_MINUTES'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EXPORT_CACHE_MINUTES">&nbsp;</span></div>
<p class="CommentLine">The number of minutes that a browser will be told to cache exported data.</p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_PUBLIC_EXPORT_VTCALXML">Allow Public to Export in VTCalendar (XML) Format:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_PUBLIC_EXPORT_VTCALXML"><input type="checkbox" id="CheckBox_PUBLIC_EXPORT_VTCALXML" name="PUBLIC_EXPORT_VTCALXML" value="true"<?php echo ($GLOBALS['Form_PUBLIC_EXPORT_VTCALXML'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_PUBLIC_EXPORT_VTCALXML">&nbsp;</span></div>
<p class="CommentLine">The VTCalendar (XML) export format contains all information about an event, which you may not want to allow the public to view.</p>
<p class="CommentLine">However, users that are part of the admin sponsor, or are main admins, can always export in this format.</p>
</td>

</tr></tbody>
</table></div>

<h2>E-Mail:</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="CheckBox_EMAIL_USEPEAR">Send E-mail via Pear::Mail:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_EMAIL_USEPEAR"><input type="checkbox" id="CheckBox_EMAIL_USEPEAR" name="EMAIL_USEPEAR" value="true" onclick="ToggleDependant('EMAIL_USEPEAR');" onchange="ToggleDependant('EMAIL_USEPEAR');"<?php echo ($GLOBALS['Form_EMAIL_USEPEAR'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_EMAIL_USEPEAR">&nbsp;</span></div>
<p class="CommentLine">Send e-mail using Pear::Mail rather than the built-in PHP Mail function.</p>
<p class="CommentLine">This should be used if you are on Windows or do not have sendmail installed.</p>
<div id="Dependants_EMAIL_USEPEAR"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_EMAIL_SMTP_HOST">SMTP Host:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EMAIL_SMTP_HOST" name="EMAIL_SMTP_HOST" value="<?php echo htmlspecialchars($GLOBALS['Form_EMAIL_SMTP_HOST'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EMAIL_SMTP_HOST">&nbsp;</span></div>
<p class="CommentLine">The SMTP host name to connect to.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_EMAIL_SMTP_PORT">SMTP Port:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EMAIL_SMTP_PORT" name="EMAIL_SMTP_PORT" value="<?php echo htmlspecialchars($GLOBALS['Form_EMAIL_SMTP_PORT'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EMAIL_SMTP_PORT">&nbsp;</span></div>
<p class="CommentLine">The SMTP port number to connect to.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="CheckBox_EMAIL_SMTP_AUTH">SMTP Authentication:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><label for="CheckBox_EMAIL_SMTP_AUTH"><input type="checkbox" id="CheckBox_EMAIL_SMTP_AUTH" name="EMAIL_SMTP_AUTH" value="true" onclick="ToggleDependant('EMAIL_SMTP_AUTH');" onchange="ToggleDependant('EMAIL_SMTP_AUTH');"<?php echo ($GLOBALS['Form_EMAIL_SMTP_AUTH'] == 'true')? $chk : ''; ?> /> Yes</label>
<span id="DataFieldInputExtra_EMAIL_SMTP_AUTH">&nbsp;</span></div>
<p class="CommentLine">Whether or not to use SMTP authentication.</p>
<div id="Dependants_EMAIL_SMTP_AUTH"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_EMAIL_SMTP_USERNAME">SMTP Username:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EMAIL_SMTP_USERNAME" name="EMAIL_SMTP_USERNAME" value="<?php echo htmlspecialchars($GLOBALS['Form_EMAIL_SMTP_USERNAME'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EMAIL_SMTP_USERNAME">&nbsp;</span></div>
<p class="CommentLine">The username to use for SMTP authentication.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_EMAIL_SMTP_PASSWORD">SMTP Password:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EMAIL_SMTP_PASSWORD" name="EMAIL_SMTP_PASSWORD" value="<?php echo htmlspecialchars($GLOBALS['Form_EMAIL_SMTP_PASSWORD'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EMAIL_SMTP_PASSWORD">&nbsp;</span></div>
<p class="CommentLine">The password to use for SMTP authentication.</p>
</td>
</tr></tbody>
</table></div>
<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("EMAIL_SMTP_AUTH");
/* ]]> */</script>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_EMAIL_SMTP_HELO">SMTP EHLO/HELO:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EMAIL_SMTP_HELO" name="EMAIL_SMTP_HELO" value="<?php echo htmlspecialchars($GLOBALS['Form_EMAIL_SMTP_HELO'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EMAIL_SMTP_HELO">&nbsp;</span></div>
<p class="CommentLine">The value to give when sending EHLO or HELO.</p>
</td>
</tr><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_EMAIL_SMTP_TIMEOUT">SMTP Timeout:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_EMAIL_SMTP_TIMEOUT" name="EMAIL_SMTP_TIMEOUT" value="<?php echo htmlspecialchars($GLOBALS['Form_EMAIL_SMTP_TIMEOUT'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_EMAIL_SMTP_TIMEOUT">&nbsp;</span></div>
<p class="CommentLine">The SMTP connection timeout.</p>
<p class="CommentLine">Set the value to 0 to have no timeout.</p>
</td>
</tr></tbody>
</table></div>
<script type="text/javascript">/* <![CDATA[ */
ToggleDependant("EMAIL_USEPEAR");
/* ]]> */</script>
</td>

</tr></tbody>
</table></div>
