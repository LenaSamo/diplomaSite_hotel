<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
	<meta charset = 'utf-8'>
	<link rel="stylesheet" type="text/css" href="css\home.css">
	<link rel="stylesheet" type="text/css" href="css\sign_in.css">
    <link rel="shortcut icon" href="img/лого.png" type="image/png">
</head>
<body>
    <?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
	?>
    
	<div class="home">
		<form method="post" class="toComeIn_Register" name="toComeInForm">
            <div class="toComeIn" name="toComeInForm" id="ClasstoComeIn">
	            <div class="reg_come">
                    <h2>Войти</h2>
                    <a href = "registration.php">Зарегистрироваться</a><br>
                </div>
                <label for="email_or_num">Почта:</label><br>
	            <input  type="text" сlass="phone" name="email_or_num" id="email_or_num" placeholder="Почта" required><br>
	            <div class="error" id="error"></div><br>

	            <label for="password">Пароль:</label><br>
	            <input type="password" name="password" id="password" placeholder="Пароль" required><br>
	            <div class="error" id="error_passwordform"></div><br>
	            
	            <div class="error" id="error_avt"></div><br>
	            <input class="button" type="submit" name="toComeIn_Person" value="Войти">
		    </div>  
			<?php	
			if(!empty($_POST['toComeIn_Person']))
			{
				$password = mysqli_real_escape_string($mysqli, $_POST['password']) ;
                $email_or_num = mysqli_real_escape_string($mysqli, $_POST['email_or_num']);
				if(preg_match('/^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/', $_POST['email_or_num']))
				{
                    $sql_SELECT = "SELECT * FROM users WHERE `email` = ?";
                    $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
                    mysqli_stmt_bind_param($stmt_SELECT, 's', $email_or_num);
                    mysqli_stmt_execute($stmt_SELECT);

                    $result = mysqli_stmt_get_result($stmt_SELECT);
                    $users = $result->fetch_assoc();
                   
                    if ($users == null || !password_verify($password, $users['password']))
                    {
                        ?>
                        <script type='text/javascript'>
                            error_avt.innerHTML = 'Почта или пароль не верен';
                        </script>
                        <?php		
                    }
                    else{
                   		$_SESSION['user'] = $users;
                        $token = bin2hex(random_bytes(20));
                        $sql_UPDATE = "UPDATE users SET token = ? WHERE `email` = ?";
                        $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                        mysqli_stmt_bind_param($stmt_UPDATE, 'ss', $token ,$email_or_num);
                        mysqli_stmt_execute($stmt_UPDATE);
                        if($_SESSION['user']['id_right'] == 1)
                        {
                            header ('Location: profile.php');
                        }
                        elseif($_SESSION['user']['id_right'] == 2){
                            header ('Location: add_rooms.php?rooms_all=Все+номера');
                        }
                        elseif($_SESSION['user']['id_right'] == 3){
                            header ('Location: booking_table.php');
                        }
                        elseif($_SESSION['user']['id_right'] == 4){
                            header ('Location: staff_table.php');
                        }
                    } 	
				}
				else 
				{
					$sql_SELECT = "SELECT * FROM users WHERE `phone` = ?";
                    $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
                    mysqli_stmt_bind_param($stmt_SELECT, 's', $email_or_num);
                    mysqli_stmt_execute($stmt_SELECT);

                    $result = mysqli_stmt_get_result($stmt_SELECT);
                    $users = $result->fetch_assoc();

                    if ($users == null || !password_verify($password, $users['password']))
                    {
                        ?>
                        <script type='text/javascript'>
                            error_avt.innerHTML = 'Номер или пароль не верен';
                        </script>
                        <?php		
                    }
                    else{
                		$_SESSION['user'] = $users;
                        $token = bin2hex(random_bytes(20));
                        $sql_UPDATE = "UPDATE users SET token = ? WHERE `phone` = ?";
                        $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                        mysqli_stmt_bind_param($stmt_UPDATE, 'ss', $token ,$email_or_num);
                        mysqli_stmt_execute($stmt_UPDATE);
                        header ('Location: profile.php');
                    } 	
				}
			}
			?>
		</form>
	</div>	
	<?php
		require_once('footer.php');
	?>
	<script src="js/jquery-3.6.4.min.js"></script>
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script>
        $(function($){
            let num = 0;
            $("#email_or_num").keyup(function () 
            {
                let val_email_or_num = $(this).val();
                if (val_email_or_num != "") 
                {
                    
                    let regexp1 = /^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/;
                    
                    else if (regexp1.test(email_or_num.value)) 
                    {
                        email_or_num.onblur = function() 
                        {
                            
                            if (!regexp1.test(email_or_num.value) && !regexp3.test(email_or_num.value)) 
                            {
                                email_or_num.classList.add('invalid');
                                error.innerHTML = 'Пожалуйста, введите правильно почту или номер';
                            }
                        }
                    } 
                    else if (event.keyCode >= 97 && event.keyCode <= 122) 
                    {
                        
                        // Alphabet lower case
                        error.innerHTML = 'Пожалуйста, введите правильно почту или номер';
                    }
                }
                
            });
            email_or_num.onfocus = function() 
            {
                if (this.classList.contains('invalid')) 
                {
                    // удаляем индикатор ошибки, т.к. пользователь хочет ввести данные заново
                    this.classList.remove('invalid');
                    error.innerHTML = "";
                };
            };
            
                    
        });
    </script>
</body>
</html>