<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\content.css">
	<link rel="stylesheet" type="text/css" href="css\table.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Редактирование контента</title>
</head>
<body>
	<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
	?>

	<form  method="post">
		<div class="contents">
			<input class="con_input" type="submit" name="services_provided" value="Предоставляемые услуги">
			<input class="con_input" type="submit" name="hotel_information" value="Информация отеля">
			<input class="con_input" type="submit" name="rooms" id="rooms" value="Работа с номерами">
			<input class="con_input" type="submit" name="room_comfort_categories" value="Цены по комфортности на номера">
		</div>    
	</form>  
	<?php

	if(!empty($_POST['hotel_information']))
	{
		$new_url = 'hotel_information.php';
		header('Location: '.$new_url);
	}
	
	if(!empty($_POST['services_provided']))
	{
		$new_url = 'services_provided.php';
		header('Location: '.$new_url);
	}
	
	if(!empty($_POST['room_comfort_categories']) )
	{
		$new_url = 'comfort_rites.php';
		header('Location: '.$new_url);
	}
	if(!empty($_POST['rooms']))
	{

		$new_url = 'add_rooms.php';
		header('Location: '.$new_url);
	}


		require_once('footer.php');
	?>
	<script src="js/jquery-3.6.4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#rooms")[0].click();
			// $("#rooms_all")[0].click();

		});  
	</script>
</body>
</html>