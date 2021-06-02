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
					<button  name="aplications" value=""> заявки</button>
					<button  name="users" value="">пользователи</button>
					<button  name="aplications_work" value=''>работа с заявками</button>
					<button  name="users_work" value=''>работа с пользовтелями</button>
				</form>
			</div>
			<div class="right_body">

				<?php

				if($_GET['aplications'])
				{
					$str_aplications_out=mysqli_query($connect, "SELECT * FROM `applications`");
					$out=mysqli_fetch_array($str_aplications_out);
					echo"<table >
					<tr>
						<th style=text-aligin:center;>ФИО
						<th style=text-aligin:center;>Login
						<th style=text-aligin:center;>Mail
						<th style=text-aligin:center;>заявки
						<th colspan=2 style=text-aligin:center;>действия
						<th>удалить
						<th>подробнее
					</tr>
						";

				}
				if($_GET['users'])
				{
					$str_users_out=mysqli_query($connect, "SELECT * FROM `users`");
					
					echo"<table >
					<tr>
						<th style=text-aligin:center;>ФИО
						<th style=text-aligin:center;>Login
						<th style=text-aligin:center;>Mail
						<th style=text-aligin:center;>заявки
						<th colspan=2 style=text-aligin:center;>действия
						<th>удалить
						<th>подробнее
					</tr>
						";
						while($out=mysqli_fetch_array($str_aplications_out))
						{
							echo"
						<tr>	
							<td>$out[first_last_name]
							<td>$out[login]
							<td>$out[mail]
							<td>0
							<td><a href=?user_del=$out[id]>удалитьь</a>
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
