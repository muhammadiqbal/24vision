<?php
/*
Code that is called early on to clean input parameters and make all inputs availalbe in a common format as part of global variables.
*/
$INPUT_PARAMS = array();
global $INPUT_PARAMS;

$INPUT_GET = array();
global $INPUT_GET;

$INPUT_POST = array();
global $INPUT_POST;

function prepareInputParameters() {
	foreach($_GET as $key => $value) {
		$GLOBALS["INPUT_PARAMS"][strtolower($key)] = htmlspecialchars($value);
		$GLOBALS["INPUT_GET"][strtolower($key)] = htmlspecialchars($value);
	}
	foreach($_POST as $key => $value) {
		$GLOBALS["INPUT_PARAMS"][strtolower($key)] = htmlspecialchars($value);
		$GLOBALS["INPUT_POST"][strtolower($key)] = htmlspecialchars($value);
	}
	
	//Handle PUT request data
	parse_str(file_get_contents("php://input"),$stdin);
	foreach ($stdin as $key => $value) {
		$GLOBALS["INPUT_PARAMS"][strtolower($key)] = htmlspecialchars($value);
		$GLOBALS["INPUT_PUT"][$key] = htmlspecialchars($value);
	}
	
	if (!isset($GLOBALS["INPUT_PARAMS"]["format"])) {
		//$GLOBALS["INPUT_PARAMS"]["format"] = "unknown";
	}
	
	if (!isset($GLOBALS["INPUT_PARAMS"]["limit"])) {
		$GLOBALS["INPUT_PARAMS"]["limit"] = "200";
		$GLOBALS["INPUT_GET"]["limit"] = "200";
	} elseif (!is_numeric($GLOBALS["INPUT_GET"]["limit"])) {
		throw new Exception("Parameter 'limit' not numeric.");
	}
}

prepareInputParameters();
//message($GLOBALS["INPUT_PARAMS"]);
?>