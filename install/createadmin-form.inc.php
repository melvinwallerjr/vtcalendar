<?php if (AUTH_DB) { ?>
<h2>Create Account for Database Authentication</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>
<th class="VariableName" nowrap="nowrap"><label for="Input_CREATEADMIN_USERNAME">Main Admin Username:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_CREATEADMIN_USERNAME" name="CREATEADMIN_USERNAME" value="<?php echo htmlspecialchars($GLOBALS['Form_CREATEADMIN_USERNAME'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_CREATEADMIN_USERNAME">&nbsp;</span></div>
<p class="Example"><i>Example:</i> <code>root</code></p>
</td>

</tr><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_CREATEADMIN_PASSWORD">Main Admin Password:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><input type="text" id="Input_CREATEADMIN_PASSWORD" name="CREATEADMIN_PASSWORD" value="<?php echo htmlspecialchars($GLOBALS['Form_CREATEADMIN_PASSWORD'], ENT_COMPAT, 'UTF-8'); ?>" size="60" />
<span id="DataFieldInputExtra_CREATEADMIN_PASSWORD">&nbsp;</span></div>
</td>

</tr></tbody>
</table></div>
<?php } if (AUTH_LDAP || AUTH_HTTP) { ?>
<h2>Grant Access to LDAP or HTTP Accounts</h2>

<div class="pad"><table class="VariableTable" border="0" cellspacing="0" cellpadding="6">
<tbody><tr>

<th class="VariableName" nowrap="nowrap"><label for="Input_MAINADMINS">Accounts to Add as Main Admins:</label></th>
<td class="VariableBody">
<div class="DataFieldInput"><textarea id="Input_MAINADMINS" name="MAINADMINS" rows="15" cols="60"><?php echo htmlspecialchars($GLOBALS['Form_MAINADMINS'], ENT_COMPAT, 'UTF-8'); ?></textarea>
<span id="DataFieldInputExtra_MAINADMINS">&nbsp;</span></div>
<p class="CommentLine">A list of account names that will be added as main admins. Each account name must be on its own line.</p>
<p class="CommentLine">Adding account names in this field will not be helpful unless you are using LDAP or HTTP Authentication.</p>
</td>

</tr></tbody>
</table></div>
<?php } ?>