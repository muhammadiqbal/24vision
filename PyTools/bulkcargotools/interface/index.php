<?php
ini_set('memory_limit', '1024M');
set_time_limit(540);

session_start();
require_once("config.php");

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

function strip_html_tags($str)
{
	if (strpos($a, '</') !== false) {
		//$str = preg_replace('/(<|>)\1{2}/is', '', $str);
		$str = preg_replace(array( // Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu'
			), "", // replace above with nothing
			$str);
		$str = strip_tags($str);
		return $str;
	} else {
		return $str;
	}
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Bulk Cargo Tool</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- jQuery 3.2.1 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  

<!--Bootstrap Framework -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

<!-- Own Styles and scripts -->
<link rel="stylesheet" type="text/css" href="style.css">
<script>
$( document ).ready(function() {
	var options_cargo = {
	  valueNames: [ 'sender', 'quantity', 'flexibility', 'commodity',  'load_port', 'discharge_port', 'laycan', 'terms', 'commission' ],
	  page: 20,
	  pagination: true
	};
	var cargolist = new List('cargo-list', options_cargo);
	
	var options_ship = {
	  valueNames: [ 'sender', 'ship_name', 'location', 'open_date' ],
	  page: 20,
	  pagination: true
	};
	var shiplist = new List('ship-list', options_ship);
	
	var options_order = {
	  valueNames: [ 'sender', 'ship_size', 'laycan', 'delivery_port', 'redelivery_port' ],
	  page: 20,
	  pagination: true
	};
	var orderlist = new List('order-list', options_order);
	
	var options_hitl = {
	  valueNames: [ 'id', 'sender', 'receiver', 'subject', 'classification_automated', 'certainty' ],
	  page: 20,
	  pagination: true
	};
	var hitllist = new List('hitl-list', options_hitl);
});	

jQuery( ".toptabs div" ).on("click", function() {
	console.log("Test");
	alert(jQuery(this).attr("id"));
});

function ChangeViewTo(listname) {
	jQuery("#cargo-list").hide(); jQuery("#cargo-list-trigger").removeClass("active");
	jQuery("#ship-list").hide(); jQuery("#ship-list-trigger").removeClass("active");
	jQuery("#order-list").hide(); jQuery("#order-list-trigger").removeClass("active");
	jQuery("#hitl-list").hide(); jQuery("#hitl-list-trigger").removeClass("active");
	
	if (listname == "cargo-list") { jQuery("#cargo-list").show(); jQuery("#cargo-list-trigger").addClass("active"); }
	if (listname == "ship-list") { jQuery("#ship-list").show(); jQuery("#ship-list-trigger").addClass("active"); }
	if (listname == "order-list") { jQuery("#order-list").show(); jQuery("#order-list-trigger").addClass("active"); }
	if (listname == "hitl-list") { jQuery("#hitl-list").show(); jQuery("#hitl-list-trigger").addClass("active"); }
}
	
</script>
<!-- Loadscreen Header -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<style>
#loading{
	background-color: #fff;;
	height: 100%;
	width: 100%;
	position: fixed;
	z-index: 1;
	margin-top: 0px;
	top: 0px;
}
#loading-center{
	width: 100%;
	height: 100%;
	position: relative;
	}
#loading-center-absolute {
	position: absolute;
	left: 50%;
	top: 50%;
	height: 50px;
	width: 300px;
	margin-top: -25px;
	margin-left: -150px;

}
.loading-object{
	width: 18px;
	height: 18px;
	background-color: #df2825;
	float: left;
    margin-top: 15px;
	margin-right: 15px;
	-moz-border-radius: 50% 50% 50% 50%;
	-webkit-border-radius: 50% 50% 50% 50%;
	border-radius: 50% 50% 50% 50%;
	-webkit-animation: loading-object 1s infinite;
	animation: loading-object 1s infinite;
}
.loading-object:last-child {
	margin-right: 0px;
	}

