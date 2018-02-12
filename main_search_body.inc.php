<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files
?>

<?php
// check if some input params are set, and if not set them to default
if (!isset($timebegin_year)) { $timebegin_year = $today['year']; }
if (!isset($timebegin_month)) { $timebegin_month = $today['month']; }
if (!isset($timebegin_day)) { $timebegin_day = $today['day']; }
if (!isset($timeend_year)) { $timeend_year = $timebegin_year; }
if (!isset($timeend_month)) {
	$timeend_month = $timebegin_month + 6;
	if ($timeend_month >= 13) {
		$timeend_month = $timeend_month - 12;
		$timeend_year++;
	}
}
if (!isset($timeend_day)) {
	$timeend_day = $timebegin_day;
	while (!checkdate($timeend_month, $timeend_day, $timeend_year)) { $timeend_day--; };
}
?>
<form method="get" action="main.php" name="searchform">
<input type="hidden" name="calendarid" value="<?php echo htmlspecialchars(urlencode($_SESSION['CALENDAR_ID']), ENT_COMPAT, 'UTF-8'); ?>" />
<input type="hidden" name="view" value="searchresults" />

<table border="0" cellspacing="2" cellpadding="3">
<tbody><tr>
<td><label for="keyword"><strong><?php echo lang('keyword'); ?>:</strong></label></td>
<td><input type="text" id="keyword" name="keyword" value="<?php echo htmlspecialchars($keyword, ENT_COMPAT, 'UTF-8'); ?>" size="40" maxlength="<?php echo MAXLENGTH_KEYWORD; ?>" /><br />
<?php echo lang('case_insensit'); ?></td>

</tr><tr>

<td><strong><?php echo lang('starting_from'); ?></strong></td>
<td><fieldset><?php
inputdate($timebegin_month, 'timebegin_month', $timebegin_day, 'timebegin_day',
 $timebegin_year, 'timebegin_year');
?></fieldset></td>

</tr><tr>

<td>&nbsp;</td>
<td><p><input type="submit" name="search" value="<?php echo htmlspecialchars(lang('search', false), ENT_COMPAT, 'UTF-8'); ?>" /></p></td>

</tr></tbody>
</table>

</form>

<script type="text/javascript">/* <![CDATA[ */
document.searchform.keyword.focus();
/* ]]> */</script>
