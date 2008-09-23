<?php

/* ==============================================
Generic Colors
============================================== */

// The default color of backgrounds inside the calendar.
if (!isset($_SESSION['COLOR_BG'])) $_SESSION['COLOR_BG'] = "#FFFFFF";

// Default color for text inside the calendar.
if (!isset($_SESSION['COLOR_TEXT'])) $_SESSION['COLOR_TEXT'] = "#000000";

// Faded color for events that have passed.
if (!isset($_SESSION['COLOR_TEXT_FADED'])) $_SESSION['COLOR_TEXT_FADED'] = "#666666";

// Text that is an urgent message.
if (!isset($_SESSION['COLOR_TEXT_WARNING'])) $_SESSION['COLOR_TEXT_WARNING'] = "#FF0000";

// Default link color.
if (!isset($_SESSION['COLOR_LINK'])) $_SESSION['COLOR_LINK'] = "#0000FF";

// General body color of the calendar.
if (!isset($_SESSION['COLOR_BODY'])) $_SESSION['COLOR_BODY'] = "#C3D9FF";

// Color that shows which day is today.
if (!isset($_SESSION['COLOR_TODAY'])) $_SESSION['COLOR_TODAY'] = "#FFE993";

// Lighter color that shows which day is today.
if (!isset($_SESSION['COLOR_TODAYLIGHT'])) $_SESSION['COLOR_TODAYLIGHT'] = "#FFFFCC";

// Background color for table cells that have a decent amount of content.
if (!isset($_SESSION['COLOR_LIGHT_CELL_BG'])) $_SESSION['COLOR_LIGHT_CELL_BG'] = "#EEEEEE";

// Background color for table headers.
if (!isset($_SESSION['COLOR_TABLE_HEADER_TEXT'])) $_SESSION['COLOR_TABLE_HEADER_TEXT'] = "#000000";

// Background color for table headers.
if (!isset($_SESSION['COLOR_TABLE_HEADER_BG'])) $_SESSION['COLOR_TABLE_HEADER_BG'] = "#DDDDDD";

// Faded color for past events.
if (!isset($_SESSION['COLOR_BORDER'])) $_SESSION['COLOR_BORDER'] = "#666666";

// Color used to highlight keywords in search results.
if (!isset($_SESSION['COLOR_KEYWORD_HIGHLIGHT'])) $_SESSION['COLOR_KEYWORD_HIGHLIGHT'] = "#FFFF99";

// Second level header used primarily on update.php.
if (!isset($_SESSION['COLOR_H2'])) $_SESSION['COLOR_H2'] = "#000000";

// Third level header used primarily on the changeeevent.php form.
if (!isset($_SESSION['COLOR_H3'])) $_SESSION['COLOR_H3'] = "#0066CC";

/* ==============================================
Title and Tabs
============================================== */

// Calendar title displayed to the left of the tabs.
if (!isset($_SESSION['COLOR_TITLE'])) $_SESSION['COLOR_TITLE'] = "#000000";

// Background color for navigation tabs that are not selected.
if (!isset($_SESSION['COLOR_TABGRAYED'])) $_SESSION['COLOR_TABGRAYED'] = "#CCCCCC";

/* ==============================================
Filter Notice
============================================== */

// Background color for the filter and search keyword notice box.
if (!isset($_SESSION['COLOR_FILTERNOTICE_BG'])) $_SESSION['COLOR_FILTERNOTICE_BG'] = "#AD2525";

// Font color for the filter and search keyword notice box.
if (!isset($_SESSION['COLOR_FILTERNOTICE_FONT'])) $_SESSION['COLOR_FILTERNOTICE_FONT'] = "#FFFFFF";

// Faded font color for the filter and search keyword notice box.
if (!isset($_SESSION['COLOR_FILTERNOTICE_FONTFADED'])) $_SESSION['COLOR_FILTERNOTICE_FONTFADED'] = "#FFBEBE";

// Background image for the filter and search keyword notice box (leave blank for no background image).
if (!isset($_SESSION['COLOR_FILTERNOTICE_BGIMAGE'])) $_SESSION['COLOR_FILTERNOTICE_BGIMAGE'] = "images/background-filter.gif";

/* ==============================================
Event Bar
============================================== */

// Colored bar displayed to the left of past event summaries
if (!isset($_SESSION['COLOR_EVENTBAR_PAST'])) $_SESSION['COLOR_EVENTBAR_PAST'] = "#CCCCCC";

