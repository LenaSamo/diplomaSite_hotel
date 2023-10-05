<?php
// if (!empty($_POST['button_room_edit']))
// {
//     $idroom = $_POST['id_room'];
//     ?>
<!-- //     <form method="post">
//         <input type="hidden" name="id_room_hidden" id="id_room_hidden" value="<?=$idroom?>">	
//     </form> -->
    <?php
//     // $new_url = "add_rooms.php?room_selected=выбрать&idroom=$idroom";
//     // header('Location: '.$new_url);
// }
if (!empty($_GET['rooms_all']) || !empty($_POST['search']) 
|| !empty($_POST['delsearch']) || !empty($_POST['button_room_edit']))

{
    
    ?>
    <form method="post">
        <div class="room_menu_seache">
            <label for="comfort">Комфортность номера</label>
            <select name="comfort" id="comfort" >
                <option value="net" <?php if (!empty($_POST['comfort']) 
                                    && $_POST['comfort'] == 'net'){echo "selected='selected'";} ?>>
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
                        <?php if (!empty($_POST['comfort']) && $_POST['comfort'] == $id_comfort){echo "selected='selected'";} ?>>
                            <?=$comfort?>
                        </option>
                <?php 
                    }   	
                }
                
                ?>
            </select>
            <label for="number_of_guests">Выберите количество гостей в номере</label>		
            <select name="number_of_guests" id="number_of_guests">
                <option value="net" <?php if (!empty($_POST['number_of_guests']) && $_POST['number_of_guests'] == 'net')
                                        {echo "selected='selected'";} ?>>
                    Выберите
                </option>
                <?php
                $sql = "SELECT  MAX(number_of_guests) AS max_guests FROM `rooms`";
                if ($SELECT_max_quests_rooms = $mysqli->query($sql)) 
                {
                    if($row = $SELECT_max_quests_rooms->fetch_assoc())
                    {
                        for ($i = 1; $i <= $row['max_guests']; $i++)
                        {
                ?>
                            <option value="<?php echo $i;?>" <?php if (!empty($_POST["number_of_guests"]) && $_POST["number_of_guests"] == $i)
                                                                    {echo "selected='selected'";} ?>>
                                <?php echo $i;?>
                            </option>
                <?php
                        }
                    }
                }
                ?>
            </select><br>
            <input type="submit" class="button" value="Поиск" name="search">
            <input type="submit" class="button" value="Отменить сортировку" name="delsearch">
        </div> 
    </form>
    <?php
    $res = "SELECT * FROM `rooms`";
    if (!empty($_POST['search']))
    {
        if ((!empty($_POST['number_of_guests']) && $_POST['number_of_guests'] != 'net') 
        && (!empty($_POST['comfort']) && $_POST['comfort'] != 'net'))
        { 
            $comfort = $_POST['comfort'];
            $number_of_guests = $_POST['number_of_guests'];

            $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, `rooms`.`description`, `rooms`.`room`  
                    FROM `rooms`, `room_comfort` 
                    WHERE (`id_comfort` = `room_comfort`.`id` AND `id_comfort` = '$comfort ')
                    AND `number_of_guests` = '$number_of_guests'";
            
            $_POST['comfort'] = 'selected';
            $_POST['number_of_guests'] = 'selected';
        }
        elseif (!empty($_POST['comfort']) && $_POST['comfort'] != 'net')
        { 
            $comfort = $_POST['comfort'];
            $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, `rooms`.`description`, `rooms`.`room`  
                    FROM `rooms`, `room_comfort` 
                    WHERE (`id_comfort` = `room_comfort`.`id` AND `id_comfort` = '$comfort')";
            
            $_POST['comfort'] = 'selected';
        }
        elseif (!empty($_POST['number_of_guests']) && $_POST['number_of_guests'] != 'net')
        { 
            $number_of_guests = $_POST['number_of_guests'];
            $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, `rooms`.`description`, `rooms`.`room`  
            FROM `rooms`
            WHERE `number_of_guests` = '$number_of_guests'";
           
            $_POST['number_of_guests'] = 'selected';
        }
    }
    if (!empty($res))
    {
        if ($result = $mysqli->query($res)) 
		{
            ?>
            <div class="rooms">
            <?php
            while($row_res = $result->fetch_assoc())
			{
                $id = $row_res['id'];
                $room = $row_res['room'];
                $id_comfort  = $row_res['id_comfort'];
                $number_of_guests = $row_res['number_of_guests'];

                $selec_comfort = "SELECT * FROM `rooms`, `room_comfort`  
                WHERE `rooms`.`id` = '$id' AND `room_comfort`.`id` = '$id_comfort'";
                $RES_comfort = $mysqli->query($selec_comfort);
                $ASSOC_comfort = $RES_comfort->fetch_assoc();
                $comfort = $ASSOC_comfort['title_comfort'];

                $nowDate = Date("Y-m-d");
                $selec_prise = "SELECT * FROM `rooms`, `room_rates`  
                                WHERE `rooms`.`id` = '$id' 
                                AND `room_rates`.`id_comfort` = '$id_comfort' 
                                AND `price_date` <= '$nowDate'
                                ORDER BY `room_rates`.`id` DESC LIMIT 1";
                $RES_prise = $mysqli->query($selec_prise);
                $ASSOC_prise = $RES_prise->fetch_assoc();
                $prise = $ASSOC_prise['price'];
                ?>
                <div class="room">
                    <?php
                    if ($SELECT_photo = $mysqli->query("SELECT * FROM `photos_of_the_rooms` WHERE `id_room` = $id"))
                    {
                        $row_photo = $SELECT_photo->fetch_assoc();
                        ?>
                        <img class="img_room" src="img/<?=$row_photo['photo']?>" >
                        <?php
                    }
                    ?>
                    <div class="room_inform">
                        <h2><?=$room?></h2>
                        <p>
                            Комфортность: <?=$comfort?><br> 
                            Количество человек: <?=$number_of_guests?><br>
                        </p>
                        <p>Цена - <?=$prise?>&#8381</p>	
                        <div class="sub_prise">  
                            <form  method="get">		
                                <input type="hidden" name="id_room" id="id_room" value="<?=$row_res['id']?>">	
                                <input class="button" type="submit" name="button_room_edit" id="button_room_edit" value="Изменить номер">
                            </form>
                        </div>	
                    </div>
                </div>
            <?php
            }
            ?>
            </div>
            <?php
        }
    }
}
?>