.loading-object:nth-child(9){
	-webkit-animation-delay: 0.9s;
    animation-delay: 0.9s;
	}
.loading-object:nth-child(8){
	-webkit-animation-delay: 0.8s;
    animation-delay: 0.8s;
	}
.loading-object:nth-child(7){
	-webkit-animation-delay: 0.7s;
    animation-delay: 0.7s;
	}	
.loading-object:nth-child(6){
	-webkit-animation-delay: 0.6s;
    animation-delay: 0.6s;
	}
.loading-object:nth-child(5){
	-webkit-animation-delay: 0.5s;
    animation-delay: 0.5s;
	}
.loading-object:nth-child(4){
	-webkit-animation-delay: 0.4s;
    animation-delay: 0.4s;
	}
.loading-object:nth-child(3){
	-webkit-animation-delay: 0.3s;
    animation-delay: 0.3s;
	}
.loading-object:nth-child(2){
	-webkit-animation-delay: 0.2s;
    animation-delay: 0.2s;
	}								

@-webkit-keyframes loading-object{
50% {
    -ms-transform: translate(0,-50px); 
   	-webkit-transform: translate(0,-50px);
    transform: translate(0,-50px);
	}
}		
@keyframes loading-object{
50% {
    -ms-transform: translate(0,-50px); 
   	-webkit-transform: translate(0,-50px);
    transform: translate(0,-50px);
	}
}

#kibana-logo {
	max-width: 40px;
}

</style>
<!--end loadscreen header -->
 </head>
 <body>

<!-- Begin LoadScreen body -->
<div id="loading">
	<div id="loading-center">
		<div id="loading-center-absolute">
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
			<div class="loading-object"></div>
		</div>
	</div>
</div>
<!-- End LoadScreen body -->

 <div class="container">
	<div class="page-header">
	  <h1>24Vision <small>Bulk Cargo Tool</small><a href="http://40.114.243.102:5601/app/kibana#/dashboard/f9722ca0-6d75-11e7-8a03-b90edacc036a?_g=(refreshInterval%3A(display%3AOff%2Cpause%3A!f%2Cvalue%3A0)%2Ctime%3A(from%3A'2017-04-30T22%3A00%3A00.000Z'%2Cmode%3Aabsolute%2Cto%3A'2017-07-20T21%3A59%3A59.999Z'))" style="float: right;" target="_blank"><img id="kibana-logo" src="img/kibana.png" /></a></h1>
	</div>
	<div class="flow-aside"  onclick="ChangeViewTo('hitl-list');">
		<div id="hitl-list-trigger">
			<span class="glyphicon glyphicon-eye-close" aria-hidden="true" >
		</div>
		
	</div>
 </div>
 <div class="container">
	<div class="row toptabs">
		<a class="toptab active col-md-4 col-lg-4 col-s-4 col-xs-4" id="cargo-list-trigger" onclick="ChangeViewTo('cargo-list');">CARGO</a>
		<a class="toptab col-md-4 col-lg-4 col-s-4 col-xs-4" id="ship-list-trigger" onclick="ChangeViewTo('ship-list');">SHIP</a>
		<a class="toptab col-md-4 col-lg-4 col-s-4 col-xs-4" id="order-list-trigger" onclick="ChangeViewTo('order-list');">ORDER</a>
	</div>
