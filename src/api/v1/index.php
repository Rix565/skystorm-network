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