// Colored bar displayed to the left of current event summaries
if (!isset($_SESSION['COLOR_EVENTBAR_CURRENT'])) $_SESSION['COLOR_EVENTBAR_CURRENT'] = "#9292FB";

// Colored bar displayed to the left of future event summaries
if (!isset($_SESSION['COLOR_EVENTBAR_FUTURE'])) $_SESSION['COLOR_EVENTBAR_FUTURE'] = "#A7A7FB";

/* ==============================================
Month Day Labels
============================================== */

// Background colors that appear when the mouse hovers over the day number in month view.
if (!isset($_SESSION['COLOR_MONTHDAYLABELS_PAST'])) $_SESSION['COLOR_MONTHDAYLABELS_PAST'] = "#DDDDDD";

// Background colors that appear when the mouse hovers over the day number in month view.
if (!isset($_SESSION['COLOR_MONTHDAYLABELS_CURRENT'])) $_SESSION['COLOR_MONTHDAYLABELS_CURRENT'] = "#FFD839";

// Background colors that appear when the mouse hovers over the day number in month view.
if (!isset($_SESSION['COLOR_MONTHDAYLABELS_FUTURE'])) $_SESSION['COLOR_MONTHDAYLABELS_FUTURE'] = "#DDDDFF";

/* ==============================================
Specific to Month View
============================================== */

// Background color for cells in month view that are not for the month currently being viewed.
if (!isset($_SESSION['COLOR_OTHERMONTH'])) $_SESSION['COLOR_OTHERMONTH'] = "#EEEEEE";

/* ==============================================
Little Calendar
============================================== */

// Color of the border around the current day in the little calendar
if (!isset($_SESSION['COLOR_LITTLECAL_TODAY'])) $_SESSION['COLOR_LITTLECAL_TODAY'] = "#004A80";

// Background color for days in the little calendar that are being displayed in the main calendar
if (!isset($_SESSION['COLOR_LITTLECAL_HIGHLIGHT'])) $_SESSION['COLOR_LITTLECAL_HIGHLIGHT'] = "#CCCCCC";

// Font color for days that are not part of the current month being displayed in the little calendar.
if (!isset($_SESSION['COLOR_LITTLECAL_FONTFADED'])) $_SESSION['COLOR_LITTLECAL_FONTFADED'] = "#999999";

// A small line below the S/M/T/W/T/F/S row in the little calendar
if (!isset($_SESSION['COLOR_LITTLECAL_LINE'])) $_SESSION['COLOR_LITTLECAL_LINE'] = "#999999";

/* ==============================================
Date Selector
============================================== */

// Background color for the date selector's GO button in the column
if (!isset($_SESSION['COLOR_GOBTN_BG'])) $_SESSION['COLOR_GOBTN_BG'] = "#FFCC66";

// Border color for the date selector's GO button in the column
if (!isset($_SESSION['COLOR_GOBTN_BORDER'])) $_SESSION['COLOR_GOBTN_BORDER'] = "#FFFFFF";

/* ==============================================
Admin Buttons
============================================== */

// Border color for 'New Event' Admin Buttons
if (!isset($_SESSION['COLOR_NEWBORDER'])) $_SESSION['COLOR_NEWBORDER'] = "#999933";

// Background color for 'New Event' Admin Buttons
if (!isset($_SESSION['COLOR_NEWBG'])) $_SESSION['COLOR_NEWBG'] = "#FFFFCC";

// Border color for 'Approve' Admin Buttons
if (!isset($_SESSION['COLOR_APPROVEBORDER'])) $_SESSION['COLOR_APPROVEBORDER'] = "#339933";

// Background color for 'Approve' Admin Buttons
if (!isset($_SESSION['COLOR_APPROVEBG'])) $_SESSION['COLOR_APPROVEBG'] = "#CCFFCC";

// Border color for 'Copy Event' Admin Buttons
if (!isset($_SESSION['COLOR_COPYBORDER'])) $_SESSION['COLOR_COPYBORDER'] = "#555599";

// Background color for 'Copy Event' Admin Buttons
if (!isset($_SESSION['COLOR_COPYBG'])) $_SESSION['COLOR_COPYBG'] = "#DDDDFF";

// Background color for 'Delete Event' Admin Buttons
if (!isset($_SESSION['COLOR_DELETEBORDER'])) $_SESSION['COLOR_DELETEBORDER'] = "#995555";

// Border color for 'Delete Event' Admin Buttons
if (!isset($_SESSION['COLOR_DELETEBG'])) $_SESSION['COLOR_DELETEBG'] = "#FFDDDD";

?>