</div>
<div class="container">
  <!-- LIST OF CARGOS -->
  <div id="cargo-list">
	  <input class="search" placeholder="Search" />

	  <table class="table">
		<thead>
			<tr>
				<td class="sort" data-sort="date">Date</td>
				<td class="sort" data-sort="sender">Sender</td>
				<td class="sort" data-sort="cargo">Cargo</td>
				<td class="sort" data-sort="load_port">Load Port</td>
				<td class="sort" data-sort="discharge_port">Discharge Port</td>
				<td class="sort" data-sort="laycan">Laycan</td>
				<td class="sort" data-sort="terms">Terms</td>
				<td class="sort" data-sort="commission">Commission</td>
				<td>Mail</td>
				<td>Reclassify</td>
			</tr>
		</thead>
		<!-- IMPORTANT, class="list" have to be at tbody -->
		<tbody class="list">
			<?php
			//Pull Cargo entities out of the database.

				//Query for filtering by date
			//$cargos = $db->query("SELECT c.cargo, c.load_place, c.disch_place, c.laycan, c.terms, c.commission, e.sender, e.date, c.emailID, e.imapuid FROM cargo_offer_extracted AS c LEFT JOIN email AS e ON e.emailID = c.emailID WHERE STR_TO_DATE(e.date, '%Y-%m-%d') >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ORDER BY c.emailID DESC;");

			//Query for filtering by number of mails
			$cargos = $db->query("SELECT c.cargo, c.load_place, c.disch_place, c.laycan, c.terms, c.commission, e.sender, e.date, c.emailID, e.imapuid FROM cargo_offer_extracted AS c LEFT JOIN email AS e ON e.emailID = c.emailID ORDER BY c.emailID DESC LIMIT 1000;");


			foreach ($cargos as $cargo) {
				$short = $cargo;
				$id = $cargo["emailID"];
				$imapuid = $cargo["imapuid"];
				if (strlen($cargo["sender"]) > 20) { $short["sender"] = substr($cargo["sender"], 0, 20); }
				$attachments = $db->query("SELECT attachment FROM attachment WHERE imapuid = $imapuid;");
				$attachment = $attachments->fetch();
				?>
			<tr class="emailid-<?php echo $cargo["emailID"]; ?>">
			<td class="date"><?php echo $cargo["date"]; ?></td>
			<td class="sender"><?php echo $short["sender"]; ?></td>
			<td class="cargo"><?php echo $cargo["cargo"]; ?></td>
			<td class="load_port"><a href="http://maps.google.com/?q=<?php echo $cargo["load_place"]; ?>" target="_blank"><?php echo $cargo["load_place"]; ?></a></td>
			<td class="discharge_port"><a href="http://maps.google.com/?q=<?php echo $cargo["disch_place"]; ?>" target="_blank"><?php echo $cargo["disch_place"]; ?></a></td>
			<td class="laycan"><?php echo $cargo["laycan"]; ?></td>
			<td class="terms"><?php echo $cargo["terms"]; ?></td>
			<td class="commission"><?php echo $cargo["commission"]; ?></td>
			<td class="mail">
				<?php echo $id; ?>
				</br>
				<a href="email.php?emailID=<?php echo $id; ?>" data-featherlight="ajax"><span class="glyphicon glyphicon-envelope" aria-hidden="true" ></span></a>
				<?php if (!empty($attachment)) { ?>
					<a href="attachments.php?imapuid=<?php echo $imapuid?>" data-featherlight="ajax"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></a>
				<?php } ?>				
			</td>
			<td class="classification">
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
									<li ><a data-type="ship" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'ship')">Ship Offer</a></li>
									<li><a data-type="order" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'order')">Ship Order</a></li>
									<li><a data-type="cargo" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'cargo')">Cargo</a></li>
									<li role="separator" class="divider"></li>
									<li><a data-type="report" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'report')">Report</a></li>
									<li><a data-type="spam" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'spam')">Spam</a></li>
				  </ul>
				</div>
			</td>
		  </tr>	
				
				<?php
			}
			
			?>
		

		</tbody>
		</table>
    <ul class="pagination"></ul>
  </div>
  
  <!-- LIST OF SHIPS -->
  <div id="ship-list" style="display: none;">
	  <input class="search" placeholder="Search" />
	<!--
	<?php
	$test = $db->query("SELECT * FROM ship_offer_extracted AS s LEFT JOIN email AS e ON e.emailID = s.emailID ORDER BY s.emailID DESC;");
	$test = $test->fetch();
	print_r($test)
	?>
	-->

	<table class="table">
		<thead>
			<tr>
				<td class="sort" data-sort="date">Date</td>
				<td class="sort" data-sort="sender">Sender</td>
				<td colspan="1">Ship</td>
				<td>Year</td>
				<td>DWT</td>
				<td class="sort" data-sort="location">Location</td>
				<td class="sort" data-sort="open_date">Open Date</td>
				<td class="sort" data-sort="destination">Destination</td>
				<td>Mail</td>
				<td>Reclassify</td>
			</tr>
		</thead>
		<!-- IMPORTANT, class="list" has to be at tbody -->
		<tbody class="list">
			<?php
			//Pull Cargo entities out of the database.
			$ships = $db->query("SELECT s.ship_name, s.ship_year, s.ship_dwt, s.loading_place, s.open_date, s.destination, e.sender, e.date, s.emailID FROM ship_offer_extracted AS s LEFT JOIN email AS e ON e.emailID = s.emailID ORDER BY s.emailID DESC LIMIT 1000;");
			
			foreach ($ships as $ship) {
				$short = $ship;
				$id = $ship["emailID"];
				if (strlen($ship["sender"]) > 20) { $short["sender"] = substr($ship["sender"], 0, 20); }				
				?>
				<tr class="emailid-<?php echo $ship["emailID"]; ?>">
						<td class="date"><?php echo $ship["date"]; ?></td>
						<td class="sender"><?php echo $short["sender"]; ?></td>
						<td class="ship_name"><?php echo $ship["ship_name"]; ?></td>
						<td class="ship_year"><?php echo $ship["ship_year"]; ?></td>
						<td class="ship_dwt"><?php echo $ship["ship_dwt"]; ?></td>
						<td class="location"><a href="http://maps.google.com/?q=<?php echo $ship["loading_place"]; ?>" target="_blank"><?php echo $ship["loading_place"]; ?></a></td>
						<td class="open_date"><?php echo $ship["open_date"]; ?></td>
						<td class="open_date"><?php echo $ship["destination"]; ?></td>
						<td class="mail">
							<?php echo $id; ?>
							</br>
							<a href="email.php?emailID=<?php echo $id; ?>" data-featherlight="ajax"><span class="glyphicon glyphicon-envelope" aria-hidden="true" ></span></a>
							<a href="./attachments/"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></a>
						</td>
						<td class="classification">
								<div class="btn-group">
								  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu">
									<li ><a data-type="ship" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'ship')">Ship Offer</a></li>
									<li><a data-type="order" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'order')">Ship Order</a></li>
									<li><a data-type="cargo" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'cargo')">Cargo</a></li>
									<li role="separator" class="divider"></li>
									<li><a data-type="report" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'report')">Report</a></li>
									<li><a data-type="spam" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'spam')">Spam</a></li>
								  </ul>
								</div>
						</td>
				</tr>	
					
					<?php
				}
				
				?>
			
		</tbody>
		</table>	
	  
		<ul class="pagination"></ul>
	</div>
  
  <!-- LIST OF SHIP ORDERS -->
  <div id="order-list" style="display: none;">
	  <input class="search" placeholder="Search" />
	  <table class="table">
		<thead>
			<tr>
				<td class="sort" data-sort="date">Date</td>
				<td class="sort" data-sort="sender">Sender</td>
				<td class="sort" data-sort="account">Account</td>
				<td class="sort" data-sort="ship_size">Ship Size</td>
				<td class="sort" data-sort="ship_type" colspan="1">Ship Type</td>
				<td class="sort" data-sort="laycan">Laycan</td>
				<td class="sort" data-sort="delivery_port">Delivery Port</td>
				<td class="sort" data-sort="redelivery_port">Redelivery Port</td>
				<td class="sort" data-sort="employment">Employment</td>
				<td class="sort" data-sort="cargo">Cargo</td>
				<td class="sort" data-sort="duration">Duration</td>
				<td class="sort" data-sort="commission">Commission</td>
				<td>Mail</td>
				<td>Reclassify</td>
			</tr>
		</thead>
		<!-- IMPORTANT, class="list" have to be at tbody -->
		<tbody class="list">
			<?php
			//Pull Cargo entities out of the database.
				$ships = $db->query("SELECT s.ship_size, s.laycan, s.delivery_location, s.redelivery_location, s.ship_age, s.ship_cranes, s.ship_grabs, s.ship_type, s.ship_gear, s.employment, s.cargo, s.duration, s.commission, s.account_name, e.date, e.sender, s.emailID FROM ship_order_extracted AS s LEFT JOIN email AS e ON e.emailID = s.emailID ORDER BY s.emailID DESC LIMIT 1000;");
			foreach ($ships as $ship) {
				$short = $ship;
				$id = $ship["emailID"];
				if (strlen($ship["sender"]) > 20) { $short["sender"] = substr($ship["sender"], 0, 20); }	

				?>
				<tr class="emailid-<?php echo $ship["emailID"]; ?>">
					<td class="date"><?php echo $ship["date"]; ?></td>
					<td class="sender"><?php echo $short["sender"]; ?></td>
					<td class="account"><?php echo $ship["account_name"]; ?></td>
					<td class="ship_size"><?php echo $ship["ship_size"]; ?></td>
					<!--<td class="age"><?php echo $ship["ship_age"]; ?></td>-->
					<!--<td class="cranes"><?php echo $ship["ship_cranes"]; ?></td>-->
					<!--<td class="grabs"><?php echo $ship["ship_grabs"]; ?></td>-->
					<td class="ship_type"><?php echo $ship["ship_type"]; ?></td>
					<!---<td class="gear"><?php echo $ship["ship_gear"]; ?></td>-->
					<td class="laycan"><?php echo $ship["laycan"]; ?></td>
					<td class="delivery_port"><?php echo $ship["delivery_location"]; ?></td>
					<td class="redelivery_port"><?php echo $ship["redelivery_location"]; ?></td>
					<td class="employment"><?php echo $ship["employment"]; ?></td>
					<td class="cargo"><?php echo $ship["cargo"]; ?></td>
					<td class="duration"><?php echo $ship["duration"]; ?></td>
					<td class="commission"><?php echo $ship["commission"]; ?></td>
					<td class="mail">
						<?php echo $id; ?>
						</br>
						<a href="email.php?emailID=<?php echo $id; ?>" data-featherlight="ajax"><span class="glyphicon glyphicon-envelope" aria-hidden="true" ></span></a>
						<a href="hitl.html" data-featherlight="ajax"><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span></a>
					</td>
					<td class="classification">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="caret"></span>
							</button>
							  <ul class="dropdown-menu">
								<li ><a data-type="ship" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'ship')">Ship Offer</a></li>
									<li><a data-type="order" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'order')">Ship Order</a></li>
									<li><a data-type="cargo" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'cargo')">Cargo</a></li>
									<li role="separator" class="divider"></li>
									<li><a data-type="report" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'report')">Report</a></li>
									<li><a data-type="spam" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'spam')">Spam</a></li>
							  </ul>
						</div>
					</td>
				</tr>	
					
					<?php
				}
				
				?>

		</tbody>
		</table>
		<ul class="pagination"></ul>
	</div>
	
	<!-- Human-in-the-loop List -->
	<div id="hitl-list" style="display: none;">
	  <input class="search" placeholder="Search" />
	  <a href="hitl.php" class="btn btn-default" style="float: right;" data-featherlight="ajax">Start ReClassification Run</a>
	  <table class="table">
		<thead>
			<tr>
				<td class="sort" data-sort="id">ID</td>
				<td class="sort" data-sort="sender">Sender</td>
				<td class="sort" data-sort="receiver">Receiver</td>
				<td class="sort" data-sort="subject">Subject</td>
				<td class="sort" data-sort="body">Body (abstract)</td>
				<td class="sort" data-sort="classification">Classification</td>
				<td class="sort" data-sort="accuracy">Certainty</td>
				<td></td>
			</tr>
		</thead>
		<!-- IMPORTANT, class="list" have to be at tbody -->
		<tbody class="list">
			<?php
			//Pull Cargo entities out of the database.
			$emails = $db->query("SELECT * FROM email WHERE classification_automated IS NOT NULL AND classification_automated_certainty IS NOT NULL ORDER BY classification_automated_certainty ASC LIMIT 500;");
			foreach ($emails as $email) {
				$emailshort = $email;
				$id = $email["emailID"];
				$email["body"] = strip_tags($email["body"]);
				if (strlen($email["sender"]) > 20) { $emailshort["sender"] = substr($email["sender"], 0, 20); }
				if (strlen($email["receiver"]) > 20) { $emailshort["receiver"] = substr($email["receiver"], 0, 20); }
				if (strlen($email["subject"]) > 30) { $emailshort["subject"] = substr($email["subject"], 0, 30); }
				if (strlen($email["body"]) > 30) { $emailshort["body"] = substr($email["body"], 0, 30). "..."; }
				?>
				<tr class="emailid-<?php echo $email["emailID"]; ?>">
							<td class="id"><?php echo $email["emailID"]; ?></td>
							<td class="sender"><?php echo $emailshort["sender"]; ?></td>
							<td class="receiver"><?php echo $emailshort["receiver"]; ?></td>
							<td class="subject"><?php echo $email["subject"]; ?></td>
							<td class="body"><?php echo $emailshort["body"]; ?></td>
							<td class="classification"><?php echo $email["classification_automated"]; ?></td>
							<td class="accuracy"><?php echo $email["classification_automated_certainty"]; ?></td>

							<td>
								<a href="email.php?emailID=<?php echo $id; ?>" data-featherlight="ajax"><span class="glyphicon glyphicon-envelope" aria-hidden="true" ></span></a>
								<div class="btn-group">
								  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu">
									<li ><a data-type="ship" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'ship')">Ship Offer</a></li>
									<li><a data-type="order" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'order')">Ship Order</a></li>
									<li><a data-type="cargo" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'cargo')">Cargo</a></li>
									<li role="separator" class="divider"></li>
									<li><a data-type="report" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'report')">Report</a></li>
									<li><a data-type="spam" onclick="UpdateEmailClassification(<?php echo $id; ?>, 'spam')">Spam</a></li>
								  </ul>
								</div>
							</td>
				</tr>	
					
					<?php
				}
				
				?>
		</tbody>
		</table>
    <ul class="pagination"></ul>
  </div>
	
</div>
 
 <!-- Featherlight Lightbox Plugin -->
<link href="//cdn.rawgit.com/noelboss/featherlight/1.7.6/release/featherlight.min.css" type="text/css" rel="stylesheet" />
<script src="//cdn.rawgit.com/noelboss/featherlight/1.7.6/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<!-- LoadScreen -->
<script>
jQuery(window).on('load', function(){
   jQuery("#loading").fadeOut(2500);
})

function UpdateEmailClassification(emailID, classification_manual) {
	var ajaxurl = "ajax/hitl_update.php?emailid=" + emailID + "&classification_manual=" + classification_manual;
	console.log("Querying " + ajaxurl);
	jQuery.ajax({
	  url: ajaxurl,
	  context: document.body
	}).done(function() {
		console.log("Query done.");
		/* Hide the respective element */
	    jQuery(".emailid-" + emailID).fadeOut(1500);
	});
}

</script>
</body>
</html>
