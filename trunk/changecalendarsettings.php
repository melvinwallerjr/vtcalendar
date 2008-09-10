<?php //
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('globalsettings.inc.php');

$database = DBopen();
if (!authorized($database)) { exit; }
if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security

if (isset($_POST['cancel'])) { setVar($cancel,$_POST['cancel'],'cancel'); } else { unset($cancel); }
if (isset($_POST['save'])) { setVar($save,$_POST['save'],'save'); } else { unset($save); }
if (isset($_POST['users'])) { setVar($users,$_POST['users'],'users'); } else { unset($users); }
if (isset($_POST['title'])) { setVar($title,$_POST['title'],'calendarTitle'); } else { unset($title); }
if (isset($_POST['header'])) { setVar($header,$_POST['header'],'calendarHeader'); } else { unset($header); }
if (isset($_POST['footer'])) { setVar($footer,$_POST['footer'],'calendarFooter'); } else { unset($footer); }
if (isset($_POST['viewauthrequired'])) { setVar($viewauthrequired,$_POST['viewauthrequired'],'viewauthrequired'); } else { unset($viewauthrequired); }
if (isset($_POST['forwardeventdefault'])) { setVar($forwardeventdefault,$_POST['forwardeventdefault'],'forwardeventdefault'); } else { unset($forwardeventdefault); }
if (isset($_POST['bgcolor'])) { setVar($bgcolor,$_POST['bgcolor'],'color'); } else { unset($bgcolor); }
if (isset($_POST['maincolor'])) { setVar($maincolor,$_POST['maincolor'],'color'); } else { unset($maincolor); }
if (isset($_POST['todaycolor'])) { setVar($todaycolor,$_POST['todaycolor'],'color'); } else { unset($todaycolor); }
if (isset($_POST['pastcolor'])) { setVar($pastcolor,$_POST['pastcolor'],'color'); } else { unset($pastcolor); }
if (isset($_POST['futurecolor'])) { setVar($futurecolor,$_POST['futurecolor'],'color'); } else { unset($futurecolor); }
if (isset($_POST['textcolor'])) { setVar($textcolor,$_POST['textcolor'],'color'); } else { unset($textcolor); }
if (isset($_POST['linkcolor'])) { setVar($linkcolor,$_POST['linkcolor'],'color'); } else { unset($linkcolor); }
if (isset($_POST['gridcolor'])) { setVar($gridcolor,$_POST['gridcolor'],'color'); } else { unset($gridcolor); }
   
if (isset($cancel)) {
redirect2URL("update.php");
exit;
};

if (!(isset($title) && isset($header) && isset($footer) && 
	  isset($bgcolor) && isset($maincolor) && isset($todaycolor) && 
	  isset($pastcolor) && isset($futurecolor) && isset($textcolor) && isset($linkcolor) && isset($gridcolor) &&
      isset($viewauthrequired))) { //(re-)read from database
	$title = $_SESSION["TITLE"];	
	$header = $_SESSION["HEADER"];	
	$footer = $_SESSION["FOOTER"];	
	$viewauthrequired	= $_SESSION["VIEWAUTHREQUIRED"];
	$forwardeventdefault = $_SESSION["FORWARDEVENTDEFAULT"];

	$bgcolor = $_SESSION["BGCOLOR"];	
	$maincolor = $_SESSION["MAINCOLOR"];
	$todaycolor = $_SESSION["TODAYCOLOR"]; //color of the day's view border color, today's date highlight in week, month view and in little calendar 
	$pastcolor = $_SESSION["PASTCOLOR"];		
	$futurecolor = $_SESSION["FUTURECOLOR"];		
	$textcolor = $_SESSION["TEXTCOLOR"];		
	$linkcolor = $_SESSION["LINKCOLOR"];		
	$gridcolor = $_SESSION["GRIDCOLOR"];		
}

