<?php
	require_once('connect.php');
	session_start();

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<title>Изменить пароля</title>
		<link rel="stylesheet" href="css\profile.css">
		<link rel="stylesheet" href="css\modal.css">
		<link rel="shortcut icon" href="img/лого.png" type="image/png">
	</head>
	
	<body>
		<?php require_once('header.php');?>
		<?php
	if (isset($_SESSION["user"]))
	{
			if(isset($_POST['button_password']))
            {

				$loginEmail = $_SESSION['user']['email'];
                
				$result = "SELECT * FROM `users` WHERE `email` = '$loginEmail'";
				// echo $result;
				$result = $mysqli->query($result);
				$users = $result->fetch_assoc();
				
				$oldPassword = mysqli_real_escape_string($mysqli, $_POST['oldpassword']) ;
				

				if (password_verify($oldPassword, $users['password'])) 
                {
                    
					$newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
                    
					$sql_UPDATE = "UPDATE users SET `password` = ? WHERE `email` = ?";
					$stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
		        	mysqli_stmt_bind_param($stmt_UPDATE, 'ss', $newpassword, $loginEmail );
		        	mysqli_stmt_execute($stmt_UPDATE);
					?>
					<div id="myModal" class="modal">
						<!-- Modal content -->
						<div class="modal-content">
						<div class="modal-header">
							<span class="close">×</span>
							<h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
							
						</div>
							<div class="modal-body">
								<p>Пароль изменен</p>
							</div>
						</div>

					</div>
					<script src="js/modalWindow.js"></script>
					<?php
				} 
                else 
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
								<p>Старый пароль введен не верно</p>
							</div>
						</div>

					</div>
					<script src="js/modalWindow.js"></script>
					<?php
					
				}
			}
		?>
		<div class="forma">
			<form id="form" name="form" method="POST">
				
					<h1>Изменить пароль</h1>

					<div class="form_grup">
						<label for="oldpassword">Старый пароль:</label><br>
							<input class="_input" type="password" id="oldpassword" name="oldpassword" onclick="check(form)"
                            value="<?php if (!empty($_POST['oldpassword'])) echo $_POST['oldpassword'];?>" required><br>
						<div class="error" id="error_old_password"></div>
					</div>

					<div class="form_grup">
						<label for="newpassword">Новый пароль:</label><br>
							<input class="_input" type="password" id="newpassword" name="newpassword" onclick="check(form)"
                            value="<?php if (!empty($_POST['newpassword'])) echo $_POST['newpassword'];?>" required><br>
						<div class="error" id="error_new_password"></div>
					</div>

					<div id="password_error"></div>
				<div class="password_form">	
					<input class="button" type="submit" id="button_password"  value="Сменить пароль" name="button_password" disabled>
					<input class="button" type="button" id="button" onclick= "location.href='edit_profile.php'" value="Вернуться"/>
				</div>
			</form>
		</div>
		<script src="js/script_password.js"> </script>
		

	<?php
	}
	?>
	</body>
</html>