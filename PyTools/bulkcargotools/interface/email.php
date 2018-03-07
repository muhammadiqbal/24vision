<?php
/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=dev_dbpsbulkcargo;host=24v-azu-db001.mysql.database.azure.com;port=3306';
$user = 'dev_cargoinship_service@24v-azu-db001';
$password = 'dev_cargoinship_service@24v-azu-db001';

$db = null;
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    throw new Exception('Connection failed: ' . $e->getMessage());
}
global $db;

$emailID = $_GET['emailID'];

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
	p textarea {
		width:85%;
	}


	
</style>
</head>
<body>

<?php
$emails = $db->query("SELECT * FROM email WHERE emailID=$emailID limit 1;");
$email = $emails->fetch();
?>

<p>
	<label for="Sender">Sender</label>
	<textarea name="Sender" id="textarea-body" rows="1" readonly=true><?php echo $email["sender"]; ?></textarea>
</p>
<p>
	<label for="Subject">Subject</label>
	<textarea name="Subject" id="textarea-body" rows="1" readonly=true><?php echo $email["subject"]; ?></textarea>
</p>
<p>
	<label for="Date">Date</label>
	<textarea name="Date" id="textarea-body" rows="1" readonly=true><?php echo $email["date"]; ?></textarea>
</p>
	<textarea name="Email" id="textarea-body" rows="50" cols="80" width="100%" readonly=true><?php echo $email["body"]; ?></textarea>

</body>
</html>
	
