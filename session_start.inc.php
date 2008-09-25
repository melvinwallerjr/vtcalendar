<?php
if (BASEPATH != "" && BASEDOMAIN != "") {
	session_set_cookie_params(0, BASEPATH, BASEDOMAIN);
}
else {
	session_set_cookie_params(0);
}

session_name("VTCAL");
session_start();
?>