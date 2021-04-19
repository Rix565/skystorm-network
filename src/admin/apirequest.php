<?php
require "../libs/connect.php";
require "libs/base.php";
require "libs/id_gen.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
	<h2>API requests</h2>
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
		<a href="./">
			<button>Go to the home of the admin panel</button>
		</a>
	</div>
    <p>___________________________________________________</p>
	<?php
	$q = $db->prepare('SELECT * FROM api_request WHERE `accepted` = "no"');
	$q->execute();
	$var = 0;
	while ($apirequets = $q->fetch()) {
		$var += 1;
		echo "<div id=container><p>API Request by ". $apirequets['author']. ", why : ". $apirequets['requestcontent'] ."</p><form method=post><button type='submit' name='".$var."'>Accept</button><button type='submit' name='".$var. "decline'>Decline</button></form></div>";
		if(isset($_POST[$var])){
			$q2 = $db->prepare("UPDATE `api_request` SET `accepted`='yes' WHERE `id`=:id");
			$q2->execute([
				'id' => $apirequets['id']
			]);
			$api_key = password_generator(13,1,1);
			$q3 = $db->prepare("INSERT INTO `api_key`(`api_key`) VALUES (:api_key)");
			$q3->execute([
				"api_key" => $api_key,
			]);
			$q4 = $db->prepare("INSERT INTO `notifications`(`to_user`, `content`) VALUES (:user, 'Your api request has been accepted, there is your api key : ". $api_key ."')");
			$q4->execute([
				"user" => $apirequets['author']
			]);
			echo "<p class=success>Succefully accepted api request.</p>";
		}else if(isset($_POST[$var . "decline"])){
			$q5 = $db->prepare("UPDATE `api_request` SET `accepted`='declined' WHERE `id`=:id");
			$q5->execute([
				'id' => $apirequets['id']
			]);
			$q6 = $db->prepare("INSERT INTO `notifications`(`to_user`, `content`) VALUES (:user, 'Your api request has been declined')");
			$q6->execute([
				"user" => $apirequets['author']
			]);
			echo "<p class=error>Succefully declined api request.</p>";
		}
	}
	?>
</body>
</html>