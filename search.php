<?php

  require_once('connect.php');
  
  if (isset($_POST['query_service'])) 
  {
      $query =  "SELECT * from `configuration` 
                  WHERE `title_configuration` LIKE '%{$_POST['query_service']}%' ";
      $result = mysqli_query($mysqli, $query);
      if (mysqli_num_rows($result) > 0) 
      {
        
        while ($res = mysqli_fetch_array($result)) 
        {
          echo "<form method='post'><input class='seacheInput' type='hidden' name='user_id' value='".$res['id']."' />
          <input class='seacheInput' type='submit' name='user_selected' value='".$res['title_configuration']."' /><br></form >";
          
          
        }
      } else {
        echo "
        <div class='alert alert-danger mt-3 text-center' role='alert'>
          По ващему запросу ничего не найдено
        </div>
        ";
      }
  }
  if (isset($_POST['query'])) 
  {
      $query =  "SELECT * from `users` 
                  WHERE (`name` LIKE '%{$_POST['query']}%' 
                  OR `surname` LIKE '%{$_POST['query']}%' 
                  OR `patronymic` LIKE '%{$_POST['query']}%'
                  OR `phone` LIKE '%{$_POST['query']}%'
                  OR `email` LIKE '%{$_POST['query']}%') AND `id_right` = 1 ";
      $result = mysqli_query($mysqli, $query);
      if (mysqli_num_rows($result) > 0) 
      {
        
        while ($res = mysqli_fetch_array($result)) 
        {
          echo "<form method='post'><input class='seacheInput' type='hidden' name='user_id' value='".$res['id']."' />
          <input class='seacheInput' type='submit' name='user_selected' value='".$res['surname'].' '.$res['name'].' '.$res['patronymic']."' /><br></form >";
          
          
        }
      } else {
        echo "
        <div class='alert alert-danger mt-3 text-center' role='alert'>
          По ващему запросу ничего не найдено
        </div>
        ";
      }
  }
  //поиск на странице таблица пользователей 
  if (isset($_POST['query_user'])) 
  {
      $query =  "SELECT * from `users` 
                  WHERE (`name` LIKE '%{$_POST['query_user']}%' 
                  OR `surname` LIKE '%{$_POST['query_user']}%' 
                  OR `patronymic` LIKE '%{$_POST['query_user']}%'
                  OR `phone` LIKE '%{$_POST['query_user']}%'
                  OR `email` LIKE '%{$_POST['query_user']}%') AND `id_right` = 1 ";
      $result = mysqli_query($mysqli, $query);
      if (mysqli_num_rows($result) > 0) 
      {
        
        while ($res = mysqli_fetch_array($result)) 
        {
          echo "<form method='get'><input class='seacheInput' type='hidden' name='user_id' value='".$res['id']."' />
          <input class='seacheInput' type='submit' name='user_selected' value='".$res['surname'].' '.$res['name'].' '.$res['patronymic']."' /><br></form >";
          
          
        }
      } else {
        echo "
        <div class='alert alert-danger mt-3 text-center' role='alert'>
          По ващему запросу ничего не найдено
        </div>
        ";
      }
  }
  //поиск на странице таблица сотрудники
  if (isset($_POST['query_staff'])) 
  {
      $query =  "SELECT * from `users` 
                  WHERE (`name` LIKE '%{$_POST['query_staff']}%' 
                  OR `surname` LIKE '%{$_POST['query_staff']}%' 
                  OR `patronymic` LIKE '%{$_POST['query_staff']}%'
                  OR `phone` LIKE '%{$_POST['query_staff']}%'
                  OR `email` LIKE '%{$_POST['query_staff']}%') AND `id_right` <> 1 ";
      $result = mysqli_query($mysqli, $query);
      if (mysqli_num_rows($result) > 0) 
      {
        
        while ($res = mysqli_fetch_array($result)) 
        {
          echo "<form method='get'><input type='hidden' name='user_id' value='".$res['id']."' />
          <input class='seacheInput' type='submit' name='user_selected' value='".$res['surname'].' '.$res['name'].' '.$res['patronymic']."' /><br></form >";
          
          
        }
      } else {
        echo "
        <div class='alert alert-danger mt-3 text-center' role='alert'>
          По ващему запросу ничего не найдено
        </div>
        ";
      }
  }
  //поиск на странице таблица брони
  if (isset($_POST['query_booking'])) 
  {
      $query =  "SELECT `check_in_date`, `surname`, `name`, `patronymic`, `room`, `booking`.`id`
                  FROM `booking`,`rooms_in_the_booking`, `rooms`,  `users` 
                  WHERE 
                  (`id_room` = `rooms`.`id` 
                  AND `id_user` = `users`.`id`
                  AND `id_booking` = `booking`.`id` 
                  AND `id_status` = '4')
                  AND (`check_in_date` LIKE '%{$_POST['query_booking']}%'
                      OR `name` LIKE '%{$_POST['query_booking']}%' 
                      OR `surname` LIKE '%{$_POST['query_booking']}%' 
                      OR `patronymic` LIKE '%{$_POST['query_booking']}%'
                      OR `phone` LIKE '%{$_POST['query_booking']}%'
                      OR `email` LIKE '%{$_POST['query_booking']}%'
                      OR `room` LIKE '%{$_POST['query_booking']}%'
                      )";
      $result = mysqli_query($mysqli, $query);
      if (mysqli_num_rows($result) > 0) 
      {
        
        while ($res = mysqli_fetch_array($result)) 
        {
          echo "<form method='get'>
                  <input type='hidden' name='booking_id' value='".$res['id']."' />
                  <input type='hidden' name='activ' value='Активные' />
                  <input class='seacheInput' type='submit' name='booking_selected' 
                  value='Дата-".$res['check_in_date'].' Пользователь-'.$res['surname'].' '.$res['name'].' '.$res['patronymic'].' Номер-'.$res['room']."' /><br>
                </form >";
          
          
        }
      } else {
        echo "
        <div class='alert alert-danger mt-3 text-center' role='alert'>
          По ващему запросу ничего не найдено
        </div>
        ";
      }
  }
  if (isset($_POST['room'])) 
  {
      $room =  "SELECT * FROM `rooms` 
                  WHERE (`room` LIKE '%{$_POST['room']}%')";
      $result = mysqli_query($mysqli, $room);
      if (mysqli_num_rows($result) > 0) 
      {
        
        while ($res = mysqli_fetch_array($result)) {
          echo "<form >
                <p>".$res['room']."
                  <input type='submit' class='roomSubSearch' 
                  name='room_selected' value='Выбрать'>
                  <input type='hidden' name='idroom' value=".$res['id'].">
                </p>
                </form><br>";
          
          
      }
    } else {
      echo "
      <div class='alert alert-danger mt-3 text-center' role='alert'>
          По ващему запросу ничего не найдено
      </div>
      ";
    }
  }
if(isset($_POST['room_service']))
{
  echo "<input type='hidden' id='id_room_service' value=".$_POST['room_service'].">";
  if (!empty($_POST['room_service']))
  {
      $room_service_id = $_POST['room_service'];
      $sql_service = "SELECT * FROM `room_comfort` WHERE `id` = '$room_service_id'";
      $RES_comfort = $mysqli->query($sql_service);
      $ASSOC_comfort = $RES_comfort->fetch_assoc();
      $comfort = $ASSOC_comfort['title_comfort'];
      echo "<input type='text' id='service_name' value=".$comfort.">";
      echo "<input type='button' id='red_name' value='Изменить название'>";
      echo "<input type='button' id='room_service' value='Удалить комфортность'>";
  }
  

}
if(!empty($_POST['id_room_service']))
{
  $room_service_id = $_POST['room_service_id'];
  $service_name = $_POST['service_name'];
  $sql_service = "UPDATE `room_comfort` SET `title_comfort`='$service_name' WHERE `id` = '$room_service_id'";
}
?>
