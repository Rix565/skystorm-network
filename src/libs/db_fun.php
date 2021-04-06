<?php

class DB_Fun
{
	function create_account($username, $password){
		require "../libs/connect.php";
		try{			
			$q = $db->prepare('INSERT INTO `users`(`username`, `password`, `class`) VALUES (:username, :password, "member")');
			$q->bindParam(":username", $username);
			$q->bindParam(":password", $password);
			$q->execute();
			$q = $db->prepare('INSERT INTO `user_data`(`skypoints`) VALUES (0)');
			$q->execute();
			echo "<p class=success>Created account !</p>";
			$_SESSION['nickname'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
			header("Location: ../");
		} catch (PDOException $e) {
			echo "<p class='error'>Username already used !</p>";
		}
	}
	function login($username, $password){
		require "../libs/connect.php";
		try {
	        $q = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
	        $q->bindParam(":username", $username);
	        $q->execute();
	        $result = $q->fetch();
	    } catch(Exception $e){
	        die("Error ! " . $e->getMessage());	        	
	    }
	    if($result==true){
	        if(password_verify($password, $result['password'])){
	            if($result['class']=="banned"){
	        		die("<p class=error>You're banned !</p>");
	        	}
	        	$_SESSION['nickname'] = $username;
	        	$_SESSION['password'] = $password;

	        	echo "<p class=success>Connected succefully !</p>";

	        	header("Location: ../");
	        			
	        }else{
	            echo "<p class=error>Incorrect nickname/password.</p>";
	        }
	    }else{
	        echo "<p class=error>Incorrect nickname/password.</p>";
	    }
	}
}
?>