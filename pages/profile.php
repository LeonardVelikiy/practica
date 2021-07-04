<?php

$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica'); 

?>
<!DOCTYPE html>
<html>
<head>
	<title>Личный кабинет</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/profile.css">
</head>
<body>
	<div class="wrapper">
		<div class="head">
			<div class="logo">ЛОГО</div>
			<span class="link_f">О сервисе</span>
			<span class="link_s">Все сообщения</span>
			<a href="../index.php">
				<div class="out">Выйти</div>
			</a>
		</div>
		<?php
		$str_auth="SELECT * FROM `users` WHERE `login`=$_SESSION[login]";
		$run_auth=mysqli_query($connect,$str_auth);
		$out_auth=mysqli_fetch_array($run_auth);
		?>
		<span class="yinfo_text">Ваш профиль</span>
		<div class="user_info">
			<div class="avatar_img">Аватар</div>
			<div class="std_info">
				<div><?php echo "$out_auth[login]"?></div>
				<div><?php echo "$out_auth[first_last_name]"?></div>
				<div><?php echo "$out_auth[mail]"?></div>
			</div>
			<div class="user_info_change">Изменить профиль</div>
		</div>
		<div class="problem_text">Ваши заявки</div>
		<div class="your_p_item">
			<div class="prodlem_item">
				<div>Фото</div>
				<div>Название</div>
				<div>Описание</div>
				<div>Категория</div>
				<div>Временная метка</div>
				<div><a href="">Удалить</a></div>
			</div>
		</div>
		<div class="delete_acc">
			<a href="">Удалить профиль</a>
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>