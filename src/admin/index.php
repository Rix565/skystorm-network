<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
	<h2>Home</h2>
	<?php
	try {
	    $q = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
	    $q->bindParam(":username", $_SESSION['nickname']);
	    $q->execute();
	    $result = $q->fetch();
	} catch(Exception $e){
	    die("Error ! " . $e->getMessage());	        	
	}
	if(empty($_SESSION['nickname'])){
		header("Location: not_logged.html");
	}else if($result['class']!=="admin"){
		header("Location: not_logged.html");
	}
	?>
	<div id="container">
		<a href="balancemanagement.php"><button>Go to the balance management system</button></a><a href="skytalkmanagement.php"><button>Go to the SkyTalk Management</button></a><a href="usermanagement.php"><button>Go to the User Management</button></a><a href="../"><button>Go to home</button></a>
	</div>
	<?php
	$request = $db->prepare("SELECT COUNT(*) AS nbr FROM `users`");
	$request->execute();
	$result = $request->fetch();
	echo "<p>Currently " .$result['nbr']. " users on Skystorm Network.</p>"
	?>
</body>
</html>