$addPIDError="";
if ( isset($save) ) {
	if (!preg_match(REGEXVALIDCOLOR, $bgcolor)) { $bgcolor = "#ffffff"; }
	if (!preg_match(REGEXVALIDCOLOR, $maincolor)) { $maincolor = "#ff9900"; }
	if (!preg_match(REGEXVALIDCOLOR, $todaycolor)) { $todaycolor = "#ffcc66"; }
	if (!preg_match(REGEXVALIDCOLOR, $pastcolor)) { $pastcolor = "#eeeeee"; }
	if (!preg_match(REGEXVALIDCOLOR, $futurecolor)) { $futurecolor = "#ffffff"; }
	if (!preg_match(REGEXVALIDCOLOR, $textcolor)) { $textcolor = "#000000"; }
	if (!preg_match(REGEXVALIDCOLOR, $linkcolor)) { $linkcolor = "#3333cc"; }
	if (!preg_match(REGEXVALIDCOLOR, $gridcolor)) { $gridcolor = "#cccccc"; }

	// check validity of users
	if ( !empty($users) ) {
		// disassemble the users string and check all PIDs against the DB
		$pidsInvalid = "";
		$pidsTokens = split ( "[ ,;\n\t]", $users );
		$pidsAddedCount = 0;
		for ($i=0; $i<count($pidsTokens); $i++) {
			$pidName = $pidsTokens[$i];
			$pidName = trim($pidName);
			if ( !empty($pidName) ) {
				if ( isValidUser ( $database, $pidName ) ) {
					$pidsAdded[$pidsAddedCount] = $pidName;
					$pidsAddedCount++;
				} 
				else {
					if ( !empty($pidsInvalid) ) { $pidsInvalid .= ","; }
					$pidsInvalid .= $pidName;
				}
			} 
		} // end: while

		// feedback message(s)
		if ( !empty($pidsInvalid) ) {
			if ( strpos($pidsInvalid, "," ) > 0 ) { // more than one user-ID
				$addPIDError = lang('user_ids_invalid')." &quot;".$pidsInvalid."&quot;";
			}
			else {
				$addPIDError = lang('user_id_invalid')." &quot;".$pidsInvalid."&quot;";
			}
		}
	} // end: else: if ( empty($users) )
	
	if (empty($addPIDError)) { 
		// save the settings to database
		if ( $viewauthrequired != 0 ) { $viewauthrequired = 1; }
		if ( $forwardeventdefault!="1" ) { $forwardeventdefault = "0"; }
		$result = DBQuery($database, 
		"UPDATE vtcal_calendar SET title='".sqlescape($title)."',header='".sqlescape($header)."',footer='".sqlescape($footer)."',
bgcolor='".sqlescape($bgcolor)."',maincolor='".sqlescape($maincolor)."',todaycolor='".sqlescape($todaycolor)."',
pastcolor='".sqlescape($pastcolor)."',futurecolor='".sqlescape($futurecolor)."',textcolor='".sqlescape($textcolor)."',
linkcolor='".sqlescape($linkcolor)."',gridcolor='".sqlescape($gridcolor)."',
viewauthrequired='".sqlescape($viewauthrequired)."',forwardeventdefault='".sqlescape($forwardeventdefault)."' 
WHERE id='".sqlescape($_SESSION["CALENDARID"])."'" ); 
		
		// substitute existing auth info with the new one
		$result = DBQuery($database, "DELETE FROM vtcal_calendarviewauth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."'" );
		for ($i=0; $i<count($pidsAdded); $i++) {
			$result = DBQuery($database, "INSERT INTO vtcal_calendarviewauth (calendarid,userid) VALUES ('".sqlescape($_SESSION["CALENDARID"])."','".sqlescape($pidsAdded[$i])."')" );
		}
		
		setCalendarPreferences();
		
		redirect2URL("update.php");
		exit;
	} // end: if (empty($addPIDError))
}

// read sponsor name from DB
$result = DBQuery($database, "SELECT name FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($_SESSION["AUTH_SPONSORID"])."'" ); 
$sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

pageheader(lang('change_header_footer_colors_auth'),
           lang('change_header_footer_colors_auth'),
           "Update","",$database);
box_begin("inputbox", lang('change_header_footer_colors_auth'));
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="globalSettings">

<p><input type="submit" name="save" value="<?php echo lang('ok_button_text'); ?>" class="button">&nbsp;&nbsp;<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" class="button"></p>

  <b><?php echo lang('calendar_title'); ?>:</b> <font color="#999999"><?php echo lang('empty_or_any_text'); ?></font><br>
  <input type="text" name="title" maxlength="<?php echo $constCalendarTitleMAXLENGTH; ?>" size="30" value="<?php 
	echo htmlentities($title);
	?>"><br>
  <br>

  <b><?php echo lang('header_html'); ?>:</b> <font color="#999999"><?php echo lang('empty_or_any_html'); ?></font><br>
  <textarea name="header" wrap="physical" cols="70" rows="10"><?php 
	echo htmlentities($header);
	?></textarea><br>
  <br>

  <b><?php echo lang('footer_html'); ?>:</b> <font color="#999999"><?php echo lang('empty_or_any_html'); ?></font><br>
  <textarea name="footer" wrap="physical" cols="70" rows="10"><?php
	echo htmlentities($footer);
  ?></textarea>

<!--<p>Note: Changing colors on the calendar is currently disabled.</p>-->
<input type="hidden" name="bgcolor" value="<?php echo $bgcolor; ?>">
<input type="hidden" name="maincolor" value="<?php echo $maincolor; ?>">
<input type="hidden" name="textcolor" value="<?php echo $textcolor; ?>">
<input type="hidden" name="linkcolor" value="<?php echo $linkcolor; ?>">
<input type="hidden" name="gridcolor" value="<?php echo $gridcolor; ?>">
<input type="hidden" name="pastcolor" value="<?php echo $pastcolor; ?>">
<input type="hidden" name="todaycolor" value="<?php echo $todaycolor; ?>">
<input type="hidden" name="futurecolor" value="<?php echo $futurecolor; ?>">


<?php
  if ( $_SESSION["CALENDARID"] != "default" ) {
?>
<?php
  $result = DBQuery($database, "SELECT * FROM vtcal_calendar WHERE id='default'" ); 
  $c = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
  $defaultcalendarname = $c['name'];
?>
<br>
  <table border="0">
    <tr align="left" valign="top">
      <td><input type="checkbox" name="forwardeventdefault" id="forwardeventdefault" value="1"<?php if ($forwardeventdefault=="1") { echo " checked"; } ?>></td>
      <td><strong><label for="forwardeventdefault">By default also display events on the <?php echo $defaultcalendarname ?></label></strong> <br>
        (Sponsors can still disable this on a per-event basis)</td>
    </tr>
  </table>
<?php
  } // end: if ( $_SESSION["CALENDARID"] != "default" ) {
?>
 <br>
<br>

    <b><?php echo lang('login_required_for_viewing'); ?></b>
</p>
<table border="0" cellpadding="3" cellspacing="3">
<tr>
  <td align="right"><input type="radio" name="viewauthrequired" value="0"<?php 
	if ( $viewauthrequired == 0 ) { echo " checked"; }
	?>></td>
  <td align="left"><?php echo lang('no_login_required'); ?><br></td>
</tr>
<tr>
  <td align="right" valign="top"><input type="radio" name="viewauthrequired" value="1"<?php 
	if ( $viewauthrequired != 0 ) { echo " checked"; }
	?>></td>
  <td align="left"><?php echo lang('login_required_user_ids'); ?>:<br>
<?php
  if (!empty($addPIDError)) {    
    feedback($addPIDError,1);
  }
?>
		<textarea name="users" cols="40" rows="6" wrap="virtual"><?php
		if ( isset($users) ) {
		  echo $users;
		}
		else {
		  $query = "SELECT * FROM vtcal_calendarviewauth WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY userid";
      $result = DBQuery($database, $query ); 
			$i = 0;
			while ($i < $result->numRows()) {
			  $viewauth = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
				if ($i>0) { echo ","; }
				echo $viewauth['userid'];
				$i++;
			}
		}
		?></textarea><br>
		<i><?php echo lang('separate_user_ids_with_comma'); ?></i>
	</td>
</tr>
</table>
<p><input type="submit" name="save" value="<?php echo lang('ok_button_text'); ?>" class="button">&nbsp;&nbsp;<input type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>" class="button"></p>
</form>
<?php 
  box_end();
  require("footer.inc.php");
DBclose($database);
?>