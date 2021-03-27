<?php
    require "../libs/connect.php";
    require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>
		Sign In - Skystorm Network
	</h1>
	<div id="container">
		<form method="post">
			<input type="text" name="username" placeholder="Nickname" required /><br/>
			<input type="password" name="password" placeholder="Password" required /><br/>
			<button type="submit" name="formsend" id="formsend">Connect</button><br/>
	    </form>
	    <?php
	        if(isset($_POST['formsend'])){
	        	try {
	        		$q = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
	        		$q->bindParam(":username", $_POST['username']);
	        		$q->execute();
	        		$result = $q->fetch();
	        	} catch(Exception $e){
	        		die("Error ! " . $e->getMessage());	        	
	        	}
	        	if($result==true){
	        		if(password_verify($_POST['password'], $result['password'])){
	        			$_SESSION['nickname'] = $_POST['username'];
	        			$_SESSION['password'] = $_POST['password'];

	        			echo "<p class=success>Connected succefully !</p>";

	        			header("Location: ../");
	        			
	        		}else{
	        			echo "<p class=error>Incorrect nickname/password.</p>";
	        		}
	        	}else{
	        		echo "<p class=error>Incorrect nickname/password.</p>";
	        	}
	        }
	    ?>
	</div>
</body>
</html>