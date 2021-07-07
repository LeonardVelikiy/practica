<?php
session_start();
$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Благоустройство города</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../styles/all_messages.css">
</head>
<body>
<div id=reg_dark>
<div class="form_window_reg">
		<a href="#">
			<div class="close_btn"></div>
		</a>
		<div class="form_mname">Регистрация</div>
		<div class="form_place">
			<form method="POST">
				<input type="text" name="first_last_name" placeholder="ФИО" class="form_mitem"><br>
				<input type="text" name="login" placeholder="Логин" class="form_mitem"><br>
				<input type="text" name="Email" placeholder="Email" class="form_mitem"><br>
				<input type="password" name="pass" placeholder="Пароль" class="form_mitem"><br>
				<input type="password" name="copy_pass" placeholder="Повторите пароль" class="form_mitem"><br>
				<input type="checkbox" name="cb"><span class="pers_inf">Согласие на обработку<br>персональных данных</span><br>
				<input type="submit" name="reg" value="Регистрация" class="form_btn_reg">
				<?php
				$first_last_name=$_POST['first_last_name'];
				$login=$_POST['login'];
				$Email=$_POST['Email'];
				$pass=$_POST['pass'];
				$copy_pass=$_POST['copy_pass'];
				$cb=$_POST['cb'];
				$reg=$_POST['reg'];
				if($reg)
				{	
					if($copy_pass == $pass)
					{
							if($first_last_name and $login and $Email and $cb) 
							{
							$str_user_plus=mysqli_query($connect, "INSERT INTO `users` (`first_last_name`, `mail`, `pass`, `login`) VALUES ('$first_last_name','$Email','$pass','$login');");
							header("Location: #auth_dark");exit();
								
							}else
							{
								echo'<br>заполните все поля<br>';
							}
					}
					
				}
				?>
			</form>
		</div>
		<div class="form_link"><a href="#auth_dark">Войти</a></div>
	</div>
</div>
<div id=auth_dark>
<div class="form_window_auth">
		<a href="#">
			<div class="close_btn"></div>
		</a>
		<div class="form_mname">Вход</div>
		<div class="form_place">
			<form method="POST">
				<input type="text" name="login" placeholder="Логин" class="form_mitem"><br>
				<input type="text" name="pass" placeholder="Пароль" class="form_mitem"><br>
				<input type="submit" name="auth" value="Вход" class="form_btn">
			
			<?php
			$login=$_POST['login'];
			$pass=$_POST['pass'];
			$add=$_POST['auth'];
			if ($add) {
				$_SESSION['login']=$login;
				$_SESSION['pass']=$pass;
				$_SESSION['auth']=$add;
			}
			if($add)
			{
				$str_auth="SELECT * FROM `users` WHERE `login` = '$_SESSION[login]' AND `pass` = '$_SESSION[pass]'";
				$run_auth=mysqli_query($connect,$str_auth);
				$check_users=mysqli_num_rows($run_auth);

				if ($check_users) 
					{
						$user= mysqli_fetch_assoc($run_auth);
						if ($user['role']==0) 
						{
							 echo '<script>location.replace("../pages/profile.php");</script>'; exit;
						}else
						{
							 echo '<script>location.replace("../pages/administration.php");</script>'; exit;
						}
									
					}else
					{
						echo '<script>location.replace("/");</script>'; exit;
					
						unset($_SESSION);
					}

			}


			?>
			</form>
		</div>
		<div class="form_link"><a href="#reg_dark">Регистрация</a></div>
	</div>
</div>
<div id=dark_success>
<div id=okno_success>
<a href="#">
			<div class="close_btn"></div>
		</a>
<form method="POST" enctype="multipart/form-data">
<input type="file" name="photo_end" class="form_mitem1" id="form_mitem1"><br><br>
<input type="submit" name="add" class="form_mbtn1" value="Подтвердить">
</form>
<?php
$id_success=$_GET['id_success'];
$status=$_POST['status'];
$time=time();
$add=$_POST['add'];
			$file_get= $_FILES['photo_end']['name'];
			$temp= $_FILES['photo_end']['tmp_name'];
			$file_to_saved= "../images/".time().$file_get;
			$imageFileType = 
			strtolower(pathinfo($file_to_saved,PATHINFO_EXTENSION));


