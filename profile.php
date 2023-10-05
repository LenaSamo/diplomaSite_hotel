
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Профиль</title>
    <link rel="stylesheet" href="css\profile.css">
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
if (isset($_SESSION["user"]))
{
    ?>
    <form id="form_profile" method="POST">
        <div class="user_profile">
            <div class="info_and_button">
                <?php 
                    if($_SESSION['user']['email'] != "")
                    {
                        ?>
                        <div class="user_info">
                            <h2>Добро пожаловать, <?= $_SESSION['user']['name']?> <?= $_SESSION['user']['patronymic'];?></h2>
                            
                            <p>Email: <?= $_SESSION['user']['email'] ?></p>
                
                            <p>Телефон: <?= $_SESSION['user']['phone'] ?></p>

                        </div>
                        <input class="button"  type="button" onclick="location.href='edit_profile.php'" value="Редактировать профиль"/>
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
                <input class="button"  type="button" onclick="location.href='logout.php'" value="Выйти"/>
            </div>
            <div class="bookings">
                <?php
                if(!empty($_POST['saveNewDateBooking']))
                {
                    $id = $_POST['idbooking'];
                    $check_in_date = $_POST['check_in_date'];
                    $date_departure = $_POST['date_departure'];
                    if ($SELECT_id_booking  = $mysqli->query("SELECT * FROM `booking` , `rooms_in_the_booking`  
                    WHERE `booking`.`id` = '$id' AND `id_booking` = `booking`.`id`")) 
					{
						while($row_id_booking = $SELECT_id_booking->fetch_assoc())
						{
                            $id_room = $row_id_booking['id_room'];
                            $res2 = "SELECT *
                            FROM `booking`, `rooms_in_the_booking`
                            WHERE
                            NOT (`booking`.`id` = '$id')
                            AND ( 
                                (ADDDATE( `check_in_date`, `number_of_nights` ) >= '$check_in_date' 
                                AND `check_in_date` <= '$date_departure') 
                                OR (ADDDATE( `check_in_date`, `number_of_nights` ) >= '$date_departure' 
                                    AND `check_in_date` <= '$check_in_date' )
                            )
                            AND NOT (`id_status` = 3)  AND `id_booking` = `booking`.`id` AND `id_room` = '$id_room'";
                            if ($result2 = $mysqli->query($res2))
                            {
                                $row2 = mysqli_num_rows($result2); //кол-во найденых строк 
                                if ($row2 == 0) 
                                {
                                    $d1_ts = strtotime($check_in_date);
                                    $d2_ts = strtotime($date_departure);
                                    $seconds = abs($d1_ts - $d2_ts);
                                    $days = floor($seconds / 86400);//кол-во найденных дней между датами
        
                                    $res_update = "UPDATE `booking` 
                                    SET `number_of_nights`='$days',`check_in_date`='$check_in_date' WHERE `id` = '$id'";
                                    $mysqli->query($res_update);
                                    ?>
                                    <div id="myModal" class="modal">
                                        <!-- Modal content -->
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="close">×</span>
                                            <span><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></span>
                                        </div>
                                            <div class="modal-body">
                                                <p>Изменение дат в бронировании прошло успешно</p>
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
                                                <p>Нельзя изменить даты в бронировании на выбранные(номера в это время заняты)</p>
                                            </div>
                                        </div>
        
                                    </div>
                                    <script >
                                        // Get the modal
                                        var modal = document.getElementById('myModal');

                                        // Get the <span> element that closes the modal
                                        var span = document.getElementsByClassName("close")[0];

                                        // When the user clicks the button, open the modal 
                                        modal.style.display = "block";

                                        // When the user clicks on <span> (x), close the modal
                                        span.onclick = function() {
                                            modal.style.display = "none";
                                            window.location.href = 'profile.php';
                                        }

                                        // When the user clicks anywhere outside of the modal, close it
                                        window.onclick = function(event) {
                                            if (event.target == modal) {
                                                modal.style.display = "none";
                                                window.location.href = 'profile.php';
                                            }
                                        }
                                        if($('#myModal').css('display') !== 'none')
                                        {
                                            document.getElementById('#hidden_el').value = 1;
                                        }
                                    </script>
                                    <?php

                                }
                            }
                        }
                    }
                   
                   
                }
                if(!empty($_POST['deleteBooking']))
                {
                    $delet = $_POST['idbooking'];
                    $idRoom_booking = $_POST['id_R_b'];
                
                    if ($result1 = $mysqli->query("SELECT * FROM `rooms_in_the_booking` WHERE `id_booking` = '$delet'"))
                    {     
                        while($rooms_in_the_booking_row = $result1->fetch_assoc())
                        {
                            $room_id = $rooms_in_the_booking_row['id_room'];
                            $mysqli->query("DELETE FROM `rooms_in_the_booking` WHERE `id_booking` = '$delet' AND `id_room` = '$room_id'");
                        }

                        if ($result2 = $mysqli->query("SELECT * FROM `set_of_services` WHERE `id_booking` = '$delet'"))
                        {     
                            while($service_row = $result2->fetch_assoc())
                            {
                                $service_id = $service_row['id_services'];
                                $mysqli->query("DELETE FROM `set_of_services` WHERE `id_booking` = '$delet' AND `id_services` = '$service_id'");
                            }
                            if ($result2 = $mysqli->query("SELECT * FROM `rooms_in_the_booking` WHERE `id_booking` = '$delet'")) 
                            {
                                $row = mysqli_num_rows($result2); //кол-во найденых строк 
                            
                                if ($row == 0) 
                                {       
                                    if ($result2 = $mysqli->query("SELECT * FROM `set_of_services` WHERE `id_booking` = '$delet'")) 
                                    {
                                        $row = mysqli_num_rows($result2); //кол-во найденых строк 
                                    
                                        if ($row == 0) 
                                        {        
                                            $mysqli->query("DELETE FROM `booking` WHERE `id` = '$delet'");
                                            ?>
                                            <div id="myModal" class="modal">
                                                <!-- Modal content -->
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <span class="close">×</span>
                                                    <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                                </div>
                                                    <div class="modal-body">
                                                        <p>Удаление бронирования прошло успешно</p>
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
                        
                    }   
                    
                }
                ?>
                <h3>Ваши бронирования</h3>
                <?php
                $id_user = $_SESSION['user']['id'];

                if ($SELECT_rooms_in_the_booking = $mysqli->query("SELECT *
                                                                FROM `booking`
                                                                WHERE `id_user` = '$id_user'
                                                                ORDER BY `id` DESC"))
                {
                    if(mysqli_num_rows($SELECT_rooms_in_the_booking) > 0)
                    {
                        while($rooms_in_the_booking_row = $SELECT_rooms_in_the_booking->fetch_assoc())
                        {
                            
                            //вывод инф из таблицы бронирование
                            $id_booking = $rooms_in_the_booking_row['id'];
                            $result1 = $mysqli->query("SELECT * FROM `booking` WHERE `id` = $id_booking");
                            $row = $result1->fetch_assoc();
                            
                            //вывод ид из таблицы номера в брони
                            $sql_b = "SELECT `id` FROM `rooms_in_the_booking` WHERE `id_booking` = '$id_booking'";
                            $SELECT_booking = $mysqli->query($sql_b);
                            $booking_row = $SELECT_booking->fetch_assoc();

                            //нахождение даты выселения из номера
                            $nowDate = Date("Y-m-d");
                            $date_departure = $row['check_in_date'];
                            $query = $row['number_of_nights'];
                            $query = '+ '.$query.' days';
                            $date_departure = date("Y-m-d", strtotime($date_departure.$query));
                        ?>
                        <form method="post">  
                            <div class="booking_info">
                                <div>
                                    <input type="hidden" name="idbooking" value="<?=$row['id']?>"> 
                                    <input type="hidden" name="id_R_b" value="<?=$booking_row['id']?>"> 
                                    <?php
                                    if ($row['check_in_date'] >= $nowDate)
                                    {
                                    ?>
                                        <p class="input_date">
                                            <input class="_input"  type="date" name="check_in_date" value="<?=$row['check_in_date'];?>">
                                            —
                                            <input class="_input" type="date" name="date_departure" value="<?=$date_departure;?>">
                                        </p>
                                        <input type="submit" class="button" name="saveNewDateBooking" id="saveNewDateBooking" value="Изменить даты бронирования"> 
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <p class="input_date">
                                            <input class="_input"  type="date" name="check_in_date" value="<?=$row['check_in_date'];?>" readonly>
                                            —
                                            <input class="_input" type="date" name="date_departure" value="<?=$date_departure;?>" readonly>
                                        </p>
                                    <?php
                                    }
                                    ?>
                                    
                                    
                                </div>                                                
                                
                                <div class="div_room">
                                    <h4>Номера:</h4>
                                <?php
                                if ($SELECT_set_of_services = $mysqli->query("SELECT `rooms`.id , room
                                                                            FROM `rooms_in_the_booking`, `rooms`, `booking`
                                                                            WHERE `id_room` = `rooms`.`id` 
                                                                            AND `id_booking` = `booking`.`id` 
                                                                            AND `id_booking` = '$id_booking'
                                                                            AND `id_user` = '$id_user' "))
                                {
                                    if(mysqli_num_rows($SELECT_set_of_services)){
                                        while($set_of_services_row = $SELECT_set_of_services->fetch_assoc())
                                        {
                                    ?>        
                                            <a class="p" href = "room.php?but_profile=1&id_room=<?=$set_of_services_row['id']?>&button_room=Подробнее">
                                            <?=$set_of_services_row['room']?></a><br>
                                            
                                    <?php
                                        }    
                                    }
                                    else{
                                        ?>
                                        <p>Номер(а) в данный момент отсутсвует(ют)</p>
                                        <?php
                                    }
                                }     
                                ?>                                               
                                </div>
                                <?php
                                // if ($SELECT_set_of_services = $mysqli->query("SELECT *
                                //                                                     FROM `set_of_services`, `services`, `booking`
                                //                                                     WHERE `id_services` = `services`.`id` 
                                //                                                     AND `id_booking` = `booking`.`id` 
                                //                                                     AND `id_booking` = '$id_booking'
                                //                                                     AND `id_user` = '$id_user' "))
                                // {
                                //     $row2 = mysqli_num_rows($SELECT_set_of_services); //кол-во найденых строк 
                                //     if ($row2 > 0) 
                                //     {
                                //         ?>
                                <!-- //         <p>Услуги отеля:</p> -->
                                     <?php
                                //         while($set_of_services_row = $SELECT_set_of_services->fetch_assoc())
                                //         {
                                //     ?>        
                                <!-- //             <p><?=$set_of_services_row['title'];?></p> -->
                                    <?php
                                //         }  
                                //     }  
                                // }     
                                ?>                                               
                                <?php
                                $id_payment_method = $row['id_payment_method'];
                                if ($SELECT_payment_method = $mysqli->query("SELECT * FROM `payment_method` WHERE `id` = $id_payment_method")) 
                                {
                                    $row_payment_method = $SELECT_payment_method->fetch_assoc();
                                    ?>
                                    <p>Оплата: <?=$row_payment_method['payment_method']?></p>
                            
                                <?php
                                }
                                ?>
                                <?php
                                    if ($row['check_in_date'] >= $nowDate)
                                    {
                                    ?>
                                        <input type="submit" class="button" name="deleteBooking" value="Отменить бронь"> 
                                    <?php
                                    }
                                ?>
                            </div> 
                        </form>      
                        <?php
                        }    
                    }
                    else{
                    ?>
                        <p>У вас пока нет бронирований</p>
                    <?php
                    }
                }   
                ?>
                <?php
                
            ?>  
            </div>
        </div>   
        
    <?php
}
		require_once('footer.php');
	?>
</body>
</html>