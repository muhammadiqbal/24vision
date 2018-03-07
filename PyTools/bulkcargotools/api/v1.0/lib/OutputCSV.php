<?php

function formatCSV($sqlobj, $headers = null) {
		$headers = $sqlobj->getHeader();
		$sqlreturn = $sqlobj->getTable();
		
		if ($sqlreturn == null) { return null; }
		//if (!is_array($sqlreturn)) {return null; }
		$export = $sqlreturn;

		$filename = "tmp/test.csv";
		$data = fopen($filename, 'w');	

		//Print Header
		fputcsv($data, $headers);
		
		//Print Table
		foreach ($sqlreturn as $row) {
			
			$cleanedrow = array();
			foreach ($row as $key => $value) {
				if (!is_numeric($key)) {
					$cleanedrow[$key] = str_replace(",", "", $value);
				}
			}
			fputcsv($data, $cleanedrow);
		}

		fclose($data);

		if (isset($GLOBALS["INPUT_PARAMS"]["download"]) && $GLOBALS["INPUT_PARAMS"]["download"] == "1") {
			header("Content-type: application/csv");
			header("Content-Disposition: attachment; filename=data.csv");
		}
		
		/*header("Pragma: no-cache");
		header("Expires: 0");*/
		echo file_get_contents($filename);
}

?>