<?php
require_once('config.inc.php');
require_once('session_start.inc.php');
header("Content-Type: text/css");	

$BG = "#FFFFFF";

$Font = "#000000";
$Link = $_SESSION["LINKCOLOR"];

$BodyColor = "#c3d9ff"; //$_SESSION["MAINCOLOR"]; //"#FF9900";
$TodayColor = "#ffe993"; //$_SESSION["TODAYCOLOR"]; //"#FFCC66";
$TodayLightColor = "#ffffcc"; //"#FFECC6";

$TabGrayed = "#CCCCCC";
$TableHeader = "#DDDDDD";

$FilterBGColor = "#ad2525";
$FilterFontColor = "#FFFFFF";

$PastEventFont = "#666666";

$PastEventLeftBorder = "#CCCCCC";
$PastEventDayLabelHoverBG = "#DDDDDD";

$CurrentEventLeftBorder = "#9292fb"; //$_SESSION["TODAYCOLOR"];
$CurrentEventDayLabelHoverBG = "#ffd839"; //"#FF9900";

$FutureEventLeftBorder = "#A7A7FB";
$FutureEventDayLabelHoverBG = "#DDDDFF";

$NewBorder = "#999933";
$NewBG = "#FFFFCC";
$ApproveBorder = "#339933";
$ApproveBG = "#CCFFCC";
$CopyBorder = "#555599";
$CopyBG = "#DDDDFF";
$DeleteBorder = "#995555";
$DeleteBG = "#FFDDDD";

$LittleCalendar_SelectedDay = "#CCCCCC";
$LittleCalendar_NotMonth = "#999999";

$MonthDay_OtherMonth = "#EEEEEE";

?>
#CalendarBlock, #CalendarBlock td, #CalendarBlock p, #CalendarBlock h2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: <?php echo $Font; ?>;
}

#CalendarBlock a {
	color: <?php echo $Link; ?>;
}

/*===================================
             Top Navi Bar
===================================*/

table#TopNaviTable {
	border-bottom: 6px solid <?php echo $BodyColor; ?>;
}
table#TopNaviTable td {
	padding: 0;
}
td.TopNavi-ColorPadding {
	border-bottom: 8px solid <?php echo $BodyColor; ?>;
}
table#TopNaviTable td.TopNavi-ColorPadding td {
	padding-top: 8px;
}
table#TopNaviTable td#NaviBar-EventName {
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 8px;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
}
table#TopNaviTable td#NaviBar-EventName a {
	color: <?php echo $Font; ?>;
	text-decoration: none;
}
.NaviBar-Tab div {
	margin-left: 2px;
	margin-right: 2px;
	/*border-left: 2px solid <?php echo $BG; ?>;
	border-right: 2px solid <?php echo $BG; ?>;*/
	font-weight: bold;
	padding: 4px;
	padding-left: 12px;
	padding-right: 12px;
	background-color: <?php echo $TabGrayed; ?>;
}
.NaviBar-Tab a {

}
#NaviBar-Selected div {
	background-color: <?php echo $BodyColor; ?>;
}

/*===================================
             Page Body
===================================*/

#CalendarTable {
	background-color: <?php echo $BodyColor; ?>;
}

#CalLeftCol {
	padding: 0;
}

/*     Month Selector
--------------------------*/

#MonthSelector td {
	padding: 4px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
}
#MonthSelector a {
	text-decoration: none;
}
#MonthSelector a:hover, #MonthSelector a:focus {
	text-decoration: underline;
}

#MonthSelector div#LeftArrowButton, #MonthSelector div#RightArrowButton,
#MonthSelector div#LeftArrowButtonDisabled, #MonthSelector div#RightArrowButtonDisabled {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
}

/*    Little Calendar
--------------------------*/

div#LittleCalendar-Padding {
	padding: 3px;
	background-color: <?php echo $BG; ?>;
}

table#LittleCalendar {
	background-color: <?php echo $BG; ?>;
}

table#LittleCalendar td {
	padding: 0;
	font-family:  Arial, Helvetica, sans-serif;
	font-size: 11px;
}
table#LittleCalendar a {
	text-decoration: none;
	display: block;
	padding: 3px;
}

