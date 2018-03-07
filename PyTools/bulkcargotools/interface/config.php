<?php
error_reporting(E_ALL);
define("DEBUG_MODE",		1);

function is_authorized($username, $password) {
	if ($username == "munsteruniversity" && md5($password) == md5("huHzJKb459Wz"))  {
		return true;
	}
	return false;
}

//Check Username, Password
if (!is_authorized($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic realm="PSBCM API"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You need to enter a valid username and password.";
    exit;
}
?>