<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\home.css">
	<link rel="stylesheet" type="text/css" href="css\rooms.css">
	
	<link rel="stylesheet" href="css/modal.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Номера</title>
</head>
<body>
	<?php
		session_start();
		require_once('connect.php');
		require_once('header.php');
	?>
	<div class="home">
		 <?php
		if(!empty($_GET['user_id']))
		{
			?>
			<h1>Выбор номеров для бронирования</h1>
			<p id="p_user">Клиент</p>
			<input type="hidden" name="user" id="user" value="<?=$_GET['user_id']?>" readonly="readonly">
			<?php
			$user_id = $_GET['user_id'];
			$select_room = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
			$row_room = $select_room->fetch_assoc();
			?>
			<input type="text" name="name_user" id="name_user" value="<?=$row_room['surname']?> <?=$row_room['name']?> <?=$row_room['patronymic']?>" readonly="readonly">
                    
		<?php
		}
		else{
			?>
			<h1>Номера</h1>
			<?php
		}


		if(!empty($_GET['modal']))
		{
			if($_GET['modal'] == 1)
			{
				?>
				<div id="myModal" class="modal">
					<!-- Modal content -->
					<div class="modal-content">
						<div class="modal-header">
							<span class="close">×</span>
							<h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
						</div>
							<div class="modal-body">
								<p>Для бронирования введите дату заселения и дату выезда</p>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					// Get the modal
					var modal = document.getElementById('myModal');

					// Get the <span> element that closes the modal
					var span = document.getElementsByClassName("close")[0];

					// When the user clicks the button, open the modal 
					modal.style.display = "block";

					// When the user clicks on <span> (x), close the modal
					span.onclick = function() {
						modal.style.display = "none";
						window.location.href = 'rooms.php';
					}

					function myImg() {
						modal.style.display = "none";
						window.location.href = 'rooms.php';
					}
					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
						if (event.target == modal) {
							modal.style.display = "none";
							window.location.href = 'rooms.php';
						}
					}
					if($('#myModal').css('display') !== 'none')
					{
						document.getElementById('#hidden_el').value = 1;
					}
				</script>
				<?php
			}
		}

		?> 
		
		<div class="room_menu">
			
			<form method="post">
				<?php
					$nowDate = Date("Y-m-d");
					$query = '+ 1 days';
					$date_departure = date("Y-m-d", strtotime($nowDate.$query));
				?>
				
				<label for="check_in_date">Дата заселения</label>
				<input type="date" name="check_in_date" id="check_in_date" min="<?=$nowDate?>"
					value="<?php if (!empty($_POST['check_in_date'])) 
								{
									echo $_POST['check_in_date'];
								}
							?>">

				<label for="date_departure">Дата выезда</label>
				<input type="date" name="date_departure" id="date_departure" min="<?=$date_departure?>"
					value="<?php if (!empty($_POST['date_departure'])) 
								{
									echo $_POST['date_departure'];
								}
							?>"><br><br>

				<label for="comfort">Комфортность</label>
				<div class="checkselect" id="comfort">
					<?php
					if ($SELECT_max_id_comfort  = $mysqli->query("SELECT * FROM `room_comfort`  ")) 
					{
						while($row = $SELECT_max_id_comfort->fetch_assoc())
						{
							
							$comfort = $row['title_comfort'];  
						?>
						<label>
							<input type="checkbox" name="comfort[]" id="<?=$row['id']?>" value="<?=$row['id']?>">
							<?=$comfort?>
						</label>
						<?php
						}
					}
					?>
				</div>
				
				<br>
				<label for="kol_room">Выбирите количество номеров для бронирования</label>
					<select name="kol_room" id="kol_room" >
						<option value="1" <?php if (!empty($_POST['kol_room']) && $_POST['kol_room'] == "1")
																{echo "selected='selected'";} ?>> 
							1
						</option>
					<?php
					for ($i = 2; $i <= 5; $i++)
					{               	
					?>
						<option value="<?php echo $i;?>" <?php if (!empty($_POST['kol_room']) && $_POST['kol_room'] == $i)
																{echo "selected='selected'";} ?>>
							<?php echo $i;?>
						</option>
					<?php 
					}
					?>
					</select>
					<input type="submit" class="add_room" value="Выбрать" name="add_room_select"><br>
					<?php
					
					if(!empty($_POST['kol_room']))
					{
						
						$kol_room = $_POST['kol_room'];
						if ($kol_room > 1)
						{
							for ($j = 1; $j < $kol_room; $j++)
							{
								if(!empty($_POST["number_of_guests".$j]) && !empty($_POST["number_of_guests".$j+1]))
								{
									if($_POST["number_of_guests".$j] >= $_POST["number_of_guests".$j+1])
									{
										$number_of_guests = $_POST["number_of_guests".$j];
									}
									else{
										$number_of_guests = $_POST["number_of_guests".$j+1];
									}
								}
							}
						}
						elseif ($kol_room == 1){
							if(!empty($_POST["number_of_guests1"]))
							{
								$number_of_guests = $_POST["number_of_guests1"];
							}
							
						}
						for ($j = 1; $j <= $kol_room; $j++)
						{
						?>
							<p>Номер <?=$j?></p>
							<label for="number_of_guests<?=$j?>">Выберите количество гостей</label>		
							<select class="number_of_guests" name="number_of_guests<?=$j?>" id="number_of_guests<?=$j?>">
								<option value="net" <?php if (!empty($_POST["number_of_guests".$j]) && $_POST["number_of_guests".$j] == 'net')
															{echo "selected='selected'";} ?>>
									-
								</option>
								<?php 
								$sql = "SELECT  MAX(number_of_guests) AS max_guests FROM `rooms`";
								if ($SELECT_max_quests_rooms = $mysqli->query($sql)) 
								{
									if($row = $SELECT_max_quests_rooms->fetch_assoc())
									{
										for ($i = 1; $i <= $row['max_guests']; $i++)
										{
								?>
											<option value="<?php echo $i;?>" <?php if (!empty($_POST["number_of_guests".$j]) && $_POST["number_of_guests".$j] == $i)
																					{echo "selected='selected'";} ?>>
												<?php echo $i;?>
											</option>
								<?php 
										}    	
									}   	
								}
								?>
							</select><br><br>
						<?php
						}
						
					}
					?>
					<input type="submit" class="button" value="Поиск" name="search">
					<input class="button"  type="button" onclick="location.href='rooms.php'" value="Отменить сортировку"/>
			</form>
		</div>
		
		<div class="armor_hidden" id="armor_hidden">		
			<form  method="get" action="armor.php" id='res_id_rooms'>
				<?php
				if(!empty($_GET['user_id']))
				{
					?>
					<input type="hidden" name="user" id="user" value="<?=$_GET['user_id']?>" readonly><br>
				<?php
				}
				?>
				<input type="hidden" name="kol_room" id="kol_room" value="<?=$kol_room?>">		
				<input type="hidden" name="check_in_date" id="check_in_date" value="<?=$_POST['check_in_date']?>">	
				<input type="hidden" name="date_departure" id="date_departure" value="<?=$_POST['date_departure']?>">
				<input class="button_armor_hidden" type="submit" name="button_room_armor" id="button_room_armor" value="Бронировать">
			</form>
		</div>
			<div class="rooms">
			<?php
			$res = "SELECT * FROM `rooms`";
			if (!empty($_POST['search']) || !empty($_POST['add_room_select']))
			{
				require_once('sorting_numbers.php');
			}
			if (!empty($res))
			{
				if ($result = $mysqli->query($res)) 
				{
					
					$array = array();
					$i = 0;
					while($row = $result->fetch_assoc())
					{
						$array[] = $row['id'];
					}
					if(count($array) != 0)
					{
						$res = "SELECT * FROM `rooms` WHERE `id` = '$array[0]'";
						for ($i = 1; $i < count($array); $i++)
						{
							if ($array[$i] != $array[$i-1])
							{
								$res .= " OR `id` = '$array[$i]'";
							}
								
						}
					}
					else{
						$res = "";
					}
					
				}
				if($res == "")
				{
					?>
					<p>Ничего не найдено</p>
					<?php
				}
				elseif ($res_query = $mysqli->query($res)) 
				{
					$row_kol = mysqli_num_rows($res_query);
					$row_room = 1;
					while($row_res = $res_query->fetch_assoc())
					{
						if(!empty($_POST['check_in_date']) && !empty($_POST['date_departure']))
						{
							$check_in_date = $_POST['check_in_date'];
							$date_departure = $_POST['date_departure'];
							$id_room = $row_res['id'];
							$res2 = "SELECT `rooms`.`id`
								FROM `rooms`, `rooms_in_the_booking` , `booking`, `room_comfort` 
								WHERE `rooms_in_the_booking`.`id_room` = '$id_room' 
								AND `rooms_in_the_booking`.`id_room` = `rooms`.`id`
								AND `id_booking` = `booking`.`id`
								AND ( 
									(ADDDATE( `check_in_date`, `number_of_nights` ) >= '$check_in_date' 
										AND `check_in_date` <= '$date_departure') 
									OR (ADDDATE( `check_in_date`, `number_of_nights` ) >= '$date_departure' 
										AND `check_in_date` <= '$check_in_date ' )
										)
								AND NOT (`id_status` = 3)";
									
							if ($result2 = $mysqli->query($res2))
							{
								$row2 = mysqli_num_rows($result2); //кол-во найденых строк 
								if ($row2 == 0) 
								{
									$id = $row_res['id'];
									$room = $row_res['room'];
									$id_comfort  = $row_res['id_comfort'];
									$number_of_guests = $row_res['number_of_guests'];

									$selec_comfort = "SELECT * FROM `rooms`, `room_comfort`  
									WHERE `rooms`.`id` = '$id' AND `room_comfort`.`id` = '$id_comfort'";
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
									$prise = $ASSOC_prise['price'];
							?>
							
								<div class="room">
									<?php
										if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
										{
											$row_photo = $SELECT_photo->fetch_assoc();
											
												?>
												<img class="img_room" src="img/<?=$row_photo['photo']?>" >
												<?php
										}
									?>
									<div class="room_inform">
										<h2><?=$room?></h2>
										<p>
											Комфортность: <?=$comfort?><br> 
											Количество человек: <?=$number_of_guests?><br>
										</p>
										<p>Цена - <?=$prise?>&#8381</p>	
										<?php
										if ($kol_room == 1)
										{
										?>
										<div class="sub_prise">  
											
											<form  method="get" action="room.php">		
											
												<input type="hidden" name="id_room" id="id_room" value="<?=$row_res['id']?>">	
												<input class="button" type="submit" name="button_room" id="button_room" value="Подробнее">
											</form>
											<form  method="get" action="armor.php">	
												<?php
												if(!empty($_GET['user_id']))
												{
												?>
													<input type="hidden" name="user" id="user" value="<?=$_GET['user_id']?>" readonly><br>
												<?php
												}
												?>	
												<input type="hidden" name="id_room" id="id_room" value="<?=$row_res['id']?>">	
												<input type="hidden" name="kol_room" id="kol_room" value="<?=$kol_room?>">
												<input type="hidden" name="check_in_date" id="check_in_date" value="<?=$_POST['check_in_date']?>">	
												<input type="hidden" name="date_departure" id="date_departure" value="<?=$_POST['date_departure']?>">
												<input class="button" type="submit" name="button_room" id="button_room" value="Бронировать">
											</form>
										</div>
										<?php
										}	
										elseif ($kol_room > 1)
										{
										?>
										<div class="sub_prise">  		
											<form  method="get" action="room.php">	
											
												<input type="hidden" name="id_room" id="id_room" value="<?=$row_res['id']?>">	
												<input class="button" type="submit" name="button_room" id="button_room" value="Подробнее">
											</form>
											<form method="post" >	
												<input type="hidden" name="kol_room" id="kol_room" value="<?=$kol_room?>">	
												<input type="hidden" name="row_kol" id="row_kol" value="<?=$row_kol?>">	
												<input type="hidden" name="room_id<?=$row_room?>" id="room_id<?=$row_room?>" value="<?=$row_res['id']?>">	
												<input class="button" type="button" name="button_rooms<?=$row_room?>" 
												id="button_rooms<?=$row_room?>" value="Добавить">
											</form>
										</div>
										<?php
										} 
										?>				
									</div>
								</div>
						
								<?php
									if($row_kol >= $row_room)
									{
										$row_room += 1;
									}
								}
							}
						}
						else{
							$id = $row_res['id'];
							$room = $row_res['room'];
							$id_comfort  = $row_res['id_comfort'];
							$number_of_guests = $row_res['number_of_guests'];

							$selec_comfort = "SELECT * FROM `rooms`, `room_comfort`  
							WHERE `rooms`.`id` = '$id' AND `room_comfort`.`id` = '$id_comfort'";
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
							$prise = $ASSOC_prise['price'];
							?>
							<div class="room">
									<?php
										if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
										{
											$row_photo = $SELECT_photo->fetch_assoc();
											
												?>
												<img class="img_room" src="img/<?=$row_photo['photo']?>" >
												<?php
											
										}
									?>
									<div class="room_inform">
										<h2><?=$room?></h2>
										<p>
											Комфортность: <?=$comfort?><br> 
											Количество человек: <?=$number_of_guests?><br>
										</p>
										<p>Цена - <?=$prise?>&#8381</p>	
										<div class="sub_prise">  
											
											<form  method="get" action="room.php">		
												
												<input type="hidden" name="id_room" id="id_room" value="<?=$row_res['id']?>">	
												<input class="button" type="submit" name="button_room" id="button_room" value="Подробнее">
											</form>
										</div>	
									</div>
								</div>
								<?php
						}
					}
				}
			}
			?>
		</div>
			
	</div>
	<?php
		require_once('footer.php');
	?>
	<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>
	<script src="js/jquery-3.6.4.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {
		let kol_room = $("#kol_room").val();
		let row_kol = $("#row_kol").val();
		for(let i = 1; i <= row_kol; i++)
		{
			$("#button_rooms"+i).click(function () {
				let r_id = $("#room_id"+i).val();
				$.ajax({
					url: 'addarmor.php',
					method: 'POST',
					data: {
						r_id: r_id,
						id: i,
						row_kol: row_kol
					},
					success: function (data) {
						$('#res_id_rooms').append(data);
						$('#armor_hidden').css('display', 'block');
						$('#del_room'+i).click(function () {
							$('#res_id_room'+i).empty();
						});
					}
				});
				
			});
			
			
		}
		

	});
	</script>	
	
	<script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
    <script>
    (function($) {
		function setChecked(target) {
			var checked = $(target).find("input[type='checkbox']:checked").length;

			if (checked) {
				$(target).find('select option:first').html('Выбрано: ' + checked);
			} else {
				$(target).find('select option:first').html('Выберите из списка');
			}
		}
 
		$.fn.checkselect = function() {
			this.wrapInner('<div class="checkselect-popup"></div>');
			this.prepend(
				'<div class="checkselect-control">' +
					'<select class="form-control"><option></option></select>' +
					'<div class="checkselect-over"></div>' +
				'</div>'
			);	
	
			this.each(function(){
				setChecked(this);
			});		
			this.find('input[type="checkbox"]').click(function(){
				setChecked($(this).parents('.checkselect'));
			});
	
			this.parent().find('.checkselect-control').on('click', function(){
				$popup = $(this).next();
				$('.checkselect-popup').not($popup).css('display', 'none');
				if ($popup.is(':hidden')) {
					$popup.css('display', 'block');
					$(this).find('select').focus();
				} else {
					$popup.css('display', 'none');
				}
			});
	
			$('html, body').on('click', function(e){
				if ($(e.target).closest('.checkselect').length == 0){
					$('.checkselect-popup').css('display', 'none');
				}
			});
		};
	})(jQuery);	
	
	$('.checkselect').checkselect();
	var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {},
    $checkboxes = $(".checkselect :checkbox");

	$checkboxes.on("change", function(){
	$checkboxes.each(function(){
		checkboxValues[this.id] = this.checked;
		
	});
	
	localStorage.setItem("checkboxValues", JSON.stringify(checkboxValues));
	});
	
	// On page load
	$.each(checkboxValues, function(key, value) {
		$("#" + key).prop('checked', value);
		
	});
	var chek = $('.checkselect').find("input[type='checkbox']:checked").length;
	if (chek) {
		$('.checkselect').find('select option:first').html('Выбрано: ' + chek);
	} else {
		$('.checkselect').find('select option:first').html('Выберите из списка');
	}
    </script>
	
</body>
</html>