if($add){

	$str_add_application="UPDATE `applications` SET `photo_end`='$file_to_saved', `status`='Выполнено', `date_end`='$time' WHERE `id`='$id_success'";
if ($_FILES) {
if($imageFileType != "jpg" && $imageFileType != "jpeg") {
	echo "Только файлы jpg и jpeg";
}
else{

	move_uploaded_file($temp, $file_to_saved);
	$run_str_add_application=mysqli_query($connect, $str_add_application);
if($run_str_add_application)
{

echo '<script>location.replace("/");</script>'; exit();

}
else
{
echo "Ошибка добавления";
}
}
}
else
{
echo "Заполните поля";
}
}


?>

</div>
</div>
	<div class="wrapper">
		<div class="head">
		<a href="../index.php">
				<span class="link_i">Главная</span>
			</a>
			<div class="logo"></div>
			<a href="about.php">
				<div class="link_f">О сервисе</div>
			</a>
			<a href="all_messages.php">
				<div class="link_s">Все сообщения</div>
			</a>
			<?php
			if ($_SESSION['login'] == NULL) {
			echo "<a href=#auth_dark>
				<div class=auth>Войти</div>
			</a>";
			}
			else
			{
				if ($user['role']==0){
					echo "<a href=../pages/profile.php><div class=kab>Мой кабинет</div></a><form method=POST><input type=submit name=exit value=Выход class=exit></form>";
				}
				else
				{
					echo "<a href=../pages/administration.php><div class=kab>Мой кабинет</div></a><form method=POST><input type=submit name=exit value=Выход class=exit></form>";
				}
			}
			$exit=$_POST['exit'];
			if ($exit) {
				session_destroy();
				echo '<script>location.replace("index.php");</script>';
				exit();
			}
			?>
		</div>
		<div class="mess_text">Все сообщения</div>
		<div class="all_messages_filter">
			<form>
			<form method=GET ><br>
<input type=text name=search class=form_mitem1><br>
			<select class="select" name=select>
				<option>Категория</option>
				<input type=submit name=send_search value=Поиск>
</form>
				<?php
				 $search=$_GET['search'];
				 $select=$_GET['select'];
				 $send_search=$_GET['send_search'];
				 if ($send_search)
{
$str_applications_out=mysqli_query($connect, "SELECT * FROM `applications` WHERE ( user LIKE '%$search%' OR title LIKE '%$search%' OR city LIKE '%$search%' OR district LIKE '%$search%' OR street LIKE '%$search%' OR house LIKE '%$search%' OR category LIKE '%$search%' OR status LIKE '%$search%' OR date_end LIKE '%$search%' OR date_start LIKE '%$search%') AND (`status` LIKE '%$select%')");
}else
{
$str_applications_out=mysqli_query($connect,"SELECT * FROM `applications`");
}
		$str_out_categoty="SELECT * FROM `category`";
		$run_out_categoty=mysqli_query($connect,$str_out_categoty);
		while ($out=mysqli_fetch_array($run_out_categoty)){
			echo "<option>$out[category]</option>";
		}
		?>
			</select>
			<input type="submit" name="" class="sub_btn" value="">
			</form>
		</div>
		<div class="mess_p_item">
			<?php
		$str_out_application="SELECT * FROM `applications` WHERE `status`='Новая' ORDER BY `date_start` DESC";
		$run_out_application=mysqli_query($connect,$str_out_application);
		$int_out_application=mysqli_num_rows($run_out_application);
		$page_number=$_GET['page_number'];
					if ($page_number == NULL)
						{
						$page_number=0;
					}
					$application_in_tape=12;
					$sql_page_number=$page_number*$application_in_tape;
					$str_out_application_pag="SELECT * FROM `applications` WHERE `status`='Новая' ORDER BY `date_start` DESC LIMIT $sql_page_number, $application_in_tape";
					$run_out_application_pag=mysqli_query($connect, $str_out_application_pag);

		while ($out=mysqli_fetch_array($str_applications_out)) {
			$id=$out['id'];
			echo "<div class=mess_item>
			<div><img src=../$out[рhoto_start]  width=260 height=260></div>
			<div>$out[title]</div>
			<div>$out[description]</div>
			<div>$out[category]</div>
			<div>".date('d/m/Y', $out['date_start'])."</div>
			<div>$out[city]/$out[district]<br>$out[street]/$out[house]</div>
			<a href=?id_success=$out[id]#dark_success name=input><div>Выполнить</div></a>
			</div>";
		}
		?>
		</div>
		<div class="pag_place">
			<?php
			$float_count=$int_out_application%12;
					$int_count=floor($int_out_application/12);
					$p=1;
					if ($float_count>0) 
					{
						$int_count++;
					}
					for ($i=0; $i <$int_count ; $i++) { 
						echo "<a class=pagination href=/?page_number=$i><div>$p</div></a>";
						$p++;
					}
				?>	
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>
