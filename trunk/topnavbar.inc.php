<?php
  if (!defined("ALLOWINCLUDES")) { exit; } // prohibits direct calling of include files
?>

<!-- Start of Top Navi Table -->
<table id="TopNaviTable" width="100%" border="0" cellpadding="3" cellspacing="0">
	<tr>
		<td class="TopNavi-ColorPadding">&nbsp;&nbsp;&nbsp;</td>
		<td id="TopNavi-Logo" valign="bottom"><a href="main.php?calendarid=<?php echo urlencode($_SESSION["CALENDARID"]);?>&view=upcoming<?php echo $queryStringExtension; ?>"><img src="images/logo.gif" alt="" width="34" height="34" border="0"></a></td>
		<td class="TopNavi-ColorPadding" width="100%" valign="bottom">
			<table width="100%" border="0" cellpadding="6" cellspacing="0">
				<tr>
					<td id="NaviBar-EventName" valign="bottom" nowrap><a href="main.php?calendarid=<?php echo urlencode($_SESSION["CALENDARID"]);?>&view=upcoming<?php echo $queryStringExtension; ?>"><?php if (isset($_SESSION["TITLE"])) { echo $_SESSION["TITLE"]; } else { echo lang('calendar'); } ?></a></td>
					<?php if (defined("SHOW_UPCOMING_TAB") && SHOW_UPCOMING_TAB) { ?>
						<td valign="bottom" <?php if ($navbaractive=="Upcoming") { echo 'id="NaviBar-Selected"'; }  ?> class="NaviBar-Tab"><div><?php if ($navbaractive=="Upcoming") echo lang('upcoming'); else { echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=upcoming" >',lang('upcoming'),'</a>'; } ?></div></td>
					<?php } ?>
					<td valign="bottom" <?php if ($navbaractive=="Day") { echo 'id="NaviBar-Selected"'; }  ?> class="NaviBar-Tab"><div><?php if ($navbaractive=="Day") echo lang('day'); else { echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=day&timebegin='.urlencode($timebegin).$queryStringExtension.'" >',lang('day'),'</a>'; } ?></div></td>
					<td valign="bottom" <?php if ($navbaractive=="Week") { echo 'id="NaviBar-Selected"'; }  ?> class="NaviBar-Tab"><div><?php if ($navbaractive=="Week") echo lang('week'); else { echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=week&timebegin='.urlencode($timebegin).$queryStringExtension.'" >',lang('week'),'</a>'; } ?></div></td>
					<?php if ($enableViewMonth) { ?>
						<td valign="bottom" <?php if ($navbaractive=="Month") { echo 'id="NaviBar-Selected"'; }  ?> class="NaviBar-Tab"><div><?php if ($navbaractive=="Month") echo lang('month'); else { echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=month&timebegin='.urlencode($timebegin).$queryStringExtension.'">',lang('month'),'</a>'; } ?></div></td>
					<?php } ?>
					<td valign="bottom" <?php if ($navbaractive=="Search" || $navbaractive=="SearchResults") { echo 'id="NaviBar-Selected"'; }  ?> class="NaviBar-Tab"><div><?php if ($navbaractive=="Search") echo lang('search'); else { echo '<a href="main.php?calendarid='.urlencode($_SESSION["CALENDARID"]).'&view=search">',lang('search'),'</a>'; } ?></div></td>
					<?php 
					
						if (!empty($_SESSION["AUTH_USERID"])) {
							?><td width="100%" align="right"><b><?php echo htmlentities($_SESSION["AUTH_USERID"]); ?></b> 
							<?php
							if (!empty($_SESSION["AUTH_SPONSORNAME"])) {
								echo "(";
								
								if (isset($_SESSION["AUTH_SPONSORCOUNT"]) && $_SESSION["AUTH_SPONSORCOUNT"] > 1) {
									echo '<a href="update.php?authsponsorid=" title="Change Sponsor">',htmlentities($_SESSION["AUTH_SPONSORNAME"]),"</a>";
								} else {
									echo htmlentities($_SESSION["AUTH_SPONSORNAME"]);
								}
								
								echo ")";
							}
							?>&nbsp;<?php //echo lang('is_logged_on'); ?></td>
						<td valign="bottom" class="NaviBar-Tab"><div><a href="logout.php">Logout</a></div></td>
							<?php
						}
						else {
							?><td width="100%">&nbsp;</td><?php
						}
					
					?></td>
					<td valign="bottom" <?php if ($navbaractive=="Update") { echo 'id="NaviBar-Selected"'; }  ?> class="NaviBar-Tab"><div><a href="<?php echo SECUREBASEURL; ?>update.php"><?php echo lang('update'); ?></a></div></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- End of Top Navi Table -->
