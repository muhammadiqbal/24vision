<?php
error_reporting(0);
/*if ($_GET["debug"] == "1") {
	define("DEBUG_MODE",		1);
	error_reporting(E_ALL ^E_NOTICE);
} else {
	define("DEBUG_MODE",		0);
	error_reporting(0);
}*/



/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=dbpsbulkcargo;host=wi-mysql.uni-muenster.de;port=3307';
$user = 'dbpsbulkcargo';
$password = '##763EsxW2!';

$output = "csv";
$headers = array();
if (isset($_GET["output"])) {
	if ($_GET["output"] == "txt") { $output = "txt"; }
}


$db = null;
try {
    $db = new PDO($dsn, $user, $password);
	//message("Connection established.");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
$sql = "";
if($_SERVER['REQUEST_METHOD'] == "GET") {
	
	if (strtolower($_GET["type"]) == "emails") {
		$sql = "SELECT emailID, subject, body, sender, receiver, cc, date, classification_manual, classification_automated FROM email LIMIT 200";
		$headers = array("emailID", "subject", "body", "sender", "receiver", "cc", "date", "classification_manual", "classification_automated");
	}
	
	//Query the database
	$sqlreturn = "";
	if ($sql != "") {
		$sqlreturn = $db->query($sql);
	}

	//Output results in appropriate form
	if ($sqlreturn != "") {
		if ($output == "csv") {
			$export = $sqlreturn;

			$filename = date('d.m.Y').'.csv';

			$data = fopen($filename, 'w');
			if (count($headers) > 1) {
				fputcsv($data, $headers);
			}
			
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

			if ($_GET["download"] == "1") {
				header("Content-type: application/csv");
				header("Content-Disposition: attachment; filename=emails.csv");
			}
			
			header("Pragma: no-cache");
			header("Expires: 0");
			echo file_get_contents($filename);
		}
	}
	
} elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {

	
	if ($_GET["type"] == "email" && isset($_GET["emailID"]) && isset($_GET["classification_automated"])) {

		//Some error handling
		if (!is_numeric($_GET["emailID"])) {echo "emailD not numeric"; }
		if (!in_array($_GET["classification_automated"], array("cargo", "ship", "order", "mix", "other"))) { echo "Classification is not cargo, ship, order, mix or other."; die();}
		
		//Sql Query.
		$emailID = mysql_real_escape_string($_GET["emailID"]);
		$emailID = $_GET["emailID"];
		$classification_automated = $_GET["classification_automated"];
		$sql = "UPDATE email SET classification_automated='" . $classification_automated . "' WHERE emailID='" . $emailID . "';";
		$db->query($sql);
		//echo $sql;
		echo "Success";
	} else {
		echo "Fail. emailID or classification_automated probably not set.";
	}
	
} else {
	echo "Unknown Request Method."; 
	file_put_contents("test.txt", "Hello World.");die();
}



function message($msg) {
	if (DEBUG_MODE == 1) {
		echo $msg . "<br>";
	}
}

function cleanContent($str){
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(
        array(// Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu'
            ),
        "", //replace above with nothing
        $str );
   // $str = replaceWhitespace($str);
    $str = strip_tags($str);
	$str = cleanEncoding($str);
    return $str;
}

function replaceWhitespace($str) {
    $result = $str;
    foreach (array(
    "  ", " \t",  " \r",  " \n",
    "\t\t", "\t ", "\t\r", "\t\n",
    "\r\r", "\r ", "\r\t", "\r\n",
    "\n\n", "\n ", "\n\t", "\n\r",
    ) as $replacement) {
    $result = str_replace($replacement, $replacement[0], $result);
    }
    return $str !== $result ? replaceWhitespace($result) : $result;
}

function cleanEncoding($str) {
	$str = str_replace("=C3=9F", "ß", $str);
	$str = str_replace("=C3=BC", "ü", $str);
	$str = str_replace("=C3=A4", "ä", $str);
	$str = str_replace("=3D", "", $str);
	$str = str_replace("&uuml;", "ü", $str);
	$str = str_replace("&auml;", "ä", $str);
	$str = str_replace("&ouml;", "ö", $str);
	$str = str_replace(array("&zwnj;", "&nbsp;", "&#54;", "&#53;", "&#52;", "&#51;", "&#50;", "&#49;", "&#48;", "&#47;", "&#56;"), "", $str);
	return $str;
}

?>