<?php 
	require_once('connect.php');
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/armor.css">
	<link rel="stylesheet" href="css\modal.css">
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<title>Бронь номера</title>
</head>
<body>
	<?php
		require_once('header.php');
		if(isset($_SESSION["user"]))
		{
			
			if (!empty($_GET['kol_room'])  && !empty($_GET['check_in_date']) && !empty($_GET['date_departure']))
			{
				require_once('armor_add_user.php');
				
			}
			else{
				$new_url = 'rooms.php?modal=1';
				header('Location: '.$new_url);
			}
			
		
		}
		else
		{
			$new_url = 'sign_in.php';
			header('Location: '.$new_url);
		}

?>



	<?php
		require_once('footer.php');
	?>		
<script src="js/jquery-3.6.4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		let kol_room = $("#kol_room").val();
		for(let i = 1; i <= kol_room; i++)
		{
			$("#button_rooms"+i).click(function () {
				let r_id = $("#room_id"+i).val();
				$.ajax({
					url: 'addarmor.php',
					method: 'POST',
					data: {
						r_id: r_id,
						id: i
					},
					success: function (data) {
						$('#res_id_rooms').append(data);
						$('#armor_hidden').css('display', 'block');
						$("#del_room"+i).click(function () {
							$("#res_id_room"+i).empty();
						});
					}
				});
			});
			
			
		}
		

	});
</script>			
		
		
</body>
</html>