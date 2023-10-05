<?php
	require_once('connect.php');
	session_start();

    $email = $_SESSION['user']['email'];

	$token = bin2hex(random_bytes(20));
	$mysqli->query( "UPDATE `users` SET `token` = '$token' WHERE `email` = '$email'");
	session_destroy();

	header ('Location: main_page.php');
	
?>