table#LittleCalendar thead td {
	border-bottom: 1px solid #999999;
	padding: 3px;
}

table#LittleCalendar td.SelectedDay {
	background-color: <?php echo $LittleCalendar_SelectedDay; ?>;
}

td.LittleCalendar-DaySelected a.LittleCal-Today, a.LittleCal-TodayGrayedOut {
	/*color: #000000 !important;*/
	border-color: #FF9900;
}

a.LittleCal-Today, a.LittleCal-TodayGrayedOut {
	padding: 1px !important;
	border: 2px solid #004a80<?php //echo $TodayColor; ?>;
}

a.LittleCal-GrayedOut, a.LittleCal-TodayGrayedOut {
	color: <?php echo $LittleCalendar_NotMonth; ?> !important;
}

/* Other Left Column Stuff
--------------------------*/

table#JumpToDateSelector td {
	padding-top: 6px;
	padding-bottom: 14px;
}
input#JumpToDateSelector-Button {
	background-color: #ffcc66<?php //echo $TodayColor; ?>;
	border: 1px solid #FFFFFF<?php //echo $BG; ?>;
}
form#JumpToDateSelectorForm {
	margin: 0; padding: 0;
}

td#CalLeftCol table#TodaysDate td {
	background-color: <?php echo $TodayColor; ?>;
	padding: 6px;
}

td#CalLeftCol table#SubscribeLink td {
	padding-top: 12px;
}

td#CalLeftCol table#CategoryFilterLink td {
	padding-top: 8px;
}

td#CalRightCol {
	padding: 0;
	border-color: <?php echo $BodyColor; ?>;
	border-left-style: solid;
	border-left-width: 7px;
	border-right-style: solid;
	border-right-width: 7px;
	background-color: <?php echo $BG; ?>;
}

td#CalRightCol.TodayHighlighted {
	border-color: <?php echo $TodayColor; ?> !important;
	border-bottom-style: solid;
	border-bottom-width: 7px;
}

/*     Filter Notice
--------------------------*/

table#FilterNotice td {
	padding: 4px;
	background-image: url(images/background-filter.gif);
	background-color: <?php echo $FilterBGColor; ?>;
	color: <?php echo $FilterFontColor; ?>;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
table#FilterNotice a {
	color: #ffbebe;
}
table#FilterNotice a:hover {
	color: #FFFFFF;
}

/*     Title & Navi
--------------------------*/

div#TitleAndNavi {
	background-color: <?php echo $BodyColor; ?>;
}

div#TitleAndNavi.TodayHighlighted {
	background-color: <?php echo $TodayColor; ?>;
}

div#TitleAndNavi td {
	padding: 4px;
}

div#TitleAndNavi a {
	text-decoration: none;
}
div#TitleAndNavi a:hover, div#TitleAndNavi a:focus {
	text-decoration: underline;
}

td#DateOrTitle {
	padding-left: 8px;
}
td#DateOrTitle h2 {
	padding: 0 !important;
	margin: 0 !important;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}

td#NavPreviousNext {
	padding-left: 18px !important;
}
td#NavPreviousNext td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	padding: 2px;
	padding-top: 0;
	padding-bottom: 0;
	/*font-weight: bold;*/
}
td#NavPreviousNext b {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
}

/*        Content
--------------------------*/

td#CalendarContent {
	padding: 3px;
}

/*===================================
             Event Table
===================================*/

#EventTable {
	background-color: <?php echo $BG; ?>;
}

#EventTable #EventLeftColumn {
	padding: 6px;
	font-size: 16px;
}
#EventTable #EventRightColumn {
	padding: 6px;
	border-left: 4px solid <?php echo $CurrentEventLeftBorder; ?>;
}
div#EventTitle {
	font-size: 18px;
}
p#EventDescription, div#EventDetailPadding, div#iCalendarLink {
	padding: 0;
	margin: 0;
	padding-top: 14px;
}
table#EventDetail {
	border-collapse: collapse;
}
table#EventDetail td {
	border: 1px solid #999999;
	padding: 4px;
	padding-right: 8px;
}
td.EventDetail-Label {
	background-color: <?php echo $TableHeader; ?>;
}

