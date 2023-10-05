<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/service.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Услуги</title>
</head>
<body>
<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
		
	?>
	
	<div class="home">
		<input class="button"  type="button" onclick="location.href='services.php'" value="назад"/>
		<?php
			$id = $_GET['id_service'];
			if ($result = $mysqli->query("SELECT * FROM `services` WHERE `id` = $id")) 
			{
				if ($row = $result->fetch_assoc())
				{
					$title = $row['title'];
					$description = $row['description'];
				}
				
			}
		?>
		<div class="slideshow-container">
		<?php
		if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = $id"))
		{
			$num = mysqli_num_rows($SELECT_photo);
			if($num > 1)
			{
				?>
				<!-- Full-width images with number and caption text -->
				<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
					<?php

						if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = '$id'"))
						{
							
							while($row_photo = $SELECT_photo->fetch_assoc())
							{
								?>
								<div class="mySlides fade">
									<img class="img_service" src="img/<?=$row_photo['photo']?>">
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
					if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = $id"))
					{
						$num = mysqli_num_rows($SELECT_photo);
						
					}
					for($i = 1; $i <= $num; $i++)
					{
						?>
						<span class="dot" onclick="currentSlide(<?=$i?>)"></span>
						<?php
					}
				?>
				<?php
			}
			else{
				if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = '$id'"))
				{
					
					while($row_photo = $SELECT_photo->fetch_assoc())
					{
						?>
						<div class="mySlides fade">
							<img class="img_service" src="img/<?=$row_photo['photo']?>">
						</div>
						
						<?php
					}
				}
			}
		}
		?>
			
		</div>
		<div class="info">
			<H2><?= $title ?></H2> 
			<p><?= $description ?></p>
		</div>
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