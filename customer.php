<?php 

	include 'core/init.php';
	$user_id = $_SESSION['user_id'];
	$user = $getFromU->userData($user_id);
	
	if($getFromU->loggedIn() === false) {
		header('Location: index.php');
	}


?>