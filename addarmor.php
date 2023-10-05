<?php
  
    require_once('connect.php');
    if (isset($_POST['r_id'])) 
    {

        echo "<div class='res_id_room' id='res_id_room".$_POST['id']."'>
            <input type='hidden' name='id_room".$_POST['id']."' id='id_room".$_POST['id']."' value=".$_POST['r_id'].">
            <input type='hidden' name='row_kol' id='row_kol' value=".$_POST['row_kol'].">";
        $id_room = $_POST['r_id'];
        if ($res_query = $mysqli->query("SELECT * FROM `rooms` WHERE `id` = '$id_room'")) 
        {
            $row = $res_query->fetch_assoc();
            echo "<p>".$row['room']."
                                    <input type='button' name='del_room".$_POST['id']."' id='del_room".$_POST['id']."' value='Удалить'>
                                    
                </p></div>";
        }
        
    }

?>
