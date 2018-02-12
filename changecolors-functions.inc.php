<?php
function LoadVariables()
{
	global $VariableErrors;
	if (!isset($_POST['bg']) || !setVar($GLOBALS['Color_bg'], $_POST['bg'], 'color')) {
		if (isset($_POST['bg'])) { $VariableErrors['bg'] = $_POST['bg']; }
		$GLOBALS['Color_bg'] = $_SESSION['COLOR_BG'];
	};
	if (!isset($_POST['text']) || !setVar($GLOBALS['Color_text'], $_POST['text'], 'color')) {
		if (isset($_POST['text'])) { $VariableErrors['text'] = $_POST['text']; }
		$GLOBALS['Color_text'] = $_SESSION['COLOR_TEXT'];
	}
	if (!isset($_POST['text_faded']) || !setVar($GLOBALS['Color_text_faded'], $_POST['text_faded'], 'color')) {
		if (isset($_POST['text_faded'])) { $VariableErrors['text_faded'] = $_POST['text_faded']; }
		$GLOBALS['Color_text_faded'] = $_SESSION['COLOR_TEXT_FADED'];
	}
	if (!isset($_POST['text_warning']) ||
	 !setVar($GLOBALS['Color_text_warning'], $_POST['text_warning'], 'color')) {
		if (isset($_POST['text_warning'])) { $VariableErrors['text_warning'] = $_POST['text_warning']; }
		$GLOBALS['Color_text_warning'] = $_SESSION['COLOR_TEXT_WARNING'];
	}
	if (!isset($_POST['link']) || !setVar($GLOBALS['Color_link'], $_POST['link'], 'color')) {
		if (isset($_POST['link'])) { $VariableErrors['link'] = $_POST['link']; }
		$GLOBALS['Color_link'] = $_SESSION['COLOR_LINK'];
	}
	if (!isset($_POST['body']) || !setVar($GLOBALS['Color_body'], $_POST['body'], 'color')) {
		if (isset($_POST['body'])) { $VariableErrors['body'] = $_POST['body']; }
		$GLOBALS['Color_body'] = $_SESSION['COLOR_BODY'];
	}
	if (!isset($_POST['today']) || !setVar($GLOBALS['Color_today'], $_POST['today'], 'color')) {
		if (isset($_POST['today'])) { $VariableErrors['today'] = $_POST['today']; }
		$GLOBALS['Color_today'] = $_SESSION['COLOR_TODAY'];
	}
	if (!isset($_POST['todaylight']) || !setVar($GLOBALS['Color_todaylight'], $_POST['todaylight'], 'color')) {
		if (isset($_POST['todaylight'])) { $VariableErrors['todaylight'] = $_POST['todaylight']; }
		$GLOBALS['Color_todaylight'] = $_SESSION['COLOR_TODAYLIGHT'];
	}
	if (!isset($_POST['light_cell_bg']) ||
	 !setVar($GLOBALS['Color_light_cell_bg'], $_POST['light_cell_bg'], 'color')) {
		if (isset($_POST['light_cell_bg'])) { $VariableErrors['light_cell_bg'] = $_POST['light_cell_bg']; }
		$GLOBALS['Color_light_cell_bg'] = $_SESSION['COLOR_LIGHT_CELL_BG'];
	}
	if (!isset($_POST['table_header_text']) ||
	 !setVar($GLOBALS['Color_table_header_text'], $_POST['table_header_text'], 'color')) {
		if (isset($_POST['table_header_text'])) {
			$VariableErrors['table_header_text'] = $_POST['table_header_text'];
		}
		$GLOBALS['Color_table_header_text'] = $_SESSION['COLOR_TABLE_HEADER_TEXT'];
	}
	if (!isset($_POST['table_header_bg']) ||
	 !setVar($GLOBALS['Color_table_header_bg'], $_POST['table_header_bg'], 'color')) {
		if (isset($_POST['table_header_bg'])) {
			$VariableErrors['table_header_bg'] = $_POST['table_header_bg'];
		}
		$GLOBALS['Color_table_header_bg'] = $_SESSION['COLOR_TABLE_HEADER_BG'];
	}
	if (!isset($_POST['border']) || !setVar($GLOBALS['Color_border'], $_POST['border'], 'color')) {
		if (isset($_POST['border'])) { $VariableErrors['border'] = $_POST['border']; }
		$GLOBALS['Color_border'] = $_SESSION['COLOR_BORDER'];
	}
	if (!isset($_POST['keyword_highlight']) ||
	 !setVar($GLOBALS['Color_keyword_highlight'], $_POST['keyword_highlight'], 'color')) {
		if (isset($_POST['keyword_highlight'])) {
			$VariableErrors['keyword_highlight'] = $_POST['keyword_highlight'];
		}
		$GLOBALS['Color_keyword_highlight'] = $_SESSION['COLOR_KEYWORD_HIGHLIGHT'];
	}
	if (!isset($_POST['h2']) || !setVar($GLOBALS['Color_h2'], $_POST['h2'], 'color')) {
		if (isset($_POST['h2'])) { $VariableErrors['h2'] = $_POST['h2']; }
		$GLOBALS['Color_h2'] = $_SESSION['COLOR_H2'];
	}
	if (!isset($_POST['h3']) || !setVar($GLOBALS['Color_h3'], $_POST['h3'], 'color')) {
		if (isset($_POST['h3'])) { $VariableErrors['h3'] = $_POST['h3']; }
		$GLOBALS['Color_h3'] = $_SESSION['COLOR_H3'];
	}
	if (!isset($_POST['title']) || !setVar($GLOBALS['Color_title'], $_POST['title'], 'color')) {
		if (isset($_POST['title'])) { $VariableErrors['title'] = $_POST['title']; }
		$GLOBALS['Color_title'] = $_SESSION['COLOR_TITLE'];
	}
	if (!isset($_POST['tabgrayed_text']) ||
	 !setVar($GLOBALS['Color_tabgrayed_text'], $_POST['tabgrayed_text'], 'color')) {
		if (isset($_POST['tabgrayed_text'])) { $VariableErrors['tabgrayed_text'] = $_POST['tabgrayed_text']; }
		$GLOBALS['Color_tabgrayed_text'] = $_SESSION['COLOR_TABGRAYED_TEXT'];
	}
	if (!isset($_POST['tabgrayed_bg']) ||
	 !setVar($GLOBALS['Color_tabgrayed_bg'], $_POST['tabgrayed_bg'], 'color')) {
		if (isset($_POST['tabgrayed_bg'])) { $VariableErrors['tabgrayed_bg'] = $_POST['tabgrayed_bg']; }
		$GLOBALS['Color_tabgrayed_bg'] = $_SESSION['COLOR_TABGRAYED_BG'];
	}
	if (!isset($_POST['filternotice_bg']) ||
	 !setVar($GLOBALS['Color_filternotice_bg'], $_POST['filternotice_bg'], 'color')) {
		if (isset($_POST['filternotice_bg'])) {
			$VariableErrors['filternotice_bg'] = $_POST['filternotice_bg'];
		}
		$GLOBALS['Color_filternotice_bg'] = $_SESSION['COLOR_FILTERNOTICE_BG'];
	}
	if (!isset($_POST['filternotice_font']) ||
	 !setVar($GLOBALS['Color_filternotice_font'], $_POST['filternotice_font'], 'color')) {
		if (isset($_POST['filternotice_font'])) {
			$VariableErrors['filternotice_font'] = $_POST['filternotice_font'];
		}
		$GLOBALS['Color_filternotice_font'] = $_SESSION['COLOR_FILTERNOTICE_FONT'];
	}
	if (!isset($_POST['filternotice_fontfaded']) ||
	 !setVar($GLOBALS['Color_filternotice_fontfaded'], $_POST['filternotice_fontfaded'], 'color')) {
		if (isset($_POST['filternotice_fontfaded'])) {
			$VariableErrors['filternotice_fontfaded'] = $_POST['filternotice_fontfaded'];
		}
		$GLOBALS['Color_filternotice_fontfaded'] = $_SESSION['COLOR_FILTERNOTICE_FONTFADED'];
	}
	if (!isset($_POST['filternotice_bgimage']) ||
	 !setVar($GLOBALS['Color_filternotice_bgimage'], $_POST['filternotice_bgimage'], 'background')) {
		if (isset($_POST['filternotice_bgimage'])) {
			$VariableErrors['filternotice_bgimage'] = $_POST['filternotice_bgimage'];
		}
		$GLOBALS['Color_filternotice_bgimage'] = $_SESSION['COLOR_FILTERNOTICE_BGIMAGE'];
	}
	if (!isset($_POST['eventbar_past']) ||
	 !setVar($GLOBALS['Color_eventbar_past'], $_POST['eventbar_past'], 'color')) {
		if (isset($_POST['eventbar_past'])) { $VariableErrors['eventbar_past'] = $_POST['eventbar_past']; }
		$GLOBALS['Color_eventbar_past'] = $_SESSION['COLOR_EVENTBAR_PAST'];
	}
	if (!isset($_POST['eventbar_current']) ||
	 !setVar($GLOBALS['Color_eventbar_current'], $_POST['eventbar_current'], 'color')) {
		if (isset($_POST['eventbar_current'])) {
			$VariableErrors['eventbar_current'] = $_POST['eventbar_current'];
		}
		$GLOBALS['Color_eventbar_current'] = $_SESSION['COLOR_EVENTBAR_CURRENT'];
	}
	if (!isset($_POST['eventbar_future']) ||
	 !setVar($GLOBALS['Color_eventbar_future'], $_POST['eventbar_future'], 'color')) {
		if (isset($_POST['eventbar_future'])) {
			$VariableErrors['eventbar_future'] = $_POST['eventbar_future'];
		}
		$GLOBALS['Color_eventbar_future'] = $_SESSION['COLOR_EVENTBAR_FUTURE'];
	}
	if (!isset($_POST['monthdaylabels_past']) ||
	 !setVar($GLOBALS['Color_monthdaylabels_past'], $_POST['monthdaylabels_past'], 'color')) {
		if (isset($_POST['monthdaylabels_past'])) {
			$VariableErrors['monthdaylabels_past'] = $_POST['monthdaylabels_past'];
		}
		$GLOBALS['Color_monthdaylabels_past'] = $_SESSION['COLOR_MONTHDAYLABELS_PAST'];
	}
	if (!isset($_POST['monthdaylabels_current']) ||
	 !setVar($GLOBALS['Color_monthdaylabels_current'], $_POST['monthdaylabels_current'], 'color')) {
		if (isset($_POST['monthdaylabels_current'])) {
			$VariableErrors['monthdaylabels_current'] = $_POST['monthdaylabels_current'];
		}
		$GLOBALS['Color_monthdaylabels_current'] = $_SESSION['COLOR_MONTHDAYLABELS_CURRENT'];
	}
	if (!isset($_POST['monthdaylabels_future']) ||
	 !setVar($GLOBALS['Color_monthdaylabels_future'], $_POST['monthdaylabels_future'], 'color')) {
		if (isset($_POST['monthdaylabels_future'])) {
			$VariableErrors['monthdaylabels_future'] = $_POST['monthdaylabels_future'];
		}
		$GLOBALS['Color_monthdaylabels_future'] = $_SESSION['COLOR_MONTHDAYLABELS_FUTURE'];
	}
	if (!isset($_POST['othermonth']) ||
	 !setVar($GLOBALS['Color_othermonth'], $_POST['othermonth'], 'color')) {
		if (isset($_POST['othermonth'])) { $VariableErrors['othermonth'] = $_POST['othermonth']; }
		$GLOBALS['Color_othermonth'] = $_SESSION['COLOR_OTHERMONTH'];
	}
	if (!isset($_POST['littlecal_today']) ||
	 !setVar($GLOBALS['Color_littlecal_today'], $_POST['littlecal_today'], 'color')) {
		if (isset($_POST['littlecal_today'])) {
			$VariableErrors['littlecal_today'] = $_POST['littlecal_today'];
		}
		$GLOBALS['Color_littlecal_today'] = $_SESSION['COLOR_LITTLECAL_TODAY'];
	}
	if (!isset($_POST['littlecal_highlight']) ||
	 !setVar($GLOBALS['Color_littlecal_highlight'], $_POST['littlecal_highlight'], 'color')) {
		if (isset($_POST['littlecal_highlight'])) {
			$VariableErrors['littlecal_highlight'] = $_POST['littlecal_highlight'];
		}
		$GLOBALS['Color_littlecal_highlight'] = $_SESSION['COLOR_LITTLECAL_HIGHLIGHT'];
	}
	if (!isset($_POST['littlecal_fontfaded']) ||
	 !setVar($GLOBALS['Color_littlecal_fontfaded'], $_POST['littlecal_fontfaded'], 'color')) {
		if (isset($_POST['littlecal_fontfaded'])) {
			$VariableErrors['littlecal_fontfaded'] = $_POST['littlecal_fontfaded'];
		}
		$GLOBALS['Color_littlecal_fontfaded'] = $_SESSION['COLOR_LITTLECAL_FONTFADED'];
	}
	if (!isset($_POST['littlecal_line']) ||
	 !setVar($GLOBALS['Color_littlecal_line'], $_POST['littlecal_line'], 'color')) {
		if (isset($_POST['littlecal_line'])) {
			$VariableErrors['littlecal_line'] = $_POST['littlecal_line'];
		}
		$GLOBALS['Color_littlecal_line'] = $_SESSION['COLOR_LITTLECAL_LINE'];
	}
	if (!isset($_POST['gobtn_bg']) || !setVar($GLOBALS['Color_gobtn_bg'], $_POST['gobtn_bg'], 'color')) {
		if (isset($_POST['gobtn_bg'])) { $VariableErrors['gobtn_bg'] = $_POST['gobtn_bg']; }
		$GLOBALS['Color_gobtn_bg'] = $_SESSION['COLOR_GOBTN_BG'];
	}
	if (!isset($_POST['gobtn_border']) ||
	 !setVar($GLOBALS['Color_gobtn_border'], $_POST['gobtn_border'], 'color')) {
		if (isset($_POST['gobtn_border'])) { $VariableErrors['gobtn_border'] = $_POST['gobtn_border']; }
		$GLOBALS['Color_gobtn_border'] = $_SESSION['COLOR_GOBTN_BORDER'];
	}
	if (!isset($_POST['newborder']) || !setVar($GLOBALS['Color_newborder'], $_POST['newborder'], 'color')) {
		if (isset($_POST['newborder'])) { $VariableErrors['newborder'] = $_POST['newborder']; }
		$GLOBALS['Color_newborder'] = $_SESSION['COLOR_NEWBORDER'];
	}
	if (!isset($_POST['newbg']) || !setVar($GLOBALS['Color_newbg'], $_POST['newbg'], 'color')) {
		if (isset($_POST['newbg'])) { $VariableErrors['newbg'] = $_POST['newbg']; }
		$GLOBALS['Color_newbg'] = $_SESSION['COLOR_NEWBG'];
	}
	if (!isset($_POST['approveborder']) ||
	 !setVar($GLOBALS['Color_approveborder'], $_POST['approveborder'], 'color')) {
		if (isset($_POST['approveborder'])) {
			$VariableErrors['approveborder'] = $_POST['approveborder'];
		}
		$GLOBALS['Color_approveborder'] = $_SESSION['COLOR_APPROVEBORDER'];
	}
	if (!isset($_POST['approvebg']) ||
	 !setVar($GLOBALS['Color_approvebg'], $_POST['approvebg'], 'color')) {
		if (isset($_POST['approvebg'])) { $VariableErrors['approvebg'] = $_POST['approvebg']; }
		$GLOBALS['Color_approvebg'] = $_SESSION['COLOR_APPROVEBG'];
	}
	if (!isset($_POST['copyborder']) ||
	 !setVar($GLOBALS['Color_copyborder'], $_POST['copyborder'], 'color')) {
		if (isset($_POST['copyborder'])) { $VariableErrors['copyborder'] = $_POST['copyborder']; }
		$GLOBALS['Color_copyborder'] = $_SESSION['COLOR_COPYBORDER'];
	}
	if (!isset($_POST['copybg']) || !setVar($GLOBALS['Color_copybg'], $_POST['copybg'], 'color')) {
		if (isset($_POST['copybg'])) { $VariableErrors['copybg'] = $_POST['copybg']; }
		$GLOBALS['Color_copybg'] = $_SESSION['COLOR_COPYBG'];
	}
	if (!isset($_POST['deleteborder']) ||
	 !setVar($GLOBALS['Color_deleteborder'], $_POST['deleteborder'], 'color')) {
		if (isset($_POST['deleteborder'])) { $VariableErrors['deleteborder'] = $_POST['deleteborder']; }
		$GLOBALS['Color_deleteborder'] = $_SESSION['COLOR_DELETEBORDER'];
	}
	if (!isset($_POST['deletebg']) || !setVar($GLOBALS['Color_deletebg'], $_POST['deletebg'],'color')) {
		if (isset($_POST['deletebg'])) { $VariableErrors['deletebg'] = $_POST['deletebg']; }
		$GLOBALS['Color_deletebg'] = $_SESSION['COLOR_DELETEBG'];
	}
}

