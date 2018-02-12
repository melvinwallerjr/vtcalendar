<?php
function print_event($event, $linkfeatures=true)
{
?>
<table id="EventTable" width="100%" border="0" cellspacing="3" cellpadding="6">
<tbody><tr>
<td id="EventLeftColumn" align="center" nowrap="nowrap"><b><?php
	if ($event['wholedayevent'] == 0) {
		echo timestring($event['timebegin_hour'], $event['timebegin_min'], $event['timebegin_ampm']);
		if (!($event['timeend_hour'] == DAY_END_H && $event['timeend_min'] == 59)) {
			echo '<br />' . "\n" . lang('to') . '<br />' . "\n";
			echo timestring($event['timeend_hour'], $event['timeend_min'], $event['timeend_ampm']);
		}
	}
	else { echo lang('all_day'); }
?></b></td>
<td id="EventRightColumn" width="100%">
<div id="EventTitle"><strong><?php echo strip_tags($event['title']); ?></strong></div>
<div id="EventCategory">(<?php echo $event['category_name']; ?>)</div>
<?php
	if (!empty($event['description'])) {
		echo '<div id="EventDescription">';
		if (strip_tags($event['description']) == $event['description']) { // no HTML, make clickable
			echo nl2br(make_clickable(strip_tags(preg_replace('/<br\s*\/?\>/i',
			 "\n", $event['description']))));
		}
		else { echo $event['description']; } // uses HTML, display AS IS
		echo '</div>';
	}
?>
<div id="EventDetailPadding"><table id="EventDetail" border="0" cellpadding="6" cellspacing="0">
<tbody><?php if (!empty($event['location']) || !empty($event['webmap'])) { ?><tr>
<td class="EventDetail-Label" nowrap="nowrap"><strong><?php echo lang('location'); ?>:</strong></td>
<td><?php
	if (!empty($event['location'])) { echo strip_tags($event['location']); }
	if (!empty($event['webmap'])) {
		echo ' <a href="' . htmlspecialchars(str_replace(' ', '+',
		 strip_tags(html_entity_decode($event['webmap']))), ENT_COMPAT, 'UTF-8') .
		 '" target="_blank">[' . lang('webmap') . ']</a>';
	}
?></td>
</tr><?php } if (!empty($event['price'])) { ?><tr>
<td class="EventDetail-Label" nowrap="nowrap"><strong><?php echo lang('price'); ?>:</strong></td>
<td><?php echo strip_tags($event['price']); ?></td>
</tr><?php } if (!empty($event['displayedsponsor'])) { ?><tr>
<td class="EventDetail-Label" nowrap="nowrap"><strong><?php echo lang('sponsor'); ?>:</strong></td>
<td><?php
	if (!empty($event['displayedsponsorurl'])) {
		echo '<a href="' . htmlspecialchars(str_replace(' ', '+', strip_tags(html_entity_decode($event['displayedsponsorurl']))), ENT_COMPAT, 'UTF-8') . '" target="_blank">' .
		 strip_tags($event['displayedsponsor']) . '</a>';
	}
	else {
		echo strip_tags($event['displayedsponsor']);
	}
?></td>
</tr><?php } if (!empty($event['contact_name']) ||
 !empty($event['contact_email']) || !empty($event['contact_phone'])) { ?><tr>
<td class="EventDetail-Label" nowrap="nowrap"><strong><?php echo lang('contact'); ?>:</strong></td>
<td><?php
	if (!empty($event['contact_name'])) { echo strip_tags($event['contact_name']) . '<br />' . "\n"; }
	if (!empty($event['contact_email'])) {
		$event['contact_email'] = htmlspecialchars(strip_tags(html_entity_decode($event['contact_email'])), ENT_COMPAT, 'UTF-8');
		echo '<img src="images/email.gif" width="20" height="20" alt="' . lang('email', false) .
		 '" class="valignMiddle" /> <a href="' . ((strpos($event['contact_email'], '://') === false)?
		 'mailto:' : '') . $event['contact_email'] . '">';
		if (strpos($event['contact_email'], '://') === false && !emailaddressok($event['contact_email'])) {
			echo '<b class="txtWarn bgWarn" title="Warning: Invalid E-Mail Format">' .
			 $event['contact_email'] . ' !!!</b>';
		}
		else { echo $event['contact_email']; }
		echo '</a><br />' . "\n";
	}
	if (!empty($event['contact_phone'])) {
		echo '<img src="images/phone.gif" width="20" height="20" alt="' .
		 lang('phone', false) . '" class="valignMiddle" /> ' .
		 strip_tags($event['contact_phone']) . '<br />' . "\n";
	}
?></td>
</tr><?php } ?></tbody>
</table></div>
<?php if ($linkfeatures) { ?>
<div id="iCalendarLink">
<?php if (!empty($event['id'])) { ?>
<a href="<?php echo EXPORT_PATH; ?>?calendarid=default&amp;format=ical&amp;id=<?php echo urlencode($event['id']); ?>"><img src="images/vcalendar.gif" width="20" height="20" alt="<?php echo lang('copy_event_to_pda', false); ?>" class="valignMiddle" /></a>
<a href="<?php echo EXPORT_PATH; ?>?calendarid=default&amp;format=ical&amp;id=<?php echo urlencode($event['id']); ?>"><?php echo lang('copy_event_to_pda', false); ?></a>
<?php } ?>
</div>
<?php } ?>
</td>
</tr></tbody>
</table>
<?php
}

