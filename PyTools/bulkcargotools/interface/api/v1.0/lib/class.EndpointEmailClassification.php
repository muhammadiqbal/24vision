<?php
//DEPRECATED !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
class EndpointEmailClassification extends Endpoint {
	var $db;
	var $url;
	var $availableverbs = array("get" => "get", "post" => "post");
	
	function __construct() {
		message("Hello World. I am EmailContent.");
		$this->db = $GLOBALS["db"];
    }
	
	function get($body = null) {
		
		$sql = "SELECT emailID, classification_manual, classification_automated FROM email WHERE classification_automated = 'Unknown' LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		$headers = array("emailID", "classification_manual", "classification_automated");
		
		//Query the database
		$sqlreturn = $this->db->query($sql);
		
		return $sqlreturn;
	}
	
	function post($body = null) {
		if ($body = null) {
			throw new Exception("PUT method requests parameters.");
		}
		
		if (!is_numeric($GLOBALS["INPUT_PARAMS"]["emailID"])) {echo "emailD  " . $_POST["emailID"] . "-" . $_GET["emailID"]." not numeric"; exit;}
		if (!in_array($GLOBALS["INPUT_PARAMS"]["classification_automated"], array("cargo", "ship", "order", "mix", "other"))) { echo "Classification is not cargo, ship, order, mix or other."; exit;}
		
		//Sql Query.
		$emailID = $GLOBALS["INPUT_PARAMS"]["emailID"];
		$classification_automated = $GLOBALS["INPUT_PARAMS"]["classification_automated"];
		$sql = "UPDATE email SET classification_automated='" . $classification_automated . "' WHERE emailID='" . $emailID . "';";
		$this->db->query($sql);
		echo $sql;
		echo "Success";
		return null;
	}
}

?>