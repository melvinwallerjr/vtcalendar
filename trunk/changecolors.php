<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('application.inc.php');
require_once('changecolors-functions.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISCALENDARADMIN']) { exit; } // additional security

if (isset($_POST['cancel'])) { setVar($cancel,$_POST['cancel'],'cancel'); } else { unset($cancel); }
if (isset($_POST['save'])) { setVar($save,$_POST['save'],'save'); } else { unset($save); }

if (isset($cancel)) {
	redirect2URL("update.php");
	exit;
};

// Load variables
$VariableErrors = array();
LoadVariables();

if (isset($save) && count($VariableErrors) == 0) {
	echo "SAVING!";
}

pageheader(lang('change_colors'), "Update");
contentsection_begin(lang('change_colors'));
?>

<script type="text/javascript">
document.ChangingColorID = null;
document.ColorChangeHandler = function(hex) {
	document.getElementById("Color_" + document.ChangingColorID).value = "#" + hex;
	document.getElementById("Swap_" + document.ChangingColorID).style.backgroundColor = "#" + hex;
	document.ChangingColorID = null;
}
function SetupColorPicker(idbase) {
	document.ChangingColorID = idbase;
	PickColor('Swap_' + idbase, escape(document.getElementById("Color_" + idbase).value));
}
</script>

<form method="post" action="changecolors.php" name="colorSettings">

<p><input type="submit" name="save" value="<?php echo lang('ok_button_text'); ?>" class="button">&nbsp;&nbsp;<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" class="button"></p>

<?php ShowForm(); ?>

<p><input type="submit" name="save" value="<?php echo lang('ok_button_text'); ?>" class="button">&nbsp;&nbsp;<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" class="button"></p>
</form>

<iframe id="ColorPicker" style="background-color: #FFFFFF; border: 1px solid #666666; position: absolute; display: none;" src="scripts/colorpicker/blank.html" frameborder="0" width="440" height="325" style="border: 1px solid #FF0000" scrolling="no" marginheight="0" marginwidth="0">Cannot display color picker</iframe>

<?php 
contentsection_end();
pagefooter();
DBclose();
?>