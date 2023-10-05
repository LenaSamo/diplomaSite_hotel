<?php
$now_date = date("Y-m-d");
$sl_bookin = "SELECT * FROM `booking`";
if ($SELECT_booking = $mysqli->query($sl_bookin))
{
    while($booking_row = $SELECT_booking->fetch_assoc())
    {

        if($booking_row['check_in_date'] > $now_date 
        && $booking_row['id_status'] == 4  && $booking_row['id_status'] != 3)
        {
            $id_booking = $booking_row['id'];
            $sl_update_id_status = "UPDATE `booking` SET `id_status` = '1' WHERE `id` = '$id_booking'";
            $query_booking = $mysqli->query($sl_update_id_status);
        }

        if($booking_row['check_in_date'] <= $now_date 
        && $booking_row['id_status'] == 1 && $booking_row['id_status'] != 3)
        {
            $id_booking = $booking_row['id'];
            $sl_update_id_status = "UPDATE `booking` SET `id_status` = '4' WHERE `id` = '$id_booking'";
            $query_booking = $mysqli->query($sl_update_id_status);
        }

        $date_Check = $booking_row['check_in_date'];
        $query = $booking_row['number_of_nights'] + 1;
        $query = '+ '.$query.' days';
        $date_departure = date("Y-m-d", strtotime($date_Check.$query));

        if($date_departure <= $now_date 
        && $booking_row['id_status'] == 4)
        {
            $id_booking = $booking_row['id'];
            $sl_update_id_status = "UPDATE `booking` SET `id_status` = '2' WHERE `id` = '$id_booking'";
            $query_booking = $mysqli->query($sl_update_id_status);
        }
    }
}

?>