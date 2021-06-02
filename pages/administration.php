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
					<button  name="aplications" value="0"> заявки</button>
					<button  name="users" value="ok">пользователи</button>
					<button  name="aplications_work" value='0'>работа с заявками</button>
					<button  name="users_work" value='0'>работа с пользовтелями</button>
				</form>
			</div>
			<div class="right_body">

				<?php
				include 'db.php';
				if($_GET['aplications'])
				{
					$str_aplications_out=mysqli_query($connect, "SELECT * FROM `applications`");
					
				}
				if($_GET['users'])
				{
					$users_del=$_GET['users'];
					$str_user_del=mysqli_query($connect, "DELETE FROM `users` WHERE id = $users_del");

					$str_users_out=mysqli_query($connect, "SELECT * FROM `users`");
					echo"<table border=1 cellspacing=0 >
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
							<td><a href=?user=$out[id]>удалить</a>
							<td><a href=?user=$out[id]>подробнее</a>
						</tr>";
						}
					echo "</table>";
				}
				if($_GET['aplications_work'])
				{
					
				}
				if($_GET['users_work'])
				{
					
				}
				
				?>
			</div>
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>
