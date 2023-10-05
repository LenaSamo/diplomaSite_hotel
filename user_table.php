
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Клиенты</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css\modal.css">
    <link rel="shortcut icon" href="img/лого.png" type="image/png">
</head>
    <?php
        require_once('connect.php');
        session_start();
        require_once('header.php');
        $error_output=false;
    ?>

<body>
    
    <?php
    if (isset($_SESSION["user"]) && ($_SESSION["user"]["id_right"] == 3 || $_SESSION["user"]["id_right"] == 4))
    {
       
        //сохранение информации пользователя
        if(!empty($_POST['savePersoninfo']))
        {
            if (preg_match('/^[А-я]{1,20}$/u', $_POST['user_name']))
            {
                if (preg_match('/^[А-я]{1,50}$/u', $_POST['surname']))
                {
                    if (preg_match('/^[А-я]{1,50}$/u', $_POST['patronymic']))
                    {
                        if (preg_match('/^([A-z0-9]+([\-\_.]?[A-z0-9]+)*)@([A-z]+\.[A-z]+)$/u', $_POST['email']))
                        {
                            if (preg_match('/^((8|\+7)[\- ]?){1}(\(?\d{3}\)[\- ]?){1}(\d{3}[\- ]){1}(\d{2}[\- ])(\d{2})$/', $_POST['phone']))
                            {
                                $id = $_POST['idperson'];
                                $user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);
                                $email = mysqli_real_escape_string($mysqli, $_POST['email']);
                                $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
                                $patronymic = mysqli_real_escape_string($mysqli, $_POST['patronymic']);
                                $surname = mysqli_real_escape_string($mysqli, $_POST['surname']);
                                $sql_SELECT = "SELECT * FROM `users` 
                                WHERE (`email` = ? OR `phone` = ?)
                                    AND NOT (`id` = '$id')";
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
                                else
                                {
                                    $sql_UPDATE = "UPDATE `users` 
                                    SET `name` = ?, `email` = ?,`phone` = ?, `patronymic` = ?,`surname` = ? WHERE id = ?";
                                    $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                    mysqli_stmt_bind_param($stmt_UPDATE, 'ssssss', $user_name, $email, $phone, $patronymic, $surname, $id);
                                    mysqli_stmt_execute($stmt_UPDATE);

                                    $result = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$id'");
                                    $users = $result->fetch_assoc();
                                    ?>
                                    <div id="myModal" class="modal">
                                        <!-- Modal content -->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="close">×</span>
                                            <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                        </div>
                                            <div class="modal-body">
                                                <p>Сохранение прошло успешно</p>
                                            </div>
                                        </div>

                                    </div>
                                    <script src="js/modalWindow.js"></script>
                                    <?php
                                }

                                if($_SESSION["user"]["id_right"] == 4)   
                                {
                                    $id_right = $_POST['id_right'];
                                    $idperson = mysqli_real_escape_string($mysqli, $_POST['idperson']);
                                    $sql_SELECT = "SELECT * FROM `users` WHERE  `id` = '$idperson'";
                                    $result = $mysqli->query($sql_SELECT);
                                    $user = $result->fetch_assoc();
                                    if($user['id_right'] <> $id_right)
                                    {
                                        $sql_UPDATE = "UPDATE `users` SET `id_right` = ? WHERE id = ?";
                                        $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                        mysqli_stmt_bind_param($stmt_UPDATE, 'is', $id_right, $idperson);
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
                                                    <p>Изменение права пользователя прошло успешно</p>
                                                </div>
                                            </div>

                                        </div>
                                        <script src="js/modalWindow.js"></script>
                                        <?php
                                        if($id_right != 1)
                                        {
                                            ?>
                                            <script>
                                                document.getElementById('button_on').onclick = location.href='user_table.php';
                                            </script>
                                            <?php   
                                        }
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
                                                <p>Номер телефона введен неверно</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="js/modalWindow.js"></script>
                                <?php
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
                                            <p>Почта введена неверно</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script src="js/modalWindow.js"></script>
                            <?php
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
                                        <p>Отчество введено неверно</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script src="js/modalWindow.js"></script>
                        <?php
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
                                    <p>Фамилия введена неверно</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="js/modalWindow.js"></script>
                    <?php
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
                                <p>Имя введена неверно</p>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="js/modalWindow.js"></script>
                <?php
            }     
        }
        //удаление пользователя
        if(!empty($_POST['deletePersoninfo']))
        {
            $delet = $_POST['idperson'];
            if ($result2 = $mysqli->query("SELECT `id` FROM `users` WHERE `id` = '$delet'"))
            {
                $row = mysqli_num_rows($result2); //кол-во найденых строк 
                if ($row == 1) 
                {
                    $mysqli->query("DELETE FROM `users` WHERE `id` = '$delet'");
                    ?>
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">×</span>
                            <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                        </div>
                            <div class="modal-body">
                                <p>Пользователь удален</p>
                            </div>
                        </div>
                    </div>
                    <script src="js/modalWindow.js"></script>
                    <?php 
                    $new_url = 'user_table.php';
                    header('Location: '.$new_url);
                }
            }    
        }
        
        if(!empty($_POST['addArmorPersoninfo']))
        {
            $idperson = $_POST['idperson'];
            $new_url = 'rooms.php?user_id='.$idperson;
            header('Location: '.$new_url);
        }
    ?>
    <h1>Клиенты</h1> 
    <form class="bloc_search_user">
        <div class="search" method="post">
            <input type="text" class="form-control" name="live_search" id="live_search" autocomplete="off"
            placeholder="Поиск пользователя">
            <div id="search_result"></div>
            <div id="search_select"></div>
        </div>
        <input class="button"  type="button" 
            onclick="location.href='user_table.php'" value="Отменить поиск"/>
    </form>
    <?php
    if(!empty($_GET['user_id']))
    {
        ?>
        <div class="table_user_search">
            
            <table class="Table">
                <tr class="nametr">
                    <th>Ид</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Почта</th>
                    <th>Номер телефона</th>
                    <th>Дата регистрации</th>
                    <?php
                    if($_SESSION["user"]["id_right"] == 4)   
                    {
                    ?>    
                    <th>Ид права</th>
                    <?php
                    } 
                    ?>
                </tr> 
                <?php
                $id_user_search = $_GET['user_id'];
                if ($user_search = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$id_user_search'"))
                {
                    if($row_user_search = $user_search->fetch_assoc())
                    {?>
                    <form  method="post">
                        <tr>       
                            <td>
                                <p class="_input" name="id"><?=$row_user_search['id']?></p>
                                <input type="hidden" name="idperson" value="<?=$row_user_search['id']?>">
                            </td>
                            <td>
                                <input class="_input" type="text" name="user_name" value="<?=$row_user_search['name'];?>">
                            </td>
                            <td>
                                <input class="_input" type="text" name="surname" value="<?=$row_user_search['surname'];?>">
                            </td>
                            <td>
                                <input class="_input" type="text" name="patronymic" value="<?=$row_user_search['patronymic'];?>">
                            </td>
                            <td>
                                <input class="_input" type="text" name="email" value="<?=$row_user_search['email'];?>">
                            </td>
                            <td>
                                <input class="_input phone" type="text" name="phone" value="<?=$row_user_search['phone'];?>">
                            </td>
                            <td>
                                <input class="_input" type="date" name="date_registration" value="<?=$row_user_search['date_registration'];?>" readonly>
                            </td>
                            <?php
                            if($_SESSION["user"]["id_right"] == 4)   
                            {

                                if ($_SESSION["user"]["id"] == $row_user_search['id'])
                                {
                                    ?>
                                    <td>
                                        <input class="_input" type="text" name="id_right" value="<?=$row_user_search['id_right'];?>" size="5" readonly>                                                    
                                    </td>
                                <?php    
                                }
                                else
                                {
                                ?>
                                    <td>
                                    <?php
                                    $id_right = $row_user_search['id_right'];
                                    $selec_id_right = "SELECT * FROM `rights`
                                                        WHERE `id` = '$id_right'";
                                    $RES_id_right = $mysqli->query($selec_id_right);
                                    $ASSOC_id_right = $RES_id_right->fetch_assoc();
                                    $right = $ASSOC_id_right['right'];
                                    ?>
                                        <select class="_input" name="id_right" id="id_right" >
                                            <option value="<?=$row_user_search['id_right']?>" >
                                                <?=$right?>
                                            </option>
                                            <?php 
                                            $sql_comfort = "SELECT * FROM `rights`";
                                            if ($SELECT_max_id_comfort  = $mysqli->query($sql_comfort)) 
                                            {
                                                while($row = $SELECT_max_id_comfort->fetch_assoc())
                                                {
                                                ?>
                                                    <option value="<?=$row['id']?>">
                                                        <?=$row['right']?>
                                                    </option>
                                            <?php 
                                                }   	
                                            }
                                            
                                            ?>
                                        </select>
                                    </td>
                                <?php   
                                }
                            }    
                            ?>
                            <td>
                                <input type="submit" class="button" name="savePersoninfo" value="Сохранить"> 
                            </td>
                            <td>
                                <input type="submit" class="button" name="deletePersoninfo" value="Удалить">    
                            </td>
                            <td>
                                <input type="submit" class="button" name="addArmorPersoninfo" value="Добавить бронирование">    
                            </td>
                        </tr>
                    </form>
                    <?php
                    }
                }
                ?>
            </table><br>
            
        </div>
        <?php
    }
    ?>
    <div class="table">
        
        <table class="Table">
            <tr class="nametr">
                <th>Ид</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Почта</th>
                <th>Номер телефона</th>
                <th>Дата регистрации</th>
                <?php
                if($_SESSION["user"]["id_right"] == 4)   
                {
                ?>    

                <th>Ид права</th>

                <?php
                } 
                ?>
            </tr>   
            <?php
                if ($result1 = $mysqli->query("SELECT * FROM `users` WHERE `id_right` = 1  ORDER BY `id` DESC"))
                {
                    while($row = $result1->fetch_assoc())
                    {?>
                    <form  method="post">
                        <tr>
                            
                                <td>
                                    <p class="_input" name="id"><?=$row['id'];?></p>
                                    <input type="hidden" name="idperson" value="<?=$row['id'];?>">
                                </td>
                                <td>
                                    <input class="_input" type="text" name="user_name" value="<?=$row['name'];?>">
                                </td>
                                <td>
                                    <input class="_input" type="text" name="surname" value="<?=$row['surname'];?>">
                                </td>
                                <td>
                                    <input class="_input" type="text" name="patronymic" value="<?=$row['patronymic'];?>">
                                </td>
                                <td>
                                    <input class="_input" type="text" name="email" value="<?=$row['email'];?>">
                                </td>
                                <td>
                                    <input class="_input phone" type="text" name="phone" value="<?=$row['phone'];?>">
                                </td>
                                <td>
                                    <input class="_input" type="date" name="date_registration" value="<?=$row['date_registration'];?>" readonly>
                                </td>
                                <?php
                                if($_SESSION["user"]["id_right"] == 4)   
                                {

                                    if ($_SESSION["user"]["id"] == $row['id'])
                                    {
                                        ?>
                                        <td>
                                            <input class="_input" type="text" name="id_right" value="<?=$row['id_right'];?>" size="5" readonly>                                                    
                                        </td>
                                    <?php    
                                    }
                                    else
                                    {
                                    ?>
                                        <td>
                                        <?php
                                        $id_right = $row['id_right'];
                                        $selec_id_right = "SELECT * FROM `rights`
                                                            WHERE `id` = '$id_right'";
                                        $RES_id_right = $mysqli->query($selec_id_right);
                                        $ASSOC_id_right = $RES_id_right->fetch_assoc();
                                        $right = $ASSOC_id_right['right'];
                                        ?>
                                            <select class="_input" name="id_right" id="id_right" >
                                                <option value="<?=$row['id_right']?>" >
                                                    <?=$right?>
                                                </option>
                                                <?php 
                                                $sql_comfort = "SELECT * FROM `rights`";
                                                if ($SELECT_max_id_comfort  = $mysqli->query($sql_comfort)) 
                                                {
                                                    while($row = $SELECT_max_id_comfort->fetch_assoc())
                                                    {
                                                    ?>
                                                        <option value="<?=$row['id']?>">
                                                            <?=$row['right']?>
                                                        </option>
                                                <?php 
                                                    }   	
                                                }
                                                
                                                ?>
                                            </select>
                                        </td>
                                    <?php   
                                    }
                                }    
                                ?>
                                <td>
                                    <input type="submit" class="button" name="savePersoninfo" value="Сохранить"> 
                                </td>
                                <td>
                                    <input type="submit" class="button" name="deletePersoninfo" value="Удалить">    
                                </td>
                                <td>
                                    <input type="submit" class="button" name="addArmorPersoninfo" value="Добавить бронирование">    
                                </td>
                        </tr>
                    </form>
                    <?php

                    }
                    $result1->free();
                }
            ?>   
        </table><br>
        
    </div>
    <?php
    }
    else {
        header ('Location: sign_in.php');
    }

    require_once('footer.php');
    ?>
    
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
            $(".phone").click(function(){
                $(this).setCursorPosition(3);
            }).mask("+7(999)999-99-99");
        });
    </script>  
    <script src="js/jquery-3.6.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#live_search").keyup(function () {
                var query_user = $(this).val();
                if (query_user != "") {
                    $.ajax({
                        url: 'search.php',
                        method: 'POST',
                        data: {
                            query_user: query_user
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