/*===================================
              Day Table
===================================*/

#DayTable td.NoAnnouncement {
	padding: 10px;
	font-size: 15px;
}

#DayTable td {
	padding: 4px;
}

#DayTable tr.BorderTop td {
	border-top: 1px solid #AAAAAA;
}
#DayTable div.EventLeftBar {
	padding-left: 5px;
	border-left: 5px solid <?php echo $CurrentEventLeftBorder; ?>;
}

#DayTable tr#FirstDateRow td.DateRow {
	padding: 0;
}

#DayTable td.DateRow div#TodayDateRow {
	background-color: #ffeb94;
}

#DayTable td.DateRow {
	font-size: 14px;
	font-weight: bold;
	padding: 0;
	padding-top: 8px;
	/*border-bottom: 1px solid #999999;*/
}

#DayTable td.DateRow a {
	/*color: #000066;*/
	text-decoration: none;
}

#DayTable td.DateRow a:hover {
	text-decoration: underline;
	/*color: #0000FF;*/
}

#DayTable td.DateRow div {
	padding: 8px;
	background-color: #c6dbff;
}

#DayTable td.TimeColumn i, #DayTable td.TimeColumn-Past i {
	font-style: normal;
	font-size: 11px;
}

#DayTable td.TimeColumn, #DayTable td.TimeColumn-Past {

}

#DayTable td.DataColumn, #DayTable td.DataColumn-Past {

}

#DayTable td.TimeColumn-Past, #DayTable td.DataColumn-Past {
	color: <?php echo $PastEventFont; ?>;
}
#DayTable td.DataColumn-Past a {
	color: <?php echo $PastEventFont; ?>;
	/*font-weight: normal;*/
}
#DayTable td.DataColumn-Past div.EventLeftBar {
	border-left-color: <?php echo $PastEventLeftBorder; ?>;
}

/*===================================
           Weekday Table
===================================*/

#WeekdayTable {
	border-collapse: collapse;
}

#WeekdayTable td {
	padding: 4px;
	border: 1px solid #999999;
}

#WeekdayTable td td {
	padding: 0;
	border: 0 none #000000;
	background-color: transparent !important;
}

/*  Weekday Header Styles
--------------------------*/

#WeekdayTable thead td {
	background-color: <?php echo $TableHeader; ?>;
}

#WeekdayTable thead td.Weekday-Today {
	background-color: <?php echo $TodayColor; ?> !important;
}

/*   Weekday Body Styles
--------------------------*/

#WeekdayTable tbody td.Weekday-Past {
	/*background-color: #EEEEEE;*/
}

#WeekdayTable tbody td.Weekday-Today {
	background-color: <?php echo $TodayLightColor; ?>;
}

#WeekdayTable tbody div.WeekEvent,
#WeekdayTable tbody div.WeekEvent-Past {
	padding-top: 2px;
	padding-bottom: 9px;
}
#WeekdayTable tbody div.WeekEvent-Past {
	color: <?php echo $PastEventFont; ?>;
}
#WeekdayTable tbody div.WeekEvent-Past a {
	color: <?php echo $PastEventFont; ?>;
}
#WeekdayTable tbody div.WeekEvent-Time {
	font-size: 11px;
	/*padding-left: 8px;*/
}
#WeekdayTable tbody div.WeekEvent-Title,
#WeekdayTable tbody div.WeekEvent-Category {
	border-left: 3px solid <?php echo $FutureEventLeftBorder; ?>;
	padding-left: 3px;
}
#WeekdayTable tbody td.Weekday-Today div.WeekEvent-Title,
#WeekdayTable tbody td.Weekday-Today div.WeekEvent-Category {
	border-left-color: <?php echo $CurrentEventLeftBorder; ?>;
}
#WeekdayTable tbody div.WeekEvent-Past div.WeekEvent-Title,
#WeekdayTable tbody div.WeekEvent-Past div.WeekEvent-Category {
	border-left-color: #DDDDDD;
}
#WeekdayTable tbody div.WeekEvent-Title a {
	text-decoration: none;
}
#WeekdayTable tbody div.WeekEvent-Title a:hover,
#WeekdayTable tbody div.WeekEvent-Title a:focus {
	text-decoration: underline;
}
#WeekdayTable tbody div.WeekEvent-Category {
	font-size: 11px;
	font-style: italic;
}

