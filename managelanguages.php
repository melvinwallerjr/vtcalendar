<?php
require_once('application.inc.php');

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN']) { exit; } // additional security

if (isset($_POST['post']) && isset($_POST['post']['cancel'])) { // redirect to update page
	redirect2URL('update.php');
	exit;
}

$post_edit = (isset($_POST['post']) && isset($_POST['post']['edit']))? true : false;
$post_save = (isset($_POST['post']) && isset($_POST['post']['save']))? true : false;
$post_fail = false; // tracks whether the process has a $_POST failure
// root language file cannot have empty fields and posting changes with empty fields will force a failure
$ascii_string = '/[^A-Za-z0-9-!"#$%&\'()*+,.\/\:;<=>?@\[\]_`{|}~ \t\r\n\v\f]/'; // non-ascii also forces failure

if (isset($_POST['cal']) && isset($_POST['cal']['lang'])) {
	if ($_POST['cal']['lang'] != 'new' &&
	 !setVar($calendarlanguage, mb_strtolower(trim($_POST['cal']['lang']), 'UTF-8'), 'calendarlanguage')) {
		unset($calendarlanguage);
	}
	elseif (isset($_POST['cal']['newlang']) && $_POST['cal']['newlang'] != '' &&
	 !setVar($newlang, mb_strtolower(trim($_POST['cal']['newlang']), 'UTF-8'), 'newlang')) {
		unset($newlang);
	}
	unset($_POST['cal']['newlang']);
}
if (!isset($calendarlanguage)) {
	if (isset($newlang)) { $calendarlanguage = mb_strtolower(trim($newlang), 'UTF-8'); }
	elseif ($post_edit) { // cannot edit undefined language
		redirect2URL('managelanguages.php');
		exit;
	}
}

if ($dh = opendir('languages')) { // PHP4 compatable directory read
	while (($file = readdir($dh)) !== false) {
		if (preg_match("|^(.*)\.inc\.php$|", $file, $matches)) { $languages[] = $matches[1]; }
	}
	closedir($dh);
}
$available_languages = array();
$language_list = '';
if (isset($languages) && count($languages) > 0) {
	foreach ($languages as $language) {
		$available_languages[] = $language;
		$sel = ((isset($_POST['cal']['lang']) && $language == $_POST['cal']['lang']) ||
		 (!isset($_POST['cal']['lang']) && $language == LANGUAGE))? ' selected="selected"' : '';
	    $language_list .= '<option value="' . $language . '"' . $sel . '>' .
		 mb_strtoupper($language, 'UTF-8') . '</option>' . "\n";
	}
}
else { $language_list .= '<option value="en">EN</option>' . "\n"; }
$newfile = (isset($calendarlanguage) && !in_array($calendarlanguage, $available_languages));

if ($post_save && isset($_POST['cal']) && isset($_POST['cal']['lang'])) { // save new/updated language file
	$LanguageOutput = '<?php' . "\n";
	foreach ($_POST['cal'] as $key => $val) {
		if (($_POST['cal']['lang'] == 'en' && trim($val) == '') || preg_match($ascii_string, $val)) {
			 // cannot save root language with empty or non-ascii fields
		 	$post_fail = true;
			$post_edit = true;
			$post_save = false;
			break;
		}
		else { // field has acceptable content
			// This saves ALL text field names in every language file, even if empty.
			// This method is not as efficient as other methods, but this way all
			// language files have all the required field names. This allows updates
			// be done outside of the site editor page and prevents lost data fields.
			$LanguageOutput .= '$lang[\'' . $key . '\'] = \'' .
			 str_replace('\'', '\\\'', trim($val)) . '\';' . "\n";
		}
	}
	$LanguageOutput .= '?>' . "\n";
	if (!$post_fail && @file_put_contents('languages/' . $_POST['cal']['lang'] .
	 '.inc.php', $LanguageOutput) !== false) {
	 	redirect2URL('update.php');
		exit;
	}
}

