<?php

class Endpoint {
	var $availableverbs = array("get" => "get", "put" => "put", "post" => "post", "delete" => "del");
	
	function __construct() {
       
    }
	
	function call($verb, $content) {
		$db = $GLOBALS["db"];
		$db->query("SET CHARACTER SET utf8");
		$verb = strtolower($verb);
		if (!in_array($verb, array_keys($this->availableverbs))) {
		    header('HTTP/1.0 405 Method Not Allowed');
			echo "The requested method '" . $verb . "' is not available for this object.";
			die;
	   }
	   
	   $func = $this->availableverbs[$verb];
	   $sqlobj = null;
	   try {
			$sqlobj = $this->$func($content);
		} catch (Exception $e) {
		//	message('Caught exception during Endpoint message execution: '.  $e->getMessage());
			sendReturnCode("500");
		}
		
		try {
			 $output = new Output;
			 $output->printOutput($sqlobj);
		} catch (Exception $e) {
		//	message('Exception during output creation:'.  $e->getMessage());
			sendReturnCode("500");
		}
	   
	  
	}
	
	function get($content) {
		throw new Exception("Not yet implemented.");
	}
	
	function put($content) {
		throw new Exception("Undefined.");
	}
	
	function post($content) {
		throw new Exception("Undefined.");
	}
	
	function del($content) {
		throw new Exception("Undefined.");
	}
}

?>
