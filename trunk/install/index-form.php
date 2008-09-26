<?php if (!defined("ALLOWINCLUDES")) exit; ?>

<h2>General:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Title Prefix:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="TITLEPREFIX" value="" size="60"/>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Added at the beginning of the &lt;title&gt; tag.</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Title Suffix:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="TITLESUFFIX" value="" size="60"/>
                     <br/>
                     <i>Example: " - My University"</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Added at the end of the &lt;title&gt; tag.</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Language:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="LANGUAGE" value="en" size="60"/>
                     <br/>
                     <i>Example: en, de</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Language used (refers to language file in directory /languages)</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>Database:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Database Connection String:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="DATABASE" value="" size="60"/>
                     <br/>
                     <i>Example: mysql://vtcal:abc123@localhost/vtcalendar</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">This is the database connection string used by the PEAR library.<br/>It has the format: "mysql://user:password@host/databasename" or "postgres://user:password@host/databasename"</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>SQL Log File:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="SQLLOGFILE" value="" size="60"/>
                     <br/>
                     <i>Example: /var/log/vtcalendarsql.log</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Put a name of a (folder and) file where the calendar logs every SQL query to the database.<br/>This is good for debugging but make sure you write into a file that's not readable by the webserver or else you may expose private information.<br/>If left blank ("") no log will be kept. That's the default.</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>Authentication:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>User ID Regular Expression:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="REGEXVALIDUSERID" value="/^[A-Za-z][\._A-Za-z0-9\-\\]{1,49}$/" size="60"/>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">This regular expression defines what is considered a valid user-ID.</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Database Authentication:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_AUTH_DB" name="AUTH_DB" value="true"
									onclick="ToggleDependant('AUTH_DB');" onchange="ToggleDependant('AUTH_DB');" checked="checked"/><label for="CheckBox_AUTH_DB"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Authenticate users against the database.<br/>If enabled, this is always performed before any other authentication.</td>
               </tr>
               <tr id="Dependants_AUTH_DB">
                  <td>
                     <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Prefix for Database Usernames:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="AUTH_DB_USER_PREFIX" value="" size="60"/>
                                       <br/>
                                       <i>Example: db_</i>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."<br/>If you only use auth_db just leave it an empty string.<br/>Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Database Authentication Notice:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="AUTH_DB_NOTICE" value="" size="60"/>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">This displays a text (or nothing) on the Update tab behind the user user management options.<br/>It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users know that they should create local users only if they are not in the LDAP.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Create Main Admin Account:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField"><input type="checkbox" id="CheckBox_AUTH_DB_CREATEADMIN" name="AUTH_DB_CREATEADMIN" value="true"
									onclick="ToggleDependant('AUTH_DB_CREATEADMIN');" onchange="ToggleDependant('AUTH_DB_CREATEADMIN');" checked="checked"/><label for="CheckBox_AUTH_DB_CREATEADMIN"> Yes</label>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">If the database has not yet been populated, you will need to create a main admin account in order to administer the calendar.<br/>However, if you are using LDAP or HTTP authentication this will not be necessary assuming you specify main admin account names under those sections.</td>
                                 </tr>
                                 <tr id="Dependants_AUTH_DB_CREATEADMIN">
                                    <td>
                                       <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                                          <tr>
                                             <td class="VariableName" nowrap="nowrap" valign="top">
                                                <b>Main Admin Username:</b>
                                             </td>
                                             <td class="VariableBody">
                                                <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                                   <tr>
                                                      <td class="DataField">
                                                         <input type="text" name="AUTH_DB_CREATEADMIN_USERNAME" value="" size="60"/>
                                                         <br/>
                                                         <i>Example: root</i>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="Comment"/>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td class="VariableName" nowrap="nowrap" valign="top">
                                                <b>Main Admin Password:</b>
                                             </td>
                                             <td class="VariableBody">
                                                <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                                   <tr>
                                                      <td class="DataField">
                                                         <input type="text" name="AUTH_DB_CREATEADMIN_PASSWORD" value="" size="60"/>
                                                         <br/>
                                                         <i>Example: root</i>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="Comment"/>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <script type="text/javascript">ToggleDependant('AUTH_DB_CREATEADMIN');</script>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     <script type="text/javascript">ToggleDependant('AUTH_DB');</script>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>LDAP Authentication:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_AUTH_LDAP" name="AUTH_LDAP" value="true"
									onclick="ToggleDependant('AUTH_LDAP');" onchange="ToggleDependant('AUTH_LDAP');"/><label for="CheckBox_AUTH_LDAP"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Authenticate users against a LDAP server.<br/>If enabled, HTTP authenticate will be ignored.</td>
               </tr>
               <tr id="Dependants_AUTH_LDAP">
                  <td>
                     <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>LDAP Host Name:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_HOST" value="" size="60"/>
                                       <br/>
                                       <i>Example: directory.myuniversity.edu or ldap://directory.myuniversity.edu/ or ldaps://secure-directory.myuniversity.edu/</i>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">If you are using OpenLDAP 2.x.x you can specify a URL ('ldap://host/') instead of the hostname ('host').</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>LDAP Port:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_PORT" value="389" size="60"/>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">The port to connect to. Ignored if LDAP Host Name is a URL.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>LDAP Username Attribute:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_USERFIELD" value="" size="60"/>
                                       <br/>
                                       <i>Example: sAMAccountName</i>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">The attribute which contains the username.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>LDAP Base DN:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_BASE_DN" value="" size="60"/>
                                       <br/>
                                       <i>Example: DC=myuniversity,DC=edu</i>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment"/>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Additional LDAP Search Filter:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_SEARCH_FILTER" value="" size="60"/>
                                       <br/>
                                       <i>Example: (objectClass=person)</i>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">An optional filter to add to the LDAP search.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>LDAP Search Bind Username.:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_BIND_USER" value="" size="60"/>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">Before authenticating the user, we first check if the username exists.<br/>If your LDAP server does not allow anonymous connections, specific a username here.<br/>Leave this blank to connect anonymously.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>LDAP Search Bind Password:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="LDAP_BIND_PASSWORD" value="" size="60"/>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">Before authenticating the user, we first check if the username exists.<br/>If your LDAP server does not allow anonymous connections, specific a password here.<br/>Leave this blank to connect anonymously.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     <script type="text/javascript">ToggleDependant('AUTH_LDAP');</script>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>HTTP Authentication:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_AUTH_HTTP" name="AUTH_HTTP" value="true"
									onclick="ToggleDependant('AUTH_HTTP');" onchange="ToggleDependant('AUTH_HTTP');"/><label for="CheckBox_AUTH_HTTP"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Authenticate users by sending an HTTP request to a server.<br/>A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.<br/>If LDAP authentication is enabled, this will be ignored.</td>
               </tr>
               <tr id="Dependants_AUTH_HTTP">
                  <td>
                     <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>HTTP Authorizaton URL:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="AUTH_HTTP_URL" value="" size="60"/>
                                       <br/>
                                       <i>Example: http://localhost/customauth.php</i>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">The URL to use for the BASIC HTTP Authentication.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     <script type="text/javascript">ToggleDependant('AUTH_HTTP');</script>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>Cookies:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Cookie Base URL:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="BASEPATH" value="" size="60"/>
                     <br/>
                     <i>Example: /calendar/</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">If you are hosting more than one VTCalendar on your server, you may want to set this to this calendar's base URL.<br/>Otherwise, the cookie will be submitted with a default path.<br/>This must start and end with a forward slash (/), unless the it is exactly "/".</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Cookie Host Name:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="BASEDOMAIN" value="" size="60"/>
                     <br/>
                     <i>Example: localhost</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">If you are hosting more than one VTCalendar on your server, you may want to set this to your server's host name.<br/>Otherwise, the cookie will be submitted with a default host name.</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>URL:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Calendar Base URL:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="BASEURL" value="" size="60"/>
                     <br/>
                     <i>Example: http://localhost/calendar/</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">This is the absolute URL where your calendar software is located.<br/>This MUST end with a slash "/"</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Secure Calendar Base URL:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="SECUREBASEURL" value="" size="60"/>
                     <br/>
                     <i>Example: https://localhost/calendar/</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">This is the absolute path where the secure version of the calendar is located.<br/>If you are not using URL, set this to the same address as BASEURL.<br/>This MUST end with a slash "/"</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>Date/Time:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Timezone Offset:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="TIMEZONE_OFFSET" value="5" size="60"/>
                     <br/>
                     <i>Example: -5</i>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Defines the offset to GMT, can be positive or negative</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Week Starting Day:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="WEEK_STARTING_DAY" value="0" size="60"/>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">defines the week starting day - allowable values - 0 for "Sunday" or 1 for "Monday"</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Use AM/PM:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_USE_AMPM" name="USE_AMPM" value="true"
									 checked="checked"/><label for="CheckBox_USE_AMPM"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">defines time format e.g. 1am-11pm (true) or 1:00-23:00 (false)</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>Display:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Column Position:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="COLUMNSIDE" value="LEFT" size="60"/>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Which side the little calendar, 'jump to', 'today is', etc. will be on.<br/>Values must be LEFT or RIGHT.</td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Show Upcoming Tab:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_SHOW_UPCOMING_TAB" name="SHOW_UPCOMING_TAB" value="true"
									onclick="ToggleDependant('SHOW_UPCOMING_TAB');" onchange="ToggleDependant('SHOW_UPCOMING_TAB');" checked="checked"/><label for="CheckBox_SHOW_UPCOMING_TAB"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Whether or not the upcoming tab will be shown.</td>
               </tr>
               <tr id="Dependants_SHOW_UPCOMING_TAB">
                  <td>
                     <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Max Upcoming Events:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="MAX_UPCOMING_EVENTS" value="75" size="60"/>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">Whether or not the upcoming tab will be shown.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     <script type="text/javascript">ToggleDependant('SHOW_UPCOMING_TAB');</script>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Show Month Overlap:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_SHOW_MONTH_OVERLAP" name="SHOW_MONTH_OVERLAP" value="true"
									 checked="checked"/><label for="CheckBox_SHOW_MONTH_OVERLAP"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Whether or not events in month view on days that are not actually part of the current month should be shown.<br/>For example, if the first day of the month starts on a Wednesday, then Sunday-Tuesday are from the previous month.<br/>Values must be true or false.</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
