<?php
if (isset($_SESSION["user"]))
{
    $num_r = 0;
    if (!empty($_GET['row_kol']))
    {
        $kol_room = $_GET['row_kol'];
        // for ($i = 1; $i <= $_GET['row_kol']; $i++)
        // {
        //     if(!empty($_GET['id_room'.$i]))
        //     {
        //         echo $_GET['id_room'.$i];
        //         $num_r += 1;
        //     }
        // }
        // if(!empty($_GET['kol_room']))
        // {
        //     if ($_GET['kol_room'] >= $num_r)
        //     {
        //         $kol_room = $num_r;
        //     }
        
        // }
        
    }
    // else{
    //     $kol_room = 1;
    // }

    $check_in_date = $_GET['check_in_date'];
    $date_departure = $_GET['date_departure'];
    if (!empty($_POST['butArmor']))
    {	
        $date_1 = $_POST['check_in_date'];
        $date_2 = $_POST['date_departure'];
        if ($_GET['kol_room'] > 1)
        {
            $free_room = 0;
            for ($i = 1; $i <= $kol_room; $i++)
            {
                if (!empty($_POST['id_room'.$i]))
                {
                    $id = $_POST['id_room'.$i];
                    $selec_date_booking = "SELECT * FROM `rooms`, `booking`, `rooms_in_the_booking`  
                    WHERE `rooms`.`id` = '$id' 
                    AND `rooms`.`id` = `rooms_in_the_booking`.`id_room` 
                    AND `booking`.`id` = `rooms_in_the_booking`.`id_booking`";
                    $RES_date_booking = $mysqli->query($selec_date_booking);
                    $row_kol = mysqli_num_rows($RES_date_booking); //кол-во найденых строк 
                    if ($row_kol >= 1) //если номера есть в бронировании
                    {
                        $date_1 = $_POST['check_in_date'];
                        $date_2 = $_POST['date_departure'];
                        //проверка что б данный номер не занят на эту дату
                        while($ASSOC_date_booking = $RES_date_booking->fetch_assoc())
                        {
                            $date_Check = $ASSOC_date_booking['check_in_date'];
                            $query = $ASSOC_date_booking['number_of_nights'];
                            $query = '+ '.$query.' days';
                            $date_departure = date("Y-m-d", strtotime($date_Check.$query));
                            if ((($date_departure >= $date_1 && $date_Check <= $date_1)	|| ($date_departure >= $date_2 && $date_Check <= $date_2)) 
                            &&  $ASSOC_date_booking['id_status'] != 3)
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
                                            <p>На выбранный дипозон дат нельзя забронировать номер(а)</p>
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
            if($free_room == 0)
            {
                $check_in_date = mysqli_real_escape_string($mysqli, $date_1);
                $d1_ts = strtotime($date_1);
                $d2_ts = strtotime($date_2);
                $seconds = abs($d1_ts - $d2_ts);
                $days = floor($seconds / 86400);//кол-во найденных дней между датами
                $number_of_nights = mysqli_real_escape_string($mysqli, $days);
                $payment_method = mysqli_real_escape_string($mysqli, $_POST['payment_method']);
                if(!empty($_POST['add_user_id']))
                {
                    $id_user = $_POST['add_user_id'];

                }
                elseif(!empty($_POST['user_id']))
                {
                    $id_user = $_POST['user_id'];
                }
                else{
                    $id_user = $_SESSION["user"]['id'];                
                }
                $id_user = mysqli_real_escape_string($mysqli, $id_user);
                $booking_date = date("y.m.d");
                $status = 1;

                //добавление новой брони
                $sql_INSERT = "INSERT INTO `booking` (`id_payment_method`, `id_user`, `number_of_nights`, `check_in_date`, `booking_date`, `id_status`) 
                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                mysqli_stmt_bind_param($stmt_INSERT, 'sssssi', $payment_method, $id_user, $number_of_nights, $check_in_date, $booking_date, $status);
                mysqli_stmt_execute($stmt_INSERT);
                //находим ид добавленной новой брони
                $selec_id_date_booking = "SELECT `id` FROM `booking`  
                WHERE `id_user` = '$id_user'
                AND `check_in_date` = '$check_in_date'
                AND `booking_date` = '$booking_date'";
                $RES_id_date_booking = $mysqli->query($selec_id_date_booking);
                $ASSOC_id_date_booking = $RES_id_date_booking->fetch_assoc();
                $id_booking = $ASSOC_id_date_booking['id'];
                for ($i = 1; $i <= $kol_room; $i++)
                {
                    if (!empty($_POST['id_room'.$i]))
                    {
                        $id_room = $_POST["id_room".$i];
                        $id_room = mysqli_real_escape_string($mysqli, $id_room);
                        //добавление номеров в бронь
                        $sql_INSERT = "INSERT INTO `rooms_in_the_booking` (`id_booking`, `id_room`) 
                        VALUES (?, ?)";
                        $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                        mysqli_stmt_bind_param($stmt_INSERT, 'is', $id_booking, $id_room);
                        mysqli_stmt_execute($stmt_INSERT);
                    }
                }
                
                //вывод сообщения об бронировании
                ?>
                    <script type='text/javascript'>
                        alert('Вы забронировали');
                    </script>
                <?php
                ?>
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">×</span>
                        <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                    </div>
                        <div class="modal-body">
                            <p>Бронирование номера(ов) прошло успешно</p>
                        </div>
                    </div>

                </div>
                <script src="js/modalWindow.js"></script>
                <?php
                if(!empty($_POST['add_user_id']) || !empty($_POST['user_id']))
                {
                    $new_url = 'booking_table.php';
                    header('Location: '.$new_url);
                }
                else{
                    $new_url = 'profile.php';
                    header('Location: '.$new_url);
                }
            }
        }
        else{
            $id = $_POST['id_room'];
            $selec_date_booking = "SELECT * FROM `rooms`, `booking`, `rooms_in_the_booking`  
            WHERE `rooms`.`id` = '$id' 
            AND `rooms`.`id` = `rooms_in_the_booking`.`id_room` 
            AND `booking`.`id` = `rooms_in_the_booking`.`id_booking`";
            $RES_date_booking = $mysqli->query($selec_date_booking);
            $row_kol = mysqli_num_rows($RES_date_booking); //кол-во найденых строк 
            if ($_GET['kol_room'] >= 1) //если номера есть в бронировании
            {
                $date_1 = $_POST['check_in_date'];
                $date_2 = $_POST['date_departure'];
                $free_room = 0;
                //проверка что б данный номер не занят на эту дату
                while($ASSOC_date_booking = $RES_date_booking->fetch_assoc())
                {
                    $date_Check = $ASSOC_date_booking['check_in_date'];
                    $query = $ASSOC_date_booking['number_of_nights'];
                    $query = '+ '.$query.' days';
                    $date_departure = date("Y-m-d", strtotime($date_Check.$query));
                    if ((($date_departure >= $date_1 && $date_Check <= $date_1)	|| ($date_departure >= $date_2 && $date_Check <= $date_2)) 
                    &&  $ASSOC_date_booking['id_status'] != 3)
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
                                    <p>На выбранный дипозон дат нельзя забронировать номер(а)</p>
                                </div>
                            </div>

                        </div>
                        <script src="js/modalWindow.js"></script>
                        <?php
                    }
                }
                if($free_room == 0)
                {
                    $check_in_date = mysqli_real_escape_string($mysqli, $date_1);
                    $d1_ts = strtotime($date_1);
                    $d2_ts = strtotime($date_2);
                    $seconds = abs($d1_ts - $d2_ts);
                    $days = floor($seconds / 86400);//кол-во найденных дней между датами
                    $id_room = mysqli_real_escape_string($mysqli, $_POST['id_room']);
                    $number_of_nights = mysqli_real_escape_string($mysqli, $days);
                    $payment_method = mysqli_real_escape_string($mysqli, $_POST['payment_method']);
                    if(!empty($_POST['add_user_id']))
                    {
                        $id_user = $_POST['add_user_id'];

                    }
                    elseif(!empty($_POST['user_id']))
                    {
                        $id_user = $_POST['user_id'];
                    }
                    else{
                        $id_user = $_SESSION["user"]['id'];                
                    }
                    $id_user = mysqli_real_escape_string($mysqli, $id_user);
                    $booking_date = date("y.m.d");
                    $status = 1;
                    //добавление новой брони
                    $sql_INSERT = "INSERT INTO `booking` (`id_payment_method`, `id_user`, `number_of_nights`, `check_in_date`, `booking_date`, `id_status`) 
                    VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                    mysqli_stmt_bind_param($stmt_INSERT, 'sssssi', $payment_method, $id_user, $number_of_nights, $check_in_date, $booking_date, $status);
                    mysqli_stmt_execute($stmt_INSERT);
                    //находим ид добавленной новой брони
                    $selec_id_date_booking = "SELECT `id` FROM `booking`  
                    WHERE `id_user` = '$id_user'
                    AND `check_in_date` = '$check_in_date'
                    AND `booking_date` = '$booking_date'";
                    $RES_id_date_booking = $mysqli->query($selec_id_date_booking);
                    $ASSOC_id_date_booking = $RES_id_date_booking->fetch_assoc();
                    $id_booking = $ASSOC_id_date_booking['id'];
                    //добавление номеров в бронь
                    $sql_INSERT = "INSERT INTO `rooms_in_the_booking` (`id_booking`, `id_room`) 
                    VALUES (?, ?)";
                    $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                    mysqli_stmt_bind_param($stmt_INSERT, 'is', $id_booking, $id_room);
                    mysqli_stmt_execute($stmt_INSERT);
                    
                    //вывод сообщения об бронировании
                    ?>
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">×</span>
                            <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                        </div>
                            <div class="modal-body">
                                <p>Бронирование номера(ов) прошло успешно</p>
                            </div>
                        </div>

                    </div>
                    <script src="js/modalWindow.js"></script>
                    <?php
                    if(!empty($_POST['add_user_id']) || !empty($_POST['user_id']))
                    {
                        $new_url = 'booking_table.php';
                        header('Location: '.$new_url);
                    }
                    else{
                        $new_url = 'profile.php';
                        header('Location: '.$new_url);
                    }
                }
            }
            else{
                $check_in_date = mysqli_real_escape_string($mysqli, $date_1);
                $d1_ts = strtotime($date_1);
                $d2_ts = strtotime($date_2);
                $seconds = abs($d1_ts - $d2_ts);
                $days = floor($seconds / 86400);//кол-во найденных дней между датами
                $number_of_nights = mysqli_real_escape_string($mysqli, $days);
                $id_room = mysqli_real_escape_string($mysqli, $_POST['id_room']);
                $payment_method = mysqli_real_escape_string($mysqli, $_POST['payment_method']);
                if(!empty($_POST['add_user_id']))
                {
                    $id_user = $_POST['add_user_id'];

                }
                elseif(!empty($_POST['user_id']))
                {
                    $id_user = $_POST['user_id'];
                }
                else{
                    $id_user = $_SESSION["user"]['id'];                
                }
                $id_user = mysqli_real_escape_string($mysqli, $id_user);
                $booking_date = date("y.m.d");
                $status = 1;
                //добавление новой брони
                $sql_INSERT = "INSERT INTO `booking` (`id_payment_method`, `id_user`, `number_of_nights`, `check_in_date`, `booking_date`, `id_status`) 
                VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                mysqli_stmt_bind_param($stmt_INSERT, 'sssssi', $payment_method, $id_user, $number_of_nights, $check_in_date, $booking_date, $status);
                mysqli_stmt_execute($stmt_INSERT);
                //находим ид добавленной новой брони
                $selec_id_date_booking = "SELECT `id` FROM `booking`  
                WHERE `id_user` = '$id_user'
                AND `check_in_date` = '$check_in_date'
                AND `booking_date` = '$booking_date'";
                $RES_id_date_booking = $mysqli->query($selec_id_date_booking);
                $ASSOC_id_date_booking = $RES_id_date_booking->fetch_assoc();
                $id_booking = $ASSOC_id_date_booking['id'];
                //добавление номеров в бронь
                $sql_INSERT = "INSERT INTO `rooms_in_the_booking` (`id_booking`, `id_room`) 
                VALUES (?, ?)";
                $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                mysqli_stmt_bind_param($stmt_INSERT, 'is', $id_booking, $id_room);
                mysqli_stmt_execute($stmt_INSERT);
            
                //вывод сообщения об бронировании
                ?>
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">×</span>
                        <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                    </div>
                        <div class="modal-body">
                            <p>Бронирование номера(ов) прошло успешно</p>
                        </div>
                    </div>

                </div>
                <script src="js/modalWindow.js"></script>
                <?php
                if(!empty($_POST['add_user_id'])  || !empty($_POST['user_id']))
                {
                    $new_url = 'booking_table.php';
                    header('Location: '.$new_url);
                }
                else{
                    $new_url = 'profile.php';
                    header('Location: '.$new_url);
                }
                
            }
        }
    
    }
}
?>