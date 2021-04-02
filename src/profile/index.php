<?php
require "libs/base.php";
require "../libs/connect.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network</h1>
	<?php
	require "../libs/connectinfo_folder.php";
	?>
	<?php
	if(isset($_GET['id'])){
		try {
	        $q = $db->prepare("SELECT * FROM `users` WHERE `id`=:id");
	        $q->execute([
	        	"id" => $_GET['id']
	        ]);
	        $result = $q->fetch();
	        $q2 = $db->prepare("SELECT * FROM `user_data` WHERE `id`=:id");
	        $q2->execute([
	        	"id" => $_GET['id']
	        ]);
	        error_reporting(E_ALL ^ E_NOTICE);
	        $result2 = $q2->fetch();
	        if (!is_null($result['username'])){
	        	echo "<h3>Profile of user " .$result['username']. "</h1>";
	        	echo "<div id='container'><p>Username : " .$result['username']. "</p><p>Number of Skypoints : ".$result2['skypoints']. "</p><p>Account state : ". $result['class']. "</p></div>";
	        }else{
	        	die("<p class=error>Invalid account ID !</p>");
	        }
	    } catch(Exception $e){
	        die("Error ! " . $e->getMessage());	        	
	    }

	}else{
		echo "<p class=error>Account ID not specified !</p>";
	}
	?>
</body>
</html>