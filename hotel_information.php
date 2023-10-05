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

    if (!empty($_POST['saveInfo']))
    {
        if(preg_match("/^((8|\+7)[\- ]?){1}(\(?\d{3}\)[\- ]?){1}(\d{3}[\- ]){1}(\d{2}[\- ])(\d{2})$/", $_POST['phone']))
        {
            if(preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i", $_POST['email']))
            {
                $idInfo = $_POST['idInfo'];
                $information = mysqli_real_escape_string($mysqli, $_POST['information']);
                $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
                $email = mysqli_real_escape_string($mysqli, $_POST['email']);
                $nameSite = mysqli_real_escape_string($mysqli, $_POST['nameSite']);
                $address = mysqli_real_escape_string($mysqli, $_POST['address']);

                $sql_UPDATE = "UPDATE `hotel_information` SET `information` = ?, 
                `phone` = ?,`nameSite` = ?, `email` = ?, `address` = ? WHERE `id` = ?";
                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                mysqli_stmt_bind_param($stmt_UPDATE, 'sssssi', $information, $phone, $nameSite, $email, $address, $idInfo);
                mysqli_stmt_execute($stmt_UPDATE);

                if($_FILES['file_img']['name'] != "")
                {     
                    
                    $name = $_FILES["file_img"]["name"];
                   
                    $tmp_name = $_FILES["file_img"]["tmp_name"];
                    // basename() может предотвратить атаку на файловую систему;
                    // может быть целесообразным дополнительно проверить имя файла
                    $name = basename($_FILES["file_img"]["name"]);
                    move_uploaded_file($tmp_name, "C:/xampp/htdocs/site_hotel/img/$name");

                    $image= mysqli_real_escape_string($mysqli, $_FILES['file_img']['name']);
                    $id = 1;

                    $sql_INSERT = "UPDATE  `hotel_information` SET `img` = ? WHERE `id` = ?";
                    $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                    mysqli_stmt_bind_param($stmt_INSERT, 'si', $image, $id);
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
                                    <p>Изображение изменено</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    
                }
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
                            <p>Неверный ввод почты</p>
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
                        <p>Неверный ввод номера</p>
                    </div>
                </div>

            </div>
            <script src="js/modalWindow.js"></script>
            <?php
        }
    }
    if ($H2result=$mysqli->query("SELECT * FROM `hotel_information` WHERE `id_users` = 1")) 
    {
        $H2row = $H2result->fetch_assoc();
    
?>
    <div class="grid_inf_hotel">
        <form method="post" class="info" enctype="multipart/form-data">
            <label for="nameSite">Изображение на главной:</label><br>
            <?php
            if ($select_img=$mysqli->query("SELECT `img` FROM `hotel_information` WHERE `id` = 1")) 
            {
                $row_img = $select_img->fetch_assoc()
                ?>
                <div>
                    <img class="img" src="img/<?=$row_img['img']?>">
                </div>  
                <?php
            }
            ?>
            <input class="_input" type="file" name="file_img" id="file_img"><br>

            <label for="nameSite">Название:</label><br>
            <input type="hidden" name="idInfo" id="idInfo" value="<?=$H2row['id']?>">
            <input class="text_input" type="text" name="nameSite" id="nameSite" value="<?=$H2row['nameSite']?>"><br>
            
            <label for="information">Описание:</label><br>
            <textarea name="information" id="information"  required><?=$H2row['information']?></textarea><br>

            
            <label for="phone">Телефон:</label><br>
            <input class="text_input phone" type="text" name="phone" id="phone" value="<?=$H2row['phone']?>"><br>

            <label for="email">Почта:</label><br>
            <input class="text_input" type="text" name="email" id="email" value="<?=$H2row['email']?>"><br>

            <label for="address">Адрес:</label><br>
            <input class="text_input" type="text" name="address" id="address" value="<?=$H2row['address']?>"><br>

            <input type="submit" class="button" name="saveInfo" value="Сохранить">
        </form>    
        <div class="inf_hotel">
            <label for="inf">Информация об отеле:</label><br>
            <?php
            if(!empty($_POST['save2Info']))
            {
                $idHotelInfo = $_POST['idHotelInfo'];
                $inf = mysqli_real_escape_string($mysqli, $_POST['inf']);

                $sql_UPDATE = "UPDATE `hotel_information` SET `info_hotel` = ? WHERE `id` = ?";
                                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                mysqli_stmt_bind_param($stmt_UPDATE, 'si', $inf, $idHotelInfo);
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
                            <p>Сохранение прошло успешно</p>
                        </div>
                    </div>

                </div>
                <script src="js/modalWindow.js"></script>
                <?php
            }
            if(!empty($_POST['deletInfo']))
            {
                $idHotelInfo = $_POST['idHotelInfo'];
                if($idHotelInfo != 1)
                {
                    $sql_UPDATE = "DELETE FROM `hotel_information` WHERE `id` = ?";
                    $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                    mysqli_stmt_bind_param($stmt_UPDATE, 'i', $idHotelInfo);
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
                                <p>Удаление прошло успешно</p>
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
                                <p>Нельзя удалить все абзацы с главной страницы</p>
                            </div>
                        </div>

                    </div>
                    <script src="js/modalWindow.js"></script>
                    <?php
                }
            }
            if(!empty($_POST['add_Info']))
            {
                $inf_add = mysqli_real_escape_string($mysqli, $_POST['inf_add']);
                $id = 1;
                $sql_UPDATE = "INSERT INTO `hotel_information`( `info_hotel`, `id_users`) VALUES (?, ?)";
                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                mysqli_stmt_bind_param($stmt_UPDATE, 'si', $inf_add, $id);
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
                            <p>Добавление прошло успешно</p>
                        </div>
                    </div>

                </div>
                <script src="js/modalWindow.js"></script>
                <?php
            }
            if ($select_hotel_inf=$mysqli->query("SELECT * FROM `hotel_information` WHERE `id_users` = 1")) 
            {
                while($row_inf = $select_hotel_inf->fetch_assoc())
                {
                    
                    ?>
                    <form method="post">
                        <input type="hidden" name="idHotelInfo" id="idHotelInfo" value="<?=$row_inf['id']?>">
                        <textarea name="inf" class="inf"  required><?=$row_inf['info_hotel']?></textarea><br>
                        <input type="submit" class="button" name="save2Info" value="Сохранить">
                        <input type="submit" class="button" name="deletInfo" value="Удалить">
                    </form>  
                    <?php
                }
                
            }
            ?>
            <form method="post">
                <input type="submit" class="button" name="addInfo" value="Добавить новый абзац">
            </form>  
            <?php
            if(!empty($_POST['addInfo']))
            {
                ?>
                <form method="post">
                    <label for="inf_add">Введиет новый абзац:</label><br>
                    <textarea name="inf_add" class="inf_add"  required></textarea><br>
                    <input type="submit" class="button" name="add_Info" value="Добавить">
                </form>  
                <?php
            }
            ?>
        </div>
    </div>
<?php
    }

	require_once('footer.php');
}
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
            $("#phone").click(function(){
                $(this).setCursorPosition(3);
            }).mask("+7(999)999-99-99");
        });
    </script>  
</body>
</html>
