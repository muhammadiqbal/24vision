<?php
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