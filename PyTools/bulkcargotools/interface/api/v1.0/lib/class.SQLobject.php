<?php
/*
Simple object that contains both the header and the result of an SQL query. Used to transfer results to the Output mechanism.
*/
class SQLobject {
	var $header;
	var $table;
	
	function __construct($header, $table = null) {
		$this->header = $header;
		$this->table = $table;
    }
	
	function getHeader() {
		return $this->header;
	}
	
	function getTable() {
		return $this->table;
	}
}
?>