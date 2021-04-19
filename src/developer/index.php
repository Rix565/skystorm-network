<?php
require "../libs/connect.php";
require "libs/base.php";
?>
<html>
<body>
<h1>Skystorm Network</h1>
<h3>Developer</h3>
<?php
	require "../libs/connectinfo_folder.php";
	if(empty($_SESSION['nickname'])){
		header("Location: not_logged.html");
	}
?>
<div id=container>
    <p>Skystorm Network Developer is a service with you can get an api key to get access to the API.</p>
    <p>But for that, you need to send a request to get an API key, and you can make your request here.</p>
    <form method="post">
        <p>Send a request to get access to the API</p>
        <input type="text" name="contentpost" placeholder="Why do you want to get access to the API" required />
        <button type="submit" name="submitpost">Send</button>
        <?php
        if(isset($_POST['submitpost'])){
            $request = $db->prepare("INSERT INTO `api_request`(`author`, `requestcontent`) VALUES (:username, :content)");
            $request->execute([
                "username" => $_SESSION['nickname'],
                "content" => $_POST['contentpost']
            ]);
            echo "<p class=success>Sended succefully your request !</p>";
        }
        ?>
    </form>
</div>
</body>
</html>