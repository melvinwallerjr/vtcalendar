<?php
// Output the beginning of a section where content can be displayed.
// Normally, the background is colored and the background of the calendar cells are colored white.
// When any other content needs to be displayed, it should be enclosed by contentsection_begin and contentsection_end.
function contentsection_begin($headertext="", $showBackToMenuButton=false) {
	
	if ($showBackToMenuButton) {
		?><div id="MenuButton"><table border="0" cellpadding="3" cellspacing="0"><tr><td><b><a href="update.php"><?php echo lang('back_to_menu'); ?></a></b></td></tr></table></div><?php
	}
	
	?><div id="UpdateBlock"><div style="border: 1px solid #666666; padding: 8px;"><?php
	
  if (!empty($headertext)) {
    echo "<h2>".htmlentities($headertext).":</h2>";
	}
}

// Output the end of a section where content can be displayed.
// Normally, the background is colored and the background of the calendar cells are colored white.
// When any other content needs to be displayed, it should be enclosed by contentsection_begin and contentsection_end.
function contentsection_end() {
	?></div></div><?php
}

// Outputs the header HTML code for a pop-up help window. See helpwindow_footer() as well.
function helpwindow_header() {
	?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
		<title><?php echo lang('help'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta content="en-us" http-equiv=language>
		<link href="stylesheet.php" rel="stylesheet" type="text/css">
	</head>
	<body bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onLoad="this.window.focus()">
		<br>
		<table border="0" cellPadding="5" cellSpacing="0">
			<tr>
			<td bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>">&nbsp;</td>
			<td bgcolor="#eeeeee"><?php
} // end: function helpwindow_header
	
// Outputs the footer HTML code for a pop-up help window. See helpwindow_header() as well.
function helpwindow_footer() {
  ?></td>
				<td bgcolor="<?php echo $_SESSION["BGCOLOR"]; ?>">&nbsp;</td>
			</tr>
		</table>
		<br>
	</body>
	</html>
	<?php
} // end: function helpwindow_footer
?>