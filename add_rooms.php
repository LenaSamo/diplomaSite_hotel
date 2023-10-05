<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/лого.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="css\table.css">
	<link rel="stylesheet" type="text/css" href="css\content.css">
	
    <link rel="stylesheet" href="css\modal.css">
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
	
    <div class="bloc_search">
        <div class="search" method="post">
            <input type="text" class="form-control" name="live_search" id="live_search" autocomplete="off" placeholder="Поиск номера">
            <div id="search_result"></div>
        </div>
        <form  method="get">
            <input class="button" type="submit" name="servise_room" value="Услуги в номерах">
            <input class="button" type="submit" name="rooms_add" value="Добавить номер">
            <input class="button" type="submit" name="rooms_all" id="rooms_all" value="Все номера">
        </form>
    </div>

    <?php
    require_once('rooms_all.php');
    require_once('servise_room.php');

    if (!empty($_GET['rooms_add']) || !empty($_POST['butAddRoom']))
    {  
        if(!empty($_POST['butAddRoom']))
        {
            if($_POST['in_room_services'] != 'net')
            {
                if(preg_match('/^\d$/u', $_POST['number_of_guests']))
                {
                    $room = mysqli_real_escape_string($mysqli, $_POST['room']);
                    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
                    $in_room_services =  $_POST['in_room_services'];
                    $number_of_guests = $_POST['number_of_guests'];

                    $sql_SELECT = "SELECT * FROM `rooms` WHERE `room` = ? AND `id_comfort` = ? AND `number_of_guests` = ?";
                    $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
                    mysqli_stmt_bind_param($stmt_SELECT, 'sii', $room, $in_room_services, $number_of_guests);
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
                                        <p>Данный номер уже существует</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    else{

                        if ($SELEC_comfort_rites  = $mysqli->query("SELECT * FROM `room_rates` WHERE '$in_room_services' = `id_comfort`")) 
                        {
                            if(mysqli_num_rows($SELEC_comfort_rites) != 0)
                            {
                                $select_comfort = "SELECT *
                                FROM `room_comfort`, `set_of_equipment`
                                WHERE `room_comfort`.`id` = '$in_room_services' 
                                AND `id_comfort` = `room_comfort`.`id`";
                                if ($result2 = $mysqli->query($select_comfort))
                                {
                                    $row2 = mysqli_num_rows($result2); //кол-во найденых строк 
                                    if ($row2 > 0) 
                                    {
                                        $sql_INSERT = "INSERT INTO `rooms` (`room`, `description`, `id_comfort`,`number_of_guests`) 
                                        VALUES (?, ?, ?, ?)";
                                        $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                                        mysqli_stmt_bind_param($stmt_INSERT, 'ssii', $room, $description, $in_room_services, $number_of_guests);
                                        mysqli_stmt_execute($stmt_INSERT);
                                    
                                        if(!empty($_FILES['image_add']['name']))
                                        {     
                                            $tmp_name = $_FILES["image_add"]["tmp_name"];
                                            $name = basename($_FILES["image_add"]["name"]);
                                            move_uploaded_file($tmp_name, "C:/xampp/htdocs/site_hotel/img/$name");
                                            $image= mysqli_real_escape_string($mysqli, $_FILES['image_add']['name']);
                                    
                                            $selec_room_new = "SELECT id FROM `rooms`  
                                            WHERE `room` = '$room' AND `description` = '$description' 
                                            AND `id_comfort` = '$in_room_services' AND `number_of_guests` = '$number_of_guests'";
                                            $RES = $mysqli->query($selec_room_new);
                                            $ASSOC = $RES->fetch_assoc();
                                            $id_new_room = $ASSOC['id'];
                                            if( $id_new_room != "")
                                            {
                                                $sql_INSERT = "INSERT INTO `photos_of_the_rooms` (`photo`, `id_room`) 
                                                VALUES (?, ?)";
                                                $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                                                mysqli_stmt_bind_param($stmt_INSERT, 'si', $image, $id_new_room);
                                                mysqli_stmt_execute($stmt_INSERT);
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
                                                                <p>Изображение не удалось добавить</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            
                                        }
                                        // $sql_SELECT = "SELECT * FROM `rooms` 
                                        // WHERE `room` = '$room' AND `id_comfort` = '$in_room_services' AND `number_of_guests` = '$number_of_guests'";
                                        // $select = $mysqli->query($sql_SELECT);
                                        // $row = $select->fetch_assoc();
                                        // $id_room = $row['id'];
                                        ?>
                                        <div id="myModal" class="modal">
                                            <!-- Modal content -->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <span class="close">×</span>
                                                    <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                                </div>
                                                    <div class="modal-body">
                                                        <p>Номер добавлен</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $_POST['room'] = "";
                                        $_POST['description'] = "";
                                        $_POST['in_room_services'] = "";
                                        $_POST['number_of_guests'] = "";
                                        // $new_url = 'add_rooms.php?room_selected=выбрать&idroom='.$id_room.'&hidden_el=1';
                                        // header('Location: '.$new_url);
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
                                                        <p>В выбраной комфотности не указано не одной услуги(добавте услуги в данную комфортность)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                <p>На данную комфортность не указана цена</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        
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
                                    <p>Введите верно кол-во гостей в номере</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <p>Выберите комфортность номера</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    ?>
        <form  method="post" class="form_add_room" name="form_add_room" enctype="multipart/form-data">	
            <h2>Добавить номер</h2>

            <label for="image_add">Добавить изображение к номеру</label>
            <input type="file" id="image_add" name="image_add" 
            value="<?php if (!empty($_FILES['image_add']['name'])) echo $_FILES['image_add']['name'];?>" required><br>
                                

            <label for="room">Название номера:</label><br>
            <input  type="text" name="room" id="room" required
            value="<?php if (!empty($_POST['room'])) echo $_POST['room'];?>"><br>

            <label for="description">Описание:</label><br>
            <textarea name="description" id="description"  required>
                <?php if (!empty($_POST['description'])) echo $_POST['description'];?></textarea><br>


            <label for="in_room_services">Комфортность номера:</label><br>
            <select name="in_room_services" id="in_room_services" >
                <option value="net" <?php if (!empty($_POST['in_room_services']) 
                                    && $_POST['in_room_services'] == 'net'){echo "selected='selected'";} ?>>
                    выберите
                </option>
                <?php 
                $sql_comfort = "SELECT *  FROM `room_comfort`";
                if ($SELECT_max_id_comfort  = $mysqli->query($sql_comfort)) 
                {
                    while($row = $SELECT_max_id_comfort->fetch_assoc())
                    {
                        $id_comfort = $row['id'];
                        $comfort = $row['title_comfort'];
                    ?>
                        <option value="<?=$id_comfort?>"  
                        <?php if (!empty($_POST['in_room_services']) && $_POST['in_room_services'] == $id_comfort){echo "selected='selected'";} ?>>
                            <?=$comfort?>
                        </option>
                <?php 
                    }   	
                }
                
                ?>
            </select><br>

            <label for="number_of_guests">Количество человек в номере:</label><br>
            <input  type="text" name="number_of_guests" id="number_of_guests" required
            value="<?php if (!empty($_POST['number_of_guests'])) echo $_POST['number_of_guests'];?>"><br>
            <div id="error_number_of_guests"></div><br>
        
            <input class="button" type="submit" name="butAddRoom" id="butAddRoom" value="Добавить номер" >
        </form>
            
        
        <script src="script_add_rooms.js"></script>
    <?php
    }
        if (!empty($_POST['butDelImg']))
        {
            $id = $_GET['id_room'];
            $sql_SELECT = "SELECT * FROM `photos_of_the_rooms` 
            WHERE `id_room` = '$id'";
            $select_set_of_equipment = $mysqli->query($sql_SELECT);
            if(mysqli_num_rows($select_set_of_equipment) > 1)
            {
                $id_img = $_POST['id_img'];
                $sql_DEL = "DELETE FROM `photos_of_the_rooms` WHERE `id` = '$id_img'";
                $del_img = $mysqli->query($sql_DEL);
                ?>
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">×</span>
                            <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                        </div>
                            <div class="modal-body">
                                <p>Фото номера удалено</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <p>Необходимо хотя бы 1 фото номера</p>
                            </div>
                        </div>
                    </div>
                </div>
    <?php
            }
        }
        if (!empty($_POST['butDelet_room']))
        {
            $id = $_POST['id'];
            $now_date = date('y-m-d');
            $sql_SELECT = "SELECT `rooms`.`id`
            FROM `rooms`,`booking`,`rooms_in_the_booking`
            WHERE
                    `rooms_in_the_booking`.`id_room` = '$id'
                AND 
                    `rooms_in_the_booking`.`id_room` = `rooms`.`id`
                AND 
                    `rooms_in_the_booking`.`id_booking` = `booking`.id 
                AND 
                    (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$now_date' AND  `check_in_date` >= '$now_date' )
                        
            ORDER BY `rooms`.`id`";
            $select_set_of_equipment = $mysqli->query($sql_SELECT);
            if(mysqli_num_rows($select_set_of_equipment) == 0)
            {
                $sql_SELECT = "SELECT * FROM `rooms`";
                $select_set_of_equipment = $mysqli->query($sql_SELECT);
                if(mysqli_num_rows($select_set_of_equipment) > 1)
                {
                    $id = $_POST['id'];
                    $sql_DEL = "DELETE FROM `photos_of_the_rooms` WHERE `id_room` = '$id'";
                    $mysqli->query($sql_DEL);
                    $sql_DELrooms = "DELETE FROM `rooms` WHERE `id` = '$id'";
                    $mysqli->query($sql_DELrooms);
                    ?>
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close">×</span>
                                <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                            </div>
                                <div class="modal-body">
                                    <p>Номер удалён</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!empty($_GET['idroom']))
                    {
                        $_GET['idroom'] = 0;
                    }
                    elseif (!empty($_GET['id_room'])){
                        $_GET['id_room'] = 0;
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
                                    <p>В отеле должен быть хотя бы 1 номер</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <p>Данный номер находится в бронировании</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        if (!empty($_POST['butSave']))
        {
            if (preg_match('/^\d+$/u', $_POST['number_of_guests']))
            {
                $id = $_POST['id'];
                $room = mysqli_real_escape_string($mysqli, $_POST['room']);
                $number_of_guests = $_POST['number_of_guests'];
                $id_comfort = $_POST['idcomfort'];
                $description = mysqli_real_escape_string($mysqli, $_POST['description']);

                if ($SELEC_comfort_rites  = $mysqli->query("SELECT * FROM `room_rates` WHERE '$id_comfort' = `id_comfort`")) 
                {
                    if(mysqli_num_rows($SELEC_comfort_rites) != 0)
                    {
                        $select_comfort = "SELECT *
                        FROM `room_comfort`, `set_of_equipment`
                        WHERE `room_comfort`.`id` = '$id_comfort' 
                        AND `id_comfort` = `room_comfort`.`id`";
                        if ($result2 = $mysqli->query($select_comfort))
                        {
                            $row2 = mysqli_num_rows($result2); //кол-во найденых строк 
                            if ($row2 > 0) 
                            {
                                $sql_UPDATE = "UPDATE `rooms` SET `room` = ?, `number_of_guests` = ?,`id_comfort` = ?, `description` = ? WHERE id = ?";
                                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                mysqli_stmt_bind_param($stmt_UPDATE, 'siisi', $room, $number_of_guests, $id_comfort, $description, $id);
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
                                                <p>Сохранение номера прошло успешно</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                <p>В выбраной комфотности не указано не одной услуги(добавте услуги в данную комфортность)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if($_FILES['file_img']['name'] != "")
                            {     
                                
                                $name = $_FILES["file_img"]["name"];
                                $sql_SELECT = "SELECT * FROM `photos_of_the_rooms` 
                                WHERE  `photo` = '$name' AND `id_room` = '$id'";
                                $select_set_of_equipment = $mysqli->query($sql_SELECT);

                                if(mysqli_num_rows($select_set_of_equipment) == 0)
                                {
                                    $tmp_name = $_FILES["file_img"]["tmp_name"];
                                    // basename() может предотвратить атаку на файловую систему;
                                    // может быть целесообразным дополнительно проверить имя файла
                                    $name = basename($_FILES["file_img"]["name"]);
                                    move_uploaded_file($tmp_name, "C:/xampp/htdocs/site_hotel/img/$name");

                                    $image= mysqli_real_escape_string($mysqli, $_FILES['file_img']['name']);
                                    
                                    $sql_INSERT = "INSERT INTO `photos_of_the_rooms` (`photo`, `id_room`) 
                                    VALUES (?, ?)";
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
                                                    <p>Добавлено новое фото</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <p>На данную комфортность не указана цена</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
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
                                <p>Неверный ввод кол-ва гостей в номере</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }             
        }
    if (
        ((!empty($_GET['room_selected']) && !empty($_GET['idroom'])) 
        || (!empty($_GET['room_selected']) && !empty($_GET['idroom']) && !empty($_GET['butSave']))
        || (!empty($_GET['room_selected']) && !empty($_GET['idroom']) && !empty($_GET['butDelImg']))
        || !empty($_GET['id_room']))
        && empty($_POST['SerAll']) && empty($_POST['butEditSer']) && empty($_POST['z']) 
        && empty($_POST['butDeletSer']) && empty($_POST['butADDSer']) && empty($_POST['form_addButSerRoom'])
        && empty($_GET['servise_room']) && empty($_GET['rooms_add']) && empty($_GET['servise_room']) 
        && empty($_POST['butSerRoom']) && empty($_POST['butEditSerRoom']) && empty($_POST['butAddRoom'])
        && empty($_POST['addButSerRoom']) && empty($_POST['butDeletSerRoom']) && empty($_GET['rooms_all'])
        && empty($_POST['search']) && empty($_POST['delsearch']) && empty($_POST['clinADDSer'])) 
    {
        if(!empty($_GET['hidden_el']))
        {
            ?> 
            <form method="post">
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <input class="hidden" type="hidden" name="hidden_el" id="hidden_el" value="0">
                        <div class="modal-header">
                            <span class="close">×</span>
                            <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                        </div>
                            <div class="modal-body">
                                <p>Номер успешно добавлен</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
    ?>
        <div class="room_edit">
        
                <?php
                if (!empty($_GET['idroom']))
                {
                    $id = $_GET['idroom'];
                }
                elseif (!empty($_GET['id_room'])){
                    $id = $_GET['id_room'];
                }
                if($id != 0)
                {
                    if ($result = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = $id"))  
                    {
                        if ($row = $result->fetch_assoc())
                        {
                            $room = $row['room']; //название номера
                            $number_of_guests = $row['number_of_guests']; //количество гостей
                            $description = $row['description']; //описание
                            $id_comfort  = $row['id_comfort']; //ид комфортности
                            $selec_comfort = "SELECT * FROM `rooms`, `room_comfort`  WHERE `rooms`.`id` = '$id' AND `room_comfort`.`id` = '$id_comfort'";
                            $RES_comfort = $mysqli->query($selec_comfort);
                            $ASSOC_comfort = $RES_comfort->fetch_assoc();
                            $comfort = $ASSOC_comfort['title_comfort'];
                        }
                    }
                    ?>
                    <div class="slideshow-container">
                    <?php
                    if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
                    {
                        $num = mysqli_num_rows($SELECT_photo);
                        if($num > 1)
                        {
                            ?>
                            <!-- Full-width images with number and caption text -->
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <?php
                                if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
                                {
                                    
                                    while($row_photo = $SELECT_photo->fetch_assoc())
                                    {
                                        ?>
                                        <form method="post">
                                            <div class="mySlides fade">
                                                <img class="img_room" src="img/<?=$row_photo['photo']?>">
                                                <input type="hidden" name="id_img"  id="id_img" value="<?= $row_photo['id'] ?>"><br>
                                                <input class="button" type="submit" name="butDelImg" id="butSave" value="Удалить фото" >
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                            ?>
            
            
                            <!-- Next and previous buttons -->
            
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>
                            </div>
                                <br>
                
                                <!-- The dots/circles -->
                            <div style="text-align:center">
                                <?php
                                if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
                                {
                                    $num = mysqli_num_rows($SELECT_photo);
                                    
                                }
                                for($i = 1; $i <= $num; $i++)
                                {
                                    ?>
                                    <span class="dot" onclick="currentSlide(<?=$i?>)"></span>
                                    <?php
                                }
                        }
                        else
                        { 
                            if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
                            {
                                
                                while($row_photo = $SELECT_photo->fetch_assoc())
                                {
                                    ?>
                                    <div class="mySlides fade">
                                        <img class="img_room" src="img/<?=$row_photo['photo']?>">
                                    </div>
                                    
                                    <?php
                                }
                            }
                            
                        }
                    }
                    ?>
                        
                    </div>
                    <!-- <?php
                        // if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
                        // {
                        //     while($row_photo = $SELECT_photo->fetch_assoc())
                        //     {
                    ?>
                                <img  class="img_room" src="img/<?=$row_photo['photo']?>">
                                <input type="hidden" name="id_img"  id="id_img" value="<?= $row_photo['id'] ?>">
                                <input class="button" type="submit" name="butDelImg" id="butSave" value="Удалить фото" >
                    <?php
                        //     }
                        // }
                    ?> -->
                    <br>
                    <form method="post" enctype="multipart/form-data">
                    <input class="_input" type="file" name="file_img" id="file_img"><br>
                    <div class="grid_res_info">
                        <div class="colum1_info">
                            <label for="room">Название:</label><br>
                            <input type="hidden" name="id"  id="id_room" value="<?= $id ?>">
                            <input class="_input" type="text" name="room" id="room" value="<?= $room ?>" required><br>
                            
                            <label for="number_of_guests">Количество гостей:</label><br>
                            <input class="_input" type="text" name="number_of_guests" id="number_of_guests" value="<?= $number_of_guests ?>" required><br>
                            
                            <label for="comfort">Комфортность:</label><br>
                            <select class="_input" name="idcomfort" id="idcomfort" >
                                <option value="<?=$id_comfort?>">
                                    <?=$comfort?>
                                </option>
                                <?php 
                                $sql_comfort = "SELECT *  FROM `room_comfort`";
                                if ($SELECT_max_id_comfort  = $mysqli->query($sql_comfort)) 
                                {
                                    while($row = $SELECT_max_id_comfort->fetch_assoc())
                                    {
                                        
                                            $id_comfort = $row['id'];
                                            $comfort = $row['title_comfort'];
                                    ?>
                                        <option value="<?=$id_comfort?>"  <?php if (!empty($_POST['in_room_services']) && $_POST['in_room_services'] == $i){echo "selected='selected'";} ?>>
                                            <?=$comfort?>
                                        </option>
                                <?php 
                                    }   	
                                }
                                ?>
                            </select><br>
                        </div>
                        <div>
                            <label for="description">Описание:</label><br>
                            <textarea name="description" id="description"  required><?= $description ?></textarea>
                        </div>
                        <br>
                    </div>
                    <input class="button" type="submit" name="butSave" id="butSave" value="Сохранить изменения" >
                    <input class="button" type="submit" name="butDelet_room" id="butDelet_room" value="Удалить номер" >
                <?php
                }
                ?>
            </form>
        </div>
    <?php
    }
}
require_once('footer.php');
?>
	
</body>
</html>
<script src="js/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function () {
        $("#live_search").keyup(function () {
            var room = $(this).val();
            if (room != "") {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: {
                        room: room
                    },
                    success: function (data) {
                        $('#search_result').html(data);
                        $('#live_search').val(room);
                        $('#search_result').css('display', 'block');
                        $("#live_search").focusin(function () {
                            $('#search_result').css('display', 'block');
                        });
                        
                    }
                });
            } else {
                $('#search_result').css('display', 'none');
            }
        });
        // $('#butSerRoom').click(function(){
        //     var room_service = $('#in_room_services :selected').val();
        //     $.ajax({
        //         url: 'search.php',
        //         method: 'POST',
        //         data: {
        //             room_service: room_service
        //         },
        //         success: function (data) {
        //             $('#content').html(data);
                    
        //         }
        //     });
        // });
        // $('#red_name').click(function(){
        //     let room_service = $('#id_room_service').val();
        //     let service_name = $('#service_name').val();
        //     $.ajax({
        //         url: 'search.php',
        //         method: 'POST',
        //         data: {
        //             id_room_service: id_room_service,
        //             service_name: service_name
        //         },
        //         success: function (data) {
        //             $('#content').append(data);
        //         }
        //     });
        // });
    });

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
    showSlides(slideIndex += n);
    }

    function currentSlide(n) {
    showSlides(slideIndex = n);
    }

    function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    }
</script>	
<script src="js/modalWindow.js"></script>
		