/*===================================
             Month Table
===================================*/

#MonthTable {
	border-collapse: collapse;
	background-color: <?php echo $BG; ?>;
}
#MonthTable td {
	border: 1px solid #AAAAAA;
	padding: 0;
}
#MonthTable thead td {
	background-color: <?php echo $TableHeader; ?>;
	padding: 5px;
}
#MonthTable tbody td {
	padding-bottom: 8px;
}
#MonthTable tbody td td {
	padding: 0 !important;
	margin: 0 !important;
	border: 0 !important;
}

#MonthTable div.DayNumber a {
	text-decoration: none !important;
	padding: 3px;
	padding-left: 4px;
	padding-bottom: 5px;
	line-height: 1;
	display: block;
}

#MonthTable p.EventItem,
#MonthTable p.EventItem-Past {
	padding: 0;
	margin: 0;
	margin-left: 3px;
	margin-right: 3px;
	padding-top: 2px;
	padding-bottom: 5px;
	padding-left: 8px;
	background-image: url("images/bullet.gif");
	background-repeat: no-repeat;
	background-position: 0 8px;
}

/* Hover color for the 'day number'. */
#MonthTable div.DayNumber a:hover,
#MonthTable div.DayNumber a:focus {
	background-color: <?php echo $FutureEventDayLabelHoverBG; ?>;
}

/* Background color for days that have past. */
#MonthTable tbody td.MonthDay-Past {
	/*background-color: #EEEEEE;*/
}

/* Background color for today. */
#MonthTable tbody td.MonthDay-Today {
	background-color: <?php echo $TodayLightColor; ?>;
}
/* Background color for the 'day number' for today. */
#MonthTable tbody td.MonthDay-Today div.DayNumber {
	background-color: <?php echo $TodayColor; ?> !important;
}

/* Link color for the 'day number' and events of past days. */
#MonthTable td.MonthDay-Past div.DayNumber a,
#MonthTable p.EventItem-Past a {
	color: <?php echo $PastEventFont; ?>;
}

/* Hover color for the 'day number' for past days. */
#MonthTable td.MonthDay-Past div.DayNumber a:hover,
#MonthTable td.MonthDay-Past div.DayNumber a:focus {
	background-color: <?php echo $PastEventDayLabelHoverBG; ?>;
}

/* Hover color for the 'day number' for today. */
#MonthTable td.MonthDay-Today div.DayNumber a:hover,
#MonthTable td.MonthDay-Today div.DayNumber a:focus {
	background-color: <?php echo $CurrentEventDayLabelHoverBG; ?>;
}
/* Top border color for past events
#MonthTable p.EventItem-Past {
	border-top: 1px solid <?php echo $PastEventDayLabelHoverBG; ?>;
} */
/* Bold links for today's events.
#MonthTable td.MonthDay-Today p.EventItem {
	font-weight: bold;
} */
/* Top border color for today's events (regardless if the individual event has past)
#MonthTable td.MonthDay-Today p.EventItem,
#MonthTable td.MonthDay-Today p.EventItem-Past {
	border-top: 1px solid <?php echo $CurrentEventDayLabelHoverBG; ?>;
} */

#MonthTable td.MonthDay-OtherMonth {
	background-color: <?php echo $MonthDay_OtherMonth; ?> !important;
}

#MonthTable a {
	text-decoration: none;
}
#MonthTable a:hover, #MonthTable a:focus {
	text-decoration: underline
}

/*===================================
            Misc Styles
===================================*/

#PoweredBy td {
	background-color: <?php echo $BodyColor; ?>;
	font-size: 11px;
	padding-right: 16px;
}
#PoweredBy td a {
	text-decoration: none;
}

#UpdateMainMenu h2 {
	font-size: 15px;
}

