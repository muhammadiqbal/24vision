<?php
/*
This class can be used by code to get an Endpoint to send requests to. These endpoints can then be used to execute calls.

*/
class API {
	var $url;
	var $endpoints = array("emails" => "EndpointEmails", "cargoofferextracted" => "EndpointExtracted", "shipofferextracted" => "EndpointExtracted", "shiporderextracted" => "EndpointExtracted");
	
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