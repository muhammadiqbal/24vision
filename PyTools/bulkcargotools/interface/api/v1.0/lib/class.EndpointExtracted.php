<?php
/*
Specific child endpoint for the *_extracted tables. Necessary because of kibana-specific filters on these.
*/
class EndpointExtracted extends EndpointGeneric {
	var $tableassignment = array("cargoofferextracted" => "cargo_offer_extracted", "shipofferextracted" => "ship_offer_extracted", "shiporderextracted" => "ship_order_extracted");

	function get($body = null) {	
		//Select Query
		$wherequery = "";
		$wherequery_and = "";
		if (isset($this->typeid)) {
			$wherequery = " WHERE " . $this->primarykey . "=" . $this->typeid . " ";
			$wherequery_and = " AND " . $this->primarykey . "=" . $this->typeid . " ";
		}
		$sql = "SELECT * FROM " . $this->table . " as ex LEFT JOIN email as em ON em.emailID=ex.emailID ". $wherequery . " LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "kibana-unextracted") {
			$sql = "SELECT * FROM " . $this->table . " as ex LEFT JOIN email as em ON em.emailID=ex.emailID WHERE (kibana_extracted=0 OR kibana_extracted IS NULL) ". $wherequery_and . " LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		}
		if ($GLOBALS["INPUT_PARAMS"]["filter"] == "kibana-extracted") {
			$sql = "SELECT * FROM " . $this->table . " as ex LEFT JOIN email as em ON em.emailID=ex.emailID WHERE kibana_extracted=1 ". $wherequery_and . " LIMIT " . $GLOBALS["INPUT_PARAMS"]["limit"];
		}
		//Execute Query
		$sqlreturn = $this->db->query($sql);

		$returnobj = new SQLobject(array_keys($this->headers), $sqlreturn);
		return $returnobj;	
	}
}

?>