function MakeColorUpdateSQL($calendarid, $type)
{
	if ($type == 'insert') {
		return "
INSERT INTO
	" . SCHEMANAME . "vtcal_colors
	(
		calendarid,
		bg,
		text,
		text_faded,
		text_warning,
		link,
		body,
		today,
		todaylight,
		light_cell_bg,
		table_header_text,
		table_header_bg,
		border,
		keyword_highlight,
		h2,
		h3,
		title,
		tabgrayed_text,
		tabgrayed_bg,
		filternotice_bg,
		filternotice_font,
		filternotice_fontfaded,
		filternotice_bgimage,
		eventbar_past,
		eventbar_current,
		eventbar_future,
		monthdaylabels_past,
		monthdaylabels_current,
		monthdaylabels_future,
		othermonth,
		littlecal_today,
		littlecal_highlight,
		littlecal_fontfaded,
		littlecal_line,
		gobtn_bg,
		gobtn_border,
		newborder,
		newbg,
		approveborder,
		approvebg,
		copyborder,
		copybg,
		deleteborder,
		deletebg
	)
VALUES
	(
		'" . sqlescape($calendarid) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_bg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_text'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_text_faded'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_text_warning'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_link'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_body'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_today'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_todaylight'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_light_cell_bg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_table_header_text'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_table_header_bg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_border'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_keyword_highlight'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_h2'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_h3'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_title'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_tabgrayed_text'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_tabgrayed_bg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_bg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_font'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_fontfaded'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_bgimage'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_eventbar_past'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_eventbar_current'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_eventbar_future'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_monthdaylabels_past'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_monthdaylabels_current'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_monthdaylabels_future'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_othermonth'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_today'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_highlight'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_fontfaded'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_line'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_gobtn_bg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_gobtn_border'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_newborder'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_newbg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_approveborder'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_approvebg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_copyborder'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_copybg'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_deleteborder'], 'UTF-8')) . "',
		'" . sqlescape(mb_strtoupper($GLOBALS['Color_deletebg'], 'UTF-8')) . "'
	)
";
	}
	else {
		return "
UPDATE
	" . SCHEMANAME . "vtcal_colors
SET
	bg='" . sqlescape(mb_strtoupper($GLOBALS['Color_bg'], 'UTF-8')) . "',
	text='" . sqlescape(mb_strtoupper($GLOBALS['Color_text'], 'UTF-8')) . "',
	text_faded='" . sqlescape(mb_strtoupper($GLOBALS['Color_text_faded'], 'UTF-8')) . "',
	text_warning='" . sqlescape(mb_strtoupper($GLOBALS['Color_text_warning'], 'UTF-8')) . "',
	link='" . sqlescape(mb_strtoupper($GLOBALS['Color_link'], 'UTF-8')) . "',
	body='" . sqlescape(mb_strtoupper($GLOBALS['Color_body'], 'UTF-8')) . "',
	today='" . sqlescape(mb_strtoupper($GLOBALS['Color_today'], 'UTF-8')) . "',
	todaylight='" . sqlescape(mb_strtoupper($GLOBALS['Color_todaylight'], 'UTF-8')) . "',
	light_cell_bg='" . sqlescape(mb_strtoupper($GLOBALS['Color_light_cell_bg'], 'UTF-8')) . "',
	table_header_text='" . sqlescape(mb_strtoupper($GLOBALS['Color_table_header_text'], 'UTF-8')) . "',
	table_header_bg='" . sqlescape(mb_strtoupper($GLOBALS['Color_table_header_bg'], 'UTF-8')) . "',
	border='" . sqlescape(mb_strtoupper($GLOBALS['Color_border'], 'UTF-8')) . "',
	keyword_highlight='" . sqlescape(mb_strtoupper($GLOBALS['Color_keyword_highlight'], 'UTF-8')) . "',
	h2='" . sqlescape(mb_strtoupper($GLOBALS['Color_h2'], 'UTF-8')) . "',
	h3='" . sqlescape(mb_strtoupper($GLOBALS['Color_h3'], 'UTF-8')) . "',
	title='" . sqlescape(mb_strtoupper($GLOBALS['Color_title'], 'UTF-8')) . "',
	tabgrayed_text='" . sqlescape(mb_strtoupper($GLOBALS['Color_tabgrayed_text'], 'UTF-8')) . "',
	tabgrayed_bg='" . sqlescape(mb_strtoupper($GLOBALS['Color_tabgrayed_bg'], 'UTF-8')) . "',
	filternotice_bg='" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_bg'], 'UTF-8')) . "',
	filternotice_font='" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_font'], 'UTF-8')) . "',
	filternotice_fontfaded='" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_fontfaded'], 'UTF-8')) . "',
	filternotice_bgimage='" . sqlescape(mb_strtoupper($GLOBALS['Color_filternotice_bgimage'], 'UTF-8')) . "',
	eventbar_past='" . sqlescape(mb_strtoupper($GLOBALS['Color_eventbar_past'], 'UTF-8')) . "',
	eventbar_current='" . sqlescape(mb_strtoupper($GLOBALS['Color_eventbar_current'], 'UTF-8')) . "',
	eventbar_future='" . sqlescape(mb_strtoupper($GLOBALS['Color_eventbar_future'], 'UTF-8')) . "',
	monthdaylabels_past='" . sqlescape(mb_strtoupper($GLOBALS['Color_monthdaylabels_past'], 'UTF-8')) . "',
	monthdaylabels_current='" . sqlescape(mb_strtoupper($GLOBALS['Color_monthdaylabels_current'], 'UTF-8')) . "',
	monthdaylabels_future='" . sqlescape(mb_strtoupper($GLOBALS['Color_monthdaylabels_future'], 'UTF-8')) . "',
	othermonth='" . sqlescape(mb_strtoupper($GLOBALS['Color_othermonth'], 'UTF-8')) . "',
	littlecal_today='" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_today'], 'UTF-8')) . "',
	littlecal_highlight='" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_highlight'], 'UTF-8')) . "',
	littlecal_fontfaded='" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_fontfaded'], 'UTF-8')) . "',
	littlecal_line='" . sqlescape(mb_strtoupper($GLOBALS['Color_littlecal_line'], 'UTF-8')) . "',
	gobtn_bg='" . sqlescape(mb_strtoupper($GLOBALS['Color_gobtn_bg'], 'UTF-8')) . "',
	gobtn_border='" . sqlescape(mb_strtoupper($GLOBALS['Color_gobtn_border'], 'UTF-8')) . "',
	newborder='" . sqlescape(mb_strtoupper($GLOBALS['Color_newborder'], 'UTF-8')) . "',
	newbg='" . sqlescape(mb_strtoupper($GLOBALS['Color_newbg'], 'UTF-8')) . "',
	approveborder='" . sqlescape(mb_strtoupper($GLOBALS['Color_approveborder'], 'UTF-8')) . "',
	approvebg='" . sqlescape(mb_strtoupper($GLOBALS['Color_approvebg'], 'UTF-8')) . "',
	copyborder='" . sqlescape(mb_strtoupper($GLOBALS['Color_copyborder'], 'UTF-8')) . "',
	copybg='" . sqlescape(mb_strtoupper($GLOBALS['Color_copybg'], 'UTF-8')) . "',
	deleteborder='" . sqlescape(mb_strtoupper($GLOBALS['Color_deleteborder'], 'UTF-8')) . "',
	deletebg='" . sqlescape(mb_strtoupper($GLOBALS['Color_deletebg'], 'UTF-8')) . "'
