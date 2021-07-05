<?php
session_start();
$connect=mysqli_connect('localhost','cn31570_practica','practica','cn31570_practica'); 
$exit=$_POST['exit'];
			if ($exit) {
				session_destroy();
				echo '<script>location.replace("/");</script>';
				exit();
			}
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
			<form method=POST><input type=submit name=exit value=Выход class=exit></form>
		</div>
		<?php
		$str_auth="SELECT * FROM `users` WHERE `login`='$_SESSION[login]'";
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
		<?php
		$str_app="SELECT * FROM `applications` WHERE `user`='$_SESSION[login]'";
		$run_app=mysqli_query($connect,$str_app);
		?>
		<div class="problem_text">Ваши заявки</div>
		<?php
		while ($out=mysqli_fetch_array($run_app)){
		echo "<div class=your_p_item>
			<div class=prodlem_item>
				<div><img src=../$out[рhoto_start] width=260 height=260></div>
				<div>$out[title]</div>
				<div>$out[description]</div>
				<div>$out[category]</div>
				<div>".date('d/m/Y', $out['date_start'])."</div>
				<div><a href=>Удалить</a></div>
			</div>
		</div>";
		}
		$del_akk=$_POST['del_akk'];
		if ($del_akk){
		$users_del=$_GET['users'];
		$str_user_del=mysqli_query($connect, "DELETE FROM `users` WHERE `login` = '$_SESSION[login]'");
		}
		?>
		<div class="delete_acc">
			<form method=POST>
			<input type=submit name=del_akk>Удалить профиль
	</form>
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>