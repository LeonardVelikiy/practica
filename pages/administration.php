
<!DOCTYPE html>

<html>
<head>
	<title>Администрация</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../styles/administration.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
					<button  name="aplications_work" value='ok'>работа с заявками</button>
					<button  name="users_work" value='ok'>работа с пользовтелями</button>
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
						<th style=text-aligin:center;>время выполнения
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
							<td>".date('d/m/Y',$out['date_start'])."
							<td>".date('d/m/Y',$out['date_end'])."
							<td><a href=?applications=$out[id] style=color:red;>удалить</a>
							<td><a href=?applications=$out[id] style=color:blue;>изменить</a>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>