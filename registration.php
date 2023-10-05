<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
	<meta charset = 'utf-8'>
	<link rel="stylesheet" type="text/css" href="css/sign_in.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">

</head>
<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script>
        $(function($){
            $.fn.setCursorPosition = function(pos) {
            if ($(this).get(0).setSelectionRange) {
                $(this).get(0).setSelectionRange(pos, pos);
            } else if ($(this).get(0).createTextRange) {
                var range = $(this).get(0).createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
            };
            $("#phone").click(function(){
                $(this).setCursorPosition(3);
            }).mask("+7(999)999-99-99");
        });
    </script>
	<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
		if(!empty($_POST['Register_Person']))
		{
			if(preg_match('/^[А-я]{3,}$/u', $_POST['log']) 
			&& preg_match('/^[А-я]{4,}$/u', $_POST['patronymic'])
			&& preg_match('/^[А-я]{2,}$/u', $_POST['surname'])
			&& preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/', $_POST['password1'])
			&& preg_match('/^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/u', $_POST['email']))
			{

				date_default_timezone_set('Asia/Yekaterinburg');

				$name = mysqli_real_escape_string($mysqli, $_POST['log']);
				$surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
				$patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
				$email = mysqli_real_escape_string($mysqli, $_POST['email']);
				$phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
				$password2 = password_hash($_POST['password1'], PASSWORD_DEFAULT);
				$date = date("y.m.d");
				$idRole = 1;
				$token = bin2hex(random_bytes(10));


				$sql_SELECT = "SELECT * FROM users WHERE email = ? OR phone = ?";
				$stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
				mysqli_stmt_bind_param($stmt_SELECT, 'ss', $email, $phone);
				mysqli_stmt_execute($stmt_SELECT);
				$result = mysqli_stmt_get_result($stmt_SELECT);
				$user = $result->fetch_assoc();
				if(mysqli_num_rows($result)){
					?>
					<script type='text/javascript'>
						error_avt.innerHTML = 'Данный пользователь уже существует';
					</script>
					<?php
				}
				else{
					$sql_INSERT = "INSERT INTO `users` (`name`, `surname`, `patronymic`,`email`, `phone`, `password`, `date_registration`, `token`, `id_right`) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
					mysqli_stmt_bind_param($stmt_INSERT, 'ssssssssi', $name, $surname, $patronymic, $email, $phone, $password2, $date, $token,  $idRole);
					mysqli_stmt_execute($stmt_INSERT);

					$new_url = 'sign_in.php';
					header('Location: '.$new_url);
					
				}
			}
			else {

				echo "<script>error_avt.innerHTML = 'Введите верно информацию.';</script>";
			}
		}
		
	?>
	
	<div class="home">
		<form  method="post" class="toComeIn_Register" name="RegisterForm">									
			<div class="Register" >
				<div class="reg_come">
					<h2>Регистрация</h2>
                    <a href = "sign_in.php">Войти</a><br>
                </div>	
				<label for="log">Имя:</label><br>
				<input  type="text" name="log" id="log" placeholder="Петр" required
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['log'])) echo $_POST['log'];?>"
				><br>
				<div class="error" id="error_name"></div><br>

				<label for="surname">Фамилия:</label><br>
				<input  type="text" name="surname" id="surname" placeholder="Петров" required
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['surname'])) echo $_POST['surname'];?>"
				><br>
				<div class="error" id="error_surname"></div><br>

				<label for="patronymic">Отчество:</label><br>
				<input  type="patronymic" name="patronymic" id="patronymic" placeholder="Петрович" required
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['patronymic'])) echo $_POST['patronymic'];?>"
				><br>
				<div class="error" id="error_patronymic"></div><br>

				<label for="email">Email:</label><br>
				<input type="email" name="email" id="email" placeholder="Email" required 
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['email'])) echo $_POST['email'];?>">
				<div class="error" id="error_email"></div><br>

				<label for="phone">Телефон:</label><br>
				<input type="tel" class="phone" name="phone" id="phone" placeholder="Телефон" required 
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['phone'])) echo $_POST['phone'];?>"><br>
				<div class="error" id="error_phone"></div><br>

				<label for="password1">Пароль:</label><br>
				<input type="password" name="password1" id="password1" placeholder="Пароль" required minlength="6" maxlength="15" 
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['password1'])) echo $_POST['password1'];?>"><br>
				<div class="error" id="error_password1"></div><br>

				<label for="password2">Повторите пароль:</label><br>
				<input type="password" name="password2" id="password2" placeholder="Повторите пароль" required 
				onclick="unblockreferences(RegisterForm)"
				value="<?php if (!empty($_POST['password2'])) echo $_POST['password2'];?>"><br>
				<div class="error" id="error_password2"></div><br>

				<input type="checkbox" name="approval" id="approval" onclick="unblockreferences(RegisterForm)">
				<a class="app" href = "approval.php">Я даю согласие на обработку персональных данных</a><br>

				<div class="error" id="error_avt"></div><br>

				<input class="button" type="submit" id="Register_Person" name="Register_Person" value="Зарегистрироваться"  disabled>
				
			</div>  
		</form>
	</div>
	<?php
		require_once('footer.php');
	?>
	<script src="js/script1.js"></script>
</body>
</html>