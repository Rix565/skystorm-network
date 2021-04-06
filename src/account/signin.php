<?php
    require "libs/base.php";
    require "../libs/db_fun.php";
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
	        	DB_Fun::login($_POST['username'], $_POST['password']);
	        }
	    ?>
	</div>
</body>
</html>