function adminButtons($eventORshowdate, $buttons, $size, $orientation)
{
	if (is_array($buttons)) {
		if (isset($eventORshowdate['id']) && !isset($eventORshowdate['eventid'])) {
			$eventORshowdate['eventid'] = $eventORshowdate['id'];
		}
		elseif (!isset($eventORshowdate['id']) && isset($eventORshowdate['eventid'])) {
			$eventORshowdate['id'] = $eventORshowdate['eventid'];
		}
?>
<div<?php if ($size == 'small') { echo ' class="AdminButtons-Small"'; } ?>>
<table class="AdminButtons NoPrint" border="0" cellspacing="0" cellpadding="3">
<tbody><tr>
<?php
	foreach ($buttons as $button) {
		if ($button == 'new') {
			$IDExt = '-New';
			$HRef = 'addevent.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']);
			if (isset($eventORshowdate['year']) && isset($eventORshowdate['month']) &&
			 isset($eventORshowdate['day'])) {
				$HRef .= '&amp;timebegin_year=' . $eventORshowdate['year'] . '&amp;timebegin_month=' .
				 $eventORshowdate['month'] . '&amp;timebegin_day=' . $eventORshowdate['day'];
			}
			if ($size == 'small') { $Label = 'New'; }
			else { $Label = lang('add_new_event'); }
		}
		elseif ($button == 'approve') {
			$IDExt = '-Approve';
			$HRef = 'approval.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']);
			if (!empty($eventORshowdate['repeatid'])) { $HRef .= '&amp;approveall=1'; }
			else { $HRef .= '&amp;approvethis=1'; }
			$HRef .= '&amp;eventid=' . $eventORshowdate['eventid'];
			$Label = lang('approve');
		}
		elseif ($button == 'reject') {
			$IDExt = '-Reject';
			$HRef = 'approval.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
			 '&amp;reject=1&amp;eventid=' . $eventORshowdate['eventid'];
			$Label = lang('reject');
		}
		elseif ($button == 'edit') {
			$IDExt = '-Edit';
			$HRef = 'changeeinfo.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
			 '&amp;eventid=' . $eventORshowdate['eventid'];
			$Label = lang('edit');
		}
		elseif ($button == 'update') {
			$IDExt = '-Edit';
			$HRef = 'changeeinfo.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
			 '&amp;eventid=' . $eventORshowdate['eventid'];
			$Label = 'Update';
		}
		elseif ($button == 'copy') {
			$IDExt = '-Copy';
			$HRef = 'changeeinfo.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
			 '&amp;copy=1&amp;eventid=' . $eventORshowdate['eventid'];
			$Label = lang('copy');
		}
		elseif ($button == 'delete') {
			$IDExt = '-Delete';
			$HRef = 'deleteevent.php?calendarid=' . urlencode($_SESSION['CALENDAR_ID']) .
			 '&amp;check=1&amp;eventid=' . $eventORshowdate['eventid'];
			$Label = lang('delete');
		}
		if (isset($IDExt)) {
			if ($orientation == 'vertical') {
				echo '<tr>' . "\n" . '<td style="padding-bottom:3px !important">';
			}
			else { echo '<td style="padding-right:5px !important">'; }
			echo '<a class="AdminButtons' . $IDExt . '" href="' . $HRef . '">' . $Label . '</a></td>' . "\n";
			if ($orientation == 'vertical') { echo '</tr>'; }
		}
	}
?>
</tr></tbody>
</table></div>
<?php
	}
}
?>