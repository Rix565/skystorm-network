<?php
	if(!empty($_SESSION['nickname']) && !empty($_SESSION['password'])){
		try {
	        $q = $db->prepare("SELECT * FROM `users` WHERE `username` = :username");
	        $q->bindParam(":username", $_SESSION['nickname']);
	        $q->execute();
	        $result = $q->fetch();
	        $q2 = $db->prepare("SELECT * FROM `user_data` WHERE `id` = :id");
	        $q2->bindParam(":id", $result['id']);
	        $q2->execute();
	        $result2 = $q2->fetch();
	    } catch(Exception $e){
	        die("Error ! " . $e->getMessage());	        	
	    }
        echo "<p class='info'>Connected as " .$_SESSION['nickname']. " with " .$result2['skypoints']. " skypoints.</p>";
	    if($result['class']=="admin"){
	        echo '<div id="container"><a href="./"><button>Go to home</button></a><a href="skytalk/"><button>SkyTalk</button></a><a href="admin/"><button>Go to admin panel</button></a><a href="profile/?id=' .$result['id']. '"><button>Your profile</button></a><a href="account/signout.php"><button>Sign out</button></a></div>';
	    }else{
	        echo '<div id="container"><a href="./"><button>Go to home</button><a href="skytalk/"><button>SkyTalk</button></a></a><a href="profile/?id=' .$result['id']. '"><button>Your profile</button></a><a href="account/signout.php"><button>Sign out</button></a></div>';
	    }
    }else{
        echo'<div id="container"><a href="./"><button>Go to home</button></a><a href="skytalk/"><button>SkyTalk</button></a><a href="account/signin.php"><button>Sign in</button></a><a href="account/signup.php"><button>Sign up</button></a></div>';
    }

?>