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
        while ($posts = $q->fetch()) {
            echo "<p>" .$posts['author']. " posted :</p><p>" .$posts['content']. "</p>";
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