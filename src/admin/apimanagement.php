<?php
require "../libs/connect.php";
require "libs/base.php";
require "libs/id_gen.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
	<h2>API Management</h2>
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
	<p>Create an API Key</p>
	<div id=container>
		<form method="post">
			<button type="submit" name="formsend" id="formsend">Create an API key</button><br>
		</form>
		<?php
		if(isset($_POST['formsend'])){
			$api_key = password_generator(13,1,1);
			$request = $db->prepare("INSERT INTO `api_key`(`api_key`) VALUES (:api_key)");
			$request->execute([
				"api_key" => $api_key,
			]);
			echo '<p class="success">The creation of your API key is finished ! Key : ' .$api_key;
	    }
		?>
	</div>
</body>
</html>