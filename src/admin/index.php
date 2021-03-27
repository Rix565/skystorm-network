<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
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
	<p>Add balance</p>
	<div id="container">
		<form method='post'>
			<input type="text" name="id" placeholder="ID" id="id" required/>
			<p>Number of skypoints to add :</p>
			<input type="number" id="balance" name="balance" min="1" max="100" required>
			<button>send request to db</button>
		</form>
		<?php
		if(isset($_POST['id'])){
			if(!empty($_POST['id'])){
				if(isset($_POST['balance'])){
					if(!empty($_POST['balance'])){
						$request = $db->prepare("UPDATE `user_data` SET `skypoints`= `skypoints` + :balance WHERE `id`=:id");
						$request->execute([
							"id" => $_POST['id'],
							"balance" => $_POST['balance']
						]);
						echo '<p class="success">(maybe) succefully added ' .$_POST['balance']. ' skypoints with id ' .$_POST['id'];
					}
				}
			}
		}
		?>
	</div>
	<p>Remove balance</p>
	<div id="container">
		<form method='post'>
			<input type="text" name="id2" placeholder="ID" id="id2" required/>
			<p>Number of skypoints to remove :</p>
			<input type="number" id="balance2" name="balance2" min="1" max="100" required>
			<button>send request to db</button>
		</form>
		<?php
		if(isset($_POST['id2'])){
			if(!empty($_POST['id2'])){
				if(isset($_POST['balance2'])){
					if(!empty($_POST['balance2'])){
						$request = $db->prepare("UPDATE `user_data` SET `skypoints`= `skypoints` - :balance WHERE `id`=:id");
						$request->execute([
							"id" => $_POST['id2'],
							"balance" => $_POST['balance2']
						]);
						echo '<p class="success">(maybe) succefully removed ' .$_POST['balance2']. ' skypoints with id ' .$_POST['id2'];
					}
				}
			}
		}
		?>
	</div>
</body>
</html>