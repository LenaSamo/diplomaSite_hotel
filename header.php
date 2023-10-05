<head>
	<link rel="stylesheet" type="text/css" href="css\header.css">
	
	<script src="https://kit.fontawesome.com/60ec660297.js" crossorigin="anonymous"></script>
</head>
<header class="header">
	<img class="img_header" src="img\лого.png" onclick="location.href='main_page.php'">
	<nav>
		<ul class="menu">
			<a href = "main_page.php">Главная</a>
			<a href = "rooms.php">Номера</a>
			<a href = "services.php">Услуги</a>
			<a href = "contacts.php">Контакты</a>
			<?php
			if (isset($_SESSION["user"]))
			{
				if(($_SESSION["user"]["id_right"] == 3) || ($_SESSION["user"]["id_right"] == 2))
				{
					if($_SESSION["user"]["id_right"] == 3)
					{
					?>
						<a href="user_table.php">Клиенты</a><br>
						<a href="booking_table.php">Бронирования</a><br>
					<?php
					}
					if(($_SESSION["user"]["id_right"] == 2))
					{
					?>   
						<a href="add_rooms.php?rooms_all=Все+номера">Контент</a><br>
					<?php
					}
				}
				if($_SESSION["user"]["id_right"] == 4) 
				{
			?>
			<div>
				<input type="button" onclick="usermyFunction()" class="userdropbtn"></input>
				<div id="userDropdown" class="userdropdown-content">
					<?php
						if(($_SESSION["user"]["id_right"] == 3) || ($_SESSION["user"]["id_right"] == 4))
						{
					?>
							<a href="user_table.php">Клиенты</a><br>
							<a href="booking_table.php">Бронирования</a><br>
					<?php
						}
						if($_SESSION["user"]["id_right"] == 4)
						{
					?>   
							<a href="staff_table.php">Персонал</a><br>
					<?php
						}
						if(($_SESSION["user"]["id_right"] == 2) || ($_SESSION["user"]["id_right"] == 4))
						{
					?>   
							<a href="add_rooms.php?rooms_all=Все+номера">Контент</a><br>
					<?php
						}
					?>
				</div>
			</div>
			<?php
				}
			}
			?>	
		</ul>
	
	</nav>
	<div class="user_">
		<div>
		<?php	
		if ($H2result=$mysqli->query("SELECT * FROM `hotel_information` WHERE `id_users` = 1")) 
		{
			$H2row = $H2result->fetch_assoc();
		?>		
			<p>Администрация: <?=$H2row['phone']?></p>
		<?php
		}	
		?>
		</div>
		<div>
			<input type="button" onclick="myFunction()" class="dropbtn"></input>
			<div id="myDropdown" class="dropdown-content">
				<?php
					if(isset($_SESSION["user"]))
					{
						?>
						<input class="button"  type="button" onclick="location.href='profile.php'" value="Профиль"/><br>
						<input class="button"  type="button" onclick="location.href='logout.php'" value="Выйти"/>
						<?php
					}
					else
					{
				?>
						<a href = "sign_in.php">Войти</a>
				<?php
					}

				?>
			</div>	
		</div>
	</div>
	
</header>
<script>
	/* Когда пользователь нажимает на кнопку,
	переключение между скрытием и отображением раскрывающегося содержимого */
	function myFunction() 
	{
		document.getElementById("myDropdown").classList.toggle("show");
	}
	function usermyFunction() 
	{
		document.getElementById("userDropdown").classList.toggle("showuser");
	}
	// Закройте выпадающее меню, если пользователь щелкает за его пределами
	window.onclick = function(event) 
	{
		if (!event.target.matches('.dropbtn')) 
		{
			var dropdowns = document.getElementsByClassName("dropdown-content");
			for (var i = 0; i < dropdowns.length; i++) 
			{
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) 
				{
					openDropdown.classList.remove('show');
				}
			}
		}

		if (!event.target.matches('.userdropbtn')) 
		{
			var dropdowns = document.getElementsByClassName("userdropdown-content");
			for (var i = 0; i < dropdowns.length; i++) 
			{
				var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('showuser')) 
				{
					openDropdown.classList.remove('showuser');
				}
			}
		}
	}
	

	
</script>	
