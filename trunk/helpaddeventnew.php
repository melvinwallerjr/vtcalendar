<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('application.inc.php');

  helpwindow_header();
?>
<H3><IMG src="images/nuvola/16x16/actions/help.png" width="16" height="16" alt="" border="0">
<?php echo lang('help_addnewevent'); ?>
</H3>
<?php echo lang('help_addnewevent_contents'); ?>
<?php
  helpwindow_footer();
?>