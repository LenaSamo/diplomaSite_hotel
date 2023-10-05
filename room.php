<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/room_.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Номер</title>
</head>
<body>
<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
	?>
	<div class="home">
		
		<?php
		if(!empty($_GET['but_profile']))
		{
			?>
			<form method="get" action="profile.php">
				<?php
				if( !empty($_SESSION['user']['check_in_date']) && !empty($_SESSION['user']['date_departure']))
				{
				?>
					<input type="hidden" name="check_in_date" id="check_in_date" value="<?=$_GET['check_in_date']?>">	
					<input type="hidden" name="date_departure" id="date_departure" value="<?=$_GET['date_departure']?>">
				<?php
				}	
				?>
				<input class="button_back"  type="submit"  value="Назад"/>
			</form>
			<?php
		}
		elseif(!empty($_GET['but_room']))
		{
		?>
		<form method="get" action="rooms.php">
			<?php
			if( !empty($_SESSION['user']['check_in_date']) && !empty($_SESSION['user']['date_departure']))
			{
			?>
				<input type="hidden" name="check_in_date" id="check_in_date" value="<?=$_GET['check_in_date']?>">	
				<input type="hidden" name="date_departure" id="date_departure" value="<?=$_GET['date_departure']?>">
			<?php
			}	
			?>
			<input class="button_back"  type="submit"  value="Назад"/>
		</form>
		<?php	
		}
		else{
		?>
			<!-- <form method="get" action="armor.php">
				<?php
				if( !empty($_GET['check_in_date']) && !empty($_GET['date_departure']))
				{
				?>
					<input type="hidden" name="check_in_date" id="check_in_date" value="<?=$_GET['check_in_date']?>">	
					<input type="hidden" name="date_departure" id="date_departure" value="<?=$_GET['date_departure']?>">
				<?php
				}	
				?>
				<input class="button_back"  type="submit"  value="Назад"/>
			</form> -->
			<input type="button" class="button_back"onclick="history.back();" value="Назад"/>
		<?php	
		}
		?>
		<form method="get" action="armor.php?modal=1" class="conclusion">
		<?php
		$id = $_GET['id_room'];
			if ($result = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = $id")) 
			{
				if ($row = $result->fetch_assoc())
				{
					$room = $row['room'];
					//$id_comfort  = $row['id_comfort '];
					$number_of_guests = $row['number_of_guests'];
					$description = $row['description'];
					$id_comfort  = $row['id_comfort'];
					$selec_comfort = "SELECT * FROM `rooms`, `room_comfort`  WHERE `rooms`.`id` = '$id' AND `room_comfort`.`id` = '$id_comfort'";
					$RES_comfort = $mysqli->query($selec_comfort);
					$ASSOC_comfort = $RES_comfort->fetch_assoc();
					$comfort = $ASSOC_comfort['title_comfort'];
				}
			}
			?>
			<div class="slideshow-container">
			<?php
				if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
				{
					$num = mysqli_num_rows($SELECT_photo);
					if($num > 1)
					{
						?>
						<!-- Full-width images with number and caption text -->
						<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
						<?php
							if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
							{
								
								while($row_photo = $SELECT_photo->fetch_assoc())
								{
									?>
									<div class="mySlides fade">
										<img class="img_room" src="img/<?=$row_photo['photo']?>">
									</div>
									
									<?php
								}
							}
						?>
						
					  
						<!-- Next and previous buttons -->
						
						<a class="next" onclick="plusSlides(1)">&#10095;</a>
					  </div>
					  <br>
					  
					  <!-- The dots/circles -->
					  <div style="text-align:center">
						<?php
							if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
							{
								$num = mysqli_num_rows($SELECT_photo);
								
							}
						for($i = 1; $i <= $num; $i++)
						{
							?>
							<span class="dot" onclick="currentSlide(<?=$i?>)"></span>
							<?php
						}
						
					}
					else
					{
						if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
						{
							
							while($row_photo = $SELECT_photo->fetch_assoc())
							{
								?>
								<div class="mySlides fade">
									<img class="img_room" src="img/<?=$row_photo['photo']?>">
								</div>
								
								<?php
							}
						}
					}
				}
			
			$select_rites = $mysqli->query("SELECT * FROM `room_rates` 
			WHERE `id_comfort` = '$id_comfort'");
			$row_rites = $select_rites->fetch_assoc();
			$price = $row_rites['price'];
			?>
		  </div>



			<div class="info_room"> 
				<div class="descr">
					<H2><?= $room ?></H2>
					<p>Цена за ночь: <?= $price ?> &#8381</p>
					<p>Количество гостей: <?= $number_of_guests ?></p>
					<p>Комфортность: <?=$comfort?></p>
					<p><?=$description?></p>
				</div>
				<div class="service_in_room"> 
					<H2>Услуги в номере:</H2>
					<?php 
					if ($select_set_of_equipment = $mysqli->query("SELECT * FROM `set_of_equipment`, `configuration` 
						WHERE `id_comfort` = '$id_comfort' AND `id_configuration` = `configuration`.`id` ")) 
					{
						while($row_set_of_equipment = $select_set_of_equipment->fetch_assoc())
						{


							?>
							<p><?=$row_set_of_equipment['title_configuration']?></p>
							<?php
						}
					}
					?>
				</div>
			</div>
			<input type="hidden" name="id_room" id="id_room" value="<?=$id?>">
			<?php
			// if( !empty($_GET['check_in_date']) && !empty($_GET['date_departure']))
			// {
			// ?>
			 	<!-- <input type="hidden" name="check_in_date" id="check_in_date" value="<?=$_GET['check_in_date']?>">	
				<input type="hidden" name="date_departure" id="date_departure" value="<?=$_GET['date_departure']?>"> -->
			 <?php
			// }	
			?>
			<input class="button" type="submit" name="button_armor" id="button_armor" value="Бронировать">
			


		</form>


	</div>


	<script>
		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
		showSlides(slideIndex += n);
		}

		function currentSlide(n) {
		showSlides(slideIndex = n);
		}

		function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("dot");
		if (n > slides.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = slides.length}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";  
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		slides[slideIndex-1].style.display = "block";  
		dots[slideIndex-1].className += " active";
		}
		</script>


	<?php
		require_once('footer.php');
	?>

</body>
</html>