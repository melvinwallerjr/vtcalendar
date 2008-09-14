<?php // prohibits direct calling of include files
if (!defined("ALLOWINCLUDES")) { exit; } ?>

<!-- Start Body Column -->
<td id="CalRightCol" width="100%" valign="top" <?php if ($IsTodayBodyColor) echo 'class="TodayHighlighted"'; ?>>
	
	<!-- Start Filter Notice -->
	<?php
	  if ( $view == "day" || $view == "week" || $view == "month" || 
	       $view == "search" || $view == "searchresults"
	  	 ) { 
		  if (isset($filtercategories)) { ?>
				<table id="FilterNotice" width="100%" border="0" cellpadding="4" cellspacing="0">
				<tr>
					<td><b><?php echo lang('showing_filtered_events'); ?></b> <a href="main.php?calendarid=<?php echo $_SESSION["CALENDARID"]; ?>&view=filter">(<?php 
					$activecategories = "";
					for ($c=0; $c<$numcategories; $c++) {
						// determine if the current category has been selected previously
				    $categoryselected = array_key_exists( $categories_id[$c], $categoryfilter );
						if ( $categoryselected || count($filtercategories)==0 ) {
						  if (!empty($activecategories)) { $activecategories.=", "; }
							$activecategories .= $categories_name[$c];
				    }
				  }		
					if (strlen($activecategories) > 70) { $activecategories = substr($activecategories,0,70)."..."; }
					echo $activecategories;
					?>)</a></td>
				</tr>
				</table><?php
	    }
	  }
	?>
	<!-- End Filter Notice -->
	
	<!-- Start Date/Title and Next/Prev Navi -->
	<div id="TitleAndNavi" <?php if ($IsTodayBodyColor) echo 'class="TodayHighlighted"'; ?>>
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td id="DateOrTitle"><h2><?php require ( "main_".$view."_datetitle.inc.php" ); ?></h2></td>
			<td id="NavPreviousNext" align="right"><?php require ( "main_".$view."_navpreviousnext.inc.php" ); ?></td>
		</tr>
	</table>
	</div>
	<!-- End Date/Title and Next/Prev Navi -->
	
	<!-- Start Body -->
	<table width="100%" border="0" cellpadding="8" cellspacing="0">
		<tr>
			<td id="CalendarContent"><?php require ( "main_".$view."_body.inc.php" ); ?></td>
		</tr>
	</table>
	<!-- End Body -->

</td>
<!-- End Body Column -->