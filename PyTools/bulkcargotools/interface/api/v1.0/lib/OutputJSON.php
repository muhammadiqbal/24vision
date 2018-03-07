<?php
/*
*Class that formats an incoming SQLobject as JSON. Currently in heavy use.
*/
function formatJSON($sqlobj, $headers = null) {
		$headers = $sqlobj->getHeader();
		$sqlreturn = $sqlobj->getTable();
		
		if ($sqlreturn == null) { return null; }
		//if (!is_array($sqlreturn)) {return null; }
		$export = $sqlreturn;
		
		message("JSON OUTPUT2");
		
		$allrows = [];
		
		//Print Table
		foreach ($sqlreturn as $row) {
			
			$cleanedrow = array();
			foreach ($row as $key => $value) {
				if (!is_numeric($key)) {
					$cleanedrow[$key] = str_replace(",", "", $value);
				}
			}
			//print_r($cleanedrow);
			$allrows[] = $cleanedrow;
		}
		//print_r($allrows);

		header("Content-type: application/json");
		header("Pragma: no-cache");
		header("Expires: 0");
		if (isset($GLOBALS["INPUT_PARAMS"]["download"]) && $GLOBALS["INPUT_PARAMS"]["download"] == "1") {		
			header("Content-Disposition: attachment; filename=data.json");
		}

		$str = json_encode($allrows, JSON_PARTIAL_OUTPUT_ON_ERROR);
		echo $str;
}

?>