if (!$post_save && !$post_edit) {
	pageheader(lang('edit_language', false), 'Update');
	contentsection_begin(lang('edit_language'));
	echo '
<form action="' . $_SERVER['PHP_SELF'] . '" method="post">

<p><strong>' . lang('specify_language_description') . '</strong></p>

<table border="0" cellspacing="0" cellpadding="2">
<tbody><tr>
<td><label for="callanguage">' . lang('lang') . ':</label></td>
<td>';
	if (isset($check)) {
		if (empty($cal['lang']) || !isValidInput($cal['lang'], 'calendarlanguage')) {
			echo 'language missing<br />';
		}
	}
	echo '
<select id="callanguage" name="cal[lang]" onchange="if(this.value==\'new\'){document.getElementById(\'newlanguage\').className=\'\';}else{document.getElementById(\'newlanguage\').className=\'none\';}">
' . $language_list .'
<option value="new">New</option>
</select>
<span id="newlanguage" class="none">&nbsp; <label for="calnewlang">' . lang('specify_new_language') . ':</label>
<input id="calnewlang" name="cal[newlang]" value="" size="3" maxlength="2" /></span></td>

</tr></tbody>
</table>

<p><input type="submit" name="post[edit]" value="' . htmlspecialchars(lang('edit', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="post[cancel]" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>

</form>';
}
if ($post_edit) {
	pageheader(lang('edit_language', false) . ' &nbsp;-&nbsp; ' . mb_strtoupper($calendarlanguage, 'UTF-8'), 'Update');
	contentsection_begin(lang('edit_language') . ' &nbsp;-&nbsp; ' . mb_strtoupper($calendarlanguage, 'UTF-8'));
	echo lang('edit_language_instructions') . '

<form action="' . $_SERVER['PHP_SELF'] . '" method="post" onsubmit="return testNonAscii()">
<p><input type="submit" name="post[save]" value="' . htmlspecialchars(lang('save_changes', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="post[cancel]" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>';
	unset($lang);
	require('languages/en.inc.php'); // load root language
	$root_language = $lang;
	$edit_language = $root_language; // set root language to editor
	foreach ($edit_language as $key => $val) { $edit_language[$key] = ''; } // clear all values
	unset($lang);
	//echo '$calendarlanguage : ' . $calendarlanguage . '<br />';
	if ($post_fail) { $edit_language = $_POST['cal'] + $edit_language; } // set edited language
	elseif (!$newfile) {
		//echo 'NOT NEW FILE';
		require('languages/' . $calendarlanguage . '.inc.php'); // load desired language
		$edit_language = $lang + $edit_language; // merge language fields
	}
	require('languages/en.inc.php'); // reset root language for the calendar session
	if (LANGUAGE != 'en') { // reset current language for the calendar session
		require('languages/' . LANGUAGE . '.inc.php');
	}
	$count = 1;
	$field_id = array();
	$class = 'even';
	echo '
<table border="0" cellspacing="1" cellpadding="3">
<thead><tr class="TableHeaderBG">
<th class="alignLeft">' . lang('lang_default') . ': <span style="font-weight:normal">(' . lang('var_name_val') . ')</span></th>
<th class="alignLeft">' . lang('lang_to_modify') . ': <span style="font-weight:normal">(' . lang('var_name_val') . ')</span></th>
</tr></thead>
<tbody>';
	foreach ($root_language as $var => $val) {
		$id = mb_strtolower($var, 'UTF-8') . (in_array(mb_strtolower($var, 'UTF-8'), $field_id)?  $count++ : '');
		$field_id[] = $id;
		$err_class = ($post_fail && (($calendarlanguage == 'en' && $edit_language[$var] == '') ||
		 preg_match($ascii_string, $edit_language[$var]))); // test if post is ascii, else if root & not empty
		$err_class = $err_class? 'txtWarn' : 'none'; // displays or hides error message with post failure
		$err_msg = ($err_class == 'txtWarn' && $edit_language[$var] == '')?
		 lang('html_empty') : lang('html_encode');
		$class = ($class == 'even')? 'odd' : 'even';
		echo '<tr class="' . $class . '">
<td width="50%"><strong>' . $var . ':</strong><br />' . "\n";
		if (strpos($val, '@FILE:') === 0) {
			echo '<em>' . $val . '</em><br />
<div style="padding:6px; border:2px dotted #ccc;">' . file_get_contents(substr($val, 6)) . '</div>';
		}
		else { echo $val; }
		echo '</td>
<td width="50%">';
		if ($var == 'lang') {
			echo '<strong>lang:</strong><br />
<input type="hidden" name="cal[lang]" value="' . htmlspecialchars($calendarlanguage, ENT_COMPAT, 'UTF-8') . '" />
<kbd>' . $calendarlanguage . '</kbd>';
		}
		elseif (strpos($edit_language[$var], '@FILE:') === 0) { // separate translation file
			echo '<strong>' . $var . ':</strong></label><br />
<em>' . $edit_language[$var] . '</em><br />
<input type="hidden" id="cal' . $id . '" name="cal[' . $var . ']" value="' . (isset($edit_language[$var])? htmlspecialchars($edit_language[$var], ENT_COMPAT, 'UTF-8') : '') . '" />
<div style="padding:6px; border:2px dotted #ccc;">' . file_get_contents(substr($edit_language[$var], 6)) . '</div>';
		}
		elseif (strpos($val, "\n") !== false || strpos($edit_language[$var], "\n") !== false ||
		 strpos($val, '@FILE:') === 0) {
			echo '<label for="cal' . $id . '"><strong>' . $var . ':</strong></label><br />
<span id="cal' . $id . '_err" class="' . $err_class . '"><b>' . $err_msg . '</b><br /></span>
<textarea id="cal' . $id . '" name="cal[' . $var . ']" cols="60" rows="8" style="width:99%">' . (isset($edit_language[$var])? htmlspecialchars($edit_language[$var], ENT_COMPAT, 'UTF-8') : '') . '</textarea>';
		}
		else {
			echo '<label for="cal' . $id . '"><strong>' . $var . ':</strong></label><br />
<span id="cal' . $id . '_err" class="' . $err_class . '"><b>' . $err_msg . '</b><br /></span>
<input type="text" id="cal' . $id . '" name="cal[' . $var . ']" value="' . (isset($edit_language[$var])? htmlspecialchars($edit_language[$var], ENT_COMPAT, 'UTF-8') : '') . '" size="60" style="width:99%" />';
		}
		echo '</td>
</tr>';
	}
	echo '</tbody>
</table>

<p><input type="submit" name="post[save]" value="' . htmlspecialchars(lang('save_changes', false), ENT_COMPAT, 'UTF-8') . '" />
&nbsp;
<input type="submit" name="post[cancel]" value="' . htmlspecialchars(lang('cancel_button_text', false), ENT_COMPAT, 'UTF-8') . '" /></p>

</form>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript">/* <![CDATA[ */
var edit_lang = "' . $calendarlanguage . '";
function testNonAscii()
{ // tests for the presence of non-ascii characters in all form fields for XML/XHTML support
	var RegEx = /[^A-Za-z0-9-!"#$%&\'()*+,.\\/\\\:;<=>?@\\[\\]_`{|}~ \\t\\r\\n\\v\\f]/; // ascii test
	var i, str, msg, setclass, f_text=$("input:text, textarea"), passed=true;
	for (i=0; i < f_text.length; i++) {
		str = $.trim($(f_text[i]).val());
		if (edit_lang == "en" && str == "") {
			msg = "<b>' . str_replace(array('"', '</'), array('\"', '<\/'), lang('html_empty')) . '<\/b>";
			setclass = "txtWarn";
			passed = false;
		}
		else if (str.replace(RegEx, "") != str) {
			msg = "<b>' . str_replace(array('"', '</'), array('\"', '<\/'), lang('html_encode')) . '<\/b>";
			setclass = "txtWarn";
			passed = false;
		}
		else {
			msg = "";
			setclass = "none"; }
		$("#" + $(f_text[i]).attr("id") + "_err").attr("className", setclass).html(msg);
	}
	return passed;
}
/* ]]> */</script>';
}

contentsection_end();
pagefooter();
DBclose();
?>