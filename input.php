<?php
// <!-- Категории комфортности номаров -->

    //выход из архива записей
    if(!empty($_POST['and']))
    {
        $sl_comfort = "SELECT * FROM `room_rates` as rates_1
                    WHERE price_date = (SELECT max(price_date) FROM `room_rates` as rates_2 WHERE rates_1.`id_comfort` = rates_2.`id_comfort`)
                    ORDER BY `price_date` DESC";
        json_encode(array('success' => 1));			
    }
    else json_encode(array('success' => 0));

    //сохранение комфортности
    if(!empty($_POST['saveComfort']))
    {
        
        if (preg_match('/^\d+$/u', $_POST['price']))
        {
            //присвоение информации в переменные
            $price = $_POST['price'];
            $price_date = date("y-m-d");
            $id_comfort  = $_POST['title_comfort'];

            //проверка на уникальность измененных данных
            $sql_SELECT = "SELECT * FROM `room_rates` WHERE price = ? AND id_comfort = ?  ORDER BY `room_rates`.`price_date` DESC LIMIT 1";
            $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
            mysqli_stmt_bind_param($stmt_SELECT, 'di', $price, $id_comfort);
            mysqli_stmt_execute($stmt_SELECT);
            $result = mysqli_stmt_get_result($stmt_SELECT);

            if(mysqli_num_rows($result))
            {
                echo "<script>alert ('Такая цена на комфортность в номере стоит на текущий момент');</script>";
            }
            else{
                $sql_INSERT = "INSERT INTO `room_rates` (`price`, `price_date`, `id_comfort`) VALUES (?, ?, ?)";
                $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                mysqli_stmt_bind_param($stmt_INSERT, 'dsi', $price, $price_date, $id_comfort);
                mysqli_stmt_execute($stmt_INSERT);

            }
            json_encode(array('success' => 1));	
        }
        else {  
                 
            echo "<script>alert ('В поле цена должно быть положительное число');</script>";
        }
    }	
    else json_encode(array('success' => 0));	
    //удаление комфортности
    if(!empty($_POST['saveComfort']))
    {
        
    }
?>