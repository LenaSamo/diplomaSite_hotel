<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\mainCss.css">
	<link rel="stylesheet" type="text/css" href="css\rooms.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">

	<title>Главная страница</title>
</head>
<body>
	<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
		$error_output=false;
	?>
	<div class="home">
		<?php
			if ($H2result=$mysqli->query("SELECT * FROM `hotel_information` WHERE `id_users` = 1 AND `id`=1")) 
			{
				$H2row = $H2result->fetch_assoc();
				$nameSite = $H2row['nameSite'];
				echo "<h2>$nameSite</h2>";
				$information = $H2row['information'];
				echo "<p>$information</p>";

			}
			
		?>

	</div>
	<h1 class="h2">Наши номера</h1>
	<div class="rooms">
		
	<?php
		$res = "SELECT `rooms`.`id`, room, id_comfort, number_of_guests  
		FROM `rooms`, `rooms_in_the_booking` WHERE `id_room` = `rooms`.`id` ORDER BY `id_room` ASC ";
		if ($result = $mysqli->query($res)) 
		{
			
			$array = array();
			$i = 0;
			$num = 0;
			while($row = $result->fetch_assoc())
			{
				$array[] = $row['id'];
			}
			if(count($array) != 0)
			{
				$res = "SELECT * FROM `rooms` WHERE `id` = '$array[0]'";
				for ($i = 1; $i < count($array); $i++)
				{
					if ($array[$i] != $array[$i-1] && $num < 2)
					{
						$num++;
						$res .= " OR `id` = '$array[$i]'";
					}
					
				}
			}
			else{
				$res = "";
			}
			
		}
		if ($result = $mysqli->query($res)) 
		{
			while($row = $result->fetch_assoc())
			{
				
				$id = $row['id'];
				$room = $row['room'];
				$id_comfort  = $row['id_comfort'];
				$number_of_guests = $row['number_of_guests'];

				$selec_comfort = "SELECT * FROM `rooms`, `room_comfort`  WHERE `rooms`.`id` = '$id' AND `room_comfort`.`id` = '$id_comfort'";
				$RES_comfort = $mysqli->query($selec_comfort);
				$ASSOC_comfort = $RES_comfort->fetch_assoc();
				$comfort = $ASSOC_comfort['title_comfort'];

				$nowDate = Date("Y-m-d");
				$selec_prise = "SELECT * FROM `rooms`, `room_rates`  
							WHERE `rooms`.`id` = '$id' 
							AND `room_rates`.`id_comfort` = '$id_comfort' 
							AND `price_date` <= '$nowDate'
							ORDER BY `room_rates`.`id` DESC LIMIT 1";
				$RES_prise = $mysqli->query($selec_prise);
				$ASSOC_prise = $RES_prise->fetch_assoc();
				// echo $selec_prise;
				$prise = $ASSOC_prise['price'];

			?>
				<form  method="get" action="room.php">
					<div class="room">
					<?php
						if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
							{
								$row_photo = $SELECT_photo->fetch_assoc();
									?>
									<img class="img_room" src="img/<?=$row_photo['photo']?>" height="500px">
									<?php
							}
					?>
						<div class="room_inform">
							<h2><?=$room?></h2>
							<p>
								Комфортность: <?=$comfort?><br>
								Количество человек: <?=$number_of_guests?>
							</p>
							<input type="hidden" name="id_room" id="id_room" value="<?=$row['id']?>">						
							<div class="sub_prise">  
								<p>Цена - <?=$prise?>&#8381</p>			
								<input class="button" type="submit" name="button_room" id="button_room" value="Подробнее">
							</div>
						</div>
					</div>
				</form>
				<?php		
				}
			}
		?>
	</div>			
	<div class="armor">
		
		<input class="button"  type="button" onclick="location.href='rooms.php?modal=1'" value="Бронировать номер"/>
	</div>
	<div class="info">
		<div>
		<?php
			if ($result = $mysqli->query("SELECT `img` FROM `hotel_information` WHERE `id` = 1 ")) 
			{
				if($row = $result->fetch_assoc())
				{
					?>
					<img class="img" src="img/<?=$row['img']?>" height="500px">
					<?php
				}
			}
		?>
		</div>
		<div>
		<?php
			if ($H2result=$mysqli->query("SELECT * FROM `hotel_information` WHERE `id_users` = 1 ")) 
			{
				while($H2row = $H2result->fetch_assoc())
				{
					$info_hotel = $H2row['info_hotel'];
					echo "<p style='text-indent: 25px;'>$info_hotel</p>";
				}
			}
		?>
		</div>
	</div>
	
	<?php
		require_once('footer.php');
	?>
</body>
</html>