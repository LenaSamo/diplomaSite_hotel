<?php
if (isset($_SESSION["user"]))
{
require_once('add_booking.php');

?>
<div class="home">
    <form method="post">
        <h1>Бронь</h1>
        <!-- добавить кнопку назад -->
        <?php
            if(!empty($_GET['user']))
            {
            ?>
                <div class="user">
                    <p>Пользователь</p>
                    <input type="hidden" name="user_id" id="user_id" value="<?=$_GET['user']?>" readonly="readonly">
                    <?php
                    $user_id = $_GET['user'];
                    $select_room = $mysqli->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
                    $row_room = $select_room->fetch_assoc();
                    ?>
                    <input type="text" name="name_user" id="name_user" value="<?=$row_room['surname']?> <?=$row_room['name']?> <?=$row_room['patronymic']?>" readonly="readonly">
                </div>
            <?php 
            }
            else if (isset($_SESSION["user"]) && ($_SESSION["user"]["id_right"] == 3 || $_SESSION["user"]["id_right"] == 4))
            {             
            ?>
                <div class="add" >
                    
                        <div class="user">
                            <h3>Пользователь:</h3>
                            <div class="radio_input">                       
                                <input type="radio" id="user_radio_input" name="user_radio_input" value="user_log" checked="checked" <?php
                                    if (!empty($_POST['user_radio_input']) && $_POST['user_radio_input'] === 'user_log') {
                                        echo 'checked';
                                    }
                                ?>>
                                <label for="user_radio_input">Пользователь уже зарегистрирован</label><br>

                                <input type="radio" id="user_radio_input" name="user_radio_input" value="user_reg" <?php
                                    if (!empty($_POST['user_radio_input']) && $_POST['user_radio_input'] === 'user_reg') {
                                        echo 'checked';
                                    }
                                ?>>
                                <label for="user_radio_input">Пользователя нет в системе</label><br>
                            </div>
                            <input type="submit" name="user_sub" id="user_sub" value="Подтвердить" formnovalidate/><br> 
                        </div>    
                          
                    <?php
                            
                            if(!empty($_POST['user_radio_input']))
                            {
                                if($_POST['user_radio_input'] == 'user_log' && !empty($_POST['user_sub']))
                                {   
                                    if (isset($_POST['user_selected'])) 
                                    {
                                        echo "<input type='submit' name='user_selected' value=".$res["name"]." ".$res["surname"]." ".$res["patronymic"]." /><br>";
                                    }
                                ?>        
                                    <div class="search" method="post">
                                        <input type="text" class="form-control" name="live_search" id="live_search" autocomplete="off"
                                        placeholder="Поиск пользователя">
                                        <div id="search_result"></div>
                                        <div id="search_select"></div>
                                    </div>
                                <?php        
                                }
                                else if($_POST['user_radio_input'] == 'user_reg' && !empty($_POST['user_sub']))
                                {
                                    ?>
                                    <div class="toComeIn_Register" name="RegisterForm">									
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

                                            
                                            <input class="button" type="submit" id="Register_Person" name="Register_Person" value="Зарегистрироваться">
                                        </div>  
                                    </div>
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
                                <div id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
                                    </div>
                                        <div class="modal-body">
                                            <p>Данный пользователь уже существует</p>
                                        </div>
                                    </div>

                                </div>
                                <script src="js/modalWindow.js"></script>
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
                                <div id="myModal" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                    </div>
                                        <div class="modal-body">
                                            <p>Регистрирование нового пользователя прошло успешно</p>
                                        </div>
                                    </div>

                                </div>
                                <script src="js/modalWindow.js"></script>
                                
                                    <div class="add_user_id">
                                        <h3 for="user">Пользователь: </h3>
                                        <input type="hidden" name="add_user_id" id="add_user_id" value="<?=$user_id?>" readonly>
                                        <input type="text" name="user" id="user" 
                                        value="<?=$ASSOC_comfort['surname']?> <?=$ASSOC_comfort['name']?> <?=$ASSOC_comfort['patronymic']?>" readonly><br>
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
                                        <p>Информация введена неверно</p>
                                    </div>
                                </div>

                            </div>
                            <script src="js/modalWindow.js"></script>
                            <?php
                        }



                    }
            }
            if(!empty($_POST['user_id']))
            {
                ?>
                    <div class="add_user_id">
                        <h3 for="user">Пользователь: </h3>
                        <input type="hidden" name="add_user_id" id="user_id" value="<?=$_POST['user_id']?>" readonly>
                        <input type="text" name="user" id="user" value="<?=$_POST['user_selected']?>" readonly><br>
                    </div> 
                <?php
            }
            //переменные для подсчета суммы номера и общей суммы всех номеров
            $allPrise = 0;
            $price = 1;
            $d1_ts = strtotime($check_in_date);
            $d2_ts = strtotime($date_departure);
            $seconds = abs($d1_ts - $d2_ts);
            $days = floor($seconds / 86400);//кол-во найденных дней между датами
            ?>
            <div class="date_armor">
                <p class="input_date">
                <input class="_input"  type="date" id="check_in_date" name="check_in_date" required value="<?=$check_in_date?>" readonly="readonly">
                —
                <input class="_input"  type="date" name="date_departure" required value="<?=$date_departure?>" readonly="readonly">
                </p>
            </div>
            <?php
            if ($_GET['kol_room'] > 1)
            {
                ?>
                <div class="rooms_armor">
                    <h3>Номера</h3>
                <?php
                
                for ($i = 1; $i <= $kol_room; $i++)
                {
                    if(!empty($_GET['id_room'.$i]))
                    {
                        $id = $_GET['id_room'.$i];
                        $select_room = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = '$id'");
                        $row_room = $select_room->fetch_assoc();
                        ?>
                        
                            <div class="room_prise">
                                <input type="text" name="room_title" id="room_title" value="<?=$row_room['room']?>" readonly="readonly">
                                <input type="hidden" name="id_room<?=$i?>" id="id_room<?=$i?>" value="<?=$id?>">
                                <?php
                                
                                //находим ид комфортности
                                $select_room = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = '$id'");
                                $row_room = $select_room->fetch_assoc();
                                $id_comfort = $row_room['id_comfort'];
                                //находим цену номера по комфортности
                                $select_rites = $mysqli->query("SELECT * FROM `room_rates` 
                                WHERE `id_comfort` = '$id_comfort' AND `price_date` <= '$check_in_date' ORDER BY `price_date` DESC");
                               
                                $row_rites = $select_rites->fetch_assoc();
                                $price = $row_rites['price'];
                                $price *= $days;
                                $allPrise += $price;
                                ?>
                                <p>Стоимость номера: <?=$price?>&#8381</p>
                            </div>
                    <?php
                    }
                }
                ?>
                </div>
                <?php
            }
            else{
                $id = $_GET['id_room'];
                $select_room = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = '$id'");
                $row_room = $select_room->fetch_assoc();
                ?>
                <div class="rooms_armor">
                    <h3>Номер</h3>
                    <div class="room_prise">
                        <input type="text" name="room_title" id="room_title" value="<?=$row_room['room']?>" readonly="readonly">
                        <input type="hidden" name="id_room" id="id_room" value="<?=$id?>">
                        <?php
                        $id = $_GET['id_room'];
                        $select_room = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = '$id'");
                        $row_room = $select_room->fetch_assoc();
                        $id_comfort = $row_room['id_comfort'];
                        //находим цену номера по комфортности
                        $select_rites = $mysqli->query("SELECT * FROM `room_rates` WHERE `id_comfort` = '$id_comfort'  
                        AND `price_date` <= '$check_in_date'  ORDER BY `price_date` DESC");
                        $row_rites = $select_rites->fetch_assoc();
                        $price = $row_rites['price'];
                        $price *= $days;//расчет цены за 1 номер
                        $allPrise += $price;//расчет общей цены 
                        ?>
                        <p>Стоимость номера: <?=$price?>&#8381</p>
                    </div>
                </div>
            <?php
            }
                ?>
                
                
                <div class="prise">
                    <p>Общая стоимость: <?=$allPrise?>&#8381</p>
                </div>
                <div class="payment_method_armor">
                    <h3>Способ оплаты</h3>
                    
                    <select name="payment_method" class="payment_method">
                        <?php 
                            if ($result2 = $mysqli->query("SELECT * FROM `payment_method`")) 
                            {
                                if($row2 = $result2->fetch_assoc())
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
                </div><br>
                <input type="submit" name="butArmor" id="butArmor" value="Забронировать">
                <input class="button"  type="button" onclick="location.href='armor.php'" value="Отмена брони"/>
    </form>
</div>
<?php
}
?>
<script src="js/jquery-3.6.4.min.js"></script>
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
<?php