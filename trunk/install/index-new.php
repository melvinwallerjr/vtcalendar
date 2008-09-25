<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>VTCalendar Configuration</title>
<style type="text/css">
body, th, td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
}

h1 {
	font-size: 24px;
	padding-bottom: 8px;
	border-bottom: 2px solid #333333;
}
h2 {
	font-size: 16px;
	padding: 6px;
	background-color: #CCDBFF;
	border-top: 1px solid #666666;
}
table.VariableTable {
	border-right: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
}
td.VariableName {
	background-color: #EEEEEE;
}
td.VariableName, td.VariableBody {
	border-top: 1px solid #CCCCCC;
	border-left: 1px solid #CCCCCC;
}
td.DataField {
	padding-top: 0;
}
td.Comment {
	padding-top: 0;
}
/*tr.VariableRow td {
	border-top: 1px solid #CCCCCC;
}
.Variable {
	background-color: #EEEEEE;
	font-weight: bold;
}
tr.CommentRow td {
	padding-top: 0;
	padding-bottom: 8px;
}
.DependantCell {
	padding-bottom: 8px;
}
.DependantTable {
	border: 1px solid #666666;
	background-color: #EEEEEE;
}*/
</style>
</head>

<body>
<p>// Config: Show Upcoming Tab<br>
	// Whether or not the upcoming tab will be shown.<br>
	if (!defined(&quot;SHOW_UPCOMING_TAB&quot;)) define(&quot;SHOW_UPCOMING_TAB&quot;, TRUE);</p>
