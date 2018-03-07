<?php

session_start();
require_once("../config.php");

/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=dev_dbpsbulkcargo;host=24v-azu-db001.mysql.database.azure.com;port=3306';
$user = 'dev_cargoinship_service@24v-azu-db001';
$password = 'cM2ur5FdIqh6';

$db = null;
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    throw new Exception('Connection failed: ' . $e->getMessage());
}
global $db;

/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=dev_dbpsbulkcargo;host=24v-azu-db001.mysql.database.azure.com;port=3306';
$user = 'dev_cargoinship_service@24v-azu-db001';
$password = 'cM2ur5FdIqh6';

$db = null;
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    throw new Exception('Connection failed: ' . $e->getMessage());
}
global $db;

if (!(isset($_GET["last_emailid"]) && is_numeric($_GET["last_emailid"]))) {
	header('HTTP/1.0 400 Bad Request');
	echo "emailid has not been set properly.";
	die();
}

$sql = "SELECT * FROM email WHERE classification_automated_certainty IS NOT NULL AND classification_automated IS NOT NULL ORDER BY classification_automated_certainty ASC LIMIT 500;";

$sth = $db->prepare($sql);
$sth->execute();
$res = $sth->fetchAll();

$arr = $sth->errorInfo();
if (!($arr[0] == "00000")) {
	echo "FAILED. Please contact technical administration.";
} else {
	
	$getnext = false;
	foreach ($res as $row) {
		if ($getnext == true) {
			echo json_encode($row); die();
		}
		if ($row["emailID"] == $_GET["last_emailid"]) {
			$getnext = true;
		}
	}
	
	echo "Something went wrong.";
}

?>