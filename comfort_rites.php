<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css\content.css">
	<link rel="stylesheet" type="text/css" href="css\table.css">
	<link rel="stylesheet" href="css\modal.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Редактирование контента</title>
</head>
<body>
	<?php

		require_once('connect.php');
		session_start();
		require_once('header.php');
if (isset($_SESSION["user"]) && ($_SESSION["user"]["id_right"] == 2 || $_SESSION["user"]["id_right"] == 4))
{			
		require_once('form_but.php');
	?>
<?php

	//сохранение комфортности
	if(!empty($_POST['addComfort']))
	{
		if ($_POST['addTitle_comfort'] != 'net')
		{
			if (preg_match('/^\d+$/u', $_POST['addPrice']))
			{
				if (preg_match('/^([0-9]{4})\-(0[1-9]|1[0-2])\-(0[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['addPrice_date']))
				{
					//присвоение информации в переменные
					$price = $_POST['addPrice'];
					$price_date = $_POST['addPrice_date'];
					$id_comfort  = $_POST['addTitle_comfort'];

					//проверка на уникальность измененных данных
					$sql_SELECT = "SELECT * FROM `room_rates` WHERE price_date = ? AND id_comfort = ?";
					$stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
					mysqli_stmt_bind_param($stmt_SELECT, 'si',$price_date, $id_comfort);
					mysqli_stmt_execute($stmt_SELECT);
					$result = mysqli_stmt_get_result($stmt_SELECT);

					if(mysqli_num_rows($result))
					{
						?>
						<div id="myModal" class="modal">
							<!-- Modal content -->
							<div class="modal-content">
							<div class="modal-header">
								<span class="close">×</span>
								<h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
							</div>
								<div class="modal-body">
									<p>Нельзя на одну дату ставить цену по одной и той же комфортности</p>
								</div>
							</div>

						</div>
						<script src="js/modalWindow.js"></script>
						<?php
					}
					else{
						$sql_INSERT = "INSERT INTO `room_rates` (`price`, `price_date`, `id_comfort`) VALUES (?, ?, ?)";
						$stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
						mysqli_stmt_bind_param($stmt_INSERT, 'dsi', $price, $price_date, $id_comfort);
						mysqli_stmt_execute($stmt_INSERT);
						?>
						<div id="myModal" class="modal">
							<!-- Modal content -->
							<div class="modal-content">
							<div class="modal-header">
								<span class="close">×</span>
								<h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
							</div>
								<div class="modal-body">
									<p>Добавлена новая цена</p>
								</div>
							</div>

						</div>
						<script src="js/modalWindow.js"></script>
						<?php
					}	
					json_encode(array('success' => 1));	
				}
				else {  
					?>
					<div id="myModal" class="modal">
						<!-- Modal content -->
						<div class="modal-content">
						<div class="modal-header">
							<span class="close">×</span>
							<h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
						</div>
							<div class="modal-body">
								<p>В поле дата назначения должен быть год-месяц-дата</p>
							</div>
						</div>

					</div>
					<script src="js/modalWindow.js"></script>
					<?php
				}
			}
			else {  
				?>
				<div id="myModal" class="modal">
					<!-- Modal content -->
					<div class="modal-content">
					<div class="modal-header">
						<span class="close">×</span>
						<h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
					</div>
						<div class="modal-body">
							<p>В поле цена должно быть положительное число</p>
						</div>
					</div>

				</div>
				<script src="js/modalWindow.js"></script>
				<?php
			}
		}	
		else {  
			?>
			<div id="myModal" class="modal">
				<!-- Modal content -->
				<div class="modal-content">
				<div class="modal-header">
					<span class="close">×</span>
					<h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
				</div>
					<div class="modal-body">
						<p>В поле название комфортности должна быть выбрана комфортность из предложенных</p>
					</div>
				</div>

			</div>
			<script src="js/modalWindow.js"></script>
			<?php
		}
	}	
	if(!empty($_POST['deleteComfort']))
	{
		
		$delet = $_POST['id'];
		if ($result2 = $mysqli->query("SELECT * FROM `room_rates` WHERE `id` = '$delet'"))
		{
			
			$row = mysqli_num_rows($result2); //кол-во найденых строк 
			if ($row == 1) 
			{
				$row_room_rates = $result2->fetch_assoc();
				$id_comfort = $row_room_rates['id_comfort'];
				if ($result2 = $mysqli->query("SELECT * FROM `room_rates` WHERE `id_comfort` = '$id_comfort'"))
				{
					$row = mysqli_num_rows($result2); //кол-во найденых строк 
					if ($row > 1) 
					{
						$num_kol_rates = 0;
						$nowDate = date('y-m-d');
						if ($result2 = $mysqli->query("SELECT * FROM `room_rates`
						 	WHERE `id_comfort` = '$id_comfort' AND `price_date` <= '$nowDate'"))
						{
							$row = mysqli_num_rows($result2); //кол-во найденых строк 
							if ($row > 1) 
							{
								$mysqli->query("DELETE FROM `room_rates` WHERE `id` = '$delet'");
								?>
								<div id="myModal" class="modal">
									<!-- Modal content -->
									<div class="modal-content">
									<div class="modal-header">
										<span class="close">×</span>
										<h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
									</div>
										<div class="modal-body">
											<p>Цена удалена</p>
										</div>
									</div>

								</div>
								<script src="js/modalWindow.js"></script>
								<?php
							}
							else{
								?>
								<div id="myModal" class="modal">
									<!-- Modal content -->
									<div class="modal-content">
									<div class="modal-header">
										<span class="close">×</span>
										<h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
									</div>
										<div class="modal-body">
											<p>Нельзя удалить последную цену на данный момент</p>
										</div>
									</div>

								</div>
								<script src="js/modalWindow.js"></script>
								<?php
							}
						}
						
						
					}
					else{
						?>
						<div id="myModal" class="modal">
							<!-- Modal content -->
							<div class="modal-content">
							<div class="modal-header">
								<span class="close">×</span>
								<h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
							</div>
								<div class="modal-body">
									<p>Нельзя удалить последную цену в данной комфортности</p>
								</div>
							</div>

						</div>
						<script src="js/modalWindow.js"></script>
						<?php
					}
					
				}
			}
		}  
	}
?>
	<h1>Цены по комфортности на номера</h1>
	<form  method="post" id="comfort_categories">
		<input type="submit" class="button_archive" name="archive" value="Перейти в архив">
		<?php
		if (!empty($_POST['archive']) 
		|| (!empty($_POST['addComfort']) && !empty($_POST['archive']))  
		|| (!empty($_POST['deleteComfort'])  && !empty($_POST['archive'])))
		{
			$sl_comfort = "SELECT * FROM `room_comfort`, `room_rates` 
			WHERE `room_comfort`.`id` = `room_rates`.`id_comfort`
			ORDER BY `room_rates`.`price_date` DESC";
			?>
			<input type="submit" class="button_archive" name="and" value="Выход из архива" onclick="foo()">
			<?php
			

		}
		else{
			$nowDate = Date("Y-m-d");
			
			$sl_comfort = "SELECT * FROM `room_rates` as rates_1
					WHERE price_date = (SELECT price_date as max FROM `room_rates` as rates_2 
										WHERE rates_1.`id_comfort` = rates_2.`id_comfort` AND price_date <= '$nowDate' ORDER BY `price_date` DESC LIMIT 1) 
					ORDER BY `price_date` DESC";

			$sl_price_new = "SELECT * FROM `room_rates` as rates_1
			WHERE price_date = (SELECT price_date as max FROM `room_rates` as rates_2 
								WHERE rates_1.`id_comfort` = rates_2.`id_comfort` AND price_date > '$nowDate' ORDER BY `price_date` LIMIT 1) 
			ORDER BY `price_date` DESC";		
		}
		?>
	</form> 
	<!-- таблица будущих цен -->
	<?php
	if(empty($_POST['archive']))
	{
		if ($SELECT_price_new = $mysqli->query($sl_price_new))
		{

		if (mysqli_num_rows($SELECT_price_new))
		{
			?>
		
		<table class="Table">
			<tr class="nametr">
				<th>Ид</th>
				<th>Название комфортности</th>
				<th>Цена</th>
				<th>Дата назначения</th>
			</tr> 
			
			<?php
		
			while($_price_new = $SELECT_price_new->fetch_assoc())
			{
				
				$id_rites = $_price_new['id_comfort'];
				$SLCT_comfort = $mysqli->query("SELECT * FROM `room_comfort`
												WHERE `id` = $id_rites");
				$_comfort_rites = $SLCT_comfort->fetch_assoc()
		?>	
			<form  method="post" id="comfort_categories">
				<tr>
					<td>
						<p class="_input" name="id"><?=$_price_new['id'];?></p>
						<input type="hidden" name="id" value="<?=$_price_new['id'];?>">
					</td>
					<td>
						<input type="hidden" name="id_comfort" value="<?=$_price_new['id_comfort'];?>">
						<input class="_input" type="text" name="title_comfort" value="<?=$_comfort_rites['title_comfort'];?>" readonly="readonly">
					</td>
					<td>
						<input class="_input" type="text" name="price" value="<?=$_price_new['price'];?>" readonly="readonly" >
							
					</td>
					<td>
						<input class="_input" type="date" name="price_date" value="<?=$_price_new['price_date'];?>" readonly="readonly">
					</td>
					<td>
						<!-- <input type="submit" class="button" name="saveComfort" value="Сохранить" onclick="foo()"> -->
						<input type="submit" class="button" name="deleteComfort" value="Удалить" onclick="foo()">    
					</td>
				</tr>	
			</form>		
		<?php	 
			}
		}
		
			
		}	
	}?>
		
	</table>	
	<div class="table">
		<table class="Table">
			<tr class="nametr">
				<th>Ид</th>
				<th>Название комфортности</th>
				<th>Цена</th>
				<th>Дата назначения</th>
			</tr> 
			

			
			<form  method="post" id="comfort_categories">
			<tr>
				<td></td>
				<td>
					<select class="_input" name="addTitle_comfort" >
						<option value="<?='net'?>">
							Выберите
						</option>
						<?php
							if ($result2 = $mysqli->query("SELECT * FROM `room_comfort`")) 
							{
								while($row2 = $result2->fetch_assoc())
								{
						?>
									<option value="<?=$row2['id']?>" >
										<?=$row2['title_comfort']?>
									</option>
						<?php  
								}
							}	
						?>
					</select> 
				</td>
				<td>
					<input class="_input" type="text" name="addPrice" required >
						
				</td>
				<td>
					<?php
					$nowDate = Date("Y-m-d");
					?>
					<input class="_input" type="date" name="addPrice_date" required  min="<?=$nowDate?>">
				</td>
				<td>
					<input type="submit" class="button" name="addComfort" value="Добавить" onclick="foo()">
				</td>
			</tr>	
			</form>
			<form  method="post" id="comfort_categories">
			<?php
			if ($SELECT_comfort = $mysqli->query($sl_comfort))
			{
				while($_comfort = $SELECT_comfort->fetch_assoc())
				{
					
					$id_rites = $_comfort['id_comfort'];
					$SLCT_comfort = $mysqli->query("SELECT * FROM `room_comfort`
													WHERE `id` = $id_rites");
					$_comfort_rites = $SLCT_comfort->fetch_assoc()
			?>	
				<form  method="post" id="comfort_categories">
					<tr>
						<td>
							<p class="_input" name="id"><?=$_comfort['id'];?></p>
							<input type="hidden" name="id" value="<?=$_comfort['id'];?>">
						</td>
						<td>
							<input type="hidden" name="id_comfort" value="<?=$_price_new['id_comfort'];?>">
							<input class="_input" type="text" name="title_comfort" value="<?=$_comfort_rites['title_comfort'];?>" readonly="readonly">
						</td>
						<td>
							<input class="_input" type="text" name="price" value="<?=$_comfort['price'];?>" readonly="readonly">
								
						</td>
						<td>
							<input class="_input" type="date" name="price_date" value="<?=$_comfort['price_date'];?>" readonly="readonly">
						</td>
						<td>
							<!-- <input type="submit" class="button" name="saveComfort" value="Сохранить" onclick="foo()"> -->
							<input type="submit" class="button" name="deleteComfort" value="Удалить" onclick="foo()">    
						</td>
					</tr>	
				</form>  	
			<?php	 
				}
			}	
			?>
		</table>
	</div>	 
	<?php 
	require_once('footer.php');
	// <!--Конец Категории комфортности номеров -->
}
	?>
</body>
</html>
