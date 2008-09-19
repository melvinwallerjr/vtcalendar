<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
require_once('application.inc.php');

$lang['show_totals'] = 'Show Totals';
$lang['upcoming_total'] = 'Upcoming / Total';
$lang['dberror_nototals'] = 'Note: Event totals could not be calculated due to a database error';
$lang['dberror_noupcomingtotals'] = 'Note: Upcoming event totals could not be calculated due to a database error';

if (!authorized()) { exit; }
if (!$_SESSION['AUTH_ISMAINADMIN'] ) { exit; } // additional security

pageheader(lang('manage_calendars'), "Update");
contentsection_begin(lang('manage_calendars'),true);

$calculateTotals = isset($_GET['totals']);

// determine today's date
$today = Decode_Date_US(date("m/d/Y"));
$todayTimeStamp = datetime2timestamp($today['year'],$today['month'],$today['day'],12,0,"am");

if ($calculateTotals) {
	// Count all events.
	$result =& DBQuery("SELECT count(id) as count, calendarid FROM vtcal_event_public v GROUP BY calendarid ORDER BY calendarid");
	
	if (is_string($result)) {
		echo "<p>" . $lang['dberror_nototals'] . ": " . $result . "</p>";
	}
	else {
		$totalEvents = array();
		$totalEvents['_'] = 0;
		for ($i = 0; $i < $result->numRows(); $i++) {
		  $calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
			$totalEvents['_'] += $calendar['count'];
			if (isset($totalEvents[$calendar['calendarid']])) {
				$totalEvents[$calendar['calendarid']] += $calendar['count'];
			}
			else {
				$totalEvents[$calendar['calendarid']] = $calendar['count'];
			}
		}
		
		$result->free();
		// Count only upcoming events.
		$result =& DBQuery("SELECT count(id) as count, calendarid FROM vtcal_event_public v WHERE timebegin >= '".sqlescape($todayTimeStamp)."' GROUP BY calendarid ORDER BY calendarid");
		
		if (is_string($result)) {
			echo "<p>" . $lang['dberror_noupcomingtotals'] . ": " . $result . "</p>";
		}
		else {
			$upcomingEvents = array();
			$upcomingEvents['_'] = 0;
			for ($i = 0; $i < $result->numRows(); $i++) {
			  $calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
				$upcomingEvents['_'] += $calendar['count'];
				if (isset($upcomingEvents[$calendar['calendarid']])) {
					$upcomingEvents[$calendar['calendarid']] += $calendar['count'];
				}
				else {
					$upcomingEvents[$calendar['calendarid']] = $calendar['count'];
				}
			}
			$result->free();
		}
	}
}

$result =& DBQuery("SELECT id, name FROM vtcal_calendar ORDER BY id");

if (is_string($result)) {
  DBErrorBox($result);
}
else {
	?><p><a href="editcalendar.php?new=1"><?php echo lang('add_new_calendar'); ?></a> <?php echo lang('or_modify_existing_calendar'); ?></p>
	
	<table border="0" cellspacing="0" cellpadding="5">
	  <tr bgcolor="#CCCCCC">
	    <td bgcolor="#CCCCCC"><b><?php echo lang('calendar_id'); ?></b></td>
	    <td bgcolor="#CCCCCC" style="border-left: 1px solid #999999;"><b><?php echo lang('calendar_name'); ?></b></td>
	    <?php if ($calculateTotals) { ?>
	    <td bgcolor="#CCCCCC" style="border-left: 1px solid #999999;" align="right"><b><?php echo $lang['upcoming_total']; ?></b></td>
	    <?php } ?>
	    <td bgcolor="#CCCCCC" style="border-left: 1px solid #999999;"><?php echo !$calculateTotals ? '<a href="managecalendars.php?totals=y">' . $lang['show_totals'] . '</a>' : '&nbsp;'; ?></td>
	  </tr><?php
	
	// The initial row color.
	$color = "#ffffff";
	
	for ($i=0; $i<$result->numRows(); $i++) {
	  $calendar =& $result->fetchRow(DB_FETCHMODE_ASSOC, $i);
		
		?><tr>
	    <td bgcolor="<?php echo $color; ?>"><a href="main.php?calendarid=<?php echo urlencode($calendar['id']); ?>"><?php echo htmlentities($calendar['id']); ?></a></td>
	    <td bgcolor="<?php echo $color; ?>" style="border-left: 1px solid #999999;"><?php echo htmlentities($calendar['name']); ?></td>
	    <?php if ($calculateTotals) { ?>
	    <td bgcolor="<?php echo $color; ?>" style="border-left: 1px solid #999999;" align="right"><?php
	    	if (isset($upcomingEvents) && isset($totalEvents)) {
			    echo isset($upcomingEvents[$calendar['id']]) ? $upcomingEvents[$calendar['id']] : 0; ?> / <?php echo isset($totalEvents[$calendar['id']]) ? $totalEvents[$calendar['id']] : 0;
			  }
			  else {
			  	echo "**";
			  }
				?></td>
	    <?php } ?>
	    <td bgcolor="<?php echo $color; ?>" style="border-left: 1px solid #999999;"><a href="editcalendar.php?cal[id]=<?php echo urlencode($calendar['id']); ?>"><?php echo lang('edit'); ?></a>&nbsp; <?php
	  if ( $calendar['id'] != "default" ) {
			?><a href="deletecalendar.php?cal[id]=<?php echo urlencode($calendar['id']); ?>"><?php echo lang('delete'); ?></a><?php
	  }
		?></td>
	  </tr><?php
		if ( $color == "#eeeeee" ) { $color = "#ffffff"; } else { $color = "#eeeeee"; }
	}
	  
	?>		
		<tr>
		  <td colspan="2" bgcolor="#CCCCCC"><b><?php echo $result->numRows(); ?> <?php echo lang('calendars'); ?></b></td>
	    <?php if ($calculateTotals) { ?>
		  <td bgcolor="#CCCCCC" align="right"><b><?php
    	if (isset($upcomingEvents) && isset($totalEvents)) {
			  echo $upcomingEvents['_']; ?> / <?php echo $totalEvents['_'];
			}
			else {
				echo "&nbsp;";
			}
		  ?></b></td>
	    <?php } ?>
		  <td bgcolor="#CCCCCC">&nbsp;</td>
		</tr>
	</table><?php
	
	$result->free();
}

  contentsection_end();
  pagefooter();
DBclose();
?>