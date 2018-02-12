<?php
function inputtemplatedata(&$event, $sponsorid, $check, $template_name)
{
	echo '
<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td><label for="template_name"><strong>' . lang('template_name') . ':</strong></label> <span class="txtWarn">*</span></td>
<td>';
	if ($check && empty($template_name)) { feedback(lang('choose_template_name'), FEEDBACKNEG); }
	echo '
<input type="text" id="template_name" name="template_name" value="';
	if ($check) { $template_name = stripslashes($template_name); }
	echo HTMLSpecialChars($template_name) . '" size="24" maxlength="' . MAXLENGTH_TEMPLATE_NAME . '" />
<i>' . lang('template_name_example') . '</i></td>
</tr></tbody>
</table>' . "\n";
	inputeventdata($event, $sponsorid, 0, $check, 0, $repeat, 0);
}
?>