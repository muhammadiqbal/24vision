<?php

class EndpointEmails extends Endpoint {
	var $availableverbs = array("get" => "get", "post" => "post", "delete" => "del");
	var $db;
	var $typeid;
	var $headers;
	
	function __construct($typeid = null, $subtype = null, $subtypeid = null) {
		$this->db = $GLOBALS["db"];
		$this->typeid = $typeid;
		
		//Extract Header Information
		$headers = array();
		$headersql = "SHOW COLUMNS FROM email";
		$headerreturn = $this->db->query($headersql);
		foreach ($headerreturn as $headerfield) {
			$headers[$headerfield["Field"]] = $headerfield["Type"];
		}
		$this->headers = $headers;
    }
	
	function get($body = null) {
		if ($GLOBALS["INPUT_PARAMS"]["mode"] == "compute") {
			echo "API LAUNCHED IN COMPUTE MODE";
			//LAUNCH IMAP SCRIPT HERE
			
		}
		//Default case
		$sql = "SELECT emailID, subject, body, sender, receiver, cc, date, classification_manual, classification_automated FROM email LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		$headers = array("emailID", "subject", "body", "sender", "receiver", "cc", "date", "classification_manual", "classification_automated");
		
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "classification") {
			$sql = "SELECT emailID, classification_manual, classification_automated, classification_automated_certainty FROM email WHERE classification_automated = 'Unknown' LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
			$headers = array("emailID", "classification_manual", "classification_automated");
		}
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "unclassified") {
			$sql = "SELECT emailID, subject, body, sender, receiver, cc, date, classification_manual, classification_automated, classification_automated_certainty FROM email WHERE classification_automated = 'Unknown' OR classification_automated IS NULL LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		}
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "classificationtraining") {
			$sql = "SELECT emailID, subject, body, sender, receiver, cc, date, classification_manual, classification_automated, classification_automated_certainty FROM email WHERE classification_manual IS NOT NULL LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		}
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "classificationconfidence") {
			$sql = "SELECT emailID, subject, body, sender, receiver, cc, date, classification_manual, classification_automated, classification_automated_certainty FROM email WHERE classification_automated_certainty IS NOT NULL ORDER BY classification_automated_certainty ASC LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		}
		if (in_array(strtolower($GLOBALS["INPUT_PARAMS"]["filter"]), array("ship", "cargo", "mix", "report", "spam", "unknown", "spam", "order"))) {
			$sql = "SELECT emailID, subject, body, sender, receiver, cc, date, classification_manual, classification_automated, classification_automated_certainty FROM email WHERE classification_manual = '" . ucfirst(strtolower($GLOBALS["INPUT_PARAMS"]["filter"])) . "' LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		}
		
		//message($sql);
	
		//Query the database
		$sqlreturn = $this->db->query($sql);

		$returnobj = new SQLobject($headers, $sqlreturn);
		return $returnobj;	
	}
	
	function post($body = null) {
		if (!isset($this->typeid)) { throw new Exception("No or wrong ID specified for POST operation."); }

		//Generate SQL for setting fieldsql
		$fieldsql = "";
		foreach ($GLOBALS["INPUT_POST"] as $key => $value) {
			if (!in_array($key, array_keys($this->headers))) { throw new Exception("Variable " . $key . " unknown."); }
			
			$subfieldsql =  " " . $key . "='" . $value . "'";
			$fieldsql .= $subfieldsql . ",";
		}
		$fieldsql = substr($fieldsql, 0, strlen($fieldsql)-1); //Cut off the last character (a comma)
		
		$updatesql = "UPDATE email SET " . $fieldsql . " WHERE emailID=" . $this->typeid . ";";
		message($updatesql);
		$this->db->query($updatesql);
		
		$returnobj = new SQLobject(array("Success"), null);
		return $returnobj;
	}
	
	function del($body = null) {
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "classification") {
			$sql = "UPDATE email SET classification_automated=null;";
			$this->db->query($sql);
			
			$sql = "UPDATE email SET classification_automated_certainty=0;";
			$this->db->query($sql);
			return new SQLobject(array("Success"), null);
		} else {
			throw new Exception("This kind of configuration is not allowed for delete requests.");
		}
		
	}
	
	/*function post($body = null) {
		if ($body = null) {
			throw new Exception("POST method requests parameters.");
		}
		
		if (!is_numeric($GLOBALS["INPUT_PARAMS"]["emailid"])) {echo "emailD  -" . $GLOBALS["INPUT_PARAMS"]["emailid"]."-" . $_POST["emailID"] ."- not numeric"; exit;}
		if (!in_array($GLOBALS["INPUT_PARAMS"]["classification_automated"], array("cargo", "ship", "order", "mix", "other"))) { echo "Classification is not cargo, ship, order, mix or other."; exit;}
		
		//Sql Query.
		$emailID = $GLOBALS["INPUT_PARAMS"]["emailid"];
		$classification_automated = $GLOBALS["INPUT_PARAMS"]["classification_automated"];
		$sql = "UPDATE email SET classification_automated='" . $classification_automated . "' WHERE emailID='" . $emailID . "';";
		$this->db->query($sql);
		//echo $sql;
		return new SQLObject("Success");
	}*/
}

?>
