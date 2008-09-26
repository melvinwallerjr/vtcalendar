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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_TITLEPREFIX" name="TITLEPREFIX" value="" size="60"/>
                        <span id="DataFieldInputExtra_TITLEPREFIX"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Added at the beginning of the &lt;title&gt; tag.</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_TITLESUFFIX" name="TITLESUFFIX" value="" size="60"/>
                        <span id="DataFieldInputExtra_TITLESUFFIX"/>
                     </div>
                     <div class="Example">
                        <i>Example: " - My University"</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Added at the end of the &lt;title&gt; tag.</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_LANGUAGE" name="LANGUAGE" value="en" size="60"/>
                        <span id="DataFieldInputExtra_LANGUAGE"/>
                     </div>
                     <div class="Example">
                        <i>Example: en, de</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Language used (refers to language file in directory /languages)</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_DATABASE" name="DATABASE" value="" size="60"/>
                        <span id="DataFieldInputExtra_DATABASE"/>
                     </div>
                     <div class="Example">
                        <i>Example: mysql://vtcal:abc123@localhost/vtcalendar</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">This is the database connection string used by the PEAR library.</div>
                     <div class="CommentLine">It has the format: "mysql://user:password@host/databasename" or "postgres://user:password@host/databasename"</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_SQLLOGFILE" name="SQLLOGFILE" value="" size="60"/>
                        <span id="DataFieldInputExtra_SQLLOGFILE"/>
                     </div>
                     <div class="Example">
                        <i>Example: /var/log/vtcalendarsql.log</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Put a name of a (folder and) file where the calendar logs every SQL query to the database.</div>
                     <div class="CommentLine">This is good for debugging but make sure you write into a file that's not readable by the webserver or else you may expose private information.</div>
                     <div class="CommentLine">If left blank ("") no log will be kept. That's the default.</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_REGEXVALIDUSERID" name="REGEXVALIDUSERID" value="/^[A-Za-z][\._A-Za-z0-9\-\\]{1,49}$/" size="60"/>
                        <span id="DataFieldInputExtra_REGEXVALIDUSERID"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">This regular expression defines what is considered a valid user-ID.</div>
                  </td>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_AUTH_DB" name="AUTH_DB" value="true"
										onclick="ToggleDependant('AUTH_DB');" onchange="ToggleDependant('AUTH_DB');" checked="checked"/><label for="CheckBox_AUTH_DB"> Yes</label>
                        <span id="DataFieldInputExtra_AUTH_DB"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Authenticate users against the database.</div>
                     <div class="CommentLine">If enabled, this is always performed before any other authentication.</div>
                  </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_AUTH_DB_USER_PREFIX" name="AUTH_DB_USER_PREFIX" value="" size="60"/>
                                          <span id="DataFieldInputExtra_AUTH_DB_USER_PREFIX"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: db_</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">This prefix is used when creating/editing a local user-ID (in the DB "user" table), e.g. "calendar."</div>
                                       <div class="CommentLine">If you only use auth_db just leave it an empty string.</div>
                                       <div class="CommentLine">Its purpose is to avoid name-space conflicts with the users authenticated via LDAP or HTTP.</div>
                                    </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_AUTH_DB_NOTICE" name="AUTH_DB_NOTICE" value="" size="60"/>
                                          <span id="DataFieldInputExtra_AUTH_DB_NOTICE"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">This displays a text (or nothing) on the Update tab behind the user user management options.</div>
                                       <div class="CommentLine">It could be used if you employ both, AUTH_DB and AUTH_LDAP at the same time to let users know that they should create local users only if they are not in the LDAP.</div>
                                    </td>
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
                                    <td class="DataField">
                                       <div class="DataFieldInput"><input type="checkbox" id="CheckBox_AUTH_DB_CREATEADMIN" name="AUTH_DB_CREATEADMIN" value="true"
										onclick="ToggleDependant('AUTH_DB_CREATEADMIN');" onchange="ToggleDependant('AUTH_DB_CREATEADMIN');" checked="checked"/><label for="CheckBox_AUTH_DB_CREATEADMIN"> Yes</label>
                                          <span id="DataFieldInputExtra_AUTH_DB_CREATEADMIN"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">If the database has not yet been populated, you will need to create a main admin account in order to administer the calendar.</div>
                                       <div class="CommentLine">However, if you are using LDAP or HTTP authentication this will not be necessary assuming you specify main admin account names under those sections.</div>
                                    </td>
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
                                                         <div class="DataFieldInput">
                                                            <input type="text" id="Input_AUTH_DB_CREATEADMIN_USERNAME" name="AUTH_DB_CREATEADMIN_USERNAME" value="" size="60"/>
                                                            <span id="DataFieldInputExtra_AUTH_DB_CREATEADMIN_USERNAME"/>
                                                         </div>
                                                         <div class="Example">
                                                            <i>Example: root</i>
                                                         </div>
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
                                                         <div class="DataFieldInput">
                                                            <input type="text" id="Input_AUTH_DB_CREATEADMIN_PASSWORD" name="AUTH_DB_CREATEADMIN_PASSWORD" value="" size="60"/>
                                                            <span id="DataFieldInputExtra_AUTH_DB_CREATEADMIN_PASSWORD"/>
                                                         </div>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_AUTH_LDAP" name="AUTH_LDAP" value="true"
										onclick="ToggleDependant('AUTH_LDAP');" onchange="ToggleDependant('AUTH_LDAP');"/><label for="CheckBox_AUTH_LDAP"> Yes</label>
                        <span id="DataFieldInputExtra_AUTH_LDAP"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Authenticate users against a LDAP server.</div>
                     <div class="CommentLine">If enabled, HTTP authenticate will be ignored.</div>
                  </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_HOST" name="LDAP_HOST" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_HOST"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: directory.myuniversity.edu or ldap://directory.myuniversity.edu/ or ldaps://secure-directory.myuniversity.edu/</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">If you are using OpenLDAP 2.x.x you can specify a URL ('ldap://host/') instead of the hostname ('host').</div>
                                    </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_PORT" name="LDAP_PORT" value="389" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_PORT"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">The port to connect to. Ignored if LDAP Host Name is a URL.</div>
                                    </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_USERFIELD" name="LDAP_USERFIELD" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_USERFIELD"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: sAMAccountName</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">The attribute which contains the username.</div>
                                    </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_BASE_DN" name="LDAP_BASE_DN" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_BASE_DN"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: DC=myuniversity,DC=edu</i>
                                       </div>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_SEARCH_FILTER" name="LDAP_SEARCH_FILTER" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_SEARCH_FILTER"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: (objectClass=person)</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">An optional filter to add to the LDAP search.</div>
                                    </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_BIND_USER" name="LDAP_BIND_USER" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_BIND_USER"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">Before authenticating the user, we first check if the username exists.</div>
                                       <div class="CommentLine">If your LDAP server does not allow anonymous connections, specific a username here.</div>
                                       <div class="CommentLine">Leave this blank to connect anonymously.</div>
                                    </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_BIND_PASSWORD" name="LDAP_BIND_PASSWORD" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_BIND_PASSWORD"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">Before authenticating the user, we first check if the username exists.</div>
                                       <div class="CommentLine">If your LDAP server does not allow anonymous connections, specific a password here.</div>
                                       <div class="CommentLine">Leave this blank to connect anonymously.</div>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Accounts to Add as Main Admins:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_LDAP_MAINADMINS" name="LDAP_MAINADMINS" value="" size="60"/>
                                          <span id="DataFieldInputExtra_LDAP_MAINADMINS"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: bsmith;ajackson</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">A semi-colon (;) delimited list of account names that will be added as main admins.</div>
                                       <div class="CommentLine">No DB accounts will be created for these account names.</div>
                                    </td>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_AUTH_HTTP" name="AUTH_HTTP" value="true"
										onclick="ToggleDependant('AUTH_HTTP');" onchange="ToggleDependant('AUTH_HTTP');"/><label for="CheckBox_AUTH_HTTP"> Yes</label>
                        <span id="DataFieldInputExtra_AUTH_HTTP"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Authenticate users by sending an HTTP request to a server.</div>
                     <div class="CommentLine">A HTTP status code of 200 will authorize the user. Otherwise, they will not be authorized.</div>
                     <div class="CommentLine">If LDAP authentication is enabled, this will be ignored.</div>
                  </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_AUTH_HTTP_URL" name="AUTH_HTTP_URL" value="" size="60"/>
                                          <span id="DataFieldInputExtra_AUTH_HTTP_URL"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: http://localhost/customauth.php</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">The URL to use for the BASIC HTTP Authentication.</div>
                                    </td>
                                 </tr>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td class="VariableName" nowrap="nowrap" valign="top">
                              <b>Accounts to Add as Main Admins:</b>
                           </td>
                           <td class="VariableBody">
                              <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
                                 <tr>
                                    <td class="DataField">
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_AUTH_HTTP_MAINADMINS" name="AUTH_HTTP_MAINADMINS" value="" size="60"/>
                                          <span id="DataFieldInputExtra_AUTH_HTTP_MAINADMINS"/>
                                       </div>
                                       <div class="Example">
                                          <i>Example: bsmith;ajackson</i>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">A semi-colon (;) delimited list of account names that will be added as main admins.</div>
                                       <div class="CommentLine">No DB accounts will be created for these account names.</div>
                                    </td>
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
            <b>Cookie Path:</b>
         </td>
         <td class="VariableBody">
            <table class="ContentTable" width="100%" border="0" cellspacing="0" cellpadding="6">
               <tr>
                  <td class="DataField">
                     <div class="DataFieldInput">
                        <input type="text" id="Input_BASEPATH" name="BASEPATH" value="" size="60"/>
                        <span id="DataFieldInputExtra_BASEPATH"/>
                     </div>
                     <div class="Example">
                        <i>Example: /calendar/</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">If you are hosting more than one VTCalendar on your server, you may want to set this to this calendar's path.</div>
                     <div class="CommentLine">Otherwise, the cookie will be submitted with a default path.</div>
                     <div class="CommentLine">This must start and end with a forward slash (/), unless the it is exactly "/".</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_BASEDOMAIN" name="BASEDOMAIN" value="" size="60"/>
                        <span id="DataFieldInputExtra_BASEDOMAIN"/>
                     </div>
                     <div class="Example">
                        <i>Example: localhost</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">If you are hosting more than one VTCalendar on your server, you may want to set this to your server's host name.</div>
                     <div class="CommentLine">Otherwise, the cookie will be submitted with a default host name.</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_BASEURL" name="BASEURL" value="" size="60"/>
                        <span id="DataFieldInputExtra_BASEURL"/>
                     </div>
                     <div class="Example">
                        <i>Example: http://localhost/calendar/</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">This is the absolute URL where your calendar software is located.</div>
                     <div class="CommentLine">This MUST end with a slash "/"</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_SECUREBASEURL" name="SECUREBASEURL" value="" size="60"/>
                        <span id="DataFieldInputExtra_SECUREBASEURL"/>
                     </div>
                     <div class="Example">
                        <i>Example: https://localhost/calendar/</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">This is the absolute path where the secure version of the calendar is located.</div>
                     <div class="CommentLine">If you are not using URL, set this to the same address as BASEURL.</div>
                     <div class="CommentLine">This MUST end with a slash "/"</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_TIMEZONE_OFFSET" name="TIMEZONE_OFFSET" value="5" size="60"/>
                        <span id="DataFieldInputExtra_TIMEZONE_OFFSET"/>
                     </div>
                     <div class="Example">
                        <i>Example: -5</i>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Defines the offset to GMT, can be positive or negative</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <select name="WEEK_STARTING_DAY" id="Input_WEEK_STARTING_DAY">
                           <option value="0" selected="selected">Sunday (0)</option>
                           <option value="1">Monday (1)</option>
                        </select>
                        <span id="DataFieldInputExtra_WEEK_STARTING_DAY"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Defines the week starting day</div>
                  </td>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_USE_AMPM" name="USE_AMPM" value="true"
										 checked="checked"/><label for="CheckBox_USE_AMPM"> Yes</label>
                        <span id="DataFieldInputExtra_USE_AMPM"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Defines time format e.g. 1am-11pm (true) or 1:00-23:00 (false)</div>
                  </td>
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
                     <div class="DataFieldInput">
                        <select name="COLUMNSIDE" id="Input_COLUMNSIDE">
                           <option value="LEFT" selected="selected">LEFT</option>
                           <option value="RIGHT">RIGHT</option>
                        </select>
                        <span id="DataFieldInputExtra_COLUMNSIDE"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Which side the little calendar, 'jump to', 'today is', etc. will be on.</div>
                  </td>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_SHOW_UPCOMING_TAB" name="SHOW_UPCOMING_TAB" value="true"
										onclick="ToggleDependant('SHOW_UPCOMING_TAB');" onchange="ToggleDependant('SHOW_UPCOMING_TAB');" checked="checked"/><label for="CheckBox_SHOW_UPCOMING_TAB"> Yes</label>
                        <span id="DataFieldInputExtra_SHOW_UPCOMING_TAB"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Whether or not the upcoming tab will be shown.</div>
                  </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_MAX_UPCOMING_EVENTS" name="MAX_UPCOMING_EVENTS" value="75" size="60"/>
                                          <span id="DataFieldInputExtra_MAX_UPCOMING_EVENTS"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">The maximum number of upcoming events displayed.</div>
                                    </td>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_SHOW_MONTH_OVERLAP" name="SHOW_MONTH_OVERLAP" value="true"
										 checked="checked"/><label for="CheckBox_SHOW_MONTH_OVERLAP"> Yes</label>
                        <span id="DataFieldInputExtra_SHOW_MONTH_OVERLAP"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Whether or not events in month view on days that are not actually part of the current month should be shown.</div>
                     <div class="CommentLine">For example, if the first day of the month starts on a Wednesday, then Sunday-Tuesday are from the previous month.</div>
                     <div class="CommentLine">Values must be true or false.</div>
                  </td>
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
                  <td class="DataField">
                     <div class="DataFieldInput"><input type="checkbox" id="CheckBox_AUTH_HTTP_CACHE" name="AUTH_HTTP_CACHE" value="true"
										onclick="ToggleDependant('AUTH_HTTP_CACHE');" onchange="ToggleDependant('AUTH_HTTP_CACHE');"/><label for="CheckBox_AUTH_HTTP_CACHE"> Yes</label>
                        <span id="DataFieldInputExtra_AUTH_HTTP_CACHE"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Cache successful HTTP authentication attempts as hashes in DB.</div>
                     <div class="CommentLine">This acts as a failover if the HTTP authentication fails due to a server error.</div>
                  </td>
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
                                       <div class="DataFieldInput">
                                          <input type="text" id="Input_AUTH_HTTP_CACHE_EXPIRATIONDAYS" name="AUTH_HTTP_CACHE_EXPIRATIONDAYS" value="4" size="60"/>
                                          <span id="DataFieldInputExtra_AUTH_HTTP_CACHE_EXPIRATIONDAYS"/>
                                       </div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="Comment">
                                       <div class="CommentLine">The number of days in which data in the HTTP authentication cache is valid.</div>
                                    </td>
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
                     <div class="DataFieldInput">
                        <input type="text" id="Input_MAX_CACHESIZE_CATEGORYNAME" name="MAX_CACHESIZE_CATEGORYNAME" value="100" size="60"/>
                        <span id="DataFieldInputExtra_MAX_CACHESIZE_CATEGORYNAME"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td class="Comment">
                     <div class="CommentLine">Cache the list of category names in memory if the calendar has less than or equal to this number.</div>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</blockquote>
