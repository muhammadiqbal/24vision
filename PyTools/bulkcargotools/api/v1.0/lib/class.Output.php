<?php

class Output {
	var $url;
	var $availableformats = array("csv", "php", "json");
	var $defaultformat = "csv";
	var $format;
	
	function __construct($format = null) {
		
		//If format unset, search for data from URL, otherwise default.
		if ($format == null) {
			if (in_array($GLOBALS["INPUT_PARAMS"]["format"], $this->availableformats)) {
				$format = $GLOBALS["INPUT_PARAMS"]["format"];
			} elseif(isset($GLOBALS["INPUT_PARAMS"]["format"])) {
				throw new Exception("Specified format not available.");
			} else {
				$format = $this->defaultformat;
			}
		}
		
		//Check if format is available
        if (!in_array($format, $this->availableformats)) {
		   throw new Exception("Format " . $format . " not available");
		   exit;
	    }
	   
	   $this->format = $format;
    }
	
	function printOutput($sqlreturn) {
		
		if ($this->format == "csv") {
			formatCSV($sqlreturn);
		} elseif ($this->format == "json") { 
			
			formatJSON($sqlreturn);
		} elseif ($this->format == "php") { //Debugging purposes only
			foreach ($sqlreturn as $row){
				print_r($row);
			}
		} else {
			throw new Exception("Output received unknown format: " . $this->format);
		}
	}
	
}

?>