<!DOCTYPE html>
<html>
<head>
	<title>Личный кабинет</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/admin.css">
</head>
<body>
	<div class="wrapper">
		<div class="head">
		<a href="../index.php">
				<span class="link_i">Главная</span>
			</a>
			<div class="logo"></div>
			<a href="about.php">
				<span class="link_f">О сервисе</span>
			</a>
			<a href="all_messages.php">
				<span class="link_s">Все сообщения</span>
			</a>
			<a href=administration.php><div class=kab>Администрация</div></a><form method=POST><input type=submit name=exit value=Выход class=exit></form>";
			<?php 
			$exit=$_POST['exit'];
			if ($exit) {
				session_destroy();
				echo '<script>location.replace("index.php");</script>';
				exit();}
			?>
		</div>
		<div class="problem_text">Все заявки</div>
		<div class="your_p_item">
			<div class="prodlem_item">
				<div>Фото</div>
				<div>Название</div>
				<div>Описание</div>
				<div>Категория</div>
				<div>Временная метка</div>
				<div>Адрес</div>
				<div><a href="">Изменить</a></div>
				<div><a href="">Удалить</a></div>
			</div>
		</div>
		<div class="pag_place">
			<div class="pagination">
				<div>1</div>
			</div>
			<div class="pagination">
				<div>2</div>
			</div>
			<div class="pagination">
				<div>3</div>
			</div>
			<div class="pagination">
				<div>4</div>
			</div>
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>