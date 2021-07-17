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
<input type="text" name="name_edit" class="form_mitem" placeholder="<?php echo $out_auth['first_last_name']?>"><br>
<input type="text" name="mail_edit" class="form_mitem" placeholder="<?php echo $out_auth['mail']?>"><br>
<input type="submit" name="save" class="form_mbtn1" value="Сохранить">
</form>
<?php
$name_edit=$_POST['name_edit'];
$mail_edit=$_POST['mail_edit'];
$save=$_POST['save'];
$file_get= $_FILES['avatar']['name'];
			$temp= $_FILES['avatar']['tmp_name'];
			$file_to_saved= "../images/".time().$file_get;
				$imageFileType = 
strtolower(pathinfo($file_to_saved,PATHINFO_EXTENSION));

if ($save){
if ($name_edit){
$str_upd_user="UPDATE `users` SET `first_last_name`='$name_edit' WHERE `login`='$_SESSION[login]'";
}
elseif ($mail_edit)
{
	$str_upd_user="UPDATE `users` SET `mail`='$mail_edit' WHERE `login`='$_SESSION[login]'";
}
elseif ($_FILES)
{
	$str_upd_user="UPDATE `users` SET `avatar`='$file_to_saved' WHERE `login`='$_SESSION[login]'";
	move_uploaded_file($temp, $file_to_saved);
}
elseif ($name_edit && $mail_edit && $_FILES)
{
	$str_upd_user="UPDATE `users` SET `avatar`='$file_to_saved',`first_last_name`='$name_edit',`mail`='$mail_edit' WHERE `login`='$_SESSION[login]'";
	move_uploaded_file($temp, $file_to_saved);
}
elseif ($name_edit && $mail_edit)
{
	$str_upd_user="UPDATE `users` SET `first_last_name`='$name_edit',`mail`='$mail_edit' WHERE `login`='$_SESSION[login]'";
}
elseif ($mail_edit && $_FILES)
{
	$str_upd_user="UPDATE `users` SET `avatar`='$file_to_saved',`mail`='$mail_edit' WHERE `login`='$_SESSION[login]'";
	move_uploaded_file($temp, $file_to_saved);
}
elseif ($name_edit && $_FILES)
{
	$str_upd_user="UPDATE `users` SET `avatar`='$file_to_saved',`first_last_name`='$name_edit' WHERE `login`='$_SESSION[login]'";
	move_uploaded_file($temp, $file_to_saved);
}
else
{

}
if($imageFileType != "jpg" && $imageFileType != "jpeg") {
	echo "Только файлы jpg и jpeg";
}
else
{

$run_upd_user=mysqli_query($connect, $str_upd_user);
if ($run_upd_user){
echo '<script>location.replace("#")</script>';
}
}
}
?>
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

echo '<script>location.replace("#");</script>'; exit();

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
		<?php echo "<div class=avatar_img><img src=../$out_auth[avatar] width=200 height=200></div>"?>
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
						$str_out_application_pag="SELECT * FROM `applications` WHERE `user`='$_SESSION[login]' AND `status`='Новая' ORDER BY `date_start` DESC LIMIT $sql_page_number, $application_in_tape";
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
				<div><a href=?id_del_app=$out[id]>Отменой</a></div>
				<a href=all_messages.php?id_success=$out[id]#dark_success name=input><div>Выполнить</div></a>
			</div>
		</div>";
		}
		$str_upd_application="UPDATE `applications` SET `status`='Отменено', `date_end`='$time' WHERE `id`='$id_del_app'";
		$run_str_upd_application=mysqli_query($connect, $str_upd_application);
		
		?>
		<div class="delete_acc">
			<form method=POST>
			<input type=submit name=del_akk value="Удалить профиль">
	</form>
		</div>
		<?php
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