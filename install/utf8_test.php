<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>

<title>VTCalendar Installation - UTF-8 Environment Test</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<link type="text/css" rel="stylesheet" href="styles.css" />
<style type="text/css">/* <![CDATA[ */
pre {
	font-family: 'Courier New', 'Courier', serif;
	font-size: 12px;
}
/* ]]> */</style>

</head><body><div id="wrapper">

<h1>UTF-8 Server Configuration Test</h1>

<div class="pad">

<p>Compare the symbols in the image on the left with the symbols from the PHP array on the right. If they look the same then your server should be properly configured to display UTF-8 encoded characters. If the symbols on the right are garbled and look nothing like those in the image, then you may have to check your server's language environment variables.</p>

<p>First ensure that your database is in UTF-8 character set mode (this page does not test your database settings). Then check that your server's operating system has the correct environment variable. For example in America you would use: NLS_LANG = American_America.UTF8</p>

<p>For more information on setting a proper NLS_LANG environment variable please refer to:<br />
<a href="http://www.oracle.com/technology/tech/globalization/htdocs/nls_lang%20faq.htm" target="_blank">http://www.oracle.com/technology/tech/globalization/htdocs/nls_lang%20faq.htm</a></p>
<br />

<img src="utf8_test.gif" width="275" height="420" alt="character appearance sample" style="float:left" />

<?php
$currency = array(
	array(
		'name' => 'British Pound',
		'symbol' => '£',
	),
	array(
		'name' => 'Czech Koruna',
		'symbol' => 'Kč',
	),
	array(
		'name' => 'Polish Zloty',
		'symbol' => 'zł',
	),
	array(
		'name' => 'Euro',
		'symbol' => '€',
	)
);
echo '<pre style="margin-left:300px">';
print_r($currency);
echo '</pre><br />';
?>

<p><a href="./">Back to Install Menu</a></p>

</div><!-- .pad -->

</div></body></html>
