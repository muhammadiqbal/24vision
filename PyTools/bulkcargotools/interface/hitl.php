<?php

require_once("config.php");

/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=dev_cargoinship_service@24v-azu-db001;host=24v-azu-db001.mysql.database.azure.com;port=3306';
$user = 'dev_cargoinship_service@24v-azu-db001';
$password = 'cM2ur5FdIqh6';

$db = null;
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    throw new Exception('Connection failed: ' . $e->getMessage());
}
global $db;

?>

<!DOCTYPE html>

<html>
<html lang="en-US">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!--jQuery 3.2.1 --> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  

<!--Bootstrap Framework -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

<!-- Own Styles and scripts -->
<link rel="stylesheet" type="text/css" href="style.css">
<style>
	.btn.active {
		background-color: #df2825;
		color: #fff;
	}
	
	#classification-buttons {
	margin-bottom: 3em; 
	}

	p textarea {
		width:100%;
	}
	
	.col-centered{
			float: none;
			margin: 0 auto;
		}
</style>
<script>
	jQuery("#classification-buttons .btn").on("click", function(){
		// set button as active
		jQuery("#classification-buttons .btn").removeClass("active");
		jQuery(this).addClass("active");
	});
</script>
 </head>

<body>

<div class="container">
	<div class="page-header">
	  <h1>24Vision <small>Human in the Loop - Correct the Classification</small></h1>
	</div>
 </div>
 <br>

<?php 
//get first mail ordered by certainty
$sql = $db->query("SELECT * FROM email WHERE classification_automated_certainty IS NOT NULL AND classification_automated IS NOT NULL AND classification_manual IS NULL ORDER BY classification_automated_certainty ASC LIMIT 1;");
$email = $sql->fetch();
$id = $email["emailID"];
?>

<div class="container">
	<div class="row">
		<div class="col-md-3">

			<span class="label label-warning" style="font-size: 120%; display: block; padding-top: 5px; padding-bottom: 5px; margin-top: 5px; float: left;"><?php echo "Auto: " . $email["classification_automated"] . " - Confidence: " . $email["classification_automated_certainty"]?></span>
		</div>

		<div class="col-md-6">
			<div class="btn-group" id="classification-buttons" role="group" aria-label="Classification Options" style="margin-bottom: 10px;">

 				<button type="button" id="classification-btn-ship" class="btn btn-secondary" value="ship" onclick="reclassify('ship')">Ship</button>
				<button type="button" id="classification-btn-cargo" class="btn btn-secondary" value="cargo" onclick="reclassify('cargo')">Cargo</button>
				<button type="button" id="classification-btn-order" class="btn btn-secondary" value="order" onclick="reclassify('order')">Order</button>
				<button type="button" id="classification-btn-report" class="btn btn-secondary" value="report" onclick="reclassify('report')">Report</button>
				<button type="button" id="classification-btn-spam" class="btn btn-secondary" value="spam" onclick="reclassify('spam')">Spam</button>			

			</div> 
		</div>
		<div class="col-md-3">
		<!-- <button type="button" style="float: right;" class="btn btn-primary" onclick="alert('Hello World!')">Next Email</button>-->
		<a href="hitl.php" onclick="$.featherlight.close()" class="btn btn-default" style="float: right;" class="btn btn-primary" data-featherlight="ajax">Next</a>
		</div>
	</div>


	<div>
		<div class="row">
			<div class="col-md-1">Sender</div>
			<textarea name="Sender" id="textarea-body" rows="1" cols="80" readonly=true><?php echo $email["sender"]; ?></textarea>
		</div>
		<div class="row">
			<div class="col-md-1">Subject</div>
			<textarea name="Subject" id="textarea-body" rows="1" cols="80" readonly=true><?php echo $email["subject"]; ?></textarea>
		</div>
		<div class="row">
			<div class="col-md-1">Date</div>
			<textarea name="Date" id="textarea-body" rows="1" cols="80" readonly=true><?php echo $email["date"]; ?></textarea>
		</div>
		<p>
			<textarea name="Email" id="textarea-body" rows="50" cols="200" width="100%" readonly=true><?php echo $email["body"]; ?></textarea>
		</p>

	</div>

</div>


</body>
<script>
	function reclassify(value) {
		var dataString = "emailid=<?php echo $id?>&classification_manual="+value
	      	$.ajax({
			url:"ajax/hitl_update.php",
			type: "GET",
			data: dataString, 
			success:function(result){
			 alert(result); }
	     	});
	 }
</script>
</html>
