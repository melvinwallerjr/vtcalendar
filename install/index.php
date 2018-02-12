<?php
/**
 * VTCalendar Installer
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

<title>VTCalendar Installation</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<link type="text/css" rel="stylesheet" href="styles.css" />
<!--[if gte IE 5.5000]><![if lt IE 7.0000]>
<style type="text/css">.png { behavior: url('../scripts/iepngfix.htc'); }</style>
<![endif]><![endif]-->

</head><body><div id="wrapper">

<h1>VTCalendar Installation</h1>

<p class="warning"><big><strong>Security Warning:</strong></big><br />
Once you complete the wizards below, you should <em>remove or secure</em> the <code>install</code> folder.</p>

<h2>Wizards</h2>

<div class="pad">

<p>These are the steps to installing VTCalendar:</p>

<ol style="list-style-type:decimal">

<?php // Multi-Byte String support missing from PHP
if (!function_exists('mb_strtolower') || !function_exists('mb_strtoupper') ||
 !function_exists('mb_convert_case')) {
	echo '
<li><p><big><strong><a href="http://php.net/manual/en/mbstring.installation.php">Enable PHP Multi-Byte String Support</a></strong></big></p>
<ul>' .
(version_compare(PHP_VERSION, '4.3.0', '<')? '<li>Multi-Byte support was added to PHP starting with version 4.3.0, your version is ' . PHP_VERSION . ' and must be upgraded before you can use this calendar.</li>' : '') . '
<li>PHP needs to support UTF-8 string encoding operations. Multi-Byte support can be enabled when installing PHP by adding the \'mbsting\' option when configuring PHP prior to installation.<br /> <kbd>--enable-mbstring</kbd></li>
</ul></li>';
}
?>

<li><p><big><strong><a href="config.php">Configure VTCalendar</a></strong></big></p>
<p>Configure various VTCalendar settings including:</p>
<ul style="list-style-type:disc">
<li>Specify how to connect to the database.</li>
<li>Specify the URL at which the calendar is accessed. </li>
<li>Choose the way users authenticate. </li>
<li>Toggle some display features.</li>
</ul></li>

<li><p><big><strong><a href="upgradedb.php">Install or Upgrade  Database (MySQL 4.2+ or PostgreSQL 8+)</a></strong></big></p>
<p>If this is a <b>fresh VTCalendar install</b> this wizard will create the necessary VTCalendar tables.</p>
<p>If you are <b>upgrading VTCalendar</b> this wizard will upgrade the database, adding any missing tables, columns or indexes.</p>
<p>The VTCalendar is configured for UTF-8 compatibility because it is designed to support multiple languages. To test your server environment settings have a look at the <a href="utf8_test.php">UTF-8 Server Configuration Test</a> page.</p>
</li>

<li><p><big><strong><a href="createadmin.php">Create Main Admin Accounts</a></strong></big></p>
<p>If this is a <b>fresh VTCalendar install</b> you may use this wizard to create main admin accounts.</p></li>

</ol><br />

</div><!-- .pad -->

<h2>Version Check</h2>

<div class="pad">
<div id="VersionResult"></div>
</div><!-- .pad -->

<script type="text/javascript">/* <![CDATA[ */
function CheckVersionHandler(image, messageHTML, tableHTML)
{
	document.getElementById("VersionResult").innerHTML = tableHTML.replace(/src="/g, "src=\"../");
}
/* ]]> */</script>
<iframe src="../checkversion.php" width="1" height="1" frameborder="0" marginheight="0" marginwidth="0"></iframe>

</div></body></html>
