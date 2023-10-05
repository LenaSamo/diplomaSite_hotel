<?php
if($kol_room > 1)
{
    for ($j = 1; $j < $kol_room; $j++)
    {
        if (!empty($_POST["number_of_guests".$j]) && !empty($_POST["number_of_guests".$j+1]))
        {
            if($_POST["number_of_guests".$j] != "net")
            {
                $number_of_guests = $_POST["number_of_guests".$j];
                if($_POST["number_of_guests".$j+1] != "net")
                {
                    if($_POST["number_of_guests".$j] > $_POST["number_of_guests".$j+1])
                    {
                        $number_of_guests = $_POST["number_of_guests".$j];
                    }
                    else{
                        $number_of_guests = $_POST["number_of_guests".$j+1];
                    }
                }
                
            }
            else{
                if($_POST["number_of_guests".$j+1] != "net")
                {
                    $number_of_guests = $_POST["number_of_guests".$j+1];
                }
            }
        }
    }
}
else{
    if (!empty($_POST["number_of_guests".$kol_room]))
    {
        $number_of_guests = $_POST["number_of_guests".$kol_room];
    }
    
}
if(empty($_POST['comfort'])) 
{
    $comfort = "";
} 
else
{
    $comforts = $_POST['comfort'];
    $N = count($comforts);

    // $comfort = " AND `id_comfort` = '$comforts[0]'";

    if($N == 1)
    {
        $comfort = "  `id_comfort` = '$comforts[0]'";
    }
    elseif($N == 2){
        $N = $N-1;
        $comfort = " (`id_comfort` = '$comforts[0]' OR `id_comfort` = '$comforts[$N]')";

    }
    elseif($N > 2)
    {
        $comfort = " (`id_comfort` = '$comforts[0]'";
        for($i=1; $i < $N-1; $i++)
        {
        $comfort .= " OR `id_comfort` =  '$comforts[$i]'";
        }
        $N = $N-1;
        $comfort .= " OR `id_comfort` = '$comforts[$N]' )";
    }   
}
if (!empty($_POST['check_in_date']) 
&& (!empty($_POST['date_departure']))
&& ($comfort != "")
&& (!empty($number_of_guests)  && $number_of_guests != "net"))
{
    $check_in_date = $_POST['check_in_date'];
    $date_departure = $_POST['date_departure'];

    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, 
    `rooms`.`description`, `rooms`.`room`, `check_in_date`, `rooms_in_the_booking`.`id_room`, `number_of_nights` FROM `rooms`
    LEFT JOIN 
         `rooms_in_the_booking` 
         ON (
             `rooms_in_the_booking`.`id_room` = `rooms`.id 
            ) 
    LEFT JOIN 
         `booking`
         ON (
              `rooms_in_the_booking`.`id_booking` = `booking`.id 
                 AND NOT(
                        (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$check_in_date' AND `check_in_date` <= '$date_departure') 
                        OR (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$date_departure' AND `check_in_date` <= '$check_in_date' ))
            ) 
    RIGHT JOIN 
         `room_comfort`
         ON (
            (`id_comfort` = `room_comfort`.`id` AND ".$comfort.")
            ) 
    WHERE (NOT(`booking`.id IS NULL) OR `rooms_in_the_booking`.`id_room` IS NULL) 
            AND `number_of_guests` <= '$number_of_guests' ORDER BY `rooms`.`id`";

    $_POST['number_of_guests'] = 'selected';
}
elseif (!empty($_POST['check_in_date']) 
&& (!empty($_POST['date_departure']))
&& ($comfort != ""))
{
    $check_in_date = $_POST['check_in_date'];
    $date_departure = $_POST['date_departure'];
    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, 
    `rooms`.`description`, `rooms`.`room`, `check_in_date`, `rooms_in_the_booking`.`id_room`, `number_of_nights` FROM `rooms`
    LEFT JOIN 
         `rooms_in_the_booking` 
         ON (
             `rooms_in_the_booking`.`id_room` = `rooms`.id 
            ) 
    LEFT JOIN 
         `booking`
         ON (
              `rooms_in_the_booking`.`id_booking` = `booking`.id 
                 AND NOT(
                        (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$check_in_date' AND `check_in_date` <= '$date_departure') 
                        OR (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$date_departure' AND `check_in_date` <= '$check_in_date' ))
            ) 
    RIGHT JOIN 
         `room_comfort`
         ON (
             (`id_comfort` = `room_comfort`.`id` AND ".$comfort.")
            ) 
    WHERE NOT(`booking`.id IS NULL) OR `rooms_in_the_booking`.`id_room` IS NULL AND NOT(`rooms`.id IS NULL) ORDER BY `rooms`.`id`";
    
}
elseif (!empty($_POST['check_in_date']) 
&& (!empty($_POST['date_departure']))
&& (!empty($number_of_guests) && $number_of_guests != "net")) 
{
    $check_in_date = $_POST['check_in_date'];
    $date_departure = $_POST['date_departure'];
    $d1_ts = strtotime($check_in_date);
    $d2_ts = strtotime($date_departure);
    $seconds = abs($d1_ts - $d2_ts);
    $days = floor($seconds / 86400);//дни между датами


    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, 
    `rooms`.`description`, `rooms`.`room`, `check_in_date`, `rooms_in_the_booking`.`id_room`, `number_of_nights` FROM `rooms`
    LEFT JOIN 
         `rooms_in_the_booking` 
         ON (
             `rooms_in_the_booking`.`id_room` = `rooms`.id 
            ) 
    LEFT JOIN 
         `booking`
         ON (
              `rooms_in_the_booking`.`id_booking` = `booking`.id 
                 AND NOT(
                        (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$check_in_date' AND `check_in_date` <= '$date_departure') 
                        OR (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$date_departure' AND `check_in_date` <= '$check_in_date' ))
            ) 
    WHERE (NOT(`booking`.id IS NULL) OR `rooms_in_the_booking`.`id_room` IS NULL) 
            AND `number_of_guests` <= '$number_of_guests' ORDER BY `rooms`.`id`";
    
    
    $_POST['number_of_guests'] = 'selected';
}
elseif (($comfort != "")
&& (!empty($number_of_guests) && $number_of_guests != "net")) 
{
    $number_of_guests = $_POST['number_of_guests1'];
    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, `rooms`.`description`, `rooms`.`room`  
            FROM `rooms`, `room_comfort` 
            WHERE (`id_comfort` = `room_comfort`.`id` AND ".$comfort.")
            AND `number_of_guests` <= '$number_of_guests'";
   
    $_POST['number_of_guests'] = 'selected';
}
elseif ($comfort != "")
{
    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, `rooms`.`description`, `rooms`.`room`  
            FROM `rooms`, `room_comfort` 
            WHERE ".$comfort."";
            
    $res_com = " AND (`id_comfort` = `room_comfort`.`id` ".$comfort.")";
}
elseif (!empty($number_of_guests)  && $number_of_guests != "net")
{
    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `rooms`.`number_of_guests`, `rooms`.`description`, `rooms`.`room`  
            FROM `rooms`
            WHERE `number_of_guests` <= '$number_of_guests'";
        
    $_POST['number_of_guests'] = 'selected';
    
}
elseif (!empty($_POST['check_in_date']) 
&& (!empty($_POST['date_departure']))) 
{
    $check_in_date = $_POST['check_in_date'];
    $date_departure = $_POST['date_departure'];
    
    $res = "SELECT `rooms`.`id`, `rooms`.`id_comfort`, `number_of_guests`, 
    `rooms`.`description`, `rooms`.`room`, `check_in_date`, `id_room`, `number_of_nights` FROM `rooms` 
    LEFT JOIN 
         `rooms_in_the_booking` 
         ON (
             `rooms_in_the_booking`.`id_room` = `rooms`.id 
            ) 
    LEFT JOIN 
         `booking`
         ON (
              `rooms_in_the_booking`.`id_booking` = `booking`.id 
                 AND NOT(
                        (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$check_in_date' AND `check_in_date` <= '$date_departure') 
                        OR (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '$date_departure' AND `check_in_date` <= '$check_in_date' ))
            ) 
    WHERE NOT(`booking`.id IS NULL) OR `rooms_in_the_booking`.`id_room` IS NULL ORDER BY `rooms`.`id` ";
/*(SELECT `rooms`.`id`, `rooms`.`id_comfort`, `number_of_guests`,  
							`rooms`.`description`, `rooms`.`room`, `check_in_date`, `id_room`, `number_of_nights`
							FROM `rooms` , `rooms_in_the_booking` , `booking` 
                			WHERE `id_room` = `rooms`.`id` 
							AND `id_booking` = `booking`.`id`
							AND  (
                            (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '2023-04-07' AND `check_in_date` <= '2023-04-10') 
                            OR (ADDDATE( `check_in_date`,  `number_of_nights` ) >= '2023-04-10' AND `check_in_date` <= '2023-04-07' )
                            ) 
                          ) */
}
?>