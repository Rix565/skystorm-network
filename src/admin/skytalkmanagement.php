<?php
require "libs/base.php";
require "../libs/connect.php";
?>
</!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network - Admin panel</h1>
	<h2>SkyTalk Management</h2>
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
	<p>Clear ALL the posts of SkyTalk</p>
	<div id="container">
		<form method="post">
			<button type="submit" name="formsend" id="formsend">Clear ALL the posts of SkyTalk</button><br/>
		</form>
		<?php
		if(isset($_POST['formsend'])){
	        try {
	        	$q = $db->prepare("DELETE FROM `skytalk_posts`");
	        	$q->execute();
	        } catch(Exception $e){
	        	die("Error ! " . $e->getMessage());	        	
	        }
	        echo "<p class=error>ALL POSTS DELETED.</p>";
	    }
		?>
	</div>
</body>
</html>