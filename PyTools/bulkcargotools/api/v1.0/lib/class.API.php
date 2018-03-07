<?php

class API {
	var $url;
	var $endpoints = array("emails" => "EndpointEmails");
	
	function __construct() {
       
    }
	
	function GetEndpoint($url, $id=null, $subtype=null, $subtypeid=null) {
		if (!in_array(strtolower($url), array_keys($this->endpoints))) {
			//Return a Generic Endpoint if no specific one was found.
			$EP = new EndpointGeneric($url, $id, $subtype, $subtypeid);
			return $EP;
		    /*header('HTTP/1.0 404 Not Found');
			echo "The requested endpoint '" . $url . "' is not available.";
			die;*/
	   }
	   
	   $EP = new $this->endpoints[$url]($id, $subtype, $subtypeid);
	   return $EP;
	}
}

?>