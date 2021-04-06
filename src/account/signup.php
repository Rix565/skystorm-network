<?php
    require "libs/base.php";
    require "../libs/db_fun.php";
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

	        			DB_Fun::create_account($_POST['username'], $hashpass);



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