WHERE
	calendarid='" . sqlescape($calendarid) . "'
";
	}
}

function ShowColorError($msg)
{
	echo '<br />
<span class="txtWarn">' . htmlspecialchars('"' . $msg . '" ' . lang('invalid_color'), ENT_COMPAT, 'UTF-8') . '</span>';
}

function ShowForm()
{
	global $VariableErrors; ?>
<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_genericcolors'); ?>:</h3>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_bg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_bg']; ?>">&nbsp;</span></span>
<label for="Color_bg"><strong><?php echo lang('color_label_bg'); ?>:</strong></label><br />
<input type="text" id="Color_bg" name="bg" value="<?php echo $GLOBALS['Color_bg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_bg').click()" />
<?php
echo '<span onclick="ResetValue(\'bg\',\'' . DEFAULTCOLOR_BG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_BG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_bg');
if (isset($VariableErrors['bg'])) { ShowColorError($VariableErrors['bg']); }
?>
</p>

<p>
<span id="Swap_text" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_text']; ?>">&nbsp;</span></span>
<label for="Color_text"><strong><?php echo lang('color_label_text'); ?>:</strong></label><br />
<input type="text" id="Color_text" name="text" value="<?php echo $GLOBALS['Color_text']; ?>" size="8" readonly="readonly" onclick="$('#Swap_text').click()" />
<?php
echo '<span onclick="ResetValue(\'text\',\'' . DEFAULTCOLOR_TEXT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TEXT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_text');
if (isset($VariableErrors['text'])) { ShowColorError($VariableErrors['text']); }
?>
</p>

