<?php
require "libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Welcome to Skystorm Network !</h1>
	<?php
		if(!empty($_SESSION['nickname']) && !empty($_SESSION['password'])){
            echo "<p class='info'>Connected as " .$_SESSION['nickname']. "</p>";
            try {
	        	$q = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
	        	$q->bindParam(":username", $_SESSION['nickname']);
	        	$q->execute();
	        	$result = $q->fetch();
	        } catch(Exception $e){
	        	die("Error ! " . $e->getMessage());	        	
	        }
	        if($result['class']=="admin"){
	        	echo '<div id="container"><a href="admin/"><button>Go to admin panel</button></a><a href="account/signout.php"><button>Sign out</button></a></div>';
	        }else{
	        	echo '<div id="container"><a href="account/signout.php"><button>Sign out</button></a></div>';
	        }
        }else{
            echo'<div id="container"><a href="account/signin.php"><button>Sign in</button></a><a href="account/signup.php"><button>Sign up</button></a></div>';
        }
    ?>
    <p>Skystorm Network is a in-developpement network by a random developer...</p>
</body>
</html>