<h1>VTCalendar Configuration: </h1>
<form name="form1" method="post" action="">
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Title Prefix:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value=""></td>
            </tr>
            <tr>
               <td class="Comment">Added at the beginning of the &lt;title&gt; tag.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Title Suffix:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value=""> <i>Example: " - My University"</i></td>
            </tr>
            <tr>
               <td class="Comment">Added at the end of the &lt;title&gt; tag.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Language:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="&#34;en&#34;"> <i>Example: en, de</i></td>
            </tr>
            <tr>
               <td class="Comment">Language used (refers to language file in directory /languages)</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Database Connection String:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="&#34;mysql://root:@localhost/vtcalendar&#34;"></td>
            </tr>
            <tr>
               <td class="Comment">This is the database connection string used by the PEAR library.It has the format: "mysql://user:password@host/databasename" or "postgres://user:password@host/databasename"</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>SQL Log File:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value=""> <i>Example: /var/log/vtcalendarsql.log</i></td>
            </tr>
            <tr>
               <td class="Comment">Put a name of a (folder and) file where the calendar logs everySQL query to the database. This is good for debugging but makesure you write into a file that's not readable by the webserver orelse you may expose private information.If left blank ("") no log will be kept. That's the default.</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>User ID Regular Expression:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="&#34;/^[A-Za-z][\\._A-Za-z0-9\\-\\\\]{1,49}$/&#34;"></td>
            </tr>
            <tr>
               <td class="Comment">This regular expression defines what is considered a valid user-ID.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Database Authentication:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">Authenticate users against the database.If enabled, this is always performed before any other authentication.</td>
            </tr>
            <tr>
               <td>
                  <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>Prefix for Database Usernames:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""> <i>Example: db_</i></td>
                              </tr>
                              <tr>
                                 <td class="Comment">This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."If you only use auth_db just leave it an empty stringIts purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>Database Authentication Notice:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""></td>
                              </tr>
                              <tr>
                                 <td class="Comment">This displays a text (or nothing) on the Update tab behind the user user management optionsIt could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let usersknow that they should create local users only if they are not in the LDAP.</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>LDAP Authentication:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">Authenticate users against a LDAP server.If enabled, HTTP authenticate will be ignored.</td>
            </tr>
            <tr>
               <td>
                  <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>LDAP Host Name:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""></td>
                              </tr>
                              <tr>
                                 <td class="Comment"></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>LDAP Port:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value="389"></td>
                              </tr>
                              <tr>
                                 <td class="Comment"></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>LDAP Username Attribute:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""> <i>Example: sAMAccountName</i></td>
                              </tr>
                              <tr>
                                 <td class="Comment">The attribute which contains the username.</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>LDAP Base DN:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""> <i>Example: DC=myuniversity,DC=edu</i></td>
                              </tr>
                              <tr>
                                 <td class="Comment"></td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>Additional LDAP Search Filter:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""> <i>Example: (objectClass=person)</i></td>
                              </tr>
                              <tr>
                                 <td class="Comment">An optional filter to add to the LDAP search.</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>LDAP Search Bind Username.:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""></td>
                              </tr>
                              <tr>
                                 <td class="Comment">Before authenticating the user, we first check if the username exists.If your LDAP server does not allow anonymous connections, specific a username here.Leave this blank to connect anonymously.</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>LDAP Search Bind Password:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""></td>
                              </tr>
                              <tr>
                                 <td class="Comment">Before authenticating the user, we first check if the username exists.If your LDAP server does not allow anonymous connections, specific a password here.Leave this blank to connect anonymously.</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>HTTP Authentication:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">Authenticate users by sending an HTTP request to a server.A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.If LDAP authentication is enabled, this will be ignored.</td>
            </tr>
            <tr>
               <td>
                  <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                     <tr>
                        <td class="VariableName" nowrap valign="top"><b>HTTP Authorizaton URL:</b></td>
                        <td class="VariableBody">
                           <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                              <tr>
                                 <td class="DataField"><input type="text" name="XX" value=""> <i>Example: http://localhost/customauth.php</i></td>
                              </tr>
                              <tr>
                                 <td class="Comment">The URL to use for the BASIC HTTP Authentication.</td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>HTTP Authentication Cache:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">Cache successful HTTP authentication attempts as hashes in DB.This acts as a failover if the HTTP authentication fails due to a server error.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>HTTP Authentication Cache Expiration:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="4"></td>
            </tr>
            <tr>
               <td class="Comment">The number of days in which data in the HTTP authentication cache is valid.</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Cookie Base URL:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value=""> <i>Example: /calendar/</i></td>
            </tr>
            <tr>
               <td class="Comment">If you are hosting more than one VTCalendar on your server, you may want to set this to this calendar's base URL.Otherwise, the cookie will be submitted with a default path.This must start and end with a forward slash (/), unless the it is exactly "/".</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Cookie Host Name:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value=""> <i>Example: localhost</i></td>
            </tr>
            <tr>
               <td class="Comment">If you are hosting more than one VTCalendar on your server, you may want to set this to your server's host name.Otherwise, the cookie will be submitted with a default host name.</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Calendar Base URL:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value=""> <i>Example: http://localhost/calendar/</i></td>
            </tr>
            <tr>
               <td class="Comment">This is the absolute URL where your calendar software is located.This MUST end with a slash "/"</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Secure Calendar Base URL:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="BASEURL"> <i>Example: https://localhost/calendar/</i></td>
            </tr>
            <tr>
               <td class="Comment">This is the absolute path where the secure version of the calendar is located.If you are not using URL, set this to the same address as BASEURL.This MUST end with a slash "/"</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Timezone Offset:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="5"> <i>Example: -5</i></td>
            </tr>
            <tr>
               <td class="Comment">Defines the offset to GMT, can be positive or negative</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Week Starting Day:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="0"></td>
            </tr>
            <tr>
               <td class="Comment">defines the week starting day - allowable values - 0 for "Sunday" or 1 for "Monday"</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Use AM/PM:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">defines time format e.g. 1am-11pm (TRUE) or 1:00-23:00 (FALSE)</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Column Position:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="&#34;LEFT&#34;"></td>
            </tr>
            <tr>
               <td class="Comment">Which side the little calendar, 'jump to', 'today is', etc. will be on.Values must be LEFT or RIGHT.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Show Upcoming Tab:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">Whether or not the upcoming tab will be shown.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Max Upcoming Events:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="75"></td>
            </tr>
            <tr>
               <td class="Comment">Whether or not the upcoming tab will be shown.</td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Show Month Overlap:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="checkbox" name="XX"> Yes
               </td>
            </tr>
            <tr>
               <td class="Comment">Whether or not events in month view on days that are not actually part of the current month should be shown.For example, if the first day of the month starts on a Wednesday, then Sunday-Tuesday are from the previous month.Values must be TRUE or FALSE.</td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<h2>General</h2>
