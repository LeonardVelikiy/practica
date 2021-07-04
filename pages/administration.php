
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
			<form method="POST"><input class="out" type="submit" name="out" value="Выйти"></form>
			<?php 
			$out=$_POST['out'];
			if($out){ unset($_SESSION['user']); echo '<script>location.replace("../index.php");</script>';exit;}
			?>
		</div>
		<div>
			<div class="left_panel">
				<form method="GET">
					<button  name="applications" value="ok"> заявки</button>
					<button  name="users" value="ok">пользователи</button>
					<button  name="aplications_work" value='ok'>работа с заявками</button>
					<button  name="users_work" value='ok'>добавление заявок</button>
					<button  name="category" value='ok'>добавление ктегорий</button>
				</form>
			</div>
			<div class="right_body">

				<?php
				include 'db.php';
				if($_GET['category'])
				{
					echo"<div class=part0>";
					echo"<div class=part1>";
					
					echo"
					<form method=POST>
						<input type=text name=category_name class=form_mitem1 id=form_mitem1><br><br>
						<input type=submit name=add style=cursor:pointer; class=form_mitem1 id=form_mitem1 >
					</form>";
					$category_name=$_POST['category_name'];
					$add=$_POST['add'];
					if($add)
					{
						$str_category_out=mysqli_query($connect, "INSERT INTO `category` (`category`) VALUES ('$category_name');");
					}
					

					echo"</div>";/*part1 */

					$category_del=$_GET['category'];
					$str_category_del=mysqli_query($connect, "DELETE FROM `category` WHERE id = $category_del");

					$str_applications_out=mysqli_query($connect, "SELECT * FROM `category` ");
					echo"<div class=part2>";
					echo"<table border=1 cellspacing=0 >
					<tr>
						<th style=text-aligin:center;>категории
						<th style=text-aligin:center;>действие
					</tr>
						";
						while($out=mysqli_fetch_array($str_applications_out))
						{
							echo"
						<tr>
							<td>$out[category]
							<td><a href=?category=$out[id]>удалить</a>
						</tr>";
						}
					echo "</table>";
					echo"</div>";/*part2 */
					echo"</div>";/*part0 */
				}
				if($_GET['applications'])
				{
					$str_applications_out=mysqli_query($connect, "SELECT * FROM `applications` WHERE `status`='Новая'");
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
							<td>".date('d/m/Y',$out['date_start'])."
						</tr>";
						}
					echo "</table>";
					
				}
				if($_GET['users'])
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
				if($_GET['aplications_work'])
				{
					$aplications_work_del=$_GET['aplications_work'];
					$str_aplications_work_del=mysqli_query($connect, "DELETE FROM `applications` WHERE id = $aplications_work_del");

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
							if($out['date_end']==0)
							{
								$time_end="-";
							}else
							{	
								$time_end=date('d/m/Y',$out['date_end']);
							}
							echo"
						<tr>	
							<td>$out[user]
							<td>$out[status]
							<td>$out[title]
							<td>$out[category]
							<td>".date('d/m/Y',$out['date_start'])."
							<td>$time_end
							<td><a href=?aplications_work=$out[id] style=color:red;>удалить</a>
							<td><a href=?aplications_work=$out[id] style=color:blue;>изменить</a>
						</tr>";
						}
					echo "</table>";
				}
				if($_GET['users_work']or$_GET['search']or$_GET['send_search'])
				{
					
					$str_out_categoty="SELECT * FROM `category`";
					$run_out_categoty=mysqli_query($connect,$str_out_categoty);
					echo"<div class=part0>";
					echo"
					<div class=part1>
					<form method=POST enctype=multipart/form-data>
					<input type=file name=рhoto_start class=form_mitem1 id=form_mitem1></input><br><br>
					<input type=text name=title class=form_mitem2 placeholder=Название><br><br>
					<input type=text name=city class=form_mitem2 placeholder=Город><br><br>
					<input type=text name=district class=form_mitem2 placeholder=Район><br><br>
					<input type=text name=street class=form_mitem2 placeholder=Улица><br><br>
					<input type=text name=house class=form_mitem2 placeholder=Дом><br><br>
					<textarea name=description class=form_mitem3 placeholder=Описание></textarea><br><br>
					<select name=category class=form_mitem4><option name=option>Выберите категорию</option>";
					while ($out=mysqli_fetch_array($run_out_categoty)){
						echo "<option>$out[category]</option>";
					}
					echo"
					</select><br><br>
					<input type=submit name=add value=Сообщить>
					</form>";
					
					$ex=$_POST['ex'];
					$option=$_POST['option'];
					$title=$_POST['title'];
					$city=$_POST['city'];
					$district=$_POST['district'];
					$street=$_POST['street'];
					$house=$_POST['house'];
					$description=$_POST['description'];
					$category=$_POST['category'];
					$date_start=time();
					$status="Новая";
					$add=$_POST['add'];
	
				
					if($add)
					{
						$file_get= $_FILES['рhoto_start']['name'];
						$temp= $_FILES['рhoto_start']['tmp_name'];
						$file_to_saved= "images/".time().$file_get;
						move_uploaded_file($temp, $file_to_saved);
						
						$str_add_application="INSERT INTO `applications` (`рhoto_start`, `title`, `city`, `district`, `street`, `house`, `description`, `category`, `status`, `date_start`) VALUES ('$file_to_saved', '$title', '$city', '$district', '$street', '$house', '$description', '$category', '$status', '$date_start')";
						
							if ($_FILES && $title && $city && $district && $street && $house && $category != $option) 
							{
									$run_str_add_application=mysqli_query($connect, $str_add_application);
									if($run_str_add_application)
									{
								
									}else
										{
											echo "Ошибка добавления";
										}
							}else
								{
									echo "Заполните поля";
									
								}
					}
					echo"
					<form method=GET ><br>
						<input type=text name=search class=form_mitem1><br>
						<input type=submit name=send_search value=Поиск>
					</form>";
					$search=$_GET['search'];
					$send_search=$_GET['send_search'];

					echo"</div>";
					echo"<div class=part2>";
					if ($send_search) 
					{
						$str_applications_out=mysqli_query($connect, "SELECT * FROM `applications` WHERE ( user LIKE '%$search%' OR title LIKE '%$search%' OR city LIKE '%$search%' OR district LIKE '%$search%' OR street LIKE '%$search%' OR house LIKE '%$search%'  OR category LIKE '%$search%'  OR status LIKE '%$search%'  OR date_end LIKE '%$search%'  OR date_start LIKE '%$search%') ");
					}else
							{
								$str_applications_out=mysqli_query($connect,"SELECT * FROM `applications`");
							}
					
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
							<td>".date('d/m/Y',$out['date_start'])."
						</tr>";
						}
					echo "</table>";
					echo"</div>";
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