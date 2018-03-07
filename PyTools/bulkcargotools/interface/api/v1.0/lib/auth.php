<?php
/*
Class that realizes the authentication mechanism and basic enpoint-level access control for defined users.
@TODO: Replace plaintext passwords with their actual md5-encoded variants.
*/
 $USERS = array('munsteruniversity' => array('password' => md5('huHzJKb459Wz'), "accesslevel" => "all"),
                'psbcm_classifier'  => array('password' => md5('huHzJKb459Wz'), "accesslevel" => "limited", "access_endpoints" => array("emails"), "access_methods" => array("get", "post", "delete")));
global $USERS;

function is_authorized($user,$pass) {
	

    if (isset($GLOBALS["USERS"][$user])) {
		$thisuser = $GLOBALS["USERS"][$user];
		if ($thisuser["password"] == md5($pass)) {
			return true;
		} 
		return false;
    } else {
		$thisuser = $GLOBALS["USERS"][$user];
		
		echo "R/I/A Comparing " . $thisuser["password"] . " with " . md5($pass);
        return false;
    }
}

function is_allowed($username, $endpoint, $method) {
	$thisuser = $GLOBALS["USERS"][$username];
	if ($thisuser["accesslevel"] == "all") {
		return true;
	} else {
		if (!in_array(strtolower($endpoint), $thisuser["access_endpoints"])) {
			return false;
		}
		if (!in_array(strtolower($method), $thisuser["access_methods"])) {
			return false;
		}
		return true; 
	} 
	
}

?>