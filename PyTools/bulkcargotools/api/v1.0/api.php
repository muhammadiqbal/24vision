<?php
require_once("config.php");
require_once("lib/include.php");

//Check Username, Password
if (!is_authorized($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic realm="PSBCM API"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You need to enter a valid username and password.";
    exit;
}

//Check permission
if (!is_allowed($_SERVER['PHP_AUTH_USER'], $GLOBALS["INPUT_PARAMS"]["type"], $_SERVER['REQUEST_METHOD'])) {
	sendReturnCode(403);
	echo " API.php You are not authorized to use this endpoint, request method or combination thereof.";
	exit;
}

/* Connect to a MySQL database using driver invocation */
//$dsn = 'mysql:dbname="dev_dbpsbulkcargo";host="24v-azu-db001.mysql.database.azure.com";port=3306;';
//$user = 'dev_cargoinship_service@24v-azu-db001';
//$password = 'cM2ur5FdIqh6';


//$mysqli = new mysqli('24v-azu-db001.mysql.database.azure.com','dev_cargoinship_service@24v-azu-db001','cM2ur5FdIqh6','dev_dbpsbulkcargo');
//if ($mysqli->connect_errno) {
//    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

$conn = mysqli_init();
mysqli_ssl_set($conn,NULL,NULL, "/var/www/html/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL) ; 
mysqli_real_connect($conn, '24v-azu-db001.mysql.database.azure.com', 'dev_cargoinship_service@24v-azu-db001', 'cM2ur5FdIqh6', 'dev_dbpsbulkcargo', 3306, MYSQLI_CLIENT_SSL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
if (mysqli_connect_errno($conn)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

$output = "csv";
$headers = array();
if (isset($_GET["output"])) {
	if ($_GET["output"] == "txt") { $output = "txt"; }
}

/**
$db = null;
try {
    $db = new PDO('mysql:host=mysql.myorganization.net;dbname=myDB',
     'username', 'password', array(
        PDO::MYSQL_ATTR_SSL_CA => 'BaltimoreCyberTrustRoot.crt.pem'
));
}

global $db;


$api = new API;
$endpoint = null;
if (isset($GLOBALS["INPUT_PARAMS"]["subtypeid"])) {
	$endpoint = $api->getEndpoint($GLOBALS["INPUT_PARAMS"]["type"], $GLOBALS["INPUT_PARAMS"]["typeid"], $GLOBALS["INPUT_PARAMS"]["subtype"], $GLOBALS["INPUT_PARAMS"]["subtypeid"]);
} elseif (isset($GLOBALS["INPUT_PARAMS"]["subtype"])) {
	$endpoint = $api->getEndpoint($GLOBALS["INPUT_PARAMS"]["type"], $GLOBALS["INPUT_PARAMS"]["typeid"], $GLOBALS["INPUT_PARAMS"]["subtype"]);
} elseif (isset($GLOBALS["INPUT_PARAMS"]["typeid"])) {
	$endpoint = $api->getEndpoint($GLOBALS["INPUT_PARAMS"]["type"], $GLOBALS["INPUT_PARAMS"]["typeid"]);
} else {
	$endpoint = $api->getEndpoint($GLOBALS["INPUT_PARAMS"]["type"]);
}

try {
    $endpoint->call($_SERVER['REQUEST_METHOD'], getRequestBody());
} catch (Exception $e) {
    sendReturnCode(500);
}

**/
?>
