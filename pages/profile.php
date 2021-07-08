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
<div id="dark_edit">
<div id="okno_edit">
<?php
		$str_auth="SELECT * FROM `users` WHERE `login`='$_SESSION[login]'";
		$run_auth=mysqli_query($connect,$str_auth);
		$out_auth=mysqli_fetch_array($run_auth);
		?>
<a href="#">
			<div class="close_btn"></div>
		</a>
		<form method="POST" enctype="multipart/form-data">
<input type="file" name="avatar" class="form_mitem1" id="form_mitem1"><br><br>
<input type="text" name="login_edit" class="form_mitem" placeholder="<?php echo $out_auth['login']?>"><br>
<input type="text" name="name_edit" class="form_mitem" placeholder="<?php echo $out_auth['first_last_name']?>"><br>
<input type="text" name="mail_edit" class="form_mitem" placeholder="<?php echo $out_auth['mail']?>"><br>
<input type="submit" name="save" class="form_mbtn1" value="Сохранить">
</form>
<?php
$str_upd_user="UPDATE `users` SET `avatar`='$avatar',`first_last_name`='$name_edit',`mail`='$mail_edit',`login`='$login_edit'";
if ($save){
$run_upd_user=mysqli_query($connect, $str_upd_user);
echo '<script>location.replace("#")</script>';
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
			<a href=#dark_edit><div class="user_info_change">Изменить профиль</div></a>
		</div>
		<?php
			$str_out_application="SELECT * FROM `applications` WHERE `user`='$_SESSION[login]' ORDER BY `date_start` DESC";
			$run_out_application=mysqli_query($connect,$str_out_application);
			$int_out_application=mysqli_num_rows($run_out_application);
			$page_number=$_GET['page_number'];
						if ($page_number == NULL)
							{
							$page_number=0;
						}
						$application_in_tape=8;
						$sql_page_number=$page_number*$application_in_tape;
						$str_out_application_pag="SELECT * FROM `applications` WHERE `user`='$_SESSION[login]' ORDER BY `date_start` DESC LIMIT $sql_page_number, $application_in_tape";
						$run_out_application_pag=mysqli_query($connect, $str_out_application_pag);
		?>
		<div class="problem_text">Ваши заявки</div>
		<?php
		while ($out=mysqli_fetch_array($run_out_application_pag)){
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
		if ($str_user_del)
		{
			session_destroy();
			echo "<script>location.replace(index.php);</script>";
			exit();
		}
		?>
		<div class="delete_acc">
			<form method=POST>
			<input type=submit name=del_akk value="Удалить профиль">
	</form>
		</div>
		<div class="pag_place">
			<?php
			$float_count=$int_out_application%8;
					$int_count=floor($int_out_application/8);
					$p=1;
					if ($float_count>0) 
					{
						$int_count++;
					}
					for ($i=0; $i <$int_count ; $i++) { 
						echo "<a class=pagination href=?page_number=$i><div>$p</div></a>";
						$p++;
					}
				?>	
		</div>
		<div class="copyright">Copyright</div>
	</div>
</body>
</html>