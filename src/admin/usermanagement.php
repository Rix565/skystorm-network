<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
	<h2>User management</h2>
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
	<p>Ban a user</p>
	<div id="container">
		<form method="post">
			<input type="text" name="author" id="author" placeholder="User" required/>
			<button type="submit" name="formsend" id="formsend">Ban user</button><br>
		</form>
		<?php
		if(isset($_POST['formsend'])){
			try{
				$q = $db->prepare("UPDATE `users` SET `class`='banned' WHERE `username`=:author");
				$q->execute([
					"author" => $_POST['author']
				]);
			} catch(Exception $e){
				die("Error !" . $e->getMessage());
			}
			echo "<p class=success>User ". $_POST['author']. " has been banned.</p>";
		}
		?>
	</div>
	<p>___________________________________________________</p>
	<p>Unban a user</p>
	<div id="container">
		<form method="post">
			<input type="text" name="author2" id="author2" placeholder="User" required/>
			<button type="submit" name="formsend2" id="formsend2">Unban user</button><br>
		</form>
		<?php
		if(isset($_POST['formsend2'])){
			try{
				$q = $db->prepare("UPDATE `users` SET `class`='member' WHERE `username`=:author");
				$q->execute([
					"author" => $_POST['author2']
				]);
			} catch(Exception $e){
				die("Error !" . $e->getMessage());
			}
			echo "<p class=success>User ". $_POST['author2']. " has been unbanned.</p>";
		}
		?>
	</div>
</body>
</html>