<table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
   <tr>
      <td class="VariableName" nowrap valign="top"><b>Max Category Name Cache Size:</b></td>
      <td class="VariableBody">
         <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
            <tr>
               <td class="DataField"><input type="text" name="XX" value="100"></td>
            </tr>
            <tr>
               <td class="Comment">Cache the list of category names in memory if the calendar has less than or equal to this number.</td>
            </tr>
         </table>
      </td>
   </tr>
</table>

	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<h2>General</h2>
	<table  border="0" cellspacing="0" cellpadding="6">
    	<tr class="VariableRow">
    		<td class="Variable">Title Prefix:</td>
    		<td><input type="text" name="textfield"></td>
	    </tr>
    	<tr class="CommentRow">
    		<td class="Variable">&nbsp;</td>
    		<td>Added at the beginning of the &lt;title&gt; tag.</td>
   		</tr>
    	<tr class="VariableRow">
    		<td class="Variable">Title Suffix:</td>
    		<td><input type="text" name="textfield">
   			    <i>Example: &quot; - My University&quot;</i></td>
	    </tr>
    	<tr class="CommentRow">
    		<td class="Variable">&nbsp;</td>
    		<td>Added at the end of the &lt;title&gt; tag.</td>
   		</tr>
    	<tr class="VariableRow">
    		<td class="Variable">Language:</td>
    		<td><input name="textfield" type="text" value="en"></td>
	    </tr>
    	<tr class="CommentRow">
    		<td class="Variable">&nbsp;</td>
    		<td>Language used (refers to language file in directory /languages)</td>
	    </tr>
    	</table>
    <h2>Authentication</h2>
    <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
    	<tr>
    		<td class="VariableName" valign="top"><b>User ID Regular Expression:</b></td>
    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
            	<tr>
            		<td class="DataField"><input type="text" name="textfield"></td>
            	</tr>
            	<tr>
            		<td class="Comment">Authenticate users against the database.<br>
If enabled, this is always performed before any other authentication.</td>
            		</tr>
            	</table></td>
   		</tr>
    	<tr>
    		<td class="VariableName" valign="top"><b>Database Authentication:</b></td>
    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
            	<tr>
            		<td class="DataField"><input type="checkbox" name="checkbox" value="checkbox">
Yes</td>
            		</tr>
            	<tr>
            		<td class="Comment">Authenticate users against the database.<br>
If enabled, this is always performed before any other authentication.</td>
            		</tr>
            	<tr>
            		<td><table  border="0" cellpadding="6" cellspacing="0" class="VariableTable">
                    	<tr>
                    		<td valign="top" class="VariableName"><b>Prefix for Database Usernames:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                            	<tr>
                            		<td class="DataField"><input name="textfield" type="text">
                                        <i>Example: db_</i></td>
                            		</tr>
                            	<tr>
                            		<td class="Comment">This prefix is used when creating/editing a local user-ID (in the DB &quot;user&quot; table), e.g. &quot;calendar.&quot;<br>
If you only use auth_db just leave it an empty string<br>
Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP</td>
                            		</tr>
                            	</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>Database Authentication Notice:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                            	<tr>
                            		<td class="DataField"><input name="textfield" type="text"></td>
                            		</tr>
                            	<tr>
                            		<td class="Comment">This displays a text (or nothing) on the Update tab behind the user user management options<br>
