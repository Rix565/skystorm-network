<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
	<h2>Balance Management System</h2>
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
	<p>Add balance</p>
	<div id="container">
		<form method='post'>
			<input type="text" name="username" placeholder="Username" id="username" required/>
			<p>Number of skypoints to add :</p>
			<input type="number" id="balance" name="balance" min="1" required>
			<button>send request to db</button>
		</form>
		<?php
		if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['balance']) && !empty($_POST['balance'])){
			$request = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
			$request->execute([
				"username" => $_POST['username']
			]);
			$result2 = $request->fetch();
			$request2 = $db->prepare("UPDATE `user_data` SET `skypoints`= `skypoints` + :balance WHERE `id`=:id");
			$request2->execute([
				"id" => $result['id'],
				"balance" => $_POST['balance']
			]);
			echo '<p class="success">(maybe) succefully added ' .$_POST['balance']. ' skypoints with user ' .$_POST['username'];
		}
		?>
	</div>
	<p>___________________________________________________</p>
	<p>Remove balance</p>
	<div id="container">
		<form method='post'>
			<input type="text" name="username2" placeholder="Username" id="username2" required/>
			<p>Number of skypoints to remove :</p>
			<input type="number" id="balance2" name="balance2" min="1" required>
			<button>send request to db</button>
		</form>
		<?php
		if(isset($_POST['username2']) && !empty($_POST['username2']) && isset($_POST['balance2']) && !empty($_POST['balance2'])){
			$request2 = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
			$request2->execute([
				"username" => $_POST['username2']
			]);
			$result3 = $request2->fetch();
			$request3 = $db->prepare("UPDATE `user_data` SET `skypoints`= `skypoints` - :balance WHERE `id`=:id");
			$request3->execute([
				"id" => $result3['id'],
				"balance" => $_POST['balance2']
			]);
			echo '<p class="success">(maybe) succefully removed ' .$_POST['balance2']. ' skypoints with user ' .$_POST['username2'];
		}
		?>
	</div>
</body>
</html>