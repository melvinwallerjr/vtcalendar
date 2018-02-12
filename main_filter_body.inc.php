<?php
if (!defined('ALLOWINCLUDES')) { exit; } // prohibits direct calling of include files

/*
1. Outputs the body for the filter view.

2. Defines javascript functions used by only this file.
		function checkAll(myForm, id, state)
		function validate ( myForm, id )
*/

?>
<script type="text/javascript">/* <![CDATA[ */
function validate(myForm, oid)
{
	var cnt, ckb, b=new Boolean(false);
	for (cnt=0; cnt < myForm.elements.length; cnt++) {
		ckb = myForm.elements[cnt];
		if (ckb.type == "checkbox" && ckb.name.indexOf(oid) == 0) {
			if (ckb.checked == true) { b = true; break; }
		}
	}
	if (b == false) {
		alert("Please select one or more categories before clicking the button.");
		return false;
	}
	return true;
}
/* ]]> */</script>

<form name="categorylist" action="main.php" method="get">
<input type="hidden" name="view" value="<?php
if (isset($oldview) && $oldview != 'filter') { echo htmlspecialchars($oldview, ENT_COMPAT, 'UTF-8'); }
elseif (isset($_SESSION['PREVIOUS_VIEW'])) { echo htmlspecialchars($_SESSION['PREVIOUS_VIEW'], ENT_COMPAT, 'UTF-8'); }
else { echo 'week'; }
?>" />
<input type="hidden" name="calendar" value="<?php echo htmlspecialchars($_SESSION['CALENDAR_ID'], ENT_COMPAT, 'UTF-8'); ?>" />

<table border="0" cellpadding="0" cellspacing="10">
<tbody><tr>

<td colspan="4"><strong><?php echo lang('select_categories'); ?></strong></td>

</tr><tr>

<td colspan="4" nowrap="nowrap"><a href="javascript:checkAll(document.categorylist,'categoryfilter',true)"><?php echo lang('select_unselect'); ?></a></td>

</tr><tr>

<td nowrap="nowrap"><?php
if (isset($CategoryFilter)) {
	// Create a list of category filter keys
	$CategoryFilterKeys = array_flip($CategoryFilter);
}
$percolumn = ceil($numcategories / 3);
for ($c=0; $c < $numcategories; $c++) {
	// determine if the current category has been selected previously
	$categoryselected = (!isset($CategoryFilterKeys) ||
	 array_key_exists($categories_id[$c], $CategoryFilterKeys));
	if ($c > 0 && $c % $percolumn == 0) {
		echo '</td>' . "\n" . '<td nowrap="nowrap">';
	}
	echo '
<input type="checkbox" id="category' . $c . '" name="categoryfilter[]" value="' . htmlspecialchars($categories_id[$c], ENT_COMPAT, 'UTF-8') . '"' . (($categoryselected || count($CategoryFilter) == 0)? ' checked="checked"' : '') . ' />
<label for="category' . $c . '">' . htmlspecialchars($categories_name[$c], ENT_COMPAT, 'UTF-8') . '</label><br />';
}
?></td>

</tr><tr>

<td colspan="3"><p><input type="submit" value="<?php echo htmlspecialchars(lang('apply_filter', false), ENT_COMPAT, 'UTF-8'); ?>" /></p></td>

</tr></tbody>
</table>

</form>
