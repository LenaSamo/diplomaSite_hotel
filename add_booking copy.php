<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Добавление брони</title>
    <link rel="stylesheet" href="css/table.css">
</head>
<?php
    require_once('connect.php');
    session_start();
    require_once('header.php');
   
?>

<body> 
    <?php
    if (isset($_SESSION["user"]) && ($_SESSION["user"]["id_right"] == 3 || $_SESSION["user"]["id_right"] == 4))
    {             
    ?>
        <div class="add" >
            <h2>Добавить бронь</h2>  
 
            <form method="post">
               <div class="user">
                    <p>Пользователь:</p>
                    <div>                       
                        <input type="radio" id="user" name="user" value="user_log" checked="checked" <?php
                            if (!empty($_POST['user']) && $_POST['user'] === 'user_log') {
                                echo 'checked';
                            }
                        ?>>
                        <label for="user">Пользователь уже зарегистрирован</label><br>

                        <input type="radio" id="user" name="user" value="user_reg" <?php
                            if (!empty($_POST['user']) && $_POST['user'] === 'user_reg') {
                                echo 'checked';
                            }
                        ?>>
                        <label for="user">Пользователя нет в системе</label><br>
                    </div>
                    <input type="submit" name="user_sub" value="Потвердить" /><br> 
                    
             </form>      
             <?php
                    if(!empty($_POST['user_id']))
                    {
                        ?>
                        <form action="rooms.php"  method="get">
                            <label for="user">Пользователь: </label>
                            <input type="hidden" name="user_id" id="user_id" value="<?=$_POST['user_id']?>" readonly><br>
                            <input type="text" name="user" id="user" value="<?=$_POST['user_selected']?>" readonly><br>
                            
                            <input type="submit" class="choose_user" value="Выбрать" name="choose_user"><br>
                        </form>
                        <?php
                    }
                    ?> 
                    <?php
                    if(!empty($_POST['user']))
                    {
                        if($_POST['user'] == 'user_log' && !empty($_POST['user_sub']))
                        {   
                            if (isset($_POST['user_selected'])) 
                            {
                                echo "<input type='submit' name='user_selected' value=".$res["name"]." ".$res["surname"]." ".$res["patronymic"]." /><br>";
                            }
                        ?>        
                            <input type="text" class="form-control" name="live_search" id="live_search" autocomplete="off"
                            placeholder="Поиск пользователя">
                            <div id="search_result"></div>
                            <div id="search_select"></div>
                        <?php        
                        }
                        else if($_POST['user'] == 'user_reg' && !empty($_POST['user_sub']))
                        {
                            ?>
                            <form  method="post" class="toComeIn_Register" name="RegisterForm">									
                                <div class="Register" >
                                    <div class="reg_come">
                                        <h2>Регистрация пользователя в системе</h2>
                                    </div>	
                                    <label for="log">Имя:</label><br>
                                    <input  type="text" name="log" id="log" placeholder="Петр" required
                                    value="<?php if (!empty($_POST['log'])) echo $_POST['log'];?>"><br>
                                    <div id="error_name"></div><br>

                                    <label for="surname">Фамилия:</label><br>
                                    <input  type="text" name="surname" id="surname" placeholder="Петров" required
                                    value="<?php if (!empty($_POST['surname'])) echo $_POST['surname'];?>"><br>
                                    <div id="error_surname"></div><br>

                                    <label for="patronymic">Отчество:</label><br>
                                    <input  type="patronymic" name="patronymic" id="patronymic" placeholder="Петрович" required
                                    value="<?php if (!empty($_POST['patronymic'])) echo $_POST['patronymic'];?>"><br>
                                    <div id="error_patronymic"></div><br>

                                    <label for="email">Email:</label><br>
                                    <input type="email" name="email" id="email" placeholder="Email" required 
                                    value="<?php if (!empty($_POST['email'])) echo $_POST['email'];?>">
                                    <div id="error_email"></div><br>

                                    <label for="phone">Телефон:</label><br>
                                    <input type="tel" name="phone" id="phone" placeholder="Телефон" required 
                                    value="<?php if (!empty($_POST['phone'])) echo $_POST['phone'];?>"><br>
                                    <div id="error_phone"></div><br>

                                    <div class="error" id="error_avt"></div><br>
                                    <input class="button" type="submit" id="Register_Person" name="Register_Person" value="Зарегистрироваться">
                                </div>  
                            </form>
                        <?php
                        }
                    }
                ?>
                </div>
            
            <?php
            if(!empty($_POST['Register_Person']))
            {
                
                if(preg_match('/^[А-я]{3,}$/u', $_POST['log']) 
                && preg_match('/^[А-я]{4,}$/u', $_POST['patronymic'])
                && preg_match('/^[А-я]{2,}$/u', $_POST['surname'])
                && preg_match('/^(8|\+7)\d{10}$/', $_POST['phone'])
                && preg_match('/^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/u', $_POST['email']))
                {

                    date_default_timezone_set('Asia/Yekaterinburg');

                    $name = mysqli_real_escape_string($mysqli, $_POST['log']);
                    $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
                    $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
                    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
                    $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
                    $password2 = password_hash('userHotelNightParadise', PASSWORD_DEFAULT);
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

                        $res2 = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
                        $result2 = $mysqli->query($res2);
                        $ASSOC_comfort = $result2->fetch_assoc();
						$user_id = $ASSOC_comfort['id'];

                        ?>
                        <form action="rooms.php"  method="get">
                            <label for="user">Пользователь: </label>
                            <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" readonly><br>
                            <input type="text" name="user" id="user" value="<?=$ASSOC_comfort['surname']?> <?=$ASSOC_comfort['name']?> <?=$ASSOC_comfort['patronymic']?>" readonly><br>
                            
                            <input type="submit" class="choose_user" value="Выбрать" name="choose_user"><br>
                        </form>
                        <?php
                        
                        
                    }
                }
                else {

                    echo "<script>error_avt.innerHTML = 'Введите верно информацию.';</script>";
                }



            }
    }
    else {
        header ('Location: sign_in.php');
    }
    ?>
<script src="jquery-3.6.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#live_search").keyup(function () {
            var query = $(this).val();
            if (query != "") {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function (data) {
                        $('#search_result').html(data);
                        $('#search_result').css('display', 'block');
                        $("#live_search").focusin(function () {
                            $('#search_result').css('display', 'block');
                        });
                        $("#live_search").focusin(function () {
                            $('#search_select').css('display', 'block');
                        });
                    }
                });
            } else {
                $('#search_result').css('display', 'none');
            }
        });

    });
</script>
</body>
</html>
    