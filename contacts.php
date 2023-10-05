<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\contacts.css">
	<link rel="stylesheet" type="text/css" href="css\home.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Контакты</title>
</head>
<body>
	<?php
		session_start();
		require_once('connect.php');
		require_once('header.php');
	?>

	<div class="home">
		<h1>Контакты</h1>
	</div>
	<div class="info">
		<?php
		if ($H2result=$mysqli->query("SELECT * FROM `hotel_information` WHERE `id_users` = 1")) 
		{
			$H2row = $H2result->fetch_assoc();
		?>	
		<div class="con_inf">	
			<h2>Контакты отеля</h2>
			<p>Телефон администрации: <?=$H2row['phone']?></p>
			<p>Почта: <?=$H2row['email']?></p>
			<p>Адрес: <?=$H2row['address']?></p>
		</div>
		<?php
		}	
		?>
		<div class="carts">
			<script  type="text/javascript" charset="utf-8" async 
				src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A3324724315ce08e3251c606bfec9364924949e1ac8492e3fafc131c90e099f69&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true">
			</script>
		</div>
	</div>
	<?php
	require_once('footer.php');
	?>
</body>
</html>