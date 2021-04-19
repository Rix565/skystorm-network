<?php
require "libs/base.php";
require "../libs/connect.php";
?>
<html>
<body>
<h1>Skystorm Network</h1>
<h3>Notifications</h1>
<?php
require "../libs/connectinfo_folder.php";
if(empty($_SESSION['nickname'])){
    header("Location: not_logged.html");
}
$q = $db->prepare('SELECT * FROM notifications WHERE `to_user` = :user');
$q->execute([
    "user" => $_SESSION['nickname']
]);
while ($notifs = $q->fetch()) {
    echo "<p>You have a new notification ! ". $notifs['content'] ."</p>";
}
?>
</body>
</html>