<p>
<span id="Swap_text_faded" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_text_faded']; ?>">&nbsp;</span></span>
<label for="Color_text_faded"><strong><?php echo lang('color_label_text_faded'); ?>:</strong></label><br />
<input type="text" id="Color_text_faded" name="text_faded" value="<?php echo $GLOBALS['Color_text_faded']; ?>" size="8" readonly="readonly" onclick="$('#Swap_text_faded').click()" />
<?php
echo '<span onclick="ResetValue(\'text_faded\',\'' . DEFAULTCOLOR_TEXT_FADED . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TEXT_FADED . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_text_faded');
if (isset($VariableErrors['text_faded'])) { ShowColorError($VariableErrors['text_faded']); }
?>
</p>

<p>
<span id="Swap_text_warning" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_text_warning']; ?>">&nbsp;</span></span>
<label for="Color_text_warning"><strong><?php echo lang('color_label_text_warning'); ?>:</strong></label><br />
<input type="text" id="Color_text_warning" name="text_warning" value="<?php echo $GLOBALS['Color_text_warning']; ?>" size="8" readonly="readonly" onclick="$('#Swap_text_warning').click()" />
<?php
echo '<span onclick="ResetValue(\'text_warning\',\'' . DEFAULTCOLOR_TEXT_WARNING . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TEXT_WARNING . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_text_warning');
if (isset($VariableErrors['text_warning'])) { ShowColorError($VariableErrors['text_warning']); }
?>
</p>

<p>
<span id="Swap_link" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_link']; ?>">&nbsp;</span></span>
<label for="Color_link"><strong><?php echo lang('color_label_link'); ?>:</strong></label><br />
<input type="text" id="Color_link" name="link" value="<?php echo $GLOBALS['Color_link']; ?>" size="8" readonly="readonly" onclick="$('#Swap_link').click()" />
<?php
echo '<span onclick="ResetValue(\'link\',\'' . DEFAULTCOLOR_LINK . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_LINK . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_link');
if (isset($VariableErrors['link'])) { ShowColorError($VariableErrors['link']); }
?>
</p>

<p>
<span id="Swap_body" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_body']; ?>">&nbsp;</span></span>
<label for="Color_body"><strong><?php echo lang('color_label_body'); ?>:</strong></label><br />
<input type="text" id="Color_body" name="body" value="<?php echo $GLOBALS['Color_body']; ?>" size="8" readonly="readonly" onclick="$('#Swap_body').click()" />
<?php
echo '<span onclick="ResetValue(\'body\',\'' . DEFAULTCOLOR_BODY . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_BODY . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_body');
if (isset($VariableErrors['body'])) { ShowColorError($VariableErrors['body']); }
?>
</p>

<p>
<span id="Swap_today" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_today']; ?>">&nbsp;</span></span>
<label for="Color_today"><strong><?php echo lang('color_label_today'); ?>:</strong></label><br />
<input type="text" id="Color_today" name="today" value="<?php echo $GLOBALS['Color_today']; ?>" size="8" readonly="readonly" onclick="$('#Swap_today').click()" />
<?php
echo '<span onclick="ResetValue(\'today\',\'' . DEFAULTCOLOR_TODAY . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TODAY . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_today');
if (isset($VariableErrors['today'])) { ShowColorError($VariableErrors['today']); }
?>
</p>

