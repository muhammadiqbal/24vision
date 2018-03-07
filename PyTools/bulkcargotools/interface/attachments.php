<?php
/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=dev_dbpsbulkcargo;host=24v-azu-db001.mysql.database.azure.com;port=3306';
$user = 'dev_cargoinship_service@24v-azu-db001';
$password = '#DoYourMagic2017';

$db = null;
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    throw new Exception('Connection failed: ' . $e->getMessage());
}
global $db;

//$emailID = $_GET['emailID'];
$imapuid = $_GET['imapuid'];

$link = "developer.cargoinship.com/var/www/html/";
?>
<html>
<head>
<head>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

jQuery 3.2.1 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  

<!--Bootstrap Framework 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

<!-- Own Styles and scripts 
<link rel="stylesheet" type="text/css" href="style.css">-->
<style>

	p label {
		display:block;
		float:left;
		width:10%; 
	}
</style>
</head>
<body>

<?php
// example imapuID 29908
$attachments = $db->query("SELECT attachmentID, attachment, link FROM attachment WHERE imapuid=$imapuid;");
//$attachment = $attachments->fetch();
//print_r($test);

foreach($attachments as $attachment) {
?>

<?php echo $attachment["attachment"] . " (ID: " . $attachment["attachmentID"] . ")"; ?>
<p>
	<label for="Link">Link:</label>
	<a target="_blank" href="file://<?php echo $link . $attachment["link"] ?>"><?php echo $attachment["link"] ?></a>
</p>

<?php
	}	
?>


</body>
</html>
