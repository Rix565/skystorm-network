<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network</h1>
	<h3>Shop</h3>
	<?php
		require "../libs/connectinfo_folder.php";
		if(empty($_SESSION['nickname'])){
			header("Location: not_logged.html");
		}
    ?>
    <div id="container">
    	<p>Test - 10 Skypoints</p>
    	<form method="post">
    		<button type="submit" name="formsend" id="formsend">Buy</button><br>
    	</form>
    	<?php
    	if(isset($_POST['formsend'])){
    		$request = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
			$request->execute([
				"username" => $_SESSION['nickname']
			]);
			$result = $request->fetch();
			$request2 = $db->prepare("SELECT * FROM `user_data` WHERE `id`=:id");
			$request2->execute([
				"id" => $result['id'],
			]);
			$result2 = $request2->fetch();
			if($result2['skypoints'] >= 10){
			}else{
				die('<p class="error">Not enough Skypoints !</p>');
			}
			$request3 = $db->prepare("UPDATE `user_data` SET `skypoints`= `skypoints` - :balance WHERE `id`=:id");
			$request3->execute([
				"id" => $result['id'],
				"balance" => 10
			]);
			echo '<p class="success">You have succefully buyed Test !</p>';
    	}
    	?>
    </div>
</body>
</html>