<p>
<span id="Swap_todaylight" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_todaylight']; ?>">&nbsp;</span></span>
<label for="Color_todaylight"><strong><?php echo lang('color_label_todaylight'); ?>:</strong></label><br />
<input type="text" id="Color_todaylight" name="todaylight" value="<?php echo $GLOBALS['Color_todaylight']; ?>" size="8" readonly="readonly" onclick="$('#Swap_todaylight').click()" />
<?php
echo '<span onclick="ResetValue(\'todaylight\',\'' . DEFAULTCOLOR_TODAYLIGHT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TODAYLIGHT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_todaylight');
if (isset($VariableErrors['todaylight'])) { ShowColorError($VariableErrors['todaylight']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_light_cell_bg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_light_cell_bg']; ?>">&nbsp;</span></span>
<label for="Color_light_cell_bg"><strong><?php echo lang('color_label_light_cell_bg'); ?>:</strong></label><br />
<input type="text" id="Color_light_cell_bg" name="light_cell_bg" value="<?php echo $GLOBALS['Color_light_cell_bg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_light_cell_bg').click()" />
<?php
echo '<span onclick="ResetValue(\'light_cell_bg\',\'' . DEFAULTCOLOR_LIGHT_CELL_BG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_LIGHT_CELL_BG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_light_cell_bg');
if (isset($VariableErrors['light_cell_bg'])) { ShowColorError($VariableErrors['light_cell_bg']); }
?>
</p>

<p>
<span id="Swap_table_header_text" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_table_header_text']; ?>">&nbsp;</span></span>
<label for="Color_table_header_text"><strong><?php echo lang('color_label_table_header_text'); ?>:</strong></label><br />
<input type="text" id="Color_table_header_text" name="table_header_text" value="<?php echo $GLOBALS['Color_table_header_text']; ?>" size="8" readonly="readonly" onclick="$('#Swap_table_header_text').click()" />
<?php
echo '<span onclick="ResetValue(\'table_header_text\',\'' . DEFAULTCOLOR_TABLE_HEADER_TEXT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TABLE_HEADER_TEXT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_table_header_text');
if (isset($VariableErrors['table_header_text'])) { ShowColorError($VariableErrors['table_header_text']); } ?>
</p>

<p>
<span id="Swap_table_header_bg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_table_header_bg']; ?>">&nbsp;</span></span>
<label for="Color_table_header_bg"><strong><?php echo lang('color_label_table_header_bg'); ?>:</strong></label><br />
<input type="text" id="Color_table_header_bg" name="table_header_bg" value="<?php echo $GLOBALS['Color_table_header_bg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_table_header_bg').click()" />
<?php
echo '<span onclick="ResetValue(\'table_header_bg\',\'' . DEFAULTCOLOR_TABLE_HEADER_BG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TABLE_HEADER_BG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_table_header_bg');
if (isset($VariableErrors['table_header_bg'])) { ShowColorError($VariableErrors['table_header_bg']); }
?>
</p>

<p>
<span id="Swap_border" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_border']; ?>">&nbsp;</span></span>
<label for="Color_border"><strong><?php echo lang('color_label_border'); ?>:</strong></label><br />
<input type="text" id="Color_border" name="border" value="<?php echo $GLOBALS['Color_border']; ?>" size="8" readonly="readonly" onclick="$('#Swap_border').click()" />
<?php
echo '<span onclick="ResetValue(\'border\',\'' . DEFAULTCOLOR_BORDER . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_BORDER . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_border');
if (isset($VariableErrors['border'])) { ShowColorError($VariableErrors['border']); }
?>
</p>

<p>
<span id="Swap_keyword_highlight" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_keyword_highlight']; ?>">&nbsp;</span></span>
<label for="Color_keyword_highlight"><strong><?php echo lang('color_label_keyword_highlight'); ?>:</strong></label><br />
<input type="text" id="Color_keyword_highlight" name="keyword_highlight" value="<?php echo $GLOBALS['Color_keyword_highlight']; ?>" size="8" readonly="readonly" onclick="$('#Swap_keyword_highlight').click()" />
<?php
echo '<span onclick="ResetValue(\'keyword_highlight\',\'' . DEFAULTCOLOR_KEYWORD_HIGHLIGHT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_KEYWORD_HIGHLIGHT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_keyword_highlight');
if (isset($VariableErrors['keyword_highlight'])) { ShowColorError($VariableErrors['keyword_highlight']); }
?>
</p>

<p>
<span id="Swap_h2" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_h2']; ?>">&nbsp;</span></span>
<label for="Color_h2"><strong><?php echo lang('color_label_h2'); ?>:</strong></label><br />
<input type="text" id="Color_h2" name="h2" value="<?php echo $GLOBALS['Color_h2']; ?>" size="8" readonly="readonly" onclick="$('#Swap_h2').click()" />
<?php
echo '<span onclick="ResetValue(\'h2\',\'' . DEFAULTCOLOR_H2 . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_H2 . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_h2');
if (isset($VariableErrors['h2'])) { ShowColorError($VariableErrors['h2']); }
?>
</p>

<p>
<span id="Swap_h3" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_h3']; ?>">&nbsp;</span></span>
<label for="Color_h3"><strong><?php echo lang('color_label_h3'); ?>:</strong></label><br />
<input type="text" id="Color_h3" name="h3" value="<?php echo $GLOBALS['Color_h3']; ?>" size="8" readonly="readonly" onclick="$('#Swap_h3').click()" />
<?php
echo '<span onclick="ResetValue(\'h3\',\'' . DEFAULTCOLOR_H3 . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_H3 . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_h3');
if (isset($VariableErrors['h3'])) { ShowColorError($VariableErrors['h3']); }
?>
</p>

</td></tr></tbody>
</table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_titletabs'); ?>:</h3>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_title" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_title']; ?>">&nbsp;</span></span>
<label for="Color_title"><strong><?php echo lang('color_label_title'); ?>:</strong></label><br />
<input type="text" id="Color_title" name="title" value="<?php echo $GLOBALS['Color_title']; ?>" size="8" readonly="readonly" onclick="$('#Swap_title').click()" />
<?php
echo '<span onclick="ResetValue(\'title\',\'' . DEFAULTCOLOR_TITLE . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TITLE . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_title');
if (isset($VariableErrors['title'])) { ShowColorError($VariableErrors['title']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_tabgrayed_text" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_tabgrayed_text']; ?>">&nbsp;</span></span>
<label for="Color_tabgrayed_text"><strong><?php echo lang('color_label_tabgrayed_text'); ?>:</strong></label><br />
<input type="text" id="Color_tabgrayed_text" name="tabgrayed_text" value="<?php echo $GLOBALS['Color_tabgrayed_text']; ?>" size="8" readonly="readonly" onclick="$('#Swap_tabgrayed_text').click()" />
<?php
echo '<span onclick="ResetValue(\'tabgrayed_text\',\'' . DEFAULTCOLOR_TABGRAYED_TEXT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TABGRAYED_TEXT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_tabgrayed_text');
if (isset($VariableErrors['tabgrayed_text'])) { ShowColorError($VariableErrors['tabgrayed_text']); }
?>
</p>

<p>
<span id="Swap_tabgrayed_bg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_tabgrayed_bg']; ?>">&nbsp;</span></span>
<label for="Color_tabgrayed_bg"><strong><?php echo lang('color_label_tabgrayed_bg'); ?>:</strong></label><br />
<input type="text" id="Color_tabgrayed_bg" name="tabgrayed_bg" value="<?php echo $GLOBALS['Color_tabgrayed_bg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_tabgrayed_bg').click()" />
<?php
echo '<span onclick="ResetValue(\'tabgrayed_bg\',\'' . DEFAULTCOLOR_TABGRAYED_BG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_TABGRAYED_BG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_tabgrayed_bg');
if (isset($VariableErrors['tabgrayed_bg'])) { ShowColorError($VariableErrors['tabgrayed_bg']); }
?>
</p>

</td></tr></tbody>
</table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_filternotice'); ?>:</h3>
<p><?php echo lang('color_section_description_filternotice'); ?></p>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_filternotice_bg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_filternotice_bg']; ?>">&nbsp;</span></span>
<label for="Color_filternotice_bg"><strong><?php echo lang('color_label_filternotice_bg'); ?>:</strong></label><br />
<input type="text" id="Color_filternotice_bg" name="filternotice_bg" value="<?php echo $GLOBALS['Color_filternotice_bg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_filternotice_bg').click()" />
<?php
echo '<span onclick="ResetValue(\'filternotice_bg\',\'' . DEFAULTCOLOR_FILTERNOTICE_BG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_FILTERNOTICE_BG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_filternotice_bg');
if (isset($VariableErrors['filternotice_bg'])) { ShowColorError($VariableErrors['filternotice_bg']); }
?>
</p>

<p>
<span id="Swap_filternotice_font" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_filternotice_font']; ?>">&nbsp;</span></span>
<label for="Color_filternotice_font"><strong><?php echo lang('color_label_filternotice_font'); ?>:</strong></label><br />
<input type="text" id="Color_filternotice_font" name="filternotice_font" value="<?php echo $GLOBALS['Color_filternotice_font']; ?>" size="8" readonly="readonly" onclick="$('#Swap_filternotice_font').click()" />
<?php
echo '<span onclick="ResetValue(\'filternotice_font\',\'' . DEFAULTCOLOR_FILTERNOTICE_FONT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_FILTERNOTICE_FONT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_filternotice_font');
if (isset($VariableErrors['filternotice_font'])) { ShowColorError($VariableErrors['filternotice_font']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_filternotice_fontfaded" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_filternotice_fontfaded']; ?>">&nbsp;</span></span>
<label for="Color_filternotice_fontfaded"><strong><?php echo lang('color_label_filternotice_fontfaded'); ?>:</strong></label><br />
<input type="text" id="Color_filternotice_fontfaded" name="filternotice_fontfaded" value="<?php echo $GLOBALS['Color_filternotice_fontfaded']; ?>" size="8" readonly="readonly" onclick="$('#Swap_filternotice_fontfaded').click()" />
<?php
echo '<span onclick="ResetValue(\'filternotice_fontfaded\',\'' . DEFAULTCOLOR_FILTERNOTICE_FONTFADED . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_FILTERNOTICE_FONTFADED . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_filternotice_fontfaded');
if (isset($VariableErrors['filternotice_fontfaded'])) { ShowColorError($VariableErrors['filternotice_fontfaded']); }
?>
</p>

<p>
<label for="Color_filternotice_bgimage"><strong><?php echo lang('color_label_filternotice_bgimage'); ?>:</strong></label><br />
<input type="text" id="Color_filternotice_bgimage" name="filternotice_bgimage" value="<?php echo $GLOBALS['Color_filternotice_bgimage']; ?>" size="60" /><br />
<?php
echo lang('color_description_filternotice_bgimage');
if (isset($VariableErrors['filternotice_bgimage'])) { ShowColorError($VariableErrors['filternotice_bgimage']); }
?>
</p>

</td></tr></tbody></table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_eventbar'); ?>:</h3>
<p><?php echo lang('color_section_description_eventbar'); ?></p>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_eventbar_past" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_eventbar_past']; ?>">&nbsp;</span></span>
<label for="Color_eventbar_past"><strong><?php echo lang('color_label_eventbar_past'); ?>:</strong></label><br />
<input type="text" id="Color_eventbar_past" name="eventbar_past" value="<?php echo $GLOBALS['Color_eventbar_past']; ?>" size="8" readonly="readonly" onclick="$('#Swap_eventbar_past').click()" />
<?php
echo '<span onclick="ResetValue(\'eventbar_past\',\'' . DEFAULTCOLOR_EVENTBAR_PAST . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_EVENTBAR_PAST . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_eventbar_past');
if (isset($VariableErrors['eventbar_past'])) { ShowColorError($VariableErrors['eventbar_past']); }
?>
</p>

<p>
<span id="Swap_eventbar_current" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_eventbar_current']; ?>">&nbsp;</span></span>
<label for="Color_eventbar_current"><strong><?php echo lang('color_label_eventbar_current'); ?>:</strong></label><br />
<input type="text" id="Color_eventbar_current" name="eventbar_current" value="<?php echo $GLOBALS['Color_eventbar_current']; ?>" size="8" readonly="readonly" onclick="$('#Swap_eventbar_current').click()" />
<?php
echo '<span onclick="ResetValue(\'eventbar_current\',\'' . DEFAULTCOLOR_EVENTBAR_CURRENT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_EVENTBAR_CURRENT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_eventbar_current');
if (isset($VariableErrors['eventbar_current'])) { ShowColorError($VariableErrors['eventbar_current']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_eventbar_future" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_eventbar_future']; ?>">&nbsp;</span></span>
<label for="Color_eventbar_future"><strong><?php echo lang('color_label_eventbar_future'); ?>:</strong></label><br />
<input type="text" id="Color_eventbar_future" name="eventbar_future" value="<?php echo $GLOBALS['Color_eventbar_future']; ?>" size="8" readonly="readonly" onclick="$('#Swap_eventbar_future').click()" />
<?php
echo '<span onclick="ResetValue(\'eventbar_future\',\'' . DEFAULTCOLOR_EVENTBAR_FUTURE . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_EVENTBAR_FUTURE . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_eventbar_future');
if (isset($VariableErrors['eventbar_future'])) { ShowColorError($VariableErrors['eventbar_future']); }
?>
</p>

</td></tr></tbody></table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_monthdaylabels'); ?>:</h3>
<p><?php echo lang('color_section_description_monthdaylabels'); ?></p>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_monthdaylabels_past" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_monthdaylabels_past']; ?>">&nbsp;</span></span>
<label for="Color_monthdaylabels_past"><strong><?php echo lang('color_label_monthdaylabels_past'); ?>:</strong></label><br />
<input type="text" id="Color_monthdaylabels_past" name="monthdaylabels_past" value="<?php echo $GLOBALS['Color_monthdaylabels_past']; ?>" size="8" readonly="readonly" onclick="$('#Swap_monthdaylabels_past').click()" />
<?php
echo '<span onclick="ResetValue(\'monthdaylabels_past\', \'' . DEFAULTCOLOR_MONTHDAYLABELS_PAST . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_MONTHDAYLABELS_PAST . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_monthdaylabels_past');
if (isset($VariableErrors['monthdaylabels_past'])) { ShowColorError($VariableErrors['monthdaylabels_past']); }
?>
</p>

<p>
<span id="Swap_monthdaylabels_current" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_monthdaylabels_current']; ?>">&nbsp;</span></span>
<label for="Color_monthdaylabels_current"><strong><?php echo lang('color_label_monthdaylabels_current'); ?>:</strong></label><br />
<input type="text" id="Color_monthdaylabels_current" name="monthdaylabels_current" value="<?php echo $GLOBALS['Color_monthdaylabels_current']; ?>" size="8" readonly="readonly" onclick="$('#Swap_monthdaylabels_current').click()" />
<?php
echo '<span onclick="ResetValue(\'monthdaylabels_current\',\'' . DEFAULTCOLOR_MONTHDAYLABELS_CURRENT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_MONTHDAYLABELS_CURRENT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_monthdaylabels_current');
if (isset($VariableErrors['monthdaylabels_current'])) { ShowColorError($VariableErrors['monthdaylabels_current']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_monthdaylabels_future" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_monthdaylabels_future']; ?>">&nbsp;</span></span>
<label for="Color_monthdaylabels_future"><strong><?php echo lang('color_label_monthdaylabels_future'); ?>:</strong></label><br />
<input type="text" id="Color_monthdaylabels_future" name="monthdaylabels_future" value="<?php echo $GLOBALS['Color_monthdaylabels_future']; ?>" size="8" readonly="readonly" onclick="$('#Swap_monthdaylabels_future').click()" />
<?php
echo '<span onclick="ResetValue(\'monthdaylabels_future\',\'' . DEFAULTCOLOR_MONTHDAYLABELS_FUTURE . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_MONTHDAYLABELS_FUTURE . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_monthdaylabels_future');
if (isset($VariableErrors['monthdaylabels_future'])) { ShowColorError($VariableErrors['monthdaylabels_future']); }
?>
</p>

</td></tr></tbody></table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_monthspecific'); ?>:</h3>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_othermonth" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_othermonth']; ?>">&nbsp;</span></span>
<label for="Color_othermonth"><strong><?php echo lang('color_label_othermonth'); ?>:</strong></label><br />
<input type="text" id="Color_othermonth" name="othermonth" value="<?php echo $GLOBALS['Color_othermonth']; ?>" size="8" readonly="readonly" onclick="$('#Swap_othermonth').click()" />
<?php
echo '<span onclick="ResetValue(\'othermonth\',\'' . DEFAULTCOLOR_OTHERMONTH . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_OTHERMONTH . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_othermonth');
if (isset($VariableErrors['othermonth'])) { ShowColorError($VariableErrors['othermonth']); }
?>
</p>

</td></tr></tbody>
</table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_littlecalendar'); ?>:</h3>
<p><?php echo lang('color_section_description_littlecalendar'); ?></p>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_littlecal_today" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_littlecal_today']; ?>">&nbsp;</span></span>
<label for="Color_littlecal_today"><strong><?php echo lang('color_label_littlecal_today'); ?>:</strong></label><br />
<input type="text" id="Color_littlecal_today" name="littlecal_today" value="<?php echo $GLOBALS['Color_littlecal_today']; ?>" size="8" readonly="readonly" onclick="$('#Swap_littlecal_today').click()" />
<?php
echo '<span onclick="ResetValue(\'littlecal_today\',\'' . DEFAULTCOLOR_LITTLECAL_TODAY . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_LITTLECAL_TODAY . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_littlecal_today');
if (isset($VariableErrors['littlecal_today'])) { ShowColorError($VariableErrors['littlecal_today']); }
?>
</p>

<p>
<span id="Swap_littlecal_highlight" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_littlecal_highlight']; ?>">&nbsp;</span></span>
<label for="Color_littlecal_highlight"><strong><?php echo lang('color_label_littlecal_highlight'); ?>:</strong></label><br />
<input type="text" id="Color_littlecal_highlight" name="littlecal_highlight" value="<?php echo $GLOBALS['Color_littlecal_highlight']; ?>" size="8" readonly="readonly" onclick="$('#Swap_littlecal_highlight').click()" />
<?php
echo '<span onclick="ResetValue(\'littlecal_highlight\',\'' . DEFAULTCOLOR_LITTLECAL_HIGHLIGHT . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_LITTLECAL_HIGHLIGHT . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_littlecal_highlight');
if (isset($VariableErrors['littlecal_highlight'])) { ShowColorError($VariableErrors['littlecal_highlight']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_littlecal_fontfaded" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_littlecal_fontfaded']; ?>">&nbsp;</span></span>
<label for="Color_littlecal_fontfaded"><strong><?php echo lang('color_label_littlecal_fontfaded'); ?>:</strong></label><br />
<input type="text" id="Color_littlecal_fontfaded" name="littlecal_fontfaded" value="<?php echo $GLOBALS['Color_littlecal_fontfaded']; ?>" size="8" readonly="readonly" onclick="$('#Swap_littlecal_fontfaded').click()" />
<?php
echo '<span onclick="ResetValue(\'littlecal_fontfaded\',\'' . DEFAULTCOLOR_LITTLECAL_FONTFADED . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_LITTLECAL_FONTFADED . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_littlecal_fontfaded');
if (isset($VariableErrors['littlecal_fontfaded'])) { ShowColorError($VariableErrors['littlecal_fontfaded']); }
?>
</p>

<p>
<span id="Swap_littlecal_line" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_littlecal_line']; ?>">&nbsp;</span></span>
<label for="Color_littlecal_line"><strong><?php echo lang('color_label_littlecal_line'); ?>:</strong></label><br />
<input type="text" id="Color_littlecal_line" name="littlecal_line" value="<?php echo $GLOBALS['Color_littlecal_line']; ?>" size="8" readonly="readonly" onclick="$('#Swap_littlecal_line').click()" />
<?php
echo '<span onclick="ResetValue(\'littlecal_line\',\'' . DEFAULTCOLOR_LITTLECAL_LINE . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_LITTLECAL_LINE . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_littlecal_line');
if (isset($VariableErrors['littlecal_line'])) { ShowColorError($VariableErrors['littlecal_line']); }
?>
</p>

</td></tr></tbody>
</table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_dateselector'); ?>:</h3>
<p><?php echo lang('color_section_description_dateselector'); ?></p>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_gobtn_bg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_gobtn_bg']; ?>">&nbsp;</span></span>
<label for="Color_gobtn_bg"><strong><?php echo lang('color_label_gobtn_bg'); ?>:</strong></label><br />
<input type="text" id="Color_gobtn_bg" name="gobtn_bg" value="<?php echo $GLOBALS['Color_gobtn_bg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_gobtn_bg').click()" />
<?php
echo '<span onclick="ResetValue(\'gobtn_bg\',\'' . DEFAULTCOLOR_GOBTN_BG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_GOBTN_BG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_gobtn_bg');
if (isset($VariableErrors['gobtn_bg'])) { ShowColorError($VariableErrors['gobtn_bg']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_gobtn_border" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_gobtn_border']; ?>">&nbsp;</span></span>
<label for="Color_gobtn_border"><strong><?php echo lang('color_label_gobtn_border'); ?>:</strong></label><br />
<input type="text" id="Color_gobtn_border" name="gobtn_border" value="<?php echo $GLOBALS['Color_gobtn_border']; ?>" size="8" readonly="readonly" onclick="$('#Swap_gobtn_border').click()" />
<?php
echo '<span onclick="ResetValue(\'gobtn_border\',\'' . DEFAULTCOLOR_GOBTN_BORDER . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_GOBTN_BORDER . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_gobtn_border');
if (isset($VariableErrors['gobtn_border'])) { ShowColorError($VariableErrors['gobtn_border']); }
?>
</p>

</td></tr></tbody>
</table>

<div class="FormSectionHeader">
<h3><?php echo lang('color_section_title_adminbuttons'); ?>:</h3>
</div>

<table class="calendarColors" width="100%" border="0" cellspacing="0" cellpadding="10">
<tbody><tr><td width="50%">

<p>
<span id="Swap_newborder" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_newborder']; ?>">&nbsp;</span></span>
<label for="Color_newborder"><strong><?php echo lang('color_label_newborder'); ?>:</strong></label><br />
<input type="text" id="Color_newborder" name="newborder" value="<?php echo $GLOBALS['Color_newborder']; ?>" size="8" readonly="readonly" onclick="$('#Swap_newborder').click()" />
<?php
echo '<span onclick="ResetValue(\'newborder\',\'' . DEFAULTCOLOR_NEWBORDER . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_NEWBORDER . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_newborder');
if (isset($VariableErrors['newborder'])) { ShowColorError($VariableErrors['newborder']); }
?>
</p>

<p>
<span id="Swap_newbg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_border']; ?>">&nbsp;</span></span>
<label for="Color_newbg"><strong><?php echo lang('color_label_newbg'); ?>:</strong></label><br />
<input type="text" id="Color_newbg" name="newbg" value="<?php echo $GLOBALS['Color_newbg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_newbg').click()" />
<?php
echo '<span onclick="ResetValue(\'newbg\',\'' . DEFAULTCOLOR_NEWBG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_NEWBG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_newbg');
if (isset($VariableErrors['newbg'])) { ShowColorError($VariableErrors['newbg']); }
?>
</p>

<p>
<span id="Swap_approveborder" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_approveborder']; ?>">&nbsp;</span></span>
<label for="Color_approveborder"><strong><?php echo lang('color_label_approveborder'); ?>:</strong></label><br />
<input type="text" id="Color_approveborder" name="approveborder" value="<?php echo $GLOBALS['Color_approveborder']; ?>" size="8" readonly="readonly" onclick="$('#Swap_approveborder').click()" />
<?php
echo '<span onclick="ResetValue(\'approveborder\',\'' . DEFAULTCOLOR_APPROVEBORDER . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_APPROVEBORDER . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_approveborder');
if (isset($VariableErrors['approveborder'])) { ShowColorError($VariableErrors['approveborder']); }
?>
</p>

<p>
<span id="Swap_approvebg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_approvebg']; ?>">&nbsp;</span></span>
<label for="Color_approvebg"><strong><?php echo lang('color_label_approvebg'); ?>:</strong></label><br />
<input type="text" id="Color_approvebg" name="approvebg" value="<?php echo $GLOBALS['Color_approvebg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_approvebg').click()" />
<?php
echo '<span onclick="ResetValue(\'approvebg\',\'' . DEFAULTCOLOR_APPROVEBG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_APPROVEBG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_approvebg');
if (isset($VariableErrors['approvebg'])) { ShowColorError($VariableErrors['approvebg']); }
?>
</p>

</td><td width="50%">

<p>
<span id="Swap_copyborder" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_copyborder']; ?>">&nbsp;</span></span>
<label for="Color_copyborder"><strong><?php echo lang('color_label_copyborder'); ?>:</strong></label><br />
<input type="text" id="Color_copyborder" name="copyborder" value="<?php echo $GLOBALS['Color_copyborder']; ?>" size="8" readonly="readonly" onclick="$('#Swap_copyborder').click()" />
<?php
echo '<span onclick="ResetValue(\'copyborder\',\'' . DEFAULTCOLOR_COPYBORDER . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_COPYBORDER . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_copyborder');
if (isset($VariableErrors['copyborder'])) { ShowColorError($VariableErrors['copyborder']); }
?>
</p>

<p>
<span id="Swap_copybg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_border']; ?>">&nbsp;</span></span>
<label for="Color_copybg"><strong><?php echo lang('color_label_copybg'); ?>:</strong></label><br />
<input type="text" id="Color_copybg" name="copybg" value="<?php echo $GLOBALS['Color_copybg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_copybg').click()" />
<?php
echo '<span onclick="ResetValue(\'copybg\',\'' . DEFAULTCOLOR_COPYBG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_COPYBG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_copybg');
if (isset($VariableErrors['copybg'])) { ShowColorError($VariableErrors['copybg']); }
?>
</p>

<p>
<span id="Swap_deleteborder" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_deleteborder']; ?>">&nbsp;</span></span>
<label for="Color_deleteborder"><strong><?php echo lang('color_label_deleteborder'); ?>:</strong></label><br />
<input type="text" id="Color_deleteborder" name="deleteborder" value="<?php echo $GLOBALS['Color_deleteborder']; ?>" size="8" readonly="readonly" onclick="$('#Swap_deleteborder').click()" />
<?php
echo '<span onclick="ResetValue(\'deleteborder\',\'' . DEFAULTCOLOR_DELETEBORDER . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_DELETEBORDER . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_deleteborder');
if (isset($VariableErrors['deleteborder'])) { ShowColorError($VariableErrors['deleteborder']); }
?>
</p>

<p>
<span id="Swap_deletebg" class="colorSelector" title="<?php echo lang('click_for_color_picker', false); ?>"><span style="background-color:<?php echo $GLOBALS['Color_deletebg']; ?>">&nbsp;</span></span>
<label for="Color_deletebg"><strong><?php echo lang('color_label_deletebg'); ?>:</strong></label><br />
<input type="text" id="Color_deletebg" name="deletebg" value="<?php echo $GLOBALS['Color_deletebg']; ?>" size="8" readonly="readonly" onclick="$('#Swap_deletebg').click()" />
<?php
echo '<span onclick="ResetValue(\'deletebg\',\'' . DEFAULTCOLOR_DELETEBG . '\')" title="' . lang('reset_to_default_color', false) . '" class="rstC" style="border-color:' . $GLOBALS['Color_border'] . ';background-color:' . DEFAULTCOLOR_DELETEBG . '">&nbsp;</span><br />' . "\n";
echo lang('color_description_deletebg');
if (isset($VariableErrors['deletebg'])) { ShowColorError($VariableErrors['deletebg']); }
?>
</p>

</td></tr></tbody>
</table>
<script type="text/javascript" src="scripts/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="scripts/colorpicker/eye.js"></script>
<script type="text/javascript" src="scripts/colorpicker/utils.js"></script>
<script type="text/javascript">/* <![CDATA[ */
(function($){
	var fadein = function(c) { $(c).fadeIn(500); return false; };
	var fadeout = function(c) { $(c).fadeOut(500); return false; };
	var initLayout = function() {
		$("#Swap_bg").ColorPicker({ // bg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_bg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_bg span").css("backgroundColor", "#" + hex);
				$("#Color_bg").val("#" + hex);
			}
		});
		$("#Swap_text").ColorPicker({ // text
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_text']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_text span").css("backgroundColor", "#" + hex);
				$("#Color_text").val("#" + hex);
			}
		});
		$("#Swap_text_faded").ColorPicker({ // text_faded
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_text_faded']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_text_faded span").css("backgroundColor", "#" + hex);
				$("#Color_text_faded").val("#" + hex);
			}
		});
		$("#Swap_text_warning").ColorPicker({ // text_warning
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_text_warning']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_text_warning span").css("backgroundColor", "#" + hex);
				$("#Color_text_warning").val("#" + hex);
			}
		});
		$("#Swap_link").ColorPicker({ // link
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_link']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_link span").css("backgroundColor", "#" + hex);
				$("#Color_link").val("#" + hex);
			}
		});
		$("#Swap_body").ColorPicker({ // body
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_body']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_body span").css("backgroundColor", "#" + hex);
				$("#Color_body").val("#" + hex);
			}
		});
		$("#Swap_today").ColorPicker({ // 
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_today']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_today span").css("backgroundColor", "#" + hex);
				$("#Color_today").val("#" + hex);
			}
		});
		$("#Swap_todaylight").ColorPicker({ // todaylight
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_todaylight']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_todaylight span").css("backgroundColor", "#" + hex);
				$("#Color_todaylight").val("#" + hex);
			}
		});
		$("#Swap_light_cell_bg").ColorPicker({ // light_cell_bg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_light_cell_bg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_light_cell_bg span").css("backgroundColor", "#" + hex);
				$("#Color_light_cell_bg").val("#" + hex);
			}
		});
		$("#Swap_table_header_text").ColorPicker({ // table_header_text
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_table_header_text']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_table_header_text span").css("backgroundColor", "#" + hex);
				$("#Color_table_header_text").val("#" + hex);
			}
		});
		$("#Swap_table_header_bg").ColorPicker({ // table_header_bg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_table_header_bg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_table_header_bg span").css("backgroundColor", "#" + hex);
				$("#Color_table_header_bg").val("#" + hex);
			}
		});
		$("#Swap_border").ColorPicker({ // border
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_border']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_border span").css("backgroundColor", "#" + hex);
				$("#Color_border").val("#" + hex);
			}
		});
		$("#Swap_keyword_highlight").ColorPicker({ // keyword_highlight
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_keyword_highlight']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_keyword_highlight span").css("backgroundColor", "#" + hex);
				$("#Color_keyword_highlight").val("#" + hex);
			}
		});
		$("#Swap_h2").ColorPicker({ // h2
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_h2']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_h2 span").css("backgroundColor", "#" + hex);
				$("#Color_h2").val("#" + hex);
			}
		});
		$("#Swap_h3").ColorPicker({ // h3
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_h3']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_h3 span").css("backgroundColor", "#" + hex);
				$("#Color_h3").val("#" + hex);
			}
		});
		$("#Swap_title").ColorPicker({ // title
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_title']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_title span").css("backgroundColor", "#" + hex);
				$("#Color_title").val("#" + hex);
			}
		});
		$("#Swap_tabgrayed_text").ColorPicker({ // tabgrayed_text
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_tabgrayed_text']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_tabgrayed_text span").css("backgroundColor", "#" + hex);
				$("#Color_tabgrayed_text").val("#" + hex);
			}
		});
		$("#Swap_tabgrayed_bg").ColorPicker({ // tabgrayed_bg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_tabgrayed_bg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_tabgrayed_bg span").css("backgroundColor", "#" + hex);
				$("#Color_tabgrayed_bg").val("#" + hex);
			}
		});
		$("#Swap_filternotice_bg").ColorPicker({ // filternotice_bg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_filternotice_bg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_filternotice_bg span").css("backgroundColor", "#" + hex);
				$("#Color_filternotice_bg").val("#" + hex);
			}
		});
		$("#Swap_filternotice_font").ColorPicker({ // filternotice_font
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_filternotice_font']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_filternotice_font span").css("backgroundColor", "#" + hex);
				$("#Color_filternotice_font").val("#" + hex);
			}
		});
		$("#Swap_filternotice_fontfaded").ColorPicker({ // filternotice_fontfaded
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_filternotice_fontfaded']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_filternotice_fontfaded span").css("backgroundColor", "#" + hex);
				$("#Color_filternotice_fontfaded").val("#" + hex);
			}
		});
		$("#Swap_eventbar_past").ColorPicker({ // eventbar_past
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_eventbar_past']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_eventbar_past span").css("backgroundColor", "#" + hex);
				$("#Color_eventbar_past").val("#" + hex);
			}
		});
		$("#Swap_eventbar_current").ColorPicker({ // eventbar_current
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_eventbar_current']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_eventbar_current span").css("backgroundColor", "#" + hex);
				$("#Color_eventbar_current").val("#" + hex);
			}
		});
		$("#Swap_eventbar_future").ColorPicker({ // eventbar_future
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_eventbar_future']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_eventbar_future span").css("backgroundColor", "#" + hex);
				$("#Color_eventbar_future").val("#" + hex);
			}
		});
		$("#Swap_monthdaylabels_past").ColorPicker({ // monthdaylabels_past
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_monthdaylabels_past']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_monthdaylabels_past span").css("backgroundColor", "#" + hex);
				$("#Color_monthdaylabels_past").val("#" + hex);
			}
		});
		$("#Swap_monthdaylabels_current").ColorPicker({ // monthdaylabels_current
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_monthdaylabels_current']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_monthdaylabels_current span").css("backgroundColor", "#" + hex);
				$("#Color_monthdaylabels_current").val("#" + hex);
			}
		});
		$("#Swap_monthdaylabels_future").ColorPicker({ // monthdaylabels_future
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_monthdaylabels_future']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_monthdaylabels_future span").css("backgroundColor", "#" + hex);
				$("#Color_monthdaylabels_future").val("#" + hex);
			}
		});
		$("#Swap_othermonth").ColorPicker({ // othermonth
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_othermonth']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_othermonth span").css("backgroundColor", "#" + hex);
				$("#Color_othermonth").val("#" + hex);
			}
		});
		$("#Swap_littlecal_today").ColorPicker({ // littlecal_today
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_littlecal_today']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_littlecal_today span").css("backgroundColor", "#" + hex);
				$("#Color_littlecal_today").val("#" + hex);
			}
		});
		$("#Swap_littlecal_highlight").ColorPicker({ // littlecal_highlight
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_littlecal_highlight']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_littlecal_highlight span").css("backgroundColor", "#" + hex);
				$("#Color_littlecal_highlight").val("#" + hex);
			}
		});
		$("#Swap_littlecal_fontfaded").ColorPicker({ // littlecal_fontfaded
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_littlecal_fontfaded']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_littlecal_fontfaded span").css("backgroundColor", "#" + hex);
				$("#Color_littlecal_fontfaded").val("#" + hex);
			}
		});
		$("#Swap_littlecal_line").ColorPicker({ // littlecal_line
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_littlecal_line']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_littlecal_line span").css("backgroundColor", "#" + hex);
				$("#Color_littlecal_line").val("#" + hex);
			}
		});
		$("#Swap_gobtn_bg").ColorPicker({ // gobtn_bg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_gobtn_bg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_gobtn_bg span").css("backgroundColor", "#" + hex);
				$("#Color_gobtn_bg").val("#" + hex);
			}
		});
		$("#Swap_gobtn_border").ColorPicker({ // gobtn_border
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_gobtn_border']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_gobtn_border span").css("backgroundColor", "#" + hex);
				$("#Color_gobtn_border").val("#" + hex);
			}
		});
		$("#Swap_newborder").ColorPicker({ // newborder
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_newborder']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_newborder span").css("backgroundColor", "#" + hex);
				$("#Color_newborder").val("#" + hex);
			}
		});
		$("#Swap_newbg").ColorPicker({ // newbg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_newbg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_newbg span").css("backgroundColor", "#" + hex);
				$("#Color_newbg").val("#" + hex);
			}
		});
		$("#Swap_approveborder").ColorPicker({ // approveborder
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_approveborder']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_approveborder span").css("backgroundColor", "#" + hex);
				$("#Color_approveborder").val("#" + hex);
			}
		});
		$("#Swap_approvebg").ColorPicker({ // approvebg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_approvebg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_approvebg span").css("backgroundColor", "#" + hex);
				$("#Color_approvebg").val("#" + hex);
			}
		});
		$("#Swap_copyborder").ColorPicker({ // copyborder
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_copyborder']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_copyborder span").css("backgroundColor", "#" + hex);
				$("#Color_copyborder").val("#" + hex);
			}
		});
		$("#Swap_copybg").ColorPicker({ // copybg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_copybg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_copybg span").css("backgroundColor", "#" + hex);
				$("#Color_copybg").val("#" + hex);
			}
		});
		$("#Swap_deleteborder").ColorPicker({ // deleteborder
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_deleteborder']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_deleteborder span").css("backgroundColor", "#" + hex);
				$("#Color_deleteborder").val("#" + hex);
			}
		});
		$("#Swap_deletebg").ColorPicker({ // deletebg
			onShow: fadein, onHide: fadeout, color: "<?php echo $GLOBALS['Color_deletebg']; ?>",
			onChange: function(hsb, hex, rgb) {
				$("#Swap_deletebg span").css("backgroundColor", "#" + hex);
				$("#Color_deletebg").val("#" + hex);
			}
		});
	};
	EYE.register(initLayout, "init");
})(jQuery);
function ResetValue(idbase, origValue)
{ // reset color to configuration default
	$("#Color_" + idbase).val(origValue);
	$("#Swap_" + idbase + " span").css("backgroundColor", origValue);
}
/* ]]> */</script>
<?php } ?>