It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users<br>
know that they should create local users only if they are not in the LDAP.</td>
                            		</tr>
                            	</table></td>
                    		</tr>
                    	</table></td>
            		</tr>
            	</table></td>
   		</tr>
    	<tr>
    		<td valign="top" class="VariableName"><b>LDAP Authentication:</b></td>
    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
            	<tr>
            		<td class="DataField"><input type="checkbox" name="checkbox" value="checkbox">
			Yes</td>
            		</tr>
            	<tr>
            		<td class="Comment">Authenticate users against the database.<br>
			If enabled, this is always performed before any other authentication.</td>
            		</tr>
            	<tr>
            		<td><table border="0" cellpadding="4" cellspacing="0" class="VariableTable">
                    	<tr>
                    		<td valign="top" class="VariableName"><b>LDAP Host Name:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                    				<tr>
                    					<td class="DataField"><input name="textfield" type="text"></td>
                    					</tr>
                    				</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>LDAP Port:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                    				<tr>
                    					<td class="DataField"><input name="textfield" type="text"></td>
                    					</tr>
                    				</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>LDAP Username Attribute:</b></td>
                    		<td class="VariableBody"><i> </i>
                        			<table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                        				<tr>
                        					<td class="DataField"><input name="textfield" type="text">
                            						<i>Example: sAMAccountName</i> </td>
                        					</tr>
                        				</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>LDAP Base DN:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                    				<tr>
                    					<td class="DataField"><input name="textfield" type="text">
                        						<i>Example: sAMAccountName</i> </td>
                    					</tr>
                    				</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>Additional LDAP Search Filter:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                    				<tr>
                    					<td class="DataField"><input name="textfield" type="text">
                        						<i>Example: sAMAccountName</i> </td>
                    					</tr>
                    				<tr>
                    					<td class="Comment">An optional filter to add to the LDAP search.</td>
                    					</tr>
                    				</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>LDAP Search Bind Username:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                    				<tr>
                    					<td class="DataField"><input name="textfield" type="text"></td>
                    					</tr>
                    				<tr>
                    					<td class="Comment">Before authenticating the user, we first check if the username exists.<br>
						If your LDAP server does not allow anonymous connections, specific a username here.<br>
						Leave this blank to connect anonymously.</td>
                    					</tr>
                    				</table></td>
                    		</tr>
                    	<tr>
                    		<td valign="top" class="VariableName"><b>LDAP Search Bind Password:</b></td>
                    		<td class="VariableBody"><table class="ContentTable" width="100%"  border="0" cellspacing="0" cellpadding="6">
                    				<tr>
                    					<td class="DataField"><input name="textfield" type="text"></td>
                    					</tr>
                    				<tr>
                    					<td class="Comment">Before authenticating the user, we first check if the username exists.<br>
						If your LDAP server does not allow anonymous connections, specific a password here.<br>
						Leave this blank to connect anonymously.</td>
                    					</tr>
                    				</table></td>
                    		</tr>
                    	</table></td>
            		</tr>
            	</table>
   			</td>
   		</tr>
    	</table>
    <p>&nbsp;</p>
    <table  border="0" cellspacing="0" cellpadding="6">
    	<tr class="VariableRow">
    		<td class="Variable">User ID Regular Expression:</td>
    		<td><input type="text" name="textfield"></td>
   		</tr>
    	<tr class="CommentRow">
    		<td class="Variable">&nbsp;</td>
    		<td>Authenticate users against the database.<br>
   			 If enabled, this is always performed before any other authentication.</td>
   		</tr>
    	<tr class="VariableRow">
    		<td class="Variable">Database Authentication:</td>
    		<td>    			<input type="checkbox" name="checkbox" value="checkbox">    			Yes</td>
   		</tr>
    	<tr class="CommentRow">
    		<td class="Variable">&nbsp;</td>
    		<td>Authenticate users against the database.<br>
   			If enabled, this is always performed before any other authentication.</td>
   		</tr>
    	<tr>
    		<td class="Variable">&nbsp;</td>
    		<td class="DependantCell"><table border="0" cellspacing="0" cellpadding="6">
    			<tr class="VariableRow">
                	<td class="Variable"><b>Prefix for Database Usernames:</b></td>
                	<td><input name="textfield" type="text">
                    		<i>Example: db_</i></td>
    				</tr>
    			<tr class="CommentRow">
                	<td class="Variable">&nbsp;</td>
                	<td>This prefix is used when creating/editing a local user-ID (in the DB &quot;user&quot; table), e.g. &quot;calendar.&quot;<br>
		If you only use auth_db just leave it an empty string<br>
		Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP</td>
    				</tr>
            	<tr class="VariableRow">
            		<td class="Variable"><b>Database Authentication Notice:</b></td>
            		<td><input name="textfield" type="text"></td>
            		</tr>
            	<tr class="CommentRow">
            		<td class="Variable">&nbsp;</td>
            		<td>This displays a text (or nothing) on the Update tab behind the user user management options<br>
            			It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users<br>
           			    know that they should create local users only if they are not in the LDAP.</td>
            		</tr>
            	</table></td>
   		</tr>
    	<tr class="VariableRow">
        	<td class="Variable">LDAP Authentication:</td>
        	<td><input type="checkbox" name="checkbox" value="checkbox">
		Yes</td>
   		</tr>
    	<tr class="CommentRow">
        	<td class="Variable">&nbsp;</td>
        	<td>Authenticate users against a LDAP server.<br>
       		If enabled, HTTP authenticate will be ignored.</td>
   		</tr>
    	<tr>
        	<td class="Variable">&nbsp;</td>
        	<td class="DependantCell"><table border="0" cellspacing="0" cellpadding="4">
        			<tr>
        				<td>LDAP Host Name:</td>
        				<td><input name="textfield" type="text"></td>
       				</tr>
        			<tr>
                    	<td><b>LDAP Port:</b></td>
                    	<td><input name="textfield" type="text"></td>
       				</tr>
        			<tr>
                    	<td><b>LDAP Username Attribute:</b></td>
                    	<td><input name="textfield" type="text">
                   		<i>                    	Example: sAMAccountName</i></td>
       				</tr>
        			<tr>
                    	<td><b>LDAP Base DN:</b></td>
                    	<td><input name="textfield" type="text">
                        		<i> Example: DC=myuniversity,DC=edu</i></td>
       				</tr>
        			<tr>
                    	<td><b>Additional LDAP Search Filter:</b></td>
                    	<td><input name="textfield" type="text">
                        		<i> Example: (objectClass=person)</i></td>
       				</tr>
        			<tr>
                    	<td>&nbsp;</td>
                    	<td>An optional filter to add to the LDAP search.</td>
       				</tr>
        			<tr>
                    	<td><b>LDAP Search Bind Username:</b></td>
                    	<td><input name="textfield" type="text"></td>
       				</tr>
        			<tr>
                    	<td>&nbsp;</td>
                    	<td>Before authenticating the user, we first check if the username exists.<br>
		If your LDAP server does not allow anonymous connections, specific a username here.<br>
		Leave this blank to connect anonymously.</td>
       				</tr>
        			<tr>
                    	<td><b>LDAP Search Bind Password:</b></td>
                    	<td><input name="textfield" type="text"></td>
       				</tr>
        			<tr>
        				<td>&nbsp;</td>
        				<td>Before authenticating the user, we first check if the username exists.<br>
        					If your LDAP server does not allow anonymous connections, specific a password here.<br>
       					Leave this blank to connect anonymously.</td>
       				</tr>
        			</table></td>
   		</tr>
    	<tr class="CommentRow">
    		<td>&nbsp;</td>
    		<td>&nbsp;</td>
   		</tr>
    	</table>
    <p>&nbsp; </p>
</form>
</body>
</html>
