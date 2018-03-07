<?php
require_once("config.php");
require_once("lib/include.php");

//Check Username, Password
if (!is_authorized($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
    header('WWW-Authenticate: Basic realm="PSBCM API"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You need to enter a valid username and password.";
    die;
}

header( 'Content-type: text/html; charset=utf-8' );
header ( "Pragma: no-cache" );
ini_set ( 'memory_limit', '1024M' );
set_time_limit ( 5400 );
define ( "DEBUG_MODE", 1 );
if (DEBUG_MODE == 0) {
	error_reporting ( 0 );
} else {
	error_reporting ( E_ALL );
}

global $inbox;

$hostname = '{outlook.office365.com:993/imap/ssl/user=MunsterUniversity@24Vision.Solutions\Chartering}';
$username = 'MunsterUniversity@24Vision.Solutions';
$password = 'Mun@24V-112017';
$inboxprefix = "24VisionChartering-";
global $inboxprefix;

// Connect to a MySQL database using driver invocation
$dbServername = '24v-azu-db001.mysql.database.azure.com:3307';
$dbUsername = 'dev_cargoinship_service@24v-azu-db001';
$dbPassword = 'cM2ur5FdIqh6';
$dbName = 'dev_dbpsbulkcargo';

$db = null;
$inbox = null;

// configure global inbox variable because this is used in several functions
$inbox = enableIMAPConnection ( $hostname, $username, $password );
$db = enableDBConnection ( $dbServername, $dbUsername, $dbPassword, $dbName );
accessEmails ( $db, $inbox );
imap_close ( $inbox );
$db = null;

/* close the connection */
function enableDBConnection($dbServername, $dbUsername, $dbPassword, $dbName) {
	/* try to connect to database */
	$db = null;
	try {
		$db = mysqli_connect ( $dbServername, $dbUsername, $dbPassword, $dbName );
		message ( "Connection established. \n" );
		return $db;
	} catch ( mysqli_sql_exception $e ) {
		die ( 'Connection failed: ' . $e->getMessage () );
	}
	return $db;
}
function enableIMAPConnection($hostname, $username, $pass) {
	
	/* try to connect to imap server */
	try {
		$inbox = imap_open ( $hostname, $username, $pass );
		print_r ( imap_last_error () );
		if (imap_ping ( $inbox )) {
			message ( "Connected to Imap server! \n" );
		} else {
			message ( 'Hm, something went wrong! ' . imap_last_error () . '\n' );
		}
	} catch ( Exception $e ) {
		message ( "Not connected to Imap server!" );
		connectServerErrors ($db);
		die ( 'Cannot connect to IMAP: ' . imap_last_error () );
	}
	if ($inbox == null)
		die ( 'Inbox empty \n' );
	return $inbox;
}

/* Main Function */
function accessEmails($db, $inbox) {
	$emails = grabEmails ( $inbox );
	if ($emails) {
		rsort ( $emails );
		emailArray ( $db, $inbox, $emails );
	}
}
function connectServerErrors($db) {
	if (imap_errors ()) {
		ob_start ();
		$errorlog = imap_errors ();
		for($i = 0; $i < $errorlog . length; $i ++) {
			ob_flush ();
			$insertSQL = "INSERT INTO email_imap_error`(`errorMessage`) VALUES ('" . $errorlog [i] . "');";
			message($insertsql);
			if ($db->query($insertSQL)) {
				message ( "inserted mail: " . $imapuid );
			} else {
				echo 'Error: ' . $imapuid . '<br>' . mysqli_error ( $db ) . "\n";
			}
		}
	}
}

/* grab emails needs to be extended, when php script allows communication with the user to execute the lower statements */
function grabEmails($inbox) {
	if ($inbox == null) {
		message ( 'Connection error: Inbox empty' );
		$emails = array ();
	} else {
		$emails = imap_search ( $inbox, 'UNSEEN' );
		if ($_GET ["filter"] == "unseen") {
			$emails = imap_search ( $inbox, 'UNSEEN' );
		} elseif ($_GET ["filter"] == "new") {
			$emails = imap_search ( $inbox, 'NEW' );
		} elseif ($_GET ["filter"] == "all") {
			$emails = imap_search ( $inbox, 'ALL' );
		} elseif ($_GET ["filter"] == "search" && isset ( $_GET ["keyword"] )) {
			$emails = imap_search ( $inbox, 'TEXT "' . urldecode ( $_GET ["keyword"] . '"' ) );
		}
	}
	return $emails;
}

/* This function stores the email into an array that can be written into the database via the insertEmail function */
function emailArray($db, $inbox, $emails) {
	/* for every email... */
	foreach ( $emails as $key => $email_number ) {
		ob_start ();
		/* get information specific to this email */
		$overview = imap_fetch_overview ( $inbox, $email_number, 0 );
		$message = imap_fetchbody ( $inbox, $email_number, "1" , FT_UID | FT_PEEK);
		$message = str_replace ( chr ( 39 ), "", $message );
		$message = strip_html_tags ( $message );
		// $message = cleanString($message);
		
		/* output the email header information */
		$email = array ();
		$email ["Subject"] = mysqli_real_escape_string($db, imap_utf8 ( $overview [0]->subject ));
		$email ["Subject"] = mysqli_real_escape_string($db, str_replace ( chr ( 39 ), "", imap_utf8($email ["Subject"]) ));
		$email ["Body"] = mysqli_real_escape_string($db, imap_utf8 ( $message ));
		$email ["From"] = mysqli_real_escape_string($db, $overview [0]->from);
		$email ["To"] = mysqli_real_escape_string($db, $overview [0]->to);
		// $email ["CC"] = $overview [0]->cc;
		$email ["Date"] = mysqli_real_escape_string($db, $overview [0]->date);
		$email ["IMAPUID"] = $GLOBALS["inboxprefix"] . $overview [0]->uid;
		insertEmail ( $db, $inbox, $email );
	}
}
function insertEmail($db, $inbox, $email) {
	$subject = $email ["Subject"];
	$body = $email ["Body"];
	$from = $email ["From"];
	$to = $email ["To"];
	$date = $email ["Date"];
	$imapuid = $email ["IMAPUID"];
	$semKey = 1; // Access Key for the Semaphore that is used for database
	             // $semaphore = sem_get ( $semKey, 1 ); // returns the semaphore
	             // sem_aquire ( $semaphore ); // tries to acquire the semaphore if free
	if (! empty ( $imapuid )) {
		$insertsql = "INSERT INTO dev_dbpsbulkcargo.email (subject, body, sender, receiver, date, IMAPUID)
					VALUES
					('" . $subject . "','" . $body . "','" . $from . "','" . $to . "','" . $date . "','" . $imapuid . "');";
		//message($insertsql);
	}
	if (mysqli_query ( $db, $insertsql )) {
		message ( "inserted mail: " . $imapuid );
	} else {
		message('Error: ' . $imapuid . '<br>' . mysqli_error ( $db ) . "<br>");
	}
	// sem_release ( $semaphore );
}

function strip_html_tags($str) {
	$str = preg_replace ( '/(<|>)\1{2}/is', '', $str );
	$str = preg_replace ( array ( // Remove invisible content
			'@<head[^>]*?>.*?</head>@siu',
			'@<style[^>]*?>.*?</style>@siu',
			'@<script[^>]*?.*?</script>@siu',
			'@<noscript[^>]*?.*?</noscript>@siu' 
	), "", // replace above with nothing
$str );
	$str = replaceWhitespace ( $str );
	$str = strip_tags ( $str );
	return $str;
}

?>