<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<!DOCTYPE html>
<html>
<body>
	<h1>Skystorm Network</h1>
	<h2>SkyTalk</h2>
	<?php
	    require "../libs/connectinfo_folder.php";
        $q = $db->prepare('SELECT * FROM skytalk_posts');
        $q->execute();
        try {
	        $q2 = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
	        $q2->bindParam(":username", $_SESSION['nickname']);
	        $q2->execute();
	        $result = $q2->fetch();
	    } catch(Exception $e){
	        die("Error ! " . $e->getMessage());	        	
	    }
        while ($posts = $q->fetch()) {
        	error_reporting(E_ALL ^ E_NOTICE);
        	if($result['class']=="admin"){
        		echo "<p>" .$posts['author']. " posted (id : " .$posts['id']. ") :</p><p>" .$posts['content']. "</p>";
        	}else{
        		echo "<p>" .$posts['author']. " posted :</p><p>" .$posts['content']. "</p>";
        	}
        }
        if(!empty($_SESSION['nickname']) && !empty($_SESSION['password'])){
            echo '<div id="container"><form method=post><input type="text" name="contentpost" placeholder="Content of post" required /><button type="submit" name="submitpost">Post</button></form></div>';
            if(isset($_POST['submitpost'])){
                $post = $db->prepare("INSERT INTO `skytalk_posts`(`author`, `content`) VALUES (:author, :content)");
                $post->execute([
                	"author" => $_SESSION['nickname'],
                	"content" => $_POST['contentpost']
                ]);
                header('Location: ./');
            }
        }
    ?>
</body>