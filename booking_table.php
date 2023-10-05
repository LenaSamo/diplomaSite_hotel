<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Бронирования</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css\modal.css">
    <link rel="shortcut icon" href="img/лого.png" type="image/png">
</head>
<?php
    require_once('connect.php');
    session_start();
    require_once('header.php');
    require_once('updating.php');
?>

<body>
    <?php
    if (isset($_SESSION["user"]) && ($_SESSION["user"]["id_right"] == 3 || $_SESSION["user"]["id_right"] == 4))
    {
        
        //сохранение брони
        if(!empty($_POST['saveBooking']))
        {
            $id = $_POST['idbooking'];
            $nowDate = Date("Y-m-d");
            $id_room = $_POST['room'];
            $idRoom_booking = $_POST['id_R_b'];
            $check_in_date = $_POST['check_in_date'];
            $booking_date = $_POST['booking_date'];
            $id_payment_method = $_POST['id_payment_method'];
            $number_of_nights = $_POST['number_of_nights'];
            $id_status = $_POST['status'];
            if ($_POST['check_in_date'] >= $_POST['booking_date'])
            {
                
                    $room = $_POST['room'];
                    $selec_date_booking = "SELECT * FROM `rooms`, `booking`, `rooms_in_the_booking`  
                                            WHERE `rooms`.`id` = '$id_room' 
                                            AND `rooms`.`id` = `rooms_in_the_booking`.`id_room` 
                                            AND `booking`.`id` = `rooms_in_the_booking`.`id_booking`
                                            AND `rooms_in_the_booking`.`id_booking` <> $id";
                    $RES_date_booking = $mysqli->query($selec_date_booking);

                    $row_kol = mysqli_num_rows($RES_date_booking); //кол-во найденых строк 
                    
                    
                    if ($row_kol >= 1) 
                    {
                        $date_1 = $_POST['check_in_date'];
                        $query = $_POST['number_of_nights'];
                        $query = '+ '.$query.' days';
                        $date_2 = date("Y-m-d", strtotime($date_1.$query));
                        
                        $free_room = 0;
                        while($ASSOC_date_booking = $RES_date_booking->fetch_assoc())
                        {
                            $date_Check = $ASSOC_date_booking['check_in_date'];
                            $query = $ASSOC_date_booking['number_of_nights'];
                            $query = '+ '.$query.' days';
                            $date_departure = date("Y-m-d", strtotime($date_Check.$query));

                            // echo $date_departure;
                            if (($date_departure >= $date_1 && $date_Check <= $date_1)	|| ($date_departure >= $date_2 && $date_Check <= $date_2))
                            {
                                $free_room++;
                                ?>
                                <div id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
                                    </div>
                                        <div class="modal-body">
                                            <p>Нельзя изменить даты в бронировании на выбранные</p>
                                        </div>
                                    </div>

                                </div>
                                <script src="js/modalWindow.js"></script>
                                <?php
                            }
                            
                        }
                        if($free_room == 0)
                        {
                            // ?>
                             <script type='text/javascript'>
                            //     alert($id_status);
                                
                            // </script>
                             <?php 
                            //сохранение информации в талице бронирование
                            $sql_UPDATE = "UPDATE `booking` SET `check_in_date` = ?,
                            `id_payment_method` = ?, `number_of_nights` = ?, `id_status` = ? WHERE `id` = ?";
                            $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                            mysqli_stmt_bind_param($stmt_UPDATE, 'siiis', 
                            $check_in_date, $id_payment_method, $number_of_nights,$id_status, $id);
                            mysqli_stmt_execute($stmt_UPDATE);
                            if(isset($_POST['paid_or_not']))
                            {
                                $paid_or_not = 1;
                                $sql_UPDATE = "UPDATE `booking` SET `paid_or_not` = ? WHERE `id` = ?";
                                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                mysqli_stmt_bind_param($stmt_UPDATE, 'is', $paid_or_not, $id);
                                mysqli_stmt_execute($stmt_UPDATE);
                            }
                            else{
                                $paid_or_not = 0;
                                $sql_UPDATE = "UPDATE `booking` SET `paid_or_not` = ? WHERE `id` = ?";
                                $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                                mysqli_stmt_bind_param($stmt_UPDATE, 'is', $paid_or_not, $id);
                                mysqli_stmt_execute($stmt_UPDATE);
                            }
                            //сохранение ид комнаты
                            $id_booking = $_POST['idbooking'];
                            $id_room = $_POST['room'];
                            
                            $sql_UPDATE = "UPDATE `rooms_in_the_booking` SET `id_room` = ? 
                                            WHERE `id_booking` = ? 
                                            AND `id` = '$idRoom_booking'";
                            $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                            
                            mysqli_stmt_bind_param($stmt_UPDATE, 'is', $id_room, $id);
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
                                        <p>Изменение в бронировании прошло успешно</p>
                                    </div>
                                </div>

                            </div>
                            <script src="js/modalWindow.js"></script>
                            <?php
                        }
                    }
                    else{
                        //сохранение информации в талице бронирование
                        $sql_UPDATE = "UPDATE `booking` SET `check_in_date` = ?,
                        `id_payment_method` = ?, `number_of_nights` = ?, `id_status` = ? WHERE `id` = ?";
                        $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                        mysqli_stmt_bind_param($stmt_UPDATE, 'siiis', 
                        $check_in_date, $id_payment_method, $number_of_nights,$id_status, $id);
                        mysqli_stmt_execute($stmt_UPDATE);
                        if(isset($_POST['paid_or_not']))
                        {
                            $paid_or_not = 1;
                            $sql_UPDATE = "UPDATE `booking` SET `paid_or_not` = ? WHERE `id` = ?";
                            $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                            mysqli_stmt_bind_param($stmt_UPDATE, 'is', $paid_or_not, $id);
                            mysqli_stmt_execute($stmt_UPDATE);
                        }
                        else{
                            $paid_or_not = 0;
                            $sql_UPDATE = "UPDATE `booking` SET `paid_or_not` = ? WHERE `id` = ?";
                            $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                            mysqli_stmt_bind_param($stmt_UPDATE, 'is', $paid_or_not, $id);
                            mysqli_stmt_execute($stmt_UPDATE);
                        }
                        //сохранение ид комнаты
                        $id_booking = $_POST['idbooking'];
                        $id_room = $_POST['room'];
                        
                        $sql_UPDATE = "UPDATE `rooms_in_the_booking` SET `id_room` = ? 
                                        WHERE `id_booking` = ? 
                                        AND `id` = '$idRoom_booking'";
                        $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                        
                        mysqli_stmt_bind_param($stmt_UPDATE, 'is', $id_room, $id);
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
                                    <p>Изменение в бронировании прошло успешно</p>
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
                            <p>Дата бронирования не может быть после даты заселения</p>
                        </div>
                    </div>

                </div>
                <script src="js/modalWindow.js"></script>
                <?php
            }
            
        
            
            //echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';            
        }
        //изменение статуса брони на завершенное 
        if(!empty($_POST['cancelBooking']))
        {
            $cancel = $_POST['idbooking'];

            if ($result2 = $mysqli->query("SELECT * FROM `booking` WHERE `id` = '$cancel'"))
            {
                $now_date = date("Y-m-d");
                $booking_row = $result2->fetch_assoc();
                if($booking_row['check_in_date'] <= $now_date 
                && $booking_row['id_status'] == 4)
                { 
                    $id_room = 2;
                    $sql_UPDATE = "UPDATE `booking` SET `id_status` = ? 
                                                WHERE `id` = ?";
                    $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                    mysqli_stmt_bind_param($stmt_UPDATE, 'is', $id_room, $cancel);
                    mysqli_stmt_execute($stmt_UPDATE); 

                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';

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
                                <p>На данный момент бронирование не активно</p>
                            </div>
                        </div>

                    </div>
                    <script src="js/modalWindow.js"></script>
                    <?php
                }
                
            }    
        }
        //удаление брони
        if(!empty($_POST['deleteBooking']))
        {
            $delet = $_POST['idbooking'];
            $room_id = $_POST['room'];
            $idRoom_booking = $_POST['id_R_b'];

            if ($result2 = $mysqli->query("SELECT * FROM `rooms_in_the_booking` WHERE `id_booking` = '$delet' AND `id` = '$idRoom_booking'"))
            {
                $mysqli->query("DELETE FROM `rooms_in_the_booking` WHERE `id_booking` = '$delet' AND `id_room` = '$room_id'");

                if ($result2 = $mysqli->query("SELECT * FROM `rooms_in_the_booking` WHERE `id_booking` = '$delet'")) 
                {
                    $row = mysqli_num_rows($result2); //кол-во найденых строк 
                
                    if ($row == 0) 
                    {
                            
                        $mysqli->query("DELETE FROM `booking` WHERE `id` = '$delet'");
                    }
                }
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
            }    
        }
    ?>
    <h1>Бронирования</h1>
    <form class="form_sub">
        <input type="submit" class="button_archive" name="all" value="Все">
        <input type="submit" class="button_archive" name="will" value="Будущие">
        <input type="submit" class="button_archive" name="activ" value="Активные">
        <input type="submit" class="button_archive" name="archive" value="Завершенные">
        <input type="submit" class="button_archive" name="cancelled" value="Отмененые">
    </form>
    <?php
    if(!empty($_GET['activ']))
    {
        ?>
        <form class="bloc_search_user">
            <div class="search" method="post">
                <input type="text" class="form-control" name="live_search" id="live_search" autocomplete="off"
                placeholder="Поиск брони">
                <div id="search_result"></div>
                <div id="search_select"></div>
            </div>
            <input class="button"  type="button" 
            onclick="location.href='booking_table.php?activ=Активные&live_search=&cancel_search=Отменить+поиск'" value="Отменить поиск"/>
        </form>
        <?php
        if(!empty($_GET['booking_id']))
        {
            ?>
            <div class="table_user_search">
                <form  method="post">
                    <table class="Table">
                        <tr class="nametr">
                            <th>Ид</th>
                            <th>Пользователь</th>
                            <th>Номер</th>
                            <th>Дата заселения</th>
                            <th>Кол-во ночей</th> 
                            <th>Дата бронирования</th>
                            <th>Способ оплаты</th>
                            <th>Статус брони</th>
                            <th>Оплачено</th>
                        </tr>  
                        <?php
                        $booking_id = $_GET['booking_id'];
                        if ($SELECT_booking = $mysqli->query("SELECT * FROM `rooms_in_the_booking`, `rooms`, `booking` 
                                                                        WHERE `id_room` = `rooms`.`id` 
                                                                        AND `id_booking` = `booking`.`id` 
                                                                        AND `id_status` = '4'
                                                                        AND `booking`.`id` = '$booking_id'"))
                        {
                            if($booking_row = $SELECT_booking->fetch_assoc())
                            {
                                //вывод инф из таблицы бронирование
                                $id_booking = $booking_row['id_booking'];
                                $result1 = $mysqli->query("SELECT * FROM `booking` WHERE `id` = $id_booking");
                                $row = $result1->fetch_assoc();

                                //вывод инф из таб пользователи
                                $id_user = $row['id_user'];
                                $SELECT_user = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$id_user'");
                                $user_row = $SELECT_user->fetch_assoc();

                                //вывод ид из таблицы номера в брони
                                $id_room = $booking_row['id_room'];
                                $sql_b = "SELECT `id` FROM `rooms_in_the_booking` WHERE `id_room` = '$id_room' AND `id_booking` = '$id_booking'";

                                $SELECT_booking = $mysqli->query($sql_b);

                                
                                ?>
                                <tr  class="tr_info">
                                    <form method="post">
                                        <td>
                                            <p class="_input" name="id"><?=$row['id'];?></p>
                                            <input type="hidden" name="idbooking" value="<?=$row['id'];?>">
                                            <input type="hidden" name="id_R_b" value="<?=$booking_row['id'];?>">
                                        </td>
                                        <td>
                                            <p class="_input" name="id_user"><?=$user_row['surname'];?></p> 
                                        </td>
                                        <td>
                                            <?php
                                            ?>
                                                <select name="room" class="_input">
                                                    <option value="<?=$booking_row['id_room']?>">
                                                        <?=$booking_row['room']?>
                                                    </option>
                                                    <?php 

                                                        if ($result2 = $mysqli->query("SELECT * FROM `rooms`")) 
                                                        {
                                                            while($row2 = $result2->fetch_assoc())
                                                            {
                                                                ?>
                                                                <option value="<?=$row2['id']?>">
                                                                    <?=$row2['room']?>
                                                                </option>
                                                            <?php  
                                                            }
                                                        }
                                                            
                                                    ?>
                                                </select> 
                                            <?php                               
                                            ?>                                  
                                        </td>
                                        <td>
                                            <input class="_input" type="date" name="check_in_date" value="<?=$row['check_in_date'];?>">
                                                
                                        </td>
                                        <td>
                                            <input class="_input num_nights" type="text" name="number_of_nights" value="<?=$row['number_of_nights'];?>" >
                                                
                                        </td>
                                        <td>
                                            <input class="_input" type="date" name="booking_date" value="<?=$row['booking_date'];?>" readonly="readonly">
                                                
                                        </td>
                                        <td>
                                            <?php
                                            $id_payment_method = $row['id_payment_method'];
                                            if ($SELECT_payment_method = $mysqli->query("SELECT * FROM `payment_method` WHERE `id` = $id_payment_method")) 
                                            {
                                                $row_payment_method = $SELECT_payment_method->fetch_assoc();
                                            ?>
                                                <select name="id_payment_method" class="_input">
                                                    <option value="<?=$row['id_payment_method'];?>">
                                                        <?=$row_payment_method['payment_method'];?>
                                                    </option>
                                                    <?php 

                                                        if ($result2 = $mysqli->query("SELECT * FROM `payment_method`")) 
                                                        {
                                                            while($row2 = $result2->fetch_assoc())
                                                            {
                                                                ?>
                                                                <option value="<?=$row2['id']?>">
                                                                    <?=$row2['payment_method']?>
                                                                </option>
                                                            <?php  
                                                            }
                                                        }
                                                            
                                                    ?>
                                                </select> 
                                            <?php
                                            }
                                            ?>   
                                        </td>
                                        <td>
                                            <?php
                                            $id_status = $booking_row['id_status'];
                                            $result1 = $mysqli->query("SELECT * FROM `booking_statuses` WHERE `id` = '$id_status'");
                                            $row_status = $result1->fetch_assoc();
                                            ?>
                                            <select name="status" class="_input">
                                                <option value="<?=$booking_row['id_status'];?>">
                                                    <?=$row_status['status'];?>
                                                </option>
                                                <?php 

                                                    if ($result2 = $mysqli->query("SELECT * FROM `booking_statuses`")) 
                                                    {
                                                        while($row2 = $result2->fetch_assoc())
                                                        {
                                                            ?>
                                                            <option value="<?=$row2['id']?>">
                                                                <?=$row2['status']?>
                                                            </option>
                                                        <?php  
                                                        }
                                                    }
                                                        
                                                ?>
                                            </select>     
                                        </td>
                                        <td>
                                            <?php
                                            if($row['paid_or_not'] == 1)
                                            {
                                            ?>
                                                <input class="_input" type="checkbox" name="paid_or_not" checked>
                                            <?php
                                            }
                                            else{
                                                ?>
                                                <input class="_input" type="checkbox" name="paid_or_not">
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <input type="submit" class="button" name="saveBooking" value="Сохранить">
                                        </td>
                                        
                                        <td>
                                            <input type="submit" class="button" name="cancelBooking" value="Завершить">  
                                        </td>
                                        <td>
                                            <input type="submit" class="button" name="deleteBooking" value="Удалить бронь номера">    
                                        </td>
                                    </form>
                                </tr><?php
                            }
                        }
                        ?>    
                    </table><br>
                </form>
            </div> 
            <?php
        }
        ?>
    <?php
    }
    ?>
    <div class="booking">
        <form  method="post">
            <input class="button_add"  type="button" value="Добавить" onclick="location.href='rooms.php'">
            <table class="Table">
                <tr class="nametr">
                    <th>Ид</th>
                    <th>Пользователь</th>
                    <th>Номер</th>
                    <th>Дата заселения</th>
                    <th>Кол-во ночей</th> 
                    <th>Дата бронирования</th>
                    <th>Способ оплаты</th>
                    <th>Статус брони</th>
                    <th>Оплачено</th>
                </tr>   
                <?php 
                
                $nowDate = Date("Y-m-d");
                ?>
                
                <?php
                if (!empty($_GET['will']) 
                || (!empty($_POST['addComfort']) && !empty($_GET['will']))  
                || (!empty($_POST['deleteComfort'])  && !empty($_GET['will'])))
                {
                    $sl_rooms_in_the_bookin = "SELECT * FROM `rooms_in_the_booking`, `rooms`, `booking` 
                                    WHERE `id_room` = `rooms`.`id` 
                                    AND `id_booking` = `booking`.`id` 
                                    AND `id_status` = '1'
                                    ORDER BY `booking`.`id` DESC";
                    ?>
                    <?php
                    

                }
                elseif (!empty($_GET['activ']) 
                || (!empty($_POST['addComfort']) && !empty($_GET['activ']))  
                || (!empty($_POST['deleteComfort'])  && !empty($_GET['activ'])))
                {
                    $sl_rooms_in_the_bookin = "SELECT * FROM `rooms_in_the_booking`, `rooms`, `booking` 
                                    WHERE `id_room` = `rooms`.`id` 
                                    AND `id_booking` = `booking`.`id` 
                                    AND `id_status` = '4'
                                    ORDER BY `booking`.`id` DESC";
                    ?>
                    <?php
                    

                }
                elseif (!empty($_GET['archive']) 
                || (!empty($_POST['addComfort']) && !empty($_GET['archive']))  
                || (!empty($_POST['deleteComfort'])  && !empty($_GET['archive'])))
                {
                    $sl_rooms_in_the_bookin = "SELECT * FROM `rooms_in_the_booking`, `rooms`, `booking` 
                                    WHERE `id_room` = `rooms`.`id` 
                                    AND `id_booking` = `booking`.`id` 
                                    AND `id_status` = '2'
                                    ORDER BY `booking`.`id` DESC";
                    ?>
                    <?php
                    

                }
                elseif (!empty($_GET['cancelled']) 
                || (!empty($_POST['addComfort']) && !empty($_GET['cancelled']))  
                || (!empty($_POST['deleteComfort'])  && !empty($_GET['cancelled'])))
                {
                    $sl_rooms_in_the_bookin = "SELECT * FROM `rooms_in_the_booking`, `rooms`, `booking` 
                                    WHERE `id_room` = `rooms`.`id` 
                                    AND `id_booking` = `booking`.`id` 
                                    AND `id_status` = '3'
                                    ORDER BY `booking`.`id` DESC";
                    ?>
                    <?php
                    

                }
                else{
                    $nowDate = Date("Y-m-d");
                    $sl_rooms_in_the_bookin = "SELECT * FROM `rooms_in_the_booking`, `rooms`, `booking` 
                                                WHERE `id_room` = `rooms`.`id` 
                                                AND `id_booking` = `booking`.`id` 
                                                ORDER BY `booking`.`id` DESC";
                }
                if ($SELECT_rooms_in_the_booking = $mysqli->query($sl_rooms_in_the_bookin))
                {
                    while($rooms_in_the_booking_row = $SELECT_rooms_in_the_booking->fetch_assoc())
                    {
                        //вывод инф из таблицы бронирование
                        $id_booking = $rooms_in_the_booking_row['id_booking'];
                        $result1 = $mysqli->query("SELECT * FROM `booking` WHERE `id` = $id_booking");
                        $row = $result1->fetch_assoc();

                        //вывод инф из таб пользователи
                        $id_user = $row['id_user'];
                        $SELECT_user = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$id_user'");
                        $user_row = $SELECT_user->fetch_assoc();

                        //вывод ид из таблицы номера в брони
                        $id_room = $rooms_in_the_booking_row['id_room'];
                        $sql_b = "SELECT `id` FROM `rooms_in_the_booking` WHERE `id_room` = '$id_room' AND `id_booking` = '$id_booking'";

                        $SELECT_booking = $mysqli->query($sql_b);

                        $booking_row = $SELECT_booking->fetch_assoc();
                        ?>
                        <tr  class="tr_info">
                            <form method="post">
                                <td>
                                    <p class="_input" name="id"><?=$row['id'];?></p>
                                    <input type="hidden" name="idbooking" value="<?=$row['id'];?>">
                                    <input type="hidden" name="id_R_b" value="<?=$booking_row['id'];?>">
                                </td>
                                <td>
                                    <p class="_input" name="id_user"><?=$user_row['surname'];?></p> 
                                </td>
                                <td>
                                    <?php
                                    ?>
                                        <select name="room" class="_input">
                                            <option value="<?=$rooms_in_the_booking_row['id_room'];?>">
                                                <?=$rooms_in_the_booking_row['room'];?>
                                            </option>
                                            <?php 

                                                if ($result2 = $mysqli->query("SELECT * FROM `rooms`")) 
                                                {
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        ?>
                                                        <option value="<?=$row2['id']?>">
                                                            <?=$row2['room']?>
                                                        </option>
                                                    <?php  
                                                    }
                                                }
                                                    
                                            ?>
                                        </select> 
                                    <?php                               
                                    ?>                                  
                                </td>
                                <td>
                                    <input class="_input" type="date" name="check_in_date" value="<?=$row['check_in_date'];?>">
                                        
                                </td>
                                <td>
                                    <input class="_input num_nights" type="text" name="number_of_nights" value="<?=$row['number_of_nights'];?>" >
                                        
                                </td>
                                <td>
                                    <input class="_input" type="date" name="booking_date" value="<?=$row['booking_date'];?>" readonly="readonly">
                                        
                                </td>
                                <td>
                                    <?php
                                    $id_payment_method = $row['id_payment_method'];
                                    if ($SELECT_payment_method = $mysqli->query("SELECT * FROM `payment_method` WHERE `id` = $id_payment_method")) 
                                    {
                                        $row_payment_method = $SELECT_payment_method->fetch_assoc();
                                    ?>
                                        <select name="id_payment_method" class="_input">
                                            <option value="<?=$row['id_payment_method'];?>">
                                                <?=$row_payment_method['payment_method'];?>
                                            </option>
                                            <?php 

                                                if ($result2 = $mysqli->query("SELECT * FROM `payment_method`")) 
                                                {
                                                    while($row2 = $result2->fetch_assoc())
                                                    {
                                                        ?>
                                                        <option value="<?=$row2['id']?>">
                                                            <?=$row2['payment_method']?>
                                                        </option>
                                                    <?php  
                                                    }
                                                }
                                                    
                                            ?>
                                        </select> 
                                    <?php
                                    }
                                    ?>   
                                </td>
                                <td>
                                    <?php
                                    $id_status = $rooms_in_the_booking_row['id_status'];
                                    $result1 = $mysqli->query("SELECT * FROM `booking_statuses` WHERE `id` = '$id_status'");
                                    $row_status = $result1->fetch_assoc();
                                    ?>
                                    <select name="status" class="_input">
                                        <option value="<?=$rooms_in_the_booking_row['id_status'];?>">
                                            <?=$row_status['status'];?>
                                        </option>
                                        <?php 

                                            if ($result2 = $mysqli->query("SELECT * FROM `booking_statuses`")) 
                                            {
                                                while($row2 = $result2->fetch_assoc())
                                                {
                                                    ?>
                                                    <option value="<?=$row2['id']?>">
                                                        <?=$row2['status']?>
                                                    </option>
                                                <?php  
                                                }
                                            }
                                                
                                        ?>
                                    </select>     
                                </td>
                                <td>
                                    <?php
                                    if($row['paid_or_not'] == 1)
                                    {
                                    ?>
                                        <input class="_input" type="checkbox" name="paid_or_not" checked>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <input class="_input" type="checkbox" name="paid_or_not">
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <input type="submit" class="button" name="saveBooking" value="Сохранить">
                                </td>
                                <?php
                                if(!empty($_GET['activ']))
                                {
                                    ?>
                                    <td>
                                        <input type="submit" class="button" name="cancelBooking" value="Завершить">  
                                    </td>
                                    <?php
                                }
                                ?>
                                
                                <td>
                                    <input type="submit" class="button" name="deleteBooking" value="Удалить бронь номера">    
                                </td>
                            </form>
                        </tr>
                        <?php

                    }
                }
                ?>    
            </table><br>
        </form>
    </div>
    <?php
    }
    else {
        header ('Location: sign_in.php');
    }
    require_once('footer.php');

	?>
    <script src="js/jquery-3.6.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#live_search").keyup(function () {
                var query_booking = $(this).val();
                if (query_booking != "") {
                    $.ajax({
                        url: 'search.php',
                        method: 'POST',
                        data: {
                            query_booking: query_booking
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