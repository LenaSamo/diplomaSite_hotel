
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Изменение профиля</title>
    <link rel="stylesheet" href="css\profile.css">
    <link rel="stylesheet" href="css\modal.css">
    <link rel="shortcut icon" href="img/лого.png" type="image/png">
</head>
<?php
require_once('connect.php');
session_start();
require_once('header.php');
if (isset($_SESSION["user"]))
{
$error_output=false;
?>

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
    if(!empty($_POST['save_profile']))
    {
        if (preg_match('/^[А-я]{1,20}$/u', $_POST['user_name']))
        {
            if (preg_match('/^[A-я]{1,50}$/u', $_POST['surname']))
            {
                if (preg_match('/^[A-я]{1,50}$/u', $_POST['patronymic']))
                {
                
                    if (preg_match('/^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/u', $_POST['email']))
                    {
                        // if (preg_match('/^(8|\+7)\d{10}$/', $_POST['phone']))
                        // {
                            $id = $_SESSION['user']['id'];
                            $user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);
                            $email = mysqli_real_escape_string($mysqli, $_POST['email']);
                            $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
                            $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
                            $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);

                            $sql_SELECT = "SELECT * FROM `users` WHERE (`email` = ? OR `phone` = ?) AND NOT `id` = '$id' ";
                            $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
                            mysqli_stmt_bind_param($stmt_SELECT, 'ss', $email, $phone);
                            mysqli_stmt_execute($stmt_SELECT);

                            $result = mysqli_stmt_get_result($stmt_SELECT);

                            $user = $result->fetch_assoc();
                            
                            if(mysqli_num_rows($result)){
                                ?>
                                <div id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
                                    </div>
                                        <div class="modal-body">
                                            <p>Нельзя изменить почту или номер телефона</p>
                                        </div>
                                    </div>

                                </div>
                                <script src="js/modalWindow.js"></script>
                                <?php
                            }
                            else{
                                $sql_UPDATE = "UPDATE `users` SET `name` = ?, `email` = ?,`phone` = ?, `patronymic` = ?,`surname` = ? WHERE id = ?";
                                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                mysqli_stmt_bind_param($stmt_UPDATE, 'ssssss', $user_name, $email, $phone, $patronymic, $surname, $id);
                                mysqli_stmt_execute($stmt_UPDATE);

                                $result = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$id'");
                                $users = $result->fetch_assoc();
                                $_SESSION['user'] = $users;

                                ?>
                                <div id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                        
                                    </div>
                                        <div class="modal-body">
                                            <p>Информация успешно сохранена</p>
                                        </div>
                                    </div>

                                </div>
                                <script src="js/modalWindow.js"></script>
                                <?php
                            }
                        // }
                        // else
                        // {
                        //     ?>
                                <script type='text/javascript'>
                        //         error_phone.innerHTML = 'Пожалуйста, введите верно телефон.';
                                
                        //     </script>
                            <?php
                        // }
                    }
                    else
                    {
                        ?>
                        <script type='text/javascript'>
                            error_email.innerHTML = 'Пожалуйста, введите верно почту.';
                        
                        </script>
                        <?php
                    }
                
                }
                else
                {
                    ?>
                    <script type='text/javascript'>
                        error_patronymic.innerHTML = 'Пожалуйста, введите верно Отчество.';
                    
                    </script>
                    <?php
                }
            }
            else
            {
                ?>
                <script type='text/javascript'>
                    error_surname.innerHTML = 'Пожалуйста, введите верно Фамилию.';
                    
                </script>
                <?php
            }
            
        } 
        else
        {
            ?>
            <script >
                error_login.innerHTML = 'Пожалуйста, введите верно Имя.';
                
            </script>
            <?php
        }

        
    }           

    ?>
    <div class="form">
        <form id="form_profile" method="POST">
            <div class="user_edit">
                <?php 
                    if(($_SESSION['user']['email'] != "") && ($_SESSION['user']['phone'] != ""))
                    {
                        ?>
                        <div class="user_info">
                            <label for="user_name">Имя:</label><br>
                            <input  class="_input" type="text" name="user_name" id="user_name" value="<?= $_SESSION['user']['name'] ?>" required><br>
                            <div class="error" id="error_login"></div><br>

                            <label for="surname">Фамилия:</label><br>
                            <input  class="_input" type="text" name="surname" id="surname" value="<?= $_SESSION['user']['surname'] ?>" required><br>
                            <div class="error" id="error_surname"></div><br>

                            <label for="patronymic">Отчество:</label><br>
                            <input  class="_input" type="text" name="patronymic" id="patronymic" value="<?= $_SESSION['user']['patronymic'] ?>" required><br>
                            <div class="error" id="error_patronymic"></div><br>
            
                            <label for="email">email:</label><br>
                            <input class="_input" type="email" name="email" id="email" value="<?= $_SESSION['user']['email'] ?>" required><br>
                            <div class="error" id="error_email"></div><br>
                            
                            <label for="phone">Телефон:</label><br>
                            <input class="_input phone" type="phone" name="phone" id="phone" value="<?= $_SESSION['user']['phone'] ?>" required><br>
                            <div class="error" id="error_phone"></div><br>
                            <div class="error" id="profile_error"></div>
                            
                        </div>

                        <input class="button" name="save_profile" id="save_profile" type="submit" value="Сохранить изменения">
                        <input class="button"  type="button" onclick="location.href='passwordRe.php'" value="Изменить пароль"/>
                        <input class="button"  type="button" onclick="location.href='profile.php'" value="Обратно в профиль"/>

                        <?php
                    }
                    else{
                        ?>
                        <div class="user_info">
                            <label for="login">Логин:</label><br>
                            <input  type="text" name="login" id="login" value="<?= $_SESSION['user']['name'] ?>"><br>
                        </div>
                        <?php
                    }
                    ?>
                <!-- <input class="button"  type="button" onclick="location.href='main_page.php'" value="На главную"/> -->
                <!-- <input class="button"  type="button" onclick="location.href='logout.php'" value="Выйти"/> -->
            </div>
        </form>
    </div>
    
    <?php
		require_once('footer.php');

	?>
</body>
<?php
}
?>
</html>