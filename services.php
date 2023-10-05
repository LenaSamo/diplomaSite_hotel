<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\home.css">
	<link rel="stylesheet" type="text/css" href="css\servicesCss.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Услуги</title>
</head>
<body>
	<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
		$error_output=false;
	?>
	<div class="home">
		<h1>Услуги</h1>
		<?php
			if ($result = $mysqli->query("SELECT * FROM `services` ORDER BY `id` DESC")) 
			{
				while($row = $result->fetch_assoc())
				{
					$id =  $row['id'];
					$title = $row['title'];
					$description = $row['description'];
					
				?>
				<form  method="get" action="service.php" class="services">
					<div class="service">
						<div class="img">
						<?php
						
						if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = $id "))
						{
							$row_photo = $SELECT_photo->fetch_assoc()
						
							?>
							<img class="img_service" src="img/<?=$row_photo['photo']?>" height="200px">
							<?php
							
						}
						?>
						</div>
						<div class="info">
							<h2><?=$title?></h2>
							<!-- <p><?=$description?></p> -->
							<input type="hidden" name="id_service" id="id_service" value="<?=$row['id']?>">
							<input class="button" type="submit" name="button_room" id="button_room" value="Подробнее">
						</div>
					</div>
				</form>
				<?php
				}
			}
		?>
	</div>
	<?php
		require_once('footer.php');
	?>
</body>
</html>