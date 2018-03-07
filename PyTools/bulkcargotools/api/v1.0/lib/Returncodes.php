<?php

function sendReturnCode($code) {
	switch ($code) {
		case "401":
			header('HTTP/1.0 401 Unauthorized'); break;
		case "404":
			header('HTTP/1.0 404 Not Found'); break;
		case "403":
			header('HTTP/1.0 403 Forbidden'); break;
		case "405":
			header('HTTP/1.0 401 Method Not Allowed'); break;
		case "418":
			header("HTTP/1.0 401 I'm a teapot"); break;
		case "500":
			header("HTTP/1.0 500 Internal Server Error"); break;
	}
}
?>