div#AdminButtons-Padding {
	padding: 5px;
}
table#AdminButtons td {
	border-style: none;
	border-width: 0;
	padding: 0;
}
div#AdminButtons-Padding td, div#AdminButtons-RightPadding td {
	padding-right: 8px;
}
table#AdminButtons a {
	text-align: center;
	display: block;
	padding: 5px;
	color: <?php echo $Font; ?>;
	font-weight: bold;
	font-size: 13px;
	text-decoration: none;
	border: 1px solid #999999;
	background-color: #DDDDDD;
	background-repeat: no-repeat;
	background-position: center left;
}
div#AdminButtons-Small table#AdminButtons a {
	padding: 2px;
	padding-left: 20px !important;
	font-weight: normal;
	font-size: 11px;
}
table#AdminButtons a#AdminButtons-New {
	text-align: left;
	padding-left: 25px;
	background-color: <?php echo $NewBG; ?>;
	border-color: <?php echo $NewBorder; ?>;
	background-image: url("images/new-button.gif");
}
div#AdminButtons-Small table#AdminButtons a#AdminButtons-New {
	background-image: url("images/new-small-button.gif");
}
table#AdminButtons a#AdminButtons-Edit {
	text-align: left;
	padding-left: 25px;
	background-color: <?php echo $NewBG; ?>;
	border-color: <?php echo $NewBorder; ?>;
	background-image: url("images/edit-button.gif");
}
div#AdminButtons-Small table#AdminButtons a#AdminButtons-Edit {
	background-image: url("images/edit-small-button.gif");
}
table#AdminButtons #AdminButtons-Copy {
	text-align: left;
	padding-left: 25px;
	background-color: <?php echo $CopyBG; ?>;
	border-color: <?php echo $CopyBorder; ?>;
	background-image: url("images/copy-button.gif");
}
div#AdminButtons-Small table#AdminButtons a#AdminButtons-Copy {
	background-image: url("images/copy-small-button.gif");
}
table#AdminButtons #AdminButtons-Delete, table#AdminButtons #AdminButtons-Reject {
	text-align: left;
	padding-left: 25px;
	background-color: <?php echo $DeleteBG; ?>;
	border-color: <?php echo $DeleteBorder; ?>;
	background-image: url("images/delete-button.gif");
}
div#AdminButtons-Small table#AdminButtons a#AdminButtons-Delete, div#AdminButtons-Small table#AdminButtons a#AdminButtons-Reject {
	background-image: url("images/delete-small-button.gif");
}
table#AdminButtons a#AdminButtons-Approve {
	text-align: left;
	padding-left: 25px;
	background-color: <?php echo $ApproveBG; ?>;
	border-color: <?php echo $ApproveBorder; ?>;
	background-image: url("images/ok-button.gif");
}
div#AdminButtons-Small table#AdminButtons a#AdminButtons-Approve {
	background-image: url("images/ok-small-button.gif");
}

dd {
	margin-left: 20px;
}

div#UpdateBlock {
	background-color: <?php echo $BG; ?>;
	/*border: 8px solid <?php echo $BodyColor; ?>;*/
	border-top-style: none;
	border-top-width: 0;
}
div#UpdateBlock h2 {
	padding: 0;
	margin: 0;
	font-size: 18px;
	font-weight: normal;
}

div#MenuButton {
	background-color: <?php echo $BodyColor; ?>;
	padding-left: 8px;
}
div#MenuButton td {
	padding: 0;
}
div#MenuButton a {
	text-decoration: none;
	font-weight: bold;
	padding: 6px;
	display: block;
	padding-left: 28px;
	background-color: <?php echo $BodyColor; ?>;
	background-repeat: no-repeat;
	background-position: center left;
	background-image: url("images/arrow-doubleback.gif");
}
div#MenuButton a:hover, div#MenuButton a:focus {
	background-color: <?php echo $TodayColor; ?>;
}

/* The following two styles are for manageevents.php */
.DefaultCalendarEvent {
	padding-left: 8px;
}
.DefaultCalendarEvent div {
	padding-left: 15px;
	background-image: url("images/subeventdoublearrow.gif");
	background-repeat: no-repeat;
	background-position: 0 3px;
}