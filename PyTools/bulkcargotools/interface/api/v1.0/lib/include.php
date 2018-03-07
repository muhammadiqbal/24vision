<?php
function message($msg) {
	if (DEBUG_MODE == 1) {
		if (!is_array($msg)) {
			echo $msg . "<br>";
		} else {
			print_r($msg);
			echo "<br>";
		}		
	}
}



$basepath = dirname(__FILE__);

include_once($basepath . "/misc.php");
include_once($basepath . "/Returncodes.php");
include_once($basepath . "/Parameters.php");
include_once($basepath . "/auth.php");
include_once($basepath . "/class.API.php");
include_once($basepath . "/class.Endpoint.php");
include_once($basepath . "/class.EndpointGeneric.php");
include_once($basepath . "/class.EndpointEmails.php");
include_once($basepath . "/class.EndpointExtracted.php");
include_once($basepath . "/class.SQLobject.php");
include_once($basepath . "/class.Output.php");
include_once($basepath . "/OutputCSV.php");
include_once($basepath . "/OutputJSON.php");
?>