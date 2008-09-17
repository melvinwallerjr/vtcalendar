<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('application.inc.php');

  if (!authorized()) { exit; }

  if (isset($_POST['cancel'])) { setVar($cancel,$_POST['cancel'],'cancel'); } else { unset($cancel); }
  if (isset($_POST['save'])) { setVar($save,$_POST['save'],'save'); } else { unset($save); }
  if (isset($_POST['sponsor_email'])) { setVar($sponsor_email,$_POST['sponsor_email'],'sponsor_email'); } else { unset($sponsor_email); }

  if (isset($cancel)) {
    redirect2URL("update.php");
    exit;
  }

  // read sponsor name from DB
  $result = DBQuery("SELECT name FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($_SESSION["AUTH_SPONSORID"])."'" ); 
  $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);

  if (isset($save)) {
    $sponsor["email"]=$sponsor_email;
    if (checkemail($sponsor["email"])) { // email is valid
      // save email to DB
      $result = DBQuery("UPDATE vtcal_sponsor SET email='".sqlescape($sponsor_email)."' WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($_SESSION["AUTH_SPONSORID"])."'" ); 

      // reroute to sponsormenu page
      redirect2URL("update.php?fbid=emailchangesuccess&fbparam=".urlencode(stripslashes($sponsor_email)));
      exit;
    }
  }
  else
  { // read the sponsor's email from the DB
    $result = DBQuery("SELECT * FROM vtcal_sponsor WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' AND id='".sqlescape($_SESSION["AUTH_SPONSORID"])."'" ); 
    $sponsor = $result->fetchRow(DB_FETCHMODE_ASSOC,0);
  } // end else: if (isset($save))

  pageheader(lang('change_email'), "Update");
  contentsection_begin(lang('change_email'));
?>
<p><B><?php echo lang('change_email_label'); ?></B></p>
<FORM method="post" action="changeemail.php">
<?php
  if (!checkemail($sponsor["email"])) {
    feedback(lang('email_invalid'),1);
?>
  <BR>
<?php
  } /* end: if ($checkemail($sponsor["email"])) */
?>
  <INPUT type="text" name="sponsor_email" maxlength="100" size="60" value="<?php echo HTMLSpecialChars($sponsor["email"]); ?>">
  <BR>
  <BR>
  <INPUT type="submit" name="save" value="<?php echo lang('ok_button_text'); ?>">
  <INPUT type="submit" name="cancel" value="<?php echo lang('cancel_button_text'); ?>">
</FORM>
<?php
  contentsection_end();

  pagefooter();
DBclose();
?>