<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
  require_once('globalsettings.inc.php');

  if (!authorized()) { exit; }
  if (!$_SESSION["AUTH_ADMIN"]) { exit; } // additional security
 
	pageheader(lang('view_search_log'), "Update");
	contentsection_begin(lang('view_search_log'),true);

?>
<a href="deletesearchlog.php"><?php echo lang('clear_search_log'); ?></a>
<img src="images/spacer.gif" width="400" height="1" alt="1">
<pre>
<?php
  $result = DBQuery("SELECT * FROM vtcal_searchlog WHERE calendarid='".sqlescape($_SESSION["CALENDARID"])."' ORDER BY time" ); 
  if ( $result->numRows() > 0 ) {
		for ($i=0; $i<$result->numRows(); $i++) {
			$searchlog = $result->fetchRow(DB_FETCHMODE_ASSOC,$i);
			echo "    ",htmlentities($searchlog['time']);
			echo "  ", str_pad($searchlog['ip'], 15, " ", STR_PAD_LEFT)," ";
			echo str_pad($searchlog['numresults'], 5, " ", STR_PAD_LEFT),"   ";
			echo htmlentities($searchlog['keyword']),"<br>";
		} // end: for ($i=0; $i<$result->numRows(); $i++)
  }
	else {
	  echo "    ",lang('search_log_is_empty');
	}
?>	
</pre>
<?php
  contentsection_end();
  require("footer.inc.php");
DBclose();
?>