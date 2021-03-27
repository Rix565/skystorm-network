<?php
    require "../libs/connect.php";
    require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>
		Sign Up - Skystorm Network
	</h1>
	<div id="container">
    <form method="post">
			<input type="text" name="username" placeholder="Username" required /><br/>
			<input type="password" name="password" placeholder="Password" required /><br/>
			<input type="password" name="cpassword" placeholder="Confirm Password" required /><br/>
			<button type="submit" name="formsend" id="formsend">Sign Up</button><br/>
			<p class="info">Info : your password is securised by an encryption algorithm.</p>
	    </form>
	    <?php
	        if(isset($_POST['formsend'])){
	        	if(!empty($_POST['username']) && !empty($_POST['cpassword']) && !empty($_POST['password'])){
	        		if($_POST['password'] == $_POST['cpassword']){

	        			$options = [
	        				"cost" => 12,
	        			];

	        			$hashpass = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
	        			try{
	        				$q = $db->prepare('INSERT INTO `users`(`username`, `password`, `class`) VALUES (:username, :password, "member")');
	        				$q->bindParam(":username", $_POST['username']);
	        				$q->bindParam(":password", $hashpass);
	        				$q->execute();
	        				$q = $db->prepare('INSERT INTO `user_data`(`skypoints`) VALUES (0)');
	        				$q->execute();
	        				echo "<p class=success>Created account !</p>";
	        				$_SESSION['nickname'] = $_POST['username'];
	        				$_SESSION['password'] = $_POST['password'];
	        				header("Location: ../");
	        			} catch (PDOException $e) {
	        				echo "<p class='error'>Username already used !</p>";
	        			}
	        		}else{
	        			echo "<p class=error>The passwords don't match !</p>";
	        			exit();
	        		}
	        	}else{
	        		echo "<p class='error'>Requied fields empty !</p>";
	        		exit();
	        	}
	        }
	    ?>
	</div>
</body>
</html>