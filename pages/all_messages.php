<?php
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
<div id=dark_success>
<div id=okno_success>
<form method="POST" enctype="multipart/form-data">
		<input type="file" name="photo_end" class="form_mitem1" id="form_mitem1">
		<input type="submit" name="add" value="Подтвердить">
</form>
<?php
$id_success=$_GET['id_success'];
$photo_end=$_POST['photo_end'];
$status=$_POST['status'];
$time=time();
$add=$_POST['add'];
$file_get= $_FILES['photo_end']['name'];
			$temp= $_FILES['photo_end']['tmp_name'];
			$file_to_saved= "images/".time().$file_get;
				$imageFileType = strtolower(pathinfo($file_to_saved,PATHINFO_EXTENSION));


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
			<div class="logo"></div>
			<a href="admin.php">
				<div class="link_f">О сервисе</div>
			</a>
			<a href="all_messages.php">
				<div class="link_s">Все сообщения</div>
			</a>
			<a href="auth_form.php">
				<div class="auth">Войти</div>
			</a>
		</div>
		<div class="mess_text">Все сообщения</div>
		<div class="all_messages_filter">
			<form>
			<input type="text" name="" class="text_sub" placeholder="Поиск">
			<select class="select">
				<option>Категория</option>
				<?php
				 
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
		while ($out=mysqli_fetch_array($run_out_application_pag)) {
			$id=$out['id'];
			echo "<div class=mess_item>
			<div><img src=../$out[рhoto_start]  width=260 height=260></div>
			<div>$out[title]</div>
			<div>$out[description]</div>0
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
