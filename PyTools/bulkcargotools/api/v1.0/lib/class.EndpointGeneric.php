<?php
/*
* NOTE: EndpointGeneric does not support Subtypes.
*/
class EndpointGeneric extends Endpoint {
	var $availableverbs = array("get" => "get", "post" => "post", "put" => "put");
	var $tableassignment = array("companies" => "company", "ports" => "port", "ships" => "ship", "cargooffers" => "cargo_offer", "cargoofferextracted" => "cargo_offer_extracted", "cargotype" => "cargo_type", "shiplocation" => "ship_location","shipoffer" =>"ship_offer", "shipofferextracted" => "ship_offer_extracted", "shiporder"=> "ship_order", "shiporderextracted" => "ship_order_extracted", "shiptype" => "ship_type");
	
	var $db;
	var $type;
	var $typeid;
	
	
	var $table;
	var $headers;
	var $primarykey;
	
	function __construct($type, $typeid = null, $subtype = null, $subtypeid = null) {
		$this->db = $GLOBALS["db"];
		$this->type = $type;
		$this->typeid = $typeid;
		
		if (isset($this->tableassignment[strtolower($type)])) {
			$this->table = $this->tableassignment[strtolower($type)];
			
			//Extract Header Information
			$headers = array();
			$headersql = "SHOW COLUMNS FROM " . $this->table;
			$headerreturn = $this->db->query($headersql);
			foreach ($headerreturn as $headerfield) {
				$headers[$headerfield["Field"]] = $headerfield["Type"];

				if ($headerfield["Key"] == "PRI") {
					$this->primarykey = $headerfield["Field"];
				}
			}
			$this->headers = $headers;
		} else {
			throw new Exception("Generic endpoint not available for type " . $type); 
		}
    }

	function get($body = null) {	
		//Select Query
		$wherequery = "";
		if (isset($this->typeid)) {
			$wherequery = " WHERE " . $this->primarykey . "=" . $this->typeid . " ";
		}
		$sql = "SELECT * FROM " . $this->table . $wherequery . " LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		
		
		//Execute Query
		$sqlreturn = $this->db->query($sql);

		$returnobj = new SQLobject(array_keys($this->headers), $sqlreturn);
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
		
		$updatesql = "UPDATE " . $this->table . " SET " . $fieldsql . " WHERE " . $this->primarykey . "=" . $this->typeid . ";";
	//	message($updatesql);
		$this->db->query($updatesql);
		
		$returnobj = new SQLobject(array("Success"), null);
		return $returnobj;
	}
	
	function put($body = null) {
			if (isset($this->typeid)) { throw new Exception("Do not specify an ID for a PUT operation."); }
			
			

			//Generate SQL for setting fieldsql
			$fieldsql = "";
			$valuesql = "";
			print_r($GLOBALS["INPUT_PUT"]);
			foreach ($GLOBALS["INPUT_PUT"] as $key => $value) {
				
				//$lowercasetablefields = array_map('strtolower', $this->headers);
				//$lowercasetablefields = array_change_key_case($this->headers, CASE_LOWER);print_r($lowercasetablefields);
				if (!in_array($key, array_keys($this->headers))) { throw new Exception("Variable " . $key . " unknown."); }
				//if (!in_array($key, $lowercasetablefields)) { throw new Exception("Variable " . $key . " unknown."); }
				if (strtolower($key) == strtolower($this->primarykey)) { throw new Exception("Value cannot be assigned to primary key " . $this->primarykey . "."); }
				
				$fieldsql .= $key . ",";
				$valuesql .= "'".$value . "',";
				
			//	message($fieldsql); message($valuesql);
			}
			$fieldsql = substr($fieldsql, 0, strlen($fieldsql)-1); //Cut off the last character (a comma)
			$valuesql = substr($valuesql, 0, strlen($valuesql)-1); //Cut off the last character (a comma)
			
			$insertsql = "INSERT INTO " . $this->table . " (" . $fieldsql . ") VALUES (" . $valuesql . ");";
		//	message($insertsql);
			$this->db->query($insertsql);
			
			$returnobj = new SQLobject(array("Success"), null);
			return $returnobj;
	}
}

?>
