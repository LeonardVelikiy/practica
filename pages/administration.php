<!DOCTYPE html>
<html>
<head>
	<title>Администрация</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/administration.css">
</head>
<body>
	<div class="wrapper">
		<div class="head">
			<div class="logo">ЛОГО</div>
			<span class="link_f">О сервисе</span>
			<span class="link_s">Все сообщения</span>
			<div class="out">Выйти</div>
		</div>
		<div>
			<div class="left_panel">
				<form method="GET">
					<button  name="applications" value="ok"> заявки</button>
					<button  name="users" value="ok">пользователи</button>
					<button  name="aplications_work" value='0'>работа с заявками</button>
					<button  name="users_work" value='0'>работа с пользовтелями</button>
				</form>
			</div>
			<div class="right_body">

				<?php
				include 'db.php';
				if($_GET['applications'])
				{
					$str_applications_out=mysqli_query($connect, "SELECT * FROM `applications`");
					echo"<table border=1 cellspacing=0 >
					<tr>
						<th style=text-aligin:center;>Публикующий
						<th style=text-aligin:center;>статус
						<th style=text-aligin:center;>название
						<th style=text-aligin:center;>категория
						<th style=text-aligin:center;>время публикации
					</tr>
						";
						while($out=mysqli_fetch_array($str_applications_out))
						{
							echo"
						<tr>	
							<td>$out[user]
							<td>$out[status]
							<td>$out[title]
							<td>$out[category]
							<td>$out[date_start]
						</tr>";
						}
					echo "</table>";
					
				}
				if($_GET['users'])
				{
					$str_users_out=mysqli_query($connect, "SELECT * FROM `users`");
					echo"<table border=1 cellspacing=0 >
					<tr>
						<th style=text-aligin:center;>ФИО
						<th style=text-aligin:center;>Login
						<th style=text-aligin:center;>Mail
						<th style=text-aligin:center;>Заявки
					</tr>
						";
						while($out=mysqli_fetch_array($str_users_out))
						{
							echo"
						<tr>	
							<td>$out[first_last_name]
							<td>$out[login]
							<td>$out[mail]
							<td>0
						</tr>";
						}
					echo "</table>";
				}
				if($_GET['aplications_work'])
				{
					$applications_del=$_GET['applications'];
					$str_applications_del=mysqli_query($connect, "DELETE FROM `applications` WHERE id = $applications_del");

					$str_applications_out=mysqli_query($connect, "SELECT * FROM `applications`");
					echo"<table border=1 cellspacing=0 >
					<tr>
						<th style=text-aligin:center;>Публикующий
						<th style=text-aligin:center;>статус
						<th style=text-aligin:center;>название
						<th style=text-aligin:center;>категория
						<th style=text-aligin:center;>время публикации
						<th colspan=2 style=text-aligin:center;>Действия
					</tr>
						";
						while($out=mysqli_fetch_array($str_applications_out))
						{
							echo"
						<tr>	
							<td>$out[user]
							<td>$out[status]
							<td>$out[title]
							<td>$out[category]
							<td>$out[date_start]
							<td><a href=?applications=$out[id]>удалить</a>
							<td><a href=?applications=$out[id]>подробнее</a>
						</tr>";
						}
					echo "</table>";
				}
				if($_GET['users_work'])
				{
					$users_del=$_GET['users'];
					$str_user_del=mysqli_query($connect, "DELETE FROM `users` WHERE id = $users_del");

					$str_users_out=mysqli_query($connect, "SELECT * FROM `users`");
					echo"<table border=1 cellspacing=0 style=widht:50%;>
					<tr>
						<th style=text-aligin:center;>ФИО
						<th style=text-aligin:center;>Login
						<th style=text-aligin:center;>Mail
						<th style=text-aligin:center;>Заявки
						<th colspan=2 style=text-aligin:center;>Действия
					</tr>
						";
						while($out=mysqli_fetch_array($str_users_out))
						{
							echo"
						<tr>	
							<td>$out[first_last_name]
							<td>$out[login]
							<td>$out[mail]
							<td>0
							<td><a href=?users=$out[id]>удалить</a>
						</tr>";
						}
					echo "</table>";
				}
				
				?>
			</div>
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>
