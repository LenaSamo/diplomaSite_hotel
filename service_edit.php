<?php
require_once('connect.php');

  if (!empty($_POST['service'])) 
  {
      $service = $_GET['service'];
      echo"$service";
  } 
  else {
      echo "
      <div class='alert alert-danger mt-3 text-center' role='alert'>
          Song not found
      </div>
      ";
    }
  

?>