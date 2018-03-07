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

if (!(isset($_GET["emailid"]) && is_numeric($_GET["emailid"]))) {
	header('HTTP/1.0 400 Bad Request');
	echo "emailid has not been set properly.";
	die();
}

$classification_options = array("ship", "order", "report", "mix", "spam", "cargo");
if (!(isset($_GET["classification_manual"]) && in_array($_GET["classification_manual"], $classification_options))) {
	header('HTTP/1.0 400 Bad Request');
	echo "classifiation_manual has not been set properly.";
	die();
}

$sql = "UPDATE email SET classification_manual='" . ucwords($_GET["classification_manual"]) . "', classification_automated='" . ucwords($_GET["classification_manual"]) . "', classification_automated_certainty=0.95 WHERE emailID=" . $_GET["emailid"] . "; DELETE FROM cargo_offer_extracted WHERE emailID=" . $_GET["emailid"] ."; DELETE FROM ship_offer_extracted WHERE emailID=" . $_GET["emailid"] . "; DELETE FROM ship_order_extracted WHERE emailID=" . $_GET["emailid"] . ";";

//print_r($sql);

$sth = $db->prepare($sql);
$sth->execute();

$arr = $sth->errorInfo();
if ($arr[0] == "00000") {
	echo "OK";
} else {
	echo "FAILED. Please contact technical administration.";
}

?>
