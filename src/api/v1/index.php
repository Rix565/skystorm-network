<?php
require "../../libs/connect.php";

header('Content-Type: application/json');

if(!empty($_GET['api_key'])){
	try {
	    $q = $db->prepare("SELECT * FROM `api_key` WHERE `api_key` = :api_key");
	    $q->bindParam(":api_key", $_GET['api_key']);
	    $q->execute();
	    $result = $q->fetch();
	} catch(Exception $e){
	    die("Error ! " . $e->getMessage());	        	
	}
	if($result==true){
		if(!empty($_GET['service'])){
			if($_GET['service']=="skytalk"){
				$request = $db->prepare("SELECT * FROM `skytalk_posts`");
				$request->execute();
				$send["success"] = true;
				$send["message"] = "Data recevied";
				$send['data'] = $request->fetchAll();
				echo json_encode($send);
			}else if($_GET['service']=="profile"){
				if(!empty($_GET['userid'])){
					try {
						$q2 = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
						$q2->bindParam(":id", $_GET['userid']);
						$q2->execute();
						$result2 = $q2->fetch();
						$q3 = $db->prepare("SELECT * FROM `user_data` WHERE `id`=:id");
						$q3->execute([
							"id" => $result2['id']
						]);
						$result3 = $q3->fetch();
					} catch(Exception $e){
						die("Error ! " . $e->getMessage());	        	
					}
					if($result2==true){
						$send["success"] = true;
						$send["message"] = "Data recevied";
						$send['data']['username'] = $result2['username'];
						$send['data']['skypoints'] = $result3['skypoints'];
						$send['data']['class'] = $result2['class'];
						$send['data']['created_date'] = $result2['created_date'];
						$send['data']['id'] = $result2['id'];
						echo json_encode($send);
					}else{
						$send["success"] = false;
						$send["message"] = "Invalid user id !";
						echo json_encode($send);
					}
				}else{
					$send["success"] = false;
					$send["message"] = "Specify user id !";
					echo json_encode($send);
				}
			}else{
				$send["success"] = false;
				$send["message"] = "Unknown service !";
				echo json_encode($send);
			}
		}else{
			$send["success"] = false;
			$send["message"] = "Specify the service you want to use !";
			echo json_encode($send);
		}
	}else{
		$send["success"] = false;
		$send["message"] = "Invalid api key !";
		echo json_encode($send);
	}
}else{
	$send["success"] = false;
	$send["message"] = "Specify the api key !";
	echo json_encode($send);
}
?>