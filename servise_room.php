<?php

if (!empty($_GET['servise_room']) || !empty($_POST['butSerRoom']) 
|| !empty($_POST['butEditSerRoom']) || !empty($_POST['addButSerRoom']) 
|| !empty($_POST['form_addButSerRoom']) || !empty($_POST['butDeletSerRoom'])
|| !empty($_POST['SerAll']) || !empty($_POST['z']) || !empty($_POST['butEditSer']) 
|| !empty($_POST['butDeletSer']) || !empty($_POST['butADDSer'])
|| !empty($_POST['clinADDSer']))
{   
    
    ?>
    <form method="post" class="room_services">
        <h2>Услуги по комфортности в номерах:</h2>
        <input class="button" type="submit" name="addButSerRoom" id="addButSerRoom" value="Добавить комфортность" formnovalidate>
        <input class="button" type="submit" name="SerAll" id="SerAll" value="Все услуги" formnovalidate>
        <?php
        if(!empty($_POST['SerAll']) || !empty($_POST['butEditSer'])  || !empty($_POST['addButSerRoom'])
        || !empty($_POST['butDeletSer']) || !empty($_POST['butADDSer']) || !empty($_POST['clinADDSer']) || !empty($_POST['form_addButSerRoom']))
        {
            ?>
            <input class="button" type="submit" name="z" id="z" value="Обратно к выбору комфортности" formnovalidate>
            <?php
        }
        //добавление комфортности 
        if(!empty($_POST['form_addButSerRoom']))
        {
            if ($_POST['addSerRoom'] != "")
            {
                if (preg_match('/^\d+$/u', $_POST['addSerPrice']))
                {
                    $addSerRoom = $_POST['addSerRoom'];
                    $addSerPrice = $_POST['addSerPrice'];
                    $sql_comfort = "SELECT * FROM `room_comfort` WHERE `title_comfort` = '$addSerRoom'";
                    $select = $mysqli->query($sql_comfort);
                    if(mysqli_num_rows($select) == 0)
                    {
                        $addSerRoom = mysqli_real_escape_string($mysqli, $addSerRoom);
                        $sql_INSERT = "INSERT INTO `room_comfort` (`title_comfort`) 
                        VALUES (?)";
                        $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                        mysqli_stmt_bind_param($stmt_INSERT, 's', $addSerRoom);
                        mysqli_stmt_execute($stmt_INSERT);
                        
                        $sql_comfort = "SELECT * FROM `room_comfort` WHERE `title_comfort` = '$addSerRoom'";
                        $select = $mysqli->query($sql_comfort);
                        $row_comfort = $select->fetch_assoc();
                        $id_com = $row_comfort['id'];

                        $date = DATE("Y-m-d");
                        $addSerRoom = mysqli_real_escape_string($mysqli, $addSerRoom);
                        $sql_INSERT = "INSERT INTO `room_rates` (`price`, `price_date`, `id_comfort`) 
                        VALUES (?, ?, ?)";
                        $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                        mysqli_stmt_bind_param($stmt_INSERT, 'isi', $addSerPrice, $date, $id_com);
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
                                        <p>Добавлена комфорность</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $_POST['addSerRoom'] = "";
                        $_POST['addSerPrice'] = "";
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
                                        <p>Данная комфорность уже существует</p>
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
                                    <p>Поле с ценой комфорности должно быть положительм числом</p>
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
                                <p>Поле с названием комфорности не должно быть пустым</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            
        }
        if(!empty($_POST['butDeletSerRoom']) && $_POST['in_room_services'] != 'net')
        {
            $sql_comfort = "SELECT * FROM `room_comfort`";
            $select = $mysqli->query($sql_comfort);
            if(mysqli_num_rows($select) > 1)
            {
                $Delet_in_room_services = $_POST['in_room_services'];
                $sql_comfort = "SELECT * FROM `room_comfort`,`rooms` 
                WHERE `room_comfort`.`id` = `id_comfort` AND `room_comfort`.`id` = '$Delet_in_room_services'";
                $select = $mysqli->query($sql_comfort);
                if(mysqli_num_rows($select) == 0)
                {
                    $sql_delet_comfort = "DELETE FROM `room_comfort` WHERE `id` = '$Delet_in_room_services'";
                    $select = $mysqli->query($sql_delet_comfort);
                    ?>
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close">×</span>
                                <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                            </div>
                                <div class="modal-body">
                                    <p>Комфортность удалена</p>
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
                                    <p>Нельзя удалить комфорность, которая указана хоть в 1 номере</p>
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
                                <p>Нельзя удалить все комфорности</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        //Добавление комфортности
        if(!empty($_POST['addButSerRoom']) || !empty($_POST['form_addButSerRoom']))
        {
            ?>
                <div class="add_comfort">
                    <label for="addSerRoom">Название комфорности:</label><br>
                    <input  type="text" name="addSerRoom" id="addSerRoom" required
                    value="<?php if (!empty($_POST['addSerRoom'])) echo $_POST['addSerRoom'];?>"><br>

                    <label for="addSerPrice">Цена за комфорность:</label><br>
                    <input  type="text" name="addSerPrice" id="addSerPrice" required
                    value="<?php if (!empty($_POST['addSerPrice'])) echo $_POST['addSerPrice'];?>"><br>

                    <input class="button" type="submit" name="form_addButSerRoom" id="form_addButSerRoom" value="Добавить"><br>
                </div>
            <?php
        }
        elseif(!empty($_POST['SerAll']) || !empty($_POST['butEditSer']) 
        || !empty($_POST['butDeletSer']) || !empty($_POST['butADDSer'])
        || !empty($_POST['clinADDSer']))
        {
            if(!empty($_POST['clinADDSer']))
            {
                $_POST['add_service'] = "";
            }
            //добавление услуги в номера
            if(!empty($_POST['butADDSer']))
            {
                if($_POST['add_service'] != "")
                {
                    $add_service = $_POST['add_service'];
                    $sql_comfort = "SELECT * FROM `configuration` WHERE `title_configuration` = '$add_service'";
                    $select = $mysqli->query($sql_comfort);
                    if(mysqli_num_rows($select) == 0)
                    {
                        $add_service = mysqli_real_escape_string($mysqli, $add_service);
                        $sql_INSERT = "INSERT INTO `configuration` (`title_configuration`) 
                        VALUES (?)";
                        $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                        mysqli_stmt_bind_param($stmt_INSERT, 's', $add_service);
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
                                        <p>Добавлена услуга в номера</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $_POST['add_service'] = "";
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
                                    <p>Данная услуга в номера уже существует</p>
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
                                <p>Пустая строка(введите в поле название услуги)</p>
                            </div>
                            
                        </div>
                    </div>
                    <?php
                }
            }
            //удаление услуги в номерах
            if(!empty($_POST['butDeletSer']) )
            {
                $sql_configuration = "SELECT * FROM `configuration`";
                $select = $mysqli->query($sql_configuration);
                if(mysqli_num_rows($select) > 1)
                {
                    $Delet_id_service = $_POST['id_service'];
                    $sql_comfort = "SELECT * FROM `configuration`,`set_of_equipment` 
                    WHERE `configuration`.`id` = `id_configuration` AND `configuration`.`id` = '$Delet_id_service'";
                    $select = $mysqli->query($sql_comfort);
                    if(mysqli_num_rows($select) == 0)
                    {
                        $sql_delet_configuration = "DELETE FROM `configuration` WHERE `id` = '$Delet_id_service'";
                        $select = $mysqli->query($sql_delet_configuration);
                        ?>
                        <div id="myModal" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="close">×</span>
                                    <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                </div>
                                    <div class="modal-body">
                                        <p>Услуга в номер удалена</p>
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
                                        <p>Нельзя удалить услугу в номер, которая указана хоть в 1 комфорности</p>
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
                                    <p>Нельзя удалить все услуги в номера</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            //изменение названия услуги в номерах
            if(!empty($_POST['butEditSer']))
            {
                $id_service = $_POST['id_service'];
                $service = $_POST['service'];
                $sql_configuration = "SELECT * FROM `configuration` WHERE `title_configuration` = '$service' AND `id` <> '$id_service'";
                $select = $mysqli->query($sql_configuration);
                if(mysqli_num_rows($select) == 0)
                {
                    $service = mysqli_real_escape_string($mysqli, $service);
                    $sql_UPDATE = "UPDATE `configuration` SET `title_configuration` = ? WHERE `id` = ?";
                    $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
                    mysqli_stmt_bind_param($stmt_UPDATE, 'si', $service, $id_service);
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
                                    <p>Изменения в услуге номера сохранены</p>
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
                                    <p>Данная услуга в номерах существует</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <br>
           
            <form method="post">
                <div class="_services_class">
                    <div class="_service">
                        <input class="input_service" type="text" id="add_service" name="add_service" 
                        value="<?php if (!empty($_POST['add_service'])){echo $_POST['add_service'];}?>">
                        <input class="button" type="submit" name="butADDSer" id="butADDSer" value="Добавить">
                        <input class="button" type="submit" name="clinADDSer" id="clinADDSer" value="Очистить">
                    </div>
                </div>
            </form>
            <!-- <form class="bloc_search_user">
                <div class="search" >
                    <input type="text" class="form-control" name="live_search_res" id="live_search_res" autocomplete="off"
                    placeholder="Поиск услуги">
                    <div id="search_result_res"></div>
                </div>
                <input class="button"  type="button2" 
                    onclick="location.href='add_rooms.php'" value="Отменить поиск"/>
            </form> -->
                <?php
                if ($select_configuration = $mysqli->query("SELECT * FROM `configuration` ORDER BY title_configuration")) 
                {
                    while($row_configuration = $select_configuration->fetch_assoc())
                    {
                        $IDconfiguration = $row_configuration['id']; 
                        $sql_set_of_equipment = "SELECT * FROM `set_of_equipment` 
                                                WHERE '$IDconfiguration' = `id_configuration`";
                        $select_set_of_equipment = $mysqli->query($sql_set_of_equipment);
                        $num_rows = mysqli_num_rows($select_set_of_equipment);
                        ?>
                        <form method="post">
                            <div class="_service">
                                <input class="input_service" type="text" id="service" name="service" 
                                value="<?php echo $row_configuration['title_configuration'];?>">
                                <input type="hidden" id="id_service" name="id_service" 
                                value="<?php echo $row_configuration['id'];?>">
                                <input class="button" type="submit" name="butEditSer" id="butEditSer" value="Сохранить">
                                <input class="button" type="submit" name="butDeletSer" id="butDeletSer" value="Удалить"><br>
                            </div>
                        </form>
                        <?php 
                    }
                }
                ?>
                </div>
            <?php
        }
        else{
            
            ?>
            <br>
            <select name="in_room_services" id="in_room_services" >
                <!-- <option value="net" <?php if (!empty($_POST['in_room_services']) && $_POST['in_room_services'] == 'net'){echo "selected='selected'";} ?>>
                    Выберите комфорность
                </option> -->
                <?php 
               

                $sql_comfort = "SELECT *  FROM `room_comfort` ";
                if ($SELECT_max_id_comfort  = $mysqli->query($sql_comfort)) 
                {
                    while($row = $SELECT_max_id_comfort->fetch_assoc())
                    {
                        
                        $id_comfort = $row['id'];
                        $comfort = $row['title_comfort'];
                        
                    ?>
                        <option value="<?=$id_comfort?>"  <?php if (!empty($_POST['in_room_services']) && $_POST['in_room_services'] == $id_comfort){echo "selected='selected'";} ?>>
                            <?=$comfort?>
                        </option>
                <?php
                    }   	
                }
                ?>
            </select>
            
            <input class="button" type="submit" name="butSerRoom" id="butSerRoom" value="Выбрать">
            <input class="button" type="submit" name="butDeletSerRoom" id="butDeletSerRoom" value="Удалить комфорность"><br>
         
            <?php
            if(!empty($_POST['butEditSerRoom']))
            {
                
                if(empty($_POST['room'])) 
                {
                    echo("<p style='color:#f44336;'>Должна быть хотя бы 1 услуга в номере</p>");
                } 
                else
                {
                    $aDoor = $_POST['room'];
                    $N = count($aDoor);
                    $id_room_service = $_POST['in_room_services'];
                    
                    for($i=0; $i < $N; $i++)
                    {
                        $configuration = $aDoor[$i];
                        
                        $sql_SELECT = "SELECT * FROM `set_of_equipment` 
                        WHERE  `id_configuration` = '$configuration'
                        AND `id_comfort` = '$id_room_service'";
                        $select_set_of_equipment = $mysqli->query($sql_SELECT);
    
                        if(mysqli_num_rows($select_set_of_equipment) == 0)
                        {
                            $sql_INSERT = $mysqli->query("INSERT INTO `set_of_equipment`(`id_configuration`, `id_comfort`) 
                            VALUES ('$configuration','$id_room_service')");
                            ?>
                            <div id="myModal" class="modal">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                    </div>
                                        <div class="modal-body">
                                            <p>Добавлена услуга в номер</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
    
                    $sql_SELECT = "SELECT * FROM `set_of_equipment` 
                    WHERE `id_comfort` = '$id_room_service'";
                    $select_set_of_equipment = $mysqli->query($sql_SELECT);
                    while($row_configuration = $select_set_of_equipment->fetch_assoc())
                    {
                        $num = 0;
                        for($i=0; $i < $N; $i++)
                        {
                            if($row_configuration['id_configuration'] == $aDoor[$i])
                            {
                                $num = 1;
                            }
                        }
                        if($num == 0)
                        {
                            $row_id_del = $row_configuration['id'];
                            $sql_delet = $mysqli->query("DELETE FROM `set_of_equipment` 
                            WHERE `id` = '$row_id_del'");
                            ?>
                            <div id="myModal" class="modal">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span class="close">×</span>
                                        <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
                                    </div>
                                        <div class="modal-body">
                                            <p>Услуга из номера успешно удалена</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
    
                    
                }
            }
            if((!empty($_POST['butSerRoom']) || !empty($_POST['butEditSerRoom']) ) 
            && $_POST['in_room_services'] != 'net' )
            {
                ?>
                <div class="in_room_services_class">
                <?php
                if (!empty($_POST['in_room_services']) && $_POST['in_room_services'] != "net")
                {
                    $id_comfort = $_POST['in_room_services'];
                    if ($select_configuration = $mysqli->query("SELECT * FROM `configuration`")) 
                    {
                        while($row_configuration = $select_configuration->fetch_assoc())
                        {
                            $IDconfiguration = $row_configuration['id']; 
                            $sql_set_of_equipment = "SELECT * FROM `set_of_equipment` 
                                                    WHERE '$IDconfiguration' = `id_configuration` 
                                                    AND `id_comfort` = '$id_comfort'";
                            $select_set_of_equipment = $mysqli->query($sql_set_of_equipment);
                            $num_rows = mysqli_num_rows($select_set_of_equipment);
                            if ($num_rows == 1)
                            {
                            ?>
                                <input type="checkbox" checked="checked" id="room" name="room[]" value="<?php 
                                echo $row_configuration['id'];?>">
                                <label for="room"><?php echo $row_configuration['title_configuration'];?></label><br>
                            <?php
                            }
                            else{
                                ?>
                                <input type="checkbox" id="room" name="room[]" value="<?php echo $row_configuration['id'];?>">
                                <label for="room"><?php echo $row_configuration['title_configuration'];?></label><br>
                                <?php 
                            }
                        }
                            
                    }
                }
                ?>
                    <input class="button" type="submit" name="butEditSerRoom" id="butEditSerRoom" value="Изменить"><br>
                    
                </div>
                <?php
            }
            elseif (empty($_POST['SerAll']) || empty($_POST['butEditSer'])  || empty($_POST['addButSerRoom'])
            || empty($_POST['butDeletSer']) || empty($_POST['butADDSer']) || empty($_POST['clinADDSer']) 
            || empty($_POST['form_addButSerRoom'])){
                ?>
                <div class="in_room_services_class">
                <?php
                $sql_comfort = "SELECT *  FROM `room_comfort` ";
                if ($SELECT_max_id_comfort  = $mysqli->query($sql_comfort)) 
                {
                    if($row = $SELECT_max_id_comfort->fetch_assoc())
                    {
                        
                        $id_comfort = $row['id'];
                    }
                }
                if ($select_configuration = $mysqli->query("SELECT * FROM `configuration`")) 
                {
                    while($row_configuration = $select_configuration->fetch_assoc())
                    {
                        $IDconfiguration = $row_configuration['id']; 
                        $sql_set_of_equipment = "SELECT * FROM `set_of_equipment` 
                                                WHERE '$IDconfiguration' = `id_configuration` 
                                                AND `id_comfort` = '$id_comfort'";
                        $select_set_of_equipment = $mysqli->query($sql_set_of_equipment);
                        $num_rows = mysqli_num_rows($select_set_of_equipment);
                        if ($num_rows == 1)
                        {
                        ?>
                            <input type="checkbox" checked="checked" id="room" name="room[]" value="<?php 
                            echo $row_configuration['id'];?>">
                            <label for="room"><?php echo $row_configuration['title_configuration'];?></label><br>
                        <?php
                        }
                        else{
                            ?>
                            <input type="checkbox" id="room" name="room[]" value="<?php echo $row_configuration['id'];?>">
                            <label for="room"><?php echo $row_configuration['title_configuration'];?></label><br>
                            <?php 
                        }
                    }
                        
                }
                
                ?>
                    <input class="button" type="submit" name="butEditSerRoom" id="butEditSerRoom" value="Изменить"><br>
                    
                </div>
                <?php
            }
        }
        
        ?>
    </form>    
<?php
}
?>
<script src="js/jquery-3.6.4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
           

            $("#live_search_res").keyup(function () {
                var query_service = $(this).val();
                if (query_service != "") {
                    $.ajax({
                        url: 'search.php',
                        method: 'POST',
                        data: {
                            query_service: query_service
                        },
                        success: function (data) {
                            $('#search_result_res').html(data);
                            $('#search_result_res').css('display', 'block');
                            $("#live_search_res").focusin(function () {
                                $('#search_result_res').css('display', 'block');
                            });
                        }
                    });
                } else {
                    $('#search_result_res').css('display', 'none');
                }
            });

        });
    </script>