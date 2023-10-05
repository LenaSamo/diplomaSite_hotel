<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="css\table.css">
    <link rel="stylesheet" type="text/css" href="css\content.css">
    <link rel="stylesheet" href="css\modal.css">
    <link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Редактирование контента</title>
</head>
<body>
	<?php
		require_once('connect.php');
		session_start();
		require_once('header.php');
if (isset($_SESSION["user"]) && ($_SESSION["user"]["id_right"] == 2 || $_SESSION["user"]["id_right"] == 4))
{     
        require_once('form_but.php');
	?>  
<?php
$sqlServic = "SELECT * FROM `services`";
if (!empty($_POST['butDelImg']))
{
    $id_service = $_POST['id'];
    $sql_SELECT = "SELECT * FROM `photo_services` 
    WHERE `id_services` = '$id_service'";
    $select_set_of_equipment = $mysqli->query($sql_SELECT);
    if(mysqli_num_rows($select_set_of_equipment) > 1)
    {
        $id_img = $_POST['id_img'];
        $sql_DEL = "DELETE FROM `photo_services` WHERE `id` = '$id_img'";
        $del_img = $mysqli->query($sql_DEL);
        ?>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <div class="modal-header">
                <span class="close">×</span>
                <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
            </div>
                <div class="modal-body">
                    <p>Удаление фото прошло успешно</p>
                </div>
            </div>
        </div>
        <script src="js/modalWindow.js"></script>
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
                    <p>Необходимо хотя бы 1 фото услуги</p>
                </div>
            </div>

        </div>
        <script src="js/modalWindow.js"></script>
        <?php
    }
}
/*Удаление услуги*/
if(!empty($_POST['serDel']))
{
    
    $sql_SELECT = "SELECT * FROM `services`";
    $select_set_of_equipment = $mysqli->query($sql_SELECT);
    if(mysqli_num_rows($select_set_of_equipment) > 1)
    {
        $id_service = $_POST['id'];
        $sql_DEL = "DELETE FROM `services` WHERE `id` = '$id_service'";
        $mysqli->query($sql_DEL);
        ?>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <div class="modal-header">
                <span class="close">×</span>
                <h2><img class="img_header" src="img\free-icon-font-angle-small-down.png" onclick="myImg()"></h2>
            </div>
                <div class="modal-body">
                    <p>Услуга отеля удалена успешно</p>
                </div>
            </div>
    
        </div>
        <script src="js/modalWindow.js"></script>
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
                        <p>В отеле должен быть хотя бы 1 услуга</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
/*сохранение выбраной услуги*/
if(!empty($_POST['serSave']))
{
    
    $id_service = $_POST['id'];
    $title = mysqli_real_escape_string($mysqli, $_POST['title']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);

    $sql_SELECT = "SELECT * FROM `services` 
    WHERE (`title` = ? OR `description` = ?) 
    AND NOT (`id` = '$id_service') ";
    $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
    mysqli_stmt_bind_param($stmt_SELECT, 'ss',$title, $description);
    mysqli_stmt_execute($stmt_SELECT);
    $result = mysqli_stmt_get_result($stmt_SELECT);

    $user = $result->fetch_assoc();
    
    if(mysqli_num_rows($result))
    {
        ?>
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
            <div class="modal-header">
                <span class="close">×</span>
                <h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
            </div>
                <div class="modal-body">
                    <p>Нельзя изменить услугу на уже имеющуюся</p>
                </div>
            </div>

        </div>
        <script src="js/modalWindow.js"></script>
        <?php
    
    }
    else{
        $sql_UPDATE = "UPDATE `services` SET `title` = ?, `description` = ? WHERE id = ?";
        $stmt_UPDATE = mysqli_prepare($mysqli, $sql_UPDATE);
        mysqli_stmt_bind_param($stmt_UPDATE, 'ssi', $title, $description, $id_service);
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
                    <p>Сохранение информации прошло успешно</p>
                </div>
            </div>
    
        </div>
        <script src="js/modalWindow.js"></script>
        <?php
        if($_FILES['file_img']['name'] != "")
        {     
            $tmp_name = $_FILES["file_img"]["tmp_name"];
            $name = basename($_FILES["file_img"]["name"]);
            move_uploaded_file($tmp_name, "C:/xampp/htdocs/site_hotel/img/$name");
            $image= mysqli_real_escape_string($mysqli, $_FILES['file_img']['name']);
    
            $sql_INSERT = "INSERT INTO `photo_services` (`photo`, `id_services`) 
            VALUES (?, ?)";
            $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
            mysqli_stmt_bind_param($stmt_INSERT, 'si', $image, $id_service);
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
                        <p>Добавлено новое фото</p>
                    </div>
                </div>
    
            </div>
            <script src="js/modalWindow.js"></script>
            <?php
        }
    }
   

}
?>
<form method="post" class="ADD">
    <input class="button" type="submit" name="butADDservice" id="butADDservice" value="Добавить услугу отеля">
    <?php
    if(!empty($_POST['butADDservice'])  )
    {
        ?>
        <input class="button" type="submit" name="z" id="z" value="Обратно к услугам отеля" formnovalidate>
        <?php
    }
    ?>
</form>
<?php
if (!empty($_POST['button_room'])) 
{
    $id_service = $_POST['id_service'];
    $service =  "SELECT * from `services` 
                WHERE `id` = '$id_service'";
    ?>            
    
    <?php
    if ($result = $mysqli->query("$service")) 
    {
        if ($res = $result->fetch_assoc())
        {
            $id = $res['id'];
        ?>
        <form method="post" class="red_services" enctype="multipart/form-data">
        <?php
		if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = $id"))
		{
			$num = mysqli_num_rows($SELECT_photo);
			if($num > 1)
			{
				?>
                <div class="slideshow-container">

                    <!-- Full-width images with number and caption text -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <?php

                        if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = '$id'"))
                        {
                            
                            while($row_photo = $SELECT_photo->fetch_assoc())
                            {
                                ?>
                                <div class="mySlides fade">
                                    <img class="img_service" src="img/<?=$row_photo['photo']?>">
                                    <input type="hidden" name="id_img"  id="id_img" value="<?= $row_photo['id'] ?>"><br>
                                    <input class="button" type="submit" name="butDelImg" id="butSave" value="Удалить фото" ><br>
                                </div>
                                
                                <?php
                            }
                        }
                    ?>


                <!-- Next and previous buttons -->

                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br>

                <!-- The dots/circles -->
                <div style="text-align:center">
                    <?php
                    if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = $id"))
                    {
                        $num = mysqli_num_rows($SELECT_photo);
                        
                    }
                    for($i = 1; $i <= $num; $i++)
                    {
                        ?>
                        <span class="dot" onclick="currentSlide(<?=$i?>)"></span>
                        <?php
                    }
                    ?>
                </div>
            <?php
            }
            else{
                if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = '$id'"))
                {
                    
                    while($row_photo = $SELECT_photo->fetch_assoc())
                    {
                        ?>
                        <div class="mySlides fade">
                            <img class="img_service" src="img/<?=$row_photo['photo']?>">
                            <input type="hidden" name="id_img"  id="id_img" value="<?= $row_photo['id'] ?>"><br>
                            <input class="button" type="submit" name="butDelImg" id="butSave" value="Удалить фото" ><br>
                        </div>
                        
                        <?php
                    }
                }
            }
        }
        ?>
            <input type="file" name="file_img" id="file_img"><br>

            <label for="room">Название:</label><br>
            <input type="hidden" name="id" value="<?=$res['id']?>">
            <input type="text" name="title" id="title" value="<?=$res['title']?>" required><br>
    
            <label for="description">Описание:</label><br>
            <textarea name="description" id="description"  required><?=$res['description']?></textarea><br>
            
            <input class="button" type="submit" name="serSave" id="serSave" value="Сохранить изменения" >
            <input class="button" type="submit" name="serDel" id="serDel" value="Удалить услугу" >
        </form >
        <?php
        
        } 
    } 

}
?>

<?php    
    if (!empty($_POST['addserSave'])) 
    {
        
            $title = mysqli_real_escape_string($mysqli, $_POST['title']);
            $description = mysqli_real_escape_string($mysqli, $_POST['description']);

            $sql_SELECT = "SELECT * FROM `services` WHERE `title` = ? AND `description` = ?";
            $stmt_SELECT = mysqli_prepare($mysqli, $sql_SELECT);
            mysqli_stmt_bind_param($stmt_SELECT, 'ss', $title, $description);
            mysqli_stmt_execute($stmt_SELECT);
            $result = mysqli_stmt_get_result($stmt_SELECT);
            if(mysqli_num_rows($result))
            {					
                ?>
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">×</span>
                            <h2><img class="img_header" src="img\free-icon-font-cross-small.png" onclick="myImg()"></h2>
                        </div>
                            <div class="modal-body">
                                <p>Данная услуга отеля существует</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            else{
                $sql_INSERT = "INSERT INTO `services` (`title`, `description`) 
                VALUES (?, ?)";
                $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                mysqli_stmt_bind_param($stmt_INSERT, 'ss', $title, $description);
                mysqli_stmt_execute($stmt_INSERT);
                if(!empty($_FILES['file_img']['name']))
                {     
                    $tmp_name = $_FILES["file_img"]["tmp_name"];
                    $name = basename($_FILES["file_img"]["name"]);
                    move_uploaded_file($tmp_name, "C:/xampp/htdocs/site_hotel/img/$name");
                    $image= mysqli_real_escape_string($mysqli, $_FILES['file_img']['name']);
            
                    $selec_room_new = "SELECT * FROM `services`  
                    WHERE `title` = '$title' AND `description` = '$description'";
                    $RES = $mysqli->query($selec_room_new);
                    $ASSOC = $RES->fetch_assoc();
                    $id_new = $ASSOC['id'];

                    $sql_INSERT = "INSERT INTO `photo_services` (`photo`, `id_services`) 
                    VALUES (?, ?)";
                    $stmt_INSERT = mysqli_prepare($mysqli, $sql_INSERT);
                    mysqli_stmt_bind_param($stmt_INSERT, 'si', $image, $id_new);
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
                                <p>Добавлена новая услуга</p>
                            </div>
                        </div>
            
                    </div>
                    <script src="js/modalWindow.js"></script>
                    <?php
                }
            }
        
    }
    if (!empty($_POST['butADDservice'])) 
    {
        
        ?>
        <form method="post" class="formAdd" enctype="multipart/form-data">
            <input type="file" name="file_img" id="file_img"  
            value="<?php if (!empty($_FILES['file_img']['name'])) echo $_FILES['file_img']['name'];?>" required><br>

            <label for="room">Название:</label><br>
            <input type="text" name="title" id="title" value="<?php if (!empty($_POST['room'])) echo $_POST['room'];?>" required><br>

            <label for="description">Описание:</label><br>
            <textarea name="description" id="description"  required>
                <?php if (!empty($_POST['description'])) echo $_POST['description'];?>
            </textarea><br>
            
            <input class="button" type="submit" name="addserSave" id="addserSave" value="Добавить услугу" >
        </form>
    <?php
    }
    elseif ($result = $mysqli->query($sqlServic)) 
    {
        while($row = $result->fetch_assoc())
        {
            $id =  $row['id'];
            $title = $row['title'];
            $description = $row['description'];
          
        ?>
        <form class="services" method="post">
            <div class="service">
            
                <?php
                    if ($SELECT_photo = $mysqli->query("SELECT * FROM `photo_services` WHERE `id_services` = $id"))
                    {
                        if($row_photo = $SELECT_photo->fetch_assoc())
                        {
                ?>
                            <img  class="img_service" src="img/<?=$row_photo['photo']?>" height="500px">
                <?php
                        }
                    }
                ?>
                <br>
                <h2><?=$title?></h2>
                <p><?=$description?></p>
                <input type="hidden" name="id_service" id="id_service" value="<?=$row['id']?>">
                <input class="button" type="submit" name="button_room" id="button_room" value="Изменить">
            </div>
            
        </form>
        <?php

        }
    }

	require_once('footer.php');
}
	?>
    <script>
		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
		showSlides(slideIndex += n);
		}

		function currentSlide(n) {
		showSlides(slideIndex = n);
		}

		function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("dot");
		if (n > slides.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = slides.length}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";  
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		slides[slideIndex-1].style.display = "block";  
		dots[slideIndex-1].className += " active";
		}
	</script>
</body>
</html>