<h2>Cache:</h2>
<blockquote>
   <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>HTTP Authentication Cache:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField"><input type="checkbox" id="CheckBox_AUTH_HTTP_CACHE" name="AUTH_HTTP_CACHE" value="true"
									onclick="ToggleDependant('AUTH_HTTP_CACHE');" onchange="ToggleDependant('AUTH_HTTP_CACHE');"/><label for="CheckBox_AUTH_HTTP_CACHE"> Yes</label>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Cache successful HTTP authentication attempts as hashes in DB.<br/>This acts as a failover if the HTTP authentication fails due to a server error.</td>
               </tr>
               <tr id="Dependants_AUTH_HTTP_CACHE">
                  <td>
                     <table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>HTTP Authentication Cache Expiration:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <input type="text" name="AUTH_HTTP_CACHE_EXPIRATIONDAYS" value="4" size="60"/>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">The number of days in which data in the HTTP authentication cache is valid.</td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                     </table>
                     <script type="text/javascript">ToggleDependant('AUTH_HTTP_CACHE');</script>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td class="VariableName" nowrap="nowrap" valign="top">
            <b>Max Category Name Cache Size:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <input type="text" name="MAX_CACHESIZE_CATEGORYNAME" value="100" size="60"/>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">Cache the list of category names in memory if the calendar has less than or equal to this number.</td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
