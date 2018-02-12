<?php
if (!file_exists('config.inc.php')) {
	header('Location: install/');
	exit;
}
header('Location: main.php');
exit;
?>