<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>VTCalendar Installation</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
<link href="styles.css" type="text/css" rel="stylesheet" />
</head>

<body>
<h1>VTCalendar Installation</h1>
<p>Two wizards are available for installing VTCalendar:</p>
<p><a href="config.php"><font size="3"><b> Configure VTCalendar</b></font></a></p>
<ul>
	<li>Specify how to connect to the database.</li>
    <li>Specify the URL at which the calendar is accessed. </li>
    <li>Choose the way users authenticate. </li>
    <li>Toggle some display features.<br />
   	    <i>and more...</i></li>
</ul>
<p><font size="3"><a href="upgradedb.php"><b>Install or Upgrade  Database (MySQL Only)</b></a></font></p>
<blockquote>
	<p>If this is a <b>fresh VTCalendar install</b> this script will create the necessary VTCalendar tables.</p>
    <p>If you are <b>upgrading VTCalendar</b> it is necessary to upgrade the database as well.</p>
</blockquote>
<p style="padding: 8px; background-color: #FFEEEE; border: 1px solid #FF3333;"><font size="3"><b>Security Warning:</b></font><br />
	Once you complete the configuration and DB upgrade, it is recommended that you remove or secure the <code>/install</code> folder. </p>
</body>
</html>
